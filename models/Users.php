<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Users".
 *
 * @property int $ID
 * @property string $Username
 * @property int $FacebookLike
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Username', 'FacebookLike'], 'required'],
            [['FacebookLike'], 'integer'],
            [['Username'], 'string', 'max' => 16],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'Username' => 'Username',
            'FacebookLike' => 'Facebook Like',
        ];
    }

    public function __toString()
    {
        return $this->Username;
        // TODO: Implement __toString() method.
    }

}
