<?php

// if (isset($message)) echo $message;

// echo validation_errors();

// var_dump($strategy);
// var_dump($plan);

// var_dump($advertisement);

// var_dump($advertisement_blocks);


// //var_dump($error);

$data['strategy'] = $strategy;
$data['campaign'] = $campaign;
$data['plan'] = $plan;

$advertisement_view_url = '#';
if (isset($campaign['id']) && isset($strategy['id']))
	$advertisement_view_url = base_url().'strategy/manage/view/'.$strategy['id'].'/'.$campaign['id'];

$advertisement_edit_url = '#';
if (isset($campaign['id']) && isset($strategy['id']))
	$advertisement_edit_url = base_url().'strategy/manage/edit/'.$strategy['id'].'/'.$campaign['id'];
	
$advertisement_statistics_url = '#';
if (isset($campaign['id']) && isset($strategy['id']))
	$advertisement_statistics_url = base_url().'strategy/reports/overview/index/'.$strategy['id'].'/'.$campaign['id'];

?>


				<!-- Article Header -->
				<header>
					<h2><?=lang('advertisement:my_campaign')?></h2>
					<!-- Article Header Tab Navigation -->
					<nav>
						<ul class="tab-switch-url">
							<li><a href="<?=$advertisement_view_url; ?>" rel="tooltip" advertisement_statistics_urle="Switch to next tab"><?=lang('View')?></a></li>
							<li><a href="<?=$advertisement_statistics_url; ?>" rel="tooltip" title="Switch to next tab"><?=lang('Statistics')?></a></li>
							<li><a href="<?=$advertisement_edit_url; ?>" class="default-tab current" rel="tooltip" title="Switch to next tab"><?=lang('Edit')?></a></li>
						</ul>
					</nav>
					<!-- /Article Header Tab Navigation -->
				</header>
				<!-- /Article Header -->

				<!-- Article Content -->
				<section>

					<!-- Tab Content #tab0 -->
					<div class="tab default-tab" id="tab0">

						<div>
							<h3>Wizard</h3>
							<!-- Wizard -->
							<!-- Wizard Steps -->
							<ol class="wizard-steps">
								<li><a href="#strategy"><?=lang('Strategy')?></a></li>
								<li><a href="#advertisement"><?=lang('advertisement:settings')?></a></li>
								<li><a href="#plan"><?=lang('Plan')?></a></li>
							</ol>
							<!-- /Wizard Steps -->
							
							<!-- Wizard Item -->
							<div id="strategy" class="wizard-content">
								<h4>Wizard Step 1</h4>

								<form name='advertisement' action='<?php echo base_url().'advertisement/save'?>' method='post'>
								<!-- Inputs -->
								<!-- Use class .small, .medium or .large for predefined size -->
								<input type='hidden' name='strategy[id]'
									value='<?= set_value('strategy[id]', isset($strategy['id']) ? $strategy['id'] : '')  ?>' />
								<fieldset>
									<legend><?=lang('settings')?></legend>
									<dl>

										<dt>
											<label><?=lang('advertisement:strategy_name')?></label>
										</dt>
										<dd>
											<?php $err = form_error('strategy[name]'); ?>
											<input type="text" class="large <?php if ($err) echo 'invalid'; ?>"
												name="strategy[name]" maxlength='100'
												value='<?= set_value('strategy[name]', isset($strategy['name']) ? $strategy['name'] : '')  ?>' />
											<?php if ($err) echo '<span class="invalid-side-note">' . $err .'</span>'; ?>
											<p><?=lang('advertisement:strategy_name:tooltip')?></p>
										</dd>

										<!-- Next item -->

										<dt>
											<label><?=lang('advertisement:strategy_description')?></label>
										</dt>
										<dd>
											<?php $err = form_error('strategy[description]'); ?>
											<input type="text" class="large <?php if ($err) echo 'invalid'; ?>"
												name="strategy[description]" maxlength='100'
												value='<?= set_value('strategy[description]', isset($strategy['description']) ? $strategy['description'] : '')  ?>' />
											<?php if ($err) echo '<span class="invalid-side-note">' . $err .'</span>'; ?>
											<p><?=lang('advertisement:strategy_description:tooltip')?></p>
										</dd>

										<!-- Next item -->

										<dt>
											<label><?=lang('advertisement:strategy_website')?></label>
										</dt>
										<dd>
											<?php $err = form_error('strategy[website]'); ?>
											<input type="text" class="large <?php if ($err) echo 'invalid'; ?>"
												name="strategy[website]" maxlength='100'
												value='<?= set_value('strategy[website]', isset($strategy['website']) ? $strategy['website'] : '')  ?>' />
											<?php if ($err) echo '<span class="invalid-side-note">' . $err .'</span>'; ?>
											<p><?=lang('advertisement:strategy_website:tooltip')?></p>
										</dd>

										<!-- Next item -->

										<dt>
											<label> &nbsp; </label>
										</dt>
										<dd>
											<button type="submit"><?=lang('Submit');?></button>
										</dd>

									</dl>
								</fieldset>
								</form>

								<?php echo form_open_multipart('advertisement/edit_strategy_picture');?>
								<input type='hidden' name='strategy_id'
									value='<?= set_value('strategy_id', isset($strategy['id']) ? $strategy['id'] : '')  ?>' />
								<input type='hidden' name='campaign_id'
									value='<?= set_value('campaign_id', isset($campaign['id']) ? $campaign['id'] : '')  ?>' />
								<fieldset>
									<legend><?=lang('settings')?></legend>
									<dl>
										<div class="image frame right">
											<img src="<?= isset($strategy['picture']) ? base_url() . $strategy['picture'] : '' ?>" />
										</div>
										<dt>
											<label><?=lang('advertisement:picture')?></label>
										</dt>
										<dd>
											<input type="file" name="strategy_picture" class="fileupload">
											<p><?=lang('brand:picture:tooltip')?></p>
										</dd>

										<!-- Next item -->


										<dt>
											<label> &nbsp; </label>
										</dt>
										<dd>
											<button type="submit"><?=lang('Submit');?></button>
										</dd>

									</dl>
								</fieldset>
								</form>

							</div>

							<!-- Wizard Item -->
							<div id="advertisement" class="wizard-content">

								<form name='advertisement' action='<?php echo base_url().'advertisement/save'?>' method='post'>
								<!-- Inputs -->
								<!-- Use class .small, .medium or .large for predefined size -->
								<input type='hidden' name='strategy[id]'
									value='<?= set_value('strategy[id]', isset($strategy['id']) ? $strategy['id'] : '')  ?>' />
								<fieldset>
									<legend><?=lang('settings')?></legend>
									<dl>

										<dt>
											<label><?=lang('advertisement:redirect_url')?></label>
										</dt>
										<dd>
											<?php $err = form_error('advertisement[redirect_url]'); ?>
											<input type="text" class="large <?php if ($err) echo 'invalid'; ?>"
												name="advertisement[redirect_url]" maxlength='100'
												value='<?= set_value('advertisement[redirect_url]', isset($advertisement['redirect_url']) ? $advertisement['redirect_url'] : '')  ?>' />
											<?php if ($err) echo '<span class="invalid-side-note">' . $err .'</span>'; ?>
											<p><?=lang('advertisement:redirect_url:tooltip')?></p>
										</dd>

										<!-- Next item -->

										<dt>
											<label><?=lang('advertisement:block_1')?></label>
										</dt>
										<dd>
											<?php $err = form_error('advertisement_blocks[block_1]'); ?>
											<textarea rows="5" cols="40" class="wysiwyg large <?php if ($err) echo 'invalid'; ?>"><?= set_value('advertisement_blocks[block_1]', isset($advertisement_blocks['block_1']) ? $advertisement_blocks['block_1'] : '')  ?></textarea>
											<?php if ($err) echo '<span class="invalid-side-note">' . $err .'</span>'; ?>
											<p><?=lang('advertisement:block_1:tooltip')?></p>
										</dd>

										<!-- Next item -->

									</dl>
								</fieldset>
								<button type="submit"><?=lang('Submit');?></button>
								</form>

							</div>

							<!-- Wizard Item -->
							<div id="plan" class="wizard-content">							

<?php
	echo Modules::run('advertisement/advertisement_manage/_partial_plan_usage_info', $data);
?>


<?php
	echo Modules::run('order/order_manage/_get_order_history', $data);
	?>

							</div>

						</div>
					</div>
					<!-- /Tab Content #tab0 -->

				</section>
				<!-- /Article Content -->