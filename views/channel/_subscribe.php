<?php
/**
 *
 * @var $channel User
 * @return
 */

use app\models\User;

?>


<a class="btn <?php echo $channel->isSubscribed(Yii::$app->user->id)? 'btn-secondary' : 'btn-danger' ?>"
   href="<?php echo \yii\helpers\Url::to(['channel/subscribe', 'username' => $channel->username])?>" role="button"
   data-method="post" data-pjax="1">
    Subscribe <i class="fa-solid fa-bell"></i>
</a> <?php echo $channel->getSubscribers()->count() ?>