<div class="content">
	<?=$this->load->view("includes/_bread")?>
    <div class="workplace">
   <div class="row-fluid">
                    <div class="span12">

                        <div class="widgetButtons">                        
                            <div class="bb green">
                            	<?=anchor('schedules/index/status/done/cat/'.$cat_link,'<span>Completed Schedules</span>')?>
                                 <div class="caption"><?=$done_schedules?></div>
                            </div>
                            <div class="bb yellow">
                                <?=anchor('schedules/index/status/pending/cat/'.$cat_link,'<span>Pending Schedules</span>')?>
                                <div class="caption"><?=$pending_schedules?></div>
                            </div>
 							<div class="bb red">
                                <?=anchor('schedules/index/status/canceled/cat/'.$cat_link,'<span>Canceled Schedules</span>')?>
                                <div class="caption"><?=$canceled_schedules?></div>
                            </div>
                            <?php if($p_add){ ?>   
 							<div class="bb">
                                <?=anchor('schedules/create','<span class="ibw-plus"></span>')?>
                            </div> 
                            <?php } ?>                                                        
                        </div>

                    </div>
                </div> 
        <div class="row-fluid">
            <div class="span12">
            <?php if($msg!=''){ ?>
              	<div class="alert alert-success">               
                    <?php echo $msg;?>
                </div> 
                <?php } ?>    
                <?php echo form_open('courses/delete_checked_schedules',array('id'=>'form_id','name'=>'form1'));?>                                
                <div class="head clearfix">
                    <div class="isw-grid"></div>
                    <h1><?=$subtitle?></h1>
                     <?=_show_delete_checked('#',$class_delete)?>                               
                </div>  
                <div class="block-fluid table-sorting clearfix">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table" id="tSortable">
                        <thead>
                            <tr>
                                <th><input type="checkbox" name="checkall"/></th>
                                <th>Class Schedule</th>
                                <th>Location</th>
                                <th>Date</th>                                
                                <th>Actions</th>                                    
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($query as $row){?>
                            <tr>
                                <td><input type="checkbox" name="checkbox1[]" value="<?=$row->id?>"/></td>
                                <td><?=$row->course_code.' : '.$row->course?></td>
                                <td><?=$row->country.' - '.$row->city; ?>
                                <?php if($row->hotel_meeting_id!=0) 
                                		echo ' - '.$row->hotel?>
                                 </td>
                                <td><?=$row->start_date.' To '.$row->end_date?></td>
                                <td><?php 
										echo _show_delete('schedules/delete/id/'.$row->id,$class_delete);
										echo _show_edit('schedules/edit/id/'.$row->id,$class_edit);
										echo _show_settings('schedules/details/id/'.$row->id).'<br>';
									if($row->status=='done')
										echo '<span class="btn btn-mini btn-success">Done</span>';
									elseif($row->status=='pending')
										echo '<span class="btn btn-mini btn-warning">Pending</span>';
									else{
										echo '<span class="btn btn-mini btn-danger">Canceled</span>';
										}		
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