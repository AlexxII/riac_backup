<?php

namespace app\modules\equipment\controllers\tool;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

use app\modules\to\models\schedule\ToEquipment;
use app\modules\to\models\count\CountEquipment;
use app\modules\equipment\models\Oth;
use app\modules\equipment\models\Special;
use app\modules\equipment\models\Tools;
use app\modules\equipment\models\ToolSettings;

class SettingsController extends Controller
{
  public $defaultAction = 'index';

  public function actionIndex()
  {
    $id = $_GET['id'];
    $tool = Tools::findModel($id);
    $toolSettings = ToolSettings::findModel($id);
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    return [
      'data' => [
        'success' => true,
        'data' => $this->renderAjax('index', [
          'model' => Tools::findModel($id),
          'toolSettings' => $toolSettings
        ]),
        'message' => 'Page load',
      ],
      'code' => 1,
    ];
  }


  public function actionWrapConfig()
  {
    $id = $_GET['id'];
    $toolSettings = ToolSettings::findModel($id);

    return $this->render('wrap_view', [
      'tool' => Tools::findModel($id),
      'toolSettings' => $toolSettings,
    ]);
  }


  public function actionGeneralTable()
  {
    if (isset($_POST['toolId'])) {
      $toolId = $_POST['toolId'];
      $toolSettings = ToolSettings::findModel($toolId);
      if (isset($_POST['bool'])) {
        if ($_POST['bool'] === 'true') {
          $toolSettings->eq_general = 1;
        } else {
          $toolSettings->eq_general = 0;
        }
      } else {
        return false;
      }
      if ($toolSettings->save()) {
        return true;
      }
      return false;
    }
    return false;
  }

  // Пакетная обработка - в разработке
  public function actionGeneralTablePckg()
  {
    return false;
  }

  public function actionOth()
  {
    if (isset($_POST['toolId'])) {
      $toolId = $_POST['toolId'];
      $toolSettings = ToolSettings::findModel($toolId);
      $model = Tools::findModel($toolId);
      if ($model->oth) {
        $oth = $model->oth;
      } else {
        $oth = new Oth();
        $oth->eq_id = $model->id;
      }
      if (isset($_POST['bool'])) {
        if ($_POST['bool'] === 'true') {
          $toolSettings->eq_oth = 1;
          $oth->valid = 1;
        } else {
          $toolSettings->eq_oth = 0;
          $oth->eq_id = $model->id;
          $oth->valid = 0;
        }
      } else {
        return false;
      }
      if ($toolSettings->save()) {
        if ($oth->save()) {
          return true;
        }
        return false;
      }
      return false;
    }
    return false;
  }

  // Пакетная обработка - в разработке
  public function actionOthPckg()
  {
    return false;
  }

  public function actionOthTitle()
  {
    if (isset($_POST['toolId'])) {
      $toolId = $_POST['toolId'];
      $model = Tools::findModel($toolId);
      if ($model->oth) {
        $oth = $model->oth;
      } else {
        return false;
      }
      if (isset($_POST['bool'])) {
        if ($_POST['bool'] === 'true') {
          $oth->eq_oth_title = $_POST['title'];
          $oth->eq_oth_title_on = 1;
        } else {
          $oth->eq_oth_title_on = 0;
        }
      } else {
        return false;
      }
      if ($oth->save()) {
        return true;
      }
      return false;
    }
    return false;
  }

  public function actionComplex()
  {
    if (isset($_POST['toolId'])) {
      $toolId = $_POST['toolId'];
      $toolSettings = ToolSettings::findModel($toolId);
      if (isset($_POST['bool'])) {
        if ($_POST['bool'] === 'true') {
          $toolSettings->eq_complex = 1;
        } else {
          $toolSettings->eq_complex = 0;
        }
      } else {
        return false;
      }
      if ($toolSettings->save()) {
        return true;
      }
      return false;
    }
    return false;
  }

  public function actionWrap()
  {
    if (isset($_POST['toolId'])) {
      $toolId = $_POST['toolId'];
      $toolSettings = ToolSettings::findModel($toolId);
      $toolModel = Tools::findModel($toolId);
      if (isset($_POST['bool'])) {
        if ($_POST['bool'] === 'true') {
          $toolSettings->eq_wrap = 1;
          $toolModel->icon = 't fa fa-clone';
        } else {
          $toolSettings->eq_wrap = 0;
          $toolModel->icon = 't fa fa-file-o';
        }
      } else {
        return false;
      }
      if ($toolSettings->save() && $toolModel->save()) {
        return true;
      }
      return false;
    }
    return false;
  }

  public function actionSpecialWorks()
  {
    if (isset($_POST['toolId'])) {
      $toolId = $_POST['toolId'];
      $toolSettings = ToolSettings::findModel($toolId);
      $model = Tools::findModel($toolId);
      if ($model->special) {
        $special = $model->special;
      } else {
        $special = new Special();
        $special->eq_id = $model->id;
      }
      if (isset($_POST['bool'])) {
        if ($_POST['bool'] === 'true') {
          $toolSettings->eq_special = 1;
          $special->valid = 1;
        } else {
          $toolSettings->eq_special = 0;
          $special->valid = 0;
        }
      } else {
        return false;
      }
      if ($toolSettings->save()) {
        if ($special->save()) {
          return true;
        }
        return false;
      }
      return false;
    }
    return false;
  }

  public function actionSpecialStickerNumber()
  {
    if (isset($_POST['toolId'])) {
      $toolId = $_POST['toolId'];
      $model = Tools::findModel($toolId);
      if ($model->special) {
        $special = $model->special;
      } else {
        return false;
      }
      if (isset($_POST['title'])) {
        $special->sticker_number = $_POST['title'];
      } else {
        return false;
      }
      if ($special->save()) {
        return true;
      }
      return false;
    }
    return false;
  }


  // =================== ТО ==============================
  // В графике ТО
  public function actionMaintenance()
  {
    if (isset($_POST['toolId'])) {
      $toolId = $_POST['toolId'];
      $toolSettings = ToolSettings::findModel($toolId);
      $model = Tools::findModel($toolId);
      if ($model->to) {
        $to = $model->to;
      } else {
        $to = new ToEquipment();
        $to->eq_id = $model->id;
        $to->name = $model->eq_title;
        $parent = ToEquipment::findOne(['lvl' => 0]);            // TODO !!есть вероятность ошибки
        $to->parent_id = $parent->id;
        $to->appendTo($parent);
      }
      if (isset($_POST['bool'])) {
        if ($_POST['bool'] === 'true') {
          $toolSettings->eq_to = 1;
          $to->valid = 1;
        } else {
          $toolSettings->eq_to = 0;
          $to->valid = 0;
        }
      } else {
        return false;
      }
      if ($toolSettings->save()) {
        if ($to->save()) {
          return true;
        }
        return false;
      }
      return false;
    }
    return false;
  }

  // Подсчет наработанного времени
  public function actionWorkCount()
  {
    if (isset($_POST['toolId'])) {
      $toolId = $_POST['toolId'];
      $toolSettings = ToolSettings::findModel($toolId);
      $model = Tools::findModel($toolId);
      if ($model->wCount) {
        $workCount = $model->wCount;
      } else {
        $workCount = new CountEquipment();
        $workCount->eq_id = $model->id;
        $workCount->name = $model->eq_title;
        $parent = CountEquipment::findOne(['lvl' => 0]);            // TODO !!есть вероятность ошибки
        $workCount->parent_id = $parent->id;
        $workCount->appendTo($parent);
      }
      if (isset($_POST['bool'])) {
        if ($_POST['bool'] === 'true') {
          $toolSettings->eq_wcount = 1;
          $workCount->valid = 1;
        } else {
          $toolSettings->eq_wcount = 0;
          $workCount->valid = 0;
        }
      } else {
        return false;
      }
      if ($toolSettings->save()) {
        if ($workCount->save()) {
          return true;
        }
        return false;
      }
      return false;
    }
    return false;
  }

}