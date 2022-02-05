<div class="content">
   <?=$this->load->view("admin/includes/_bread")?>         
    <div class="workplace">
        <div class="page-header">
            <h1>Add Survey Step 1 <small>Create New User</small></h1>
        </div>                  
        <div class="row-fluid">
            <div class="span12">
                <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1>Register</h1>
                </div>
                <?php echo form_open($this->uri->uri_string(),array('id'=>'validation')); ?> 
                <div class="block-fluid">                        

                    <div class="row-form clearfix">
                        <div class="span3">Email address:</div>
                        <div class="span4"><input type="text" name="email" class="validate[required,custom[email]]" value="<?php echo set_value('email'); ?>" /><font color="#FF0000"><?php echo form_error('email'); ?></font>
                        </div>
                    </div> 

                    <div class="row-form clearfix">
                        <div class="span3">User Name:</div>
                        <div class="span4"><input type="text" class="validate[required,maxSize[6]]" name="username" value="<?php echo set_value('username'); ?>" /><font color="#FF0000"><?php echo form_error('username'); ?></font>
                        </div>
                    </div>                         

                    <div class="row-form clearfix">
                        <div class="span3">Password:</div>
                        <div class="span4"><input type="password" name="password" class="validate[required,minSize[6]]" value="<?php echo set_value('password'); ?>" /><font color="#FF0000"><?php echo form_error('password'); ?></font>
                        </div>                            
                    </div> 

                    <div class="row-form clearfix">
                        <div class="span3">Retype Password:</div>
                        <div class="span4"><input type="password" name="password_conf" value="<?php echo set_value('conf_password'); ?>" /><font color="#FF0000"><?php echo form_error('conf_password'); ?></font>
                        </div>
                    </div>                                       

                    <div class="row-form clearfix">
                        <div class="span3">Fullname:</div>
                        <div class="span4"><input type="text" name="fullname" value="<?php echo set_value('fullname'); ?>" />
                        <font color="#FF0000"><?php echo form_error('fullname'); ?></font>
                        </div>
                    </div>                                                               

                    <div class="row-form clearfix">
                        <div class="span3">Address:</div>
                        <div class="span4"><input type="text" name="address" value="<?php echo set_value('address'); ?>" />
                        </div>
                    </div>                        

                    <div class="row-form clearfix">
                        <div class="span3">Phone number:</div>
                        <div class="span9"><input type="text" name="phone" value="<?php echo set_value('phone'); ?>" />
                        </div>
                    </div>                                                

                    <div class="footer tar">
                    	<input type="submit" name="register" value="Continue" class="btn">
                    </div>                            
                </div>
				<?=form_close()?>
            </div>
        </div>
    </div>
</div>