<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

class RequestTec extends \yii\db\ActiveRecord
{
public $name_tec;
public $begin_tec;
public $end_tec;

    public static function tableName()
    {
        return 'request_tec';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_tec', 'status', 'result','id_work'], 'integer'],
            [['name_tec'],'string','max'=>250],
            [['date_begin', 'date_end'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_tec' => 'Наименование',
            'result' => 'Результат',
            'status' => 'Статус',
            'date_begin' => 'Дата начала',
            'date_end' => 'Дата завершения',
            'sogl' => 'Согласование',
            'name_tec'=>'Наименование',
            'begin_tec'=>'Дата начала',
            'end_tec'=>'Дата завершения'
        ];
    }
    //------------------------------------------
public function getRec_tec()
{
    return $this->hasOne(Tecnical::className(), ['id' => 'id_tec']);
}
//------------------------------------------

    public function search($params)
{
    $query =RequestTec::find()->joinWith('rec_tec')->where('id_work='.$this->id_work);

    $dataProvider = new ActiveDataProvider([
        'query' => $query,
    ]);

    /*$dataProvider->sort->attributes['name_tec'] = [
        'asc' => ['list_tec.name' => SORT_ASC],
        'desc' => ['list_tec.name' => SORT_DESC],
    ];*/
    $dataProvider->sort->attributes['begin_tec'] = [
        'asc' => ['tecnical.date_begin' => SORT_ASC],
        'desc' => ['tecnical.date_begin' => SORT_DESC],
    ];
    $dataProvider->sort->attributes['end_tec'] = [
        'asc' => ['tecnical.date_end' => SORT_ASC],
        'desc' => ['tecnical.date_end' => SORT_DESC],
    ];
    // load the search form data and validate
    if (!($this->load($params) && $this->validate())) {
        return $dataProvider;
    }

    // adjust the query by adding the filters
    $query->andFilterWhere(['id' => $this->id]);
    $query->andFilterWhere(['like', 'name', $this->name])
          ->andFilterWhere(['like', 'type', $this->type])
          ->andFilterWhere(['like', 'status', $this->status])
          ->andFilterWhere(['like', 'tecnical.date_begin', $this->begin_tec])
          ->andFilterWhere(['like', 'tecnical.date_end', $this->end_tec])
          ->andFilterWhere(['like', 'name_tec.name', $this->name_tec]);


    return $dataProvider;
}
//------------------------------------
public function list_status(){
    $rows = (new \yii\db\Query())
    ->select('*')
    ->from('_status_request')
    ->All();
    foreach($rows as $rr)
        $ret[$rr['id']]=$rr['name'];
    
    return $ret;
}
//------------------------------------
//------------------------------------
public static function find_result($id) {
    $rows = (new \yii\db\Query())
    ->select('id,name')
    ->from('_status_tec')
    ->where('id='.$id)
    ->one();
    return $rows['name'];
}

}
