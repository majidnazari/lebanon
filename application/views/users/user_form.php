<?php
$username = array(
	'name'	=> 'username',
	'id'	=> 'username',
	'class'	=> 'validate[required]',	
	'value' => $username,
	
);

$fullname = array(
	'name'	=> 'fullname',
	'id'	=> 'fullname',
	'class'	=> 'validate[required]',	
	'value' => $fullname,
);
$phone = array(
	'name'	=> 'phone',
	'id'	=> 'phone',	
	'value' => $phone,
);
$address = array(
	'name'	=> 'address',
	'id'	=> 'address',	
	'value' => $address,
);
$email = array(
	'name'	=> 'email',
	'id'	=> 'email',
	'class'	=> 'validate[custom[email]]',	
	'value' => $email,
);
if(@$readonly)
{
	$username['readonly']='readonly';
	$email['readonly']='readonly';
}
?>
<div class="content">
   <?=$this->load->view("includes/_bread")?>         
    <div class="workplace">
        <div class="page-header">
            <h1><?=$subtitle?></h1>
        </div>                  
        <div class="row-fluid">
            <div class="span12">
                <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1><?=$subtitle?></h1>
                </div>
                <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'validation'));
					  echo form_hidden('u_id',$u_id); ?> 
                <div class="block-fluid">                        
                    <div class="row-form clearfix">
                        <div class="span3">Fullname:</div>
                        <div class="span4"><?php echo form_input($fullname); ?>
                        <font color="#FF0000"><?php echo form_error('fullname'); ?></font>
                        </div>
                    </div> 
                    <div class="row-form clearfix">
                        <div class="span3">Phone:</div>
                        <div class="span4"><?php echo form_input($phone); ?>
                        <font color="#FF0000"><?php echo form_error('phone'); ?></font>
                        </div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span3">Address:</div>
                        <div class="span4"><?php echo form_input($address); ?>
                        <font color="#FF0000"><?php echo form_error('address'); ?></font>
                        </div>
                    </div>                      
                    <div class="row-form clearfix">
                        <div class="span3">Email:</div>
                        <div class="span4"><?php echo form_input($email); ?>
                        <font color="#FF0000"><?php echo form_error('email'); ?></font>
                        </div>
                    </div>                                         
                    <div class="row-form clearfix">
                        <div class="span3">Username:</div>
                        <div class="span4"><?php echo form_input($username); ?>
                        <font color="#FF0000"><?php echo form_error('username'); ?></font></div>
                    </div>
                    <?=$password_area?>
                    <div class="row-form clearfix">
                        <div class="span3">Group:</div>
                        <div class="span4"><?php $array_group=array();
												foreach($groups as $group)
												{
													$array_group[$group->id]=$group->name;
													}
												echo form_dropdown('group_id',$array_group,$group_id);
							?></div>
                    </div>  
                    <div class="row-form clearfix">
                        <div class="span3">Status:</div>
                        <div class="span4"><?php $array_status=array('online'=>'Online','offline'=>'Offline');
												echo form_dropdown('status',$array_status,$status);
							?></div>
                    </div>                        
                    <div class="footer tar">
                    	<center><input type="submit" name="save" value="Save" class="btn"></center>
                    </div>                            
                </div>
				<?=form_close()?>
            </div>
        </div>
    </div>
</div>