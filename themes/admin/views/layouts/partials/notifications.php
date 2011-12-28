
<!-- Error Notifications -->
<?php
	$notifications = $this->session->flashdata('notifications');
	if (isset($notifications['error'])):
?>
		<div class="notification error">
			<a href="#" class="close-notification" title="Hide Notification" rel="tooltip">x</a>
<?php
	foreach($notifications['error'] as $msg):
?>
			<p><strong>Oops...</strong> <?php echo $msg ?></p>
<?php
 	endforeach;
?>
		</div>
<?php
	endif;
?>
<!-- /Error Notifications -->

<!-- Success Notifications -->
<?php
	$notifications = $this->session->flashdata('notifications');
	if (isset($notifications['success'])):
?>
		<div class="notification success">
			<a href="#" class="close-notification" title="Hide Notification" rel="tooltip">x</a>
<?php
	foreach($notifications['success'] as $msg):
?>
			<p><strong>Congrads!</strong> <?php echo $msg ?></p>
<?php
 	endforeach;
?>
		</div>
<?php
	endif;
?>
<!-- /Success Notifications -->

<!-- Information Notifications -->
<?php
	$notifications = $this->session->flashdata('notifications');
	if (isset($notifications['information'])):
?>
		<div class="notification information">
			<a href="#" class="close-notification" title="Hide Notification" rel="tooltip">x</a>
<?php
	foreach($notifications['information'] as $msg):
?>
			<p><strong>You ought to know...</strong> <?php echo $msg ?></p>
<?php
 	endforeach;
?>
		</div>
<?php
	endif;
?>
<!-- /Information Notifications -->

<!-- Attention Notifications -->
<?php
	$notifications = $this->session->flashdata('notifications');
	if (isset($notifications['attention'])):
?>
		<div class="notification attention">
			<a href="#" class="close-notification" title="Hide Notification" rel="tooltip">x</a>
<?php
	foreach($notifications['attention'] as $msg):
?>
			<p><strong>Attention!</strong> <?php echo $msg ?></p>
<?php
 	endforeach;
?>
		</div>
<?php
	endif;
?>
<!-- /Attention Notifications -->