<?php

namespace app\models;

use Yii;

class Briges extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'briges';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
          
            [['type', 'cou_lines'], 'integer'],
            [['width'], 'number','numberPattern' => '/^\s*[-+]?[0-9]*[.,]?[0-9]+([eE][-+]?[0-9]+)?\s*$/'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Тип пролетного строения',
            'width' => 'Ширина',
            'cou_lines' => 'Количество полос',
            
        ];
    }
}
