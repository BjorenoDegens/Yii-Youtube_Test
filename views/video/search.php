<?php

/** @var yii\web\View $this
/**
 * @var $dataProvider ActiveDataProvider
 */

use app\helpers\User;
use yii\data\ActiveDataProvider;

$this->title = 'My Yii Application';

?>
<div class="site-index">
<h1>Found videos</h1>
    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">Congratulations!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>FacebookLikes</h2>
                <?php
                echo app\helpers\FacebookHelper::vote($users);
                ?>

                <p><a class="btn btn-outline-secondary" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>
            <div class="col-lg-8">
                <?php
                echo \yii\widgets\ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemView' => '_video_item',
                    'layout' => '<div class="d-flex flex-wrap">{items}</div>{pager}',
                    'itemOptions' => [
                        'tag' => false
                    ]
                ])
                ?>
            </div>
        </div>

    </div>
</div>
