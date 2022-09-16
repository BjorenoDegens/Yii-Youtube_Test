<?php
/**
 * @var $getMyVideos Video
 *
 */
use app\models\Video;
use yii\helpers\Html;
use yii\helpers\Url;


$this->title = 'My videos';
$this->params['breadcrumbs'][] = $this->title;

?>
<h1><?= Html::encode($this->title) ?></h1>

<div class="d-flex flex-row flex-wrap">
<?php
foreach ($getMyVideos as $getMyVideo):
?>
<div class="card m-2" style="width: 18rem;">
    <div class="embed-responsive embed-responsive-16by9 mb-3">
        <video style="width:285px; height:150px" poster="<?php echo $getMyVideo->getThumbnailLink() ?>"
               class="embed-responsive-item" src="<?php echo $getMyVideo->getVideoLink() ?>"></video>
    </div>        <div class="card-body">
        <h6 class="card-title"><?php echo $getMyVideo->title ?></h6>
        <p class="card-text">
            likes: <?php echo $getMyVideo->getLikes()->count() ?>
            <br>
            views: <?php echo $getMyVideo->getViews()->count() ?>
        </p>
        <a href="<?php echo Url::to(['/video/update', 'video_id' => $getMyVideo->video_id]) ?>" class="btn btn-primary">Edit</a>
    </div>
</div>
<?php
endforeach;
?>
</div>

