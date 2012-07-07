<?php
// $strategy['bank']
// $strategy['expiration_date']
/*

						<!-- Widget Box -->
						<div class="widget increase" id="new-visitors">
							<a href="#" class="close-widget" title="Hide Widget" rel="tooltip">x</a>
							<span>increase</span>
							<p><strong><?= $strategy['bank']?><sup>%</sup></strong> bank size</p>
						</div>
						<!-- /Widget Box -->

						<!-- Widget Box -->
						<div class="widget increase" id="new-visitors">
							<a href="#" class="close-widget" title="Hide Widget" rel="tooltip">x</a>
							<span>increase</span>
							<p><strong>+35,18<sup>%</sup></strong> +2489 new visitors</p>
						</div>
						<!-- /Widget Box -->
						
						<!-- Widget Box -->
						<div class="widget decrease" id="new-orders">
							<a href="#" class="close-widget" title="Hide Widget" rel="tooltip">x</a>
							<span>decrease</span>
							<p><strong>-12,50<sup>%</sup></strong> -311 new orders</p>
						</div>
						<!-- Widget Box -->
*/
?>

						<?php if (isset($widgets['strategy_uptime'])): ?>
							<!-- /Widget Box -->
							<div class="widget increase autowidth" id="new-tasks">
								<a href="#" class="close-widget" title="Hide Widget" rel="tooltip">x</a>
								<span><?php echo $widgets['strategy_uptime']; ?></span>
								<p><strong>Campaign Uptime</strong>number of days campaign is running</p>
							</div>
							<!-- Widget Box -->
						<?php endif; ?>

						<?php if (isset($widgets['strategy_bank_utilization'])): ?>
							<!-- /Widget Box -->
							<div class="widget increase autowidth" id="new-tasks">
								<a href="#" class="close-widget" title="Hide Widget" rel="tooltip">x</a>
								<span><?php echo $widgets['strategy_bank_utilization']['utilization']; ?>%</span>
								<p><strong>Campaign Utilization</strong>
									used <?= $widgets['strategy_bank_utilization']['coupons']?> microdeals out of <?= $widgets['strategy_bank_utilization']['bank']?>
								</p>
							</div>
							<!-- Widget Box -->
						<?php endif; ?>





						<?php if (isset($widgets['total_redemptions'])): ?>
							<!-- /Widget Box -->
							<div class="widget increase autowidth" id="new-tasks">
								<a href="#" class="close-widget" title="Hide Widget" rel="tooltip">x</a>
								<span><?php echo $widgets['total_redemptions']; ?></span>
								<p><strong>Deals Claimed</strong>of vouchers by your customers</p>
							</div>
							<!-- Widget Box -->
						<?php endif; ?>

						<?php if (isset($widgets['total_exposure'])): ?>
							<!-- /Widget Box -->
							<div class="widget increase autowidth" id="new-tasks">
								<a href="#" class="close-widget" title="Hide Widget" rel="tooltip">x</a>
								<span><?php echo $widgets['total_exposure']; ?></span>
								<p><strong>Estimated Exposure</strong>of vouchers by your customers</p>
							</div>
							<!-- Widget Box -->
						<?php endif; ?>
<?php
/*
						<?php if (isset($widgets['total_customers'])): ?>
							<!-- /Widget Box -->
							<div class="widget increase autowidth" id="new-tasks">
								<a href="#" class="close-widget" title="Hide Widget" rel="tooltip">x</a>
								<span><?php echo $widgets['total_customers']; ?></span>
								<p><strong>Total Customers</strong>of vouchers by your customers</p>
							</div>
							<!-- Widget Box -->
						<?php endif; ?>

						<?php if (isset($widgets['returning_customers'])): ?>
							<!-- /Widget Box -->
							<div class="widget increase autowidth" id="new-tasks">
								<a href="#" class="close-widget" title="Hide Widget" rel="tooltip">x</a>
								<span><?php echo $widgets['returning_customers']; ?>%</span>
								<p><strong>Returning Customers</strong>of vouchers by your customers</p>
							</div>
							<!-- Widget Box -->
						<?php endif; ?>
*/
?>
						<?php if (isset($widgets['conversion_rate'])): ?>
							<!-- /Widget Box -->
							<div class="widget increase autowidth" id="new-tasks">
								<a href="#" class="close-widget" title="Hide Widget" rel="tooltip">x</a>
								<span><?php echo $widgets['conversion_rate']; ?>%</span>
								<p><strong>Conversion Rate</strong>of vouchers by your customers</p>
							</div>
							<!-- Widget Box -->
						<?php endif; ?>


