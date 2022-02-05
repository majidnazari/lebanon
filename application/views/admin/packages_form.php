<?php
$class='class="select1"';
$package_title = array(
	'name'	=> 'package_title',
	'id'	=> 'package_title',
	'class'	=> 'text fl',
	'style'	=> 'width:600px',
	'value' => $package_title,
);
$cost = array(
	'name'	=> 'cost',
	'id'	=> 'cost',
	'class'	=> 'text fl',
	'value' => $cost,
);
$addionnal_cost = array(
	'name'	=> 'addionnal_cost',
	'id'	=> 'addionnal_cost',
	'class'	=> 'text fl',
	'value' => $addionnal_cost,
);
$min_premium = array(
	'name'	=> 'min_premium',
	'id'	=> 'min_premium',
	'class'	=> 'text fl',
	'value' => $min_premium,
);

$details = array(
	'name'	=> 'details',
	'id'	=> 'details',
	'cols' => 135,
	'rows' => 8,
	'value' => $details,
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
			echo form_hidden('package_id',$package_id);
	 ?>
					<table class="style1">
					<thead>
					</thead>
					<tbody>
					<tr><th>Title</th><td colspan="2"><?php echo form_input($package_title); ?>
                        <font color="#FF0000"><?=form_error('package_title') ?>
                        <?php echo isset($errors['package_title'])?$errors['package_title']:''; ?></font></td>
                    </tr>
                    <tr><th>Category</th><td colspan="2"><?php 
														foreach($categories as $category){
														$array_category[$category->id]=$category->title;
														}
														echo form_dropdown('category_id', $array_category,$category_id);?></td>
                    </tr>
					<tr><th>Cost</th><td colspan="2"><?php echo form_input($cost); ?>USD
                        <font color="#FF0000"><?=form_error('cost') ?>
                        <?php echo isset($errors['cost'])?$errors['cost']:''; ?></font></td>
                    </tr>
					<tr><th>Addionnal Cost</th><td colspan="2"><?php echo form_input($addionnal_cost); ?>%
                        <font color="#FF0000"><?=form_error('addionnal_cost') ?>
                        <?php echo isset($errors['addionnal_cost'])?$errors['addionnal_cost']:''; ?></font></td>
                    </tr>
					<tr><th>Min. Premium</th><td colspan="2"><?php echo form_input($min_premium); ?>USD
                        <font color="#FF0000"><?=form_error('min_premium') ?>
                        <?php echo isset($errors['min_premium'])?$errors['min_premium']:''; ?></font></td>
                    </tr>                                                            
					<tr>
						<th>Description</th>
						<td colspan="2"><?php echo form_textarea($details); ?></td>
					</tr>
					<tr>
						<th>Status</th>
						<td colspan="2">
						<?php 
						$array_status=array('online'=>'Online','offline'=>'Offline');
						echo form_dropdown('status', $array_status,$status,$class);?></td>
					</tr>
                 	<tr><td colspan="3" align="center"><br /><?php echo form_submit('submit', 'Save',$button); ?></td></tr> 
					</tbody>
					</table>
                    <?php echo form_close(); ?>
				</div> <!-- end of box-wrap -->
			</div> <!-- end of box-body -->
			</div>