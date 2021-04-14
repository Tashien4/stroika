<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<?php 
$this->title = 'Регистрация';
$form = ActiveForm::begin();
$sp_list=['0'=>'','1'=>'Начальник управления', '2'=>'Начальник участка','3'=>'Прораб']; ?>
<h1><?= Html::encode($this->title) ?></h1><br>
<?= $form->field($model, 'login') ?>
<?= $form->field($model, 'password')->passwordInput() ?>
<?= $form->field($model, 'role')->dropdownlist($sp_list) ?>
<div class="form-group">
 <div>
 <?= Html::submitButton('Регистрация', ['class' => 'btn btn-success']) ?>
 </div>
</div>
<?php ActiveForm::end() ?>