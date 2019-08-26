<?php

namespace app\modules\scheduler\models;

use app\base\MHelper;


class Event extends \yii\db\ActiveRecord
{
  public static function tableName()
  {
    return 'calendar_events_tbl';
  }

  public function __construct()
  {
    $this->id = MHelper::generateId();
  }

  public function attributeLabels()
  {
    return [
      'id' => 'ID',
      'start_date' => 'Дата начала:',
      'end_date' => 'Дата окончания:',
      'title' => 'Наименование:',
      'description' => 'Описание:',
      'color' => 'Цвет события:'
    ];
  }

  public function rules()
  {
    return [
      [['start_date', 'end_date', 'title'], 'required'],
      [['description'], 'string'],
    ];
  }

  public function getColorList()
  {
/*    return [
      '#7bd148' => 'Зеленый',
      "#5484ed" => 'Темно-синий',
      "#a4bdfc" => 'Синий',
      "#46d6db" => 'Бирюзовый',
      "#7ae7bf" => 'Светло-зеленый',
      "#51b749" => 'Темно-зеленый',
      "#fbd75b" => 'Желтый',
      "#ffb878" => 'Оранжевый',
      "#ff887c" => 'Красный',
      "#dc2127" => 'Темно-красный',
      "#dbadff" => 'Фиолетовый',
      "#9b9820" => 'ИАД'

    ];*/
    return [
      '#d50000' => 'Помидор',
      "#e67c73" => 'Фламинго',
      "#f4511e" => 'Мандарин',
      "#f6bf26" => 'Банан',
      "#33b679" => 'Шалфей',
      "#0b8043" => 'Базилик',
      "#039be5" => 'Павлин',
      "#3f51b5" => 'Черника',
      "#7986cb" => 'Лаванда',
      "#8e24aa" => 'Виноград',
      "#616161" => 'Графит',
      "#9b9820" => 'Кака'

    ];

    #d50000

  }

}