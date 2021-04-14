<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use app\models\RequestTec;
use app\models\Works;
use app\models\Tecnical;

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
    text-decoration:none;
}
.little_obj a {    
    color: #fff;
    background-color: #5fe85f;
    padding: 8px;
    margin: 2px;
    border-radius: 5px;}
.little_obj a:hover {    
    background: #328432;
    text-decoration:none;
}
.inside td,th{ border:1px solid black;padding:10px;}
.inside {width:100%;margin:auto;}
.inside th{background:#eeeeee}
</style>
<div class="create_obj">
    <a href="/stroika/web/reestr/tec">Назад</a>
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
    <tr><td colspan=2>
        <h3 align=center>Список техники</h3>
        <table class="inside">
        <tr><th>Тип техники</th><th></th></tr>
    <?php
    $bmodel=$wmodel->find_all_tec($wmodel->id);
    foreach($bmodel as $bb)
        echo '<tr><td>'.$bb['name'].'</td>

                    <td style="text-align:center;"><div class="little_obj">
                            <a href="create_request?id_work='.$wmodel->id.'&id_tec='.$bb['id'].'">Создать запрос</div></td></tr>';
    ?>
    </table></td></tr>
</table>    
<h2>Список запросов</h2><br>
<div class="create_obj">
    <a href="create_request?id_work=<?php echo $wmodel->id;?>">Создать запрос</a>
</div>
<br>
<?php
$searchModel = $recmodel;
    $dataProvider = $searchModel->search(Yii::$app->request->get());
    $stat=$recmodel->list_status();
    $sogl=['0'=>'На рассмотрении','1'=>'Согласовано'];

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => '<div class="summary">Отображается  {begin} из {end}</div>',
        'columns' => [
            
            [
                'attribute'=>'name_tec',
                'format' => 'raw',
                 'value' => function ($data) {
                    return Html::a($data['rec_tec']['tec_name']['name'],'/stroika/web/tecnical/create_request?id='.$data->id);
                }
            ],
            [
                'attribute'=>'begin_tec',
                'format' => 'raw',
                 'value' => function ($data) {
                        return $data['rec_tec']['date_begin'];
                }
            ],
            [
                'attribute'=>'end_tec',
                'format' => 'raw',
                 'value' => function ($data) {
                        return $data['rec_tec']['date_end'];
                }
            ],
            [
                'attribute'=>'status',
                'filter' => $stat,
                'value' => function ($data) {
                    $rows = (new \yii\db\Query())
                    ->select('name')
                    ->from('_status_request')
                    ->where('id='.$data->status)
                    ->one();
                    return $rows['name'];
                }
            ],
            [
                'attribute'=>'result',
                'filter' => $stat,
                'value' => function ($data) {
                    $rows = (new \yii\db\Query())
                    ->select('name')
                    ->from('_status_tec')
                    ->where('id='.$data->status)
                    ->one();
                    return $rows['name'];
                }
            ],
            
        ],
    ]);

?>
    <?php ActiveForm::end(); ?>


