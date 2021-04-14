<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use app\models\TypeObject;

class Reestr extends \yii\db\ActiveRecord
{
    public $type_name;
    public $obj_status;
    public static function tableName()
    {
        return 'reestr';
    }

    public function rules()
    {
        return [
            [['type','id_distr','status'], 'integer'],
            [['date_begin', 'plan_date_end','real_date_end'], 'date','format' => 'php:Y-m-d'],
            [['name', 'tab'], 'string', 'max' => 250],
            [['type_name','obj_status'],'string']
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'type' => 'Тип',
            'tab' => 'Отвественный',
            'date_begin' => 'Дата начала',
            'plan_date_end' => 'Плановая дата окончания',
            'id_distr'=>'Участок строительства',
            'status'=>'Статус'
        ];
    }
//------------------------------------------
public function getType_name()
{
    return $this->hasOne(TypeObject::className(), ['id' => 'type']);
}
//------------------------------------------
public function getObj_status()
{
    return $this->hasOne(Status::className(), ['id' => 'status']);
}
//------------------------------------------
//------------------------------------------
public function getList_works()
{
    return $this->hasMany(Works::className(), ['id_resstr' => 'id']);
}
//------------------------------------------
    public function search($params)
    {
        $query = Reestr::find()->joinWith(['type_name'])->joinWith(['obj_status']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->sort->attributes['type_name'] = [
            'asc' => ['type_name.name' => SORT_ASC],
            'desc' => ['type_name.name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['obj_status'] = [
            'asc' => ['obj_status.name' => SORT_ASC],
            'desc' => ['obj_status.name' => SORT_DESC],
        ];
        // load the search form data and validate
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // adjust the query by adding the filters
        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['like', 'reestr.name', $this->name])
              ->andFilterWhere(['like', 'type', $this->type])
              ->andFilterWhere(['like', 'status', $this->status]);
         //     ->andFilterWhere(['like', 'type_name.name', $this->type_name]);

        return $dataProvider;
    }

public function listType() {
    $rows = (new \yii\db\Query())
    ->select('*')
    ->from('type_object')
    ->where('id in (1,4)')
    ->all();
foreach($rows as $r)
        $row[$r['id']]=$r['name'];
    return $row;
}
//------------------------------------------
public function findDistricts($id) {
    $rows = (new \yii\db\Query())
    ->select('name')
    ->from('_districts')
    ->where('id ='.$id)
    ->one();

    return $rows['name'];
}
//------------------------------------------
public function findStatus($id) {
    $rows = (new \yii\db\Query())
    ->select('name')
    ->from('_status')
    ->where('id ='.$id)
    ->one();

    return $rows['name'];
}
//------------------------------------------
//------------------------------------------
public static function has_work($id) {
    if(isset($id))
    $rows = Yii::$app->db->createCommand('
    select sum(j.cou)as c
    from (select if(date_begin<now(),1,0) as cou
    from works
    where id_reestr='.$id.') as j')->queryOne();
    else $rows['c']=-1;
    return $rows['c'];
}
//------------------------------------------
public function findType($id) {
    $rows = (new \yii\db\Query())
    ->select('name')
    ->from('type_object')
    ->where('id ='.$id)
    ->one();

    return $rows['name'];
}
//------------------------------------------
public function list_status() {
    $rows = (new \yii\db\Query())
    ->select('*')
    ->from('_status')
    ->all();
foreach($rows as $r)
        $row[$r['id']]=$r['name'];
    return $row;
}
//------------------------------------------
public function give_name_type($type) {
    $rows = (new \yii\db\Query())
    ->select('name')
    ->from('type_object')
    ->where('id='.$type)
    ->one();

    return $rows['name'];
}
//------------------------------------------
public function find_pmod($type) {
    $rows = (new \yii\db\Query())
    ->select('name')
    ->from('pmodels')
    ->where('id='.$type)
    ->one();

    return $rows['name'];
}

//------------------------------------------
public function list_fio() {
    $rows = Yii::$app->db->createCommand('select concat(p.name," - ",d.name) as value,concat(p.name," - ",d.name) as label
                                            from people p
                                            inner join dolg d on d.id=p.id_dolg
                                            where 1')->queryAll();
    
    return $rows;
}
//------------------------------------------
public function find_fio($fio) {
    $rows = (new \yii\db\Query())
    ->select('tab')
    ->from('people')
    ->innerJoin('dolg','dolg.id=people.id_dolg')
    ->where('concat(people.name," - ",dolg.name)="'.$fio.'"')
    ->one();

    return $rows['tab'];
}
//------------------------------------------
//------------------------------------------
public function find_fio_by_tab($tab) {
    $rows = Yii::$app->db->createCommand('select concat(p.name," - ",d.name) as name
                                            from people p
                                            inner join dolg d on d.id=p.id_dolg
                                            where p.tab='.$tab)->queryOne();

    return $rows['name'];
}
//------------------------------------------


}
