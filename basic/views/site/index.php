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
<?php
// Подключение к базе данных
$pdo = new PDO('mysql:host=localhost;dbname=yii2basic', 'root', '');

// Получение данных о товарах из базы
$statement = $pdo->query('SELECT * FROM promotions');
$promotions = $statement->fetchAll(PDO::FETCH_ASSOC);

?>



<section id="menu" class="avtopark container">
    <div class="textov">
        <h1>Наше меню</h1>
        <button class="smtr button-cat" data-category="all">Смотреть все</button>
    </div>
    <div class="tri container">
        <ul class="catalog">
            <li>
                <button class="button-cat svet" data-category="салат">
                    <p>Салаты</p>
                </button>
            </li>
            <li>
                <button class="button-cat svet s1" data-category="закуски">
                    <p>Закуски</p>
                </button>
            </li>
            <li>
                <button class="button-cat svet s1" data-category="гарниры">
                    <p>Гарниры</p>
                </button>
            </li>
            <li>
                <button class="button-cat svet s1" data-category="супы">
                    <p>Супы</p>
                </button>
            </li>
            <li>
                <button class="button-cat svet s1" data-category="картошка">
                    <p>Картошка</p>
                </button>
            </li>
            <li>
                <button class="button-cat svet s1" data-category="напитки">
                    <p>Напитки</p>
                </button>
            </li>
        </ul>
    </div>
    <?php
// Подключение к базе данных
$pdo = new PDO('mysql:host=localhost;dbname=yii2basic', 'root', '');

// Получение данных о товарах из базы
$statement = $pdo->query('SELECT * FROM promotions');
$promotions = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="katalog container">
    <h1>Еженедельные акции</h1>
    <ul class="katal">
        <?php foreach ($promotions as $index => $promotion): ?>
            <?php if ($promotion['promotion_type'] === 'weekly'): ?>
                 <li class="vis-biba" data-category="<?= Html::encode($promotion['cat']) ?>" style="display: <?= $index < 6 ? 'block' : 'none' ?>">
                    <div class="img-kat">
                        <img src="<?= Html::encode($promotion['image_url']) ?>" alt="">
                    </div>
                    <h4><?= Html::encode($promotion['name']) ?></h4>
                    <p class="description"><?= Html::encode($promotion['description']) ?></p>
                    <div class="cen">
                        <p>Цена: <?= Html::encode($promotion['price']) ?></p>
                        <form method="post" action="<?= Url::to(['site/add-to-corzin']) ?>">
                            <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
                            <input type="hidden" name="id" value="<?= Html::encode($promotion['id']) ?>">
                            <input type="hidden" name="name" value="<?= Html::encode($promotion['name']) ?>">
                            <input type="hidden" name="price" value="<?= Html::encode($promotion['price']) ?>">
                            <input type="hidden" name="image_url" value="<?= Html::encode($promotion['image_url']) ?>">
                            <button type="submit">заказать</button>
                        </form>
                    </div>
                    </div>
                </section>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
    </div>
<div class="katalog container">
    <h1>Ежедневные акции</h1>
    <ul class="katal">
        <?php foreach ($promotions as $index => $promotion): ?>
            <?php if ($promotion['promotion_type'] === 'daily'): ?>
                 <li class="vis-biba" data-category="<?= Html::encode($promotion['cat']) ?>" style="display: <?= $index < 6 ? 'block' : 'none' ?>">
                    <div class="img-kat">
                        <img src="<?= Html::encode($promotion['image_url']) ?>" alt="">
                    </div>
                    <h4><?= Html::encode($promotion['name']) ?></h4>
                    <p class="description"><?= Html::encode($promotion['description']) ?></p>
                    <div class="cen">
                        <p>Цена: <?= Html::encode($promotion['price']) ?></p>
                        <form method="post" action="<?= Url::to(['site/add-to-corzin']) ?>">
                            <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
                            <input type="hidden" name="id" value="<?= Html::encode($promotion['id']) ?>">
                            <input type="hidden" name="name" value="<?= Html::encode($promotion['name']) ?>">
                            <input type="hidden" name="price" value="<?= Html::encode($promotion['price']) ?>">
                            <input type="hidden" name="image_url" value="<?= Html::encode($promotion['image_url']) ?>">
                            <button type="submit">заказать</button>
                        </form>
                    </div>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</div>

    <?php
    $pdo = new PDO('mysql:host=localhost;dbname=yii2basic', 'root', '');

    // Получение данных о товарах из базы
    $statement = $pdo->query('SELECT * FROM TOVAR');
    $tovars = $statement->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <div class="katalog container">
        <h1>Основное меню</h1>
        <ul class="katal">
            <?php foreach ($tovars as $index => $tovar): ?>
                <li class="vis-biba" data-category="<?= Html::encode($tovar['cat']) ?>" style="display: <?= $index < 6 ? 'block' : 'none' ?>">
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
                    <div class="centered-button">
                        <button id="show-more" class="golden">Показать еще</button>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    const categoryButtons = $('.button-cat');
    const items = $('.vis-biba');
    const showMoreButton = $('#show-more');
    let visibleItems = 6;

    function filterItems(category) {
        let displayedCount = 0;
        items.each(function(index, item) {
            if (category === 'all' || $(item).data('category') === category) {
                if (displayedCount < visibleItems) {
                    $(item).show();
                    displayedCount++;
                } else {
                    $(item).hide();
                }
            } else {
                $(item).hide();
            }
        });
    }

    categoryButtons.on('click', function() {
        const category = $(this).data('category');
        visibleItems = 6; // Reset visible items counter
        filterItems(category);
    });

    showMoreButton.on('mouseenter', function() {
        $(this).addClass('golden');
    }).on('mouseleave', function() {
        $(this).removeClass('golden');
    }).on('click', function() {
        visibleItems += 3;
        const currentCategory = $('.button-cat.svet.active').data('category') || 'all';
        filterItems(currentCategory);
    });

    // Initial filter to show only the first 6 items
    filterItems('all');
});
</script>
<style>
.centered-button {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh; /* Это высота всего экрана */
}

#show-more.golden {
    background: linear-gradient(to top right, #9F7437, #E3D293);
    color: black; /* Изменяем цвет текста на черный */
}
/* Общие стили для кнопок */
./* Общие стили для кнопок */
.button-cat {

    outline: none; /* Убираем контур */
    font-weight: bold; /* Полужирный текст */
    text-transform: uppercase; /* Прописные буквы */
    transition: all 0.3s ease; /* Плавный переход */
    box-shadow: 0 6px 10px rgba(0, 0, 0, 0.1); /* Тень */
}

/* Стили для наведения на кнопку */
.button-cat:hover {
    transform: translateY(-3px); /* Сдвиг вверх */
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2); /* Увеличенная тень */
}

/* Стили для активной кнопки */
.button-cat:active {
    transform: translateY(0); /* Возвращение в исходное положение */
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1); /* Тень */
}



</style>




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
