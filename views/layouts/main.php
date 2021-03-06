<?php

use yii\helpers\Html;
use yii\bootstrap\BootstrapPluginAsset;
use app\assets\AppAsset;
use app\assets\SlidebarsAsset;
use app\assets\JConfirmAsset;

AppAsset::register($this);    // регистрация ресурсов всего приложения
JConfirmAsset::register($this);
//SlidebarsAsset::register($this);
BootstrapPluginAsset::register($this);

$this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
  <meta charset="<?= Yii::$app->charset ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?= Html::csrfMetaTags() ?>
  <title><?= Html::encode($this->title) ?></title>
  <?php $this->head() ?>

</head>

<?php $this->beginBody() ?>
<div id="wait-modal" style="background-color: white;
                opacity: .7; height: 100%; width: 100%; position: fixed; top: 0; left: 0;display: none;z-index: 99"></div>

<!--  Меню на маленьких экранах -->

<div id='small-menu' off-canvas="main-menu left overlay">

</div>

<!--  Навигационная панель  -->

<div id="app-wrap">
  <nav class="navigation navigation-default">
    <div class="container-fluid">
      <ul class="navig navigation-nav" id="left">
        <li class="dropdown visible-xs visible-sm">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
             aria-expanded="false">
            <svg width="24" height="24" viewBox="0 0 24 24">
              <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"></path>
            </svg>
          </a>
          <ul class="dropdown-menu mobile-navigation">

          </ul>
        </li>

        <li><span id="push-it" class="btn btn-default btn-circle btn-ml hidden hidden-xs hidden-sm" aria-hidden="true">
            <svg focusable="false" width="24" height="24" viewBox="0 0 24 24">
              <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"></path>
            </svg>
          </span></li>
        <li id="app-logo" class="navigation-brand hidden-xs hidden-sm">
          <img src="/images/logo.png" style="display:inline">
        </li>
        <li id="app-name">
          <?= $this->title ?>
        </li>
        <li id="left-custom-data" class="hidden-xs hidden-sm">
        </li>
        <li id="left-custom-data-ex" class="hidden-xs hidden-sm">
        </li>
      </ul>
      <ul id="right" class="navig navigation-nav navigation-right">
        <li id="right-custom-data-ex" class="hidden-xs hidden-sm">
        </li>
        <li id="right-custom-data" class="hidden-xs hidden-sm">
        </li>

        <li id="app-control" class="dropdown hidden">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
             aria-expanded="false">
            <svg width="24" height="24" viewBox="0 0 24 24" focusable="false">
              <path d="M13.85 22.25h-3.7c-.74 0-1.36-.54-1.45-1.27l-.27-1.89c-.27-.14-.53-.29-.79-.46l-1.8.72c-.7.26-1.47-.03-1.81-.65L2.2
              15.53c-.35-.66-.2-1.44.36-1.88l1.53-1.19c-.01-.15-.02-.3-.02-.46 0-.15.01-.31.02-.46l-1.52-1.19c-.59-.45-.74-1.26-.37-1.88l1.85-3.19c.34-.62
              1.11-.9 1.79-.63l1.81.73c.26-.17.52-.32.78-.46l.27-1.91c.09-.7.71-1.25 1.44-1.25h3.7c.74 0 1.36.54 1.45 1.27l.27
              1.89c.27.14.53.29.79.46l1.8-.72c.71-.26 1.48.03 1.82.65l1.84 3.18c.36.66.2 1.44-.36 1.88l-1.52 1.19c.01.15.02.3.02.46s-.01.31-.02.46l1.52
              1.19c.56.45.72 1.23.37 1.86l-1.86 3.22c-.34.62-1.11.9-1.8.63l-1.8-.72c-.26.17-.52.32-.78.46l-.27 1.91c-.1.68-.72 1.22-1.46
              1.22zm-3.23-2h2.76l.37-2.55.53-.22c.44-.18.88-.44 1.34-.78l.45-.34 2.38.96 1.38-2.4-2.03-1.58.07-.56c.03-.26.06-.51.06-.78s-.03-.53-.06-.78l-.07-.56
              2.03-1.58-1.39-2.4-2.39.96-.45-.35c-.42-.32-.87-.58-1.33-.77l-.52-.22-.37-2.55h-2.76l-.37 2.55-.53.21c-.44.19-.88.44-1.34.79l-.45.33-2.38-.95-1.39 2.39
              2.03 1.58-.07.56a7 7 0 0 0-.06.79c0 .26.02.53.06.78l.07.56-2.03 1.58 1.38 2.4 2.39-.96.45.35c.43.33.86.58 1.33.77l.53.22.38 2.55z"></path>
              <circle cx="12" cy="12" r="3.5"></circle>
            </svg>
          </a>
          <ul id="app-control-ul" class="dropdown-menu">

          </ul>
        </li>
        <li id="app-notification" class="hidden-xs hidden-sm">
          <a href="#" role="button" class="dropdown-toggle" aria-hidden="true">
            <svg viewBox="0 0 16 16" width="24" height="24" aria-hidden="true">
              <path fill-rule="evenodd" d="M14 12v1H0v-1l.73-.58c.77-.77.81-2.55 1.19-4.42C2.69 3.23 6 2 6 2c0-.55.45-1
              1-1s1 .45 1 1c0 0 3.39 1.23 4.16 5 .38 1.88.42 3.66 1.19 4.42l.66.58H14zm-7 4c1.11 0 2-.89 2-2H5c0 1.11.89 2 2 2z">
              </path>
            </svg>
          </a>
        </li>
        <li id="apps" class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
             aria-expanded="false">
            <svg width="24" height="24" viewBox="0 0 24 24">
              <path d="M6,8c1.1,0 2,-0.9 2,-2s-0.9,-2 -2,-2 -2,0.9 -2,2 0.9,2 2,2zM12,20c1.1,0 2,-0.9 2,-2s-0.9,-2 -2,-2 -2,0.9 -2,2 0.9,2
              2,2zM6,20c1.1,0 2,-0.9 2,-2s-0.9,-2 -2,-2 -2,0.9 -2,2 0.9,2 2,2zM6,14c1.1,0 2,-0.9 2,-2s-0.9,-2 -2,-2 -2,0.9 -2,2 0.9,2
              2,2zM12,14c1.1,0 2,-0.9 2,-2s-0.9,-2 -2,-2 -2,0.9 -2,2 0.9,2 2,2zM16,6c0,1.1 0.9,2 2,2s2,-0.9 2,-2 -0.9,-2 -2,-2 -2,0.9
              -2,2zM12,8c1.1,0 2,-0.9 2,-2s-0.9,-2 -2,-2 -2,0.9 -2,2 0.9,2 2,2zM18,14c1.1,0 2,-0.9 2,-2s-0.9,-2 -2,-2 -2,0.9 -2,2 0.9,2
              2,2zM18,20c1.1,0 2,-0.9 2,-2s-0.9,-2 -2,-2 -2,0.9 -2,2 0.9,2 2,2z">
              </path>
            </svg>
          </a>
          <ul class="dropdown-menu navig">
            <div class="list-group">
              <a href="/vks" class="list-group-item">
                <h4 class="list-group-item-heading">Журнал ВКС</h4>
                <p class="list-group-item-text">Журнал сеансов видеосвязи</p>
              </a>
            </div>
            <div class="list-group">
              <a href="/scheduler" class="list-group-item">
                <h4 class="list-group-item-heading">Календарь</h4>
                <p class="list-group-item-text">Календарь</p>
              </a>
            </div>
            <div class="list-group">
              <a href="/equipment" class="list-group-item">
                <h4 class="list-group-item-heading">Техника</h4>
                <p class="list-group-item-text">Перечень оборудования</p>
              </a>
            </div>
            <div class="list-group">
              <a href="/to" class="list-group-item">
                <h4 class="list-group-item-heading">ТО</h4>
                <p class="list-group-item-text">Техническое обслуживание</p>
              </a>
            </div>
            <div class="list-group">
              <a href="/polls" class="list-group-item">
                <h4 class="list-group-item-heading">Опрос</h4>
                <p class="list-group-item-text">Социологические опросы</p>
              </a>
            </div>
            <div class="list-group">
              <a href="/maps" class="list-group-item">
                <h4 class="list-group-item-heading">Карты</h4>
                <p class="list-group-item-text">Карта России</p>
              </a>
            </div>
          </ul>
        </li>
        <li id="accounts" class="dropdown">
          <?php if (Yii::$app->user->isGuest): ?>
            <a href="/site/login" role="button" aria-haspopup="true" title="Войти">
              <svg height="24" width="24" viewBox="0 0 1792 1792" style="fill:#000">
                <path d="M1312 896q0 26-19 45l-544 544q-19 19-45 19t-45-19-19-45v-288h-448q-26 0-45-19t-19-45v-384q0-26
            19-45t45-19h448v-288q0-26 19-45t45-19 45 19l544 544q19 19 19 45zm352-352v704q0 119-84.5 203.5t-203.5
            84.5h-320q-13 0-22.5-9.5t-9.5-22.5q0-4-1-20t-.5-26.5 3-23.5 10-19.5 20.5-6.5h320q66 0
            113-47t47-113v-704q0-66-47-113t-113-47h-312l-11.5-1-11.5-3-8-5.5-7-9-2-13.5q0-4-1-20t-.5-26.5 3-23.5 10-19.5
            20.5-6.5h320q119 0 203.5 84.5t84.5 203.5z"/>
                </path>
              </svg>
            </a>
          <?php else: ?>
            <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
               aria-expanded="false">
              <svg class="rui-ToplineUser-userIcon" viewBox="0 0 16 16" width="24" height="24">
                <path d="M14 12.197c0-.66-.205-1.311-.614-1.829a7.536 7.536 0 0 0-2.734-2.164 4.482 4.482 0 0 1-6.304 0
              7.536 7.536 0 0 0-2.734 2.164A2.947 2.947 0 0 0 1 12.197V13a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-.803zM4.5 5c0
              1.654 1.346 3 3 3s3-1.346 3-3V3c0-1.654-1.346-3-3-3s-3 1.346-3 3v2zM0 15V0v15zM15 0v15V0z">
                </path>
              </svg>
            </a>
            <ul class="dropdown-menu">
              <div class="list-group">
                <a href="" class="list-group-item ex-click" data-url="/admin/user/profile"
                   data-uri="/admin/user/profile">
                  <h4 class="list-group-item-heading">Профиль</h4>
                  <p class="list-group-item-text"><?= Yii::$app->user->identity->username ?></p>
                </a>
              </div>
              <div class="list-group">
                <a id="logout" data-href="/site/logout" class="list-group-item">
                  <p class="list-group-item-text">Выход</p>
                </a>
              </div>
            </ul>
          <?php endif; ?>
        </li>
      </ul>
    </div>
  </nav>


  <div id="main-wrap">

    <!--  Основное навигационное меню слева -->
    <div id="left-side">

    </div>
    <div id="main-content" class="container">

      <?= $content ?>
    </div>
  </div>

</div>

<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>


<script>
  $(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();

    $('#push-it').bind('click', clickMenu);

    $('#logout').on('click', function (e) {
      var url = $(this).data('href');
      $.post(url);
    })
  });

  $(document).on('click', '.jclick', loadControls);

  $(document).on('click', '.ex-click', function (e) {
    e.preventDefault();
    jc = $.confirm({
      icon: 'fa fa-cog fa-spin',
      title: 'Подождите!',
      content: 'Ваш запрос выполняется!',
      buttons: false,
      closeIcon: false,
      confirmButtonClass: 'hide'
    });
    var url = $(this).data('url');
    var bUrl = $(this).data('back-url');
    loadExContent(url, bUrl, jc);
  });

</script>