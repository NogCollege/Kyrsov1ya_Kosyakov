<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin(); ?>

<?= $form->field($order, 'customer_name')->textInput() ?>
<?= $form->field($order, 'customer_email')->textInput() ?>
<?= $form->field($order, 'promocode')->textInput() ?>
<?= $form->field($order, 'delivery_method')->dropDownList(['address' => 'Доставка по адресу', 'pickup' => 'Самовывоз']) ?>

<div class="form-group">
    <?= Html::submitButton('Оформить заказ', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
