<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "_type_works".
 *
 * @property int $id
 * @property int $type_object
 * @property string $name
 */
class TypeWorks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '_type_works';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type_object', 'name'], 'required'],
            [['type_object'], 'integer'],
            [['name'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_object' => 'Type Object',
            'name' => 'Name',
        ];
    }
}
