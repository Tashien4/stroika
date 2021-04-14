<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Houses;
use app\models\Reestr;

?>

<?php $form = ActiveForm::begin();
$isDone=Reestr::has_work($id_reestr);
$model=Houses::find()->where(['id_reestr'=>$id_reestr])->one(); ?>
<table>
    <tr><td <?php if($isDone>0) echo "onclick='nop()'";?>>
    <?php 
    
    if(!isset($model->id)) $model=new Houses;
    $material=$model->find_mat();
    echo $form->field($model, 'floor')->textInput($isDone>0?['disabled'=>'true']:['maxlength' => true]);
    echo $form->field($model, 'id_material')->dropDownList($material,$isDone>0?['disabled'=>'true']:['maxlength' => true]);
    echo $form->field($model, 'kv')->textInput($isDone>0?['disabled'=>'true']:['maxlength' => true]);
    ?>
    
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>


