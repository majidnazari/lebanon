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
.row-form{
	font-size:15px !important;
	padding:3px 10px !important;
}
.label-ar{
	text-align:right !important;
	float:right !important;
}
.label-ar strong{
	text-align:right !important;
	float:right !important;
}
.h1-ar{
	float:right !important;
	margin-right:10px !important;
	font-size:20px !important
	}
</style>

<script language="javascript">
jQuery(function($){
   $("#app_fill_date").mask("9999-99-99");
   $("#end_date").mask("9999-99-99");
});		
</script>    

<?php
$jsgov='id="gov_id" onchange="getdistricts(this.value)"';
$jsdis='id="district_id" onchange="getarea(this.value)"';
?>
<div class="content">
   <?=$this->load->view("includes/_bread")?>  
    <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'validation'));
          
		   ?>             
    <div class="workplace">
    
        <div class="page-header">
            <h1><?=$subtitle?></h1>
        </div> 
		               
        <div class="row-fluid">
        <div class="span9">
                <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1 style="font-size:16px !important"><?php echo $query['ref']; ?>  </h1>
                    <h1 class="h1-ar">معلومات عامة</h1>
                </div>
                <div class="block-fluid">
                     <div class="row-form clearfix">
                     	<div class="span6"><strong>Company Name : </strong><?php echo $query['name_en']; ?></div>
                        <div class="span6 label-ar"><?php echo $query['name_ar']; ?> <strong>: اسم الشركة </strong></div>
                    </div>                 
					<div class="row-form clearfix">
                    	<div class="span6"><strong>C.R : </strong><?php echo $query['cr_en']; ?></div>                       
                        <div class="span6 label-ar"><?php echo $query['cr_ar']; ?>  <strong> : س.ت </strong></div>
                    </div>   
                    <div class="row-form clearfix">
                    	<div class="span6"><strong>Capital : </strong><?php echo $query['capital']; ?></div>
                        <div class="span6 label-ar"><?php echo $query['capital']; ?> <strong> :  رأس المال </strong></div>
                        
                    </div>
                    <div class="row-form clearfix">
                        <div class="span6"><strong>Registration No. at Ministry of Economy : </strong><?php echo $query['ins_number']; ?></div>
                        <div class="span6 label-ar"><?php echo $query['ins_number']; ?> <strong> : رقم التسجيل في وزارة الاقتصاد والتجارة </strong></div>
                        
                    </div>                    
                    <div class="row-form clearfix"> 
                    	<div class="span6"><strong>Registration No. at Lebanon :  </strong> <?php echo $query['ins_ecoo_no']; ?></div>
                        <div class="span6 label-ar"><?php echo $query['ins_ecoo_no']; ?>                          <strong> : رقم الانتساب لجمعية شركات الضمان في لبنان </strong>
</div>
                    </div>       
					<div class="row-form clearfix">
                    	<div class="span6"><strong>Board of Directors : </strong><?php echo $query['manager_en']; ?></div>
                        <div class="span6 label-ar"><?php echo $query['manager_ar']; ?><strong> : مجلس الادارة </strong></div>
                    </div>
                	<div class="row-form clearfix">
                        <div class="span6"><strong>Executives Managing : </strong><?php echo $query['chairman_en']; ?></div>
                        <div class="span6 label-ar"><?php echo $query['chairman_ar']; ?>  <strong> : الادارة التنفيذية</strong> </div>    
                                       
                    </div>  
                  
                                                                          
                 </div>
                 <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1>Address</h1>
                    <h1 class="h1-ar"> عنوان المؤسسة</h1>
                </div>            
				<div class="block-fluid"> 
                    <div class="row-form clearfix">
                    <?php 
						if(count($governorates)>0)
						{
							$governorate_ar=$governorates['label_ar'];
							$governorate_en=$governorates['label_en'];
						}
						else{
							$governorate_ar='';
							$governorate_en='';

							}
						if(count($districts)>0)
						{
							$district_ar=$districts['label_ar'];
							$district_en=$districts['label_en'];
						}
						else{
							$district_ar='';
							$district_en='';

							}
						if(count($area)>0)
						{
							$area_ar=$area['label_ar'];
							$area_en=$area['label_en'];
						}
						else{
							$area_ar='';
							$area_en='';

							}		
					?>
                    	<div class="span6"><strong>Mohafaza : </strong><?php echo $governorate_en; ?></div>
                        <div class="span6 label-ar"><strong>: المحافظة</strong>  <?php echo $governorate_ar; ?></div>
                        
                     </div>  
                     <div class="row-form clearfix">
                      <div class="span6"><strong>Kazaa : </strong><?php echo $district_en; ?></div>
                       <div class="span6 label-ar"><strong>:   القضاء</strong>   <?php echo $district_ar; ?> </div>                      
                     </div>   
                    <div class="row-form clearfix">  
                        <div class="span6"><strong>City : </strong><?php echo $area_en; ?></div>
                        <div class="span6 label-ar"><strong>:    البلدة</strong> <?php echo $area_ar; ?></div>
                    </div>  
                    <div class="row-form clearfix"> 
                    	<div class="span6"><strong>Street : </strong><?=$query['street_en']?></div>   
                        <div class="span6 label-ar"><strong>: الشارع </strong> <?=$query['street_ar']?></div>
                    </div>                                                          
                    <div class="row-form clearfix">  
                        <div class="span6"><strong>Building : </strong><?=$query['bldg_en']?></div>                  
                        <div class="span6 label-ar"><strong> : بناية </strong><?=$query['bldg_ar']?></div>                  
                    </div> 
                    <div class="row-form clearfix">  
                        <div class="span6"><strong>Address2 : </strong><?=$query['address2_en']?></div>                  
                        <div class="span6 label-ar"><strong> : العنوان ٢ </strong><?=$query['address2_ar']?></div>                  
                    </div>   
                      
                    <div class="row-form clearfix">  
                        <div class="span6"><strong>phone : </strong><?=$query['phone']?></div>                  
                        <div class="span6 label-ar"><strong>: هاتف</strong><?=$query['phone']?></div>
                    </div>             
					<div class="row-form clearfix">  
                        <div class="span6"><strong>Fax : </strong><?=$query['fax']?></div>                  
                        <div class="span6 label-ar"><strong>: فاكس </strong><?=$query['fax']?></div>
                    </div>             
					<div class="row-form clearfix">  
                        <div class="span6"><strong>P.O. Box : </strong><?=$query['pobox_en']?></div>                  
                        <div class="span6 label-ar"><strong> : صندوق بريد </strong><?=$query['pobox_ar']?></div>              
                    </div>             				             
					<div class="row-form clearfix">                        
                        <div class="span6"><strong>Email : </strong><?php echo $query['email']; ?></div>
                        <div class="span6"><strong>Website : </strong><?php echo $query['website']; ?></div>
                    </div>
                    <div class="row-form clearfix">                        
                        <div class="span6"><strong>N Location : </strong><?php echo $query['x_location']; ?></div>
                        <div class="span6"><strong>E Location : </strong><?php echo $query['y_location']; ?></div>
                    </div>                                     
                    <iframe scrolling="no" width="100%" height="350" frameborder="0" marginheight="0" marginwidth="0" src="http://system.lebanon-industry.com/map/insurance/<?php echo $query['id']; ?>"></iframe> 
                    </div>
                 <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1>Classes of Business Transacted : </h1>
                    <h1 class="h1-ar">: أوجه النشاط التي تمارسها الشركة</h1>
                </div>
                <div class="block-fluid"> 
                
                <div class="row-form clearfix">
                	<ul style=" float:right; direction:rtl; width:100%">
                        <?php foreach($activities as $activity){
						
						echo '<li style="margin-top:5px; margin-right:30px">'.$activity->label_ar.' '.$activity->label_en.'</li>';
                         } ?> 
                        </ul> 
                        
                    </div>
                    
                    <div class="row-form clearfix">  
                     	<div class="span6"><strong>Other - Specify : </strong><?php echo $query['activity_other_ar']; ?></div>
                        <div class="span6"><strong class="label-ar">: نشاطات أخرى - حدد </strong><?php echo $query['activity_other_ar']; ?></div>
                    </div>
                    	</div>               
                <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1></h1>
                    <h1 class="h1-ar"> ملحق الشركة</h1>
                </div>
                <div class="block-fluid"> 
                    <div class="row-form clearfix">
                    	<div class="span6"><strong>Interviewer : </strong><?=$query['rep_person_en']?></div>
                        <div class="span6 label-ar"><strong>: مع من تمت المقابلة</strong>
                        <?=$query['rep_person_ar']?></div>
                    </div>
                    <?php if(count($salesman)>0){ ?>
                    <div class="row-form clearfix">
                    	<div class="span6"><strong>Sales Man : </strong><?=$salesman['fullname_en']?></div>
                        <div class="span6 label-ar"><strong> : اسم المندوب </strong>
                        <?=$salesman['fullname']?></div>
                    </div>
                    <?php } ?>
                    <div class="row-form clearfix">
                        <div class="span12 label-ar"><strong> : التاريخ </strong>
                        <?=$query['entry_date']?></div>
                    </div>
                     
                      
                      <div class="row-form clearfix">  
                        <div class="span3"><?php 
						if($query['is_adv']==1){
							$checkedis_adv=TRUE;
							}
						else{
							$checkedis_adv=FALSE;
							}
						if($query['copy_res']==1){
							$checkedcopy_res=TRUE;
							}
						else{
							$checkedcopy_res=FALSE;
							}		
						if($query['online']==1){
							$checkedonline=TRUE;
							}
						else{
							$checkedonline=FALSE;
							}			
						echo 'Advertisment&nbsp;'.form_checkbox(array('name'=>'is_adv','value'=> 1, 'checked'=>$checkedis_adv,'readonly'=>'readonly','disabled'=>'disabled')).'<br>';
						
						echo 'Copy Reservation&nbsp;'.form_checkbox(array('name'=>'copy_res','value'=> 1, 'checked'=>$checkedcopy_res,'readonly'=>'readonly','disabled'=>'disabled')).'<br>';
						echo 'Online&nbsp;'.form_checkbox(array('name'=>'online','value'=> 1, 'checked'=>$checkedonline,'readonly'=>'readonly','disabled'=>'disabled'));
						?>
                        </div>
                        
                        <div class="span5" style="text-align:right"><?=$query['adv_pic']?></div>
                        <div class="span4" style="text-align:right">صورة الاعلان </div>
                      
                    </div>             
 					<div class="row-form clearfix">   
                    	<div class="span6 label-ar"><?php 
						
						if($query['display_directory']==1){
						if($query['directory_interested']==1){
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
						if($query['display_directory']==1){
							$checked_display_directory=TRUE;
							}
						else{
							$checked_display_directory=FALSE;
							}	
						echo form_checkbox(array('checked'=>$checked_display_directory,'readonly'=>'readonly','disabled'=>'disabled')).'&nbsp;<u>تم عرض الدليل&nbsp;</u>';?>
                        </div>
                        <div class="span3 label-ar"><?php 	
						echo form_radio(array('checked'=>$interested1,'readonly'=>'readonly','disabled'=>'disabled')).'&nbsp;مهتم';?>
                        </div>  
                        <div class="span3 label-ar"><?php 
						echo form_radio(array('checked'=>$interested2,'readonly'=>'readonly','disabled'=>'disabled')).'&nbsp;غير مهتم';?>
                        </div>                     
                        
                        
                    </div>
                    <div class="row-form clearfix">   
                     <div class="span6 label-ar"><?php 
					 if($query['display_exhibition']==1){
						if($query['exhibition_interested']==1){
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
						if($query['display_exhibition']==1){
							$checked_display_exhibition=TRUE;
							}
						else{
							$checked_display_exhibition=FALSE;
							}	
							
						echo form_checkbox(array('checked'=>$checked_display_directory,'readonly'=>'readonly','disabled'=>'disabled') ).'&nbsp;<u>تم عرض المعرض</u>';?>
                        </div>
                        <div class="span3 label-ar"><?php 	
						echo form_radio(array('checked'=>$exinterested1,'readonly'=>'readonly','disabled'=>'disabled')).'&nbsp;مهتم';?>
                        </div>   
                    	<div class="span3 label-ar"><?php 
						
						echo form_radio(array('checked'=>$exinterested2,'readonly'=>'readonly','disabled'=>'disabled')).'&nbsp;غير مهتم';?>
                        </div> 
                        
                    </div>
                    <div class="row-form clearfix">
                    	<?php $user=$this->Administrator->GetUserById($query['user_id']);?>
                    	<div class="span6"><strong>Create By : </strong><?=@$user['username']?></div>
                        <div class="span6"><strong>Create Date : </strong>
                        <?=$query['create_time']?></div>
                    </div>
            </div>
                  <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1>Note :</h1>
                    <h1 class="h1-ar">ملاحظات شخصية</h1>
                </div>
                <div class="block-fluid"> 
                    <div class="row-form clearfix">
                        <div class="span12" ><?php echo $query['personal_notes']; ?></div>
                     </div>
                </div> 
            </div>
            <?=$this->load->view('insurance/_navigation');?>     
        </div>
    </div>
    <?=form_close()?>
</div>