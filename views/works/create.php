<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Reestr */

$this->title = 'Создание работы';

?>
<div class="create_obj">
    <a href="/stroika/web/reestr/works?id=<?php echo $_GET['id_reestr'];?>">Назад</a>
</div>
<div class="reestr-create">

    <h1 align=center><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
