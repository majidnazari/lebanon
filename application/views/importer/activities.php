<div class="content">
	<?=$this->load->view("includes/_bread")?>
    <div class="workplace">
        <div class="page-header">
            <h2><?=$subtitle?></h2>
        </div> 
        <div class="row-fluid">
            <div class="span12">
			<?php if($msg!=''){ ?>
                            <div class="alert alert-success">               
                                <?php echo $msg;?>
                            </div> 
                            <?php } ?>                   
                   <div class="head clearfix">
                    <div class="isw-grid"></div>
                    <h1><?=$subtitle?></h1>
                     <?=_show_add_pop('#CreateModal','Add New',$p_add);?> 
                </div>  
                <div class="block-fluid table-sorting clearfix">
                <table cellpadding="0" cellspacing="0" width="100%" class="table" id="tSortable">
                                <thead>
                                    <tr>
                                        <th><!--<input type="checkbox" name="checkall"/>-->ID#</th>
                                		<th>English Name</th>
                                		<th>Arabic Name</th>
                                		<th>Last Update Date</th>
                                		<th>Actions</th>                          
                                    </tr>
                                </thead>
                                <tbody>
                                 <?php 
                            		foreach($query as $row) {
                               			if($row->status == 'online') {
                                            $img = '<span class="label label-success">Active</span>';
                                            $a_title = 'Inactive';
											$status_b='offline';
                                        }
                                        else {
                                            $img = '<span class="label">Inactive</span>';
                                            $a_title = 'Active';
											$status_b='online';
                                        }
                                ?>
                                <tr>
                                    <td><!--<input type="checkbox" class="checkbox" value="<?=$row->id?>" name="check[]" />--><?=$row->id?></td>
                                    <td><?=$row->label_en?></td>
                                    <td><?=$row->label_ar?></td>
                                    <td><?=$row->update_time?></td>
                                    <td class="options-width">
                                        <?=_show_edit_pop('#'.$row->id.'Modal',$p_edit_activity);?>
                                        <?=_show_delete('importers/delete/id/'.$row->id.'/p/activity/'.$row->id, $p_delete_activity).$img?>
                                    </td>
                                </tr>
                            <?php if($p_edit_activity){ ?>
                            <div id="<?=$row->id?>Modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h3 id="myModalLabel">Edit Activity</h3>
                                    </div>  
                                    <?php 
									
									echo form_open_multipart('importers/activity_edit/',array('id'=>'validation'.$row->id));
					  				echo form_hidden('id',$row->id);
									?>      
                                    <div class="row-fluid">
                                        <div class="block-fluid">
                                        	<div class="row-form clearfix">
                                            	<div class="span3">Name In Arabic *:</div>
                                            	<div class="span9"><input type="text" name="label_ar" value="<?=$row->label_ar?>" required="required" /></div>
                                        	</div>  
                                            <div class="row-form clearfix">
                                            	<div class="span3">Name In English *:</div>
                                            	<div class="span9"><input type="text" name="label_en" value="<?=$row->label_en?>" required="required" /></div>
                                        	</div>  
                                               
                                            <div class="row-form clearfix">
                                                <div class="span3">Status *:</div>
                                                <div class="span9">
                                                <?php 
                                                    $array_actives=array('online'=>'Active','offline'=>'Inactive');
                                                    echo form_dropdown('status',$array_actives);
                                                ?></div>
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
<?php if($p_add_activity){ ?>
<div id="CreateModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Add New Activity</h3>
    </div>  
    <?php echo form_open_multipart('importers/activity_add',array('id'=>'validation'));?>      
    <div class="row-fluid">
        <div class="block-fluid">
            <div class="row-form clearfix">
                <div class="span3">Name In Arabic *:</div>
                <div class="span9"><input type="text" name="label_ar" required="required" /></div>
            </div>  
            <div class="row-form clearfix">
                <div class="span3">Name In English *:</div>
                <div class="span9"><input type="text" name="label_en" required="required" /></div>
            </div>  
               
            <div class="row-form clearfix">
                <div class="span3">Status *:</div>
                <div class="span9">
                <?php 
                    $array_actives=array('online'=>'Active','offline'=>'Inactive');
                    echo form_dropdown('status',$array_actives);
                ?></div>
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
 