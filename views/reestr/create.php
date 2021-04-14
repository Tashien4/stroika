<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Reestr */

$this->title = 'Создание объекта';
$this->params['breadcrumbs'][] = ['label' => 'Reestr', 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reestr-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
