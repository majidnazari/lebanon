<style type="text/css">
.title{
	width:200px !important;
}
.text1{
	margin-left:200px !important;
}
</style>
<div class="content">
	<?=$this->load->view("includes/_bread")?>
            <div class="workplace">
			    <div class="page-header">
                    <h2><?=$query['name_en'].'/&nbsp;'.$query['name_ar']?></h2>
                </div>  
                 
        <div class="row-fluid">
            <div class="span9">
            	<?php if($msg!=''){  ?>
              	<div class="alert alert-block">               
                    <?php echo $msg;?>
                </div> 
                <?php } ?> 
                <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1><?=$subtitle?></h1>
                </div>
                
				 <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'validation'));
                  echo form_hidden('c_id',$id);
                   echo form_hidden('action',@$action);
                   ?>    
                <div class="block-fluid">
					<div class="row-form clearfix">
                        <div class="span1">Year:</div>
                        <div class="span2"><?php 
							$j=date('Y');
							$array_years['']='Select a Year';		
							for($i=2016;$i<=$j;$i++)
							{
								$array_years[$i]=$i;		
							}
							echo form_dropdown('year',$array_years,@$year,'required="required"');
							?></div>
                        <div class="span9">
						<?php echo form_textarea(array('name'=>'notes','value'=>@$notes,'cols'=>36,'rows'=>6)); ?></div>
                    </div>                 
					
                    <div class="footer tar">
                    	<center><input type="submit" name="save" value="Save" class="btn">
                        		<?=anchor('companies/statement/'.$id,'Cancel',array('class'=>'btn'))?>
                        </center>
                    </div>                                                                        
                 </div>
                 <?=form_close()?>
                 <div class="row-fluid">

                    <div class="span12">                    
                        <div class="head clearfix">
                            <div class="isw-grid"></div>
                            
                            <?php //_show_add('companies/production-create/'.$query['id'],'Add New',TRUE)?>                
                        </div>
                        <div class="block-fluid">
                            <table cellpadding="0" cellspacing="0" width="100%" class="table">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" name="checkall"/></th>                                        
                                        <th>Year</th>
                                        <th>Comments</th>
                                        <th>Created By</th>
                                        <th>Created On</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if(count($items)){
										foreach($items as $item){ 
										?>
                                    <tr>
                                        <td><input type="checkbox" name="checkbox"/></td>   
                                        <td><?=$item->year?></td>                                     
                                        <td><?=$item->notes?></td>
                                        <td><?=$item->username?></td>
                                        <td><?=$item->create_time?></td>
                                        <td nowrap="nowrap"><?php echo _show_delete('companies/delete/id/'.$item->id.'/cid/'.$query['id'].'/p/statement',$p_delete);
										echo _show_edit('companies/statement/'.$id.'/'.$item->id,$p_edit);?></td>
                                    </tr>
                                  <?php }
								  
								}
								else{
								?> 
                                    <tr>
                                        <td colspan="6" align="center"><h3 style="margin-left:20px">No Data Found</h3></td>
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

