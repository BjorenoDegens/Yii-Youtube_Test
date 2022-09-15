<?php
/**
 * @var $model Video
 */

use app\models\Video;
use \yii\helpers\StringHelper;
use yii\helpers\Url;

?>
<div class="media d-flex ">
    <a href="<?php echo Url::to(['/video/update', 'video_id' => $model->video_id]);?>">
        <div class="embed-responsive embed-responsive-16by9 mr-3 ">
            <video style="width:180px; height:90px" poster="<?php echo $model->getThumbnailLink() ?>" class="embed-responsive-item" src="<?php echo $model->getVideoLink() ?>"></video>
        </div>
    </a>
    <div class="media-body">
        <h6 class="mt-0"><?php echo $model->title ?></h6>
        <?php echo  StringHelper::truncateWords($model->description,10)?>
    </div>
</div>