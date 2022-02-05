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
	height:200px;
}
.h1-ar{
	float:right !important;
	margin-right:10px !important;
	font-size:22px !important
	}
.row-form{
	padding: 5px 16px !important;
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
                <div class="row-fluid">
                <div class="span12">   
                <?php if($msg!=''){ ?>
              	<div class="alert alert-success">               
                    <?php echo $msg;?>
                </div> 
                <?php } ?> 
                <div class="span9">
                <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1>Company Info</h1>
                    <h1 class="h1-ar">معلومات عامة</h1>
                </div>
                <div class="block-fluid">
                     <div class="row-form clearfix">
                     	<div class="span6"><strong>Company Name: </strong><?php echo $query['name_en']; ?></div>
                        <div class="span6" style="text-align:right !important"><?php echo $query['name_ar']; ?> <strong class="label-ar"> : اسم الشركة </strong></div>
                        
                    </div>                 
                    <div class="row-form clearfix">
                    	<div class="span6"><strong>C.R : </strong><?php echo $query['commercial_register_en']; ?></div>                       
                        <div class="span6" style="text-align:right"><?php echo $query['commercial_register_ar']; ?>  
                        <strong class="label-ar"> : س . ت / رقم الترخيص </strong></div>
                    </div>
                    <div class="row-form clearfix">
                    	<div class="span6"><strong>Capital : </strong><?php echo $query['bnk_capital']; ?></div>                      
                        <div class="span6" style="text-align:right"><?php echo $query['bnk_capital']; ?>  
                        <strong class="label-ar">: رأس المال  </strong></div>
                    </div>   
                    <div class="row-form clearfix">
                    	<div class="span6"><strong>Date Founded : </strong><?php echo $query['establish_date']; ?></div>                       
                        <div class="span6" style="text-align:right"><?php echo $query['establish_date']; ?>  
                        <strong class="label-ar">: تاريخ التأسيس </strong></div>
                    </div>   
                    <div class="row-form clearfix">
                    	<div class="span6"><strong>Banks List : </strong><?php  echo $query['list_number']; ?></div>                       
                        <div class="span6" style="text-align:right"><?php  echo $query['list_number']; ?>  
                        <strong class="label-ar">: لائحة المصارف </strong></div>
                    </div>   
                    
                                                                          
                 </div>
                 <?php /*
                 <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1> Board Of Directors: </h1>
                    <h1  class="h1-ar"> :مجلس  الادارة  </h1>
                </div>
                <div class="block-fluid"> 
                <div class="row-form clearfix">
                	
                 </div>
                  </div>   
                  <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1>Address</h1>
                    <h1 class="h1-ar"> عنوان المؤسسة</h1>
                </div>            
				<div class="block-fluid"> 
                    <div class="row-form clearfix">
                    	<div class="span6"><strong>Mohafaza : </strong><?php echo $governorates['label_en']; ?></div>
                        <div class="span6" style="text-align:right"><strong class="label-ar">: المحافظة</strong>  <?php echo $governorates['label_ar']; ?></div>
                        
                     </div>  
                     <div class="row-form clearfix">
                      <div class="span6"><strong>Kazaa : </strong><?php echo $districts['label_en']; ?></div>
                       <div class="span6" style="text-align:right !important"><strong class="label-ar">:   القضاء</strong>   <?php echo $districts['label_ar']; ?> </div>                      
                     </div>   
                    <div class="row-form clearfix">  
                        <div class="span6"><strong>City : </strong><?php echo $area['label_en']; ?></div>
                        <div class="span6" style="text-align:right"><strong class="label-ar">:    البلدة</strong> <?php echo $area['label_ar']; ?></div>
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
                        <div class="span6"><strong>phone : </strong><?=$query['phone']?></div>                  
                        <div class="span6" style="text-align:right"><strong class="label-ar">: هاتف</strong><?=$query['phone']?></div>                    </div>             
					<div class="row-form clearfix">  
                        <div class="span6"><strong>Fax : </strong><?=$query['fax']?></div>                  
                        <div class="span6" style="text-align:right"><strong class="label-ar">: فاكس </strong><?=$query['fax']?></div>                    </div>             
					<div class="row-form clearfix">  
                        <div class="span6"><strong>P.O. Box : </strong><?=$query['pobox_en']?></div>                  
                        <div class="span6" style="text-align:right"><strong class="label-ar"> : صندوق بريد </strong><?=$query['pobox_ar']?></div>              
                    </div>             				             
					<div class="row-form clearfix">                        
                        <div class="span6"><strong>Email : </strong><?php echo $query['email']; ?></div>
                        <div class="span6"><strong>Website : </strong><?php echo $query['website']; ?></div>
                    </div>
                    <div class="row-form clearfix">                        
                        <div class="span6"><strong>N Location : </strong><?php echo $query['x_location']; ?></div>
                        <div class="span6"><strong>E Location : </strong><?php echo $query['y_location']; ?></div>
                    </div>                                     
                    </div>
                <div class="block-fluid"> 
                    <div class="row-form clearfix">
                    	<div class="span6"><strong>No. Of Branches In Lebanon : </strong><?php echo count($branches); ?></div>
                        <div class="span6" style="text-align:right"><strong class="label-ar">: عدد الفروع في لبنان</strong>  <?php echo count($branches); ?></div>
                        
                     </div>  
                     <div class="row-form clearfix">
                      <div class="span6"><strong>No. Of Branches Abroad : </strong><?php echo count($branches); ?></div>
                       <div class="span6" style="text-align:right !important"><strong class="label-ar"> : عدد الفروع في الخارج </strong>   <?php echo count($branches); ?> </div>                      
                     </div>   
                    <div class="row-form clearfix">  
                        <div class="span6"><strong>Representative Agents Abroad : </strong><?php //echo $area['label_en']; ?></div>
                        <div class="span6" style="text-align:right"><strong class="label-ar">: مكاتب المثيل في الخارج</strong> <?php //echo $area['label_ar']; ?></div>
                    </div>                                                          
                 </div>
                
                    
                <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1></h1>
                    <h1 class="h1-ar"> ملحق الشركة</h1>
                </div>
                <div class="block-fluid"> 
                    <div class="row-form clearfix">
                    	<div class="span6"><strong>Interviewer : </strong><?=$query['res_person_en']?></div>
                        <div class="span6" style="text-align:right !important"><strong class="label-ar">: مع من تمت المقابلة</strong>
                        <?=$query['res_person_ar']?></div>
                    </div>
                    <?php if(count($salesman)>0){ ?>
                    <div class="row-form clearfix">
                    	<div class="span6"><strong>Sales Man : </strong><?=$salesman['fullname_en']?></div>
                        <div class="span6" style="text-align:right !important"><strong class="label-ar"> : اسم المندوب </strong>
                        <?=$salesman['fullname']?></div>
                    </div>
                    <?php } ?>
                    <div class="row-form clearfix">
                        <div class="span12" style="text-align:right !important"><strong class="label-ar"> : التاريخ </strong>
                        <?=$query['app_refill_date']?></div>
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
                        <?php if($query['is_adv']==1){ 
							if (strpos($query['adv_pic'],'uploads/') !== false) {
								$url=base_url().$query['adv_pic'];
							}
							else{
								$url=base_url().'uploads/'.$query['adv_pic'];
								}
						?>
                        <div class="span5" style="text-align:right"><img src="<?=$url?>" class="adv-img" /></div>
                        <div class="span4" style="text-align:right">صورة الاعلان </div>
                        <?php } ?>
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
		*/?>                 
              <?=$this->load->view('company/_navigation')?>      
              </div>
            </div>            
           <div class="dr"><span></span></div>           
         </div>
             <?=form_close()?>
        
</div>