                <?php echo form_open('',array('id'=>'form_id','name'=>'form1'));?>
                <div class="head clearfix">
                    <div class="isw-grid"></div>
                    <h1><?=$subtitle?></h1>
                        
                </div>  
                <div class="block-fluid table-sorting clearfix">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table">
                         <thead>
                        <tr>
                            
                            <th style="text-align:center" rowspan="2"  width="15%">Sales Man</th>
                            <th style="text-align:center" rowspan="2">Total List#</th>
                            <th style="text-align:center" rowspan="2" width="10%">All</th>
                            <th style="text-align:center" colspan="3" width="10%">Pending</th>
                            <th style="text-align:center" colspan="3" width="5%">Done</th>
                            <th style="text-align:center" colspan="3" width="5%">Acc. Pending</th>
                            <th style="text-align:center" colspan="3" width="5%">Acc. Done</th>
                        </tr>
                        <tr>
                            <!--<th>All</th>
                            <th nowrap>Update Info</th>-->
                            
                            <th>View</th>
                            <th> List</th>
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
                            $all = $this->Task->GetListTasks('', '', '', '', '', '', $row->salesman_id, '', '', '', '', '', '','', 0, 0);
                            $update_info = $this->Task->GetUpdatedInfoCompaniesBySalesMan($row->salesman_id,'','','');
							?>
                            <tr>
                                <td style="text-align:center"><?=$row->salesman?></td>
                                <td style="text-align:center"><?=anchor('tasks/lists?list=&sales_man='.$row->salesman_id.'&from_start=&to_start=&from_due=&to_due=&gov=0&district_id=0&area_id=0&status=&category=&search=Search',$all['num_results'])?></td>
                                <td style="text-align:center"><?=$row->all_count?></td>
                                <!--<td style="text-align:center" nowrap><?=$row->update_info_count?></td>-->
                                <td style="text-align:center" nowrap class="btn-warning"><?=anchor('tasks?list=&sales_man='.$row->salesman_id.'&from_start=&to_start=&from_due=&to_due=&gov=0&district_id=0&area_id=0&status=pending&category=&search=Search','View ('.$row->pending_count.')')?></td>
                                
                                <td style="text-align:center" class="btn-warning"><?=anchor('tasks/print-list?list=&sales_man='.$row->salesman_id.'&from_start=&to_start=&from_due=&to_due=&gov=0&district_id=0&area_id=0&status=pending&category=&search=Search','<span class="isb-print"></span>',array('target'=>'_blank'))?></td>
                                <td style="text-align:center" class="btn-warning"><?=anchor('tasks/print-details?list=&sales_man='.$row->salesman_id.'&from_start=&to_start=&from_due=&to_due=&gov=0&district_id=0&area_id=0&status=pending&category=&search=Search','<span class="isb-print"></span>',array('target'=>'_blank'))?></td>


                                <td style="text-align:center" nowrap class="btn-success"><?=anchor('tasks?list=&sales_man='.$row->salesman_id.'&from_start=&to_start=&from_due=&to_due=&gov=0&district_id=0&area_id=0&status=done&category=&search=Search','View ('.$row->done_count.')')?></td>
                                <td style="text-align:center"  class="btn-success"><?=anchor('tasks/print-list?list=&sales_man='.$row->salesman_id.'&from_start=&to_start=&from_due=&to_due=&gov=0&district_id=0&area_id=0&status=done&category=&search=Search','<span class="isb-print"></span>',array('target'=>'_blank'))?></td>
                                <td style="text-align:center" class="btn-success"><?=anchor('tasks/print-details?list=&sales_man='.$row->salesman_id.'&from_start=&to_start=&from_due=&to_due=&gov=0&district_id=0&area_id=0&status=done&category=&search=Search','<span class="isb-print"></span>',array('target'=>'_blank'))?></td>


                                <td style="text-align:center" nowrap class="btn-warning"><?=anchor('tasks/acc?area_id=&district_id=&governorate_id=&salesman='.$row->salesman_id.'&status=no','View ('.@$row->pending_acc.')')?></td>
                                <td style="text-align:center" class="btn-warning"><?=anchor('tasks/print-list-acc?area_id=&district_id=&governorate_id=&salesman='.$row->salesman_id.'&status=no','<span class="isb-print"></span>',array('target'=>'_blank'))?></td>
                                <td style="text-align:center" class="btn-warning"><?=anchor('tasks/print-details-acc?area_id=&district_id=&governorate_id=&salesman='.$row->salesman_id.'&status=no','<span class="isb-print"></span>',array('target'=>'_blank'))?></td>

                                <td style="text-align:center" nowrap class="btn-success"><?=anchor('tasks/acc?area_id=&district_id=&governorate_id=&salesman='.$row->salesman_id.'&status=yes','View ('.$row->done_acc.')')?></td>
                                <td style="text-align:center" class="btn-success"><?=anchor('tasks/print-list-acc?area_id=&district_id=&governorate_id=&salesman='.$row->salesman_id.'&status=yes','<span class="isb-print"></span>',array('target'=>'_blank'))?></td>
                                <td style="text-align:center" class="btn-success"><?=anchor('tasks/print-details-acc?area_id=&district_id=&governorate_id=&salesman='.$row->salesman_id.'&status=yes','<span class="isb-print"></span>',array('target'=>'_blank'))?></td>

                            </tr>
                            
                        <?php } }
						else{
								echo '<tr>
                            	<td colspan="7"><center><strong>No Data Found</strong></center></td>
                            </tr>';
							}
						
						?>    
                        </tbody>
                        <tfoot>
                        	<tr>
                                <td colspan="7">Total : <?=$total_row?><div class="dataTables_paginate paging_full_numbers"><?=$links?></div></td></tr>
                        </tfoot>
                    </table>
                    
                </div>
                <?php echo form_close();?>
            