<?php

namespace app\controllers;

use yii;
use yii\filters;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;
use app\models\SignupForm;

class PageController extends Controller
{
    public function actionlogin()
    {
            return $this->render('login');
    }
}