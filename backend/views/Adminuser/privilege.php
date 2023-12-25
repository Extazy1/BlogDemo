<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use common\models\Adminuser;

/** @var yii\web\View $this */
/** @var common\models\Adminuser $model */

$model = Adminuser::findOne($id);

$this->title = '权限设置: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => '管理员', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $id]];
$this->params['breadcrumbs'][] = '权限设置';
?>

<div class="adminuser-update">

    <h1><?= Html::encode($this->title) ?></h1>


    <div class="adminuser-privilege-form">

    <?php $form = ActiveForm::begin(); ?>

	<?= Html::checkboxList('newPri',$AuthAssignmentArray,$allPrivilegesArray);?>

    <div class="form-group">
        <?= Html::submitButton('设置') ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
