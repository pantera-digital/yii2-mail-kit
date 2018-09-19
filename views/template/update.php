<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model pantera\mail\models\MailTemplate */

$this->title = 'Update Mail Template: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Mail Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mail-template-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
