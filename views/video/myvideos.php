<?php
/**
 * @var $getMyVideos Video
 *
 */

use app\models\Video;
use yii\helpers\Url;
?>
<div class="card m-2" style="width: 18rem;">
    <div class="embed-responsive embed-responsive-16by9 mb-3">
        <video style="width:285px; height:150px" poster="<?php echo $getMyVideos->getThumbnailLink() ?>"
               class="embed-responsive-item" src="<?php echo $getMyVideos->getVideoLink() ?>"></video>
    </div>        <div class="card-body">
        <h6 class="card-title"><?php echo $getMyVideos->title ?></h6>
        <p class="card-text">
            likes: <?php echo $getMyVideos->getLikes()->count() ?>
            <br>
            views: <?php echo $getMyVideos->getViews()->count() ?>
        </p>
        <a href="<?php echo Url::to(['/video/update', 'video_id' => $getMyVideos->video_id]) ?>" class="btn btn-primary">Edit</a>
    </div>
</div>


