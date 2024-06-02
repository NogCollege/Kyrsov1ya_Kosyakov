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

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'promo_code')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'delivery')->dropDownList(['address' => 'Доставка по адресу', 'pickup' => 'Самовывоз']) ?>

<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

<div class="form-group">
    <?= Html::submitButton('Оформить заказ', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
