<?php

namespace app\models\query;

use app\models\Video;
use app\models\VideoLike;

/**
 * This is the ActiveQuery class for [[\app\models\VideoLike]].
 *
 * @see \app\models\VideoLike
 */
class VideoLikeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\VideoLike[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\VideoLike|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function userIdVideoId($userID,$videoID)
    {
        return $this->andWhere([
            'video_id' => $videoID,
            'user_id' => $userID
        ]);
    }

    public function liked()
    {
        return $this->andWhere(['type' => VideoLike::TYPE_LIKE]);
    }

    public function disliked()
    {
        return $this->andWhere(['type' => VideoLike::TYPE_DISLIKE]);
    }
}
