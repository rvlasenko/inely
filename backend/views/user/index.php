<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $userStats backend\models\GamifyUserStats */

$currentXPInPercentage = $userStats[0]['experience'] * 100 / $userStats[0]['experience_needed'];
$srcUserAvatar = Yii::$app->user->identity->userProfile->getAvatar(Yii::$app->user->id);
$toNewLevel = $userStats[0]['experience_needed'] - $userStats[0]['experience'];

?>

<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title">Профиль <?= Yii::$app->user->identity->username ?></span>
    </div>
    <div class="panel-body">
        <div class="media clearfix">
            <div class="media-left pr30">
                <ul class="img-list">
                    <li>
                        <a id="avatar" href="#">
                            <span class="chart" style="position:relative;" data-percent="<?= $currentXPInPercentage ?>">
                                <span class="text-content"><span>Изменить...</span></span>
                                <img class="media-object mw150" src="<?= $srcUserAvatar ?>">
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="media-body va-m">
                <h2 class="media-heading text-primary fs22"><?= $this->params['firstName'] ?>
                    <small> - </small>
                    <small class="user-level" title="ещё <?= $toNewLevel ?> XP"><?= $userStats[0]['level'] ?></small>
                </h2>
                <p class="lead">
                    <?= $userStats[0]['tasks_done'] ?> выполненных задач и
                    <?= count($userStats['achievements']) ?> значков!
                </p>

                <div class="badges">
                    <div class="badges">
                        <?php foreach ($userStats['achievements'] as $achievement): ?>
                            <div class="achievement">
                                <img alt="Badge" src="<?= $achievement['badge_src'] ?>" title="<?= $achievement['achievement_name'] ?>" width="50">
                                <div class="achievement-rank"><?= $achievement['achievement_name'] ?></div>
                                <div class="achievement-date"><?= date('d-m-Y', $achievement['time']) ?></div>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="divider nav-pad-top"></div>
        <div class="user-profile-form">
            <?= $this->render('_form', [
                'userProfile' => $userProfile,
                'userModel'   => $userModel
            ]) ?>
        </div>
    </div>
    <div class="panel-footer text-right">
        <?= Html::submitButton('Готово', [
            'id'    => 'send-profile',
            'class' => 'btn btn-primary btn-sm ph15'
        ]) ?>
    </div>
</div>