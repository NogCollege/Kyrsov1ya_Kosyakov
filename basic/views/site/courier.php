<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Страница курьера';
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php foreach ($orders as $order): ?>
    <div class="order-item">
        <p>ID заказа: <?= $order->id ?></p>
        <p>Статус: <?= $order->status ?></p>
        <?php if ($order->status !== 'доставлен'): ?>
            <?php $form = ActiveForm::begin(['action' => ['update-status', 'orderId' => $order->id], 'method' => 'post']) ?>
            <?= Html::submitButton('Отметить как доставленный', ['class' => 'btn btn-primary']) ?>
            <?php ActiveForm::end() ?>
        <?php endif ?>
    </div>
<?php endforeach ?>
