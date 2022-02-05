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
                <?php echo form_open('sponsors/delete_checked',array('id'=>'form_id','name'=>'form1'));?>                  
                <div class="head clearfix">
                    <div class="isw-grid"></div>
                    <h1><?=$subtitle?></h1>
                     <?=_show_delete_checked('#',$p_delete)?>
                </div>
                <div class="block-fluid table-sorting clearfix">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table" id="tSortable">
                        <thead>
                            <tr>
                                <th><input type="checkbox" name="checkall"/></th>
                                <th>Title Ar</th>
                                <th>Position</th>
                                <th>Image </th>
                                <th>Date</th>
                                <th>Actions</th>                                    
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($query as $row){?>
                            <tr>
                                <td><input type="checkbox" name="checkbox1[]" value="<?=$row->id?>"/></td>
                                <td><?=anchor('news/edit/'.$row->id,$row->title_ar.' <br> '.$row->title_en)?></td>
                                <td><?=$row->position?></td>
                                <td><img src="<?=base_url().$row->url?>" style="height:60px !important" /></td>
                                <td><?=$row->fdate.' -> '.$row->tdate?></td>
                                <td><?php 
										echo _show_delete('news/delete/'.$row->id,$p_delete);
										echo _show_edit('news/edit/'.$row->id,$p_edit);
										if($row->status=='active')
										echo '<span class="label label-success">Active</span>';
										else
										echo '<span class="label">Inactive</span>';
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