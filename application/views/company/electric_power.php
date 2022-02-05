<style type="text/css">
.title{
	width:200px !important;
}
.text1{
	margin-left:200px !important;
}
</style>

<?php
$a_fuel = array(
	'name'	=> 'fuel',
	'id'	=> 'fuel',
	'value' => $fuel,
);
$a_diesel = array(
	'name'	=> 'diesel',
	'id'	=> 'diesel',
	'value' => $diesel,
);
?>
<div class="content">
	<?=$this->load->view("includes/_bread")?>
    
            <div class="workplace">
			    <div class="page-header">
                    <h2><?=$query['name_en'].'/&nbsp;'.$query['name_ar']?></h2>
                </div>  
                 
        <div class="row-fluid">
            <div class="span9">
            <?php if($msg!=''){ 
				if($msg=='Electric Power Item Updated successfully'){
					echo '<div class="alert alert-success">'.$msg.'
                </div> ';
				}
				else{
			?>
              	<div class="alert alert-block">               
                    <?php echo $msg;?>
                </div> 
                <?php }
				} ?> 
                <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1><?=$subtitle?></h1>
                </div>
                
				 <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'validation'));
                  echo form_hidden('c_id',$c_id);
                   echo form_hidden('action',$action);
                   $unit_array=array('Ton'=>'Ton','Litre'=>'Litre');
                   ?>    
                <div class="block-fluid">
					<div class="row-form clearfix">
                        <div class="span4">Fuel / Ton Or Litre (فيول / طن او ليتر) :</div>
                        <div class="span5"><?php echo form_input($a_fuel); ?></div>
                        <div class="span3"><?php echo form_dropdown('fuel_unit',$unit_array,$fuel_unit); ?></div>
                    </div>                 
					<div class="row-form clearfix">
                        <div class="span4">Diesel / Ton Or Litre (مازوت / طن او ليتر)</div>
                        <div class="span5"><?php echo form_input($a_diesel); ?></div>
                        <div class="span3"><?php echo form_dropdown('diesel_unit',$unit_array,$diesel_unit); ?></div>
                    </div> 
                    <div class="footer tar">
                    	<center><input type="submit" name="save" value="Save" class="btn">
                        		<?=anchor('companies/power/'.$query['id'],'Cancel',array('class'=>'btn'))?>
                        </center>
                    </div>                                                                        
                 </div>
                 <?=form_close()?>
                 <div class="row-fluid">

                    <div class="span12">                    
                        <div class="head clearfix">
                            <div class="isw-grid"></div>
                            <h1>Electric Power &nbsp;&nbsp; 
                            	<div style="float:right !important; margin-right:10px;">(استعمال الطاقة )</div>
                            </h1> 
                            <?php //_show_add('companies/production-create/'.$query['id'],'Add New',TRUE)?>                
                        </div>
                        <div class="block-fluid">
                            <table cellpadding="0" cellspacing="0" width="100%" class="table">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" name="checkall"/></th>                                        
                                        <th>Fuel</th>
                                        <th>Diesel</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if(count($items)){
										foreach($items as $item){ ?>
                                    <tr>
                                        <td><input type="checkbox" name="checkbox"/></td>   
                                        <td><?=@number_format($item->fuel)?></td>
                                        <td><?=@number_format($item->diesel)?></td>
                                        <td nowrap="nowrap"><?php echo _show_delete('companies/delete/id/'.$item->id.'/cid/'.$query['id'].'/p/power',$p_delete);
										//echo _show_edit('companies/power/'.$query['id'].'/'.$item->id,$p_delete);?></td>
                                    </tr>
                                  <?php }
								  
								}
								else{
								?> 
                                    <tr>
                                        <td colspan="4" align="center"><h3 style="margin-left:20px">No Electric Power Found</h3></td>
                                    </tr> 
                                   <?php } ?>                                                                
                                </tbody>
                            </table>
                        </div>
                    </div>                                
                </div>
             </div>
              <?=$this->load->view('company/_navigation')?>   
        </div>
        
                
                
                            
           <div class="dr"><span></span></div>           
         </div>
        </div>

