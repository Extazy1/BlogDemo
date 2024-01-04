 <?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Poststatus;
use common\models\Adminuser;
use dosamigos\ckeditor\CKEditor;

/** @var yii\web\View $this */
/** @var common\models\Post $model */
/** @var common\models\Poststatus $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->widget(CKEditor::className(), [
    'options' => ['rows' => 6],
    'preset' => 'basic'
    ]) ?>

    <?= $form->field($model, 'tags')->textarea(['rows' => 6]) ?>

    <?= $form->field($model,'status')
         ->dropDownList(Poststatus::find()
						->select(['name','id'])
						->orderBy('position')
						->indexBy('id')
						->column(),
    		   ['prompt'=>'请选择状态']);?>
     		   
        <?= $form->field($model,'author_id')
         ->dropDownList(Adminuser::find()
						->select(['nickname','id'])
						->indexBy('id')
						->column(),
    		   ['prompt'=>'请选择作者']);?>

    <div class="form-group">
        <?= Html::submitButton('提交', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
