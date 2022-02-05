<style type="text/css">
.title{
	width:200px !important;
}
.text1{
	margin-left:200px !important;
}
</style>
<div class="content">
	<?=$this->load->view("includes/_bread")?>
            <div class="workplace">
			<div class="row-fluid">
                <div class="span12">
                    <div class="widgetButtons">
                    	<?php if($class_edit){ ?>
                    	<div class="bb"><?=anchor('schedules/edit/id/'.$query['id'],'<span class="ibw-edit"></span>')?><br>Edit</div>
                      <?php } ?>
                      <?php ///if($p_add){ ?>     
                        <div class="bb"><?=anchor('schedules/tools/id/'.$query['id'],'<span class="ibw-edit"></span>')?><br>Instructor Tools</div>
                        <?php //} ?>
                        <?php if($class_delete){ ?>
                        <div class="bb"><?=anchor('schedules/delete/id/'.$query['id'],'<span class="ibw-delete"></span>',$js_confirm)?><br>Delete</div>
                        <?php } ?>
                        <?php if($p_register){ ?>
                        <div class="bb"><?=anchor('registrations/schedule/id/'.$query['id'],'<span class="ibw-list"></span>')?><br>Registrations</div>
                        <?php } ?>
                        <?php if($p_invoice){ ?>
						<div class="bb"><?=anchor('schedules/delete/id/'.$query['id'],'<span class="ibw-text_document"></span>')?><br>Invoices</div> 
                        <?php } ?>
                        <?php if($p_add){ ?>                       
                        <div class="bb"><?=anchor('schedules/create','<span class="ibw-plus"></span>')?><br>Add</div>
                    </div>
                    <?php } ?>
                </div>
                </div>            
                <div class="page-header">
                    <h1><small><?=$query['course']?></small></h1>
                </div>                  
                
                <div class="row-fluid">

                <div class="span12">   
                <?php if($msg!=''){ ?>
              	<div class="alert alert-success">               
                    <?php echo $msg;?>
                </div> 
                <?php } ?>                   
                        <div class="row-fluid">
                            <div class="span6">
                                <div class="block-fluid ucard">
                                        <div class="info">                                                                
                                            <ul class="rows">
                                                <li class="heading"> <div class="isw-cloud"></div>Class Schedule Details</li>
                                                <li>
                                                    <div class="title title1">Course Title:</div>
                                                    <div class="text text1"><?=$query['course_code'].' : '.$query['course']?></div>
                                                </li>
                                                <li>
                                                    <div class="title title1">Class Category:</div>
                                                    <div class="text text1"><?=$query['category'];?>.</div>
                                                </li>
                                                <?php if($query['category_id']==1){ ?>                                                <li>
                                                    <div class="title title1">Client:</div>
                                                    <div class="text text1"><?=$query['client']?>.</div>
                                                </li>
    											<?php } ?>
                                                <li>
                                                    <div class="title title1">No.of Participants:</div>
                                                    <div class="text text1"><?=$query['no_of_participants']?>.</div>
                                                </li>
                                                <li>
                                                    <div class="title title1">Dates:</div>
                                                    <div class="text text1"><?=$query['start_date'].' To '.$query['end_date']?>.</div>
                                                </li>
                                                <li>
                                                    <div class="title title1">Location:</div>
                                                    <div class="text text1"><?=$query['country'].' - '.$query['city']; ?>.</div>
                                                </li>
                                                <li>
                                                    <div class="title title1">Status MAE:</div>
                                                    <div class="text text1">
													<?php if($query['status']=='done')
																echo '<span class="btn btn-mini btn-success">Done</span>';
															elseif($query['status']=='pending')
																echo '<span class="btn btn-mini btn-warning">Pending</span>';
															else{
																echo '<span class="btn btn-mini btn-danger">Canceled</span>';
																}?>
                                                    </div>
                                                </li>                                                                                               
                                            </ul>                                                      
                                        </div>                        
                                </div>
                            </div> 
							<div class="span6">
                                <div class="block-fluid ucard">
                                        <div class="info">                                                                
                                            <ul class="rows">
                                                <li class="heading"> <div class="isw-cloud"></div>Class Schedule Settings</li>
 
                                                <li>
                                                    <div class="title title1">INMA Staff AHH (Open):</div>
                                                    <div class="text text1"><?=$query['staff_open']?>&nbsp;</div>
                                                </li>
                                                <li>
                                                    <div class="title title1">INMA Staff AHH (Close):</div>
                                                    <div class="text text1"><?=$query['staff_close']?>&nbsp;</div>
                                                </li>                                                
                                                <li>
                                                    <div class="title title1">Hotel OMM (Meeting):</div>
                                                    <div class="text text1"><?=$query['hotel']?>&nbsp;</div>
                                                </li>                                                

                                                <li>
                                                    <div class="title title1">Outline MAE:</div>
                                                    <div class="text text1"><?=ucfirst($query['outline'])?>&nbsp;</div>
                                                </li>
                                                <li>
                                                    <div class="title">Material MAE (Word):</div>
                                                    <div class="text text1"><?=ucfirst($query['material_word'])?>&nbsp;</div>
                                                </li>
                                                <li>
                                                    <div class="title">Material MAE (P.P):</div>
                                                    <div class="text text1"><?=ucfirst($query['material_pp'])?>&nbsp;</div>
                                                </li>                                                
                                                <li>
                                                    <div class="title title1">Comment:</div>
                                                    <div class="text text1"><?=ucfirst($query['comment'])?>&nbsp;</div>
                                                </li>        
                                                                                                                                                                            		<li>
                                                    <div class="title title1">Create Date:</div>
                                                    <div class="text text1"><?=$query['create_time']?></div>
                                                </li>
                                                <li>
                                                    <div class="title title1">Last Update Date:</div>
                                                    <div class="text text1"><?=$query['update_time']?></div>
                                                </li>
                                               
                                            </ul>                                                      
                                        </div>                        
                                </div>
                            </div>                                                           
                        </div>
                        <div class="row-fluid">

                    <div class="span12">                    
                        <div class="head clearfix">
                            <div class="isw-grid"></div>
                            <h1>Instructors Tools</h1>                 
                        </div>
                        <div class="block-fluid">
                            <table cellpadding="0" cellspacing="0" width="100%" class="table">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" name="checkall"/></th>                                        
                                        <th>Instructor</th>
                                        <th>Provider</th>
                                        <th>Hotel OMM (Room)</th>                       
                                        <th>Instructor Eveluation AHH</th>
                                        <th>Visa OMM</th>
                                        <th>Ticket Issue OMM</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if(count($tools)){
										foreach($tools as $item){ ?>
                                    <tr>
                                        <td><input type="checkbox" name="checkbox"/></td>                                        
                                        <td><?=$item->fullname?></td>
                                        <td><?=$item->provider?></td>
                                        <td><?=$item->hotel?></td>                      
                                        <td><?=$item->eveluation?></td>
                                        <td><?=ucfirst($item->visa)?></td>
                                        <td><?=ucfirst($item->ticket)?></td>
                                        <td><?php echo _show_delete('schedules/remove/id/'.$item->id.'/sid/'.$query['id'],$class_delete);
										echo _show_edit('schedules/update/id/'.$item->id.'/sid/'.$query['id'],$class_edit);?></td>
                                    </tr>
                                  <?php }
								  
								}
								else{
								?> 
                                    <tr>
                                        <td colspan="8" align="center"><h3>No Instructor Found</h3></td>
                                    </tr> 
                                   <?php } ?>                                                                
                                </tbody>
                            </table>
                        </div>
                    </div>                                
                </div>
<div class="row-fluid">

                    <div class="span12">                    
                        <div class="head clearfix">
                            <div class="isw-grid"></div>
                            <h1>Trainees</h1>                 
                        </div>
                        <div class="block-fluid">
                            <table cellpadding="0" cellspacing="0" width="100%" class="table">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" name="checkall"/></th>                                        
                                        <th>Trainees</th>
                                        <th>Clients</th>
                                        <th>Code</th>                       
                                        <th>Status</th>
                                        <th>PIF</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if(count($registrations)){
										foreach($registrations as $registration){ ?>
                                    <tr>
                                        <td><input type="checkbox" name="checkbox"/></td>                                        
                                        <td><?=$registration->fullname?></td>
                                        <td><?=$registration->company?></td>
                                        <td><?=$registration->code?></td>                      
                                        <td><?=$registration->status?></td>
                                        <td><?php 
										if($registration->pif!='')
										echo anchor(base_url().$registration->pif,'PIF',array('target'=>'_blank'));
										else
										echo 'Not Found';
										?></td>
                                        <td><?php echo _show_delete('registrations/delete/id/'.$registration->id.'/sid/'.$query['id'],$class_delete);
										echo _show_edit('registrations/edit/id/'.$registration->id.'/sid/'.$query['id'],$class_edit);?></td>
                                    </tr>
                                  <?php }
								  
								}
								else{
								?> 
                                    <tr>
                                        <td colspan="8" align="center"><h3>No Trainees Found</h3></td>
                                    </tr> 
                                   <?php } ?>                                                                
                                </tbody>
                            </table>
                        </div>
                    </div>                                
                </div>                	                        
              </div>
            </div>            
           <div class="dr"><span></span></div>           
         </div>
        </div>