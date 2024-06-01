<?php

use yii\helpers\Html;

$this->title = 'Статус заказа';
?>

<p>Статус заказа:
    <?php
    switch ($order->status) {
        case Order::STATUS_CREATED:
            echo 'Оформлен';
            break;
        case Order::STATUS_ACCEPTED:
            echo 'Принят';
            break;
        case Order::STATUS_DELIVERED:
            echo 'Доставляется';
            break;
        case Order::STATUS_COMPLETED:
            echo 'Завершен';
            break;
        default:
            echo 'Неизвестный';
            break;
    }
    ?>
</p>
