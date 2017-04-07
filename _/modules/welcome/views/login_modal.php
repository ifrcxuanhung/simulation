<?php
if(empty($_SESSION['simulation']['token']))
			$_SESSION['simulation']['token'] = md5(uniqid(mt_rand(),true));
?>
<div class="modal-header">

<h4 class="form-title">Sign In</h4>
<button aria-hidden="true" data-dismiss="modal" type="button" class="btn red mt-ladda-btn ladda-button" data-style="slide-right"><i aria-hidden="true" class="fa fa-times"></i></button>
</div>
<div class="modal-body">
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
            <div class="alert alert-danger login-alert" id="login_alert" style="display:none;">
                <button class="close" data-close="alert"></button>
                <span class="aler_msg"><?php translate('Login failed'); ?></span>
            </div>
            <form role="form" class="form-horizontal" action="<?php echo base_url(); ?>user-manage/login.php" method="post">
            	<div class="form-group">
                    
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="email"><?php translate('Username'); ?></label>
                    <div class="col-md-8">
                        <div class="input-icon">
                            <i class="fa fa-envelope"></i>
                            <input class="form-control" id="username" name="username" placeholder="<?php translate('Username'); ?>" type="text"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="password"><?php translate('Password'); ?></label>
                    <div class="col-md-8">
                        <div class="input-icon left">
                            <i class="fa fa-user"></i>
                            <input class="form-control" id="password" name="password" size="30" placeholder="<?php translate('Password'); ?>" type="password"/>
                        </div>
                    </div>
                </div>
                
             
                <!--div class="form-group">
                    <div class="col-md-offset-3 col-md-10">
                        <button class="btn green" type="submit"><?php translate('sign_in'); ?></button>
                        <button type="button" class="btn default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
                <input type="hidden" id="redirect" name="redirect" value="<?php echo $current_url; ?>"/-->
                <input type="hidden" id="remember" name="remember" value="1"/>
                <input type="hidden" id="token" name="token" value="<?php echo $_SESSION['simulation']['token']; ?>"/>
                
             
            </form>
              <div class="col-md-12 getinfo">
              <a id="register-btn" href="<?php echo base_url();?>user-manage/sign_up.php"><?php translate('Create an account'); ?></a>
               <a class="forget-password" id="forget-password" href="<?php echo base_url();?>user-manage/forgot_password.php"><?php translate('Forgot Password?'); ?></a>
             	
                    
                </div>
               
	</div>
</div>
</div>
<div class="modal-footer">
    <a href="javascript:;" id="LoginProcess" class="btn btn-success uppercase login-process" style="background:#00a800;">Login</a>
    <!--button type="button" class="" >Login</button>
    <button type="button" class="btn default" data-dismiss="modal">Cancel</button>
    <button type="button" class="btn blue">Save changes</button-->
</div>
<script>
$("input").keyup(function(event)
{
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13')
    {   
        $('#LoginProcess').click();
    }
});
</script>