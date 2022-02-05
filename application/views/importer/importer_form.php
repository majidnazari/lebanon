<?php
/********************General Info**********************/
$array_name_ar=array('id'=>'name_ar','name'=>'name_ar','value'=>$name_ar,'style'=>'direction:rtl !important;');
$array_name_en=array('id'=>'name_en','name'=>'name_en','value'=>$name_en);

$array_owner_ar=array('id'=>'owner_ar','name'=>'owner_ar','value'=>$owner_ar,'style'=>'direction:rtl !important;');
$array_owner_en=array('id'=>'owner_en','name'=>'owner_en','value'=>$owner_en);


$array_personal_notes=array('id'=>'personal_notes','name'=>'personal_notes','value'=>$personal_notes,'style'=>'height:250px !important');

/*********************Address*************************/
$array_street_ar=array('id'=>'street_ar','name'=>'street_ar','value'=>$street_ar,'style'=>'direction:rtl !important;');
$array_street_en=array('id'=>'street_en','name'=>'street_en','value'=>$street_en);

$array_bldg_ar=array('id'=>'bldg_ar','name'=>'bldg_ar','value'=>$bldg_ar,'style'=>'direction:rtl !important;');
$array_bldg_en=array('id'=>'bldg_en','name'=>'bldg_en','value'=>$bldg_en);

$array_fax=array('id'=>'fax','name'=>'fax','value'=>$fax);
$array_phone=array('id'=>'phone','name'=>'phone','value'=>$phone);

$array_pobox_ar=array('id'=>'pobox_ar','name'=>'pobox_ar','value'=>$pobox_ar,'style'=>'direction:rtl !important;');
$array_pobox_en=array('id'=>'pobox_en','name'=>'pobox_en','value'=>$pobox_en);

$array_email=array('id'=>'email','name'=>'email','value'=>$email);
$array_website=array('id'=>'website','name'=>'website','value'=>$website);
$array_x_location=array('id'=>'x_location','name'=>'x_location','value'=>$x_location);
$array_y_location=array('id'=>'y_location','name'=>'y_location','value'=>$y_location);

/*********************Molhak*************************/
$array_res_person_ar=array('id'=>'res_person_ar','name'=>'res_person_ar','value'=>$res_person_ar,'style'=>'direction:rtl !important;');
$array_res_person_en=array('id'=>'res_person_en','name'=>'res_person_en','value'=>$res_person_en);

$array_app_fill_date=array('id'=>'app_refill_date','name'=>'app_refill_date','value'=>$app_refill_date);
$array_adv_pic=array('id'=>'adv_pic','name'=>'adv_pic','value'=>$adv_pic);


?>

<script language="javascript">
 $(function() {
	  $( "#app_refill_date" ).datepicker({
		  dateFormat: "yy-mm-dd"
		});
	$( "#end_date" ).datepicker({
		  dateFormat: "yy-mm-dd"
		});	
    //$( "#app_fill_date" ).datepicker();
  });
$(document).ready(function(){
	$("#other-area").hide();
	$("#other").click(function() {
	if ($('#other').is(":checked"))
	{
	  $("#other-area").show();
	}
	else
	{
	   $("#other-area").hide();
	}
	});
});
	function getdistricts(gov_id)
	{
		$("#district").html("loading ... ");
		$.ajax({
			url: "<?php echo base_url();?>companies/GetDistricts",
			type: "post",
			data: "id="+gov_id,
			success: function(result){
				$("#district").html(result);
			}
		});
	}
	function getarea(district_id)
	{
		$("#area").html("loading ... ");
		$.ajax({
			url: "<?php echo base_url();?>companies/GetArea",
			type: "post",
			data: "id="+district_id,
			success: function(result){
				$("#area").html(result);
			}
		});
	}	
</script>		
<style type="text/css">
select{
	direction:rtl !important;
	font-size:14px !important;
	}
input{
	font-size:14px !important;
	
}
textarea{
	font-size:14px !important;
	
}
.label-ar{
	float:right !important;
	margin-left:5px !important;
	text-align:right !important;
}

</style>

<script language="javascript">
jQuery(function($){
     $("#x_location").mask("99°99'99.99\"");
   $("#y_location").mask("99°99'99.99\"");

});		
</script>    

<?php
$jsgov='id="gov_id" onchange="getdistricts(this.value)" class="search-select"  required="required"';
$jsdis='id="district_id" onchange="getarea(this.value)" class="search-select"  required="required"';
?>
<div class="content">
   <?=$this->load->view("includes/_bread")?>  
    <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'validation'));
          echo form_hidden('c_id',$c_id);
		  //echo form_hidden('adv_pic',$adv_pic);
		   ?>             
    <div class="workplace">
    
        <div class="page-header">
            <h1><?=$subtitle?>
                <input type="submit" name="save" value="Save" class="btn btn-large" style="float:right !important">
                &nbsp;
                <?php if($c_id!=''){
                echo anchor('importers/details/'.$c_id,'Cancel',array('class'=>'btn btn-large','style'=>'float:right !important; margin-right:10px'));
				}else{
					echo anchor('importers/','Cancel',array('class'=>'btn btn-large','style'=>'float:right !important; margin-right:10px'));
					}
				?>
            </h1>
        </div> 
		               
        <div class="row-fluid">
        <?php if ($nave){?>
        <div class="span9">
        <?php } ?>
        <div class="span6">
                 <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1>Address</h1>
                    <h1 style="float:right; margin-right:10px"> عنوان المؤسسة</h1>
                </div>            
				<div class="block-fluid"> 
                <div class="row-form clearfix">
                        <div class="span8"><?php echo form_input(array('name'=>'ref','value'=>@$ref)); ?>
                        <font color="#FF0000"><?php echo form_error('ref'); ?></font></div>
                        <div class="span4" style="text-align:right !important">مرجع</div>
                     </div>
                    <div class="row-form clearfix">
                        
                        <?php 
							$gover=array(''=>'اختر المحافظة');
							foreach($governorates as $governorate){
								
								$gover[$governorate->id]=$governorate->label_ar.' ( '.$governorate->label_en.' )';
								}
						?>
                        <div class="span8"><?php echo form_dropdown('governorate_id',$gover,$governorate_id,$jsgov); ?>
                        <font color="#FF0000"><?php echo form_error('governorate_id'); ?></font></div>
                        <div class="span4" style="text-align:right !important"><font color="#FF0000">*</font>: المحافظة</div>
                     </div>  
                     <div class="row-form clearfix"> 
                       
                       <div class="span8">
                        <div id="district">
                        <?php 
							$district_array=array(''=>'اختر القضاء');
							if(count($districts)>0){
							foreach($districts as $district){
								
								$district_array[$district->id]=$district->label_ar.' ( '.$district->label_en.' )';
								}
							}
						 echo form_dropdown('district_id',$district_array,$district_id,$jsdis); ?>
                        <font color="#FF0000"><?php echo form_error('district_id'); ?></font></div>
                        </div>
                        <div class="span4" style="text-align:right !important"><font color="#FF0000">*</font>:  القضاء</div>
                     </div>   
                    <div class="row-form clearfix">  
                        
                        <div class="span8">
                        <div id="area">
                        <?php 
							$area_array=array(''=>'اختر البلدة');
							if(count($areas)>0){
							foreach($areas as $area){
								
								$area_array[$area->id]=$area->label_ar.' ( '.$area->label_en.' )';
								}
							}
						 echo form_dropdown('area_id',$area_array,$area_id,' required="required"'); ?>
                        <font color="#FF0000"><?php echo form_error('district_id'); ?></font></div>
                        </div>
                        <div class="span4" style="text-align:right"><font color="#FF0000">*</font>:  البلدة</div>
                    </div>  
                    <div class="row-form clearfix">    
                        <div class="span8" style="text-align:right"><?php echo form_input($array_street_ar); ?>
                        <font color="#FF0000"><?php echo form_error('street_ar'); ?></font></div>
                        <div class="span4" style="text-align:right"> :   شارع</div>
                    </div>                                                      
                    <div class="row-form clearfix">
                       
                        <div class="span8"><?php echo form_input($array_street_en); ?>
                        <font color="#FF0000"><?php echo form_error('street_en'); ?></font></div>
                        <div class="span4" style="text-align:right" > : Street</div>
                    </div>      
                    <div class="row-form clearfix">  
                        <div class="span8" style="text-align:right"><?php echo form_input($array_bldg_ar); ?>
                        <font color="#FF0000"><?php echo form_error('bldg_ar'); ?></font></div>
                        <div class="span4" style="text-align:right"> : بناية </div>
                    </div>             
					<div class="row-form clearfix">                       
                        <div class="span8"><?php echo form_input($array_bldg_en); ?>
                        <font color="#FF0000"><?php echo form_error('bldg_en'); ?></font></div>
                        <div class="span4" style="text-align:right">: Building</div>
                    </div>                   
					<div class="row-form clearfix">  
                        <div class="span8" style="text-align:right">
						<?php echo form_input(array('name'=>'address2_ar','value'=>@$address2_ar)); ?>
                        <font color="#FF0000"><?php echo form_error('address2_ar'); ?></font></div>
                        <div class="span4" style="text-align:right"> : العنوان ٢ </div>
                    </div>             
					<div class="row-form clearfix">                       
                        <div class="span8"><?php echo form_input(array('name'=>'address2_en','value'=>@$address2_en)); ?>
                        <font color="#FF0000"><?php echo form_error('address2_en'); ?></font></div>
                        <div class="span4" style="text-align:right">: Address 2</div>
                    </div>                   

					<div class="row-form clearfix">                        
                        <div class="span8"><?php echo form_input($array_phone); ?>
                        <font color="#FF0000"><?php echo form_error('phone'); ?></font></div>
                        <div class="span4" style="text-align:right">: هاتف</div>
                    </div>             
					<div class="row-form clearfix">                              
                        <div class="span8"><?php echo form_input($array_fax); ?>
                        <font color="#FF0000"><?php echo form_error('fax'); ?></font></div>
                        <div class="span4" style="text-align:right">: فاكس </div>
                    </div>
                    <div class="row-form clearfix">      
                        <div class="span8" style="text-align:right !important"><?php echo form_input($array_pobox_ar); ?>
                        <font color="#FF0000"><?php echo form_error('pobox_ar'); ?></font></div>
                        <div class="span4" style="text-align:right"> : صندوق بريد </div>
                    </div>
 					<div class="row-form clearfix">
                        
                        <div class="span8"><?php echo form_input($array_pobox_en); ?>
                        <font color="#FF0000"><?php echo form_error('pobox_en'); ?></font></div>
                        <div class="span4" style="text-align:right">: P.O. Box </div>
                     </div>             
					<div class="row-form clearfix">                        
                        <div class="span8"><?php echo form_input($array_email); ?>
                        <font color="#FF0000"><?php echo form_error('email'); ?></font></div>
                        <div class="span4" style="text-align:right">: Email</div>
                    </div>
 					<div class="row-form clearfix">                         
                        <div class="span8"><?php echo form_input($array_website); ?>
                        <font color="#FF0000"><?php echo form_error('website'); ?></font></div>    
                        <div class="span4" style="text-align:right">: Website</div>
                    </div> 
                    <?php 
						/*
						$x1=explode('°',$x_location);
						$x2=explode("'",@$x1[1]);
						$x3=explode('"',@$x2[1]);
						
						$y1=explode('°',$y_location);
						$y2=explode("'",@$y1[1]);
						$y3=explode('"',@$y2[1]);
*/
					?>
					 <div class="row-form clearfix">                        
                        <div class="span8"><?php echo form_input(array('name'=>'x_location','value'=>@$x_location)); ?>
                        <font color="#FF0000"><?php echo form_error('x_location'); ?></font></div>
                        <div class="span4" style="text-align:right">: N Location Decimal</div>
                    </div>
 					<div class="row-form clearfix">                         
                        <div class="span8"><?php echo form_input(array('name'=>'y_location','value'=>@$y_location)); ?>
                        <font color="#FF0000"><?php echo form_error('y_location'); ?></font></div>    
                        <div class="span4" style="text-align:right">: E Location Decimal</div>
                    </div>                                        
                    </div>            
                <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1></h1>
                    <h1 style="float:right; margin-right:10px"> ملحق الشركة</h1>
                </div>
                <div class="block-fluid">
                 
                    <div class="row-form clearfix">
                        <div class="span8"><?php echo form_input($array_res_person_ar); ?>
                        <font color="#FF0000"><?php echo form_error('res_person_ar'); ?></font></div>
                        <div class="span4" style="text-align:right !important">: مع من تمت المقابلة</div>
                     </div>
                     <div class="row-form clearfix">
                        <div class="span8"><?php echo form_input($array_res_person_en); ?>
                        <font color="#FF0000"><?php echo form_error('res_person_en'); ?></font></div>
                        <div class="span4" style="text-align:right !important"> : Interviewer</div>
                     </div>    
                       <div class="row-form clearfix">                       
                       <div class="span8">
                        <?php 
							$positiosn_array=array(0=>'اختر ');
							if(count($positions)>0){
							foreach($positions as $position){
								
								$positiosn_array[$position->id]=$position->label_ar.' ( '.$position->label_en.' )';
								}
							}
						 echo form_dropdown('position_id',$positiosn_array,@$position_id,'style="direction:rtl"'); ?>
                        <font color="#FF0000"><?php echo form_error('position_id'); ?></font>
                        </div>
                        <div class="span4" style="text-align:right !important">:صفته في المؤسسة</div>
                     </div> 
                        
                    <div class="row-form clearfix">  
                        
                        <div class="span8">
                        <?php 
							$sales_array=array(0=>'اختر');
							if(count($sales)>0){
							foreach($sales as $item){
								
								$sales_array[$item->id]=$item->fullname;
								}
							}
						 echo form_dropdown('sales_man_id',$sales_array,$sales_man_id,'style="direction:rtl"'); ?>
                        <font color="#FF0000"><?php echo form_error('sales_man_id'); ?></font></div>
                        <div class="span4" style="text-align:right">: المندوب</div>
                    </div>  
                    <div class="row-form clearfix">                      
                        <div class="span8"><?php echo form_input($array_app_fill_date); ?>yyyy-mm-dd
                        <font color="#FF0000"><?php echo form_error('app_refill_date'); ?></font></div>
                        <div class="span4" style="text-align:right" >تاريخ ملء الاستمارة</div>
                    </div>  
                      <div class="row-form clearfix">  
                        <div class="span3"><?php 
						if($is_adv!=1){
							
							$checkedis_adv=FALSE;
							
							
							}
						else{
							$checkedis_adv=TRUE;
							}	
						echo 'Advertisment&nbsp;'.form_checkbox('is_adv', 1, $checkedis_adv);?>
                        </div>
                        <div class="span5" style="text-align:right">
                        <!--<input type="file" name="userfile" />-->
                        <?=form_input($array_adv_pic);?>
)
                        <br />
                        </div>
                        <div class="span4" style="text-align:right">صورة الاعلان </div>
                    </div>                     
 					<div class="row-form clearfix">                         
                         
                        <div class="span2"><?php 
						if($status==0){
							$checkedonline=FALSE;
							}
						else{
							$checkedonline=TRUE;
							}	
						echo 'Online&nbsp;'.form_checkbox('status', 1, $checkedonline);?>
                        </div>
                        
                        <div class="span4"><?php 
						if($copy_res==1){
							$checkedcopy_res=TRUE;
							}
						else{
							$checkedcopy_res=FALSE;
							}	
						echo 'Copy Reservation&nbsp;'.form_checkbox('copy_res', 1, $checkedcopy_res);?>
                        </div>   
                    </div>                                        
                    </div>
                  
            </div>
            <div class="span6">
                <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1>General Info
                    	
                    </h1>
                    <h1 style="float:right !important; margin-right:10px;">معلومات عامة</h1>
                </div>
                <div class="block-fluid">
                     <div class="row-form clearfix">
                        <div class="span8"style="text-align:right !important"><?php echo form_input($array_name_ar); ?>
                        <font color="#FF0000"><?php echo form_error('name_ar'); ?></font></div>
                        <div class="span4" style="text-align:right !important">: اسم الشركة </div>
                    </div>                 
					<div class="row-form clearfix">
                         <div class="span8"><?php echo form_input($array_name_en); ?>
                        <font color="#FF0000"><?php echo form_error('name_en'); ?></font></div>
                        <div class="span4" style="text-align:right !important">: Company Name</div>
                    </div> 
                    <div class="row-form clearfix">
                        
                        <div class="span8"><?php echo form_input($array_owner_ar); ?>
                        <font color="#FF0000"><?php echo form_error('owner_ar'); ?></font></div>
                        <div class="span4" style="text-align:right">: صاحب / اصحاب الشركة  </div>
                        </div>
                     <div class="row-form clearfix">
                        
                        <div class="span8"><?php echo form_input($array_owner_en); ?>
                        <font color="#FF0000"><?php echo form_error('owner_en'); ?></font></div>
                        <div class="span4" style="text-align:right"> : Owner / Owners of the Company</div>
                        </div>   
                    
                    
                        
                  
                                                                          
                 </div>
                 <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1>Sectors : </h1>
                    <h1 style="float:right; margin-right:10px;">القطاعات</h1>
                </div>
                <div class="block-fluid"> 
                
                <div class="row-form clearfix">
                	<ul style="list-style:none; float:right; direction:rtl">
                        <?php
						 foreach($activities as $activity){
						if(in_array($activity->id,$activities_data)){
							$checked=TRUE;
							}
						else{
							$checked=FALSE;
							}
							
						echo '<li style="display:inline-block; width:100%; margin-top:5px">'.form_checkbox('activities[]', $activity->id, $checked,'style="float:left; margin:5px"');?><?=$activity->label_ar.'<br>'.$activity->label_en?></li>
                         <?php } ?> 
                         </ul>
                       </div>
                      </div>   
                         <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1>Activity : </h1>
                                <h1 style="float:right; margin-right:10px;">: أوجه النشاط التي تمارسها الشركة</h1>
                            </div>
                            <div class="block-fluid"> 
                            <div class="row-form clearfix">
                        
                                <div class="span10"><?=form_input(array('name'=>'activity_other_ar','value'=>@$activity_other_ar))?>
                                <font color="#FF0000"><?php echo form_error('activity_other_ar'); ?></font></div>
                                <div class="span2" style="text-align:right">النشاط</div>
                             </div>
                            <div class="row-form clearfix">
                            <div class="span10"><?=form_input(array('name'=>'activity_other_en','value'=>@$activity_other_en))?>
                            <font color="#FF0000"><?php echo form_error('activity_other_en'); ?></font></div>
                            <div class="span2" style="text-align:right"> : Activity</div>
                          </div>  
                    </div>
                    
                <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1>Note :</h1>
                    <h1 style="float:right; margin-right:10px;">ملاحظات شخصية</h1>
                </div>
                <div class="block-fluid"> 
                    <div class="row-form clearfix">
                        <div class="span12" ><?php echo form_textarea($array_personal_notes); ?></div>
                     </div>
                     <div class="row-form clearfix">   
                    	<div class="span6 label-ar"><?php 
						
						if(@$display_directory==1){
						if(@$directory_interested==1){
							$interested1=TRUE;
							$interested2=FALSE;
							}
						else{
							$interested1=FALSE;
							$interested2=TRUE;
							}
						}
						else{
							$interested1=FALSE;
							$interested2=FALSE;
							}
						if(@$display_directory==1){
							$checked_display_directory=TRUE;
							}
						else{
							$checked_display_directory=FALSE;
							}	
						echo form_checkbox(array('checked'=>$checked_display_directory,'name'=>'display_directory','value'=>1)).'&nbsp;<u>تم عرض الدليل&nbsp;</u>';?>
                        </div>
                        <div class="span3 label-ar"><?php 	
						echo form_checkbox(array('checked'=>$interested1,'name'=>'directory_interested','value'=>1)).'&nbsp;مهتم';?>
                        </div>  
                        <div class="span3 label-ar"><?php 
						echo form_checkbox(array('checked'=>$interested2,'name'=>'directory_interested','value'=>0)).'&nbsp;غير مهتم';?>
                        </div>                     
                        
                        
                    </div>
                    <div class="row-form clearfix">   
                     <div class="span6 label-ar"><?php 
					 if(@$display_exhibition==1){
						if(@$exhibition_interested==1){
							$exinterested1=TRUE;
							$exinterested2=FALSE;
							}
						else{
							$exinterested1=FALSE;
							$exinterested2=TRUE;
							}	
						}
						else{
							$exinterested1=FALSE;
							$exinterested2=FALSE;
							}
						if(@$display_exhibition==1){
							$checked_display_exhibition=TRUE;
							}
						else{
							$checked_display_exhibition=FALSE;
							}	
							
						echo form_checkbox(array('checked'=>$checked_display_exhibition,'name'=>'display_exhibition','value'=>1) ).'&nbsp;<u>تم عرض المعرض</u>';?>
                        </div>
                        <div class="span3 label-ar"><?php 	
						echo form_checkbox(array('checked'=>$exinterested1,'name'=>'exhibition_interested','value'=>1)).'&nbsp;مهتم';?>
                        </div>   
                    	<div class="span3 label-ar"><?php 
						
						echo form_checkbox(array('checked'=>$exinterested2,'name'=>'exhibition_interested','value'=>0)).'&nbsp;غير مهتم';?>
                        </div> 
                        
                    </div>
                </div> 
              <?php $this->load->view('clients',['client_id'=>$c_id,'client_type'=>'importer','status_type'=>'show_items','title'=>'Show Activities']);?>
        </div>
        <?php if ($nave){?>
        </div>
        
    <?=$this->load->view('importer/_navigation')?>
    <?php } ?>
    </div>
    <?=form_close()?>
</div>