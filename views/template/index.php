<?php

use pantera\mail\models\MailTemplate;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel pantera\mail\models\MailTemplateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('mail', 'Mail Templates');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mail-template-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>

    <p>
        <?= Html::a(Yii::t('mail', 'Create'), ['create'], [
            'class' => 'btn btn-success',
            'data' => [
                'pjax' => 0,
            ],
        ]) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'name',
            'alias',
            'from',
            'subject',
            [
                'attribute' => 'content_type',
                'value' => function (MailTemplate $model) {
                    return $model->getCurrentContentType();
                },
                'filter' => Html::activeDropDownList($searchModel, 'content_type', $searchModel->getContentTypeList(), [
                    'prompt' => '',
                    'class' => 'form-control',
                ]),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}',
                'urlCreator' => function (string $action, MailTemplate $model) {
                    return [$action, 'alias' => $model->alias];
                }
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
