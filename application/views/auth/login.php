
    <a href="/" title="Back to Homepage"></a>
  
    <!-- Login box -->
    <article id="login-box">
    
      <div class="article-container">

        <?php
          if (isset($message) && !empty($message)):
        ?>
        <!-- Notification -->
        <div class="notification error">
          <a href="#" class="close-notification" title="Hide Notification" rel="tooltip">x</a>
          <p><strong><?=lang('password_error')?></strong>
            <?php echo $message //lang('username_or_password_incorrect')?>
          </p>
        </div>
        <!-- /Notification -->
        <?php
          endif;
        ?>
      
        <?php echo form_open("auth/login");?>
          <fieldset>
            <dl>
              <dt>
                <label><?=lang('username')?></label>
              </dt>
              <dd>
                <?php echo form_input($identity);?>
                <!--
                <input type="text" class="large">
                -->
              </dd>
              <dt>
                <label><?=lang('password')?></label>
              </dt>
              <dd>
                <?php echo form_input($password);?>
                <!--
                <input type="password" class="large">
                -->
              </dd>
              <dt class="checkbox"><label><?=lang('remember_me')?></label></dt>
              <dd>
              <!--
              <input type="checkbox">
              -->
              <?php echo form_checkbox('remember', '1', FALSE);?>
              </dd>
            </dl>
          </fieldset>
          <button type="submit" class="right"><?=lang('sign_in')?></button>
        <!--
        </form>
        -->
        <?php echo form_close();?>
      
      </div>
    
    </article>
    <!-- /Login box -->
    <ul class="login-links">
      <li><a href="#">Wiki</a></li>
      <li><a href="#">Back to page</a></li>
    </ul>

