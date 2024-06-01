<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Корзина';
?>


<h1><?= Html::encode($this->title) ?></h1>

<?php if (empty($cart->getItems())): ?>
    <p>Ваша корзина пуста</p>
<?php else: ?>
    <table>
        <thead>
        <tr>
            <th>Изображение</th>
            <th>Название</th>
            <th>Цена</th>
            <th>Количество</th>
            <th>Сумма</th>
            <th>Действие</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($cart->getItems() as $item): ?>
            <tr>
                <td><img src="<?= Html::encode($item['image_url']) ?>" alt="" style="width: 50px;"></td>
                <td><?= Html::encode($item['name']) ?></td>
                <td><?= Html::encode($item['price']) ?></td>
                <td>
                    <form method="post" action="<?= Url::to(['site/update-cart']) ?>">
                        <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
                        <input type="hidden" name="id" value="<?= Html::encode($item['id']) ?>">
                        <input type="number" name="quantity" value="<?= Html::encode($item['quantity']) ?>" min="1">
                        <button type="submit">Изменить</button>
                    </form>
                </td>
                <td><?= Html::encode($item['price'] * $item['quantity']) ?></td>
                <td>
                    <a href="<?= Url::to(['site/remove-from-cart', 'id' => $item['id']]) ?>">Удалить</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <p>Общая сумма: <?= Html::encode($cart->getTotal()) ?></p>

    <div>
        <a href="<?= Url::to(['site/checkout']) ?>" class="btn btn-primary">Оформить заказ</a>
    </div>
<?php endif; ?>


