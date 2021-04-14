<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use app\models\Reestr;

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
.action-column th{width: 5% i !important;}
</style>

<br><Br>
<?php
echo '<div class="create_obj">
    <a href="create">Создать новый объект</a>
    </div><br><Br>';

    $searchModel = new Reestr();
    $types=$searchModel->listType();
    $status=$searchModel->list_status();
    $dataProvider = $searchModel->search(Yii::$app->request->get());
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => '<div class="summary">Отображается  {begin} из {end}</div>',
        'columns' => [
            
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a($data->name,'update?id='.$data->id);
                },
            ],
            [
                'attribute' => 'type',
                'filter' => $types,
                'value'=>function($data){
                    $rows = (new \yii\db\Query())
                    ->select('name')
                    ->from('type_object')
                    ->where('id='.$data->type)
                    ->one();
                    return $rows['name'];
                }
            ],
            [
                'attribute' => 'status',
                'filter' => $status,
                'value'=>function($data){
                    $rows = (new \yii\db\Query())
                    ->select('name')
                    ->from('_status')
                    ->where('id='.$data->status)
                    ->one();
                    return $rows['name'];
                }
            ],
            [
                'attribute' => 'date_begin',
                'format' => ['date', 'php:Y-m-d']
            ],
            [
                'attribute' => 'plan_date_end',
                'format' => ['date', 'php:Y-m-d']
            ],
            ['class' => 'yii\grid\ActionColumn','template' => '{update}{delete}',
            'buttons'=>[
                'update' => function ($url,$model,$key) {
                            return Html::a('', 'update?id='.$model->id, ['class' => 'glyphicon glyphicon-pencil']);
                        },
                'delete' => function ($url,$model,$key) {
                            return Html::a('', ($model->has_work($model->id))>0?'frozen?id='.$model->id:'delete?id='.$model->id,($model->has_work($model->id))>0?['onclick'=>($model->status<4?'alert("Работы на объекте уже запущены. Замораживаем объект.")':'alert("Невозможно удалить объект. Он хранится для истории")'),'class' => 'glyphicon glyphicon-trash']:['class' => 'glyphicon glyphicon-trash']);
                },         
            ]                       ]
        ],
    ]); 


?>
