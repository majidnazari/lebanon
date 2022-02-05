
<script language="javascript">

		function getinstructor(provider_id,instructor_id)
		{
			$("#datainstructor").html("loading ... ");
			$.ajax({
				url: "<?php echo base_url();?>providers/GetInstructors",
				type: "post",
				data: "id="+provider_id+"&instructor_id="+instructor_id,
				success: function(result){
					$("#datainstructor").html(result);
				}
			});
		}		
		
</script>    
<?php
$eveluation = array(
	'name'	=> 'eveluation',
	'id'	=> 'eveluation',
	'value' => $eveluation,
);
if($instructor_id=='')
$instructor_id=0;
$class_provider=' id="provider_id" onchange="getinstructor(this.value,'.$instructor_id.')"';


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
					  echo form_hidden('t_id',$t_id);
					  echo form_hidden('schedule_id',$schedule_id);
					  echo form_hidden('instructor_id',$instructor_id); ?> 
                <div class="block-fluid">                        
                    <div class="row-form clearfix">
                        <div class="span3">Class Schedule:</div>
                        <div class="span7"><?=$class_schedule?></div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span3">Provider:</div>
                        <div class="span4"><?php 
								$array_providers[0]='Please Select a Provider';
								foreach($providers as $provider)
								{
									if($provider->id!=0)
									$array_providers[$provider->id]=$provider->title;	
								}
											
								echo form_dropdown('provider_id',$array_providers,$provider_id,$class_provider);
							?>
                        </div>
                    </div>                   
					<div class="row-form clearfix">
                        <div class="span3">Instructor:</div>
                        <div class="span4">
                            <div id="datainstructor">
								<?php if(count($instructors_data)) {
                                                $data_instructors[0]='Please Select a Instructor';
                                                foreach($instructors_data as $instructor_data)
                                                {
                                                    if($instructor_data->id!=0)
                                                    $data_instructors[$instructor_data->id]=$instructor_data->fullname;	
                                                }
                                                            
                                                echo form_dropdown('instructor_id',$data_instructors,$instructor_id);
                                                }
                                                else{
                                                    $data_instructors[0]='Please Select a Provider First';
                                                    echo form_dropdown('instructor_id',$data_instructors,$instructor_id);
                                                    }
                                            ?>
                               </div>
                        </div>
                    </div>                                                                                             
					<div class="row-form clearfix">
                        <div class="span3">Hotel Room </div>
                        <div class="span4">
                            <div id="datahotels">
                            <?php if(count($hotels_data)) {
                                        $data_hotels[0]='No Hotel';
                                        foreach($hotels_data as $hotel_data)
                                        {
                                            if($hotel_data->id!=0)
                                            $data_hotels[$hotel_data->id]=$hotel_data->name;	
                                        }
                                          }         
                                        echo form_dropdown('hotel_meeting_id',$data_hotels,$hotel_id);
                                      
                                    ?>
                             </div>
                        </div>
                    </div> 
					<div class="row-form clearfix">
                        <div class="span3">Instructor Eveluation:</div>
                        <div class="span4"><?php echo form_input($eveluation); ?>
                        <font color="#FF0000"><?php echo form_error('eveluation'); ?></font>
                        </div>
                    </div>                    
                    <div class="row-form clearfix">
                        <div class="span3">Visa:</div>
                        <div class="span4"><?php $array_visa=array('Pending'=>'Pending','Done'=>'Done','N/A'=>'N/A');
												echo form_dropdown('visa',$array_visa,$visa);
							?></div>
                    </div>                        
					<div class="row-form clearfix">
                        <div class="span3">Ticket Issue:</div>
                        <div class="span4"><?php $array_ticket=array('Done'=>'Done','N/A'=>'N/A');
												echo form_dropdown('ticket',$array_ticket,$ticket);
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