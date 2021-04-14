<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

?>
<div class="tecnical-update">
<h2>Формирование запроса</h2>
    <?php $form = ActiveForm::begin();
    $sp_tec=$model->find_tec($type_works);
    $sp_status=$model->find_stat(); ?>
<table>
    <tr>
        <td><?= $form->field($model, 'type')->dropDownList($sp_tec,['disabled' => 'disabled']); ?></td>
        <td><?= $form->field($model, 'status_name')->dropDownList($sp_status,['disabled' => 'disabled']); ?></td>
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
    <tr>
        <td colspan=2><?= $form->field($recmodel, 'status')->dropDownList($recmodel->list_status())->label('Статус запроса'); ?></td>
    </tr>    
        
</table>    
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- tecnical-update -->
