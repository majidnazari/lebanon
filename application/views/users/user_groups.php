<div class="content">
	<?=$this->load->view("includes/_bread")?>
    <div class="workplace">
        <div class="page-header">
            <h1><?=$subtitle;?></h1>
        </div> 
         <div class="row-fluid">
            <div class="span12">
            <?php if($msg!=''){ ?>
              	<div class="alert alert-success">               
                    <?php echo $msg;?>
                </div> 
                <?php } ?>    
                <?php echo form_open('',array('id'=>'form_id','name'=>'form1'));
						
				?>   
                                          
                <div class="head clearfix">
                    <div class="isw-grid"></div>
                    <h1><?=$subtitle?></h1>
					  
					  <?php /* <a href="javascript:void(0)" onclick="delete_checked()">
                      <h2 style="float:right; color:#FFF !important">Delete Checked</h2></a>
					  */?>
                      <?=anchor('banks/create','<h3 style="float:right !important">Add New</h3>')?>
                </div>  
                <div class="block-fluid table-sorting clearfix">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table" id="tSortable">
                        <thead>
                            <tr>
                                <th><input type="checkbox" name="checkall"/></th>
                                <th>Group Name</th>
                                <th>Create Date</th>
                                <th>Last Update Date</th>                                
                                <th>Actions</th>                                    
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($query as $row){?>
                            <tr>
                                <td><input type="checkbox" name="checkbox1[]" value="<?=$row->id?>"/></td>
                                <td><?=$row->name?></td>
                                <td><?=$row->create_time?></td>
                                <td><?=$row->update_time?></td>
                                <td>
									<?=_show_edit('users/group-edit/'.$row->id,TRUE)?>
                                    <?php //_show_delete('users/group_delete/'.$row->id,TRUE)?>
                                </td>                                    
                            </tr>
                        <?php } ?>    
                        </tbody>
                    </table>
                </div>
                <?php echo form_close();?>
            </div>                                
        </div>            
        <div class="dr"><span></span></div>            
    </div>
</div>
