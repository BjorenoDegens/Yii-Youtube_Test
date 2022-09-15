<?php

use app\models\Video;
use yii\helpers\Url;

/**
 * @var $model Video
 */
?>
<div class="card m-2" style="width: 18rem; ">
    <a href="<?php echo Url::to(['/site/view', 'id' => $model->video_id]) ?>" style="text-decoration:none; color:black ">
        <div class="embed-responsive embed-responsive-16by9 mb-3 card-img-top">
            <video style="width:285px; height:150px" poster="<?php echo $model->getThumbnailLink() ?>" class="embed-responsive-item" src="<?php echo $model->getVideoLink() ?>" ></video>
        </div>
        <div class="card-body">
            <h5 class="card-title m-0"><?php echo $model->title ?></h5>
            <p class="card-text m-0 text-muted"><?php echo \app\helpers\Html::channelLink($model->owner) ?></p>
            <p class="card-text m-0 text-muted"><?php echo $model->getViews()->count()?> views . <?php echo Yii::$app->formatter->asRelativeTime($model->created_at)?></p></div>
    </a>

</div>

