<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\data\ActiveDataProvider;
use app\models\Tecnical;
use yii\grid\GridView;

?>
<?php ?>
<?php $sp_tec=$model->find_tec($type_works);
echo $form->field($model, 'type')->checkboxList($sp_tec,['separator' => '<br>'])->label('');
echo $form->field($model, 'id_works')->hiddenInput(['value' => $id_works])->label(''); 
echo Html::submitButton('Добавить', ['class' => 'btn btn-success','name'=>'add_tec']);?>
<?php  ?>
