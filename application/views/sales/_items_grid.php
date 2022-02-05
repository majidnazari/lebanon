<script>
    function SubmitFormAll()
    {
        document.getElementById("form_id").action = "<?=base_url().'sales/update/'?>";
        document.getElementById("form_id").submit();

    }
</script>
<div class="row-fluid">
    <div class="span12">
        <?php if($msg!=''){ ?>
            <div class="alert alert-success">
                <?php echo $msg;?>
            </div>
        <?php } ?>


        <div class="head clearfix">
            <div class="isw-grid"></div>
            <h1><?=$subtitle?></h1>
            <?php if(@$list!='' and $sales_man!='')
            {
                $all_list = $this->Task->GetListTasks('','', '', '', '', @$list, @$sales_man, '', '','', '', '','','scanning', 0, 0);
                $query_list=$all_list['results'];
                ?>
                <ul class="buttons">
                    <li><?=anchor('tasks/details?delivery_id='.$delivery_id.'&salesman='.$sales_man.'&status=pending',$query_list[0]->pending_count,array('class'=>'btn btn-warning'));?>&nbsp;</li>
                    <li><?=anchor('tasks/details?delivery_id='.$delivery_id.'&salesman='.$sales_man.'&status=done',$query_list[0]->done_count,array('class'=>'btn btn-success'));?></li>
                    <li><a href="#StatusModalAll" data-toggle="modal"><h2>Update Selected Status</h2></a></li>
                </ul>
         <?php   } ?>
        </div>
        <div class="block-fluid table-sorting clearfix">
                <table cellpadding="0" cellspacing="0" width="100%" class="table">
                <thead>
                <tr>
                    <th><input type="checkbox" name="checkall"/></th>
                    <th style="text-align:center"  width="10%">Company</th>
                   <!-- <th style="text-align:center"  width="15%">Sales Man</th>-->
                    <th style="text-align:center"  width="15%">Sales Task</th>
                    <th style="text-align:center"  width="5%">List</th>
                    <th style="text-align:center"  width="5%">Category</th>
                    <th style="text-align:center" width="10%">Mohafaza </th>
                    <th style="text-align:center" width="10%">Kazaa</th>
                    <th style="text-align:center" width="10%">Area</th>
                    <th style="text-align:center"  width="10%">Start Date</th>
                    <th style="text-align:center" width="5%">Due Date</th>
                    <th style="text-align:center" width="5%">Delivery Date</th>
                    <th style="text-align:center" width="5%"> Status</th>
                    <th style="text-align:center" width="5%"> Logs</th>
                    <th  width="20%">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(count($query)>0){
                foreach($query as $row){
                if($row->SalesStatus=='pending')
                {
                    $status_css='btn btn-mini btn-warning';
                }
                elseif($row->SalesStatus=='done')
                {
                    $status_css='btn btn-mini btn-success';
                }
                elseif($row->SalesStatus=='canceled'){
                    $status_css='btn btn-mini btn-danger';
                }
                else{
                    $status_css='btn btn-mini';
                }
                ?>
                <tr>
                    <td><input type="checkbox" id="check" name="checkbox1[]" value="<?=$row->id?>"/><?=$row->id?></td>
                    <td><?=anchor('companies/details/'.$row->id,$row->name_ar)?></td>
                   <?php /* <td><?=$row->salesman?></td> */?>
                    <td><?=$row->TaskSales?></td>
                    <td><?=$row->SalesId?></td>
                     <td><?=$row->SalesItemType?></td>
                    <td><?=$row->governorate_ar?></td>
                    <td><?=$row->district_ar?></td>
                    <td><?=$row->area_ar?></td>
                    <td><?=$row->StartDate?></td>
                    <td><?=$row->EndDate?></td>
                    <td><?=$row->SalesNotes?></td>
                    <td><a href="#StatusModal<?=$row->id?>" data-toggle="modal" class="<?=$status_css?>"><?=ucfirst($row->SalesStatus)?></a></td>
                    <td><?=anchor('tasks/logs?id='.$row->id,'View',array('target'=>'_blank'));?></td>
                    <td nowrap="nowrap">

                        <?php
                        echo anchor('sales/view/'.$row->id.'/'.$row->id,'<span class="isb-print"></span>',array('target'=>'_blank'));

                        echo _show_delete('sales/delete/'.$row->SalesItemId.'/items/',@$this->p_delete);

                        ?>
                    </td>
                </tr>
                <div id="StatusModal<?=$row->id?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <?php echo form_open('sales/update/'.$row->SalesItemId); ?>
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 id="myModalLabel">Update Status</h3>
                    </div>
                    <div class="row-fluid">
                        <div class="block-fluid">
                            <?=form_hidden('item_type',$row->SalesItemType)?>
                            <?=form_hidden('item_id',$row->id)?>
                            <?=form_hidden('sales_id',$row->SalesId)?>
                            <?=form_hidden('id',$row->SalesItemId)?>
                            <div class="row-form clearfix">
                                <div class="span3">Status :</div>
                                <div class="span3">
                                    <?php 
                                    $array_status=array(''=>'Any','done'=>'Done','pending'=>'Pending','cancel'=>'Canceled');
                                    echo form_dropdown('status',$array_status,$row->SalesStatus,' onchange="ShowDeliveryDate(this.value,'.$row->id.')"');
                                    ?>

                                </div>
                                <div class="span3">Paid :</div>
                                <div class="span3">
                                    <?php $array_paid=array('paid'=>'Paid','unpaid'=>'Unpaid');
                                    echo form_dropdown('paid_status',$array_paid,@$row->paid_status);
                                    ?>
                                </div>
                            </div>
                           
                            <div class="row-form clearfix">
                                <div class="span3">Adv Salesman</div>
                                <div class="span9">
                                    <?php
                                    $sales_array = array(0 => 'اختر');
                                    if (count($sales) > 0) {
                                        foreach ($sales as $item) {

                                            $sales_array[$item->id] = $item->fullname;
                                        }
                                    }
                                    echo form_dropdown('advertisment', $sales_array, $row->Advertisment, 'style="direction:rtl"'); ?>

                                </div>
                            </div>
                            <div class="row-form clearfix">
                                <div class="span3">Copy Res. Salesman</div>
                                <div class="span9">
                                    <?php echo form_dropdown('copy_reservation', $sales_array, $row->CopyReservation, 'style="direction:rtl"'); ?>
                                </div>
                            </div>
                            <div class="row-form clearfix delivery-date" id="delivery<?=$row->id?>">
                                <div class="span3">Sales Date</div>
                                <div class="span9"><?=form_input(array('name'=>'due_date','class'=>'datep'));?>
                                </div>
                            </div>
                             <div class="row-form clearfix">
                                <div class="span3">Sales Note</div>
                                <div class="span9"><?=form_input(array('name'=>'note','value'=>@$row->SalesNotes));?></div>
                            </div>
                            
                        </div>
                      
                        <div class="row-form clearfix">
                                <div class="span3">Delivery List ID</div>
                                <div class="span3"><?=form_input(array('name'=>'delivery_id','value'=>@$row->delivery_id,'readonly'=>'readonly')) ?></div>
                                <div class="span3">Delivery Man</div>
                                <div class="span3">
                                    <?php echo form_dropdown('delivery_man', $sales_array, $row->delivery_man, 'style="direction:rtl"'); ?>
                                </div>
                            </div>
                      
                        <div class="row-form clearfix">
                                <div class="span3">Copy Quantity</div>
                                <div class="span3"><?=form_input(array('name'=>'copy_quantity','value'=>($row->delivery_copy_qty!='' ? $row->delivery_copy_qty:1))) ?></div>
                                <div class="span3">Delivery Status</div>
                                <div class="span3">
                                    <?php $array_status_delivery=array('done'=>'Done','pending'=>'Pending');
                                    echo form_dropdown('delivery_status',$array_status_delivery,($row->delivery_status!='' ? $row->delivery_status:'pending'));
                                    ?>

                                </div>
                            </div>    
                        <div class="row-form clearfix">
                                <div class="span3">Reciever Name</div>
                                <div class="span3"><?=form_input(array('name'=>'receiver_name','value'=>$row->receiver_name)) ?></div>
                            
                                <div class="span3">Reciever Date</div>
                                <div class="span3"><?=form_input(array('name'=>'receiver_date','class'=>'datep','value'=>($row->receiver_date!='0000-00-00 00:00:00' ? $row->receiver_date:''))) ?></div>
                        </div>
                        <div class="row-form clearfix">
                                <div class="span3">Delivery Notes</div>
                                <div class="span9"><?=form_input(array('name'=>'delivery_notes','value'=>$row->delivery_notes)) ?></div>
                        </div>
                         <div class="row-form clearfix">
                        <div class="span3">Document </div><div class="span9"><?=anchor('documents/index/'.$row->id.'/company','Upload Attachments',array('target'=>'_blank'))?></div>
</div>
                        <div class="modal-footer">
                            <?=form_submit(array('value'=>'Save','name'=>'save','class'=>'btn'))?>
                            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                        </div>
                    </div>
                    <?php echo form_close();?>
                </div>

                    <?php
                    } }
                    else{
                        echo '<tr>
                            	<td colspan="13"><center><strong>No Data Found</strong></center></td>
                            </tr>';
                    }

                    ?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="13">Total : <?=$total_row?><div class="dataTables_paginate paging_full_numbers"><?=$links?></div></td></tr>
                </tfoot>
            </table>

        </div>

    </div>
</div>