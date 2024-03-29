<?php

namespace app\models\query;

use app\models\Accounts;
use app\models\Video;

/**
 * This is the ActiveQuery class for [[\app\models\Video]].
 *
 * @see \app\models\Video
 */
class VideoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\Video[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\Video|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);

    }

    public function creator($userID)
    {
        return $this->andWhere(['created_by' => $userID]);
    }

    public function latest()
    {
        return $this->orderBy(['created_at' => SORT_DESC]);
    }

    public function published()
    {
        return $this->andWhere(['status' => Video::STATUS_PUBLISHED]);
    }

    public function byKeyword($keyword)
    {
        return $this->andWhere("MATCH(title, description, tags) AGAINST (:keyword)",['keyword' => $keyword]);
    }
}
