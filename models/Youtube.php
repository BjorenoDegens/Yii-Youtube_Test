<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "youtube".
 *
 * @property int $id
 * @property string|null $videoname
 * @property string|null $tumbnail
 * @property string|null $video
 * @property string|null $description
 */
class Youtube extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'youtube';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['videoname','description'],'required'],
            [['videoname', 'tumbnail', 'video'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'videoname' => 'Videoname',
            'tumbnail' => 'Tumbnail',
            'video' => 'Video',
            'description' => 'Description',
        ];
    }
}
