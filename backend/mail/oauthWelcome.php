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
                                    <?= Yii::t('mail', 'Thank you for choosing Inely as your personal assistant.') ?>
                                    <br><br>
                                    <?= Yii::t('mail', 'Your user account with the e-mail address {email} has been created.', [ 'email' => $user->email ]) ?>
                                    <br>
                                    <?= Yii::t('mail', 'Your personal data Inely:') ?>
                                    <br>
                                    <br>
                                    <?= Yii::t('mail', 'Username: {username}', [ 'username' => $user->username ]) ?>
                                    <br>
                                    <?= Yii::t('mail', 'Password: {password}', [ 'password' => $password ]) ?>
                                </td>
                            </tr>
                            <!-- end of content --><!-- Spacing -->
                            <tr>
                                <td width="100%" height="10"></td>
                            </tr>
                            <!-- Spacing -->
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
