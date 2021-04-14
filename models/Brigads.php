<?php

namespace app\models;
use yii\data\ActiveDataProvider;

use Yii;

/**
 * This is the model class for table "brigads".
 *
 * @property int $id
 * @property int $type
 * @property int $id_reestr
 * @property string $date_begin
 * @property string $data_end
 */
class Brigads extends \yii\db\ActiveRecord
{
    public $name_brig;
    public $status_name;
    public static function tableName()
    {
        return 'brigads';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'id_works'], 'integer'],
            [['date_begin', 'data_end'], 'safe'],
            [['name_brig','status_name'],'string','max'=>250]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Наименование',
            'id_reestr' => 'Id Reestr',
            'date_begin' => 'Дата начала',
            'date_end' => 'Дата окончания',
            'status' => 'Статус',
            'status_name' => 'Статус',
        ];
    }
//------------------------------------------
public function getList_brig()
{
    return $this->hasOne(Works::className(), ['id' => 'id_works']);
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
public static function find_brig($type_works) {
    $rows = (new \yii\db\Query())
    ->select('id,name')
    ->from('_type_brig')
    ->where('type_works='.$type_works)
    ->all();
    if(count($rows)>0)
        foreach($rows as $rr)
            $ret[$rr['id']]=$rr['name'];
    else $ret[0]='';
    return $ret;
}
}
