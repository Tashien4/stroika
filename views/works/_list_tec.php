<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\data\ActiveDataProvider;
use app\models\Tecnical;
use yii\grid\GridView;
use yii\bootstrap\Modal;

?><br><Br>
    <table class="inside">

<tr><th>Тип техники</th><th>Дата начала</th><th>Дата окончания</th><th></th></tr>
<?php
    $bmodel=$model->find_all_tec($model->id);
    foreach($bmodel as $bb)
        echo '<tr><td>'.$bb['name'].'</td>
                    <td>'.$bb['date_begin'].'</td>
                    <td>'.$bb['date_end'].'</td>
                    <td>
                        <a href="/stroika/web/tecnical/update?id='.$bb['id'].'" class="glyphicon glyphicon-pencil">
                        </a><a href="/stroika/web/tecnical/delete?id='.$bb['id'].'" class="glyphicon glyphicon-trash">
                        </a>
                    </td></tr>';

?></table>
