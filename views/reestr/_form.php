<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\jui\AutoComplete;
use app\models\Houses;
use app\models\Briges;
use app\models\Reestr;

?>
<?php $types=$model->listType();
if(!isset($model->date_begin)) {
    $model->date_begin = date("Y-m-d");
    $model->plan_date_end = date("Y-m-d");
};
$listfio=$model->list_fio();
$status=$model->list_status();
$sp_uch=['0'=>'','1'=>'Участок 1','2'=>'Участок 2'];
$isDone=Reestr::has_work($model->id);
?>
<div class="reestr-form">

    <?php $form = ActiveForm::begin(); ?>
<table>
    <tr><td <?php if($isDone>0) echo " onclick='nop()'";?>>
    <?php echo $form->field($model, 'name')->textInput($isDone>0?['disabled'=>'true']:['maxlength' => true]);
    
    echo '</td><td '.($isDone>0?"onclick='nop()'":'').'>'.$form->field($model, 'type')->dropDownList($types,$isDone>0?['disabled'=>'true']:['maxlength' => true]);
    echo '</td></tr><tr><td '.($isDone>0?"onclick='nop()'":'').'>'.$form->field($model, 'id_distr')->dropDownList($sp_uch,$isDone>0?['disabled'=>'true']:['maxlength' => true]);
    echo '</td><td '.($isDone>0?"onclick='nop()'":'').'>'.$form->field($model, 'tab')->widget(\yii\jui\AutoComplete::classname(), 
    [ 'options' => $isDone>0?['disabled'=>'true','class' => 'form-control']:['class' => 'form-control'],
      'clientOptions' => ['source' => $listfio,
         'autoFill' => true,
          'minLength' => '2',
           'style' => 'font-size: 0.8em',
           ]
    ]);         
    echo  '</td></tr><tr><td '.($isDone>0?"onclick='nop()'":'').'>'.$form->field($model, 'date_begin')->widget(DatePicker::className(),[
    'name' => 'date_begin',
    'options' => $isDone>0?['disabled'=>'true']:['placeholder' => 'Ввод даты начала...'],
   // 'convertFormat' => true,
    'language' => 'ru',
    'value'=> date("Y-m-d",(integer) $model->date_begin),
    'pluginOptions' => [
        'format' => 'yyyy-mm-dd',
        'autoclose'=>true,
        'weekStart'=>1, //неделя начинается с понедельника
        'startDate' => '2015-01-01', //самая ранняя возможная дата
    ]
]);
echo  '</td><td>'.$form->field($model, 'plan_date_end')->widget(DatePicker::className(),[
    'name' => 'plan_date_end',
    'options' => ['placeholder' => 'Ввод плановой даты окончания...'],
   // 'convertFormat' => true,
    'language' => 'ru',
    'value'=> date("Y-m-d",(integer) $model->plan_date_end),
    'pluginOptions' => [
        'format' => 'yyyy-mm-dd',
        'autoclose'=>true,
        'weekStart'=>1, //неделя начинается с понедельника
        'startDate' => '2015-01-01', //самая ранняя возможная дата
    ]
]); ?>
    
<?php
echo '</td></tr><tr><td colspan=2 '.($isDone>0?"onclick='nop()'":'').'>'.
    $form->field($model, 'status')->dropDownList($status,$isDone>0?['disabled'=>'true']:['maxlength' => true]).'<td></tr>';
?>
</table>
<?php 
if(!$model->isNewRecord) {
    echo '<h2>Параметры объекта</h2>';
    echo '<table style="width:50%;"><tr><td>';
    $v=['1'=>'_houses','2'=>'_villages','3'=>'_plants','4'=>'_briges','5'=>'_roads','6'=>'_military'];
    echo $this->render($v[$model->type], ['id_reestr' => $model->id]);
    echo '</td></tr></table><br>';
};?>
    <?php if($model->isNewRecord)
    echo '<div class="form-group">
        '.Html::submitButton(($model->isNewRecord?'Создать':'Сохранить'), ['class' => 'btn btn-success'])
        .'</div>';?>

    <?php ActiveForm::end(); ?>

</div>
<script>
    function nop() {
        alert("Работы уже ведутся. Менять параметры запрещено.");
    }
</script>