<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Корзина';
?>


<h1><?= Html::encode($this->title) ?></h1>

<?php if (empty($cart)): ?>
    <p>Ваша корзина пуста.</p>
<?php else: ?>
    <table>
        <thead>
        <tr>
            <th>Изображение</th>
            <th>Название</th>
            <th>Цена</th>
            <th>Количество</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($cart as $item): ?>
            <tr>
                <td><img src="<?= $item['image_url'] ?>" alt="" style="width: 50px;"></td>
                <td><?= Html::encode($item['name']) ?></td>
                <td><?= Html::encode($item['price']) ?></td>
                <td><?= Html::encode($item['quantity']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>


