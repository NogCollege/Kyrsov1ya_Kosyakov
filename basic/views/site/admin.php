<?php

use yii\helpers\Html;

$this->title = 'Admin Page';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-admin">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Welcome to the admin page. Only administrators can access this page.</p>
</div>