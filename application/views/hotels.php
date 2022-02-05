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
                <?php echo form_open('hotels/delete_checked',array('id'=>'form_id','name'=>'form1'));?>                                
                <div class="head clearfix">
                    <div class="isw-grid"></div>
                    <h1>Hotels Details List</h1>
                     <?=_show_delete_checked('#',$p_delete)?>                               
                </div>  
                <div class="block-fluid table-sorting clearfix">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table" id="tSortable">
                        <thead>
                            <tr>
                                <th><input type="checkbox" name="checkall"/></th>
                                <th>Hotel</th>
                                <th>Contact info</th>
                                <th>Rating</th>                                
                                <th>Actions</th>                                    
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($query as $row){?>
                            <tr>
                                <td><input type="checkbox" name="checkbox1[]" value="<?=$row->id?>"/></td>
                                <td><?=$row->name."<br>"?><?php for($i=1;$i<=$row->rating;$i++){ ?>
                                	<img src="<?=base_url()?>img/start.png" style="height:20px !important" />
                                    <?php } ?></td>
                                <td><?=$row->city." - ".$row->country.'<br>Phone : '.$row->phone?></td>
                                <td><?='Create Date : '.$row->create_time.'<br>Last Update : '.$row->update_time?></td>
                                <td><?php 
										echo _show_delete('hotels/delete/id/'.$row->id,$p_delete);
										echo _show_edit('hotels/edit/id/'.$row->id,$p_edit).'<br/>';
									
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