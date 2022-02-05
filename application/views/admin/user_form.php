<?php
$class='class="select1"';
$email = array(
	'name'	=> 'email',
	'id'	=> 'email',
	'class'	=> 'validate[required,custom[email]]',
	'value' => $email,
);
$username = array(
	'name'	=> 'username',
	'id'	=> 'username',
	'class'	=> 'validate[required,minSize[6]]',
	'value' => $username,
);
$password_conf = array(
	'name'	=> 'password_conf',
	'id'	=> 'password_conf',
	'class'	=> 'validate[required,minSize[6]]',
);
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'class'	=> 'validate[required,minSize[6]]',
	'value' => $password,
);
$fullname = array(
	'name'	=> 'fullname',
	'id'	=> 'fullname',
	'value' => $fullname,
);

$address = array(
	'name'	=> 'address',
	'id'	=> 'address',
	'value' => $address,
);
$address = array(
	'name'	=> 'address',
	'id'	=> 'address',
	'value' => $address,
);
$button = "class='button size-120'";
$select_class='calss="fl-space2 required"';
?>

<div class="content">
   <?=$this->load->view("includes/_bread")?>         
    <div class="workplace">
        <div class="page-header">
            <h1>Create New User</h1>
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
                        <div class="span4"><?php echo form_input($email); ?>
                        <font color="#FF0000"><?php echo form_error('email'); ?></font>
                        </div>
                    </div> 

                    <div class="row-form clearfix">
                        <div class="span3">User Name:</div>
                        <div class="span4"><?php echo form_input($username); ?>
                        <font color="#FF0000"><?php echo form_error('username'); ?></font>
                        </div>
                    </div>                         

                    <div class="row-form clearfix">
                        <div class="span3">Password:</div>
                        <div class="span4"><?php echo form_password($password); ?>
                        <font color="#FF0000"><?php echo form_error('password'); ?></font>
                        </div>                            
                    </div> 

                    <div class="row-form clearfix">
                        <div class="span3">Retype Password:</div>
                        <div class="span4"><?php echo form_password($conf_password); ?>
						<?php echo form_error('conf_password'); ?></font>
                        </div>
                    </div>                                       

                    <div class="row-form clearfix">
                        <div class="span3">Fullname:</div>
                        <div class="span4"><?php echo form_input($fullname); ?>
                        <font color="#FF0000"><?php echo form_error('fullname'); ?></font>
                        </div>
                    </div>                                                               

                    <div class="row-form clearfix">
                        <div class="span3">Address:</div>
                        <div class="span4"><?php echo form_input($address); ?><input type="text" name="address" value="<?php echo set_value('address'); ?>" />
                        </div>
                    </div>                        

                    <div class="row-form clearfix">
                        <div class="span3">Phone number:</div>
                        <div class="span4"><input type="text" name="phone" value="<?php echo set_value('phone'); ?>" />
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