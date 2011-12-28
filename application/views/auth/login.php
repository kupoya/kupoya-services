
    <a href="/" title="Back to Homepage"></a>
  
    <!-- Login box -->
    <article id="login-box">
    
      <div class="article-container">
      
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et dignissim metus. Maecenas id augue ac metus tempus aliquam. </p>
        
        <!-- Notification -->
        <div class="notification error">
          <a href="#" class="close-notification" title="Hide Notification" rel="tooltip">x</a>
          <p><strong>Error notification</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vulputate, sapien quis fermentum luctus, libero.</p>
        </div>
        <!-- /Notification -->
      
        <?php echo form_open("auth/login");?>
          <fieldset>
            <dl>
              <dt>
                <label>Login</label>
              </dt>
              <dd>
                <?php echo form_input($identity);?>
                <!--
                <input type="text" class="large">
                -->
              </dd>
              <dt>
                <label>Password</label>
              </dt>
              <dd>
                <?php echo form_input($password);?>
                <!--
                <input type="password" class="large">
                -->
              </dd>
              <dt class="checkbox"><label>Remeber me</label></dt>
              <dd>
              <!--
              <input type="checkbox">
              -->
              <?php echo form_checkbox('remember', '1', FALSE);?>
              </dd>
            </dl>
          </fieldset>
          <button type="submit" class="right">Log in</button>
        <!--
        </form>
        -->
        <?php echo form_close();?>
      
      </div>
    
    </article>
    <!-- /Login box -->
    <ul class="login-links">
      <li><a href="#">Lost password?</a></li>
      <li><a href="#">Wiki</a></li>
      <li><a href="#">Back to page</a></li>
    </ul>




<?php
/*
<div class='mainInfo'>

	<div class="pageTitle">Login</div>
    <div class="pageTitleBorder"></div>
	<p>Please login with your email/username and password below.</p>
	
	<div id="infoMessage"><?php echo $message;?></div>
	
    <?php echo form_open("auth/login");?>
    	
      <p>
      	<label for="identity">Email/Username:</label>
      	<?php echo form_input($identity);?>
      </p>
      
      <p>
      	<label for="password">Password:</label>
      	<?php echo form_input($password);?>
      </p>
      
      <p>
	      <label for="remember">Remember Me:</label>
	      <?php echo form_checkbox('remember', '1', FALSE);?>
	  </p>
      
      
      <p><?php echo form_submit('submit', 'Login');?></p>

      
    <?php echo form_close();?>

</div>
*/?>
