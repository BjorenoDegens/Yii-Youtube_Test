<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%subscriber}}".
 *
 * @property int $id
 * @property int|null $channel_id
 * @property int|null $user_id
 * @property int|null $created_at
 *
 * @property Accounts $channel
 * @property Accounts $user
 */
class Subscriber extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%subscriber}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['channel_id', 'user_id', 'created_at'], 'integer'],
            [['channel_id'], 'exist', 'skipOnError' => true, 'targetClass' => Accounts::class, 'targetAttribute' => ['channel_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Accounts::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'channel_id' => 'Channel ID',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Channel]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\AccountsQuery
     */
    public function getChannel()
    {
        return $this->hasOne(Accounts::class, ['id' => 'channel_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\AccountsQuery
     */
    public function getUser()
    {
        return $this->hasOne(Accounts::class, ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\SubscriberQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\SubscriberQuery(get_called_class());
    }
}
