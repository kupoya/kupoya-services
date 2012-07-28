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

				<!-- Article Content -->
				<section>

					<!-- Tab Content #tab0 -->
					<div class="tab default-tab" id="tab0">

					<h7> <?=lang('brand:contact_info_helper') ?> </h7>

							<?php echo form_open_multipart('brand/edit_brand_info');?>
								<!-- Inputs -->
								<!-- Use class .small, .medium or .large for predefined size -->
								<input type='hidden' name='operator_id'
									value='<?= set_value('operator_id', isset($operator['id']) ? $operator['id'] : '')  ?>' />
								<input type='hidden' name='brand[id]'
									value='<?= set_value('brand[id]', isset($brand['id']) ? $brand['id'] : '')  ?>' />
								<fieldset>
									<legend><?=lang('brand:company_info')?></legend>
									<dl>
										
										<dt>
											<label><?=lang('brand:name')?></label>
										</dt>
										<dd>
											<?php $err = form_error('brand[name]'); ?>
											<input type="text" class="large <?php if ($err) echo 'invalid'; ?>"
												name="brand[name]" maxlength='100'
												value='<?= set_value('brand[name]', isset($brand['name']) ? $brand['name'] : '')  ?>'
												>
											<?php if ($err) echo '<span class="invalid-side-note">' . $err .'</span>'; ?>
											<p><?=lang('brand:name:tooltip')?></p>
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
											<span class="invalid-side-note">
												required
											</span>
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
											<span class="invalid-side-note">
												required
											</span>
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
											<span class="invalid-side-note">
												required
											</span>
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
											<span class="invalid-side-note">
												required
											</span>
										</dd>

										<dt>
											<label><?=lang('Postal_Code')?></label>
										</dt>
										<dd>
											<?php $err = form_error('contact[zip]'); ?>
											<input type="text" class="small <?php if ($err) echo 'invalid'; ?>"
												name="contact[zip]" maxlength='45'
												value='<?= set_value('contact[zip]', isset($contact['zip']) ? $contact['zip'] : '')  ?>'
												>
											<?php if ($err) echo '<span class="invalid-side-note">' . $err .'</span>'; ?>
										</dd>

										<dt>
											<label><?=lang('Phone')?></label>
										</dt>
										<dd>
											<?php $err = form_error('contact[phone]'); ?>
											<input type="text" class="small <?php if ($err) echo 'invalid'; ?>"
												name="contact[phone]" maxlength='45'
												value='<?= set_value('contact[phone]', isset($contact['phone']) ? $contact['phone'] : '')  ?>'
												>
											<?php if ($err) echo '<span class="invalid-side-note">' . $err .'</span>'; ?>
											<span class="invalid-side-note">
												required
											</span>
											<p><?=lang('Phone:helper')?></p>
										</dd>

										<dt>
											<label><?=lang('Fax')?></label>
										</dt>
										<dd>
											<?php $err = form_error('contact[fax]'); ?>
											<input type="text" class="small <?php if ($err) echo 'invalid'; ?>"
												name="contact[fax]" maxlength='45'
												value='<?= set_value('contact[fax]', isset($contact['fax']) ? $contact['fax'] : '')  ?>'
												>
											<?php if ($err) echo '<span class="invalid-side-note">' . $err .'</span>'; ?>
											<p><?=lang('Phone:helper')?></p>
										</dd>

										<dt>
											<label><?=lang('brand:company_website')?></label>
										</dt>
										<dd>
											<?php $err = form_error('contact[website]'); ?>
											<input type="text" class="medium <?php if ($err) echo 'invalid'; ?>"
												name="contact[website]" maxlength='100'
												value='<?= set_value('contact[website]', isset($contact['website']) ? $contact['website'] : '')  ?>'
												>
											<?php if ($err) echo '<span class="invalid-side-note">' . $err .'</span>'; ?>
										</dd>

										<dl>
										<dt>
											<label><?=lang('brand:picture')?></label>
										</dt>
										<dd>
											<input type="file" name="brand_picture" class="fileupload">
											<p><?=lang('brand:picture:tooltip')?></p>
										</dd>
									</dl>

									</dl>
								</fieldset>
								<button type="submit"><?=lang('Update')?></button>
								&nbsp; 	<a href="<?= site_url('strategy/manage/index')?>">Cancel</a>
							</form>

					</div>
					<!-- /Tab Content #tab0 -->

				</section>
				<!-- /Article Content -->