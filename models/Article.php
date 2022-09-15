<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Article".
 *
 * @property int $id
 * @property string|null $article_title
 * @property string|null $text
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Article';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['article_title', 'text'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'article_title' => 'Article Title',
            'text' => 'Text',
        ];
    }
}
