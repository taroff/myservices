<script type="text/javascript">

function ajaxSave() {
	// get field values
	var title = $('#Note_title').val(); 
	var text = $('#Note_text').val();

	// clear values
	$('#Note_title').val(''); 
	$('#Note_text').val('');

	// ajax POST request for adding values 
	var request = $.ajax({
		url: '/note/save',
		type: 'POST',
		data: {'Ajax[title]': title, 'Ajax[text]': text},
		dataType: 'html'
	});

	request.done(function(msg) {
		alert( msg );
	});

	request.fail(function(jqXHR, textStatus) {
		alert( "Error: " + textStatus );
	});

	// cancel btn handler
	return false;
}

$(document).ready(
	function() {
		$('#saveBtn').click( ajaxSave );
	}
)

</script>

<h1>Notes</h1>

<div style="width:25%;float:left;background-color:#CCC">
Categories
</div>

<div style="width:50%;float:left;background-color:#AAA">

<?php foreach( $data as $noteRow ): ?>
<div><?php echo $noteRow['title'] ?></div>
<?php endforeach ?>
</div>

<div style="width:25%;float:left">
<?php
/* @var $this NoteController */
/* @var $model Note */
/* @var $form CActiveForm */
?>

<div class="form">
<?php 
$form=$this->beginWidget('CActiveForm', array('id'=>'note-form','enableAjaxValidation'=>false,'action'=>'/note/save')); 
?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>40,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'tags'); ?>
		<?php echo $form->textField($model,'tags',array('size'=>40,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'tags'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'text'); ?>
		<?php echo $form->textArea($model,'text',array('rows'=>6, 'cols'=>32)); ?>
		<?php echo $form->error($model,'text'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array( 'id'=>'saveBtn' )); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

</div>