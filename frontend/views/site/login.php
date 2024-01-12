<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = '登录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>请输入用户名和密码:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label("用户名") ?>

                <?= $form->field($model, 'password')->passwordInput()->label("密码") ?>

                <?= $form->field($model, 'rememberMe')->checkbox()->label("记住密码") ?>

                <div class="my-1 mx-0" style="color:#999;">
                    忘记密码 <?= Html::a('重置密码', ['site/request-password-reset']) ?>.
                    <br>
                    验证邮箱? <?= Html::a('发送验证码', ['site/resend-verification-email']) ?>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('登录', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
