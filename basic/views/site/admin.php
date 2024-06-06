<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

$this->title = 'Admin Panel';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="admin-panel">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= Html::a('Добавить товар', ['create-product'], ['class' => 'btn btn-success']) ?>
    <?= Html::a('Добавить промокод', ['create-promocode'], ['class' => 'btn btn-success']) ?>

    <?php if ($action === 'create-product' || $action === 'update-product'): ?>
        <div class="product-form">
            <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'image_url')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'name')->textarea(['rows' => 6]) ?>
            <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'ves')->textInput() ?>
            <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'cat')->dropDownList([
                'салаты' => 'Салаты',
                'напитки' => 'Напитки',
                'картошка' => 'картошка',
                'гарниры' => 'гарниры',
                'закуски'=>'закуски',
                'супы'=>'супы',
            ], ['prompt' => 'Select Category']) ?>
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    <?php elseif ($action === 'create-promocode' || $action === 'update-promocode'): ?>
        <div class="promocode-form">
            <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'discount')->textInput() ?>
            <?= $form->field($model, 'active')->checkbox() ?>
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    <?php else: ?>
        <h2>Products</h2>
        <?= GridView::widget([
            'dataProvider' => $dataProviderProducts,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'id',
                'name',
                'price',
                'description',
                'image_url',
                'cat',
                'ves',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update} {delete}',
                    'buttons' => [
                        'update' => function ($url, $model, $key) {
                            return Html::a('Update', ['update-product', 'id' => $model->id]);
                        },
                        'delete' => function ($url, $model, $key) {
                            return Html::a('Delete', ['delete-product', 'id' => $model->id], [
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this item?',
                                    'method' => 'post',
                                ],
                            ]);
                        },
                    ],
                ],
            ],
        ]); ?>

        <h2>Promo Codes</h2>
        <?= GridView::widget([
            'dataProvider' => $dataProviderPromoCodes,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'id',
                'code',
                'discount',
                'active',
                'created_at',
                'updated_at',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update} {delete}',
                    'buttons' => [
                        'update' => function ($url, $model, $key) {
                            return Html::a('Update', ['update-promocode', 'id' => $model->id]);
                        },
                        'delete' => function ($url, $model, $key) {
                            return Html::a('Delete', ['delete-promocode', 'id' => $model->id], [
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this item?',
                                    'method' => 'post',
                                ],
                            ]);
                        },
                    ],
                ],
            ],
        ]); ?>
    <?php endif; ?>
</div>
