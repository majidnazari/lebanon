<style type="text/css">
    select {
        direction: rtl !important;
        font-size: 14px !important;
    }

    input {
        font-size: 14px !important;

    }

    textarea {
        font-size: 14px !important;

    }

    .label-ar {
        float: right !important;
        margin-left: 5px !important;
        text-align: right !important;
    }
</style>
<?php
/********************General Info**********************/
$array_name_ar=array('id'=>'name_ar','name'=>'name_ar','value'=>$name_ar);
$array_name_en=array('id'=>'name_en','name'=>'name_en','value'=>$name_en);
$array_establish_date=array('id'=>'establish_date','name'=>'establish_date','value'=>$establish_date);
$array_list_number=array('id'=>'list_number','name'=>'list_number','value'=>$list_number);
$array_bnk_capital=array('id'=>'bnk_capital','name'=>'bnk_capital','value'=>$bnk_capital,'style'=>'font-size:19px !important');
$array_personal_notes=array('id'=>'personal_notes','name'=>'personal_notes','value'=>$personal_notes,'style'=>'height:250px !important');


/*********************Address*************************/
$array_street_ar=array('id'=>'street_ar','name'=>'street_ar','value'=>$street_ar);
$array_street_en=array('id'=>'street_en','name'=>'street_en','value'=>$street_en);

$array_bldg_ar=array('id'=>'bldg_ar','name'=>'bldg_ar','value'=>$bldg_ar);
$array_bldg_en=array('id'=>'bldg_en','name'=>'bldg_en','value'=>$bldg_en);

$array_fax=array('id'=>'fax','name'=>'fax','value'=>$fax);
$array_phone=array('id'=>'phone','name'=>'phone','value'=>$phone);
$array_whatsapp=array('id'=>'whatsapp','name'=>'whatsapp','value'=>$whatsapp);

$array_pobox_ar=array('id'=>'pobox_ar','name'=>'pobox_ar','value'=>$pobox_ar,'style'=>'direction:rtl !important');
$array_pobox_en=array('id'=>'pobox_en','name'=>'pobox_en','value'=>$pobox_en);

$array_email=array('id'=>'email','name'=>'email','value'=>$email);
$array_website=array('id'=>'website','name'=>'website','value'=>$website);

$array_x_location=array('id'=>'x_location','name'=>'x_location','value'=>$x_location);
$array_y_location=array('id'=>'y_location','name'=>'y_location','value'=>$y_location);

$commercial_register_en = array('id'=>'commercial_register_en','name'=>'commercial_register_en','value'=>$commercial_register_en);
$commercial_register_ar = array('id'=>'commercial_register_ar','name'=>'commercial_register_ar','value'=>$commercial_register_ar);
/*********************Molhak*************************/
$array_res_person_ar=array('id'=>'res_person_ar','name'=>'res_person_ar','value'=>$res_person_ar);
$array_res_person_en=array('id'=>'res_person_en','name'=>'res_person_en','value'=>$res_person_en);
$array_app_refill_date=array('id'=>'app_refill_date','name'=>'app_refill_date','value'=>$app_refill_date);
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
	$(".search-select").select2();  
  });
	function getdistricts(gov_id)
	{
		$("#district").html("loading ... ");
		$.ajax({
			url: "<?php echo base_url();?>banks/GetDistricts",
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
			url: "<?php echo base_url();?>banks/GetArea",
			type: "post",
			data: "id="+district_id,
			success: function(result){
				$("#area").html(result);
			}
		});
	}
	jQuery(function($){
   $("#app_refill_date").mask("9999-99-99");
   $("#end_date").mask("9999-99-99");
    $("#x_location").mask("99°99'99.99\"");
   $("#y_location").mask("99°99'99.99\"");

});		
</script>		

<style type="text/css">
select{
	direction:rtl !important;
	}
.label-ar{
	text-align:right !important;
	font-size:15px;
	font-weight:bold;
}
.txt-ar{
	text-align:right !important;
	font-size:15px;
}
.row-form{
	font-size:16px !important;
}
</style>

<?php
$jsgov='id="gov_id" onchange="getdistricts(this.value)" required="required"';
$jsdis='id="district_id" onchange="getarea(this.value)" required="required"';
?>
<div class="content">
   <?=$this->load->view("includes/_bread")?>  
    <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'validation'));
          echo form_hidden('c_id',$c_id); 
		  echo form_hidden('logo',$adv_pic); 

		  ?>             
    <div class="workplace">
        <div class="page-header">
            <h1><?=$subtitle?>
                <input type="submit" name="save" value="Save" class="btn btn-large" style="float:right !important">
                &nbsp;
                <?php 
				if ($nave){
				echo anchor('banks/details/'.$id,'Cancel',array('class'=>'btn btn-large','style'=>'float:right !important; margin-right:10px'));
				}
				else{
				echo anchor('banks','Cancel',array('class'=>'btn btn-large','style'=>'float:right !important; margin-right:10px'));
					}
				?>
            </h1>
        </div> 
		               
        <div class="row-fluid">
         <?php if ($nave){
				$span='span9';
				}
			else{
				$span='span12';
				}?>
         <div class="<?=$span?>">       

        <div class="span6">
                 <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1>Address</h1>
                    <h1 style="float:right; margin-right:10px"> عنوان البنك</h1>
                </div>            
				<div class="block-fluid"> 
                <div class="row-form clearfix">
                        <div class="span8"><?php echo form_input(array('name'=>'bnk_ref','value'=>@$bnk_ref)); ?>
                        <font color="#FF0000"><?php echo form_error('bnk_ref'); ?></font></div>
                        <div class="span4" style="text-align:right !important">مرجع</div>
                     </div>
                    <div class="row-form clearfix">
                        
                        <?php 
							$gover=array(''=>'اختر المحافظة');
							foreach($governorates as $governorate){
								
								$gover[$governorate->id]=$governorate->label_en.' ( '.$governorate->label_ar.' )';
								}
						?>
                        <div class="span8"><?php echo form_dropdown('governorate_id',$gover,$governorate_id,$jsgov); ?>
                        <font color="#FF0000"><?php echo form_error('governorate_id'); ?></font></div>
                        <div class="span4" style="text-align:right !important">: المحافظة<font color="#FF0000">*</font></div>
                     </div>  
                     <div class="row-form clearfix"> 
                       
                       <div class="span8">
                        <div id="district">
                        <?php 
							$district_array=array();
							if(count($districts)>0){
							foreach($districts as $district){
								
								$district_array[$district->id]=$district->label_en.' ( '.$district->label_ar.' )';
								}
							}
						 echo form_dropdown('district_id',$district_array,$district_id,$jsdis); ?>
                        <font color="#FF0000"><?php echo form_error('district_id'); ?></font></div>
                        </div>
                        <div class="span4" style="text-align:right !important">:  القضاء<font color="#FF0000">*</font></div>
                     </div>   
                    <div class="row-form clearfix">  
                        
                        <div class="span8">
                        <div id="area">
                        <?php 
							$area_array=array();
							if(count($areas)>0){
							foreach($areas as $area){
								
								$area_array[$area->id]=$area->label_en.' ( '.$area->label_ar.' )';
								}
							}
						 echo form_dropdown('area_id',$area_array,$area_id,' required="required"'); ?>
                        <font color="#FF0000"><?php echo form_error('district_id'); ?></font></div>
                        </div>
                        <div class="span4" style="text-align:right">:  البلدة<font color="#FF0000">*</font></div>
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
                        <div class="span4" style="text-align:right"> : ملك </div>
                    </div>             
					<div class="row-form clearfix">                       
                        <div class="span8"><?php echo form_input($array_bldg_en); ?>
                        <font color="#FF0000"><?php echo form_error('bldg_en'); ?></font></div>
                        <div class="span4" style="text-align:right">: Building</div>
                    </div>                   
					<div class="row-form clearfix">                        
                        <div class="span8"><?php echo form_input($array_phone); ?>
                        <font color="#FF0000"><?php echo form_error('phone'); ?></font></div>
                        <div class="span4" style="text-align:right">: هاتف</div>
                    </div>  
                    <div class="row-form clearfix">                        
                        <div class="span8"><?php echo form_input($array_whatsapp); ?>
                        <font color="#FF0000"><?php echo form_error('whatsapp'); ?></font></div>
                        <div class="span4" style="text-align:right">: WhatsApp</div>
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
                        <div class="span8" style="text-align:right !important">
						<?php echo form_input(array('name'=>'address2_ar','value'=>@$address2_ar)); ?>
                        <font color="#FF0000"><?php echo form_error('address2_ar'); ?></font></div>
                        <div class="span4" style="text-align:right"> : العنوان ٢  </div>
                    </div>
                     <div class="row-form clearfix">
                        
                        <div class="span8"><?php echo form_input(array('name'=>'address2_en','value'=>@$address2_en)); ?>
                        <font color="#FF0000"><?php echo form_error('address2_en'); ?></font></div>
                        <div class="span4" style="text-align:right">: Address 2 </div>
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
                        <div class="span4" style="text-align:right !important"> : إسم البنك</div>
                    </div>                 
					<div class="row-form clearfix">
                         <div class="span8"><?php echo form_input($array_name_en); ?>
                        <font color="#FF0000"><?php echo form_error('name_en'); ?></font></div>
                        <div class="span4" style="text-align:right !important">: Bank Name</div>
                    </div> 
                    
                    <?php 
						$array_license_sources=array();
						if(count($license_sources)>0)
						{
							foreach($license_sources as $licence)
							{
								$array_license_sources[$licence->id]=$licence->label_ar;	
							}	
						}
						
					
					?>
                   <div class="row-form clearfix">
                        <div class="span8">
						<?php echo form_input(array('id'=>'trade_license','name'=>'trade_license','value'=>@$trade_license)); ?>
                        <font color="#FF0000"><?php echo form_error('trade_license'); ?></font></div>
                      <div class="span4" style="text-align:right">سجل تجاري </div>
                        
                    </div>
                    <div class="row-form clearfix">
                        <div class="span8">
						<?php echo form_dropdown('license_source_id',$array_license_sources,@$license_source_id,'class="search-select"'); ?>
                        <font color="#FF0000"><?php echo form_error('license_source_id'); ?></font></div>
                      <div class="span4" style="text-align:right">مصدر السجل</div>
                        
                    </div>
                   <div class="row-form clearfix">   
                       <div class="span8" ><?php echo form_input($array_establish_date); ?>
                        <font color="#FF0000"><?php echo form_error('establish_date'); ?></font>
                        </div>
						<div class="span4" style="text-align:right"> : سنة التأسيس </div>
                   </div>
                   <div class="row-form clearfix">   
                       <div class="span8" ><?php echo form_input($array_bnk_capital); ?>
                        <font color="#FF0000"><?php echo form_error('bnk_capital'); ?></font>
                        </div>
						<div class="span4" style="text-align:right">: رأس المال </div>
                   </div>
                   <div class="row-form clearfix">   
                       <div class="span8" ><?php echo form_input($array_list_number); ?>
                        <font color="#FF0000"><?php echo form_error('list_number'); ?></font>
                        </div>
						<div class="span4" style="text-align:right">لائحة المصارف </div>
                   </div>                                                        
                 </div>
               
			  <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1></h1>
                    <h1 style="float:right; margin-right:10px"> ملحق البنك</h1>
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
						 echo form_dropdown('position_id',$positiosn_array,$position_id,'style="direction:rtl"'); ?>
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
                        <div class="span8"><?php echo form_input($array_app_refill_date); ?>
                        <font color="#FF0000"><?php echo form_error('app_refill_date'); ?></font></div>
                        <div class="span4" style="text-align:right !important">: التاريخ </div>
                     </div>
                     <div class="row-form clearfix">  
                        <?php 
						if($is_adv!=1){
							
							$checkedis_adv=FALSE;
							
							
							}
						else{
							$checkedis_adv=TRUE;
							}	
						//echo 'Advertisment&nbsp;'.form_checkbox('is_adv', 1, $checkedis_adv);?>

                        
                        <div class="span7" style="text-align:right">
                        <?=form_input($array_adv_pic)?>
                       <!-- <input type="file" name="userfile" />-->
                        <br />
                        </div>
                        <div class="span5" style="text-align:right">صورة الاعلان </div>
                    </div>                                                        
                               
 					<div class="row-form clearfix">                         
                        <div class="span3"><?php 
						if($show_online==1){
							$checkedonline=TRUE;
							}
						else{
							$checkedonline=FALSE;
							}	
						echo 'Online&nbsp;'.form_checkbox('online', 1, $checkedonline);?>
                        </div>
                        <div class="span5"><?php 
						if($is_adv==1){
							$checkedis_adv=TRUE;
							}
						else{
							$checkedis_adv=FALSE;
							}	
						echo 'Advertisment&nbsp;'.form_checkbox('is_adv', 1, $checkedis_adv);?>
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
                    <div class="row-form clearfix">   
                    	<div class="span3 label-ar"><?php 
						if($display_directory==1){
						if($directory_interested==1){
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
						echo form_checkbox('directory_interested', 0, $interested2).'&nbsp;غير مهتم';?>
                        </div> 
                        <div class="span3 label-ar"><?php 	
						echo form_checkbox('directory_interested', 1, $interested1).'&nbsp;مهتم';?>
                        </div>                      
                        <div class="span6 label-ar"><?php 
						if($display_directory==1){
							$checked_display_directory=TRUE;
							}
						else{
							$checked_display_directory=FALSE;
							}	
						echo form_checkbox('display_directory', 1, $checked_display_directory).'&nbsp;<u>تم عرض الدليل&nbsp;</u>';?>
                        </div>
                        
                    </div>  
                    <div class="row-form clearfix">   
                    	<div class="span3 label-ar"><?php 
						if($display_exhibition==1){
						if($exhibition_interested==1){
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
						echo form_checkbox('exhibition_interested', 0, $exinterested2).'&nbsp;غير مهتم';?>
                        </div> 
                        <div class="span3 label-ar"><?php 	
						echo form_checkbox('exhibition_interested', 1, $exinterested1).'&nbsp;مهتم';?>
                        </div>                      
                        <div class="span6 label-ar"><?php 
						if($display_exhibition==1){
							$checked_display_exhibition=TRUE;
							}
						else{
							$checked_display_exhibition=FALSE;
							}	
						echo form_checkbox('display_exhibition', 1, $checked_display_directory).'&nbsp;<u>تم عرض المعرض</u>';?>
                        </div>
                        
                    </div>                                    
                    </div>
                    
        </div>
        
   
    <div class="row-fluid">
    <div class="span12">
        <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1>Note :</h1>
                    <h1 style="float:right; margin-right:10px;">ملاحظات شخصية</h1>
                </div>
                <div class="block-fluid"> 
                    <div class="row-form clearfix">
                        <div class="span12" ><?php echo form_textarea($array_personal_notes); ?></div>
                     </div>
                </div> 
        </div>
         </div>
        <?php $this->load->view('clients',['client_id'=>$c_id,'client_type'=>'bank','status_type'=>'show_items','title'=>'Show Activities']);?>
        </div>
    <?=form_close()?>
    <?php if($nave){ echo $this->load->view('banks/_navigation');}?>
</div>