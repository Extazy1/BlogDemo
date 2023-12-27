<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php foreach($comments as $comment): ?>

<div class="comment">

	<div class="row">
		<div class="col-md-12">
			<div class="comment_detail">
			<div class="bg-info p-3">
  <div class="d-flex align-items-center">
    <i class="bi bi-person-fill" aria-hidden="true"></i>
    <em><?= Html::encode($comment->user->username);?>;</em>
  </div>
  <br>
  <?= nl2br($comment->content);?>
  <br>
  <div class="d-flex align-items-center">
    <i class="bi bi-clock" aria-hidden="true"></i>
    <em><?= date('Y-m-d H:i:s',$comment->create_time);?>;</em>
  </div>
</div>


      </div>	 
		</div>
	</div>
</div>
</div>

<?php endforeach;?>