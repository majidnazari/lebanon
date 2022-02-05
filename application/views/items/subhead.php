<?php 
$array_code=array('name'=>'code','id'=>'code','value'=>$code);
$array_description=array('name'=>'description','id'=>'description','value'=>$description);

?>
<div class="content">
	<?=$this->load->view("includes/_bread")?>
    <div class="workplace">
        <div class="page-header">
            <h1><?=$subtitle?></h1>
        </div> 
        <div class="row-fluid">
      
        <?php if($msg!=''){ ?>
           <div class="span12">
              	<div class="alert alert-success">               
                    <?php echo $msg;?>
                </div>  </div>
                <?php } ?>  
               
            <div class="span12">
                 <div class="head clearfix">
                    <div class="isw-zoom"></div>
                    <h1>Search</h1>
                </div>
                <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'validation','method'=>'get'));
					   ?> 
                <div class="block-fluid">                        

                    <div class="row-form clearfix">
                    	<div class="span3">Code <br /><?php echo form_input($array_code);?></div>
                        <div class="span5">Subhead<br /><?php echo form_input($array_description);?></div>
                        <div class="span3"><br /><input type="submit" name="search" value="Search" class="btn">
                        <input type="submit" name="clear" value="Clear" class="btn">
                        </div>
                    </div>                            
                </div>
				<?php echo form_close() ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
              
                                           
                <div class="head clearfix">
                    <div class="isw-grid"></div>
                    <h1><?=$subtitle?></h1>
                     <?php //echo _show_delete_checked('#',$p_delete_position)?>
                     <?=_show_add_pop('#CreateModal','Add New',$p_add_sector)?> 
                                                       
                </div>  
                <div class="block-fluid table-sorting clearfix">
                <table cellpadding="0" cellspacing="0" width="100%" class="table">
                                <thead>
                                    <tr>
                                    	<th width="10%">Code</th>
                                        <th width="25%">English Description</th>
                                        <th width="25%">Arabic Description</th>
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
                                    <td><?=$row->code?></td>
                                    <td><?=$row->title_en?></td>
                                    <td align="right" style="text-align:right !important">
                                    <?=$row->title_ar?></td>
             
                                    <td><?php echo $createdBy.'<br>Create Date : '.$row->create_time."<br />Last Update : ".$row->update_time?></td>

                                    <td><?php 
                                            echo _show_delete('items/delete/id/'.$row->id.'/p/subhead/',$p_delete_subhead);
                                            echo _show_edit_pop('#'.$row->id.'Modal',$p_edit_subhead);
											if($row->status=='online')
												echo '<span class="label label-success">Online</span>';
												else
												echo '<span class="label">Offline</span>';
                                    ?>                                        
                                    </td>                                    
                            </tr>
                            <?php if($p_edit_subhead){ ?>
                            <div id="<?=$row->id?>Modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h3 id="myModalLabel">Edit Subhead</h3>
                                    </div>  
                                    <?php 
									
									echo form_open_multipart('items/edit_sector',array('id'=>'validation'.$row->id));
					  				echo form_hidden('id',$row->id);
									?>      
                                    <div class="row-fluid">
                                        <div class="block-fluid">
                                        <div class="row-form clearfix">
                                                <div class="span3">Code *:</div>
                                                <div class="span9"><input type="text" name="code" value="<?=$row->code?>" required="required" /></div>
                                            </div>   
                                            <div class="row-form clearfix">
                                                <div class="span3">Title In english *:</div>
                                                <div class="span9"><input type="text" name="title_en" value="<?=$row->title_en?>" required="required" /></div>
                                                </div>
                                                <div class="row-form clearfix">
                                                <div class="span3">Title In arabic *:</div>
                                                <div class="span9"><input type="text" name="title_ar" value="<?=$row->title_ar?>" required="required" /></div>
                                            </div> 
                                            <div class="row-form clearfix">
                                            <div class="span3">Status : </div>
                                            <div class="span9"><?php $array_status=array('online'=>'Online','offline'=>'Offline');
                                                      echo form_dropdown('status',$array_status,$row->status);
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
                                <tfoot>
                        	<tr>
                                <td colspan="6">Total : <?=$total_row?><div class="dataTables_paginate paging_full_numbers"><?=$links?></div></td></tr>
                        </tfoot>
                            </table>
                    
                </div>
                <?php echo form_close();?>
            </div>                                
        </div>            
        <div class="dr"><span></span></div>            
    </div>
</div>
<?php if($p_add_subhead){ ?>
<div id="CreateModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Add New Subhead</h3>
    </div>  
    <?php echo form_open_multipart('items/create_subhead',array('id'=>'validation'));?>      
    <div class="row-fluid">
        <div class="block-fluid">
            <div class="row-form clearfix">
                <div class="span3">Code *:</div>
                <div class="span9"><input type="text" name="code" required="required" /></div>
            </div>   
            <div class="row-form clearfix">
                <div class="span3">Title in english *:</div>
                <div class="span9"><input type="text" name="title_en" required="required" /></div>
            </div>            
            <div class="row-form clearfix">
                <div class="span3">Title in arabic *:</div>
                <div class="span9"><input type="text" name="title_ar" required="required" /></div>
            </div> 
            <div class="row-form clearfix">
                <div class="span3">Status : </div>
                <div class="span9"><?php $array_status=array('online'=>'Online','offline'=>'Offline');
                          echo form_dropdown('status',$array_status,$row->status);
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