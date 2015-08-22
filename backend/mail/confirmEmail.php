<?php
    use yii\helpers\Html;

    /* @var $this yii\web\View */
    /* @var $user common\models\User */
    /* @var $password */

    $confirmLink = Yii::$app->urlManager->createAbsoluteUrl([ 'confirm-email', 'token' => $user->email_confirm_token ]);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Активация</title>

    <style type="text/css">
        #outlook a {
            padding: 0;
        }

        body {
            width: 100% !important;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            margin: 0;
            padding: 0;
        }

        .ExternalClass {
            width: 100%;
        }

        .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {
            line-height: 100%;
        }

        #backgroundTable {
            margin: 0;
            padding: 0;
            width: 100% !important;
            line-height: 100% !important;
        }

        img {
            outline: none;
            text-decoration: none;
            border: none;
            -ms-interpolation-mode: bicubic;
        }

        a img {
            border: none;
        }

        .image_fix {
            display: block;
        }

        p {
            margin: 0px 0px !important;
        }

        table td {
            border-collapse: collapse;
        }

        table {
            border-collapse: collapse;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        a {
            color: #0a8cce;
            text-decoration: none;
            text-decoration: none !important;
        }

        table[class=full] {
            width: 100%;
            clear: both;
        }

        /* IPAD STYLES */
        @media only screen and (max-width: 640px) {
            a[href^="tel"], a[href^="sms"] {
                text-decoration: none;
                color: #0a8cce;
                pointer-events: none;
                cursor: default;
            }

            .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
                text-decoration: default;
                color: #0a8cce !important;
                pointer-events: auto;
                cursor: default;
            }

            table[class=devicewidth] {
                width: 440px !important;
                text-align: center !important;
            }

            table[class=devicewidthinner] {
                width: 420px !important;
                text-align: center !important;
            }

            img[class=banner] {
                width: 440px !important;
                height: 220px !important;
            }

            img[class=colimg2] {
                width: 440px !important;
                height: 220px !important;
            }

        }

        /* IPHONE STYLES */
        @media only screen and (max-width: 480px) {
            a[href^="tel"], a[href^="sms"] {
                text-decoration: none;
                color: #0a8cce;
                pointer-events: none;
                cursor: default;
            }

            .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
                text-decoration: default;
                color: #0a8cce !important;
                pointer-events: auto;
                cursor: default;
            }

            table[class=devicewidth] {
                width: 280px !important;
                text-align: center !important;
            }

            table[class=devicewidthinner] {
                width: 260px !important;
                text-align: center !important;
            }

            img[class=banner] {
                width: 280px !important;
                height: 140px !important;
            }

            img[class=colimg2] {
                width: 280px !important;
                height: 140px !important;
            }

            td[class=mobile-hide] {
                display: none !important;
            }

            td[class="padding-bottom25"] {
                padding-bottom: 25px !important;
            }

        }
    </style>
</head>
<body>

<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable"
       st-sortable="header">
    <tbody>
    <tr>
        <td>
            <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
                <tbody>
                <tr>
                    <td width="100%">
                        <table width="600" cellpadding="0" cellspacing="0" border="0" align="center"
                               class="devicewidth">
                            <tbody>
                            <tr>
                                <td height="20" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
                                    &nbsp;</td>
                            </tr>
                            <tr>
                                <td>
                                    <table width="140" align="center" border="0" cellpadding="0" cellspacing="0"
                                           class="devicewidth">
                                        <tbody>
                                        <tr>
                                            <td width="169" height="45" align="center">
                                                <div class="imgpop">
                                                    <a target="_blank" href="#">
                                                        <img src="logo.png" alt="" border="0" width="169" height="45"
                                                             style="display:block; border:none; outline:none; text-decoration:none;">
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td height="20" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
                                    &nbsp;</td>
                            </tr>
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
<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable"
       st-sortable="seperator">
    <tbody>
    <tr>
        <td>
            <table width="600" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
                <tbody>
                <tr>
                    <td align="center" height="20" style="font-size:1px; line-height:1px;">&nbsp;</td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable"
       st-sortable="full-text">
    <tbody>
    <tr>
        <td>
            <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
                <tbody>
                <tr>
                    <td width="100%">
                        <table width="600" cellpadding="0" cellspacing="0" border="0" align="center"
                               class="devicewidth">
                            <tbody>
                            <tr>
                                <td height="20" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
                                    &nbsp;</td>
                            </tr>
                            <tr>
                                <td>
                                    <table width="560" align="center" cellpadding="0" cellspacing="0" border="0"
                                           class="devicewidthinner">
                                        <tbody>
                                        <tr>
                                            <td style="font-family: Tahoma, sans-serif;font-size: 30px; text-align:center; line-height: 30px;"
                                                st-title="fulltext-heading">
                                                Привет, <?= Html::encode($user->username) ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="100%" height="20"
                                                style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
                                                &nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="font-family: Tahoma, sans-serif; font-size: 16px; text-align:center; line-height: 30px;"
                                                st-content="fulltext-content">
                                                Вы зарегистрировались на madeasy со следующими данными:<br>
                                                Логин: <?= Html::encode($user->username) ?><br>
                                                <?php if (!empty($password)) echo "Пароль: $password<br>" ?>
                                                Пожалуйста, сохраните Ваши данные и не сообщайте их третьим лицам.<br><br>
                                                <a href="<?= Html::encode($confirmLink) ?>"
                                                   style="text-decoration: none; color: #0a8cce">Активируйте мою запись!
                                                </a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td height="20" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
                                    &nbsp;</td>
                            </tr>
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
<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable"
       st-sortable="seperator">
    <tbody>
    <tr>
        <td>
            <table width="600" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
                <tbody>
                <tr>
                    <td align="center" height="30" style="font-size:1px; line-height:1px;">&nbsp;</td>
                </tr>
                <tr>
                    <td width="550" align="center" height="1" bgcolor="#d1d1d1" style="font-size:1px; line-height:1px;">
                        &nbsp;</td>
                </tr>
                <tr>
                    <td align="center" height="30" style="font-size:1px; line-height:1px;">&nbsp;</td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable"
       st-sortable="postfooter">
    <tbody>
    <tr>
        <td>
            <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
                <tbody>
                <tr>
                    <td width="100%">
                        <table width="600" cellpadding="0" cellspacing="0" border="0" align="center"
                               class="devicewidth">
                            <tbody>
                            <tr>
                                <td align="center" valign="middle"
                                    style="font-family: Tahoma, sans-serif; font-size: 14px;color: #666666"
                                    st-content="postfooter">
                                    Добро пожаловать на madeasy. Надеемся, Вам у нас понравится!
                                </td>
                            </tr>
                            <tr>
                                <td width="100%" height="20"></td>
                            </tr>
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
</body>
</html>