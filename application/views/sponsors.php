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
                     <?='<h2 style="float:right; color:#FFF !important">'.anchor('sponsors/create','Add New Sponsor',array('style'=>'color:#FFF')).'&nbsp;&nbsp;&nbsp;|&nbsp; </h2>'?>                     
                </div>  
                <div class="block-fluid table-sorting clearfix">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table" id="tSortable">
                        <thead>
                            <tr>
                                <th><input type="checkbox" name="checkall"/></th>
                                <th>Sponsor</th>
                                <th>Position</th>
                                <th>Logo / الشعار</th>
                                <th>Actions</th>                                    
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($query as $row){
                                if($row->language=='ar')
                                {
                                    $x='A';
                                }
                                else{
                                    $x='E';
                                }
                        ?>
                            <tr>
                                <td><input type="checkbox" name="checkbox1[]" value="<?=$row->id?>"/></td>
                                <td><?=anchor($row->website,$row->title_en,array('target'=>'_blank'))?></td>
                                <td><?=$x.$row->position?></td>
                                <td><img src="http://www.lebanon-industry.com/<?=$row->logo?>" style="height:60px !important" /></td>
                                <td><?php 
										echo _show_delete('sponsors/delete/'.$row->id,$p_delete);
										echo _show_edit('sponsors/edit/'.$row->id,$p_edit);
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