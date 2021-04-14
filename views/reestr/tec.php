<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use app\models\RequestTec;
use app\models\Works;
use app\models\Tecnical;

/* @var $this yii\web\View */
/* @var $model app\models\Reestr */
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
</style>
<h1 align=center>Запрос техники</h1>

<br><Br>
    <?php //$form = ActiveForm::begin(); ?>
<?php 
    $searchModel = new Works;
    $dataProvider = $searchModel->search_2(Yii::$app->request->get());
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => '<div class="summary">Отображается  {begin} из {end}</div>',
        'columns' => [
             [
                'attribute'=>'name_reestr',
                'format' => 'raw',
                 'value' => function ($data) {
                        return $data['list_reestr']['name'];
                }
            ],
            [
                'attribute' => 'name_work',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a($data['name_type_work']['name'],'/stroika/web/tecnical/list?id_work='.$data->id);
                },
            ],
            [
                'attribute' => 'date_begin',
                'format' => ['date', 'php:Y-m-d']
            ],
            [
                'attribute' => 'date_end',
                'format' => ['date', 'php:Y-m-d']
            ],
            [
                'label' => 'Техника',
                'value'=>function($data){
                    $rows = (new \yii\db\Query())
                    ->select('count(id) as cou')
                    ->from('tecnical')
                    ->where('id_works='.$data->id)
                    ->groupBy('id_works')
                    ->one();
                    return (($rows['cou']>0)?'Прикреплена':'-');
                }
            ],
            
            ['class' => 'yii\grid\ActionColumn','template' => '{update}',
            'urlCreator' => function ($action, $model, $key, $index) {
                if ($action === 'update') {
                    $url ='/stroika/web/tecnical/list?id_work='.$model->id;
                    return $url;
                }
              }
            ]
        ],
    ]); 
?>
    <?php //ActiveForm::end(); ?>


