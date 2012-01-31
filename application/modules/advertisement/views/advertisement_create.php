<?php

//var_dump($plans);
if (!isset($plans))
	$plans = array();
?>


	<?php
		$form_errors = validation_errors();
		if ($form_errors != ''):
	?>
		<div class="notification error">
			<a href="#" class="close-notification" title="Hide Notification" rel="tooltip">x</a>
			<p><strong>Errors in the form</strong>
				<?php echo $form_errors ?>
			</p>
		</div>
	<?php endif; ?>

	<header>
		<h2>
			Create a new campaign
		</h2>
	</header>

		<form name='advertisement' action='<?php echo base_url().'advertisement/create'?>' method='post'>
			<!-- Inputs -->
			<!-- Use class .small, .medium or .large for predefined size -->
			<input type='hidden' name='strategy[id]'
				value='<?= set_value('strategy[id]', isset($strategy['id']) ? $strategy['id'] : '')  ?>' />
			<fieldset>
				<legend>Basic Campaign Info</legend>
				<dl>

					<dt>
						<label>Campaign Name</label>
					</dt>
					<dd>
						<?php $err = form_error('strategy[name]'); ?>
						<input type="text" class="medium <?php if ($err) echo 'invalid'; ?>"
							name="strategy[name]" maxlength='100'
							value='<?= set_value('strategy[name]', isset($strategy['name']) ? $strategy['name'] : '')  ?>' />
						<?php if ($err) echo '<span class="invalid-side-note">' . $err .'</span>'; ?>
						<p>This name identifies your campaign strategy name</p>
					</dd>

					<!-- Next item -->

				</dl>
			</fieldset>

			<fieldset>
				<legend>Choose a plan to start with...</legend>

					<?php foreach($plans as $key => $value): ?>

						<input type="radio" name="plan[id]" value="<?=$value['id']?>">
						<label><?= $value['name']?></label>
						<br/>
						<ul>
							<p><?= $value['description']?> </p>
							<?php if (isset($value['plan_type']) && $value['plan_type'] == 'expiration'): ?>
							Set Expiration Date <input type="text" name="plan[expiration_date]" class="datepicker small" value="" />
							<?php endif; ?>
						</ul>

					<?php endforeach; ?>

			</fieldset>

			<button type="submit"><?=lang('Submit');?></button>
			</form>