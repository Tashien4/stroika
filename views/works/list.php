<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\data\ActiveDataProvider;
use app\models\Works;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Works */
/* @var $form ActiveForm */
?>
    <?php $form = ActiveForm::begin(); ?>
<h2>Планирование работ</h2>
<Br>
<div class="create_obj">
    <a href="/stroika/web/works/create?id_reestr=<?php echo $id_reestr;?>">Добавить тип работы</a>
    </div><br>
<?php $id=$_GET['id'];
    $searchModel=new Works;
    $dataProvider = $searchModel->search(Yii::$app->request->get(),$model->id);
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => '<div class="summary">Отображается  {begin} из {end}</div>',
        'columns' => [
            [
                'attribute' => 'type_work',
                'format' => 'raw',
                'value' => function ($data) {
                    $rows = (new \yii\db\Query())
                    ->select('name')
                    ->from('_type_works')
                    ->where('id='.$data->type_work)
                    ->one();
                    return Html::a($rows['name'],'/stroika/web/works/update?id='.$data->id.'&id_reestr='.$data->id_reestr);
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
                'attribute' => 'list_tec',
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
            [
                'attribute' => 'list_brig',
                'value'=>function($data){
                    $rows = (new \yii\db\Query())
                    ->select('count(id) as cou')
                    ->from('brigads')
                    ->where('id_works='.$data->id)
                    ->groupby('id_works')
                    ->one();
                    return (($rows['cou']>0)?'Прикреплены':'-');
                }
            ],
            ['class' => 'yii\grid\ActionColumn','template' => '{update} {delete}','headerOptions'=>['style'=>'width:8%;'],
            'urlCreator' => function ($action, $model, $key, $index) {
                if ($action === 'update') {
                    $url ='/stroika/web/works/update?id='.$model->id.'&id_reestr='.$model->id_reestr;
                    return $url;
                }
                if ($action === 'delete') {
                    $url ='/stroika/web/works/delete?id='.$model->id;
                    return $url;
                }
              }
            ]
        ],
    ]); 

    echo '<div class="form-group">
        '.Html::submitButton('Подтвердить',['class' => 'btn btn-success','name'=>'butn','id'=>'butn'])
        .'</div>';
?>

    <?php ActiveForm::end();?>