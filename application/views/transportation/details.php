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
                        <div class="span6" style="text-align:right !important"><?php echo $query['name_ar']; ?> <strong class="label-ar">: اسم الشركة </strong></div>
                        
                    </div>                 
					<div class="row-form clearfix">
                    	<div class="span6"><strong>Owner / Owners of The Company: </strong><?php echo $query['owner_en']; ?></div>                       
                        <div class="span6" style="text-align:right"><?php echo $query['owner_ar']; ?>  <strong class="label-ar">صاحب / أصحاب الشركة </strong></div>
                    </div>
                    <div class="row-form clearfix">
                    	<div class="span6"><strong>C.R : </strong><?php echo $query['trade_license'].' - '.@$license['label_en']; ?></div>                       
                        <div class="span6" style="text-align:right;">
							 <strong class="label-ar"> : س . ت    </strong>
							 <div class="label-ar"> - <?=$query['trade_license']; ?></div>
                           	<div class="label-ar"><?=@$license['label_ar']?></div>
                       </div>
                    </div>   
                    <div class="row-form clearfix">
                    	<div class="span6"><strong>Date Founded : </strong><?php echo $query['est_date']; ?></div>                       
                        <div class="span6" style="text-align:right"><?php echo $query['est_date']; ?>  
                        <strong class="label-ar">: تاريخ التأسيس </strong></div>
                    </div>   
                    
                                                                          
                 </div>
                 <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1>Membership in Organization : </h1>
                    <h1  class="h1-ar"> :عضويتها في هيئات </h1>
                </div>
                <div class="block-fluid"> 
                
                <div class="row-form clearfix">
                	<div class="span6"><?php 
					if($query['maritime']==1)
					{
						$checkedMaritime=TRUE;
						}
					else{
						$checkedMaritime=FALSE;
						}	
					if($query['airline']==1)
					{
						$checkedAirline=TRUE;
						}
					else{
						$checkedAirline=FALSE;
						}
					if($query['member_overseas']==1)
					{
						$checkedoverseas=TRUE;
						}
					else{
						$checkedoverseas=FALSE;
						}
					if($query['member_local']==1)
					{
						$checkedlocal=TRUE;
						}
					else{
						$checkedlocal=FALSE;
						}			
							
					echo '<div class="span5">'.form_checkbox(array('name'=>'is_adv','value'=> 1, 'checked'=>$checkedMaritime,'readonly'=>'readonly','disabled'=>'disabled')).'Maritime<br>'.form_checkbox(array('name'=>'is_adv','value'=> 1, 'checked'=>$checkedlocal,'readonly'=>'readonly','disabled'=>'disabled')).'Locally<br>'.$query['member_local_en'].'</div>
					<div class="span5">'.form_checkbox(array('name'=>'is_adv','value'=> 1, 'checked'=>$checkedAirline,'readonly'=>'readonly','disabled'=>'disabled')).'Airline<br>'.form_checkbox(array('name'=>'is_adv','value'=> 1, 'checked'=>$checkedoverseas,'readonly'=>'readonly','disabled'=>'disabled')).'Overseas<br>'.$query['member_overseas_en'].'</div>';?></div>
                    <div class="span6 label-ar">
                    	<?php 
						echo '<div class="span5 label-ar"> بحرية  '.form_checkbox(array('name'=>'is_adv','value'=> 1, 'checked'=>$checkedMaritime,'readonly'=>'readonly','disabled'=>'disabled')).'<br> في الخارج '.form_checkbox(array('name'=>'is_adv','value'=> 1, 'checked'=>$checkedoverseas,'readonly'=>'readonly','disabled'=>'disabled')).'<br>'.$query['member_overseas_ar'].'</div>
						<div class="span5 label-ar"> جوية '.form_checkbox(array('name'=>'is_adv','value'=> 1, 'checked'=>$checkedAirline,'readonly'=>'readonly','disabled'=>'disabled')).'<br>محليا'.form_checkbox(array('name'=>'is_adv','value'=> 1, 'checked'=>$checkedlocal,'readonly'=>'readonly','disabled'=>'disabled')).'<br>'.$query['member_local_ar'].'</div>';?>
                    </div>	
                        
                 </div>
                  </div>   
                  <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1>Services : </h1>
                    <h1 class="h1-ar">:  خدمات النقل</h1>
                </div>
                <div class="block-fluid"> 
                <div class="row-form clearfix">
                <?php 
				if($query['service_landline']==1)
					{
						$s_landline=TRUE;
						}
					else{
						$s_landline=FALSE;
						}	
					if($query['service_maritime']==1)
					{
						$s_maritime=TRUE;
						}
					else{
						$s_maritime=FALSE;
						}
					if($query['service_airline']==1)
					{
						$s_airline=TRUE;
						}
					else{
						$s_airline=FALSE;
						}	
				
				?>
                	<div class="span6">
                    	<div class="span4"><?=form_checkbox(array('name'=>'is_adv', 'checked'=>$s_landline,'readonly'=>'readonly','disabled'=>'disabled'))?>Landline</div>
                        <div class="span4"><?=form_checkbox(array('name'=>'is_adv', 'checked'=>$s_maritime,'readonly'=>'readonly','disabled'=>'disabled'))?>Maritime</div>
                        <div class="span4"><?=form_checkbox(array('name'=>'is_adv', 'checked'=>$s_airline,'readonly'=>'readonly','disabled'=>'disabled'))?>Airline</div>
                    </div>
                    <div class="span6">
                    	<div class="span3 label-ar">برية  <?=form_checkbox(array('name'=>'is_adv', 'checked'=>$s_landline,'readonly'=>'readonly','disabled'=>'disabled'))?></div>
                        <div class="span3 label-ar">بحرية <?=form_checkbox(array('name'=>'is_adv', 'checked'=>$s_maritime,'readonly'=>'readonly','disabled'=>'disabled'))?></div>
                        <div class="span3 label-ar">جوية <?=form_checkbox(array('name'=>'is_adv', 'checked'=>$s_airline,'readonly'=>'readonly','disabled'=>'disabled'))?></div>
                    </div>
                </div> 
                </div> 
                <div class="head clearfix">
                    <h1>Comuting Transportation : </h1>
                    <h1 class="h1-ar"> : الخدمات البرية </h1>
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
							
						echo '<li style="display:inline-block; width:100%; margin-top:5px">'.form_checkbox('activities[]', $activity->id, $checked,'readonly="readonly" style="float:left; margin:5px" ');?><?=$activity->label_ar.' ('.$activity->label_en.')'?></li>
                         <?php } ?> 
                        </ul> 
                        
                    </div>
                    
               	</div>  
                <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1>Foreign Companies Represented in Lebanon : </h1>
                    <h1 class="h1-ar">: الشركات الاجنبية التي تمثلها في لبنان </h1>
                </div>
                   <div class="block-fluid"> 
                    <?php foreach($represented as $item){ ?>
                      <div class="row-form clearfix">
                    	<div class="span6"><strong>Company Name : </strong><?php echo $item->name_en; ?></div>
                        <div class="span6" style="text-align:right">
                        	<strong class="label-ar">: اسم الشركة </strong>  
							<?php echo $item->name_ar; ?>
                        </div>
                      </div>  
                     <?php } ?>  
                     
                     
                </div>  
                <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1>Ports Served By The Vessels : </h1>
                    <h1 class="h1-ar"> : المرافىء التي تقصدها البواخر</h1>
                </div>
                   <div class="block-fluid"> 
                    <?php foreach($ports as $port){ ?>
                      <div class="row-form clearfix">
                    	<div class="span6"><?php echo $port->name_en; ?></div>
                        <div class="span6" style="text-align:right"><?php echo $port->name_ar; ?></div>
                       </div> 
                     <?php } ?>  
                     
                     
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
                        <div class="span6" style="text-align:right"><strong class="label-ar">: هاتف</strong><?=$query['phone']?></div>
                    <div class="row-form clearfix">  
                        <div class="span6"><strong>whatsapp : </strong><?=$query['whatsapp']?></div>                  
                        <div class="span6" style="text-align:right"><strong class="label-ar">: واتساپ</strong><?=$query['whatsapp']?></div>                   </div>             
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
                    <iframe scrolling="no" width="100%" height="350" frameborder="0" marginheight="0" marginwidth="0" src="http://www.lebanon-industry.com/sites/map?name=<?=$query['name_ar']?>&x=<?=$query['x_location'];?>&y=<?=$query['y_location'];?>"></iframe>

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
        <?=$this->load->view('transportation/_navigation')?>
        
        
        
            
        
        
    </div>
    <?=form_close()?>
</div>