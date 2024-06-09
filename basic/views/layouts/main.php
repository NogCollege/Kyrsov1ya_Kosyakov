<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\bootstrap5\BootstrapAsset;

BootstrapAsset::register($this);
AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<!--<header id="header">

</header>-->
<div class="nav-menu">
    <ul class="menu">
        <div class="logo">
            <li><h1>Картошка от Антошки</h1></li>
        </div>
        <div class="knopki no-vid" >
            <li> Меню </li>
            <li> Купоны и Акции</li>
            <li>Контакты</li>
            <li>О компании</li>
            <div class="nomer no-vid">
                <li><?= '7 (499) 110-20-47' ?></li>
                <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->hasRole('admin')): ?>
                    <li><?= Html::a('Админ', ['/site/admin']) ?></li>
                <?php endif; ?>
                <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->hasRole('courier')): ?>
                    <li><?= Html::a('Админ', ['/site/courier']) ?></li>
                <?php endif; ?>
            </div>

            <img>
            <div class="korzina">
                <li><?= Html::a(Html::img('/../web/img/free-icon-shopping-cart-711897%20(2).png', ['alt' => 'your image']), ['/site/cart']) ?></li>
                <?php if (!Yii::$app->user->isGuest): ?>
                    <li><?= Html::a(Html::img('/../web/img/free-icon-login-6681204.png', ['alt' => 'your image']), ['/site/profile']) ?></li>
                    <li><?= Html::a(Html::img('/../web/img/free-icon-exit-603018.png', ['data-method' => 'post']), ['/site/logout']) ?></li>
                <?php else: ?>
                    <li><?= Html::a(Html::img('/../web/img/free-icon-login-6681204.png', ['alt' => 'your image']), ['/site/login']) ?></li>
                <?php endif; ?>
            </div>

    </ul>
</div>
    <div >
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>
<footer class="main-footer">

    <div class="container">
        <address class="footer-address">
            <h2>Картошка у Антошки</h2><br>
            Адрес: 446587, Московская область, город Ногинск, ул Бухарестская, 11 <br>
            Телефон: <a href="tel:7 (499) 110-20-47">7 (499) 110-20-47</a>
        </address>

        <div class="footer-social">
            <b>Соцсети!</b>
            <ul>
                <li>
                    <a class="social-button" href="#">
                        <span class="visually-hidden">Вконтакте</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="27" height="15" viewbox="0 0 26.14 14.91">
                            <path d="M26 13.47l-.09-.17a13.55 13.55 0 0 0-2.6-3q-.87-.83-1.1-1.12A1 1 0 0 1 22 8a10.27 10.27 0 0 1 1.22-1.78l.88-1.16q2.35-3.13 2-4L26 .94a.8.8 0 0 0-.4-.22 2.14 2.14 0 0 0-.87 0h-3.92a.51.51 0 0 0-.27 0h-.3a.6.6 0 0 0-.15.14.93.93 0 0 0-.14.24 22.22 22.22 0 0 1-1.46 3.06q-.5.84-.93 1.46a7 7 0 0 1-.71.91 4.94 4.94 0 0 1-.52.47q-.23.18-.35.15l-.23-.05a.9.9 0 0 1-.31-.33 1.49 1.49 0 0 1-.16-.53V1.6a3.14 3.14 0 0 0 0-.62 2.12 2.12 0 0 0-.14-.44.73.73 0 0 0-.28-.33 1.57 1.57 0 0 0-.46-.18A9 9 0 0 0 12.57 0a8.93 8.93 0 0 0-3.25.33 1.83 1.83 0 0 0-.52.41q-.25.3-.07.33a1.67 1.67 0 0 1 1.16.59l.08.16a2.6 2.6 0 0 1 .19.63 6.32 6.32 0 0 1 .12 1 10.59 10.59 0 0 1 0 1.7q-.07.71-.13 1.1a2.21 2.21 0 0 1-.18.64 2.69 2.69 0 0 1-.16.3l-.07.07a1 1 0 0 1-.37.07.86.86 0 0 1-.46-.19 3.27 3.27 0 0 1-.56-.52 7 7 0 0 1-.66-.93q-.37-.6-.76-1.42l-.22-.39q-.2-.38-.56-1.11t-.62-1.43A.9.9 0 0 0 5.2.9h-.07a.93.93 0 0 0-.22-.16A1.44 1.44 0 0 0 4.6.65L.87.68A1 1 0 0 0 .1.94L0 1a.44.44 0 0 0 0 .22 1.08 1.08 0 0 0 .08.37Q.9 3.53 1.86 5.31t1.66 2.87Q4.23 9.27 5 10.24t1 1.24l.37.41.34.33a8.06 8.06 0 0 0 1 .78 16.34 16.34 0 0 0 1.4.9 7.6 7.6 0 0 0 1.79.72 6.19 6.19 0 0 0 2 .22h1.57a1.08 1.08 0 0 0 .72-.3l.05-.07a.9.9 0 0 0 .1-.25 1.38 1.38 0 0 0 0-.37 4.48 4.48 0 0 1 .09-1.05 2.77 2.77 0 0 1 .23-.71 1.74 1.74 0 0 1 .29-.4 1.19 1.19 0 0 1 .23-.2h.11a.86.86 0 0 1 .77.21 4.52 4.52 0 0 1 .83.79q.39.47.93 1.05a6.41 6.41 0 0 0 1 .87l.27.16a3.31 3.31 0 0 0 .71.3 1.53 1.53 0 0 0 .76.07l3.48-.05a1.58 1.58 0 0 0 .8-.17.68.68 0 0 0 .34-.37 1.06 1.06 0 0 0 0-.46 1.71 1.71 0 0 0-.1-.36z"
                                  fill="#fff" /></svg>
                    </a>
                </li>
                <li>
                    <a class="social-button" href="#">
                        <span class="visually-hidden">Фейсбук</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="22" viewbox="0 0 10.15 21.74">
                            <path d="M3.34 1.12A4.77 4.77 0 0 1 6.53 0h3.61v3.81H7.81a1.07 1.07 0 0 0-1.09.83v2.55h3.42c-.08 1.23-.24 2.45-.41 3.67h-3v10.87H2.21V10.86H0V7.21h2.19V3.66a3.83 3.83 0 0 1 1.15-2.54z"
                                  fill="#fff" /></svg>
                    </a>
                </li>
                <li>
                    <a class="social-button" href="#">
                        <span class="visually-hidden">Инстаграм</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewbox="0 0 20 20">
                            <path d="M18 0H2a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm-8 6a4 4 0 1 1-4 4 4 4 0 0 1 4-4zM2.5 18a.47.47 0 0 1-.5-.5V9h2.1a3.4 3.4 0 0 0-.1 1 6 6 0 1 0 12 0 3.4 3.4 0 0 0-.1-1H18v8.5a.47.47 0 0 1-.5.5zM18 4.5a.47.47 0 0 1-.5.5h-2a.47.47 0 0 1-.5-.5v-2a.47.47 0 0 1 .5-.5h2a.47.47 0 0 1 .5.5z"
                                  fill="#fff" /></svg>
                    </a>
                </li>
            </ul>
        </div>

        <div class="footer-copyright">
            <p>© 2021 Картошка у Антошки. Все права защищены. Мы рады предложить вам свежую и вкусную картошку, выращенную с любовью и заботой. Заказывайте у нас и наслаждайтесь натуральными продуктами! Благодарим за вашу поддержку<p>
        </div>
    </div>

</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
