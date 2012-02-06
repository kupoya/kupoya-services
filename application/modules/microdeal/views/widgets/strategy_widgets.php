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

						<?php if (isset($widgets['total_redemptions'])): ?>
							<!-- /Widget Box -->
							<div class="widget increase autowidth" id="new-tasks">
								<a href="#" class="close-widget" title="Hide Widget" rel="tooltip">x</a>
								<span><?php echo $widgets['total_redemptions']; ?></span>
								<p><strong>Total Redemptions</strong>of vouchers by your customers</p>
							</div>
							<!-- Widget Box -->
						<?php endif; ?>

						<?php if (isset($widgets['estimated_exposure'])): ?>
							<!-- /Widget Box -->
							<div class="widget increase autowidth" id="new-tasks">
								<a href="#" class="close-widget" title="Hide Widget" rel="tooltip">x</a>
								<span><?php echo $widgets['estimated_exposure']; ?></span>
								<p><strong>Estimated Exposure</strong>to friends on facebook</p>
							</div>
							<!-- Widget Box -->
						<?php endif; ?>

