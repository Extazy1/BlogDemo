<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use common\models\User;

/** @var yii\web\View $this */
/** @var common\models\Adminuser $model */

$model = User::findOne($id);

$this->title = '权限设置: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => '用户管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $id]];
$this->params['breadcrumbs'][] = '权限设置';
?>

<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>


    <div class="user-privilege-form">

    <?php $form = ActiveForm::begin(); ?>

	<?= Html::checkboxList('newPri',$AuthAssignmentArray,$allPrivilegesArray);?>

    <div class="form-group">
        <?= Html::submitButton('设置') ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
