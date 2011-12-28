<?php
/*
echo "<br/><br/>";
if (isset($message)) echo $message;
echo "<br/><br/>";

echo validation_errors();
echo "<br/><br/>";
echo "<br/><br/>";

var_dump($brand);
echo "<br/><br/>";
var_dump($contact);

echo "<br/><br/>";
echo "<br/><br/>";

//var_dump($error);
echo "<br/><br/>";
*/
?>
				<!-- Article Header -->
				<header>
					<h2><?=lang('brand:my_brand')?></h2>
					<!-- Article Header Tab Navigation -->
					<nav>
						<ul class="tab-switch">
							<li><a class="default-tab" href="#tab0" rel="tooltip" title="Switch to next tab"><?=lang('Settings')?></a></li>
							<li><a href="#tab_logo" rel="tooltip" title="Switch to next tab"><?=lang('Logo')?></a></li>
						</ul>
					</nav>
					<!-- /Article Header Tab Navigation -->
				</header>
				<!-- /Article Header -->

				<!-- Article Content -->
				<section>

					<!-- Tab Content #tab0 -->
					<div class="tab default-tab" id="tab0">

							<form name='operator' action='<?php echo base_url().'brand/edit_brand'?>' method='post'>
								<!-- Inputs -->
								<!-- Use class .small, .medium or .large for predefined size -->
								<input type='hidden' name='brand[id]'
									value='<?= set_value('brand[id]', isset($brand['id']) ? $brand['id'] : '')  ?>' />
								<fieldset>
									<legend><?=lang('settings')?></legend>
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
											<label><?=lang('brand:description')?></label>
										</dt>
										<dd>
											<!-- Use class .wysiwyg for jQuery jWYSIWYG initiation -->
											<?php $err = form_error('brand[description]'); ?>
											<textarea rows="5" cols="40" class="wysiwyg large <?php if ($err) echo 'invalid'; ?>" maxlength='512' name='brand[description]'><?= set_value('brand[description]', isset($brand['description']) ? $brand['description'] : '')  ?></textarea>
											<?php if ($err) echo '<span class="invalid-side-note">' . $err .'</span>'; ?>
											<p><?=lang('brand:description:tooltip')?></p>
										</dd>
										<dt>
											<label><?=lang('brand:name:purpose')?></label>
										</dt>
										<dd class="text">
											<p><?=lang('brand:name:purpose:text')?></p>
										</dd>
									</dl>
								</fieldset>
								<button type="submit">Submit</button>
							</form>

					</div>
					<!-- /Tab Content #tab0 -->


					<!-- Tab Content #tab_logo -->
					<div class="tab" id="tab_logo">

							<?php echo form_open_multipart('brand/edit_brand_picture');?>
								<!-- Inputs -->
								<!-- Use class .small, .medium or .large for predefined size -->
								<input type='hidden' name='brand_id'
									value='<?= set_value('brand_id', isset($brand['id']) ? $brand['id'] : '')  ?>' />
								<fieldset>
									<legend><?=lang('brand:logo')?></legend>
									<div class="image frame right">
										<img src="<?= isset($brand['picture']) ? base_url() . $brand['picture'] : '' ?>" />
									</div>
									<dl>
										<dt>
											<label><?=lang('brand:picture')?></label>
										</dt>
										<dd>
											<input type="file" name="brand_picture" class="fileupload">
											<p><?=lang('brand:picture:tooltip')?></p>
										</dd>
									</dl>
								</fieldset>
								<button type="submit">Submit</button>
							</form>

					</div>
					<!-- /Tab Content #tab_logo -->
