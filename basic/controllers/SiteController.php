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

    public function actionAdmin()
    {
        $action = 'admin';
        $dataProviderProducts = new ActiveDataProvider([
            'query' => Tovar::find(),
        ]);

        $dataProviderPromoCodes = new ActiveDataProvider([
            'query' => PromoCode::find(),
        ]);

        return $this->render('admin', [
            'dataProviderProducts' => $dataProviderProducts,
            'dataProviderPromoCodes' => $dataProviderPromoCodes,
            'action' => $action, // Pass the $action variable to the view
        ]);
    }

    public function actionCreateProduct()
    {
        $model = new Tovar();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['admin']);
        }

        return $this->render('admin', [
            'model' => $model,
            'action' => 'create-product',
        ]);
    }

    public function actionUpdateProduct($id)
    {
        $model = Tovar::findOne($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['admin']);
        }

        return $this->render('admin', [
            'model' => $model,
            'action' => 'update-product',
        ]);
    }

    public function actionDeleteProduct($id)
    {
        Tovar::findOne($id)->delete();
        return $this->redirect(['admin']);
    }

    public function actionCreatePromoCode()
    {
        $model = new PromoCode();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Промокод успешно создан.');
            return $this->redirect(['admin']);
        }

        return $this->render('create-promo-code', [
            'model' => $model,
        ]);
    }

    public function actionUpdatePromoCode($id)
    {
        $model = PromoCode::findOne($id);

        if ($model === null) {
            throw new NotFoundHttpException('Промокод не найден.');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Промокод успешно обновлен.');
            return $this->redirect(['admin']);
        }

        return $this->render('update-promo-code', [
            'model' => $model,
        ]);
    }

    public function actionDeletePromoCode($id)
    {
        $model = PromoCode::findOne($id);
        if ($model !== null) {
            $model->delete();
            Yii::$app->session->setFlash('success', 'Промокод успешно удален.');
        } else {
            Yii::$app->session->setFlash('error', 'Промокод не найден.');
        }

        return $this->redirect(['admin']);
    }


    protected function findModel($id)
    {
        if (($model = Tovar::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findPromoCodeModel($id)
    {
        if (($model = PromoCode::findOne($id)) !== null) {
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
    public function actionProcessOrder()
    {
        $model = new OrderForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $order = new Order();
            $order->customer_name = $model->customer_name;
            $order->customer_email = $model->email;
            $order->delivery_method = $model->delivery;
            $order->total = $this->calculateTotal(); // здесь нужно реализовать логику подсчета общей суммы заказа

            if ($order->save()) {
                Yii::$app->session->setFlash('success', 'Заказ успешно оформлен.');
                return $this->redirect(['site/index']);
            } else {
                Yii::$app->session->setFlash('error', 'Произошла ошибка при оформлении заказа.');
            }
        }

        return $this->render('checkout', [
            'model' => $model,
        ]);
    }


    public function actionCheckout()
    {
        $model = new Order();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // Apply promo code if provided
            if (!empty($model->promocode)) {
                $model->applyPromocode($model->promocode);
            }

            if (!$model->hasErrors()) {
                // Save the order to the database or any other processing needed
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Ваш заказ был успешно оформлен.');
                    return $this->refresh();
                } else {
                    Yii::$app->session->setFlash('error', 'Ошибка при сохранении заказа.');
                }
            }
        }

        return $this->render('checkout', [
            'model' => $model,
        ]);
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
