<?php

namespace app\controllers;


use Yii;
use app\models\Works;
use app\models\Reestr;
use app\models\Tecnical;
use app\models\Brigads;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class BrigadsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    //-------------------------------------------
    public function actionUpdate($id)
    {
        $model = Brigads::find()->where(['id'=>$id])->one();
        $rmodel=Works::find()->where(['id'=>$model->id_works])->one();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,'type_works' => $rmodel->type_work,
        ]);
    }


}
