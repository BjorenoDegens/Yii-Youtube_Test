<?php

namespace app\models;

use app\models\query\UsersQuery;
use Faker\Provider\Image;
use Imagine\Image\Box;
use Yii;
use yii\base\Exception;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "{{%video}}".
 *
 * @property string $video_id
 * @property string $title
 * @property string|null $description
 * @property string|null $tags
 * @property int|null $status
 * @property int|null $has_thumbnail
 * @property string|null $video_name
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 *
 * @property Accounts $owner
 * @property \app\models\VideoLike[] $likes
 * @property \app\models\VideoLike[] $dislikes
 */
class Video extends \yii\db\ActiveRecord
{
    const STATUS_UNLISTED = 0;
    const  STATUS_PUBLISHED = 1;

    /**
     * {@inheritdoc}
     * @var \yii\web\UploadedFile
     */
    public $video;
    public $thumbnail;
    public static function tableName()
    {
        return '{{%video}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => BlameableBehavior::class,
                'updatedByAttribute' => false
            ]
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['video_id', 'title'], 'required'],
            [['description'], 'string'],
            [['status', 'has_thumbnail', 'created_at', 'updated_at', 'created_by'], 'integer'],
            [['video_id'], 'string', 'max' => 16],
            [['title', 'tags', 'video_name'], 'string', 'max' => 512],
            [['video_id'], 'unique'],
            ['has_thumbnail','default','value' => 0],
            ['status','default','value' => self::STATUS_UNLISTED],
            ['thumbnail', 'image', 'minWidth' => 1280, 'minHeight' => 720],
            ['video','file','extensions' => ['mp4']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Accounts::class, 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'video_id' => 'Title',
            'title' => 'Title',
            'description' => 'Description',
            'tags' => 'Tags',
            'status' => 'Status',
            'has_thumbnail' => 'Has Thumbnail',
            'video_name' => 'Video Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Create By',
            'thumbnail' => 'Thumbnail'
        ];
    }
    public function getStatusLabels()
    {
        return[
            self::STATUS_UNLISTED => 'Unlisted',
            self::STATUS_PUBLISHED => 'Published'
        ];
    }
    /**
     * Gets query for [[owner]].
     *
     * @return ActiveQuery|UsersQuery
     */
    public function getOwner()
    {
        return $this->hasOne(Accounts::class, ['id' => 'created_by']);
    }
    /**
     * @return ActiveQuery
     */
    public function getViews()
    {
        return $this->hasMany(VideoView::class, ['video_id' => 'video_id']);
    }
    /**
     * @return ActiveQuery
     */
    public function getLikes()
    {
        return $this->hasMany(VideoLike::class, ['video_id' => 'video_id'])->liked();
    }
    /**
     * @return ActiveQuery
     */
    public function getDislikes()
    {
        return $this->hasMany(VideoLike::class, ['video_id' => 'video_id'])->disliked();
    }
    /**
     * {@inheritdoc}
     * @return \app\models\query\VideoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\VideoQuery(get_called_class());
    }

    /**
     * @throws Exception
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        $isInsert = $this->isNewRecord;
        if($isInsert)
        {
            $this->video_id = Yii::$app->security->generateRandomString(8);
            $this->title = $this->video->name;
            $this->video_name = $this->video->name;
        }
        if ($this->thumbnail)
        {
            $this->has_thumbnail = 1;
        }
        $saved = parent::save($runValidation, $attributeNames);
        if(!$saved)
        {
            return false;
        }
        if ($isInsert)
        {
            $videoPath = Yii::getAlias('@app/web/storages/video/'.$this->video_id.'.mp4');
            if(!is_dir(dirname($videoPath)))
            {
                FileHelper::createDirectory(dir($videoPath));
            }
            $this->video->saveAs($videoPath);
        }
        if ($this->thumbnail)
        {
            $ThumbnailPath = Yii::getAlias('@app/web/storages/thumb/'.$this->video_id.'.jpg');
            if(!is_dir(dirname($ThumbnailPath)))
            {
                FileHelper::createDirectory(dir($ThumbnailPath));
            }
            $this->thumbnail->saveAs($ThumbnailPath);
            \yii\imagine\Image::getImagine()
                ->open($ThumbnailPath)
                ->thumbnail(new Box(1280,1280))
                ->save();
        }
        return true;
    }

    public function getVideoLink()
    {
        return Yii::$app->params['Url'].'storages/video/'.$this->video_id.'.mp4';
    }
    public function getThumbnailLink()
    {
        return Yii::$app->params['Url'].'storages/thumb/'.$this->video_id.'.jpg';
    }

    public  function isLikedBy($userID)
    {
        return VideoLike::find()
            ->userIdVideoId($userID,$this->video_id)
            ->liked()
            ->one();
    }
    public  function isDislikedBy($userID)
    {
        return VideoLike::find()
            ->userIdVideoId($userID,$this->video_id)
            ->disliked()
            ->one();
    }
}
