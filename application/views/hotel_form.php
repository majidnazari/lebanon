<?php
$name = array(
	'name'	=> 'name',
	'id'	=> 'name',
	'class'	=> 'validate[required]',
	'value' => $name,
);
$rating = array(
	'name'	=> 'rating',
	'id'	=> 'rating',
	'value' => $rating,
);
$phone = array(
	'name'	=> 'phone',
	'id'	=> 'phone',
	'value' => $phone,
);
if($city_id=='')
$city_id=0;
$class_country=' class="validate[required]" id="country_id" onchange="getcity(this.value,'.$city_id.')"';
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
					  echo form_hidden('country_id',$country_id); ?> 
                <div class="block-fluid">                        
                    <div class="row-form clearfix">
                        <div class="span3">Hotel Name:</div>
                        <div class="span4"><?php echo form_input($name); ?>
                        <font color="#FF0000"><?php echo form_error('name'); ?></font>
                        </div>
                    </div> 
                    <div class="row-form clearfix">
                        <div class="span3">Phone:</div>
                        <div class="span4"><?php echo form_input($phone); ?>
                        <font color="#FF0000"><?php echo form_error('phone'); ?></font>
                        </div>
                    </div>                     
                    <div class="row-form clearfix">
                        <div class="span3">Rating:</div>
                        <div class="span4"><?php echo form_input($rating); ?>
                        <font color="#FF0000"><?php echo form_error('rating'); ?></font>
                        </div>
                    </div>                     
                    <div class="row-form clearfix">
                        <div class="span3">Country:</div>
                        <div class="span4"><?php 
								$array_countries['']='Please Select a Country';
								foreach($countries as $country)
								{
									if($country->id!=0)
									$array_countries[$country->id]=$country->country;	
								}
											
								echo form_dropdown('country_id',$array_countries,$country_id,$class_country);
							?>
                        </div>
                    </div> 
                       <script language="javascript">
						function getcity(country_id,city_id)
							{
								$("#datacities").html("loading ... ");
								$.ajax({
									url: "<?php echo base_url();?>hotels/GetCities",
									type: "post",
									data: "id="+country_id+"&city_id="+city_id,
									success: function(result){
										$("#datacities").html(result);
									}
								});
							}
                    </script>                    
					<div class="row-form clearfix">
                        <div class="span3">City:</div>
                        <div class="span4"><div id="datacities"><select><option>Select Country first</option></select></div>
                        </div>
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