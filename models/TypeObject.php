<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "type_object".
 *
 * @property int $id
 * @property string $name
 */
class TypeObject extends \yii\db\ActiveRecord
{
    public function getTypeObject()
    {
        return $this->hasMany(Reestr::className(), ['type' => 'id']);
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'type_object';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
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
        ];
    }
}
