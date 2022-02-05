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
        <?php echo form_open('',array('id'=>'form_id','name'=>'form1'));

        ?>

        <div class="head clearfix">
            <div class="isw-grid"></div>
            <h1><?=$subtitle?></h1>
            <?php if($list!='' and $sales_man!='')
            {
                $all_list = $this->Task->GetListTasks('','', '', '', '', @$list, @$sales_man, '', '','', '', '','','scanning', 0, 0);
                $query_list=$all_list['results'];
                ?>
                <ul class="buttons">
                    <li><?=anchor('tasks/details?list='.$list.'&salesman='.$sales_man.'&status=pending',$query_list[0]->pending_count,array('class'=>'btn btn-warning'));?>&nbsp;</li>
                    <li><?=anchor('tasks/details?list='.$list.'&salesman='.$sales_man.'&status=done',$query_list[0]->done_count,array('class'=>'btn btn-success'));?></li>
                    <li><a href="#StatusModalAll" data-toggle="modal"><h2>Update Selected Status</h2></a></li>
                </ul>
         <?php   } ?>
        </div>
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
                if($row->status=='pending')
                {
                    $status_css='btn btn-mini btn-warning';
                }
                elseif($row->status=='done')
                {
                    $status_css='btn btn-mini btn-success';
                }
                elseif($row->status=='canceled'){
                    $status_css='btn btn-mini btn-danger';
                }
                else{
                    $status_css='btn btn-mini';
                }
                ?>
                <tr>
                    <td><input type="checkbox" id="check" name="checkbox1[]" value="<?=$row->id?>"/><?=$row->company_id?></td>
                    <td><?=anchor('companies/details/'.$row->company_id,$row->company_ar)?></td>
                    <td><?=$row->sales_man_ar?></td>
                    <td><?=$row->list_id?></td>
                     <td><?=$row->category?></td>
                    <td><?=$row->governorate_ar?></td>
                    <td><?=$row->district_ar?></td>
                    <td><?=$row->area_ar?></td>
                    <td><?=$row->start_date?></td>
                    <td><?=$row->due_date?></td>
                    <td><?=$row->delivery_date?></td>
                    <td><a href="#StatusModal<?=$row->id?>" data-toggle="modal" class="<?=$status_css?>"><?=$row->status?></a></td>
                    <td><?=anchor('tasks/logs?id='.$row->id,'View',array('target'=>'_blank'));?></td>
                    <td nowrap="nowrap">

                        <?php
                        echo anchor('tasks/view/'.$row->company_id.'/'.$row->id,'<span class="isb-print"></span>',array('target'=>'_blank'));

                        echo _show_delete('tasks/delete/'.$row->id.'/company/',$p_delete);
                        echo _show_edit('tasks/edit/'.$row->id,$p_edit);

                        ?>
                    </td>
                </tr>
                <div id="StatusModal<?=$row->id?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 id="myModalLabel">Update Status</h3>
                    </div>
                    <div class="row-fluid">
                        <div class="block-fluid">

                            <div class="row-form clearfix">
                                <div class="span3">Status :</div>
                                <div class="span9">
                                    <?php $array_status=array(''=>'Any','done'=>'Done','pending'=>'Pending','canceled'=>'Canceled');
                                    echo form_dropdown('status'.$row->id,$array_status,$row->status,' onchange="ShowDeliveryDate(this.value,'.$row->id.')"');
                                    ?>

                                </div>
                            </div>
                            <div class="row-form clearfix delivery-date" id="delivery<?=$row->id?>">
                                <div class="span3">Delivery Date :</div>
                                <div class="span9"><?=form_input(array('name'=>'delivery_date'.$row->id,'class'=>'datep'));?>
                                </div>
                            </div>
                            <div class="dr"><span></span></div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span3">Note :</div>
                            <div class="span9">
                                <?=form_textarea(array('name'=>'note'.$row->id));?>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="javascript:void(0)" onclick="SubmitForm(<?=$row->id?>)" class="btn">Save</a>
                            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                        </div>
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
        <?php echo form_close();?>
    </div>
</div>