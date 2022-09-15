<?php

/** @var yii\web\View $this
/**
 * @var $dataProvider ActiveDataProvider
 */

use yii\helpers\Html;
use app\helpers\User;
use yii\data\ActiveDataProvider;



$this->title = 'History';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="site-index">

    <div class="body-content">

        <div class="row">

        </div>
        <div class="col-lg-8">
            <?php
            echo \yii\widgets\ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => '/site/_video_item',
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
