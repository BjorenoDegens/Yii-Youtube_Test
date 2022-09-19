<?php
/**
 * @var $model Video
 * @var $similarVideos Video[]
 */

use app\models\Video;
use yii\helpers\Url;

?>

<div class="row">
    <div class="col">
        <div class="embed-responsive embed-responsive-16by9 mb-3 card-img-top">
            <video style="width:1068px; height:601px" poster="<?php echo $model->getThumbnailLink() ?>"
                   class="embed-responsive-item" src="<?php echo $model->getVideoLink() ?>" controls></video>
        </div>
        <h6 class="mt-2"><?php echo $model->title?></h6>
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <p><?php echo $model->getViews()->count() ?>  views . <?php echo Yii::$app->formatter->asDate($model->created_at) ?></p>
            </div>
            <div style="margin-right: 75px;" ">
                <?php \yii\widgets\Pjax::begin() ?>
                    <?php echo $this->render('_buttons',[
                            'model' => $model
                ]) ?>
                <?php \yii\widgets\Pjax::end() ?>
            </div>
    </div>
    <hr>

    <div>
            <p><?php echo \yii\helpers\Html::a($model->owner->username,[
                    '/channel/view', 'username' => $model->owner->username
                ]); ?></p>
            <?php echo \yii\helpers\Html::encode($model->description)  ?>
        </div>
    <hr>

</div>
    <div class="col col-lg-2">
        <?php  foreach ($similarVideos as $similarVideo): ?>
        <a href="<?php echo Url::to(['/site/view', 'id' => $similarVideo->video_id]) ?>" style="text-decoration:none; color:black ">
        <div class="media"
        <div class="embed-responsive embed-responsive-16by9 mb-3 card-img-top">
            <video style="width:180px; height:90px" poster="<?php echo $similarVideo->getThumbnailLink() ?>"
                   class="embed-responsive-item" src="<?php echo $similarVideo->getVideoLink() ?>"></video>
        </div>
                <div class="media-body text-lowercase" >
                    <h6 class="mt-0 "><?php  echo $similarVideo->title ?></h6>
                    <div class="text-muted">
                        <h6 class="m-0">
                            <?php echo \app\helpers\Html::channelLink($similarVideo->owner) ?>
                        </h6>
                        <h6>
                            <?php echo $similarVideo->getViews()->count() ?> views .
                            <?php  echo Yii::$app->formatter->asRelativeTime($similarVideo->created_at) ?>
                        </h6>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
            </div>

    </div>
</div>