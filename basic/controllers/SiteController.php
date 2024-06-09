<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\SignupForm;
use app\models\User;
use app\models\LoginForm;
use app\models\Tovar;
use app\models\Cart;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use app\models\Order;
use app\models\OrderForm;
use app\models\PromoCode;
use app\models\OrderItem;
use app\models\ProductSearch;
use app\models\PromoCodeSearch;;
use app\models\UserSearch;
use app\models\Promotion;
use app\models\PromotionSearch;
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            return $this->goHome();
        }

        return $this->render('signup', [
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
            $user = User::findOne(Yii::$app->user->id);
            if ($user->role == User::ROLE_ADMIN) {
                return $this->redirect(['site/admin']);
            } elseif ($user->role == User::ROLE_COURIER) {
                return $this->redirect(['site/courier']);
            } else {
                return $this->goHome();
            }
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }
    public function actionIndex()
    {
        $model = new OrderForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $order = new Order();
            $order->customer_name = $model->customer_name;
            $order->address = $model->address;
            $order->promocode = $model->promocode;
            $order->delivery_method = $model->delivery_method;
            $order->customer_email = $model->customer_email;
            $order->user_id = Yii::$app->user->id; // Capture the user ID of the authenticated user

            if ($order->save()) {
                Yii::$app->session->setFlash('success', 'Order placed successfully!');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error placing your order.');
            }

            return $this->refresh();
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }



    public function actionClearCache()
    {
        if (Yii::$app->cache->flush()) {
            Yii::$app->session->setFlash('success', 'Кэш успешно очищен.');
        } else {
            Yii::$app->session->setFlash('error', 'Не удалось очистить кэш.');
        }
        return $this->redirect(['admin']);
    }



    public function actionAdmin()
    {
        $action = 'admin';
        $productSearchModel = new ProductSearch();
        $productDataProvider = $productSearchModel->search(Yii::$app->request->queryParams);

        return $this->render('admin', [
            'action' => $action,
            'productDataProvider' => $productDataProvider,
        ]);
    }

    public function actionCreateProduct()
    {
        $action = 'create';
        $model = new Tovar();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['admin']);
        }

        return $this->render('admin', [
            'action' => $action,
            'model' => $model,
        ]);
    }

    public function actionUpdateProduct($id)
    {
        $action = 'update';
        $model = $this->findProductModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['admin']);
        }

        return $this->render('admin', [
            'action' => $action,
            'model' => $model,
        ]);
    }

    public function actionDeleteProduct($id)
    {
        $this->findProductModel($id)->delete();

        return $this->redirect(['admin']);
    }

    public function actionPromoIndex()
    {
        $action = 'promo';
        $promoSearchModel = new PromoCodeSearch();
        $promoDataProvider = $promoSearchModel->search(Yii::$app->request->queryParams);

        return $this->render('admin', [
            'action' => $action,
            'promoDataProvider' => $promoDataProvider,
        ]);
    }

    public function actionCreatePromo()
    {
        $action = 'createPromo';
        $model = new PromoCode();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['promo-index']);
        }

        return $this->render('admin', [
            'action' => $action,
            'model' => $model,
        ]);
    }

    public function actionUpdatePromo($id)
    {
        $action = 'updatePromo';
        $model = $this->findPromoModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['promo-index']);
        }

        return $this->render('admin', [
            'action' => $action,
            'model' => $model,
        ]);
    }

    public function actionDeletePromo($id)
    {
        $this->findPromoModel($id)->delete();

        return $this->redirect(['promo-index']);
    }

    public function actionUserIndex()
    {
        $action = 'user';
        $userSearchModel = new UserSearch();
        $userDataProvider = $userSearchModel->search(Yii::$app->request->queryParams);

        return $this->render('admin', [
            'action' => $action,
            'userDataProvider' => $userDataProvider,
        ]);
    }

    public function actionCreateUser()
    {
        $action = 'createUser';
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['user-index']);
        }

        return $this->render('admin', [
            'action' => $action,
            'model' => $model,
        ]);
    }

    public function actionUpdateUser($id)
    {
        $action = 'updateUser';
        $model = $this->findUserModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['user-index']);
        }

        return $this->render('admin', [
            'action' => $action,
            'model' => $model,
        ]);
    }

    public function actionDeleteUser($id)
    {
        $this->findUserModel($id)->delete();

        return $this->redirect(['user-index']);
    }

    public function actionPromotionIndex()
    {
        $action = 'promotion';
        $promotionSearchModel = new PromotionSearch();
        $promotionDataProvider = $promotionSearchModel->search(Yii::$app->request->queryParams);

        return $this->render('admin', [
            'action' => $action,
            'promotionDataProvider' => $promotionDataProvider,
        ]);
    }

    public function actionCreatePromotion()
    {
        $action = 'createPromotion';
        $model = new Promotion();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['promotion-index']);
        }

        return $this->render('admin', [
            'action' => $action,
            'model' => $model,
        ]);
    }

    public function actionUpdatePromotion($id)
    {
        $action = 'updatePromotion';
        $model = $this->findPromotionModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['promotion-index']);
        }

        return $this->render('admin', [
            'action' => $action,
            'model' => $model,
        ]);
    }

    public function actionDeletePromotion($id)
    {
        $this->findPromotionModel($id)->delete();

        return $this->redirect(['promotion-index']);
    }

    protected function findPromotionModel($id)
    {
        if (($model = Promotion::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function findProductModel($id)
    {
        if (($model = Tovar::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findPromoModel($id)
    {
        if (($model = PromoCode::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findUserModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }







public function actionCourier()
    {
        return $this->render('courier');
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
    public function getTotal()
    {
        $total = 0;
        $cart = Yii::$app->session->get('cart', new Cart());
        $items = $cart->getItems();
        foreach ($items as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }



    public function actionCheckout()
    {
        $model = new Order();

        // Устанавливаем user_id текущего пользователя, если он авторизован
        if (!Yii::$app->user->isGuest) {
            $model->user_id = Yii::$app->user->id;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Заказ успешно оформлен!');
            return $this->refresh();
        }

        return $this->render('checkout', [
            'model' => $model,
        ]);
    }

    public function actionProfile()
    {
        // Получаем текущего авторизованного пользователя, если он есть
        $user = Yii::$app->user->identity;

        // Проверяем, авторизован ли пользователь
        if ($user !== null) {
            // Если пользователь авторизован, получаем его ID
            $userId = $user->id;

            // Получаем все заказы, сделанные текущим пользователем
            $orders = Order::find()->where(['user_id' => $userId])->all();

            // Отображаем представление с заказами пользователя
            return $this->render('profile', [
                'orders' => $orders,
                'user' => $user,
            ]);
        } else {
            // Если пользователь не авторизован, можно выполнить другое действие или просто вывести сообщение
            return $this->render('not_authorized');
        }
    }


    public function actionGetDiscount()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $promoCode = Yii::$app->request->post('PromoCode');
        $discount = 0; // По умолчанию скидка равна 0

        // Здесь ваш код для получения скидки из базы данных по промокоду
        // Например, используйте модель Order для запроса к базе данных
        $order = Order::find()->where(['PromoCode' => $promoCode])->one();
        if ($order) {
            $discount = $order->discount;
        }

        return ['discount' => $discount];
    }

    public function actionSendEmails()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model = new Order();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // Отправка письма заказчику
            Yii::$app->mailer->compose()
                ->setTo($model->customer_email)
                ->setFrom([Yii::$app->params['adminEmail'] => 'Ваш сайт'])
                ->setSubject('Ваш заказ оформлен')
                ->setTextBody("Уважаемый(ая) {$model->customer_name},\n\nВаш заказ был успешно оформлен. Детали заказа:\n\n" .
                    "Имя: {$model->customer_name}\n" .
                    "Телефон: {$model->phone_number}\n" .
                    "Адрес: {$model->address}\n" .
                    "Промокод: {$model->promocode}\n" .
                    "Тип доставки: {$model->delivery_method}\n" .
                    "Email: {$model->customer_email}\n\n" .
                    "Спасибо за ваш заказ!")
                ->send();

            // Отправка письма админу
            Yii::$app->mailer->compose()
                ->setTo(Yii::$app->params['adminEmail'])
                ->setFrom([Yii::$app->params['adminEmail'] => 'Ваш сайт'])
                ->setSubject('Новый заказ')
                ->setTextBody("Поступил новый заказ. Детали заказа:\n\n" .
                    "Имя: {$model->customer_name}\n" .
                    "Телефон: {$model->phone_number}\n" .
                    "Адрес: {$model->address}\n" .
                    "Промокод: {$model->promocode}\n" .
                    "Тип доставки: {$model->delivery_method}\n" .
                    "Email: {$model->customer_email}")
                ->send();

            return ['status' => 'success', 'message' => 'Заказ успешно добавлен в базу данных и письма отправлены!'];
        } else {
            return ['status' => 'error', 'message' => 'Произошла ошибка при добавлении заказа в базу данных!'];
        }
    }
    public function actionAddToCorzin()
    {
        $id = Yii::$app->request->post('id');
        $name = Yii::$app->request->post('name');
        $price = Yii::$app->request->post('price');
        $image_url = Yii::$app->request->post('image_url');

        // Assuming you have a Cart model to manage the cart
        $cart = Yii::$app->session->get('cart', new Cart());

        // Add the item to the cart
        $cart->addItem([
            'id' => $id,
            'name' => $name,
            'price' => $price,
            'image_url' => $image_url,
        ]);

        // Save the cart back to the session
        Yii::$app->session->set('cart', $cart);

        return $this->redirect(['site/cart']);
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
