<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<style>
.navbar-inverse .navbar-brand {
    color: #f9f9f9;
    font-weight: bold;
    font-size: 20px;}
.navbar-inverse {
    background-color: #1c1b52;}
.navbar-inverse .navbar-nav > .active > a, .navbar-inverse .navbar-nav > .active > a:hover, .navbar-inverse .navbar-nav > .active > a:focus {
    color: #000;
    background-color: #ffffff;
    font-size: 20px;
    font-weight: bold;
    border-radius: 5px;}
.navbar-inverse .navbar-nav > li > a {
    color: #fff;
    font-size: 20px;
    font-weight: bold;
}
</style>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            
            Yii::$app->user->isGuest ?
                ['label' => 'Регистрация', 'url' => ['/site/signup']] :(Yii::$app->user->identity->login==2?
                ['label' => 'Планирование работ', 'url' => ['/reestr/plan']] :['label' => 'Учет объектов', 'url' => ['/reestr/list']]),
                Yii::$app->user->isGuest ?
                ['label' => '', 'url' => ['/site/index']]:
                (Yii::$app->user->identity->login==2?
                ['label' => 'Запрос техники', 'url' => ['/reestr/tec']]:['label' => '', 'url' => ['/site/index']]),
                 Yii::$app->user->isGuest ?
            ['label' => 'Войти', 'url' => ['/site/login']] :
            ['label' => 'Выйти (' . Yii::$app->user->identity->username .')' , 'url' =>['/site/logout']],
           /* ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'About', 'url' => ['/site/about']],
            ['label' => 'Contact', 'url' => ['/site/contact']],*/
            /*Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )*/
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
