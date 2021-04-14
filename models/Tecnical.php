<?php

namespace app\models;
use yii\data\ActiveDataProvider;

use Yii;

class Tecnical extends \yii\db\ActiveRecord
{
public $name_tec;
public $status_name;
public $work_name;
public $reestr_name;

    public static function tableName()
    {
        return 'tecnical';
    }


    public function rules()
    {
        return [
            [['type', 'id_works'], 'integer'],
            [['date_begin', 'date_end'], 'safe'],
            [['name_tec','status_name','work_name','reestr_name'],'string','max'=>250]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Тип техники',
            'name_tec' => 'Тип техники',
            'id_reestr' => 'Id Reestr',
            'date_begin' => 'Дата начала',
            'date_end' => 'Дата окончания',
            'status' => 'Статус',
            'work_name' => 'Наименование работы',
            'reestr_name' => 'Имя объекта',
            'status_name' => 'Статус',
        ];
    }
//------------------------------------------
public function getWork_list()
{
    return $this->hasOne(Works::className(), ['id' => 'id_works']);
}
//------------------------------------------
public function getTec_name()
{
    return $this->hasOne(TypeTec::className(), ['id' => 'type']);
}

public function getFind_name_tec()
{
    $tec_name = $this->tec_name;

    return $tec_name ? $tec_name->name : '';
}

//------------------------------------------

//------------------------------------------
public function getRec_tec()
{
    return $this->hasOne(RequestTec::className(), ['id' => 'id_tec']);
}
//------------------------------------------
public function search($params,$id_works)
{
    //joinWith(['list_tec'])->joinWith(['list_brig'])
    $query = Tecnical::find()->where(['id_works'=>$id_works]);

    $dataProvider = new ActiveDataProvider([
        'query' => $query,
    ]);
    $dataProvider->sort->attributes['name_tec'] = [
        'asc' => ['list_tec.name' => SORT_ASC],
        'desc' => ['list_tec.name' => SORT_DESC],
    ];
    $dataProvider->sort->attributes['status_name'] = [
        'asc' => ['status_name.name' => SORT_ASC],
        'desc' => ['status_name.name' => SORT_DESC],
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
          ->andFilterWhere(['like', 'list_tec.name', $this->list_tec])
          ->andFilterWhere(['like', 'list_brig.name', $this->list_brig]);

    return $dataProvider;
}
//------------------------------------
//------------------------------------------
public function search_2($params)
{
    $query = Tecnical::find()
                ->joinWith('work_list')
                ->joinWith('tec_name')
                ->joinWith('work_list.name_type_work')
                ->joinWith('work_list.list_reestr');

    $dataProvider = new ActiveDataProvider([
        'query' => $query,
    ]);
    $dataProvider->sort->attributes['work_name'] = [
        'asc' => ['_type_works.name' => SORT_ASC],
        'desc' => ['_type_works.name' => SORT_DESC],
    ];
    $dataProvider->sort->attributes['reestr_name'] = [
        'asc' => ['reestr.name' => SORT_ASC],
        'desc' => ['reestr.name' => SORT_DESC],
    ];

    /*$dataProvider->sort->attributes['name_tec'] = [
        'asc' => ['_type_tec.name' => SORT_ASC],
        'desc' => ['_type_tec.name' => SORT_DESC],
    ];*/
    // load the search form data and validate
    if (!($this->load($params) && $this->validate())) {
        return $dataProvider;
    }

    // adjust the query by adding the filters
    $query->andFilterWhere(['id' => $this->id]);
    $query->andFilterWhere(['like', 'type', $this->type])
          ->andFilterWhere(['like', 'status', $this->status])
          ->andFilterWhere(['like', 'reestr.name', $this->reestr_name])
          ->andFilterWhere(['like', '_type_works.name', $this->work_name]);
 //->andFilterWhere(['like', '_type_tec.name', $this->name_tec])
    return $dataProvider;
}
//-----------------------------------------------------
public static function find_tec($type_works) {
    $rows = (new \yii\db\Query())
    ->select('id,name')
    ->from('_type_tec')
    ->where('type_works='.$type_works)
    ->all();
    if(count($rows)>0)
        foreach($rows as $rr)
            $ret[$rr['id']]=$rr['name'];
    else $ret[0]='';
    return $ret;
}
//------------------------------------
public static function find_stat() {
    $rows = (new \yii\db\Query())
    ->select('id,name')
    ->from('_status_tec')
    ->all();
        foreach($rows as $rr)
            $ret[$rr['id']]=$rr['name'];
    return $ret;
}
}
