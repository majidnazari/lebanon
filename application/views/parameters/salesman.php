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

                   
				echo anchor('parameters/export_salesman/en','<h6 style="float:right !important; color:#FFF !important"> - English </h6>');
			   echo anchor('parameters/export_salesman/ar','<h6 style="float:right !important; color:#FFF !important">Export To Excel</h6>');
                                        
				?>                                
                <div class="head clearfix">
                    <div class="isw-grid"></div>
                    <h1><?=$subtitle?></h1>
                     <?php //echo _show_delete_checked('#',$p_delete_salesman)?>
                     <?=_show_add_pop('#CreateModal','Add New',$p_add_salesman)?> 
                                                       
                </div>  
                <div class="block-fluid table-sorting clearfix">
                <table cellpadding="0" cellspacing="0" width="100%" class="table" id="tSortable">
                                <thead>
                                    <tr>
                                        
                                        <th width="20%">Fullname</th>
                                        <th width="20%">Contact</th>
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
                                    <td><?=$row->fullname.'<br>'.$row->fullname_en?></td>
                                    <td align="right">
                                    <?=$row->phone.'<br>'.$row->address?></td>
             
                                    <td><?php echo 'Create Date : '.$row->create_time."<br />Last Update : ".$row->update_time?></td>
                                    <td><?=$createdBy?></td>
                                    <td><?php 
                                            echo _show_delete('parameters/delete/id/'.$row->id.'/p/salesman/',$p_delete_salesman);
                                            echo _show_edit_pop('#'.$row->id.'Modal',$p_edit_salesman);
                                    ?>                                        
                                    </td>                                    
                            </tr>
                            <?php if($p_edit_salesman){ ?>
                            <div id="<?=$row->id?>Modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h3 id="myModalLabel">Edit Salesman</h3>
                                    </div>  
                                    <?php 
									
									echo form_open_multipart('parameters/edit_salesman',array('id'=>'validation'.$row->id));
					  				echo form_hidden('id',$row->id);
									?>      
                                    <div class="row-fluid">
                                        <div class="block-fluid">
                                            <div class="row-form clearfix">
                                                <div class="span3">Fullname In english *:</div>
                                                <div class="span9"><input type="text" name="fullname_en" value="<?=$row->fullname_en?>" required="required" /></div>
                                                </div>
                                                <div class="row-form clearfix">
                                                <div class="span3">Fullname In arabic *:</div>
                                                <div class="span9"><input type="text" name="fullname" value="<?=$row->fullname?>" required="required" /></div>
                                            </div>
                                            <div class="row-form clearfix">
                                                <div class="span3">Phone :</div>
                                                <div class="span9"><input type="text" name="phone" value="<?=$row->phone?>" /></div>
                                            </div>
                                            <div class="row-form clearfix">
                                                <div class="span3">Address :</div>
                                                <div class="span9"><input type="text" name="address" value="<?=$row->address?>" /></div>
                                            </div> 
                                            
                                            <div class="row-form clearfix">
                                                <div class="span3">Status:</div>
                                                <div class="span4"><?php $array_status=array('online'=>'Online','offline'=>'Offline');
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
                            </table>
                    
                </div>
                <?php echo form_close();?>
            </div>                                
        </div>            
        <div class="dr"><span></span></div>            
    </div>
</div>
<?php if($p_add_position){ ?>
<div id="CreateModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Add New Salesman</h3>
    </div>  
    <?php echo form_open_multipart('parameters/create_salesman',array('id'=>'validation'));?>      
    <div class="row-fluid">
        <div class="block-fluid">
            <div class="row-form clearfix">
                <div class="span3">Fullname in english *:</div>
                <div class="span9"><input type="text" name="fullname_en" required="required" /></div>
            </div>            
            <div class="row-form clearfix">
                <div class="span3">Fullname in arabic *:</div>
                <div class="span9"><input type="text" name="fullname" required="required" /></div>
            </div> 
            <div class="row-form clearfix">
                <div class="span3">Phone :</div>
                <div class="span9"><input type="text" name="phone" /></div>
            </div>
            <div class="row-form clearfix">
                <div class="span3">Address :</div>
                <div class="span9"><input type="text" name="address"/></div>
            </div>
              
            <div class="row-form clearfix">
                <div class="span3">Status:</div>
                <div class="span4"><?php $array_status=array('online'=>'Online','offline'=>'Offline');
                                        echo form_dropdown('status',$array_status/*,$status*/);
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