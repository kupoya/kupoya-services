<!-- Error Notifications -->
<?php
	// @TODO also add support for combining notifications coming from session...
	$notifications_session = $this->session->flashdata('notifications');
	if (isset($notifications_session) && count ($notifications_session))
	{
		//$notifications += array_merge($notifications, $this->session->flashdata('notifications'));
		if (isset($notifications) && is_array($notifications_session))
			$notifications += $notifications_session;
		else if (isset($notifications))
			$notifications;
		else
			$notifications = $notifications_session;
	}

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