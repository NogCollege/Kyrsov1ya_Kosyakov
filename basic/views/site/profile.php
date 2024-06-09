<?php

use yii\helpers\Html;

$this->title = 'Мой профиль';
?>

<h1><?= Html::encode($this->title) ?></h1>

<table class="table">
    <thead>
    <tr>
        <th>Имя пользователя</th>
        <th>Email</th>
        <!-- Добавьте другие необходимые заголовки столбцов -->
    </tr>
    </thead>
    <tbody>
    <tr>
        <td><?= htmlspecialchars($user->username) ?></td>
        <td><?= htmlspecialchars($user->email) ?></td>
        <!-- Добавьте другие необходимые ячейки данных -->
    </tr>
    </tbody>
</table>
<?php if (!empty($orders)): ?>
    <h2>Мои заказы:</h2>
    <ul>
        <?php foreach ($orders as $order): ?>
            <li>
                <?= Html::encode($order->id) ?>:
                <?= Html::encode($order->customer_name) ?>,
                <?= Html::encode($order->address) ?>,
                <?= Html::encode($order->created_at) ?>
                <ul>
                    <?php foreach ($order->orderItems as $item): ?>
                        <li>
                            <?= Html::encode($item->product_name) ?>,
                            <?= Html::encode($item->product_price) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>У вас пока нет заказов.</p>
<?php endif; ?>
