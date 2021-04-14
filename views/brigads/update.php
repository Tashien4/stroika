<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Tecnical;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Brigads */
/* @var $form ActiveForm */
?>
<div class="brigads-update">

    <?php $form = ActiveForm::begin(); ?>
    <?php $form = ActiveForm::begin();
    $sp_brig=$model->find_brig($type_works);
    $sp_status=Tecnical::find_stat(); ?>
<table>
    <tr>
        <td><?= $form->field($model, 'type')->dropDownList($sp_brig); ?></td>
        <td><?= $form->field($model, 'status_name')->dropDownList($sp_status); ?></td>
    </tr>
    <tr>
        <td><?= $form->field($model, 'date_begin')->widget(DatePicker::className(),[
    'name' => 'date_begin',
    'options' => ['placeholder' => 'Ввод даты начала...'],
   // 'convertFormat' => true,
    'language' => 'ru',
    'value'=> date("Y-m-d",(integer) $model->date_begin),
    'pluginOptions' => [
        'format' => 'yyyy-mm-dd',
        'autoclose'=>true,
        'weekStart'=>1, //неделя начинается с понедельника
        'startDate' => '2015-01-01', //самая ранняя возможная дата
    ]
]); ?></td>
        <td><?= $form->field($model, 'date_end')->widget(DatePicker::className(),[
    'name' => 'date_end',
    'options' => ['placeholder' => 'Ввод плановой даты окончания...'],
   // 'convertFormat' => true,
    'language' => 'ru',
    'value'=> $model->date_end,
    'pluginOptions' => [
        'format' => 'yyyy-mm-dd',
        'autoclose'=>true,
        'weekStart'=>1, //неделя начинается с понедельника
        'startDate' => '2015-01-01', //самая ранняя возможная дата
    ]
]); ?></td>
    </tr>
        
        
</table>    
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- brigads-update -->
