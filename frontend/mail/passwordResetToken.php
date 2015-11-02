<?php $resetLink = Yii::$app->urlManager->createAbsoluteUrl([
    '/resetpass',
    'token' => $user->password_reset_token
]) ?>

<table width="100%" bgcolor="#f6f4f5" cellpadding="0" cellspacing="0" border="0" st-sortable="bigimage">
    <tbody>
    <tr>
        <td>
            <table bgcolor="#ffffff" width="580" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth" modulebg="edit">
                <tbody>
                <tr>
                    <td width="100%" height="20"></td>
                </tr>
                <tr>
                    <td>
                        <table width="540" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidthinner">
                            <tbody>

                            <!-- Spacing -->
                            <tr>
                                <td width="100%" height="20"></td>
                            </tr>
                            <!-- Spacing --><!-- title -->
                            <tr>
                                <td style="font-family: Helvetica, arial, sans-serif; font-size: 18px; color: #333333; text-align:left;line-height: 20px;" st-title="rightimage-title">
                                    <?= Yii::t('mail', 'Hello, {username}!', [ 'username' => $user->username ]) ?>
                                </td>
                            </tr>
                            <!-- end of title --><!-- Spacing -->
                            <tr>
                                <td width="100%" height="20"></td>
                            </tr>
                            <!-- Spacing --><!-- content -->
                            <tr>
                                <td style="font-family: Helvetica, arial, sans-serif; font-size: 13px; color: #95a5a6; text-align:left;line-height: 24px;" st-content="rightimage-paragraph">
                                    <?= Yii::t('mail', 'Someone recently requested a password change for your Inely account. If this was you, you can set a new password by click on link below.') ?>
                                    <br><br>
                                    <?= Yii::t('mail', 'If you don\'t want to change your password or didn\'t request this, just ignore and delete this message.') ?>
                                </td>
                            </tr>
                            <!-- end of content --><!-- Spacing -->
                            <tr>
                                <td width="100%" height="10"></td>
                            </tr>
                            <!-- button -->
                            <tr>
                                <td>
                                    <table height="30" align="left" valign="middle" border="0" cellpadding="0" cellspacing="0" class="tablet-button" st-button="read-more-button" bgcolor="#0db9ea" style="background-color:#0db9ea; border-top-left-radius:4px; border-bottom-left-radius:4px;border-top-right-radius:4px; border-bottom-right-radius:4px; background-clip: padding-box;font-size:13px; font-family:Helvetica, arial, sans-serif; text-align:center;  color:#ffffff; font-weight: 300; padding-left:18px; padding-right:18px;">
                                        <tbody>
                                        <tr>
                                            <td width="auto" align="center" valign="middle" height="30" st-title="read-more-button" style="padding-left:18px; padding-right:18px;font-family:Helvetica, arial, sans-serif; text-align:center;  color:#ffffff; font-weight: 300;">
                                               <span style="color: #ffffff; font-weight: 300;">
                                                  <a style="color: #ffffff; text-align:center;text-decoration: none;" href="<?= \yii\helpers\Html::encode($resetLink) ?>" st-content="read-more-button"><?= Yii::t('mail', 'Reset password') ?></a>
                                               </span>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <!-- /button --><!-- Spacing -->
                            <tr>
                                <td width="100%" height="20"></td>
                            </tr>
                            <!-- Spacing -->
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>