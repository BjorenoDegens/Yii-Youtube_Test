<?php

/**
 * @var $channel User
 * @var $dataProvider ActiveDataProvider
 */

use app\models\User;
use yii\data\ActiveDataProvider;
use yii\widgets\Pjax;
?>
<div class="jumbotron">
    <h1 class="display-4"><?php echo $channel->username ?></h1>
    <hr class="my-4">
        <?php Pjax::begin()?>
            <?php echo $this->render('_subscribe',[
                    'channel' => $channel
        ])?>
        <?php Pjax::end()?>
    <hr class="my-4">
</div>
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
