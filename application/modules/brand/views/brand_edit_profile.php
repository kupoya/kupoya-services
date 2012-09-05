
				<!-- Article Header -->
				<header>
					<h2><?=lang('operator:account')?></h2>
					<!-- Article Header Tab Navigation -->
					<nav>
						<ul class="tab-switch-url">
							<li><a href="<?=base_url().'brand/edit_brand_profile'?>" class="default-tab current" title="Switch to next tab"><?=lang('operator:profile')?></a></li>
							<li><a href="<?=base_url().'operator/change_password'?>" title="Switch to next tab"><?=lang('operator:change_password')?></a></li>
						</ul>
					</nav>
					<!-- /Article Header Tab Navigation -->
				</header>
				<!-- /Article Header -->


<?php
	echo Modules::run('brand/edit_brand_info');
?>

<?php
	echo Modules::run('operator/view_contact');
?>