<?php

namespace app\modules\polls\controllers;

use Yii;
use yii\web\Controller;

class AnaliticController extends Controller
{

  public function actionIndex()
  {
    return $this->render('index');
  }

}