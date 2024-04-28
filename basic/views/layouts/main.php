<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

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
<header>
    <div class="nav-menu">
        <ul class="menu">
            <div class="logo">
                <li><h1>Картошка от Антошки</h1></li>
            </div>
            <div class="knopki no-vid" >
                <li>Меню</li>
                <li>Купоны и Акции</li>
                <li>Контакты</li>
                <li>О компании</li>
            </div>
            <div class="nomer no-vid">
                <li>7 (499) 110-20-47</li>
            </div>
            <div class="korzina">
                <li><a href=''><img src="/../web/img/free-icon-shopping-cart-711897%20(2).png" alt=""></a></li>
                <li><a href='/../views/site/login.php'><img src="/../web/img/free-icon-login-6681204.png"></a></li>
            </div>
        </ul>
    </div>
</header>
<section class="promo">
    <div class="text container">
        <h1>Свежая и вкусная еда
            Для вашего здоровья</h1>
        <a href="#" class="btn">Посмотреть меню</a>
    </div>
    div>
    <ul class=" cifirki container">
        <li >
            <div class="b">
                <p>Большой выбор <br>
                   блюд в ресторане</p>
            </div>
        </li>
        <li>
            <div class="b">
                <p>Доставка еды <br>
                    до вашей двери</p>
            </div>
        </li>
        <li>
            <div class="b">
                <p>Скидки постоянным <br>
                    клиентам</p>
            </div>
        </li>
        <li>
            <div class="b">
                <p>Любая форма <br>
                    оплаты</p>
            </div>
        </li>
        <li>
            <div class="b">
                <p>Выгодные цены</p>
            </div>
        </li>
    </ul>
    </div>
</section>
<section class="premium container">
    <h1 class="container">Заказ блюд на мероприятия</h1>
    <div class="arenda">
        <div class="bl1">
            <img src="/../web/img/chto_prigotovit_na_svadbu_letom_1.jpg" alt="">
            <h2>собственное меню на свадьбу</h2>
            <p> <span class="greyy">Предоставляем специальное меню для вашего праздника</span></p>
        </div>
        <div class="bl1">
            <img src="/../web/img/2_menu_na_dp_letom-1.jpg" alt="">
            <h2>Специальное меню на день рождение</h2>
            <p><span class="greyy"> Предоставляем специальное меню и аниматоров для вашего праздника</span></p>
        </div>
    </div>
</section>
<section class="avtopark container">
    <div class="textov">
        <h1>Наше меню</h1>
        <button class="smtr">Смотреть все</button>
    </div>
    <div class="tri container">
        <ul class="catalog">
            <li>
                <button class="button-cat svet" data-category="suv">
                    <p>Салаты</p>
                </button>
            </li>
            <li >
                <button class="button-cat svet s1" data-category="business">
                    <p>Закуски</p>
                </button>
            </li>
            <li>
                <button class="button-cat svet s1" data-category="premium">
                    <p>Гарниры</p>
                </button>
            </li>
            <li>
                <button class="button-cat svet s1" data-category="sport">
                    <p>Супы</p>
                </button>
            </li>
            <li>
                <button class="button-cat svet s1" data-category="premium">
                    <p>Десерты</p>
                </button>
            </li>
            <li>
                <button class="button-cat svet s1" data-category="comfort">
                    <p>Напитки</p>
                </button>
            </li>
        </ul>
    </div>
<!--    --><?php
//    require_once ("controllers/connect.php");
//
//    $query = "SELECT * FROM catalogg";
//
//    $result = mysqli_query($link, $query) or die(mysqli_error($link));
//
//    for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
//
//    echo '<div class = "katalog container">
//    <ul class="katal">';
//    foreach ($data as $elem){
//        $result = '';
//        $result .= '
//        <li class="vis-biba '.$elem['categoria'] .'">
//        <div class="img-kat">
//        <img src="templates/img/photos/'.$elem['id'].'-'.$elem['nazvan']  .'/main.jpg" alt="">
//        </div>';
//        $result .= ' <h4>'. $elem['fullname'] . ', '. $elem['god'] . '</h4>';
//        $result .= '<div class="text-s2">
//            <p> <img src="templates/img/Vector (8).png" alt="">'. $elem['volume'] . ',' . $elem['Dvigatel'] . '</p>
//            <p class="pa"> <img src="templates/img/Vector (9).png" alt="">'. $elem['loshadki'] .'</p>
//        </div>';
//        $result .= '<hr size="1px">';
//        $result .= '<div class="cen">
//        <a href="fullopis.php?id='.$elem['id'].'"> <button>Забронировать</button></a><p>от <span>'.$elem['mid'].'</span>руб/сут.</p>
//        </div>';
//        $result .= '</li>';
//
//        echo $result;
//    }
//    echo '</ul></div>';
//
//    ?>
</section>
<section class="informatiom">
    <di>
        <img>
    </div>

</section>
<!--<main id="main" class="flex-shrink-0" role="main">
    <div class="container">
        <?php /*if (!empty($this->params['breadcrumbs'])): */?>
            <?php /*= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) */?>
        <?php /*endif */?>
        <?php /*= Alert::widget() */?>
        <?php /*= $content */?>
    </div>
</main>-->



<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
