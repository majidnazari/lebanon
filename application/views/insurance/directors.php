<link href="<?=base_url()?>table/style.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="<?=base_url()?>table/scripts/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>table/scripts/move.js"></script>
<script>
function standing()
        {
			
            document.getElementById("form_id").action = "<?=base_url().'insurances/standing_directors'?>";
			document.getElementById("form_id").submit();
        }
		
function editing(id)
        {
			document.getElementById("form_id").action = "<?=base_url().'insurances/edit_director/'?>"+id;
			document.getElementById(id).submit();
        }		
function delete_checked()
        {
			checkboxes = document.getElementsByName('checkall');
			checkboxes.checked =true;
            document.getElementById("form_id").action = "<?=base_url().'insurances/delete_checked'?>";
			var answer = confirm("Are You Sure ?")
				if (answer){
					document.getElementById("form_id").submit();
				}
				else{
					return false
				}
            

        }		
</script>
<div class="content">
	<?=$this->load->view("includes/_bread")?>
    <div class="workplace">
        <div class="page-header">
            <h1><?=$subtitle?></h1>
            
        </div> 
        <div class="row-fluid">
            <div class="span9">
            <?php if($msg!=''){ ?>
              	<div class="alert alert-success">               
                    <?php echo $msg;?>
                </div> 
                <?php } ?>    
                <?php  echo form_open('',array('id'=>'form_id','name'=>'form1'));
						echo form_hidden('ins_id',$id);
						echo form_hidden('p','director');
				?>                                
                <div class="head clearfix">
                    <div class="isw-grid"></div>
                    <h1><?=$subtitle?></h1>
                    <a href="javascript:void(0)" onclick="standing()">
                      <h2 style="float:right; color:#FFF !important">Save Ordering </h2></a>
                      <a href="javascript:void(0)" onclick="delete_checked()"><h2 style="float:right; color:#FFF !important">Delete Checked</h2></a>
                     <?php //echo _show_delete_checked('#',$p_delete_position)?>
                     <?=_show_add_pop('#CreateModal','Add New',$p_directors_add)?> 
                                                       
                </div>  
                <div class="block-fluid table-sorting clearfix">
                <table cellpadding="0" cellspacing="0" width="100%" class="table" id="tSortable">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th width="20%">English Name</th>
                                        <th width="20%">Arabic Name</th>
                                        <th width="25%">Date</th>
                                        <th width="15%">Created By</th>
                                        <th width="15%">Ordering</th> 
                                        <th width="10%">Actions</th>                                    
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
                                	<td> <input type="checkbox" id="check" name="checkbox1[]" value="<?=$row->id?>"/></td>
                                    <td><input type="hidden" name="ids[]" value="<?=$row->id?>" /><?=$row->name_en?></td>
                                    <td align="right" style="text-align:right !important">
                                    <?=$row->name_ar?></td>
             
                                    <td><?php echo 'Create Date : '.$row->create_time."<br />Last Update : ".$row->update_time?></td>
                                    <td><?=$createdBy?></td>
                                    <td>
                                         <a href="javascript:void(0)" class="up"></a>
                                         <a href="javascript:void(0)" class="down"></a>
                                         <a href="javascript:void(0)" class="top"></a>
                                    </td>
                                    <td><?php 
                                         echo _show_delete('insurances/delete/id/'.$row->id.'/iid/'.$id.'/p/director/',$p_directors_delete);
                                         echo _show_edit_pop('#'.$row->id.'Modal',$p_directors_edit);
                                    ?>                                        
                                    </td>                                    
                            </tr>
                            <?php if($p_directors_edit){ 
							echo form_open_multipart('insurances/edit_director',array('id'=>$row->id));
							?>
                            <div id="<?=$row->id?>Modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h3 id="myModalLabel">Edit Director</h3>
                                    </div>  
                                    <?php 
									
									
					  				echo form_hidden('insurance_id',$id);
									echo form_hidden('id',$row->id);
									?>      
                                    <div class="row-fluid">
                                        <div class="block-fluid">
                                            <div class="row-form clearfix">
                                                <div class="span3">Name In english *:</div>
                                                <div class="span9"><input type="text" name="name_en<?=$row->id?>" value="<?=$row->name_en?>" required="required" /></div>
                                                </div>
                                                <div class="row-form clearfix">
                                                <div class="span3">Name In arabic *:</div>
                                                <div class="span9"><input type="text" name="name_ar<?=$row->id?>" value="<?=$row->name_ar?>" required="required" /></div>
                                            </div>
                                          </div>                
                                        <div class="dr"><span></span></div>
                                    </div>                    
                                    <div class="modal-footer">
                                       <!-- <input type="submit" name="save" value="Save" class="btn">-->
                                        <button class="btn" name="save" onclick="editing(<?=$row->id?>);">Save</button>
                                        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>            
                                    </div>
                                    
        						</div>
                                  <?php 
								  echo form_close();
								  }
								  } ?>  
                                </tbody>
                            </table>
                    
                </div>
                <?php  echo form_close();?>
            </div> 
            <?=$this->load->view('insurance/_navigation')?>                               
        </div>            
        <div class="dr"><span></span></div>            
    </div>
</div>
<?php if($p_directors_add){ ?>
<div id="CreateModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Add New Director</h3>
    </div>  
    <?php echo form_open_multipart('insurances/create_director',array('id'=>'validation'));
			echo form_hidden('insurance_id',$id);
	?>      
    <div class="row-fluid">
        <div class="block-fluid">
            <div class="row-form clearfix">
                <div class="span3">Name in english *:</div>
                <div class="span9"><input type="text" name="name_en" required="required" /></div>
            </div>            
            <div class="row-form clearfix">
                <div class="span3">Name in arabic *:</div>
                <div class="span9"><input type="text" name="name_ar" required="required" /></div>
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