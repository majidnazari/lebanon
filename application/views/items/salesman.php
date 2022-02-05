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
                <?php echo form_open('parameters/salesman/delete_checked',array('id'=>'form_id','name'=>'form1'));?>                                
                <div class="head clearfix">
                    <div class="isw-grid"></div>
                    <h1><?=$subtitle?></h1>
                     <?=_show_delete_checked('#',$p_delete)?>
                     <?=_show_add('parameters/salesman/create','Add New',TRUE)?>                                   
                </div>  
                <div class="block-fluid table-sorting clearfix">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table" id="tSortable">
                        <thead>
                            <tr>
                                <th><input type="checkbox" name="checkall"/></th>
                                <th>SalesMan</th>
                                <th>Contact Info</th>
                                <th>Date</th>                                
                                <th>Actions</th>                                    
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($query as $row){?>
                            <tr>
                                <td><input type="checkbox" name="checkbox1[]" value="<?=$row->id?>"/></td>
                                <td><?=$row->fullname_en.'<br>'.$row->fullname?></td>
                                <td><?=$row->phone.'<br />'.$row->address?></td>
                                <td><?php echo 'Create Date : '.date('d-m-Y',strtotime($row->create_time))."<br />Last Update : ".date('d-m-Y',strtotime($row->update_time))?></td>
                                <td><?php 
										echo _show_delete('parameters/salesman/delete/id/'.$row->id,$p_delete);
										echo _show_edit('parameters/salesman/edit/id/'.$row->id,$p_edit);
										
									
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