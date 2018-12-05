<?php

use pantera\mail\models\MailTemplate;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model pantera\mail\models\MailTemplate */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mail-template-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'template')->textarea(['rows' => 12]) ?>

    <?= $form->field($model, 'from')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content_type')->dropDownList($model->getContentTypeList(), [
        'prompt' => '',
    ]) ?>

    <?= $form->field($model, 'layout_id')->dropDownList(MailTemplate::getList(), [
        'prompt' => '',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('mail', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
