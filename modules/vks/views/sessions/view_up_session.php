<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\tehdoc\asset;
use yii\widgets\DetailView;

?>

<style>
  #w0 td {
    text-align: center;
  }
  .h-title {
    font-size: 18px;
    color: #1e6887;
  }
  table.detail-view th {
    width: 40%;
  }

</style>

<div class="">
  <div class="container-fluid col-lg-7 col-md-7">
    <?= DetailView::widget([
      'model' => $model,
      'attributes' => [
        [
          'label' => 'Дата проведения ВКС:',
          'value' => date('d.m.Y', strtotime($model->vks_date)) . ' г.'
        ],
        'vks_teh_time_start',
        'vks_work_time_start',
        [
          'label' => 'Тип сеанса ВКС:',
          'value' => $model->type
        ],
        [
          'label' => 'Студия проведения ВКС:',
          'value' => $model->place
        ],
        [
          'label' => 'Абонент:',
          'value' => $model->subscriber
        ],
        [
          'label' => 'Распоряжение:',
          'value' => $model->order
        ],
        [
          'label' => 'Принявший сообщение:',
          'value' => $model->vks_employee_receive_msg
        ],
        [
          'label' => 'Дата сообщения:',
          'value' => date('d.m.Y', strtotime($model->vks_receive_msg_datetime)) . ' г.'
        ],
        [
          'label' => 'Передавший сообщение:',
          'value' => $model->sendMsg
        ],
        'vks_comments',
        'vks_record_create',
        'vks_record_update'
      ]
    ]) ?>
  </div>

  <div class="vks-log col-lg-5 col-md-5">
    <?php
    foreach ($logs as $log) {
      if ($log->status == 'danger') {
        $info = 'alert-danger';
      } else {
        $info = 'alert-info';
      }
      echo '<div class="alert ' . $info . '" role="alert" style="margin-bottom: 10px">';
      echo '<div class="clock" style="font-size: 12px">';
      echo '<i class="fa fa-clock-o" aria-hidden="true"></i>';
      echo ' ';
      echo date('d.m.Y', strtotime($log->log_time)) . ' ' . date('H:i.s', strtotime($log->log_time));
      echo '</div>';
      echo " Пользователь: " . '<strong>' . $log->userName . '</strong>';
      echo '<br>';
      echo $log->log_text;
      echo '</div>';
    }
    ?>
  </div>

</div>
<br>

<script>
  $(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>


