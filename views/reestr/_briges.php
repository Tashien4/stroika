<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Briges;
use app\models\Reestr;

?>

<?php $form = ActiveForm::begin(); 
$model=Briges::find()->where(['id_reestr'=>$id_reestr])->one();?>
<?php $isDone=Reestr::has_work($id_reestr);?>
<table>
    <tr><td <?php if($isDone>0) echo "onclick='nop()'";?>>
    <?php 
    $types=['1'=>'Балочное','2'=>'Ферменное','3'=>'Арочное','4'=>'Конструкции комбинированного типа','5'=>'Рамное','6'=>'Висячее','7'=>'Вантовое'];
    
    if(!isset($model->id)) $model=new Briges;
    echo $form->field($model, 'type')->dropdownlist($types,$isDone>0?['disabled'=>'true']:['maxlength' => true]);
    echo $form->field($model, 'width')->textInput($isDone>0?['disabled'=>'true']:['maxlength' => true]);
    echo $form->field($model, 'cou_lines')->textInput($isDone>0?['disabled'=>'true']:['maxlength' => true]);
    ?>
    
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>


