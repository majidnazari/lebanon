<?php
$class='class="select1"';
$chassis_no = array(
	'name'	=> 'chassis',
	'id'	=> 'chassis',
	'class'	=> 'text fl',
	'style'	=> 'width:600px',
	'value' => $chassis_no,
);
$year_build = array(
	'name'	=> 'year_build',
	'id'	=> 'year_build',
	'class'	=> 'text fl',
	'style'	=> 'width:600px',
	'value' => $year_build,
);
$h_p = array(
	'name'	=> 'hp',
	'id'	=> 'hp',
	'class'	=> 'text fl',
	'style'	=> 'width:600px',
	'value' => $h_p,
);
$no_of_seats = array(
	'name'	=> 'seats',
	'id'	=> 'seats',
	'class'	=> 'text fl',
	'style'	=> 'width:200px',
	'value' => $no_of_seats,
);
$engine_no = array(
	'name'	=> 'engine',
	'id'	=> 'engine',
	'class'	=> 'text fl',
	'style'	=> 'width:600px',
	'value' => $engine_no,
);
$plate_no = array(
	'name'	=> 'plate',
	'id'	=> 'plate',
	'class'	=> 'text fl',
	'style'	=> 'width:600px',
	'value' => $plate_no,
);
$price = array(
	'name'	=> 'price',
	'id'	=> 'price',
	'class'	=> 'text fl',
	'style'	=> 'width:600px',
	'value' => $price,
);

$button = "class='button size-120'";
$select_class='calss="fl-space2 required"';
$makes_class='onchange="getmodels(this.value)" id="brand_id"';
?>
<div class="content-box">
    <div class="box-body">
        <div class="box-header clear">
            <h2><?=$subtitle?></h2>
        </div>
		<div class="box-wrap clear">
        <?=form_open_multipart($this->uri->uri_string());
	echo form_hidden('v_id',$v_id);
	 ?>
					<table class="style1">
					<thead>
					</thead>
					<tbody>
					<tr><th>Chassis No</th><td colspan="2"><?php echo form_input($chassis_no); ?>
                		<font color="#FF0000"><?=form_error('chassis_no') ?>
						<?php echo isset($errors['chassis_no'])?$errors['chassis_no']:''; ?></font></td>
                    </tr>
					<tr><th>Make</th><td colspan="2"><?php 
						$array_makes[0]='Select Make';
						foreach($makes as $make){
						$array_makes[$make->id]=$make->name;
						}
						echo form_dropdown('brand_id', $array_makes,$make_id,$makes_class);?>
                       <script language="javascript">
						function getmodels(brand_id)
							{
								$("#datamodels").html("loading ... ");
								$.ajax({
									url: "<?php echo base_url();?>models.php",
									type: "post",
									data: "id="+brand_id,
									success: function(result){
										$("#datamodels").html(result);
									}
								});
							}
                    </script>
                        </td>
                    </tr>
					<tr><th>Model</th><td colspan="2"><div id="datamodels"><select><option>Select make first</option></select></div></td>
                    </tr>
					<tr><th>Color</th><td colspan="2"><?php 
						foreach($colors as $color){
						$array_color[$color->id]=$color->name;
						}
						echo form_dropdown('color_id', $array_color,$color_id);?></td>
                    </tr>
					<tr><th>Usage</th><td colspan="2"><?php 
						$array_used=array('private'=>'Private','commercial'=>'Commercial');
						echo form_dropdown('usage', $array_used,$usage);?></td>
                    </tr>                                                                                
					<tr>
						<th>Body Type</th>
						<td colspan="2"><?php 
						$array_types[0]='Select Body Type';
						foreach($body_types as $body_type){
						$array_types[$body_type->id]=$body_type->title;
						}
						echo form_dropdown('body_type', $array_types,$body_type_id);?></td>
					</tr>
					<tr>
						<th>No. of Seats</th>
						<td colspan="2"><?php echo form_input($no_of_seats); ?>
                		<font color="#FF0000"><?=form_error('no_of_seats') ?>
						<?php echo isset($errors['no_of_seats'])?$errors['no_of_seats']:''; ?></font></td>
					</tr>
					<tr>
						<th>Engine No</th>
						<td colspan="2"><?php echo form_input($engine_no); ?>
                		<font color="#FF0000"><?=form_error('engine_no') ?>
						<?php echo isset($errors['engine_no'])?$errors['engine_no']:''; ?></font></td>
					</tr>
					<tr>
						<th>Year build</th>
						<td colspan="2"><?php echo form_input($year_build); ?>
                		<font color="#FF0000"><?=form_error('year_build') ?>
						<?php echo isset($errors['year_build'])?$errors['year_build']:''; ?></font></td>
					</tr> 
					<tr>
						<th>H.P.</th>
						<td colspan="2"><?php echo form_input($h_p); ?>
                		<font color="#FF0000"><?=form_error('h_p') ?>
						<?php echo isset($errors['h_p'])?$errors['h_p']:''; ?></font></td>
					</tr>
					<tr>
						<th>Plate No</th>
						<td colspan="2"><?php echo form_input($plate_no); ?>
                		<font color="#FF0000"><?=form_error('plate_no') ?>
						<?php echo isset($errors['plate_no'])?$errors['plate_no']:''; ?></font></td>
					</tr>                                                                                
					<tr>
						<th>Vehicle Price(USD)</th>
						<td colspan="2"><?php echo form_input($price); ?>
                		<font color="#FF0000"><?=form_error('price') ?>
						<?php echo isset($errors['price'])?$errors['price']:''; ?></font></td>
					</tr>
					<tr>
						<th>User</th>
						<td colspan="2"><?php 
						$array_user[0]='Select User';
						foreach($users as $user){
						$array_user[$user->id]=$user->fullname.'('.$user->agent_code.')';
						}
						echo form_dropdown('user_id', $array_user,$user_id);?></td>
					</tr>                    
                 <tr><td colspan="3" align="center"><br /><?php echo form_submit('submit', 'Save',$button); ?></td></tr> 
					</tbody>
					</table>
                    <?php echo form_close(); ?>
				</div> <!-- end of box-wrap -->
			</div> <!-- end of box-body -->
			</div>