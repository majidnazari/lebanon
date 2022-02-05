<div class="content">
	<?=$this->load->view("includes/_bread")?>
    <div class="workplace">
        <div class="row-fluid">
            <div class="span12">
            <?php if($msg!=''){ ?>
              	<div class="alert alert-success">               
                    <?php echo $msg;?>
                </div> 
                <?php } ?> 
                <?php echo form_open('users/delete_checked',array('id'=>'form_id','name'=>'form1'));?>                     
                <div class="head clearfix">
                    <div class="isw-grid"></div>
                    <h1>Users List</h1>
                    <?php //_show_delete_checked('#',$p_delete)?>                                 
                </div>  
                <div class="block-fluid table-sorting clearfix">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table" id="tSortable">
                        <thead>
                            <tr>
                                <th width="25%">Full Name</th>
                                <th width="25%">Username</th>             
                                <th>Group</th>
                                <th width="25%">Contact Info</th>
                                <th width="25%">Actions</th>                                    
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($query as $row){?>
                            <tr>
                                <td><?=$row->fullname?></td>
                                <td><?=$row->username?></td>
                                <td><?=$row->group_name?></td>
                                <td>
									<?php if($row->email!='') echo 'Email : '.$row->email.'<br>'; ?>
                                	<?php if($row->phone!='') echo 'Phone : '.$row->phone.'<br>'; ?>
                                    <?php if($row->address!='') echo 'Address : '.$row->address.'<br>'; ?>
                                </td>
                                <td><?php 
										//echo _show_delete('users/delete/'.$row->id,$p_delete);
										echo _show_edit('users/edit/'.$row->id,$p_edit);
										echo _show_settings('users/change-password/'.$row->id);
									if($row->status=='online')
										echo '<span class="label label-success">Online</span>';
									else
										echo '<span class="label">Offline</span>';
							
									?>                                       
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