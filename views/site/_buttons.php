<?php
/**
 * @var $model Video
 */

use app\models\Video;
use yii\helpers\Url;

?>
<a href="<?php echo Url::to(['/site/like', 'id' => $model->video_id]) ?>"
   class="btn btn-sm btn-outline-primary<?php echo $model->isLikedBy(Yii::$app->user->id) ? 'btn-outline-primary' : 'btn-outline-secondary' ?>"
   data-method="post" data-pjax="1">
    <i class="fa-sharp fa-solid fa-thumbs-up"></i> <?php echo $model->getLikes()->count() ?>
</a>
<a href="<?php echo Url::to(['/site/dislike', 'id' => $model->video_id]) ?>"
   class="btn btn-sm btn-outline-primary<?php echo $model->isDislikedBy(Yii::$app->user->id) ? 'btn-outline-primary' : 'btn-outline-secondary' ?>"
   data-method="post" data-pjax="1">
    <i class="fa-sharp fa-solid fa-thumbs-down"></i> <?php echo $model->getDislikes()->count() ?>
</a>
