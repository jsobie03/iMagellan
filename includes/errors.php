<?php  if (count($errors) > 0) : ?>
	<div class="error">
		<?php foreach ($errors as $error) : ?>
			<p><?php echo $error ?></p>
		<?php endforeach ?>
	</div>
<?php  endif ?>

<?php if (count($successes) > 0) : ?>
	<div class="success">
		<?php foreach ($successes as $success) : ?>
			<p><?php echo $success ?></p>
		<?php endforeach ?>
	</div>
<?php endif ?>

