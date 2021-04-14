<?php
namespace app\controllers;

use Yii;
use app\models\Works;
use app\models\Reestr;
use app\models\Tecnical;
use app\models\RequestTec;
use app\models\Brigads;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class TecnicalController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    //-------------------------------------------
    public function actionUpdate($id)
    {
        $model = Tecnical::find()->where(['id'=>$id])->one();
        $rmodel=Works::find()->where(['id'=>$model->id_works])->one();
        $recmodel=RequestTec::find()->where(['id_tec'=>$id])->one();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['works/update?id='.$rmodel->id.'&id_reestr='.$rmodel->id_reestr]);
        }

        return $this->render('update', [
            'model' => $model,'recmodel'=>$recmodel,'type_works' => $rmodel->type_work,
        ]);
    }
        //-------------------------------------------
        public function actionUpdate_rec($id)
        {
            $model = Tecnical::find()->where(['id'=>$id])->one();
            $rmodel=Works::find()->where(['id'=>$model->id_works])->one();
            $recmodel=RequestTec::find()->where(['id_tec'=>$id])->one();
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
    
            return $this->render('update_rec', [
                'model' => $model,'recmodel'=>$recmodel,'type_works' => $rmodel->type_work,
            ]);
        }
 //-------------------------------------------
 public function actionList()
 {
     $id_work=$_GET['id_work'];

    // $model = Tecnical::find()->where(['id'=>$id])->one();
     $wmodel=Works::find()->where(['id'=>$id_work])->one();
     $recmodel= new RequestTec;
     $recmodel->id_work=$id_work;
     /*if ($model->load(Yii::$app->request->post()) && $model->save()) {
         return $this->redirect(['view', 'id' => $model->id]);
     }*/

     return $this->render('list', [
         'wmodel' => $wmodel,'recmodel' => $recmodel
     ]);
 }
 //---------------------------------------------
 public function actionCreate_request()
 {    
        if(isset($_GET['id_tec'])) $id_tec=$_GET['id_tec'];
        else $id_tec=0;
    if(isset($_GET['id'])) {
            $model =RequestTec::find()->where(['id'=>$_GET['id']])->one();
            $tmodel=Tecnical::find()->where(['id'=>$model->id_tec])->one();
            $wmodel=Works::find()->where(['id'=>$tmodel->id_works])->one();
        }
        else {$model = new RequestTec();  
                $model->id_tec=$id_tec; 
                $model->id_work=$_GET['id_work']; 
                $wmodel=Works::find()->where(['id'=>$_GET['id_work']])->one();};

    if($model->date_begin==0)
        $model->date_begin=$wmodel->date_begin;
    if($model->date_end==0)
        $model->date_end=$wmodel->date_end;

     if ($model->load(Yii::$app->request->post())) {
         if ($model->validate()) {
             $model->save();
             $this->redirect(['list?id_work='.$model->id_work]);
         }
         else print_r($model->geterrors());
     }
 
     return $this->render('create_request', [
         'model' => $model, 'wmodel' => $wmodel
     ]);
 }
 public function actionDelete($id)
    {
        $model=$this->findModel($id);
        $idr=$model->id_works;
        $wmodel=Works::find()->where(['id'=>$idr])->one();
        $model->delete();

        return $this->redirect(['works/update?id='.$idr.'&id_reestr='.$wmodel->id_reestr]);
    }

    protected function findModel($id)
    {
        if (($model = Tecnical::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
