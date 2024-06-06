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
        $dataProvider = new ActiveDataProvider([
            'query' => Tovar::find(),
        ]);

        $dataProviderPromoCodes = new ActiveDataProvider([
            'query' => PromoCode::find(),
        ]);

        return $this->render('admin', [
            'dataProvider' => $dataProvider,
            'dataProviderPromoCodes' => $dataProviderPromoCodes,
            'action' => $action,
        ]);
    }

    public function actionCreate()
    {
        $model = new Tovar();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('admin', [
            'model' => $model,
            'action' => 'create',
        ]);
    }

    public function actionUpdatee($id)
    {
        $model = Tovar::findOne($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('admin', [
            'model' => $model,
            'action' => 'updatee',
        ]);
    }

    public function actionDelete($id)
    {
        Tovar::findOne($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionCreatePromo()
    {
        $model = new PromoCode();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['promo-index']);
        }

        return $this->render('admin', [
            'model' => $model,
            'action' => 'createPromo',
        ]);
    }

    public function actionUpdatePromo($id)
    {
        $model = PromoCode::findOne($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['promo-index']);
        }

        return $this->render('admin', [
            'model' => $model,
            'action' => 'updatePromo',
        ]);
    }

    public function actionDeletePromo($id)
    {
        PromoCode::findOne($id)->delete();

        return $this->redirect(['promo-index']);
    }

    public function actionPromoIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => PromoCode::find(),
        ]);

        return $this->render('admin', [
            'dataProvider' => $dataProvider,
            'action' => 'promo',
        ]);
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
