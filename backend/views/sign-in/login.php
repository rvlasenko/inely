<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \backend\models\LoginForm */

$this->title = Yii::t('backend', 'Sign In');
$this->params['breadcrumbs'][] = $this->title;
$this->params['body-class'] = 'login-page';
$this->registerJs('$.backstretch([
        "../img/media/1.jpg",
        "../img/media/3.jpg"
        ], {
          fade: 1000,
          duration: 6000
    }
    );');
?>
<body class="login-page skin-blue fixed">
<div class="login-box">
    <div class="login-logo">
        <?= Html::encode($this->title) ?>
    </div>
    <!-- /.login-logo -->
    <div class="header"></div>
    <div class="login-box-body">
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
        <?= $form->field($model, 'username', [
            'inputOptions' => [
                'placeholder' => $model->getAttributeLabel('username')
            ],
            'template' => '<div class="input-icon"><i class="fa fa-user"></i>{input}{error}</div>'
        ]) ?>
        <?= $form->field($model, 'password', [
            'inputOptions' => [
                'placeholder' => $model->getAttributeLabel('password')
            ],
            'template' => '<div class="input-icon"><i class="fa fa-lock"></i>{input}{error}</div>'
        ])->passwordInput() ?>
        <?= Html::submitButton(Yii::t('backend', 'Sign me in'), [
            'class' => 'btn blue pull-right',
            'name' => 'login-button'
        ]) ?>
        <?= $form->field($model, 'rememberMe')->checkbox(['class' => 'simple', 'template' => 'Remember me<div class="checker" style="float: left"><span class="checked">{input}</span></div>']) ?>
        </div>
        <?php ActiveForm::end(); ?>

</div>

</body>