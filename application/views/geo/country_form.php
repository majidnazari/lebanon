<?php
$labelen = array(
	'name'	=> 'label_en',
	'id'	=> 'label_en',
	'class'	=> 'validate[required]',	
	'value' => $label_en,
);
$labelar = array(
	'name'	=> 'label_ar',
	'id'	=> 'label_ar',
	'class'	=> 'validate[required]',	
	'value' => $label_ar,
);
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
					  echo form_hidden('country_id',$country_id);
					   ?> 
                <div class="block-fluid">                        

                    <div class="row-form clearfix">
                        <div class="span3">Country Title in english:</div>
                        <div class="span4"><?php echo form_input($labelen); ?>
                        <font color="#FF0000"><?php echo form_error('label_en'); ?></font>
                        </div>
                    </div> 
                    <div class="row-form clearfix">
                        <div class="span3">Country Title in arabic:</div>
                        <div class="span4"><?php echo form_input($labelar); ?>
                        <font color="#FF0000"><?php echo form_error('label_ar'); ?></font>
                        </div>
                    </div>                                         
                    <div class="row-form clearfix">
                        <div class="span3">Status:</div>
                        <div class="span4"><?php $array_status=array('online'=>'Online','offline'=>'Offline');
												echo form_dropdown('status',$array_status,$status);
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