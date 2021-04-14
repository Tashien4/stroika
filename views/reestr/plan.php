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
</style>
<h1 align=center>Планирование работ</h1>
<br><Br>
<?php

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
                    return Html::a($data->name,'works?id='.$data->id);
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
            ['class' => 'yii\grid\ActionColumn',
            'buttons' => [
                'update' => function ($url, $model) {
                    return Html::a('План работ', $url);
                },
            ],
            'template' => '{update}',
              'urlCreator' => function ($action, $model, $key, $index) {
                if ($action === 'update') {
                    $url ='works?id='.$model->id;
                    return $url;
                }
              }
            ]
        ],
    ]); 


?>
