<style type="text/css">
.row-form{
	font-size:15px !important;
}
.label-ar{
	float:right !important;
	margin-left:10px !important;
	text-align:right !important;
}
.adv-img{
}
.h1-ar{
	float:right !important;
	margin-right:10px !important;
	font-size:22px !important
	}
.row-form{
	padding: 5px 16px !important;
}
.icon{
	height:15px;
	margin-left:5px;
	margin-right:5px;
}
</style>
<div class="content">
	<?=$this->load->view("includes/_bread")?>
    <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'validation'));
          
		   ?>
    <div class="workplace">			            
             
                <div class="page-header">
                    <h1><?=$query['name_en'].'/&nbsp;'.$query['name_ar']?></h1>
                </div>  
                <?php if($msg!=''){ ?>
                <div class="row-fluid">
              	<div class="alert alert-success">               
                    <?php echo $msg;?>
                </div> 
                </div>
                <?php } ?>                 
                <div class="row-fluid">
                <div class="span12">   
                
                <div class="span9">
                <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1 style="font-size:16px !important"><?php echo $query['ref']; ?>  </h1>
                    <h1 class="h1-ar">معلومات عامة</h1>
                </div>
                <div class="block-fluid">
                
                     <div class="row-form clearfix">
                     	<div class="span6"><strong>Company Name: </strong><?php echo $query['name_en']; ?></div>
                        <div class="span6" style="text-align:right !important"><?php echo $query['name_ar']; ?> <strong class="label-ar"> : اسم المؤسسة </strong></div>
                        
                    </div>
                    <!--                 
                    <div class="row-form clearfix">
                    	<div class="span6"><strong>  : س . ت / رقم التر</strong><?php echo $query['commercial_register_en']; ?></div>                       
                        <div class="span6" style="text-align:right"><?php echo $query['commercial_register_ar']; ?>  
                        <strong class="label-ar"> : س . ت / رقم الترخيص </strong></div>
                    </div>-->
                    <div class="row-form clearfix">
                    	<div class="span6"><strong>Company Owner : </strong><?php echo $query['owner_name_en']; ?></div>                      
                        <div class="span6" style="text-align:right"><?php echo $query['owner_name']; ?>  
                        <strong class="label-ar"> : صاحب المؤسسة  </strong></div>
                    </div>   
                    <div class="row-form clearfix">
                    	<div class="span6"><strong>Auth. to sign : </strong><?php echo $query['auth_person_en']; ?></div>                       
                        <div class="span6" style="text-align:right"><?php echo $query['auth_person_ar']; ?>  
                        <strong class="label-ar"> : المفوض بالتوقيع </strong></div>
                    </div>   
                    <div class="row-form clearfix">
                    	<div class="span6"><strong>C.R: </strong>  <?php  echo $query['auth_no']; ?></div> 
                        <div class="span6" style="text-align:right">
                        <?php  echo $query['auth_no']; ?>
                        <strong class="label-ar">: سجل تجاري  </strong></div>
                    </div> 
                    <div class="row-form clearfix">
                    	<div class="span6"><strong>Place of C.R : </strong>
						<?php  
						if(count($license_sources)>0)
						echo $license_sources['label_en']; ?> </div>                       
                        <div class="span6" style="text-align:right"><?php  
						if(count($license_sources)>0)
						echo $license_sources['label_ar']; ?>
						
                        <strong class="label-ar"> :مصدر السجل  </strong></div>
                    </div> 
                    <div class="row-form clearfix">
                    	<div class="span6"><strong>Company Type : </strong><?php  
						if(count($company_types)>0)
						echo @$company_types['label_en']; ?></div>                       
                        <div class="span6" style="text-align:right"><?php  
						if(count($company_types)>0)
						echo @$company_types['label_ar']; ?> :   
                        <strong class="label-ar">نوع الشركة</strong></div>
                    </div> 
                    <div class="row-form clearfix">
                    	<div class="span6"><strong>Activity : </strong><?php  echo $query['activity_en']; ?></div>                       
                        <div class="span6" style="text-align:right"><?php  echo $query['activity_ar']; ?>  
                        <strong class="label-ar">النشاط  </strong></div>
                    </div> 
                    <?php  if($query['sector_id']!=''){
								$sct=$this->Item->GetSectorById($query['sector_id']);
								
								    ?>
                     <div class="row-form clearfix">
                    	<div class="span6"><strong>Sector : </strong><?php  echo @$sct['label_en']; ?></div>                       
                        <div class="span6" style="text-align:right"><?php  echo @$sct['label_ar']; ?>  
                        <strong class="label-ar">القطاع  </strong></div>
                    </div>   
               <?php } ?>
                    <div class="row-form clearfix">
                        <div class="span12" style="text-align:right"><?php  echo @$query['employees_number']; ?>
                            <strong class="label-ar">عدد العمال  </strong></div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span12" style="text-align:right !important"><strong class="label-ar"><?php  echo (@$query['is_closed'] == 1) ? 'مغلقة منذ '.$query['closed_date'] : '' ; ?></strong></div>

                    </div>
                </div>
                 <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1>Address</h1>
                    <h1 class="h1-ar"> عنوان المؤسسة</h1>
                </div>            
				<div class="block-fluid"> 
                    <div class="row-form clearfix">
                    	<div class="span6"><strong>Mohafaza : </strong><?php echo @$governorates['label_en']; ?></div>
                        <div class="span6" style="text-align:right"><strong class="label-ar">: المحافظة</strong>  <?php echo @$governorates['label_ar']; ?></div>
                        
                     </div>  
                     <div class="row-form clearfix">
                      <div class="span6"><strong>Kazaa : </strong><?php echo @$districts['label_en']; ?></div>
                       <div class="span6" style="text-align:right !important"><strong class="label-ar">:   القضاء</strong>   <?php echo @$districts['label_ar']; ?> </div>                      
                     </div>   
                    <div class="row-form clearfix">  
                        <div class="span6"><strong>City : </strong><?php echo @$area['label_en']; ?></div>
                        <div class="span6" style="text-align:right"><strong class="label-ar">:    البلدة</strong> <?php echo @$area['label_ar']; ?></div>
                    </div>  
                    <div class="row-form clearfix"> 
                    	<div class="span6"><strong>Street : </strong><?=$query['street_en']?></div>   
                        <div class="span6" style="text-align:right"><strong class="label-ar">: الشارع </strong> <?=$query['street_ar']?></div>
                    </div>                                                          
                    <div class="row-form clearfix">  
                        <div class="span6"><strong>Building : </strong><?=$query['bldg_en']?></div>                  
                        <div class="span6" style="text-align:right"><strong class="label-ar"> : بناية </strong><?=$query['bldg_ar']?></div>                  
                    </div>
                    <div class="row-form clearfix">  
                        <div class="span6"><strong>Address2 : </strong><?=$query['address2_en']?></div>                  
                        <div class="span6" style="text-align:right"><strong class="label-ar"> : العنوان ٢ </strong><?=$query['address2_ar']?></div>                  
                    </div>   
                    <div class="row-form clearfix">  
                        <div class="span6"><strong>phone : </strong><?=$query['phone']?></div>                  
                        <div class="span6" style="text-align:right"><strong class="label-ar">: هاتف</strong><?=$query['phone']?></div>                    </div>             
					<div class="row-form clearfix">  
                        <div class="span6"><strong>Fax : </strong><?=$query['fax']?></div>                  
                        <div class="span6" style="text-align:right"><strong class="label-ar">: فاكس </strong><?=$query['fax']?></div>                    </div>             
					<div class="row-form clearfix">  
                        <div class="span6"><strong>P.O. Box : </strong><?=$query['pobox_en']?></div>                  
                        <div class="span6" style="text-align:right; direction:rtl !important"><strong class="label-ar"> صندوق بريد :</strong><?=$query['pobox_ar']?></div>              
                    </div>             				             
					<div class="row-form clearfix">                        
                        <div class="span6"><strong>Email : </strong><?php echo $query['email']; ?></div>
                        <div class="span6"><strong>Website : </strong><?php echo $query['website']; ?></div>
                    </div>
                    <div class="row-form clearfix">                        
                        <div class="span6"><strong>N Location Decimal: </strong><?php echo $query['x_decimal']; ?></div>
                        <div class="span6"><strong>E Location Decimal: </strong><?php echo $query['y_decimal']; ?></div>
                        <iframe scrolling="no" width="100%" height="350" frameborder="0" marginheight="0" marginwidth="0" src="http://www.lebanon-industry.com/sites/map?name=<?=$query['name_ar']?>&x=<?=$query['x_decimal'];?>&y=<?=$query['y_decimal'];?>"></iframe>
                    </div>                                     
                    </div>
                    <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1 class="h1-ar">الرخصة</h1>
                </div>
                <div class="block-fluid">
                    <div class="row-form clearfix">
                        <div class="span6"></div>
                        <div class="span6" style="text-align:right"><?php echo @$query['ministry_id']; ?>
                            <strong class="label-ar">ID وزارة </strong></div>
                    </div>
                    <div class="row-form clearfix">
                     	<div class="span6"></div>
                        <div class="span6" style="text-align:right !important"><?php  echo (@$query['wezara_source'] == 1) ? 'وزارة الصناعة' : $query['other_source'] ; ?> <strong class="label-ar">مصدر الرخصة </strong></div>
                        
                    </div>
                    <div class="row-form clearfix">
                    	<div class="span6"></div>                      
                        <div class="span6" style="text-align:right"><?php echo $query['nbr_source']; ?>  
                        <strong class="label-ar">رقم الرخصة</strong></div>
                    </div>   
                    <div class="row-form clearfix">
                    	<div class="span6"></div>                       
                        <div class="span6" style="text-align:right"><?php echo $query['date_source']; ?>  
                        <strong class="label-ar">التاريخ </strong></div>
                    </div>   
                    <div class="row-form clearfix">
                    	<div class="span6"></div> 
                        <div class="span6" style="text-align:right">
                        <?php  echo $query['type_source']; ?>
                        <strong class="label-ar">الفئة</strong></div>
                    </div> 
                 </div>
                <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1> Affiliation to Economical & Technical Associations : </h1>
                   <!-- <h1  class="h1-ar"> :مجلس  الادارة  </h1>-->
                </div>
                <div class="block-fluid"> 
                <div class="row-form clearfix">
                	
                 </div>
                  </div>   
                  
                 <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1>Means of Export :</h1>
                    <h1 style="float:right; margin-right:10px;">  طريقة التصدير </h1>
                </div>
                   <div class="block-fluid"> 
                     <div class="row-form clearfix">   
                    	<div class="span4 label-ar">
						  <?php $style_ins_exp="class='english' disabled='disabled'"; 
					$checked_l='';
					$checked_d='';
					$checked_m='';
					if(@$query['is_exporter']==0){
							$checked_d='<img src="'.base_url().'img/unchecked.png" class="icon english" />';
							$checked_l='<img src="'.base_url().'img/checked.png" class="icon english" />';
							$checked_m='<img src="'.base_url().'img/unchecked.png" class="icon english" />';
						}
						elseif(@$query['is_exporter']==1){
							$checked_d='<img src="'.base_url().'img/checked.png" class="icon english" />';
							$checked_l='<img src="'.base_url().'img/unchecked.png" class="icon english" />';
							$checked_m='<img src="'.base_url().'img/unchecked.png" class="icon english" />';
							}
						elseif(@$query['is_exporter']==2){
							$checked_d='<img src="'.base_url().'img/unchecked.png" class="icon english" />';
							$checked_l='<img src="'.base_url().'img/unchecked.png" class="icon english" />';
							$checked_m='<img src="'.base_url().'img/checked.png" class="icon english" />';
							}	
						echo $checked_m.'&nbsp; بالواسطة';?>
                        </div>
                        <div class="span4 label-ar"><?php 	
						echo $checked_d.'&nbsp;  مباشر';?>
                        </div>  
                        <div class="span4 label-ar"><?php 
						echo $checked_l.'&nbsp; غير مصدر';?>
                        </div>                     
                    </div>
                </div> 
                <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1></h1>
                    <h1 class="h1-ar"> ملحق الشركة</h1>
                </div>
                    <?php $task=$this->Task->GetTaskByCompanyId($query['id']);?>
                <div class="block-fluid">
                    <?php if(count($task)>0){ ?>
                    <div class="row-form clearfix">
                        <div class="span6"></div>
                        <div class="span6" style="text-align:right !important"><strong class="label-ar"> مسح 2017</strong>
                            <?=$task['sales_man_ar'].' - '.$task['list_id']?></div>
                    </div>
                    <?php } ?>
                	<div class="row-form clearfix">
                    	<div class="span6"></div>
                        <div class="span6" style="text-align:right !important"><strong class="label-ar">مرجع</strong>
                        <?=$query['ref']?></div>
                    </div>
                    <div class="row-form clearfix">
                    	<div class="span6"><strong>Interviewer : </strong><?=$query['rep_person_en']?></div>
                        <div class="span6" style="text-align:right !important"><strong class="label-ar">: مع من تمت المقابلة</strong>
                        <?=$query['rep_person_ar']?></div>
                    </div>
                    <?php if(count($salesman)>0){ ?>
                    <div class="row-form clearfix">
                    	<div class="span6"><strong>Sales Man : </strong><?=@$salesman['fullname_en']?></div>
                        <div class="span6" style="text-align:right !important"><strong class="label-ar"> : اسم المندوب </strong>
                        <?=@$salesman['fullname']?></div>
                    </div>
                    <?php } ?>
                    <div class="row-form clearfix">
                        <div class="span12" style="text-align:right !important"><strong class="label-ar"> : التاريخ </strong>
                        <?=$query['app_fill_date']?></div>
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
						if($query['show_online']==1){
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
                       
                        <div class="span6" style="text-align:right"><?=$query['adv_pic']?></div>
                        <div class="span3" style="text-align:right">صورة الاعلان </div>
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
							
						echo form_checkbox(array('checked'=>$checked_display_exhibition,'readonly'=>'readonly','disabled'=>'disabled') ).'&nbsp;<u>تم عرض المعرض</u>';?>
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
		         
              <?=$this->load->view('company/_navigation')?>      
              </div>
            </div>            
           <div class="dr"><span></span></div>           
         </div>
             <?=form_close()?>
        
</div>