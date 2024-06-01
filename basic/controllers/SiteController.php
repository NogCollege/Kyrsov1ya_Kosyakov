<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\RegisterForm;
use app\models\User;
use app\models\LoginForm;
use app\models\Tovar;
use app\models\Cart;
use app\models\Order;
use yii\helpers\Url;
use yii\helpers\Html;
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'admin'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['admin'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function($rule, $action) {
                            return Yii::$app->user->identity->role === User::ROLE_ADMIN;
                        },
                    ],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionRegister()
    {
        $model = new RegisterForm();
        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            return $this->redirect(['login']);
        }
        return $this->render('register', [
            'model' => $model,
        ]);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if (Yii::$app->user->identity->role === User::ROLE_ADMIN) {
                return $this->redirect(['admin']);
            }
            return $this->goBack();
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionAdmin()
    {
        return $this->render('admin');
    }
    public function actionCreateOrder()
    {
        // Получаем текущего пользователя
        $user = Yii::$app->user->identity;

        // Создаем новый заказ
        $model = new Order();
        $model->customer_name = $user->username; // Имя пользователя
        $model->customer_email = $user->email; // Email пользователя
        $model->promocode = 'nogcollege'; // Пример применения промокода
        $model->delivery_method = 'home_delivery'; // Пример выбора метода доставки

        // Сохраняем модель в базе данных
        if ($model->save()) {
            // Успешно сохранено
            return $this->redirect(['order/view', 'id' => $model->id]);
        } else {
            // Ошибка при сохранении
            Yii::error("Ошибка при сохранении заказа: " . json_encode($model->errors));
            throw new \yii\web\HttpException(500, "Ошибка при сохранении заказа");
        }
    }
    public function actionCheckout()
    {
        $order = new Order();
        $cart = Yii::$app->session->get('cart', new Cart());

        if ($order->load(Yii::$app->request->post()) && $order->validate()) {
            $order->customer_name = Yii::$app->request->post('Order')['customer_name'];
            $order->customer_email = Yii::$app->request->post('Order')['customer_email'];
            $order->applyPromocode($order->promocode); // Применение промокода
            $order->status = Order::STATUS_CREATED;
            $order->save();

            // Отправка писем
            $this->sendEmailToCustomer($order);
            $this->sendEmailToAdmin($order);

            // Перенаправление на страницу статуса заказа
            return $this->redirect(['site/order-status', 'id' => $order->id]);
        }

        return $this->render('checkout', ['order' => $order, 'cart' => $cart]);
    }

    public function actionOrderStatus($id)
    {
        $order = Order::findOne($id);
        return $this->render('order-status', ['order' => $order]);
    }

    private function sendEmailToCustomer($order)
    {
        Yii::$app->mailer->compose()
            ->setTo($order->email)
            ->setSubject('Подтверждение заказа')
            ->setTextBody('Ваш заказ успешно оформлен.')
            ->send();
    }

    private function sendEmailToAdmin($order)
    {
        $adminEmail = 'kolt12566@gmail.com'; // Замените на реальный адрес администратора
        Yii::$app->mailer->compose()
            ->setTo($adminEmail)
            ->setSubject('Новый заказ')
            ->setTextBody('Поступил новый заказ. Номер заказа: ' . $order->id)
            ->send();
    }


public function actionAdd()
    {
        $id = Yii::$app->request->post('id');
        $tovar = Tovar::findOne($id);

        if ($tovar) {
            $cart = Yii::$app->session->get('cart', new Cart());
            $cart->addItem($tovar->attributes);
            Yii::$app->session->set('cart', $cart);
        }

        return $this->redirect(['cart/index']);
    }

    public function actionRemove($id)
    {
        $cart = Yii::$app->session->get('cart', new Cart());
        $cart->removeItem($id);
        Yii::$app->session->set('cart', $cart);

        return $this->redirect(['cart']);
    }

    public function actionUpdate()
    {
        $id = Yii::$app->request->post('id');
        $quantity = Yii::$app->request->post('quantity');

        $cart = Yii::$app->session->get('cart', new Cart());
        $cart->updateItem($id, $quantity);
        Yii::$app->session->set('cart', $cart);

        return $this->redirect(['cart']);
    }

    public function actionAddToCart()
    {
        $id = Yii::$app->request->post('id');
        $tovar = Tovar::findOne($id);

        if ($tovar) {
            $cart = Yii::$app->session->get('cart', new Cart());
            $cart->addItem($tovar->attributes);
            Yii::$app->session->set('cart', $cart);
        }

        return $this->redirect(['site/cart']);
    }

    public function actionRemoveFromCart($id)
    {
        $cart = Yii::$app->session->get('cart', new Cart());
        $cart->removeItem($id);
        Yii::$app->session->set('cart', $cart);

        return $this->redirect(['site/cart']);
    }

    public function actionUpdateCart()
    {
        $id = Yii::$app->request->post('id');
        $quantity = Yii::$app->request->post('quantity');

        $cart = Yii::$app->session->get('cart', new Cart());
        $cart->updateItem($id, $quantity);
        Yii::$app->session->set('cart', $cart);

        return $this->redirect(['site/cart']);
    }

    public function actionCart()
    {
        $cart = Yii::$app->session->get('cart', new Cart());
        return $this->render('cart', ['cart' => $cart]);
    }
    public function actionIndex()
    {
        return $this->render('index');
    }





    /**
     * Login action.
     * Login action.
     *
     * @return Response|string
     */



    /**
     * Displays contact page.
     *
     * @return Response|string
     */

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
