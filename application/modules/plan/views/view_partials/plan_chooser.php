<?php
?>
	<!-- Article Content -->
	<section>
		<!-- Accordion -->
		<ul class="accordion">
			<!-- Accordion Tab -->
			<?php if (isset($plans)):
				foreach($plans as $key => $value):
			?>

				<li>
					 <a class="accordion-switch" href="">
						<h3><?=$value['name']?></h3>
					</a>
					<div>
						<form method="post" action="<?php echo base_url().'plan/manage/upgrade'?>" name="plan_upgrade_form">

							<input type="hidden" name="plan[id]" value="<?=$value['id']?>" />
							<input type="hidden" name="strategy[id]" value="<?=$strategy['id']?>" />

							<p><?=$value['description']?></p>
							<?php if (isset($value['plan_type']) && $value['plan_type'] == 'expiration'): ?>
								Set Expiration Date <input type="text" name="plan[expiration_date]" class="datepicker small" value="" />
							<?php endif;?>
							<?php if (isset($value['plan_type']) && $value['plan_type'] == 'bank'): ?>
								<input type="hidden" name="plan[bank]" value="<?=$value['bank']?>" />
								With this plan you get <strong> <?=$value['bank']?> </strong> bank
							<?php endif;?>

							<button type="submit">Upgrade Plan</button>
						</form>

					</div>
				</li>

			<?php endforeach; endif; ?>
			<!-- /Accordion Tab -->
		</ul>
		<!-- /Accordion -->
	</section>
	<!-- /Article Content -->