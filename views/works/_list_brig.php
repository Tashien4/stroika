<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\data\ActiveDataProvider;
use app\models\Brigads;
use yii\grid\GridView;

?>
<style>
    .inside td,th{ border:1px solid black;padding:10px;}
    </style>

<br><Br>
    <table class="inside">

    <tr><th>Тип бригады</th><th>Дата начала</th><th>Дата окончания</th><th></th></tr>
    <?php
        $bmodel=$model->find_all_brig($model->id);
        foreach($bmodel as $bb)
            echo '<tr><td>'.$bb['name'].'</td>
                        <td>'.$bb['date_begin'].'</td>
                        <td>'.$bb['date_end'].'</td>
                        <td>
                            <a href="/stroika/web/brigads/update?id='.$bb['id'].'" class="glyphicon glyphicon-pencil">
                            </a><a href="/stroika/web/brigads/delete?id='.$bb['id'].'" class="glyphicon glyphicon-trash">
                            </a>
                        </td></tr>';

    ?></table>
