<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "_type_tec".
 *
 * @property int $id
 * @property string $name
 * @property int $type_works
 */
class TypeTec extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '_type_tec';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'type_works'], 'required'],
            [['type_works'], 'integer'],
            [['name'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'type_works' => 'Type Works',
        ];
    }
}
