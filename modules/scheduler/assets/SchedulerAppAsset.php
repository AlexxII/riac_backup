<?php

namespace app\modules\scheduler\assets;

use yii\web\AssetBundle;

class SchedulerAppAsset extends AssetBundle
{
  public $sourcePath = '@app/modules/scheduler/lib';

  public $css = [
    'css/scheduler_style.css',
    'css/by-calendar.min.css'
  ];

  public $js = [
    'js/scheduler.js',
    'js/by-calendar.min.js',
    'js/languages/bootstrap-year-calendar.ru.js'
  ];
}
