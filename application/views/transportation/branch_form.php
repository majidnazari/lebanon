<?php
/********************General Info**********************/
$array_name_ar=array('id'=>'name_ar','name'=>'name_ar','value'=>@$row['name_ar']);
$array_name_en=array('id'=>'name_en','name'=>'name_en','value'=>@$row['name_en']);


/*********************Address*************************/
$array_phone=array('id'=>'phone','name'=>'phone','value'=>@$row['phone']);

$array_email=array('id'=>'email','name'=>'email','value'=>@$row['email']);
$array_website=array('id'=>'website','name'=>'website','value'=>@$row['website']);

?>


<style type="text/css">
select{
	direction:rtl !important;
	}
.label-ar{
	text-align:right !important;
	font-size:15px;
	font-weight:bold;
}	
</style>

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
                    <h1></h1>
                    <h1 style="float:right; margin-right:10px">الوكلات الاجنبية التي تمثلها الشركة</h1>
                </div>            
				<div class="block-fluid">
                    <div class="row-form clearfix">    
                    	
                        <div class="span4"><?php echo form_input($array_name_en); ?>
                        <font color="#FF0000"><?php echo form_error('name_en'); ?></font></div>
                        <div class="span2">: Name  </div>
                        <div class="span4" style="text-align:right"><?php echo form_input($array_name_ar); ?>
                        <font color="#FF0000"><?php echo form_error('name_ar'); ?></font></div>
                        <div class="span2 label-ar"> :   الاسم</div>

                    </div>
                    <div class="row-form clearfix">
                    
                        

                        <?php 
							$country_array=array(0=>'اختر البلد');
							foreach($countries as $country){
								
								$country_array[$country->id]=$country->label_en.' ( '.$country->label_ar.' )';
								}
						?>
                        <div class="span4"><?php echo form_dropdown('country_id',$country_array,@$country_id); ?>
                        <font color="#FF0000"><?php echo form_error('country_id'); ?></font></div>
                        <div class="span2 label-ar"> البلد</div>
                              
                        <div class="span4"><?php echo form_input($array_phone); ?>
                        <font color="#FF0000"><?php echo form_error('phone'); ?></font></div>
                        <div class="span2 label-ar">: هاتف</div>
                    </div>             
					
                    
					<div class="row-form clearfix">    
                        <div class="span4"><?php echo form_input($array_email); ?>
                        <font color="#FF0000"><?php echo form_error('email'); ?></font></div>
                        <div class="span2 label-ar">: البريد الالكتروني </div>
                                   
                        <div class="span4"><?php echo form_input($array_website); ?>
                        <font color="#FF0000"><?php echo form_error('website'); ?></font></div>    
                        <div class="span2 label-ar">: الموقع الالكتروني</div>
                    </div> 
					  
                    <div class="row-form clearfix">   
                    	<center><input type="submit" name="save" value="Save" class="btn btn-large"/>
                		&nbsp;<?=anchor('transportations/details/'.$id,'Cancel',array('class'=>'btn btn-large','style'=>''))?></center>      
                    </div>                                       
                    </div>            
                 <div class="block-fluid">
                            <table cellpadding="0" cellspacing="0" width="100%" class="table">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" name="checkall"/></th>                                        
                                        <th>Name</th>
                                        <th>Country</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Website</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if(count($branches)){
										foreach($branches as $branch){ 
										$country=$this->Address->GetCountryById($branch->country_id);
										?>
                                    <tr>
                                        <td><input type="checkbox" name="checkbox"/></td>   
                                        <td><?=$branch->name_ar.' : '.$branch->name_en?></td>  
                                        <td><?=@$country['label_ar']?></td>
                                        <td><?=$branch->phone?></td>  
                                        <td><?=$branch->email?></td>  
                                        <td><?=$branch->website?></td>  
                                        <td nowrap="nowrap">
										<?php echo _show_delete('transportations/delete/id/'.$branch->id.'/cid/'.$query['id'].'/p/branches',$p_delete_branch);
										echo _show_edit('transportations/branch-edit/'.$query['id'].'/'.$branch->id,$p_edit_branch);?></td>
                                    </tr>
                                  <?php }
								  
								}
								else{
								?> 
                                    <tr>
                                        <td colspan="7" align="center"><h3>No Branch Found</h3></td>
                                    </tr> 
                                   <?php } ?>                                                                
                                </tbody>
                            </table>
                        </div> 
            </div>
            <?=$this->load->view('transportation/_navigation')?>
    </div>
    <?=form_close()?>
</div>