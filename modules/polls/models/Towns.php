<?php

namespace app\modules\maps\models;

use Yii;
use creocoder\nestedsets\NestedSetsBehavior;
use yii\web\NotFoundHttpException;

use app\base\MHelper;
use app\base\NestedSetsTreeBehavior;


class Towns extends \yii\db\ActiveRecord
{
  public function behaviors()
  {
    return [
      'tree' => [
        'class' => NestedSetsBehavior::className(),
        'treeAttribute' => 'root',
        'leftAttribute' => 'lft',
        'rightAttribute' => 'rgt',
        'depthAttribute' => 'lvl',
      ],
      'htmlTree' => [
        'class' => NestedSetsTreeBehavior::className(),
        'depthAttribute' => 'lvl'
      ]
    ];
  }

  public function __construct()
  {
    $this->id = MHelper::generateId();
  }

  public function transactions()
  {
    return [
      self::SCENARIO_DEFAULT => self::OP_ALL,
    ];
  }

  public static function tableName()
  {
    return 'poll_towns_tbl';
  }

  public static function find()
  {
    return new RegionsQuery(get_called_class());
  }

  public static function findModel($id)
  {
    if (($model = Towns::findOne($id)) !== null) {
      return $model;
    }
    throw new NotFoundHttpException('Запрашиваемая страница не существует.');
  }

  public function getParentDistrict()
  {
    return $this->hasOne(Towns::class, ['id' => 'parent_id']);
  }

  public function getDistrict()
  {
    if($this->parentDistrict){
      return $this->parentDistrict->name;
    } else {
      return '-';
    }
  }

}