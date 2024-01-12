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

$this->registerCssFile("https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.css");
$this->registerJsFile("https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.js", ['position' => \yii\web\View::POS_END]);
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(['id' => 'post-form'],['options' => ['enctype' => 'multipart/form-data']],); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <!-- 编辑器选择按钮 -->
    <div class="editor-selection">
        <button type="button" id="useCkEditor">使用 CKEditor</button>
        <button type="button" id="useMarkdown">使用 EasyMDE</button>
    </div>

    <!-- CKEditor -->
    <div id="ckeditorContainer" style="display:none;">
        <?= $form->field($model, 'content')->widget(CKEditor::className(), [
            'options' => ['rows' => 6],
            'preset' => 'basic'
        ]) ?>
    </div>

    <!-- EasyMDE Markdown Editor -->
    <div id="markdownContainer" style="display:none;">
        <?= $form->field($model, 'content')->textarea(['id' => 'easyMDE']) ?>
    </div>
    
    <?= $form->field($model, 'attachment[]')->fileInput(['multiple' => true, 'id' => 'attachmentInput'])->label(false) ?>
    <?= $form->field($model, 'tags')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->dropDownList(Poststatus::find()->select(['name','id'])->orderBy('position')->indexBy('id')->column(), ['prompt'=>'请选择状态']); ?>
    <?= $form->field($model, 'author_id')->dropDownList(Adminuser::find()->select(['nickname','id'])->indexBy('id')->column(), ['prompt'=>'请选择作者']); ?>

    <div class="form-group">
        <?= Html::submitButton('提交', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$this->registerJs("
document.getElementById('attachmentInput').addEventListener('change', function() {
    var fileName = this.files[0].name; // 获取选择的文件名
    // 将文件名显示在输入框下面。这里假设您有一个id为'filenameDisplay'的元素用来显示文件名。
    document.getElementById('post-attachment').textContent = fileName;
});

var easyMDE;

document.getElementById('useCkEditor').addEventListener('click', function() {
    document.getElementById('ckeditorContainer').style.display = 'block';
    document.getElementById('markdownContainer').style.display = 'none';
    if (easyMDE) {
        document.getElementById('easyMDE').value = easyMDE.value();
    }
});

document.getElementById('useMarkdown').addEventListener('click', function() {
    document.getElementById('ckeditorContainer').style.display = 'none';
    document.getElementById('markdownContainer').style.display = 'block';

    // 初始化 EasyMDE
    if (!easyMDE) {
        easyMDE = new EasyMDE({ element: document.getElementById('easyMDE') });
    }
});

// 当表单提交时，同步 EasyMDE 内容到 textarea
document.getElementById('post-form').addEventListener('submit', function() {
    if (easyMDE) {
        document.getElementById('easyMDE').value = easyMDE.value();
    }
});
", \yii\web\View::POS_READY);
?>