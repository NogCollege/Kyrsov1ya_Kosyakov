<?php

use yii\helpers\Html;

$this->title = 'Мой профиль';
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php if (!empty($orders)): ?>
    <h2>Мои заказы:</h2>
    <ul>
        <?php foreach ($orders as $order): ?>
            <li>
                Заказ №<?= $order->id ?><br>
                Имя заказчика: <?= Html::encode($order->customer_name) ?><br>
                Электронная почта: <?= Html::encode($order->customer_email) ?><br>
                Адрес доставки: <?= Html::encode($order->address) ?><br>
                Статус заказа: <?= Html::encode($order->status) ?><br>
                <!-- Добавьте другие необходимые данные о заказе -->
            </li>
            <hr>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>У вас пока нет заказов.</p>
<?php endif; ?>
