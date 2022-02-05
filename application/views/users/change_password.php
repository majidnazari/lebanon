<?php
$conf_password = array(
	'name'	=> 'password_conf',
	'id'	=> 'password_conf',
	'class'	=> 'validate[required,minSize[6]]',
);
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'class'	=> 'validate[required,minSize[6]]',
);

?>
<div class="content">
   <?=$this->load->view("includes/_bread")?>         
    <div class="workplace">
        <div class="page-header">
            <h1><?=$subtitle?></h1>
        </div>                  
        <div class="row-fluid">
            <div class="span12">
                        <?php if($msg!=''){ ?>
              	<div class="alert alert-success">               
                    <?php echo $msg;?>
                </div> 
                <?php } ?>  
                <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1>Change Password</h1>
                </div>
                <?php echo form_open($this->uri->uri_string(),array('id'=>'validation')); ?> 
                <div class="block-fluid">                        

                    <div class="row-form clearfix">
                        <div class="span3">Email address:</div>
                        <div class="span4"><?php echo $email; ?></div>
                    </div> 

                    <div class="row-form clearfix">
                        <div class="span3">User Name:</div>
                        <div class="span4"><?php echo $username; ?></div>
                    </div>                         
					<div class="row-form clearfix">
                        <div class="span3">Password:</div>
                        <div class="span4"><?=form_password($password)?>
                        <font color="#FF0000"><?=form_error('password')?></font>
                        </div>                            
                    </div> 

                    <div class="row-form clearfix">
                        <div class="span3">Retype Password:</div>
                        <div class="span4"><?=form_password($conf_password)?>
						<font color="#FF0000"><?=form_error('conf_password')?></font>
                        </div>
                    </div> 
                    <div class="footer tar">
                    	<center><input type="submit" name="update" value="Change Password" class="btn"></center>
                    </div>                            
                </div>
				<?=form_close()?>
            </div>
        </div>
    </div>
</div>