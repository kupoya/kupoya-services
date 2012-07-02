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
							<li><a href="<?=base_url().'operator/view_contact'?>" class="default-tab current" rel="tooltip" title="Switch to next tab"><?=lang('operator:profile')?></a></li>
							<li><a href="<?=base_url().'operator/change_password'?>" rel="tooltip" title="Switch to next tab"><?=lang('operator:change_password')?></a></li>
						</ul>
					</nav>
					<!-- /Article Header Tab Navigation -->
				</header>
				<!-- /Article Header -->

				<!-- Article Content -->
				<section>

					<!-- Tab Content #tab0 -->
					<div class="tab default-tab" id="tab0">

							<form name='operator' action='<?php echo base_url().'operator/view_contact'?>' method='post'>
								<!-- Inputs -->
								<!-- Use class .small, .medium or .large for predefined size -->
								<input type='hidden' name='operator_id'
									value='<?= set_value('operator_id', isset($operator['id']) ? $operator['id'] : '')  ?>' />
								<fieldset>
									<legend><?=lang('operator:profile')?></legend>
									<dl>
										<dt>
											<label><?=lang('Name')?></label>
										</dt>
										<dd>
											<?php $err = form_error('contact[name]'); ?>
											<input type="text" class="medium <?php if ($err) echo 'invalid'; ?>"
												name="contact[name]" maxlength='45'
												value='<?= set_value('contact[name]', isset($contact['name']) ? $contact['name'] : '')  ?>'
												>
											<?php if ($err) echo '<span class="invalid-side-note">' . $err .'</span>'; ?>
										</dd>

										<dt>
											<label><?=lang('First_Name')?></label>
										</dt>
										<dd>
											<?php $err = form_error('contact[first_name]'); ?>
											<input type="text" class="large <?php if ($err) echo 'invalid'; ?>"
												name="contact[first_name]" maxlength='100'
												value='<?= set_value('contact[first_name]', isset($contact['first_name']) ? $contact['first_name'] : '')  ?>'
												>
											<?php if ($err) echo '<span class="invalid-side-note">' . $err .'</span>'; ?>
										</dd>

										<dt>
											<label><?=lang('Last_Name')?></label>
										</dt>
										<dd>
											<?php $err = form_error('contact[last_name]'); ?>
											<input type="text" class="large <?php if ($err) echo 'invalid'; ?>"
												name="contact[last_name]" maxlength='100'
												value='<?= set_value('contact[last_name]', isset($contact['last_name']) ? $contact['last_name'] : '')  ?>'
												>
											<?php if ($err) echo '<span class="invalid-side-note">' . $err .'</span>'; ?>
										</dd>

										<dt>
											<label><?=lang('Address')?></label>
										</dt>
										<dd>
											<?php $err = form_error('contact[address]'); ?>
											<input type="text" class="medium <?php if ($err) echo 'invalid'; ?>"
												name="contact[address]" maxlength='45'
												value='<?= set_value('contact[address]', isset($contact['address']) ? $contact['address'] : '')  ?>'
												>
											<?php if ($err) echo '<span class="invalid-side-note">' . $err .'</span>'; ?>
										</dd>

										<dt>
											<label><?=lang('City')?></label>
										</dt>
										<dd>
											<?php $err = form_error('contact[city]'); ?>
											<input type="text" class="medium <?php if ($err) echo 'invalid'; ?>"
												name="contact[city]" maxlength='45'
												value='<?= set_value('contact[city]', isset($contact['city']) ? $contact['city'] : '')  ?>'
												>
											<?php if ($err) echo '<span class="invalid-side-note">' . $err .'</span>'; ?>
										</dd>

										<dt>
											<label><?=lang('State')?></label>
										</dt>
										<dd>
											<?php $err = form_error('contact[state]'); ?>
											<input type="text" class="medium <?php if ($err) echo 'invalid'; ?>"
												name="contact[state]" maxlength='45'
												value='<?= set_value('contact[state]', isset($contact['state']) ? $contact['city'] : '')  ?>'
												>
											<?php if ($err) echo '<span class="invalid-side-note">' . $err .'</span>'; ?>
										</dd>


										<dt>
											<label><?=lang('Country')?></label>
										</dt>
										<dd>
											<?php $err = form_error('contact[country]'); ?>
											<input type="text" class="medium <?php if ($err) echo 'invalid'; ?>"
												name="contact[country]" maxlength='45'
												value='<?= set_value('contact[country]', isset($contact['country']) ? $contact['country'] : '')  ?>'
												>
											<?php if ($err) echo '<span class="invalid-side-note">' . $err .'</span>'; ?>
										</dd>

										<dt>
											<label><?=lang('Email')?></label>
										</dt>
										<dd>
											<?php $err = form_error('contact[email]'); ?>
											<input type="text" class="large <?php if ($err) echo 'invalid'; ?>"
												name="contact[email]" maxlength='45'
												value='<?= set_value('contact[email]', isset($contact['email']) ? $contact['email'] : '')  ?>'
												>
											<?php if ($err) echo '<span class="invalid-side-note">' . $err .'</span>'; ?>
										</dd>

										<dt>
											<label><?=lang('operator:contact:purpose')?></label>
										</dt>
										<dd class="text">
											<p><?=lang('operator:contact:purpose:text')?></p>
										</dd>
									</dl>
								</fieldset>
								<button type="submit"><?=lang('Save')?></button>
							</form>

					</div>
					<!-- /Tab Content #tab0 -->

				</section>
				<!-- /Article Content -->