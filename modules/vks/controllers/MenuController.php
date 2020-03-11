<?php

namespace app\modules\vks\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

class MenuController extends Controller
{
  public function actionLeftSide()
  {
    return $this->renderAjax('left_menu');
  }

  public function actionAppConfig()
  {
    return $this->renderAjax('app_config_menu');
  }

  public function actionRightSideData()
  {
    return $this->renderAjax('right_data');
  }

  public function actionSmallMenu()
  {
    return $this->renderAjax('small_menu');
  }

}