<?php


/** @var yii\web\View $this */
use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\Url;

$this->title = 'Картошка от Антошки';

?>

<section class="promo">
    <div class="text container">
        <h1>Свежая и вкусная еда
            Для вашего здоровья</h1>
        <a href="#" class="btn">Посмотреть меню</a>
    </div>
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
<section id="menu" class="avtopark container">
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
    <?php
    $pdo = new PDO('mysql:host=localhost;dbname=yii2basic', 'root', '');

    // Получение данных о товарах из базы
    $statement = $pdo->query('SELECT * FROM TOVAR');
    $tovars = $statement->fetchAll(PDO::FETCH_ASSOC);

    ?>


    <div class="katalog container">
        <ul class="katal">
            <?php foreach ($tovars as $tovar): ?>
                <li class="vis-biba">
                    <div class="img-kat">
                        <img src="<?= Html::encode($tovar['image_url']) ?>" alt="">
                    </div>
                    <h4><?= Html::encode($tovar['name']) ?></h4>
                    <div class="text-s2">
                        <p class="pa"><img src="/../web/img/weigh.jpg" alt=""> Вес: <?= Html::encode($tovar['ves']) ?></p>
                    </div>
                    <p class="description"><?= Html::encode($tovar['description']) ?></p>
                    <div class="cen">
                        <p>Цена: <?= Html::encode($tovar['price']) ?></p>
                        <form method="post" action="<?= Url::to(['site/add-to-cart']) ?>">
                            <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
                            <input type="hidden" name="id" value="<?= Html::encode($tovar['id']) ?>">
                            <input type="hidden" name="name" value="<?= Html::encode($tovar['name']) ?>">
                            <input type="hidden" name="price" value="<?= Html::encode($tovar['price']) ?>">
                            <input type="hidden" name="image_url" value="<?= Html::encode($tovar['image_url']) ?>">
                            <button type="submit">заказать</button>
                        </form>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<div id="onas" class="about_area">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-6 col-lg-6 col-md-6">
                <div class="about_thumb2">
                    <div class="img_1">
                        <img src="/../web/img/1.png" alt="">
                    </div>
                    <div class="img_2">
                        <img src="/../web/img/2.png" alt="">
                    </div>
                </div>
            </div>
            <div class="col-xl-5 col-lg-5 offset-lg-1 col-md-6">
                <div class="about_info">
                    <div class="section_title mb-20px">
                        <span>О нас</span>
                        <h3>Лучшее кафе  <br>
                            в твоем городе</h3>
                    </div>
                    <p>Наше кафе - это место, где каждый клиент встречается с теплом и уютом. Мы гордимся своим разнообразным меню, предлагающим блюда на любой вкус - от классических завтраков до изысканных десертов. Наш поручик бариста готов предложить вам широкий выбор напитков - от ароматного кофе до освежающих коктейлей. Мы уделяем особое внимание качеству продуктов и заботимся о каждой детали приготовления блюд.

                        Наша команда внимательных и дружелюбных сотрудников всегда готова встретить вас с улыбкой и обеспечить первоклассное обслуживание. Мы создаем атмосферу гостеприимства и комфорта, чтобы каждый гость чувствовал себя как дома. Мы стремимся к тому, чтобы визит в наше кафе стал для вас незабываемым и приятным.

                        Приходите в наше кафе и позвольте нам порадовать вас вкусом, обслуживанием и атмосферой. Мы рады будем видеть вас в числе наших постоянных гостей!</p>
                    <div class="img_thumb">
                        <img src="/../web/img/avt.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
