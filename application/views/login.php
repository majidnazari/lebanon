<!DOCTYPE html>
<html lang="en">
<?=$this->load->view("includes/_head");?>
<body>
    
    <div class="loginBox">
        <div class="bLogo"></div>
        <div class="loginForm">
         		<font color="#FF0000"><?=$reset_message?></font>
   				<?=form_open('',array('class'=>'form-horizontal')); ?>
                <div class="control-group">
                    <div class="input-prepend">
                        <span class="add-on"><span class="icon-envelope"></span></span>
                        <input type="text" id="inputEmail" placeholder="Username" name="username" value="<?php echo set_value('username'); ?>"/><?php echo form_error('username'); ?>
                    </div>                
                </div>
                <div class="control-group">
                    <div class="input-prepend">
                        <span class="add-on"><span class="icon-lock"></span></span>
                        <input type="password" id="inputPassword" name="password" value="<?php echo set_value('password'); ?>" placeholder="Password"/>
                        <?php echo form_error('password'); ?>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4">
                        <button type="submit" class="btn btn-block">Sign in</button>       
                    </div>
                </div>
            <?=form_close()?>       
        </div>
    </div>    
    
</body>
</html>
