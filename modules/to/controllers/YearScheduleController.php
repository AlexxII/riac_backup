<?php

namespace app\modules\to\controllers;

use Yii;
use yii\web\Controller;

use app\base\Model;
use app\modules\to\models\ToEquipment;
use app\modules\to\models\ToSchedule;
use app\modules\to\models\ToType;
use app\modules\to\models\ToYearSchedule;

class YearScheduleController extends Controller
{

  /*  public function actionIndex()
    {
      $toTypes = ToType::find()->where(['!=', 'lvl', '0'])->orderBy('lft')->asArray()->all();
      $toTypeArray = array();
      foreach ($toTypes as $toType) {
        $toTypeArray[$toType['id']] = mb_substr($toType['name'], 0, 1);
      }
      return $this->render('create', [
        'list' => $toTypeArray
      ]);
    }
  */
  public function actionCreate()
  {
    $toTypes = ToType::find()->where(['!=', 'lvl', '0'])->orderBy('lft')->asArray()->all();
    $toTypeArray = array();
    foreach ($toTypes as $toType) {
//      $toTypeArray[$toType['id']] = mb_substr($toType['name'], 0, 1);
      $toTypeArray[$toType['id']] = $toType['name'];
    }
    $toEq = ToEquipment::find()
      ->where(['valid' => 1])
      ->andWhere(['!=', 'eq_id', '0'])->orderby(['lft' => SORT_ASC])->all();
    if (empty($toEq)) {
      Yii::$app->session->setFlash('error', "Не добавлено ни одного оборудования в график ТО.");
      return $this->render('create', [
        'tos' => $toEq,
        'list' => $toTypeArray
      ]);
    }
    $scheduleRand = rand();
    foreach ($toEq as $i => $eq) {
      $toss[] = new ToYearSchedule();
      $toss[$i]->eq_id = $eq->id;
      $toss[$i]->schedule_year = 2019;
    }
    return $this->render('create', [
      'tos' => $toss,
      'list' => $toTypeArray
    ]);


  }


  public function actionIndex()
  {
    $this->layout = '@app/views/layouts/main_ex.php';

    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    Yii::$app->view->params['title'] = 'Годовый планы ТО';
    Yii::$app->view->params['bUrl'] = $_GET['back-url'];
    $toTypes = ToType::find()->where(['!=', 'lvl', '0'])->orderBy('lft')->asArray()->all();
    $toTypeArray = array();
    foreach ($toTypes as $toType) {
//      $toTypeArray[$toType['id']] = mb_substr($toType['name'], 0, 1);
      $toTypeArray[$toType['id']] = $toType['name'];
    }

    $toEq = ToEquipment::find()
      ->where(['valid' => 1])
      ->andWhere(['!=', 'eq_id', '0'])->orderby(['lft' => SORT_ASC])->all();
    if (empty($toEq)) {
      Yii::$app->session->setFlash('error', "Не добавлено ни одного оборудования в график ТО.");
      return $this->render('create', [
        'tos' => $toEq,
      ]);
    }
    $scheduleRand = rand();
    foreach ($toEq as $i => $eq) {
      $toss[] = new ToYearSchedule();
      $toss[$i]->eq_id = $eq->id;
    }
    $to = new ToYearSchedule();

    return [
      'data' => [
        'success' => true,
        'data' => $this->render('_form', [
          'tos' => $toss,
          'list' => $toTypeArray

        ]),
        'message' => 'Page load.',
      ],
      'code' => 1,
    ];



    if (ToYearSchedule::loadMultiple($toss, Yii::$app->request->post())) {
      if (!$to_month = Yii::$app->request->post('month')) {
        Yii::$app->session->setFlash('error', "Введите месяц проведения ТО");
        return $this->render('create', ['tos' => $toss]);
      }
      if (ToYearSchedule::validateMultiple($toss)) {
        foreach ($toss as $t) {
          $t->to_month = $to_month;
          $t->save();
        }
      } else {
        Yii::$app->session->setFlash('error', "Ошибка валидации данных");
        return $this->render('create', ['tos' => $toss]);
      }
      Yii::$app->session->setFlash('success', "Новый график ТО создан успешно");
      return $this->redirect('archive'); // redirect to your next desired page
    } else {
      return $this->render('create_ex', [
        'tos' => $toss
      ]);
    }
  }

  public function actionSelect()
  {
    $toEq = ToEquipment::find()
      ->where(['valid' => 1])
      ->andWhere(['!=', 'eq_id', '0'])->orderby(['lft' => SORT_ASC])->all();
    if (empty($toEq)) {
      Yii::$app->session->setFlash('error', "Не добавлено ни одного оборудования в график ТО.");
      return $this->render('create', [
        'tos' => $toEq,
      ]);
    }
    $scheduleRand = rand();
    foreach ($toEq as $i => $eq) {
      $toss[] = new ToYearSchedule();
      $toss[$i]->scenario = ToYearSchedule::SCENARIO_CREATE;
      $toss[$i]->eq_id = $eq->id;
      $toss[$i]->schedule_id = $scheduleRand;
    }
  }

  public function actionCreateYearSchedule()
  {
    $year = $_POST['year'];
    $result = array();
    $yearModel = ToYearSchedule::findAll(['schedule_year' => $year]);
    $toEq = ToEquipment::find()
      ->where(['valid' => 1])
      ->andWhere(['!=', 'eq_id', '0'])->orderby(['lft' => SORT_ASC])->asArray()->all();
    if (empty($toEq)) {
      $result['status'] = false;
      $result['data'] = '';
      return json_encode($result);
    }
    if (count($yearModel) == count($toEq)) {
      $t = array();
      foreach ($yearModel as $model) {
        $temp = array();
        for ($i = 0; $i < 12; $i++) {
          $string = 'm' . $i;
          $temp[$i] = $model[$string];
        }
        $t[$model['eq_id']] = $temp;
      }
      $result['status'] = 'old';
      $result['data'] = &$t;
      return json_encode($result);
    } else {
      foreach ($toEq as $i => $eq) {
        $toss[] = new ToYearSchedule();
        $toss[$i]->eq_id = $eq['id'];
        $toss[$i]->schedule_year = $year;
        $toss[$i]->save();
      }
      $yearModel = ToYearSchedule::findAll(['schedule_year' => $year]);
      $t = array();
      foreach ($yearModel as $model) {
        $temp = array();
        for ($i = 0; $i < 12; $i++) {
          $string = 'm' . $i;
          $temp[$i] = $model[$string];
        }
        $t[$model['eq_id']] = $temp;
      }
      $result['status'] = 'new';
      $result['data'] = &$t;
      return json_encode($result);
    }
  }

  public function actionSaveTypes()
  {
    $array = $_POST['id'];
    $year = $_POST['year'];
    $result = false;
    foreach ($array as $ar) {
      $eqId = $ar['eqId'];
      $types = $ar['types'];
      $model = ToYearSchedule::find()->where(['eq_id' => $eqId])->andWhere(['schedule_year' => $year])->one();
      for ($i = 0; $i < 12; $i++) {
        $month = 'm' . $i;
        $model->$month = $types[$i];
      }
      if ($model->save(false)) {
        $result = true;
        continue;
      }
      return false;
    }
    return true;
  }

}