<?php

namespace pantera\mail\controllers;

use pantera\mail\models\MailTemplate;
use pantera\mail\models\MailTemplateSearch;
use pantera\mail\Module;
use Yii;
use yii\filters\AccessControl;
use yii\filters\AjaxFilter;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * TemplateController implements the CRUD actions for MailTemplate model.
 */
class TemplateController extends Controller
{
    /* @var Module */
    public $module;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => $this->module->permissions,
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'preview' => ['POST'],
                ],
            ],
            'ajax' => [
                'class' => AjaxFilter::class,
                'only' => ['preview'],
            ],
        ];
    }

    public function actionPreview()
    {
        $model = new MailTemplate();
        $model->load(Yii::$app->request->post());
        /** @noinspection MissedViewInspection */
        return Yii::$app->mailer->renderTemplate($model, $model->data ? Json::decode($model->data) : []);
    }

    /**
     * Lists all MailTemplate models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MailTemplateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        /** @noinspection MissedViewInspection */
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new MailTemplate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MailTemplate();
        $model->loadDefaultValues();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('mail', '{NAME} saved', [
                'NAME' => $model->name,
            ]));
            if (Yii::$app->request->post('action') === 'apply') {
                return $this->redirect(['update', 'alias' => $model->alias]);
            }
            return $this->redirect(['index']);
        }
        /** @noinspection MissedViewInspection */
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MailTemplate model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $alias
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($alias)
    {
        $model = $this->findModel($alias);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('mail', '{NAME} saved', [
                'NAME' => $model->name,
            ]));
            if (Yii::$app->request->post('action') === 'apply') {
                return $this->redirect(['update', 'alias' => $model->alias]);
            }
            return $this->redirect(['index']);
        }
        /** @noinspection MissedViewInspection */
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @param string $alias
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete(string $alias)
    {
        $model = $this->findModel($alias);
        $usedAsLayout = MailTemplate::find()
            ->andWhere(['=', 'layout_id', $model->id])
            ->count();
        if (!$usedAsLayout || Yii::$app->request->post('force')) {
            $model->delete();
            $result = [
                'status' => true,
            ];
        } else {
            $result = [
                'status' => false,
                'message' => Yii::t('mail', 'Used as layout in other letters.<br>Anyway delete?'),
                'swalConfig' => [
                    'confirmButtonText' => Yii::t('mail', 'Yes'),
                    'cancelButtonText' => Yii::t('mail', 'No'),
                ],
            ];
        }
        return $this->asJson($result);
    }

    /**
     * @param string $alias
     * @return MailTemplate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(string $alias)
    {
        $model = MailTemplate::find()
            ->andWhere(['=', 'alias', $alias])
            ->one();
        if ($model) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
