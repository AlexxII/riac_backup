<?php

namespace app\modules\maps\controllers;

use Yii;
use yii\web\Controller;

class MurmController extends Controller
{

/*  public function actionIndex()
  {
//    \Yii::$app->view->title = 'Карты';
    return $this->render('index');
  }*/

  public function actionIndex()
  {

    return $this->render('_index');
  }

}