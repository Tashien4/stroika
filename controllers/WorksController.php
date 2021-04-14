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

/**
 * WorksController implements the CRUD actions for Works model.
 */
class WorksController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Works models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Works::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Works model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Works model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Works();
        $model->id_reestr=$_GET['id_reestr'];
        $rmodel=Reestr::find()->where(['id'=>$model->id_reestr])->one();
        $model->date_begin=$rmodel->date_begin;
        if(isset($_POST['Works'])) {
            $model->attributes=$_POST['Works'];
        if($model->save())
            return $this->redirect(['update', 'id' => $model->id,'id_reestr'=>$rmodel->id]);
        else print_r($model->geterrors());
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }
    //-----------------------------------.
    public function actionAdd_tec()
    {
        $model = new Tecnical();
        $model->id_works=$_GET['id_work'];
        $model->status=1;
        $rmodel=Works::find()->where(['id'=>$model->id_works])->one();
        $model->date_begin=$rmodel->date_begin;
        $model->date_end=$rmodel->date_begin;
        if(isset($_POST['add_tec'])) {
            //$model->attributes=$_POST['Tecnical'];
        if($model->save())
            return $this->redirect(['update', 'id' => $rmodel->id,'id_reestr'=>$rmodel->id_reestr]);
        else print_r($model->geterrors());
        }
        return $this->render('add_tec', [
            'model' => $model,'type_works' => $rmodel->type_work
        ]);
    }
    //-------------------------------------------
    //-----------------------------------.
    public function actionAdd_brig()
    {
        $model = new Brigads();
        $model->id_works=$_GET['id_work'];
        $model->status=1;
        $rmodel=Works::find()->where(['id'=>$model->id_works])->one();
        $model->date_begin=$rmodel->date_begin;
        $model->date_end=$rmodel->date_begin;
        if(isset($_POST['Brigads'])) {
            $model->attributes=$_POST['Brigads'];
        if($model->save())
            return $this->redirect(['update', 'id' => $rmodel->id,'id_reestr'=>$rmodel->id_reestr]);
        else print_r($model->geterrors());
        }
        return $this->render('add_brig', [
            'model' => $model,'type_works' => $rmodel->type_work
        ]);
    }
    //-------------------------------------------


    /**
     * Updates an existing Works model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if(isset($_POST['works'])){
            $model->attributes=$_POST['Works'];
            if($model->save())
            return $this->redirect(['update?id='.$model->id.'&id_reestr='.$model->id_reestr, 'model' => $model]);
            else print_r($model->geterrors());
        };
        if(isset($_POST['add_tec'])) {
            $tmodel = new Tecnical();
            $all=$_POST['Tecnical']['type'];
            if(is_countable($all))foreach($all as $a) {
                //echo '<br><br><br>'.$a; print_r($_POST['Tecnical']['type']);
            $tmodel = new Tecnical();
            $tmodel->id_works=$_POST['Tecnical']['id_works'];
            $tmodel->type=$a;
            $wmodel=Works::find()->where(['id'=>$tmodel->id_works])->one();
            $tmodel->date_begin=$wmodel->date_begin;
            $tmodel->date_end=$wmodel->date_begin;
            if(!$tmodel->save()) print_r($tmodel->geterrors());
            };
        };
        if(isset($_POST['add_brig'])) {echo '<script>alert("NOOO")</script>';
            $all=$_POST['Brigads']['type'];
            if(is_countable($all))
                foreach($all as $a) {
            $bmodel = new Brigads();
            $bmodel->id_works=$_POST['Brigads']['id_works'];
            $bmodel->type=$a;
            $bmodel->status=1;
            $wmodel=Works::find()->where(['id'=>$bmodel->id_works])->one();
            $bmodel->date_begin=$wmodel->date_begin;
            $bmodel->date_end=$wmodel->date_begin;
            print_r($bmodel->geterrors());
            if(!$bmodel->save()) print_r($bmodel->geterrors());
            };
        };
            return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Works model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model=$this->findModel($id);
        $idr=$model->id_reestr;
        $model->delete();

        return $this->redirect(['reestr/works?id='.$idr]);
    }

    /**
     * Finds the Works model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Works the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Works::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
