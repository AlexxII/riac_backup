<?php

use yii\helpers\Html;

$this->title = 'Задание на обновление';

$about = "Данный раздел позволяет планировать работу по обновлению сведений об оборудовании с мобильных устройств. Оборудование 
появляется в данном перечне после соответствующих настроек";

?>
<style>
  .app-settings {
    font-weight: 400 !important;
    margin: 12px 0px 0px 30px !important;
  }
  #main-wrap {
    margin-top: 0px !important;
  }
  #main-wrap h3 {
    margin-top: 10px;
  }
</style>


<div class="tool-task">

  <h3><?= Html::encode($this->title) ?>
    <sup class="h-title fa fa-question-circle-o" aria-hidden="true"
         data-toggle="tooltip" data-placement="bottom" title="<?php echo $about ?>"></sup>
  </h3>
  <div class="row">
    <?php foreach ($models as $model): ?>
      <div class="col-sm-6 col-md-4 col-lg-4 task-wrap">
        <div class="thumbnail">
          <div class="caption">
            <span><small><?= $model->toolParents(0) ?></small></span>
            <h4><?= $model->eq_title ?>
              <span class="counter" title="Кол-во изображений" data-toggle="tooltip" data-placement="top">
                <?= $model->countImages ?>
              </span>
            </h4>
            <p><a href="update-ex?id=<?= $model->id ?>" class="btn btn-sm btn-default" role="button">Обновить</a></p>
            <li class="list-group-item" style="margin-bottom: 15px">
              <div class="form-checkbox js-complex-option">
                <label style="font-weight: 500">
                  <input class="ch" id="consolidated-feature" type="checkbox" data-check='consolidated-check'
                         data-id="<?= $model->id ?>" <?php if ($model->settings->eq_task) echo 'checked' ?> > В задании
                  на обновление
                </label>
                <span class="status-indicator"></span>
              </div>
            </li>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

</div>

<script>

  $(document).ready(function () {

    var successCheck = '<i class="fa fa-check" id="consolidated-check" aria-hidden="true" style="color: #4eb305"></i>';
    var warningCheck = '<i class="fa fa-times" id="consolidated-check" aria-hidden="true" style="color: #cc0000"></i>';
    var waiting = '<i class="fa fa-cog fa-spin" aria-hidden="true"></i>';
    $('.ch').change(function (e) {
      var csrf = $('meta[name=csrf-token]').attr("content");
      var nodeId = $(this).data('id');
      var result = $(this).is(':checked');
      var parentDiv = $(this).closest('.task-wrap');
      var url = '/equipment/control-panel/settings/task-set';
      var checkId = parentDiv.find('.status-indicator');
      checkId.html(waiting);
      $.ajax({
        url: url,
        type: "post",
        data: {
          _csrf: csrf,
          toolId: nodeId,
          bool: result
        },
        success: function (data) {
          checkId.html(successCheck);
          parentDiv.fadeOut();
        },
        error: function (data) {
          checkId.html(warningCheck);
        }
      });
    })
  })

</script>