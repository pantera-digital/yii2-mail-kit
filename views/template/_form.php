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
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'from')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'content_type')->dropDownList($model->getContentTypeList(), [
                'prompt' => '',
            ]) ?>

            <?= $form->field($model, 'layout_id')->dropDownList(MailTemplate::getList(), [
                'prompt' => '',
            ]) ?>
        </div>
        <div class="col-md-9">
            <?= $form->field($model, 'template')->hiddenInput() ?>
            <div id="mail-template-editor-container" class="form-group">
                <div id="mail-template-editor"></div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('mail', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
