<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model pantera\mail\models\MailTemplate */

$this->title = Yii::t('mail', 'Create');
$this->params['breadcrumbs'][] = ['label' => Yii::t('mail', 'Mail Templates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mail-template-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
