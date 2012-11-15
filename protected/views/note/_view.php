<?php
/* @var $this NoteController */
/* @var $data Note */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_user')); ?>:</b>
	<?php echo CHtml::encode($data->id_user); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('text')); ?>:</b>
	<?php echo CHtml::encode($data->text); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dt_create')); ?>:</b>
	<?php echo CHtml::encode($data->dt_create); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dt_update')); ?>:</b>
	<?php echo CHtml::encode($data->dt_update); ?>
	<br />


</div>