<?php

// echo "<br/><br/>";
// if (isset($message)) echo $message;
// echo "<br/><br/>";

// echo validation_errors();
// echo "<br/><br/>";
// echo "<br/><br/>";

// var_dump($operator);
// echo "<br/><br/>";
// var_dump($contact);

// echo "<br/><br/>";
// echo "<br/><br/>";

// //var_dump($error);


// echo "<br/><br/>";
?>


				<!-- Article Header -->
				<header>
					<h2><?=lang('operator:account')?></h2>
					<!-- Article Header Tab Navigation -->
					<nav>
						<ul class="tab-switch-url">
							<li><a href="<?=base_url().'operator/view_contact'?>" rel="tooltip" title="Switch to next tab"><?=lang('operator:profile')?></a></li>
							<li><a href="<?=base_url().'operator/change_password'?>" class="default-tab current" rel="tooltip" title="Switch to next tab"><?=lang('operator:change_password')?></a></li>
						</ul>
					</nav>
					<!-- /Article Header Tab Navigation -->
				</header>
				<!-- /Article Header -->

				<?=lang('operator:description')?>

				<!-- Article Content -->
				<section>

					<!-- Tab Content #tab0 -->
					<div class="tab default-tab" id="tab0">

						<form name='operator' action='<?php echo base_url().'operator/change_password'?>' method='post'>
								<!-- Inputs -->
								<!-- Use class .small, .medium or .large for predefined size -->
								<input type='hidden' name='operator[id]'
									value='<?= set_value('operator[id]', isset($operator['id']) ? $operator['id'] : '')  ?>' />
								<fieldset>

									<legend><?=lang('operator:change_password')?></legend>
									<dl>
										<dt>
											<label><?=lang('operator:old_password')?></label>
										</dt>
										<dd>
											<?php $err = form_error('old_password'); ?>
											<input type="password" class="large <?php if ($err) echo 'invalid'; ?>"
												name="old_password" maxlength='100'
												value='<?= set_value('old_password', '') ?>'
												>
											<?php if ($err) echo '<span class="invalid-side-note">' . $err .'</span>'; ?>
											<p><?=lang('operator:old_password:tooltip')?></p>
										</dd>

										<dt>
											<label><?=lang('operator:new_password')?></label>
										</dt>
										<dd>
											<?php $err = form_error('new_password'); ?>
											<input type="password" class="large <?php if ($err) echo 'invalid'; ?>"
												name="new_password" maxlength='100'
												value='<?= set_value('new_password', '') ?>'
												>
											<?php if ($err) echo '<span class="invalid-side-note">' . $err .'</span>'; ?>
											<p><?=lang('operator:new_password:tooltip')?></p>
										</dd>

										<dt>
											<label><?=lang('operator:new_password_confirm')?></label>
										</dt>
										<dd>
											<?php $err = form_error('new_password_confirm'); ?>
											<input type="password" class="large <?php if ($err) echo 'invalid'; ?>"
												name="new_password_confirm" maxlength='100'
												value='<?= set_value('new_password_confirm', '') ?>'
												>
											<?php if ($err) echo '<span class="invalid-side-note">' . $err .'</span>'; ?>
											<p><?=lang('operator:new_password_confirm:tooltip')?></p>
										</dd>
									</dl>
								</fieldset>
								<button type="submit"><?=lang('Save');?></button>
							</form>

					</div>
					<!-- /Tab Content #tab0 -->

				</section>
				<!-- /Article Content -->