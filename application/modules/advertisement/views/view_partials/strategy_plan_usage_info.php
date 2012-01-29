<?php
// var_dump($strategy);
$bank_remaining = (isset($strategy['exposure_count']) && isset($strategy['bank'])) ? ($strategy['bank'] - $strategy['exposure_count']) : 0;

$data = array();

if (isset($strategy))
	$data['strategy'] = $strategy;

if (isset($plan))
	$data['plan'] = $plan;

if (isset($plans))
	$data['plans'] = $plans;

if (isset($campaign))
	$data['campaign'] = $campaign;
?>



<!-- Half Content Block -->
<article class="half-block">

	<!-- Article Container for safe floating -->
	<div class="article-container">

		<header>
			<h2>Plan Information</h2>
		</header>
		
		<form name='plan_upgrade' action='<?php echo base_url().'plan/manage/upgrade'?>' method='post'>

		<input type='hidden' name='strategy[id]'
			value='<?= set_value('strategy[id]', isset($strategy['id']) ? $strategy['id'] : '')  ?>' />

		<fieldset>
			<legend><?=lang('settings')?></legend>
			<dl>

				<dt>
					<label><?=lang('advertisement:plan')?></label>
				</dt>
				<dd class="text">
					<?php if (isset($plan['name'])) echo $plan['name']; ?>
					<br/>
					<?php if (isset($plan['description'])) echo $plan['description']; ?>
				</dd>

				<!-- Next item -->	

				<?php if (isset($plan['plan_type']) && $plan['plan_type'] == 'expiration'): ?>
					<dt>
						<label>Expires in</label>
					</dt>
					<dd class="text">
						<?php if (isset($strategy['expiration_date'])) echo $strategy['expiration_date']; ?>
					</dd>

					<!-- Next item -->

					<dt>
						<label>Days till Expiration</label>
					</dt>
					<dd class="text">
						<?php if (isset($strategy['bank'])) echo $strategy['bank']; ?>
					</dd>

				<?php endif; ?>

				<?php if (isset($plan['plan_type']) && $plan['plan_type'] == 'bank'): ?>
					<dt>
						<label>Bank Total</label>
					</dt>
					<dd class="text">
						<?php if (isset($strategy['bank'])) echo $strategy['bank']; ?>
					</dd>

					<!-- Next item -->

					<dt>
						<label>Remaining bank</label>
					</dt>
					<dd class="text">
						<?php if (isset($bank_remaining)) echo $bank_remaining; ?>
					</dd>

				<?php endif; ?>

				<!-- Next item -->										

					<dt>
						<label>Upgrade Plan</label>
					</dt>
					<dd>
						<select name="plan[id]">
							<option value=''>Choose</option>
							<?php if (isset($plans)):
								foreach($plans as $key => $value):
							?>
								<option value="<?=$key?>"><?=$value['description']?></option>
							<?php endforeach; endif; ?>
						</select>
					</dd>

					<dt>
						<label> &nbsp;</label>
					</dt>
					<dd>
						<button type="submit">Upgrade Plan</button>
					</dd>
			</dl>
		</fieldset>
		
		</form>

	</div>
	<!-- /Article Container -->
	

	<?php
		echo Modules::run('plan/plan_manage/_partial_plan_chooser', $data);
	?>

</article>
<!-- /Half Content Block -->


<!-- Half Content Block -->
<article class="half-block clearrm">

	<!-- Article Container for safe floating -->
	<div class="article-container">

		<header>
			<h2>Understanding Upgrading Plans</h2>
		</header>
	
		<div class="notification attention">
			<a href="#" class="close-notification" title="Hide Notification" rel="tooltip">x</a>
			<p><strong>Attention notification</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vulputate, sapien quis fermentum luctus, libero.</p>
		</div>

	</div>
	<!-- /Article Container -->
	
</article>
<!-- /Half Content Block -->

<div class="clearfix"></div>
