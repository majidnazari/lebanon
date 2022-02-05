<script language="javascript">
jQuery(function($){
   $("#start_date").mask("9999-99-99");
   $("#end_date").mask("9999-99-99");
});

$(function() {
    $('#row_dim').hide(); 
    $('#cat_id').change(function(){
        if($('#cat_id').val() == 1) {
            $('#row_dim').show(); 
        } else {
            $('#row_dim').hide(); 
        } 
    });
});

function getcity(country_id,city_id,hotel_id)
		{
			$("#datacities").html("loading ... ");
			$.ajax({
				url: "<?php echo base_url();?>countries/GetCities",
				type: "post",
				data: "id="+country_id+"&city_id="+city_id+"&hotel_id="+hotel_id,
				success: function(result){
					$("#datacities").html(result);
				}
			});
		}
		
		function gethotels(city_id,hotel_id)
		{
			$("#datahotels").html("loading ... ");
			$.ajax({
				url: "<?php echo base_url();?>countries/GetHotels",
				type: "post",
				data: "id="+city_id+"&hotel_id="+hotel_id,
				success: function(result){
					$("#datahotels").html(result);
				}
			});
		}	
		
</script>    

<?php
$start_date = array(
	'name'	=> 'start_date',
	'id'	=> 'start_date',
	'class'	=> 'validate[required]',
	'value' => $start_date,
);
$end_date = array(
	'name'	=> 'end_date',
	'id'	=> 'end_date',
	'class'	=> 'validate[required]',	
	'value' => $end_date,
);
$staff_open = array(
	'name'	=> 'staff_open',
	'id'	=> 'staff_open',
	'value' => $staff_open,
);
$staff_close = array(
	'name'	=> 'staff_close',
	'id'	=> 'staff_close',	
	'value' => $staff_close,
);
$no_of_participants = array(
	'name'	=> 'no_of_participants',
	'id'	=> 'no_of_participants',	
	'value' => $no_of_participants,
);
$comment = array(
	'name'	=> 'comment',
	'id'	=> 'comment',
	'class'	=> '',	
	'value' => $comment,
	'cols'  =>35,
	'rows'  =>5,	
);
$class_major=' class="validate[required]" id="major_id"';
if($city_id=='')
$city_id=0;
$class_country=' class="validate[required]" id="country_id" onchange="getcity(this.value,'.$city_id.')"';
$category_js='id="cat_id"';
$class_city="'class'= 'validate[required]'";
?>
<div class="content">
   <?=$this->load->view("includes/_bread")?>         
    <div class="workplace">
        <div class="page-header">
            <h1><?=$subtitle?></h1>
        </div> 
		 <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'validation'));
          echo form_hidden('schedule_id',$schedule_id); ?>                     
        <div class="row-fluid">
            <div class="span6">
                <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1>Course Details</h1>
                </div>
                <div class="block-fluid"> 
                    <div class="row-form clearfix">
                        <div class="span3">Schedule Category:</div>
                        <div class="span7">
							<?php 
								$array_categories[0]='Select Category';
								foreach($categories as $category)
								{
									if($category->id!=0)
									$array_categories[$category->id]=$category->title;	
								}
								
											
								echo form_dropdown('category_id',$array_categories,$category_id,$category_js);
							?></div>
                    </div> 
                    <div id="row_dim">
                    <div class="row-form clearfix">
                        <div class="span3">No.of Participants:</div>
                        <div class="span7"><?php echo form_input($no_of_participants); ?>
                        <font color="#FF0000"><?php echo form_error('no_of_participants'); ?></font></div>
                    </div>
					<div class="row-form clearfix">
                        <div class="span3">Client:</div>
                        <div class="span7">
							<?php 
								$array_clients[0]='Select Client';
								foreach($clients as $client)
								{
									if($client->id!=0)
									$array_clients[$client->id]=$client->name;	
								}
								
											
								echo form_dropdown('client_id',$array_clients,$client_id);
							?></div>
                    </div>                     
                    </div>                                                           
                    <div class="row-form clearfix">
                        <div class="span3">Cours:</div>
                        <div class="span7"><?php 
								
								$array_course_group[0]='Please Select a Course';
								
							foreach($majors as $major){
								$array_courses=array();	
								foreach($courses as $course)
								{
									if($course->major_id==$major->id){
									$array_courses[$course->id]=$course->title;
									}
								}
							if(count($array_courses)){
							$array_course_group[$major->title]=$array_courses;	
							unset($array_courses);
							}
							
							}
											
								echo form_dropdown('course_id',$array_course_group,$course_id);
								
							?></div>
                    </div> 
                    <div class="row-form clearfix">
                        <div class="span3">Class Start Date:</div>
                        <div class="span7"><?php echo form_input($start_date); ?> yyyy-mm-dd
                        <font color="#FF0000"><?php echo form_error('start_date'); ?></font>
                        </div>
                    </div>                     
                    <div class="row-form clearfix">
                        <div class="span3">Class End Date:</div>
                        <div class="span7"><?php echo form_input($end_date); ?> yyyy-mm-dd
                        <font color="#FF0000"><?php echo form_error('end_date'); ?></font>
                        </div>
                    </div>
                    </div>
                <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1>Location</h1>
                </div>
                <div class="block-fluid"> 
                    <div class="row-form clearfix">
                        <div class="span3">Country:</div>
                        <div class="span7"><?php 
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
					<div class="row-form clearfix">
                        <div class="span3">City:</div>
                        <div class="span7">
                            <div id="datacities">
                                <?php if(count($cities_data)) {
                                    $data_city['']='Please Select a City';
                                    foreach($cities_data as $city_data)
                                    {
                                        if($city_data->id!=0)
                                        $data_city[$city_data->id]=$city_data->city;	
                                    }
                                                
                                    echo form_dropdown('city_id',$data_city,$city_id,$class_city);
                                    }
                                    else{
                                        $data_city['']='Please Select a Country First';
                                        echo form_dropdown('city_id',$data_city,$city_id);
                                        }
                                ?>
                            </div>
                        </div>
                    </div> 
					<div class="row-form clearfix">
                        <div class="span3">Hotel-Meeting Room </div>
                        <div class="span7">
                            <div id="datahotels">
                            <?php if(count($hotels_data)) {
                                        $data_hotels[0]='Please Select a Hotel';
                                        foreach($hotels_data as $hotel_data)
                                        {
                                            if($hotel_data->id!=0)
                                            $data_hotels[$hotel_data->id]=$hotel_data->name;	
                                        }
                                                    
                                        echo form_dropdown('hotel_meeting_id',$data_hotels,$hotel_meeting_id);
                                        }
                                        else{
                                            $data_hotels[0]='Please Select a City First';
                                            echo form_dropdown('hotel_meeting_id',$data_hotels,$hotel_meeting_id);
                                            }
                                    ?>
                             </div>
                        </div>
                    </div>                                       
                </div>
                  
            </div>
			            
			 
			<div class="span6" style="float:left !important">
                <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1>INMA Staff & Settings</h1>
                </div>
                <div class="block-fluid">          
                    <div class="row-form clearfix">
                        <div class="span3">INMA Staff Open:</div>
                        <div class="span7"><?php echo form_input($staff_open); ?>
                        <font color="#FF0000"><?php echo form_error('staff_open'); ?></font>
                        </div>
                    </div>                     
                    <div class="row-form clearfix">
                        <div class="span3">INMA Staff Close:</div>
                        <div class="span7"><?php echo form_input($staff_close); ?>
                        <font color="#FF0000"><?php echo form_error('staff_close'); ?></font>
                        </div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span3">Outline:</div>
                        <div class="span7">
							<?php
                            if($outline=='yes'){
                            $yes=TRUE;
                            $no='';
                            }
                            elseif($outline=='no'){
                            $no=TRUE;
                            $yes='';
                            }
                            else{
                                $yes='';
                                $no='';
                                }
                            
                             echo form_radio(array("name"=>"outline","id"=>"yes","value"=>"yes", 'checked'=>$yes)); ?>&nbsp;Yes
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php echo form_radio(array("name"=>"outline","id"=>"no","value"=>"no", 'checked'=>$no)); ?>&nbsp;No
					</div>
                    </div>
					<div class="row-form clearfix">
                        <div class="span3">Material Word:</div>
                        <div class="span7">
							<?php
                            if($material_word=='yes'){
                            $yes_w=TRUE;
                            $no_w='';
                            }
                            elseif($material_word=='no'){
                            $no_w=TRUE;
                            $yes_w='';
                            }
                            else{
                                $yes_w='';
                                $no_w='';
                                }
                            
                             echo form_radio(array("name"=>"material_word","id"=>"yes","value"=>"yes", 'checked'=>$yes_w)); ?>&nbsp;Yes
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php echo form_radio(array("name"=>"material_word","id"=>"no","value"=>"no", 'checked'=>$no_w)); ?>&nbsp;No
					</div>
                    </div> 
					<div class="row-form clearfix">
                        <div class="span3">Material PP:</div>
                        <div class="span7">
							<?php
                            if($material_pp=='yes'){
                            $yes_p=TRUE;
                            $no_p='';
                            }
                            elseif($material_pp=='no'){
                            $no_p=TRUE;
                            $yes_p='';
                            }
                            else{
                                $yes_p='';
                                $no_p='';
                                }
                            
                             echo form_radio(array("name"=>"material_pp","id"=>"yes","value"=>"yes", 'checked'=>$yes_p)); ?>&nbsp;Yes
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php echo form_radio(array("name"=>"material_pp","id"=>"no","value"=>"no", 'checked'=>$no_p)); ?>&nbsp;No
					</div>
                    </div>                                                          
                    <div class="row-form clearfix">
                        <div class="span3">Status:</div>
                        <div class="span4"><?php $array_status=array('done'=>'Done','pending'=>'Pending','canceled'=>'Canceled');
												echo form_dropdown('status',$array_status,$status);
							?></div>
                    </div>                        
                                                
                </div>
				
            </div> 
             
                    
        </div>
        <div class="row-fluid">                

                    <div class="span12">
                    <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1>Comments</h1>
                </div>
                        <div class="block">
    
                                                                        

                                                                        

                                       <div class="row-form clearfix">
                        <div class="span3">Comment:</div>
                        <div class="span7"><?php echo form_textarea($comment); ?></div>
                    </div>                                        
                    <div class="footer tar">
                    	<center><input type="submit" name="save" value="Save" class="btn"></center>
                    </div>                                              

                        </div>                    
                    </div>                                                                    
                    
                </div>
        <?=form_close()?>
    </div>
</div>