<?php

namespace app\modules\equipment\controllers\infoPanel;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

use app\modules\equipment\models\Tools;
use app\modules\equipment\models\Wiki;


class WikiController extends Controller
{

  public function actionIndex()
  {
    $id = $_GET['id'];
    $model = Wiki::find()->where(['eq_id' => $id])->orderBy('wiki_title')->limit(1)->all();
    $list = Wiki::find()->where(['eq_id' => $id])->orderBy('wiki_title')->asArray()->all();
    $toolModel = Tools::findModel($id);
    if (!empty($model)) {
      $indexModel = $model[0];
      return $this->renderAjax('index', [
        'model' => $indexModel,
        'list' => $list,
      ]);
    }
    return $this->renderAjax('_index', [
    ]);
  }

  public function actionCreate()
  {
    $model = new Wiki();
    $id = $_GET['id'];
    $toolModel = Tools::findModel($id);

    if ($model->load(Yii::$app->request->post())) {
      $date = date('Y-m-d H:i:s');
      $model->eq_id = $_GET['id'];
      $model->wiki_record_create = $date;
      $model->wiki_record_update = $date;
      $model->wiki_created_user = Yii::$app->user->identity->id;
      if ($model->save()) {
        $id = $_GET['id'];
        $list = Wiki::find()->where(['eq_id' => $id])->orderBy('wiki_title')->asArray()->all();
        return $this->render('header', [
          'model' => $model,
          'list' => $list,
        ]);
      }
    }
    return $this->renderAjax('_form', [
      'model' => $model,
    ]);
  }

  public function actionUpdate($page)
  {
    $model = Wiki::findModel($page);
    $id = $_GET['id'];
    $toolModel = Tools::findModel($id);

    if ($model->load(Yii::$app->request->post())) {
      $date = date('Y-m-d H:i:s');
      $model->wiki_record_update = $date;
      if ($model->save()) {
        $id = $_GET['id'];
        $list = Wiki::find()->where(['eq_id' => $id])->orderBy('wiki_title')->asArray()->all();
        return $this->render('header', [
          'model' => $model,
          'list' => $list,
        ]);
      }
    }
    return $this->renderAjax('update', [
      'model' => $model,
    ]);
  }

  public function actionView($page)
  {
    if ($page) {
      $id = $_GET['id'];
      $toolModel = Tools::findModel($id);
      $wikiPage = Wiki::findOne($page);
      $list = Wiki::find()->where(['eq_id' => $id])->orderBy('wiki_title')->asArray()->all();
      return $this->renderAjax('header', [
        'model' => $wikiPage,
        'list' => $list,
      ]);
    }
    return false;
  }


  public function actionDeletePage($page)
  {
    $toolId = $_GET['id'];
    if ($page) {
      $wiki = Wiki::findModel($page);
      if ($wiki->delete()) {
        Yii::$app->session->setFlash('success', 'Страница удалена');
        return $this->redirect(['tool/' . $toolId . '/wiki/index']);
      }
      Yii::$app->session->setFlash('error', 'Удалить страницу не удалось');
      return $this->redirect(['tool/' . $toolId . '/wiki/index']);

    }
    return false;
  }



}