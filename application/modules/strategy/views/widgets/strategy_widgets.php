<?php
// $strategy['bank']
// $strategy['expiration_date']
?>

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
						
						<?php if (isset($strategy['exposure_count'])): ?>
							<!-- /Widget Box -->
							<div class="widget increase autowidth" id="new-tasks">
								<a href="#" class="close-widget" title="Hide Widget" rel="tooltip">x</a>
								<span><?php echo $strategy['exposure_count']; ?></span>
								<p><strong><?=lang('strategy:Exposure');?></strong><?=lang('strategy:total_exposure_count');?></p>
							</div>
							<!-- Widget Box -->
						<?php endif; ?>

						<!-- /Widget Box -->
						<div class="widget text-only" id="text-widget">
							<a href="#" class="close-widget" title="Hide Widget" rel="tooltip">x</a>
							<p><strong>Text Only App</strong> +29 Lorem Ipsum</p>
						</div>
						<!-- /Widget Box -->
