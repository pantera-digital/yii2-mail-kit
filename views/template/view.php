<?php

use pantera\mail\models\MailTemplate;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model pantera\mail\models\MailTemplate */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('mail', 'Mail Templates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mail-template-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('mail', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('mail', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'alias',
            'template:ntext',
            'from',
            'subject',
            [
                'attribute' => 'content_type',
                'value' => function (MailTemplate $model) {
                    return $model->getCurrentContentType();
                },
            ],
            [
                'attribute' => 'layout_id',
                'value' => function (MailTemplate $model) {
                    return $model->layout ? $model->layout->name : '';
                },
            ],
        ],
    ]) ?>

</div>
