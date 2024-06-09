<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

$this->title = 'Admin Panel';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="admin-panel">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if ($action === 'admin'): ?>
        <p>
            <?= Html::a('Создать товар', ['create-product'], ['class' => 'btn btn-success']) ?>
            <?= Html::a('Создать промокод', ['create-promo'], ['class' => 'btn btn-success']) ?>
            <?= Html::a('Создать акцию', ['create-promotion'], ['class' => 'btn btn-success']) ?>
            <?= Html::a('Управление акциями', ['promotion-index'], ['class' => 'btn btn-primary']) ?>
        </p>

        <?= GridView::widget([
            'dataProvider' => $productDataProvider,
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

        <?= Html::a('Управление промокодами', ['promo-index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Управление пользователями', ['user-index'], ['class' => 'btn btn-primary']) ?>

    <?php elseif ($action === 'create' || $action === 'update'): ?>
        <div class="tovar-form">
            <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'image_url')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'name')->textarea(['rows' => 6]) ?>
            <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'ves')->textInput() ?>
            <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'cat')->dropDownList([
                'салат' => 'Салат',
                'напитки' => 'Напитки',
                'картошка' => 'Картошка',
                'гарниры' => 'Гарниры',
                'закуски' => 'Закуски',
                'супы' => 'Супы',
            ], ['prompt' => 'Select Category']) ?>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    <?php elseif ($action === 'promo'): ?>
        <p>
            <?= Html::a('Создать промокод', ['create-promo'], ['class' => 'btn btn-success']) ?>
        </p>

        <?= GridView::widget([
            'dataProvider' => $promoDataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'id',
                'code',
                'discount',
                'active:boolean',
                'created_at:datetime',
                'updated_at:datetime',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update} {delete}',
                    'buttons' => [
                        'update' => function ($url, $model, $key) {
                            return Html::a('Update', ['update-promo', 'id' => $model->id]);
                        },
                        'delete' => function ($url, $model, $key) {
                            return Html::a('Delete', ['delete-promo', 'id' => $model->id], [
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

    <?php elseif ($action === 'createPromo' || $action === 'updatePromo'): ?>
        <div class="promo-form">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'discount')->textInput() ?>
            <?= $form->field($model, 'active')->checkbox() ?>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>

    <?php elseif ($action === 'promotion'): ?>
        <p>
            <?= Html::a('Создать акцию', ['create-promotion'], ['class' => 'btn btn-success']) ?>
        </p>

        <?= GridView::widget([
            'dataProvider' => $promotionDataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'id',
                'name',
                'description:ntext',
                'image_url',
                'start_date:date',
                'end_date:date',
                'price',
                [
                    'attribute' => 'promotion_type',
                    'value' => function ($model) {
                        return $model->promotion_type === 'weekly' ? 'Weekly' : 'Daily';
                    },
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update} {delete}',
                    'buttons' => [
                        'update' => function ($url, $model, $key) {
                            return Html::a('Update', ['update-promotion', 'id' => $model->id]);
                        },
                        'delete' => function ($url, $model, $key) {
                            return Html::a('Delete', ['delete-promotion', 'id' => $model->id], [
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

    <?php elseif ($action === 'createPromotion' || $action === 'updatePromotion'): ?>
        <div class="promotion-form">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
            <?= $form->field($model, 'image_url')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'start_date')->textInput(['type' => 'date']) ?>
            <?= $form->field($model, 'end_date')->textInput(['type' => 'date']) ?>
            <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'promotion_type')->dropDownList([
                'weekly' => 'Weekly',
                'daily' => 'Daily',
            ], ['prompt' => 'Select Promotion Type']) ?>
            <?= $form->field($model, 'cat')->dropDownList([
                'салат' => 'Салат',
                'напитки' => 'Напитки',
                'картошка' => 'Картошка',
                'гарниры' => 'Гарниры',
                'закуски' => 'Закуски',
                'супы' => 'Супы',
            ], ['prompt' => 'Select Category']) ?>


            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    <?php elseif ($action === 'user'): ?>
        <p>
            <?= Html::a('Create User', ['create-user'], ['class' => 'btn btn-success']) ?>
        </p>

        <?= GridView::widget([
            'dataProvider' => $userDataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'id',
                'username',
                'email:email',
                'role',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update} {delete}',
                    'buttons' => [
                        'update' => function ($url, $model, $key) {
                            return Html::a('Update', ['update-user', 'id' => $model->id]);
                        },
                        'delete' => function ($url, $model, $key) {
                            return Html::a('Delete', ['delete-user', 'id' => $model->id], [
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

    <?php elseif ($action === 'createUser'): ?>
        <div class="user-form">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'role')->dropDownList(['admin' => 'Admin', 'user' => 'User','courier' => 'courier']) ?>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>

    <?php elseif ($action === 'updateUser'): ?>
        <div class="user-form">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'role')->dropDownList(['admin' => 'Admin', 'user' => 'User','courier' => 'courier']) ?>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>

    <?php endif; ?>
</div>

