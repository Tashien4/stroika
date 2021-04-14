<?php

namespace app\models;

use Yii;


class Houses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'houses';
    }

    public function rules()
    {
        return [
           // [['name', 'tab', 'date_begin', 'plan_date_end', 'real_date_end', 'floor', 'id_material', 'kv', 'status'], 'required'],
            [['id_reestr','floor', 'id_material', 'kv'], 'integer'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'floor' => 'Этажность',
            'id_material' => 'Материал',
            'kv' => 'Кол-во квартир',
            'status' => 'Статус',
        ];
    }
//------------------------------------------
public function getMaterials()
{
    return $this->hasOne(Materials::className(), ['id' => 'id_material']);
}
//------------------------------------------
public function find_mat(){

    $rows = (new \yii\db\Query())
    ->select('*')
    ->from('_materials')
    //->where('id_mod='.$type)
    ->all();
    foreach($rows as $a)
        $ret[$a['id']]=$a['name'];
return $ret;
}
//------------------------------------------
}
