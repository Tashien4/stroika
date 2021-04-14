<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\jui\AutoComplete;
use yii\data\ActiveDataProvider;
use app\models\Works;
use yii\grid\GridView;
?>
<style>
.params {font-size: 25px;
    padding: 10px;
    text-align: center;
    font-weight: bold;
    width: 100%;
    background: linear-gradient( #cec7c7, transparent);
}
.params td {border:1px solid black;}
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
</style>

<div class="reestr-form">
<h2>Параметры объекта</h2>

<table class="params">
    <tr><td>
    <?php echo 'Наименование:'.$model->name.'</td>
    <td>Тип:'.$model->findType($model->type).'</td></tr>
   <tr><td> Дата начала:'.$model->date_begin.
   '</td><td>Плановая дата окончания:'.$model->plan_date_end.
   '</td></tr>
   <tr><td> Участок:'.$model->findDistricts($model->id_distr).
   '</td><td >Статус:'.$model->findStatus($model->status).'</td></tr>';
?>
</table>
<br><Br>
<?php echo $this->render('/works/list', ['id_reestr' => $model->id,
                                        'model'=>$model,
                                        'wmodel'=>$wmodel,
                                        'id_reestr'=>$model->id]);?>
</div>

