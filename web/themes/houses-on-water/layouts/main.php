<?php
use yii\helpers\Html;
use yii\widgets\Menu;
use yii\widgets\Breadcrumbs;
use yii\debug\Toolbar;

// You can use the registerAssetBundle function if you'd like
//$this->registerAssetBundle('app');
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
<title><?php echo Html::encode($this->title); ?></title>
<meta property='og:site_name' content='<?php echo Html::encode($this->title); ?>' />
<meta property='og:title' content='<?php echo Html::encode($this->title); ?>' />
<meta property='og:description' content='<?php echo Html::encode($this->title); ?>' />

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<link rel='stylesheet' type='text/css' href='<?php echo $this->theme->baseUrl; ?>/files/main_style.css' title='wsite-theme-css' />
<link href='http://fonts.googleapis.com/css?family=Cabin+Condensed:400,700' rel='stylesheet' type='text/css' />
<link href='http://fonts.googleapis.com/css?family=Cutive' rel='stylesheet' type='text/css' />
<link href='http://fonts.googleapis.com/css?family=Anton' rel='stylesheet' type='text/css' />
<?php $this->head(); ?>
</head>
<body class='wsite-theme-light tall-header-page wsite-page-index weeblypage-index'>
<?php $this->beginBody(); ?>
<div id="container">
  <div id="top-section">
    <div id="inner-section">
      <div id="header-container">
        <div id="header-top">
          <Div id="logo">
          <?php echo Html::encode(\Yii::$app->name); ?>
          </div>
          <div id="topnav">
          <?php echo Menu::widget(array(
            'options' => array('class' => 'nav'),
            'items' => array(
             /* array('label' => 'Home', 'url' => array('/site/index')),
              array('label' => 'About', 'url' => array('/site/about')),
              array('label' => 'Contact', 'url' => array('/site/contact')),*/
              Yii::$app->user->isGuest ?
                array('label' => 'Войти', 'url' => array('/site/login')) :
                array('label' => 'Выйти (' . Yii::$app->user->identity->username .')' , 'url' => array('/site/logout')),
   
              Yii::$app->user->isGuest ?
                array('label' => 'Регистрация', 'url' => array('/site/signup')) :array('label' => '', 'url' => array('/site/index')),
            ),
        )); ?> 
            <div style="clear:both"></div>
          </div>
        </div>
      </div>
      <div id="main">
        <div id="content"><div id='wsite-content' class='wsite-not-footer'>
          <?php echo $content; ?>
</div>
</div>
      </div>
      
</div>
    </div>
  </div>
</div>

<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>