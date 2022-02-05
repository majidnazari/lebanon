<script>
    function SubmitFormAll()
    {
        document.getElementById("form_id").action = "<?=base_url().'tasks/update_selected_status/'?>";
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
        <?php echo form_open('',array('id'=>'form_id','name'=>'form1')); ?>
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
        <?=form_close()?>
        <div class="block-fluid table-sorting clearfix">
            <div id="StatusModalAll" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Update Selected Status</h3>
                </div>
                <div class="row-fluid">
                    <div class="block-fluid">

                        <div class="row-form clearfix">
                            <div class="span3">Status :</div>
                            <div class="span9">
                                <?php $array_status=array(''=>'Any','done'=>'Done','pending'=>'Pending','canceled'=>'Canceled');
                                echo form_dropdown('status_all',$array_status,'',' onchange="ShowDeliveryDate(this.value,0)"');
                                ?>

                            </div>
                        </div>
                        <div class="row-form clearfix delivery-date" id="delivery0">
                            <div class="span3">Delivery Date :</div>
                            <div class="span9"><?=form_input(array('name'=>'delivery_date_all','class'=>'datep'));?>
                            </div>
                        </div>
                        <div class="dr"><span></span></div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span3">Note :</div>
                        <div class="span9">
                            <?=form_textarea(array('name'=>'note_all'));?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:void(0)" onclick="SubmitFormAll()" class="btn">Save</a>
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                    </div>
                </div>
            </div>
                <table cellpadding="0" cellspacing="0" width="100%" class="table">
                <thead>
                <tr>
                    <th><input type="checkbox" name="checkall"/></th>
                    <th style="text-align:center"  width="10%">Company</th>
                    <th style="text-align:center"  width="15%">Sales Man</th>
                    <th style="text-align:center"  width="15%">Delivery By</th>
                    <th style="text-align:center"  width="5%">List</th>
                    <th style="text-align:center"  width="5%">Category</th>
                    <th style="text-align:center" width="10%">Mohafaza </th>
                    <th style="text-align:center" width="10%">Kazaa</th>
                    <th style="text-align:center" width="10%">Area</th>
                    <th style="text-align:center"  width="10%">Start Date</th>
                    <th style="text-align:center" width="5%">Due Date</th>
                    <th style="text-align:center" width="5%">Delivery Date</th>
                    <th style="text-align:center" width="5%"> Status</th>
                    <th  width="20%">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(count($query)>0){
                foreach($query as $row){
                if($row->DeliveryStatus=='pending')
                {
                    $status_css='btn btn-mini btn-warning';
                }
                elseif($row->DeliveryStatus=='done')
                {
                    $status_css='btn btn-mini btn-success';
                }
                elseif($row->DeliveryStatus=='canceled'){
                    $status_css='btn btn-mini btn-danger';
                }
                else{
                    $status_css='btn btn-mini';
                }
                ?>
                <tr>
                    <td><input type="checkbox" id="check" name="checkbox1[]" value="<?=$row->DeliveryItemId?>"/><?=$row->id?></td>
                    <td><?=anchor('companies/details/'.$row->id,$row->name_ar)?></td>
                    <td><?=$row->salesman?></td>
                    <td><?=$row->DeliverySales?></td>
                    <td><?=$row->DeliveryId?></td>
                     <td><?=$row->DeliveryItemType?></td>
                    <td><?=$row->governorate_ar?></td>
                    <td><?=$row->district_ar?></td>
                    <td><?=$row->area_ar?></td>
                    <td><?=$row->DeliveryStartDate?></td>
                    <td><?=$row->DeliveryEndDate?></td>
                    <td><?=$row->delivery_date?></td>
                    <td><a href="#StatusModal<?=$row->id?>" data-toggle="modal" class="<?=$status_css?>"><?=$row->DeliveryStatus?></a></td>
                    <td nowrap="nowrap">

                        <?php
                        echo anchor('delivery/view/'.$row->id.'/'.$row->id,'<span class="isb-print"></span>',array('target'=>'_blank'));

                        echo _show_delete('delivery/delete/'.$row->DeliveryItemId.'/items/',$this->p_delivery_delete);
                       // echo _show_edit('delivery/edit/'.$row->DeliveryItemId,$this->p_delivery_edit);

                        ?>
                    </td>
                </tr>
                <?php echo form_open_multipart('delivery/update_delivery/'.$row->DeliveryItemId);
                    echo form_hidden('item_type',$row->DeliveryItemType);
                    echo form_hidden('item_id',$row->id);
                ?>
                <div id="StatusModal<?=$row->id?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 id="myModalLabel">Update Status</h3>
                    </div>
                    <div class="row-fluid">
                        <div class="block-fluid">

                            <div class="row-form clearfix">
                                <div class="span3">Status :</div>
                                <div class="span3">
                                    <?php $array_status=array('done'=>'Done','pending'=>'Pending','canceled'=>'Canceled');
                                    echo form_dropdown('status',$array_status,$row->DeliveryStatus,' onchange="ShowDeliveryDate(this.value,'.$row->id.')"');
                                    ?>
                                </div>
                                <div class="span3">Paid :</div>
                                <div class="span3">
                                    <?php $array_paid=array('paid'=>'Paid','unpaid'=>'Unpaid');
                                    echo form_dropdown('paid_status',$array_paid,@$row->PaidStatus);
                                    ?>
                                </div>
                            </div>
                            <div class="row-form clearfix">
                                <div class="span3">Delivery By:</div>
                                <div class="span9">
                                    <?php
                                    $array_salesm=array(''=>'Any');
                                    foreach($sales as $salesm)
                                    {
                                       $array_salesm[$salesm->id]=$salesm->fullname; 
                                    }
                                    
                                    echo form_dropdown('delivery_man_id',$array_salesm, ($row->DeliveryManId>0) ? $row->DeliveryManId : $row->salesman_id);
                                    ?>
                                </div>
                            </div>
                           
                            <div class="row-form clearfix">
                                <div class="span3">Delivery Date :</div>
                                <div class="span9"><?=form_input(array('name'=>'receiver_date','value'=>@$row->ReceiverDate,'class'=>'datep'));?>
                                </div>
                            </div>
                            <div class="dr"><span></span></div>
                        </div>
                         <div class="row-form clearfix">
                                <div class="span3">Receiver Name :</div>
                                <div class="span9">
                                    <?=form_input(array('name'=>'receiver_name','id'=>'receiver_name','value'=>@$row->ReceiverName));?>
                                </div>
                            </div>
                        <div class="row-form clearfix">
                                <div class="span3">Copy Quantity :</div>
                                <div class="span9">
                                    <?=form_input(array('name'=>'copy_quantity','id'=>'copy_quantity','value'=>(@$row->CopyQuantity>0) ? @$row->CopyQuantity : 1));?>
                                </div>
                            </div>  
                        <div class="row-form clearfix">
                            <div class="span3">Document </div><div class="span9"><?=anchor('documents/index/'.$row->id.'/company','Upload Attachments',array('target'=>'_blank'))?></div>
                    </div>          
                        <div class="row-form clearfix">
                            <div class="span3">Note :</div>
                            <div class="span9">
                                <?=form_textarea(array('name'=>'note','value'=>@$row->DeliveryNotes));?>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <?=form_submit(array('name'=>'save','value'=>'Save','class'=>'btn'))?>
                            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                        </div>
                    </div>
                
                </div>
                <?php echo form_close();?>
                    <?php
                    } }
                    else{
                        echo '<tr>
                            	<td colspan="14"><center><strong>No Data Found</strong></center></td>
                            </tr>';
                    }

                    ?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="14">Total : <?=$total_row?><div class="dataTables_paginate paging_full_numbers"><?=$links?></div></td></tr>
                </tfoot>
            </table>
    </div>
</div>