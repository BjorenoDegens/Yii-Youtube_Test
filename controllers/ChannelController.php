<?php

namespace app\controllers;

use app\models\Subscriber;
use app\models\User;
use app\models\Video;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ChannelController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['subscribe'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionView($username)
    {
        $channel = $this->findChannel($username);

        $dataProvider = new ActiveDataProvider([
            'query' => Video::find()->creator($channel->id)->published()
        ]);
        return $this->render('view',[
            'channel' => $channel,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionSubscribe($username)
    {
        $channel = $this->findChannel($username);

        $userID = \Yii::$app->user->id;
        $subscriber = $channel->isSubscribed($userID);
        if(!$subscriber)
        {
            $subscriber = new Subscriber();
            $subscriber->channel_id = $channel->id;
            $subscriber->user_id = $userID;
            $subscriber->created_at = time();
            $subscriber->save();
        }
        else
        {
            $subscriber->delete();
        }
        return $this->renderAjax('_subscribe',[
            'channel' => $channel
        ]);
    }
    /**
     * @param $username
     * @return void
     * @throws NotFoundHttpException
     */
    public function findChannel($username)
    {
        $channel = User::findByUsername($username);
        if (!$channel) {
            throw new NotFoundHttpException('Channel does not exist');
        }
        return $channel;
    }
}