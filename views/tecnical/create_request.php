<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\RequestTec;
use app\models\Works;
use app\models\Tecnical;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\RequestTec */
/* @var $form ActiveForm */
?>
<style>
.summary {text-align: right;}
.grid-view {text-align: center;}
.create_obj a {    
    background: #18a0fb;
    border-radius: 6px;
    margin-right: 8px;
    padding: 10px 18px;
    font-size:16px;
    color: #fff;}
.create_obj a:hover {    
    background: #678ea9;
}
.inside td,th{ border:1px solid black;padding:10px;}
.inside {width:100%;margin:auto;}
.inside th{background:#eeeeee}
</style>
<div class="create_obj">
    <a href="list?id_work=<?php echo $wmodel->id;?>">Назад</a>
</div>
<h2 align=center>Параметры работы</h2>
<?php $form = ActiveForm::begin();
    $workName=$wmodel::find_all_name_work();
    $sp_status=Tecnical::find_stat(); ?>
<table style="width:60%;margin:auto;">
    <tr>
        <td colspan=2><?= $form->field($wmodel, 'type_work')->dropDownList($workName,['disabled' => 'disabled']); ?></td>
       
    </tr>
    <tr>
        <td><?= $form->field($wmodel, 'date_begin')->textInput(['disabled' => 'disabled']); ?></td>
        <td><?= $form->field($wmodel, 'date_end')->textInput(['disabled' => 'disabled']); ?></td>
    </tr>
    <?php
    $bmodel=$wmodel->find_all_tec($wmodel->id);
    foreach($bmodel as $b)
        $list_t[$b['id']]=$b['name'];
    $list_status=$model->list_status();
    ?>
</table>    
<h2 align=center>Параметры запроса</h2>

<div style="width:60%; margin:auto;">
        <?= $form->field($model, 'id_tec')->dropDownList($list_t); ?>
        <?= $form->field($model, 'status')->dropDownList($list_status); ?>
     <div style="display:flex;width:100%">
     <?= $form->field($model, 'date_begin')->widget(DatePicker::className(),[
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
]);?>	&#8195;	&#8195;
        <?= $form->field($model, 'date_end')->widget(DatePicker::className(),[
    'name' => 'date_end',
    'options' => ['placeholder' => 'Ввод даты начала...'],
   // 'convertFormat' => true,
    'language' => 'ru',
    'value'=> date("Y-m-d",(integer) $model->date_end),
    'pluginOptions' => [
        'format' => 'yyyy-mm-dd',
        'autoclose'=>true,
        'weekStart'=>1, //неделя начинается с понедельника
        'startDate' => '2015-01-01', //самая ранняя возможная дата
    ]
]);?></div>
        <?php $res=$model->find_result(($model->result>0)?$model->result:1);?>
        <?= $form->field($model, 'result')->textInput(['value'=>$res,'disabled' => 'disabled']); ?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
        </div>
</div>
    <?php ActiveForm::end(); ?>

</div><!-- tecnical-create_request -->
