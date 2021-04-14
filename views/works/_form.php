<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\jui\AutoComplete;
use app\models\Works;
use app\models\Tecnical;
use app\models\Brigads;

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
.create_mod{    
    background: #18a0fb;
    border-radius: 6px;
    margin-right: 8px;
    padding: 10px 18px;
    font-size:16px;
    color: #fff;
    display: inline-block;}
.create_mod:hover {    
    background: #678ea9;
    display: inline-block;
}
.close,.close_2{
    cursor: pointer;
    position: absolute;
    right: 15px;
    text-align: center;
    top:15px;
}
.modal_1,.modal_2{
    background-color: white;
    display: none;
    height: 300px;
    left:50%;
    margin-left: -200px;
    margin-top:-150px;
    position: fixed;
    top:50%;
    width: 400px;
    z-index: 1000;
}
.overlay_1,.overlay_2{
    background-color: black;
    bottom:0;
    display: none;
    left:0;
    margin: 0;
    opacity: 0.65;
    position: fixed;
    top:0;
    right: 0;
    z-index: 999;
}
</style>
<?php 
if(!isset($model->date_begin)) {
    $model->date_begin = date("Y-m-d");
    $model->date_end = date("Y-m-d");
};
?>

<div class="reestr-form">

    <?php $form = ActiveForm::begin(); ?>

<table style="width: 50%;margin:auto;">
    <tr><td colspan=2>
    <?php
    $list_tec=0; 
    $list_brig=0; 
    $id_reestr=$_GET['id_reestr'];
    $types=Works::list_types($id_reestr);
    echo $form->field($model, 'type_work')->dropDownList($types);
    
    
    echo  '</td></tr>
    <tr><td>'.$form->field($model, 'date_begin')->widget(DatePicker::className(),[
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
]);
echo  '</td><td>'.$form->field($model, 'date_end')->widget(DatePicker::className(),[
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
]); ?>
</td></tr>
<tr><td colsan=2>
    <?php echo Html::submitButton(($model->isNewRecord?'Создать':'Сохранить'), ['class' => 'btn btn-success','name'=>'works']);?></td></tr>
</table>

<?php if(!$model->isNewRecord) {
    echo '
<table style="width:100%">
<tr><th style="font-size:25px;border:0px;">Список техники<br><br></th>
    <th style="font-size:25px;border:0px;">Список бригад<br><br></th></tr> 
<tr><td>
    <div class="create_mod" id="show_1">Добавить технику</div>
        <div class="overlay_1"></div>';
    echo '<div class="modal_1"><div ><h2>&#8195;Добавление техники</h2></div>
            <span class="close">X</span><br>
            <div style="padding:10px 20px;">';
    $tmodel = new Tecnical();
    echo $this->render('add_tec',['form'=>$form,'id_works'=>$model->id,'model' => $tmodel,'type_works' => $model->type_work]).'
            </div>
    </div>';
    echo '<td><div class="create_mod" id="show_2">Добавить бригаду</div>
    <div class="overlay_2"></div>';
    echo '<div class="modal_2"><div ><h2>&#8195;Добавление бригады</h2></div>
    <span class="close_2">X</span><br>
    <div style="padding:10px 20px;">';
    $bmodel = new Brigads();
    echo $this->render('add_brig',['form'=>$form,'id_works'=>$model->id,'model' => $bmodel,'type_works' => $model->type_work]).'
            </div>
    </div>';
    echo '</td></tr><tr><td>';
    echo $this->render('_list_tec',['id_works'=>$model->id,'model'=>$model]);
    echo '</td><td>';
    echo $this->render('_list_brig',['id_works'=>$model->id,'model'=>$model]);
    echo '</td></tr>';}?>
    </table>
    <?php ActiveForm::end(); ?>

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script>
$(document).ready(function () {

    $('#show_1').on('click',
            function () {
                $('.overlay_1,.modal_1').show();
            }
    );

    $('.overlay_1,.close').on('click',function(){
        $('.overlay_1,.modal_1').hide();
    });

        $('#show_2').on('click',
            function () {
                $('.overlay_2,.modal_2').show();
            }
    );

    $('.overlay_2,.close_2').on('click',function(){
        $('.overlay_2,.modal_2').hide();
    });
});
</script>