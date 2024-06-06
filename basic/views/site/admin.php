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
            <?= Html::a('Создать товар', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
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
                            return Html::a('Update', ['updatee', 'id' => $model->id]);
                        },
                        'delete' => function ($url, $model, $key) {
                            return Html::a('Delete', ['delete', 'id' => $model->id], [
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
    <?php elseif ($action === 'create' || $action === 'updatee'): ?>
        <div class="tovar-form">
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
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Updatee', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    <?php endif; ?>
</div>