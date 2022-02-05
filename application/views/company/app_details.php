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
<div class="content">
   <?=$this->load->view("includes/_bread")?>  
    <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'validation'));
          echo form_hidden('_id',$_id);
		 // echo form_hidden('adv_pic',$adv_pic);
		   ?>             
    <div class="workplace">
    
        <div class="page-header">
            <h1><?php echo $subtitle; echo anchor('companies/delete/id/'.$_id.'/cid/'.$id.'/p/app','Delete',array('class'=>'btn btn-large','style'=>'float:right !important; margin-right:10px'));?></h1>
        </div> 
		               
        <div class="row-fluid">
         <div class="span9">       
        <div class="span6">
                 <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1>Address</h1>
                    <h1 style="float:right; margin-right:10px"> عنوان المؤسسة</h1>
                </div>            
				<div class="block-fluid"> 
                     <div class="row-form clearfix">
                        <div class="span8" style="text-align:right !important"><?=$query['governorate_ar'].' ( '.$query['governorate_en'].' )';?></div>
                        <div class="span4" style="text-align:right !important"><font color="#FF0000">*</font>: المحافظة</div>
                     </div>  
                     <div class="row-form clearfix"> 
                       
                       <div class="span8" style="text-align:right !important"><?=$query['district_ar'].' ( '.$query['district_en'].' )';?></div>
                        <div class="span4" style="text-align:right !important"><font color="#FF0000">*</font>:  القضاء</div>
                     </div>   
                    <div class="row-form clearfix">  
                        
                        <div class="span8" style="text-align:right !important"><?=$query['area_ar'].' ( '.$query['area_en'].' )';?></div>
                        <div class="span4" style="text-align:right"><font color="#FF0000">*</font>:  البلدة</div>
                    </div>  
                    <div class="row-form clearfix">    
                        <div class="span8" style="text-align:right"><?=$query['street_ar']?></div>
                        <div class="span4" style="text-align:right"> :   شارع</div>
                    </div>                                                      
                    <div class="row-form clearfix">
                        <div class="span8" style="text-align:right"><?=$query['street_en']?></div>
                        <div class="span4" style="text-align:right" > : Street</div>
                    </div>      
                    <div class="row-form clearfix">  
                        <div class="span8" style="text-align:right"><?=$query['bldg_ar']?></div>
                        <div class="span4" style="text-align:right"> : بناية </div>
                    </div>             
					<div class="row-form clearfix">                       
                        <div class="span8" style="text-align:right"><?=$query['bldg_en']?></div>
                        <div class="span4" style="text-align:right">: Building</div>
                    </div>                   
					<div class="row-form clearfix">                        
                        <div class="span8" style="text-align:right"><?=$query['phone']?></div>
                        <div class="span4" style="text-align:right">: هاتف</div>
                    </div>             
					<div class="row-form clearfix">                              
                        <div class="span8" style="text-align:right"><?=$query['fax']?></div>
                        <div class="span4" style="text-align:right">: فاكس </div>
                    </div>
                    <div class="row-form clearfix">      
                        <div class="span8" style="text-align:right !important"><?=$query['pobox_ar']?></div>
                        <div class="span4" style="text-align:right"> : صندوق بريد </div>
                    </div>
 					<div class="row-form clearfix">
                        <div class="span8" style="text-align:right !important"><?=$query['pobox_en']?></div>
                        <div class="span4" style="text-align:right">: P.O. Box </div>
                     </div>
                     <div class="row-form clearfix">                        
                        <div class="span8" style="text-align:right !important"><?=$query['email']?></div>
                        <div class="span4" style="text-align:right">: Email</div>
                    </div>
 					<div class="row-form clearfix">                         
                        <div class="span8" style="text-align:right !important"><?=$query['website']?></div>   
                        <div class="span4" style="text-align:right">: Website</div>
                    </div> 
                    <?php 
						$x1=explode('°',$query['x_location']);
						$x2=explode("'",@$x1[1]);
						$x3=explode('"',@$x2[1]);
						
						$y1=explode('°',$query['y_location']);
						$y2=explode("'",@$y1[1]);
						$y3=explode('"',@$y2[1]);

					?>
					 <div class="row-form clearfix">                        
                        <div class="span8">
						<?php echo form_input(array('name'=>'x1','value'=>@$x1[0],'style'=>'width:25%')).'° '.form_input(array('name'=>'x2','value'=>@$x2[0],'style'=>'width:25%'))."' ".form_input(array('name'=>'x3','value'=>@$x3[0],'style'=>'width:25%')).'"'; ?>
                        <font color="#FF0000"><?php echo form_error('x_location'); ?></font></div>
                        <div class="span4" style="text-align:right">: N Location</div>
                    </div>
 					<div class="row-form clearfix">                         
                        <div class="span8"><?php echo form_input(array('name'=>'y1','value'=>@$y1[0],'style'=>'width:25%')).'° '.form_input(array('name'=>'y2','value'=>@$y2[0],'style'=>'width:25%'))."' ".form_input(array('name'=>'y3','value'=>@$y3[0],'style'=>'width:25%')).'"'; ?>
                        <font color="#FF0000"><?php echo form_error('y_location'); ?></font></div>    
                        <div class="span4" style="text-align:right">: E Location</div>
                    </div>                                        
                    </div>   
                    <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1>Productions Info :</h1>
                    <h1 style="float:right; margin-right:10px;">معلومات عن الانتاج</h1>
                </div>
                <div class="block-fluid"> 
                    <div class="row-form clearfix">
                        <div class="span12" ><?=$query['productions']?></div>
                     </div>
                </div>         
            </div>
            <div class="span6">
                <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1>General Info</h1>
                    <h1 style="float:right !important; margin-right:10px;">معلومات عامة</h1>
                </div>
                <div class="block-fluid">
                     
                     <div class="row-form clearfix">
                        <div class="span8"style="text-align:right !important"><?=$query['name_ar']?></div>
                        <div class="span4" style="text-align:right !important"><font color="#FF0000">*</font> : اسم المؤسسة</div>
                    </div>                 
					<div class="row-form clearfix">
                         <div class="span8" style="text-align:right !important"><?=$query['name_en']?></div>
                        <div class="span4" style="text-align:right !important"><font color="#FF0000">*</font>: Company Name</div>
                    </div> 
                    <div class="row-form clearfix">     
                        <div class="span8" style="text-align:right !important"><?=$query['owner_name']?></div>
                        <div class="span4" style="text-align:right !important"> : صاحب المؤسسة</div>
                    </div>       
					<div class="row-form clearfix">
                        <div class="span8" style="text-align:right !important"><?=$query['owner_name_en']?></div>
                        <div class="span4" style="text-align:right !important">: Company Owner</div>
                    </div>
                    <div class="row-form clearfix">  
                        <div class="span8" style="text-align:right !important"><?=$query['auth_person_ar']?></div>
                        <div class="span4" style="text-align:right"> : المفوض بالتوقيع </div>

                    </div>
					<div class="row-form clearfix">
                        <div class="span8" style="text-align:right !important"><?=$query['auth_person_en']?></div>
                        <div class="span4" style="text-align:right">: Auth. to sign</div>                
                     </div>  
                     <div class="row-form clearfix">  
                        <div class="span8" style="text-align:right !important"><?=$query['auth_no']?></div>
                      	<div class="span4" style="text-align:right">سجل تجاري </div>
                    </div>
                    <div class="row-form clearfix">                       
                        <div class="span8" style="text-align:right !important"><?=$query['license_source_ar']?></div>
                        <div class="span4" style="text-align:right">مصدر السجل</div>
                    </div>
                    <div class="row-form clearfix">    
                        <div class="span8" style="text-align:right !important"><?=$query['activity_ar']?></div>
                        <div class="span4" style="text-align:right !important"> : النشاط</div>
                    </div>  
					<div class="row-form clearfix">                       
                        <div class="span8" style="text-align:right !important"><?=$query['activity_en']?></div>
                        <div class="span4" style="text-align:right !important"> : Activity</div>
                    </div>
                    
                    <div class="row-form clearfix">
                        <div class="span8" style="text-align:right !important"><?=$query['company_type_ar']?></div>
                        <div class="span4" style="text-align:right">نوع الشركة</div>
                      </div>
                 </div>
                 <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1 style="float:right; margin-right:10px;">الانتساب الى هيئات اقتصادية او مهنية</h1>
                </div>
                <div class="block-fluid"> 
                <div class="row-form clearfix">
                        
                        <div class="span8" style="text-align:right"><?php 
						if($query['ind_association']==1){
							$checked=TRUE;
							}
						else{
							$checked=FALSE;
							}	
						echo form_checkbox('ind_association', 1, $checked);?></div>
                        <div class="span4" style="text-align:right">جمعية الصناعيين اللبنانين</div>    
                    </div>
                	<div class="row-form clearfix">
                        <div class="span8" style="text-align:right !important"><?=$query['iro_ar']?></div>
                        <div class="span4" style="text-align:right">غرفة  التجارة الصناعة والزراعة في </div>
                        </div> 
 					<div class="row-form clearfix">
                        <div class="span8" style="text-align:right !important"><?=$query['igr_ar']?></div>
                        <div class="span4" style="text-align:right">تجمع صناعي </div>
                    </div>                   

                  	<div class="row-form clearfix">
                        
                        <div class="span8" style="text-align:right !important"><?=$query['eas_ar']?></div>
                        <div class="span4" style="text-align:right">اتحادات مهنية اقليمية او دولية</div>   
                    </div>                                                                 
               </div>
                 
        </div>
       </div> 
       <?=$this->load->view('company/_navigation');?>
    </div>
    <?=form_close()?>
</div>