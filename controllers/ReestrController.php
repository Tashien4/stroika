<?php

namespace app\controllers;

use Yii;
use app\models\Reestr;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\User;
use app\models\Houses;
use app\models\Briges;
use app\models\Works;

/**
 * ReestrController implements the CRUD actions for Reestr model.
 */
class ReestrController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['list'],
                'rules' => [
                    // deny all POST requests
                    [   
                        'allow' => false,
                        'verbs' => ['POST']
                    ],
                    // allow authenticated users
                    [
                        'actions'=>['create', 'update','delete','list','plan'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    // everything else is denied
                ],
            ],
           /* 'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],*/
        ];
    }

    /**
     * Lists all Reestr models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Reestr::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Reestr model.
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
     * Creates a new Reestr model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Reestr();

        if(isset($_POST['Reestr']))
        {
            $model->attributes=$_POST['Reestr'];
            $model->tab=$model->find_fio($_POST['Reestr']['tab']);

            $list_models=$model->find_pmod($_POST['Reestr']['type']);
            $pm='app\models\$';
            $pm=substr($pm,0,-1).$list_models;
            $pmodel=new $pm;

            if ($model->save()) {
                $pmodel->id_reestr=$model->id;
                $pmodel->save();
                Works::add_begin_works($model->id);
                return $this->redirect(['reestr/update?id='.$model->id]);
            } else print_r($model->geterrors());
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }
//----------------------------------------------
    public function actionPlan()
    {
        $model = new Reestr();
        return $this->render('plan', [
            'model' => $model,
        ]);
    }
//----------------------------------------------
//----------------------------------------------
public function actionFrozen($id)
{
    $rows = Yii::$app->db->createCommand('
    update reestr set status=4 where id='.$id)->execute();
    $this->redirect(['list']);
    
}
//----------------------------------------------
//----------------------------------------------
public function actionTec()
{
    $model = new Reestr();
    return $this->render('tec', [
        'model' => $model,
    ]);
}
//----------------------------------------------
    public function actionWorks($id)
    {
        $model = $this->findModel($id);
        $wmodel=Works::find()->where(['id_reestr'=>$model->id]);
        if(isset($_POST['butn'])) {
            $rows = Yii::$app->db->createCommand('update reestr set status=2 where reestr.id='.$model->id)->execute();
            return $this->redirect(['plan']);
        };
        return $this->render('works', [
            'model' => $model,
            'wmodel' => $wmodel,
        ]);
    }
//----------------------------------------------
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->tab=$model->find_fio_by_tab($model->tab);

        if(isset($_POST['Reestr']))
        {
            $model->attributes=$_POST['Reestr'];
            $model->tab=$model->find_fio($_POST['Reestr']['tab']);

            if(isset($_POST['Houses'])) {
                $pmodel=Houses::find()->where(['id_reestr'=>$model->id])->one();
                $pmodel->attributes=$_POST['Houses'];
            };
            if(isset($_POST['Briges'])) {
                $pmodel=Briges::find()->where(['id_reestr'=>$model->id])->one();
                $pmodel->attributes=$_POST['Briges'];
                $pmodel->width=str_replace(',','.',$_POST['Briges']['width']);
            };
            
            if ($model->save()) {
                $pmodel->id_reestr=$model->id;
                if($pmodel->save())
                    return $this->redirect(['list']);
                print_r($pmodel->geterrors());
            } else print_r($model->geterrors());
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Reestr model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['list']);
    }

    /**
     * Finds the Reestr model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Reestr the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Reestr::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionList()
    {
        $umodel=User::findOne(['id' => Yii::$app->user->id]);
        $role=$umodel::getRole(Yii::$app->user->id);
        $model=new Reestr;
        return $this->render('list',['umodel' => $umodel,'role'=>$role,'model'=>$model]);
    }
}
