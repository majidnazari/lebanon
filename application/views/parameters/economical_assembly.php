<div class="content">
	<?=$this->load->view("includes/_bread")?>
    <div class="workplace">
        <div class="page-header">
            <h1><?=$subtitle?></h1>
        </div> 
        <div class="row-fluid">
            <div class="span12">
            <?php if($msg!=''){ ?>
              	<div class="alert alert-success">               
                    <?php echo $msg;?>
                </div> 
                <?php } ?>    
                <?php // echo form_open('parameters/delete_checked/cat/position',array('id'=>'form_id','name'=>'form1'));
					//	echo form_hidden('p','position');
				?>                                
                <div class="head clearfix">
                    <div class="isw-grid"></div>
                    <h1><?=$subtitle?></h1>
                     <?php //echo _show_delete_checked('#',$p_delete_industrialroom)?>
                     <?=_show_add_pop('#CreateModal','Add New',$p_add_economicalassembly)?> 
                                                       
                </div>  
                <div class="block-fluid table-sorting clearfix">
                <table cellpadding="0" cellspacing="0" width="100%" class="table" id="tSortable">
                                <thead>
                                    <tr>
                                        
                                        <th width="20%">English Description</th>
                                        <th width="20%">Arabic Description</th>
                                        <th width="20%">Date</th>
                                        <th width="20%">Created By</th>
                                        <th width="20%">Actions</th>                                    
                                    </tr>
                                </thead>
                                <tbody>
                                 <?php foreach($query as $row){
									 $user=$this->Administrator->GetUserById($row->user_id);
									 if(count($user)>0)
									 {
											$createdBy=$user['fullname'].' ('.$user['username'].' )'; 
										}
									else{
											$createdBy='N/A';
										}	
									 ?>
                                <tr>
                                    <td><?=$row->label_en?></td>
                                    <td align="right" style="text-align:right !important">
                                    <?=$row->label_ar?></td>
             
                                    <td><?php echo 'Create Date : '.$row->create_time."<br />Last Update : ".$row->update_time?></td>
                                    <td><?=$createdBy?></td>
                                    <td><?php 
                                            echo _show_delete('parameters/delete/id/'.$row->id.'/p/economicalassembly/',$p_delete_economicalassembly);
                                            echo _show_edit_pop('#'.$row->id.'Modal',$p_edit_economicalassembly);
                                    ?>                                        
                                    </td>                                    
                            </tr>
                            <?php if($p_edit_economicalassembly){ ?>
                            <div id="<?=$row->id?>Modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h3 id="myModalLabel">Edit Economical Assembly</h3>
                                    </div>  
                                    <?php 
									
									echo form_open_multipart('parameters/edit_economical_assembly',array('id'=>'validation'.$row->id));
					  				echo form_hidden('id',$row->id);
									?>      
                                    <div class="row-fluid">
                                        <div class="block-fluid">
                                            <div class="row-form clearfix">
                                                <div class="span3">Title In english *:</div>
                                                <div class="span9"><input type="text" name="label_en" value="<?=$row->label_en?>" required="required" /></div>
                                                </div>
                                                <div class="row-form clearfix">
                                                <div class="span3">Title In arabic *:</div>
                                                <div class="span9"><input type="text" name="label_ar" value="<?=$row->label_ar?>" required="required" /></div>
                                            </div>            
                                          </div>                
                                        <div class="dr"><span></span></div>
                                    </div>                    
                                    <div class="modal-footer">
                                       <!-- <input type="submit" name="save" value="Save" class="btn">-->
                                        <button class="btn" name="save" onclick="return f_submit(validation);">Save</button>
                                        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>            
                                    </div>
                                    <?php echo form_close();
									
									?>
        						</div>
                                  <?php }
								  } ?>  
                                </tbody>
                            </table>
                    
                </div>
                <?php echo form_close();?>
            </div>                                
        </div>            
        <div class="dr"><span></span></div>            
    </div>
</div>
<?php if($p_add_economicalassembly){ ?>
<div id="CreateModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Add New Economical Assembly</h3>
    </div>  
    <?php echo form_open_multipart('parameters/create_economical_assembly',array('id'=>'validation'));?>      
    <div class="row-fluid">
        <div class="block-fluid">
            <div class="row-form clearfix">
                <div class="span3">Title in english *:</div>
                <div class="span9"><input type="text" name="label_en" required="required" /></div>
            </div>            
            <div class="row-form clearfix">
                <div class="span3">Title in arabic *:</div>
                <div class="span9"><input type="text" name="label_ar" required="required" /></div>
            </div>            
        </div>                
        <div class="dr"><span></span></div>
    </div>                    
    <div class="modal-footer">
        <input type="submit" name="save" value="Save" class="btn">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>            
    </div>
    <?=form_close()?>
</div>
<?php } ?>