<?php 
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use app\models\Reestr;
?>
<style>
.summary {text-align: right;}
</style>

       
</div>
<div class="panel">
<?php if($role!=1)
         echo '<a href="/reestr/plan">Планирование работ</a>
                    </div>
                    <div class="panel"><a href="/reestr/tec">Запрос техники</a>';
?>
</div>
<?php /*
if ($role==1) { echo '<a href="ressert/create">Создать объект</a><br><Br>';
   /* $dataProvider = new ActiveDataProvider([
        'query' => Reestr::find(),
        'pagination' => [
            'pageSize' => 20,
        ],
    ]);*/
  /*  $searchModel = new Reestr();
    $types=$searchModel->listType();
    $dataProvider = $searchModel->search(Yii::$app->request->get());
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'name',
                'format' => 'text'
            ],
            [
                'attribute' => 'date_begin',
                'format' => ['date', 'php:Y-m-d']
            ],
            [
                'attribute' => 'plan_date_end',
                'format' => ['date', 'php:Y-m-d']
            ],
            [
                'attribute' => 'type',
                'filter' => $types,
                
                //'filterInputOptions' => ['prompt' => 'All educations', 'class' => 'form-control', 'id' => null]
            ],
            ['class' => 'yii\grid\ActionColumn',
            ]
        ],
    ]); 
};*/

?>