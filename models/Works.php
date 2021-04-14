<?php

namespace app\models;
use yii\data\ActiveDataProvider;

use Yii;

class Works extends \yii\db\ActiveRecord
{
    public $list_tec;
    public $list_brig;
    public $name_work;
    public $name_reestr;
    public static function tableName()
    {
        return 'works';
    }

    public function rules()
    {
        return [
          //  [['id', 'id_reestr', 'type_work', 'date_begin', 'data_end'], 'required'],
            [['id', 'id_reestr', 'type_work','list_tec','list_brig'], 'integer'],
            [['name_work','name_reestr'],'string','max'=>250],
            [['date_begin', 'date_end'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_reestr' => 'Название объекта',
            'name_reestr' => 'Название объекта',
            'type_work' => 'Название работы',
            'name_work' => 'Название работы',
            'date_begin' => 'Дата начала',
            'date_end' => 'Дата окончания',
            'list_tec' => 'Техника',
            'list_brig' => 'Бригады',
        ];
    }
//------------------------------------------
public function getList_tec()
{
    return $this->hasMany(Tecnical::className(), ['id_works' => 'id']);
}
//------------------------------------------
public function getList_brig()
{
    return $this->hasMany(Brigads::className(), ['id_works' => 'id']);
}
//------------------------------------------
public function getList_reestr()
{
    return $this->hasOne(Reestr::className(), ['id' => 'id_reestr']);
}
//------------------------------------------
//------------------------------------------
public function getName_type_work()
{
    return $this->hasOne(TypeWorks::className(), ['id' => 'type_work']);
}
//------------------------------------------
public function search($params,$id_reestr)
{
    $query = Works::find()->joinWith(['list_tec'])->joinWith(['list_brig'])->where(['id_reestr'=>$id_reestr]);

    $dataProvider = new ActiveDataProvider([
        'query' => $query,
    ]);
    $dataProvider->sort->attributes['list_tec'] = [
        'asc' => ['list_tec.name' => SORT_ASC],
        'desc' => ['list_tec.name' => SORT_DESC],
    ];
    $dataProvider->sort->attributes['list_brig'] = [
        'asc' => ['list_brig.name' => SORT_ASC],
        'desc' => ['list_brig.name' => SORT_DESC],
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
public function search_2($params)
{
    $query = Works::find()
        ->joinWith(['list_tec'])
        ->joinWith(['list_reestr'])
        ->joinWith(['name_type_work'])
        ->where('tecnical.id>0');

    $dataProvider = new ActiveDataProvider([
        'query' => $query,
    ]);
    $dataProvider->sort->attributes['list_tec'] = [
        'asc' => ['_type_tec.name' => SORT_ASC],
        'desc' => ['_type_tec.name' => SORT_DESC],
    ];
    $dataProvider->sort->attributes['name_reestr'] = [
        'asc' => ['reestr.name' => SORT_ASC],
        'desc' => ['reestr.name' => SORT_DESC],
    ];  
      $dataProvider->sort->attributes['name_work'] = [
        'asc' => ['_type_works.name' => SORT_ASC],
        'desc' => ['_type_works.name' => SORT_DESC],
    ];
    // load the search form data and validate
    if (!($this->load($params) && $this->validate())) {
        return $dataProvider;
    }

    // adjust the query by adding the filters
    $query->andFilterWhere(['id' => $this->id]);
    $query->andFilterWhere(['like', 'type_work', $this->type_work])
          ->andFilterWhere(['like', '_type_tec.name', $this->list_tec])
          ->andFilterWhere(['like', '_type_works.name', $this->name_work])
          ->andFilterWhere(['like', 'reestr.name', $this->name_reestr]);

    return $dataProvider;
}
//------------------------------------------
//------------------------------------
public static function add_begin_works($id) {
    $rows = Yii::$app->db->createCommand('
    Insert into works (id_reestr,type_work,date_begin)
    select '.$id.' as id_reestr,_type_works.id, (reestr.date_begin + INTERVAL 1 day)
        from reestr
        inner join _type_works on _type_works.type_object=reestr.type
        where reestr.id='.$id)->execute();
    return $rows;    
}
//------------------------------------
public static function list_types($id) {
    $rows = (new \yii\db\Query())
    ->select('_type_works.*')
    ->from('_type_works')
    ->innerJoin('reestr','reestr.type=_type_works.type_object and reestr.id='.$id)
    ->all();
    foreach($rows as $r)
        $ret[$r['id']]=$r['name'];
    return $ret;
}
//------------------------------------
public static function find_all_brig($id) {
    $rows = (new \yii\db\Query())
    ->select('b.id,t.name,b.date_begin,b.date_end,s.name as status')
    ->from('brigads b')
    ->innerJoin('_type_brig t','t.id=b.type')
    ->innerJoin('_status_tec s','s.id=b.status')
    ->where('b.id_works='.$id)
    ->all();
    
    return $rows;
}
//------------------------------------
public static function find_all_tec($id) {
    $rows = (new \yii\db\Query())
    ->select('b.id,t.name,b.date_begin,b.date_end')
    ->from('tecnical b')
    ->innerJoin('_type_tec t','t.id=b.type')
    ->where('b.id_works='.$id)
    ->all();
    
    return $rows;
}
//------------------------------------
public static function find_name_work($id) {
    $rows = (new \yii\db\Query())
    ->select('name')
    ->from('_type_works')
    ->where('id='.$id)
    ->one();
    return $rows['name'];
}
//------------------------------------
public static function find_all_name_work() {
    $rows = (new \yii\db\Query())
    ->select('*')
    ->from('_type_works')
    ->all();
    foreach($rows as $r)
        $ret[$r['id']]=$r['name'];
    return $ret;
}
}
