<?php
	$scans_url = 'https://scans.kupoya.com';
	if (isset($code['brand_id']) && isset($code['id']))
		$code_url = $scans_url . '/' . $code['brand_id'] . '/' . $code['id'];
	else
		$code_url = $scans_url;
?>

					<!-- Strategy General Information -->

					<!-- Article Container for safe floating -->
					<div class="article-container">
					<header>
						<h2>Overview</h2>
					</header>

						<!-- Image Minimenu Actions -->
						<div class="image-frame left">
							<img src="
								http://chart.apis.google.com/chart?cht=qr&chl=<?php echo $code_url; ?>&choe=UTF-8&chs=250x250&chld=H|0" alt="Sample Image">
							<ul class="image-actions">
								<li class="view"><a href="#">View</a></li>
								<li class="delete"><a href="#">Delete</a></li>
							</ul>

						</div>
						<!-- /Image Minimenu Actions -->

						<dl>
							<dt>
								<label>Strategy Name</label>
							</dt>
							<dd class="text">
								<?php echo $strategy['name']; ?>
							</dd>

							<br/>

							<dt>
								<label>Strategy Description</label>
							</dt>
							<dd class="text">
								<?php echo $strategy['description']; ?>
							</dd>

							<br/>

							<dt>
								<label>Strategy Image</label>
							</dt>
							<dd class="text">
								<img src="<?php echo base_url().$strategy['picture']; ?>" width="50" height="50"/>
							</dd>

							<br/>

							<dt>
								<label>Strategy Website</label>
							</dt>
							<dd class="text">
								<?php echo $strategy['website']; ?>
							</dd>

						</dl>

					</div>
					<!-- /Article Container for safe floating -->

					<!-- /Strategy General Information -->