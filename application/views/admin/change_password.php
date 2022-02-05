<?php
$class='class="select1"';
$username = array(
	'name'	=> 'username',
	'id'	=> 'username',
	'class'	=> 'text fl',
	'style'	=> 'width:300px',
	'value' => $username,
	'readonly'=>'readonly'
);
$email = array(
	'name'	=> 'email',
	'id'	=> 'email',
	'class'	=> 'text fl',
	'style'	=> 'width:300px',
	'value' => $email,
	'readonly'=>'readonly'
);
$password = array(
	'type'	=> 'password',
	'name'	=> 'password',
	'id'	=> 'password',
	'class'	=> 'text fl',
	'style'	=> 'width:300px',
);
$password_conf = array(
	'type'	=> 'password',
	'name'	=> 'password_conf',
	'id'	=> 'password_conf',
	'class'	=> 'text fl',
	'style'	=> 'width:300px',
);


$button = "class='button size-120'";
$select_class='calss="fl-space2 required"';
?>
<div class="content-box">
    <div class="box-body">
        <div class="box-header clear">
            <h2><?=$subtitle?></h2>
        </div>
		<div class="box-wrap clear">
        <?=form_open_multipart($this->uri->uri_string());
			echo form_hidden('user_id',$user_id);
			echo form_hidden('group_id',$group_id);
	 ?>
					<table class="style1">
                        <tbody>
                            <tr><th>Username</th><td colspan="2"><?php echo form_input($username); ?>
                                <font color="#FF0000"><?=form_error('username') ?>
                                <?php echo isset($errors['username'])?$errors['username']:''; ?></font></td></tr>
                            <tr><th>Email</th><td colspan="2"><?php echo form_input($email); ?>
                            <font color="#FF0000"><?=form_error('email') ?>
                            <?php echo isset($errors['email'])?$errors['email']:''; ?></font></td></tr>
                            <tr><th>Password</th><td colspan="2"><?php echo form_input($password); ?>
                            <font color="#FF0000"><?=form_error('password') ?>
                            <?php echo isset($errors['password'])?$errors['password']:''; ?></font></td></tr>                
                            <tr><th>Confirm Password</th><td colspan="2"><?php echo form_input($password_conf); ?>
                            <font color="#FF0000"><?=form_error('password_conf') ?>
                            <?php echo isset($errors['password_conf'])?$errors['password_conf']:''; ?></font></td></tr>                
                            <tr><td colspan="3" align="center"><br /><?php echo form_submit('submit', 'Save',$button); ?></td></tr> 
                        </tbody>
					</table>
                    <?php echo form_close(); ?>
				</div> <!-- end of box-wrap -->
			</div> <!-- end of box-body -->
			</div>