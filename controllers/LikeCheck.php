<?php
namespace app\controllers;

use yii\web\Controller;

Class LikeCheck extends Controller
{
    public function actionLikes()
    {
        $users = Users::find()
            ->where(["FacebookLike" => 0])
            ->all();
        return $this->render('index', [
            'users' => $users,
        ]);
    }
}