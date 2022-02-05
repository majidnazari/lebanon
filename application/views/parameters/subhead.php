<?php 
$acode = array(
	'name'	=> 'code',
	'id'	=> 'code',
	'value' => $code,
);
$adescription = array(
	'name'	=> 'description',
	'id'	=> 'description',	
	'value' => $description,
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
                    <div class="isw-zoom"></div>
                    <h1>Search</h1>
                </div>
                <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'validation','method'=>'get'));
					  
					   ?> 
                <div class="block-fluid">                        

                    <div class="row-form clearfix">
                        <div class="span2">Code<br /><?php echo form_input($acode); ?></div>
                        <div class="span6">SubHead (Arabic or english)<br /><?php echo form_input($adescription); ?></div>
                        <div class="span2">Status<br /><?php $array_status=array('online'=>'Online','offline'=>'Offline');
												echo form_dropdown('status',$array_status,$status);
							?></div>
                        <div class="span2"><br /><input type="submit" name="search" value="Search" class="btn">
                        <input type="submit" name="clear" value="Clear" class="btn">
                        </div>
                    </div>                            
                </div>
				<?=form_close()?>
            </div>
        </div> 
        <div class="row-fluid">
            <div class="span12">
            <?php if($msg!=''){ ?>
              	<div class="alert alert-success">               
                    <?php echo $msg;?>
                </div> 
                <?php } ?>    
                <?php echo form_open('parameters/items/delete_checked',array('id'=>'form_id','name'=>'form1'));
						echo form_hidden('st',$st);
						echo form_hidden('p','subhead');
				?>                                
                <div class="head clearfix">
                    <div class="isw-grid"></div>
                    <h1><?=$subtitle?></h1>
                     <?=_show_delete_checked('#',$p_delete)?>
                     <?=_show_add_pop('#CreateModal','Add New',TRUE)?> 
                                                       
                </div>  
                <div class="block-fluid table-sorting clearfix">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                                <th><input type="checkbox" name="checkall"/></th>
                                <th>Code</th>
                                <th width="32%">English Description</th>
                                <th width="32%">Arabic Description</th>
                                <th>Date</th>                                
                                <th>Actions</th>                                    
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($query as $row){?>
                            <tr>
                                <td><input type="checkbox" name="checkbox1[]" value="<?=$row->id?>"/></td>
                                <td><?=$row->code?></td>
                                <td><?=$row->title_en?></td>
                                <td align="right" style="text-align:right !important"><?=$row->title_ar?></td>
                                <td><?php echo 'Create Date : '.date('d-m-Y',strtotime($row->create_time))."<br />Last Update : ".date('d-m-Y',strtotime($row->update_time))?></td>
                                <td><?php 
										echo _show_delete('parameters/items/delete/id/'.$row->id.'/p/subhead/st/'.$st,$p_delete);
										echo _show_edit_pop('#'.$row->id.'Modal',$p_edit);
										
									
								if($row->status=='online')
								echo '<span class="label label-success">Online</span>';
								else
								echo '<span class="label">Offline</span>';
							
									?>                                        
                                </td>                                    
                            </tr>
                            <div id="<?=$row->id?>Modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h3 id="myModalLabel">Edit Sub Heading</h3>
                                    </div>  
                                    <?php echo form_open_multipart('parameters/items/subhead_edit',array('id'=>'validation'));
					  				echo form_hidden('id',$row->id);
									echo form_hidden('st',$st);
									?>      
                                    <div class="row-fluid">
                                        <div class="block-fluid">
                                            <div class="row-form clearfix">
                                                <div class="span3">Code *:</div>
                                                <div class="span9"><input type="text" name="code" value="<?=$row->code?>" required="required" /></div>
                                            </div>            
                                            <div class="row-form clearfix">
                                                <div class="span3">English Description *</div>
                                                <div class="span9">
                                                	<textarea name="title_en" required="required"><?=$row->title_en?></textarea>
                                            </div>
                                            </div>                                    
                                            <div class="row-form clearfix">
                                                <div class="span3">Arabic Description *</div>
                                                <div class="span9">
                                                	<textarea name="title_ar" dir="rtl" required="required"><?=$row->title_ar?></textarea>
                                                </div>
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
                                        <input type="submit" name="save" value="Save" class="btn">
                                        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>            
                                    </div>
                                    <?=form_close()?>
        						</div>
                        <?php } ?>    
                        </tbody>
                        <tfoot>
                        	<tr>
                            	<td colspan="6"><?=$links?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <?php echo form_close();?>
            </div>                                
        </div>            
        <div class="dr"><span></span></div>            
    </div>
</div>
<div id="CreateModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h3 id="myModalLabel">Add New Sub Heading</h3>
                                    </div>  
                                    <?php echo form_open_multipart('parameters/items/subhead_create',array('id'=>'validation'));
										  echo form_hidden('st',$st);
									?>      
                                    <div class="row-fluid">
                                        <div class="block-fluid">
                                            <div class="row-form clearfix">
                                                <div class="span3">Code *:</div>
                                                <div class="span9"><input type="text" name="code" required="required" /></div>
                                            </div>            
                                            <div class="row-form clearfix">
                                                <div class="span3">English Description *</div>
                                                <div class="span9">
                                                	<textarea name="title_en" required="required"></textarea>
                                            </div>
                                            </div>                                    
                                            <div class="row-form clearfix">
                                                <div class="span3">Arabic Description *</div>
                                                <div class="span9">
                                                	<textarea name="title_ar" dir="rtl" required="required"></textarea>
                                                </div>
                                            </div>                                    
                                            <div class="row-form clearfix">
                                            <div class="span3">Status:</div>
                                            <div class="span4"><?php $array_status=array('online'=>'Online','offline'=>'Offline');
                                                                    echo form_dropdown('status',$array_status,'');
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