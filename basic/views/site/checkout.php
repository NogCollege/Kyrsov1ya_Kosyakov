<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Оформление заказа';
?>

    <h1><?= Html::encode($this->title) ?></h1>

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success">
        <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="alert alert-danger">
        <?= Yii::$app->session->getFlash('error') ?>
    </div>
<?php endif; ?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'customer_name')->textInput(['maxlength' => true])->label('Имя заказчика') ?>
<?= $form->field($model, 'customer_email')->textInput(['maxlength' => true])->label('Электронная почта') ?>
<?= $form->field($model, 'address')->textInput(['maxlength' => true])->label('Адрес') ?>
<?= $form->field($model, 'promocode')->textInput(['maxlength' => true])->label('Промокод') ?>
<?= $form->field($model, 'delivery_method')->dropDownList(['address' => 'Доставка по адресу', 'pickup' => 'Самовывоз'])->label('Тип доставки') ?>
<?= $form->field($model, 'phone_number')->textInput(['maxlength' => true])->label('Номер телефона') ?>
<?= Html::errorSummary($model, ['class' => 'alert alert-danger']); ?>
<div class="form-group">
    <?= Html::submitButton('Оформить заказ', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

