                <?php echo form_open('',array('id'=>'form_id','name'=>'form1'));?>
                <div class="head clearfix">
                    <div class="isw-grid"></div>
                    <h1><?=$subtitle?></h1>
                        
                </div>  
                <div class="block-fluid table-sorting clearfix">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table">
                         <thead>
                        <tr>
                            <th style="text-align:center" rowspan="2"  width="15%">Area</th>
                            <th style="text-align:center" rowspan="2"  width="15%">Kazaa</th>
                            <th style="text-align:center" rowspan="2"  width="15%">Mohafaza</th>
                            <th style="text-align:center" rowspan="2" width="10%">All</th>
                            <th style="text-align:center" rowspan="2" width="10%">Canceled</th>
                            <th style="text-align:center" colspan="3" width="10%">Pending</th>
                            <th style="text-align:center" colspan="3" width="5%">Done</th>
                            <th style="text-align:center" colspan="3" width="5%">Acc. Pending</th>
                            <th style="text-align:center" colspan="3" width="5%">Acc. Done</th>
                        </tr>
                        <tr>
                            <!--<th>All</th>
                            <th nowrap>Update Info</th>-->
                            
                            <th>View</th>
                            <th>List</th>
                            <th>Istimarat</th>
                            
                            <th>View</th>
                            <th>List</th>
                            <th>Istimarat</th>
                            
                            <th>View</th>
                            <th>List</th>
                            <th>Istimarat</th>
                            
                            <th>View</th>
                            <th>List</th>
                            <th>Istimarat</th>
                            
                        </tr>
                        </thead>
                    
                        <tbody> 
                        <?php 
						if(count($query)>0){
						foreach($query as $row){
                        //    $all = $this->Task->GetListTasks('', '', '', '', '', '', $row->salesman_id, '', '', '', '', '', '','', 0, 0);
                           // $update_info = $this->Task->GetUpdatedInfoCompaniesBySalesMan($row->salesman_id,'','','');
							?>
                            <tr>
                                <td style="text-align:center"><?=$row->area_ar?></td>
                                <td style="text-align:center"><?=$row->district_ar?></td>
                                <td style="text-align:center"><?=$row->governorate_ar?></td>
                                <td style="text-align:center"><?=$row->all_count?></td>
                                <td style="text-align:center"><?=$row->canceled_count?></td>
                                <!--<td style="text-align:center" nowrap><?=$row->update_info_count?></td>-->
                                <td style="text-align:center" nowrap class="btn-warning"><?=anchor('tasks?list=&sales_man=&from_start=&to_start=&from_due=&to_due=&gov='.@$row->governorate_id.'&district_id='.@$row->district_id.'&area_id='.@$row->area_id.'&status=pending&category=&search=Search','View ('.$row->pending_count.')')?></td>
                                
                                <td style="text-align:center" class="btn-warning"><?=anchor('tasks/area-list?governorate='.@$row->governorate_id.'&district_id='.@$row->district_id.'&area_id='.@$row->area_id.'&status=pending','<span class="isb-print"></span>',array('target'=>'_blank'))?></td>
                                <td style="text-align:center" class="btn-warning"><?=anchor('tasks/print_details?governorate='.@$row->governorate_id.'&district_id='.@$row->district_id.'&area_id='.@$row->area_id.'&status=pending','<span class="isb-print"></span>',array('target'=>'_blank'))?></td>


                                <td style="text-align:center" nowrap class="btn-success"><?=anchor('tasks?list=&sales_man=&from_start=&to_start=&from_due=&to_due=&gov='.@$row->governorate_id.'&district_id='.@$row->district_id.'&area_id='.@$row->area_id.'&status=done&category=&search=Search','View ('.$row->done_count.')')?></td>
                                <td style="text-align:center"  class="btn-success"><?=anchor('tasks/area-list?governorate='.@$row->governorate_id.'&district_id='.@$row->district_id.'&area_id='.@$row->area_id.'&status=done','<span class="isb-print"></span>',array('target'=>'_blank'))?></td>
                                <td style="text-align:center" class="btn-success"><?=anchor('tasks/print-details?governorate='.@$row->governorate_id.'&district_id='.@$row->district_id.'&area_id='.@$row->area_id.'&status=done','<span class="isb-print"></span>',array('target'=>'_blank'))?></td>


                                <td style="text-align:center" nowrap class="btn-warning"><?=anchor('tasks/acc?area_id='.@$row->area_id.'&district_id='.@$row->district_id.'&governorate_id='.@$row->governorate_id.'&salesman=&status=no','View ('.@$row->pending_acc.')')?></td>
                                <td style="text-align:center" class="btn-warning"><?=anchor('tasks/area-list-acc?area_id='.@$row->area_id.'&district_id='.@$row->district_id.'&governorate_id='.@$row->governorate_id.'&salesman=&status=no','<span class="isb-print"></span>',array('target'=>'_blank'))?></td>
                                <td style="text-align:center" class="btn-warning"><?=anchor('tasks/print-details-acc?area_id='.@$row->area_id.'&district_id='.@$row->district_id.'&governorate_id='.@$row->governorate_id.'&status=no','<span class="isb-print"></span>',array('target'=>'_blank'))?></td>

                                <td style="text-align:center" nowrap class="btn-success"><?=anchor('tasks/acc?area_id='.@$row->area_id.'&district_id='.@$row->district_id.'&governorate_id='.@$row->governorate_id.'&salesman=&status=yes','View ('.$row->done_acc.')')?></td>
                                <td style="text-align:center" class="btn-success"><?=anchor('tasks/area-list-acc?area_id='.@$row->area_id.'&district_id='.@$row->district_id.'&governorate_id='.@$row->governorate_id.'&salesman=&status=yes','<span class="isb-print"></span>',array('target'=>'_blank'))?></td>
                                <td style="text-align:center" class="btn-success"><?=anchor('tasks/print-details-acc?area_id='.@$row->area_id.'&district_id='.@$row->district_id.'&governorate_id='.@$row->governorate_id.'salesman=&status=yes','<span class="isb-print"></span>',array('target'=>'_blank'))?></td>

                            </tr>
                            
                        <?php } }
						else{
								echo '<tr>
                            	<td colspan="16"><center><strong>No Data Found</strong></center></td>
                            </tr>';
							}
						
						?>    
                        </tbody>
                        <tfoot>
                        	<tr>
                                <td colspan="16">Total : <?=$total_row?><div class="dataTables_paginate paging_full_numbers"><?=$links?></div></td></tr>
                        </tfoot>
                    </table>
                    
                </div>
                <?php echo form_close();?>
            