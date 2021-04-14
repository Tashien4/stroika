<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Reestr */

$this->title = 'Изменение параметров работы';
/*$this->params['breadcrumbs'][] = ['label' => 'Reestrs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';*/
?>
<div class="create_obj">
    <a href="/stroika/web/reestr/works?id=<?php echo $model->id;?>">Назад</a>
</div>
<div class="reestr-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
