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
	padding:5px !important;
}

.adv-img{
	height:200px;
}
.label-ar{
	float:right !important;
	margin-left:10px !important;
	text-align:right !important;
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
                    <h1 style="float:right !important; margin-right:10px;">معلومات عامة</h1>
                </div>
                <div class="block-fluid">
                     <div class="row-form clearfix">
                     	<div class="span6"><strong>Company Name : </strong><?php echo $query['name_en']; ?></div>
                        <div class="span6" style="text-align:right !important"><strong> اسم الشركة : </strong><?php echo $query['name_ar']; ?> </div>
                        
                    </div>                 
					<div class="row-form clearfix">
                    	<div class="span6"><strong>Owner / Owners of The Company: </strong><?php echo $query['owner_en']; ?></div>                       
                        <div class="span6" style="text-align:right"><strong class="label-ar"> : صاحب / أصحاب الشركة </strong><?php echo $query['owner_ar']; ?>  </div>
                    </div>   
                    
                                                                          
                 </div>
                 <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1>Activity : </h1>
                    <h1 style="float:right; margin-right:10px;"> : نوع النشاط الرئيسي </h1>
                </div>
                <div class="block-fluid"> 
                
                <div class="row-form clearfix">
                	<ul style=" float:right; direction:rtl; width:100%">
                        <?php 
						 if($query['activity_other_ar']!='' or $query['activity_other_en']!=''){
						 echo '<li style="margin-top:5px; margin-right:30px">غير ذلك : '.$query['activity_other_ar'].' <span style="float:left; text-align:left; font-size:13px !important">Other : '.$query['activity_other_en'].'</span></li>';
						 }
						 ?> 
                        </ul> 
                        
                    </div>
                  </div>
                  <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1>Sectors : </h1>
                    <h1 style="float:right; margin-right:10px;">القطاعات </h1>
                </div>
                  <div class="block-fluid"> 
                
                <div class="row-form clearfix">
                	<ul style=" float:right; direction:rtl; width:100%">
                        <?php foreach($activities as $activity){
						
						echo '<li style="margin-top:5px; margin-right:30px">'.$activity->label_ar.' <span style="float:left; text-align:left; font-size:13px !important">'.$activity->label_en.'</span></li>';
                         } 
						 
						 ?> 
                        </ul> 
                        
                    </div>
                  </div>            
                 <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1>Address</h1>
                    <h1 style="float:right; margin-right:10px"> عنوان المؤسسة</h1>
                </div>            
				<div class="block-fluid"> 
                    <div class="row-form clearfix">
                    	<div class="span6"><strong>Mohafaza : </strong><?php echo @$governorates['label_en']; ?></div>
                        <div class="span6" style="text-align:right"><strong class="label-ar">: المحافظة</strong>  <?php echo @$governorates['label_ar']; ?></div>
                        
                     </div>  
                     <div class="row-form clearfix">
                      <div class="span6"><strong>Kazaa : </strong><?php echo @$districts['label_en']; ?></div>
                       <div class="span6" style="text-align:right !important"><strong class="label-ar">:   القضاء</strong>   <?php echo $districts['label_ar']; ?> </div>                      
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
                        <div class="span6" style="text-align:right; direction:rtl"><strong class="label-ar"> : صندوق بريد </strong><?=$query['pobox_ar']?></div>              
                    </div> 
                    <div class="row-form clearfix">  
                        <div class="span6"><strong>Address 2 : </strong><?=$query['address2_en']?></div>                  
                        <div class="span6" style="text-align:right"><strong class="label-ar"> : العنوان ٢  </strong><?=$query['address2_ar']?></div>              
                    </div>             				             
					<div class="row-form clearfix">                        
                        <div class="span6"><strong>Email : </strong><?php echo $query['email']; ?></div>
                        <div class="span6"><strong>Website : </strong><?php echo $query['website']; ?></div>
                    </div>
                    <div class="row-form clearfix">                        
                        <div class="span6"><strong>N Location : </strong><?php echo $query['x_location']; ?></div>
                        <div class="span6"><strong>E Location : </strong><?php echo $query['y_location']; ?></div>
                        <iframe scrolling="no" width="100%" height="350" frameborder="0" marginheight="0" marginwidth="0" src="http://www.lebanon-industry.com/sites/map?name=<?=$query['name_ar']?>&x=<?=$query['x_location'];?>&y=<?=$query['y_location'];?>"></iframe>

                    </div>                                     
                    </div>
                <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1>Foreign Companies Represented in Lebanon</h1>
                    <h1 style="float:right; margin-right:10px">: الشركات الاجنبية التي تمثلها في لبنان </h1>
                </div>
                <div class="block-fluid"> 
                     
                <div class="row-form clearfix"> 
                <?php if(count($fcompanies)>0){?>
                	    <table  cellpadding="0" cellspacing="0" width="100%" class="table">
                        	<thead>
                                <tr>                                    
                                   <th><strong>Company Name</strong></th>
                                    <th><strong>Address</strong></th>
                                    <th><strong>Items Imported</strong></th>
                                    <th><strong>Trade Mark</strong></th>   
                                    <th>Actions</th>                                
                                </tr>
                               </thead>
                            </tr>
                            <tbody>
                        	 <?php foreach($fcompanies as $fcompany){ ?>	  
                        	<tr>
                                <td><?php echo $fcompany->name_ar?></td>
                                <td><?php echo $fcompany->address_ar ?></td>
                                <td><?php echo $fcompany->items_ar ?></td>
                                <td><?php echo $fcompany->trade_mark_ar ?></td>
                                <td><?php echo _show_delete('importers/delete/id/'.$fcompany->id.'/p/foreign/imp/'.$id,$p_foreign_companies);
										echo _show_edit('importers/update/'.$fcompany->id.'/'.$id,$p_foreign_companies);
										
										?></td>
                            </tr>
                            <?php }?>
                            </tbody>
                        </table>           
                    <?php } ?>
                              
                         
                 </div> 
                  
                  
                </div>    
                <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1></h1>
                    <h1 style="float:right; margin-right:10px"> ملحق الشركة</h1>
                </div>
                <div class="block-fluid"> 
                    <div class="row-form clearfix">
                    	<div class="span6"><strong>Interviewer : </strong><?=$query['res_person_en']?></div>
                        <div class="span6" style="text-align:right !important"><strong class="label-ar">: مع من تمت المقابلة</strong>
                        <?=$query['res_person_ar']?></div>
                    </div>
                     <div class="row-form clearfix">
                    	<div class="span6"><strong>Position : </strong><?=@$position['label_en']?></div>
                        <div class="span6" style="text-align:right !important"><strong class="label-ar">صفته في المؤسسة</strong>
                        <?=@$position['label_ar']?></div>
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
						if($query['copy_reservation']==1){
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
                    <h1 style="float:right; margin-right:10px;">ملاحظات شخصية</h1>
                </div>
                <div class="block-fluid"> 
                    <div class="row-form clearfix">
                        <div class="span12" ><?php echo $query['personal_notes']; ?></div>
                     </div>
                </div> 
        </div>
        <?=$this->load->view('importer/_navigation')?>
    </div>
    <?=form_close()?>
</div>