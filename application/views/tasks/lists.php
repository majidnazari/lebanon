
<script language="javascript">



    function ShowDeliveryDate(value,id)
    {
        if(value=='done')
        {
            $("#delivery"+id).show();
        }
        else{
            $("#delivery"+id).hide();
        }

    }

    function change_status(id,status)
    {
        $("#status-area-"+id).html("loading ... ");
        $.ajax({
            url: "<?php echo base_url();?>companies/change_status",
            type: "post",
            data: "id="+id+"&status="+status,
            success: function(result){
                $("#status-area-"+id).html(result);
            }
        });
    }
    function GetDistrictsBySalesman(id)
    {
        $("#salesdistrict").html("loading ... ");
        $.ajax({
            url: "<?php echo base_url();?>tasks/GetDistrictsBySalesman",
            type: "post",
            data: "id="+id,
            success: function(result){
                $("#salesdistrict").html(result);
            }
        });
    }
    function getdistrict(gov_id,district_id)
    {
        $("#datadistrict").html("loading ... ");
        $.ajax({
            url: "<?php echo base_url();?>companies/GetDistricts",
            type: "post",
            data: "id="+gov_id+"&district_id="+district_id,
            success: function(result){
                $("#datadistrict").html(result);
            }
        });
    }
    function getarea(district_id)
    {
        $("#area").html("loading ... ");
        $.ajax({
            url: "<?php echo base_url();?>companies/GetArea",
            type: "post",
            data: "id="+district_id,
            success: function(result){
                $("#area").html(result);
            }
        });
    }
    $(function () {
        $(".delivery-date").hide();
        $(".select2").select2();
        $(".datep").datepicker({
            dateFormat: "yy-mm-dd"
        });
    })

    $(document).ready(function () {
        $("#company").select2({
            <?php if(count(@$company_array)>0){ ?>
            initSelection: function(element, callback) {
                callback({id: <?=$company_array['id']?>, text: "<?=$company_array['name_ar']?>" });
            },
            <?php } ?>
            placeholder: 'اختر الشركة',
            allowClear: true,
            ajax: {
                url: "<?=base_url()?>tasks/GetCompanies",
                dataType: 'json',
                delay: 250,
                data: function (query) {
                    if (!query) query = 'Москва';

                    return {
                        geocode: query,
                        format: 'json'
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                results: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });
    });

</script>

<?php
$array_name=array('id'=>'name','name'=>'name','value'=>@$name);
$array_id=array('id'=>'id','name'=>'id','value'=>@$id);

$array_phone=array('id'=>'phone','name'=>'phone','value'=>@$phone);

$array_activity=array('id'=>'activity','name'=>'activity','value'=>@$activity);
if(@$districtID=='')
    $districtID=0;
$class_sect=' class="select2" id="sector_id" onchange="getdistrict(this.value,'.$district.')" ';
$class_sect1=' class="validate[required]"  required="required" id="sector" onchange="getsection1(this.value,0)"';
$class_sect2=' class="validate[required]"  required="required" id="sector2" onchange="getsection2(this.value,0)"';

?>
<script language="JavaScript" type="text/JavaScript">

    function printall()
    {
        checkboxes = document.getElementsByName('checkall');
        checkboxes.checked =true;
        document.getElementById("form_id").target = "_blank";
        document.getElementById("form_id").action = "<?=base_url().'companies/printall'?>";
        document.getElementById("form_id").submit();

    }

    function printarea()
    {
        checkboxes = document.getElementsByName('checkall');
        checkboxes.checked =true;
        //document.getElementById("form_id").target = "_blank";
        document.getElementById("form_id").action = "<?=base_url().'companies/task_create'?>";
        document.getElementById("form_id").submit();

    }
</script>
<style type="text/css">
    .sub-link{
        padding-left:10px !important;
    }
</style>
<div class="content">
    <?=$this->load->view("includes/_bread")?>
    <div class="workplace">
        <div class="page-header">
            <h1><?=$subtitle;?></h1>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <div class="head clearfix">
                    <div class="isw-zoom"></div>
                    <h1>Search</h1>
                    <ul class="buttons">
                        <li>&nbsp;<?=anchor('tasks/lists?ref='.@$ref.'&company='.@$company_id.'&governorate='.@$governorate_id.'&district='.@$district_id.'&area='.@$area_id.'&list='.@$list.'&sales_man='.@$sales_man.'&year='.@$year.'&from_start='.@$from_start.'&to_start='.@$to_start.'&from_due='.@$from_due.'&to_due='.@$to_due.'&status='.@$status.'&category='.@$category.'&search=Search','<h3>Print List</h3>',array('target'=>'_blank'))?>&nbsp;</li>
                        <li>&nbsp;<?=anchor('tasks/print_all?ref='.@$ref.'&company='.@$company_id.'&governorate='.@$governorate_id.'&district='.@$district_id.'&area='.@$area_id.'&list='.@$list.'&sales_man='.@$sales_man.'&year='.@$year.'&from_start='.@$from_start.'&to_start='.@$to_start.'&from_due='.@$from_due.'&to_due='.@$to_due.'&status='.@$status.'&category='.@$category.'&search=Search','<h3>Print All</h3>',array('target'=>'_blank'))?>&nbsp;</li>
                    </ul>
                </div>
                <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'validation','method'=>'get'));?>
                <div class="block-fluid">
                    <div class="row-form clearfix">
                        <div class="span2">List number : <br /><?php echo form_input(array('name'=>'list','value'=>@$list)); ?></div>
                        <div class="span2">Company Name (اسم الشركة)<br /><?=form_dropdown('company',@$array_companies,@$company,'id="company" style="width:100% !important"'); ?></div>
                        <div class="span2">Sales Man<br /><?php
                            $array_sales_men=array(''=>'Select');
                            foreach($sales as $salesman){

                                $array_sales_men[$salesman->id]=$salesman->fullname;
                            }

                            echo form_dropdown('sales_man',$array_sales_men,@$sales_man,' class="select2" style="width:100% !important"'); ?></div>
                        <div class="span3">Start Date
                            <div class="span12">
                                <div class="span6"><?php echo form_input(array('name'=>'from_start','value'=>@$from_start,'class'=>'datep','placeholder'=>'From')); ?></div>
                                <div class="span6"><?php echo form_input(array('name'=>'to_start','value'=>@$to_start,'class'=>'datep','placeholder'=>'To')); ?></div>
                            </div>
                        </div>
                        <div class="span3">Due Date
                            <div class="span12">
                                <div class="span6"><?php echo form_input(array('name'=>'from_due','value'=>@$from_due,'class'=>'datep','placeholder'=>'From')); ?></div>
                                <div class="span6"><?php echo form_input(array('name'=>'to_due','value'=>@$to_due,'class'=>'datep','placeholder'=>'To')); ?></div>
                            </div>
                        </div>

                    </div>


                    <div class="row-form clearfix">
                        <div class="span2">Mohafaza<br /><?php
                            $array_governorates[0]='All ';
                            foreach($governorates as $governorate)
                            {
                                if($governorate->id!=0)
                                    $array_governorates[$governorate->id]=$governorate->label_ar;
                            }

                            echo form_dropdown('gov',$array_governorates,@$governorate_id,$class_sect);
                            ?>
                        </div>

                        <div class="span2">Kazaa (القضاء)<br />
                            <div id="datadistrict">
                                <?php
                                $array_district[0]='All ';
                                foreach($districts as $district)
                                {
                                    if($district->id!=0)
                                        $array_district[$district->id]=$district->label_ar;
                                }

                                echo form_dropdown('district_id',$array_district,@$district_id,'  onchange="getarea(this.value)" class="select2"');
                                ?>
                            </div>
                        </div>
                        <div class="span2">City (المنطقة)<br />
                            <div id="area">
                                <?php
                                $array_area[0]='All ';
                                foreach($areas as $area)
                                {
                                    if($area->id!=0)
                                        $array_area[$area->id]=$area->label_ar;
                                }

                                echo form_dropdown('area_id',$array_area,@$area_id,' class="select2"');
                                ?>
                            </div>
                        </div>

                        <div class="span2">Status<br /><?php $array_status=array(''=>'Any','done'=>'Done','pending'=>'Pending','canceled'=>'Canceled');
                            echo form_dropdown('status',$array_status,$status);
                            ?></div>
                        <div class="span2">Category<br /><?php $array_categories=array(''=>'Any','scanning'=>'Scanning','delivery'=>'Delivery');
                            echo form_dropdown('category',$array_categories,@$category);
                            ?></div>
                        <div class="span2"><br /><input type="submit" name="search" value="Search" class="btn">
                            <input type="submit" name="clear" value="Clear" class="btn">
                        </div>
                    </div>
                </div>
                <?=form_close()?>
            </div>
        </div>
        <script>
            function SubmitForm(id)
            {
                document.getElementById("form_id").action = "<?=base_url().'tasks/update_status/'?>"+id;
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
                <?php

                ?>

                <div class="head clearfix">
                    <div class="isw-grid"></div>
                    <h1><?=$subtitle?></h1>
                    <a href="#DistrictModal" data-toggle="modal"><h2 style="float: right">Change Salesman By Kazaa</h2></a>&nbsp;
                </div>
                <div class="block-fluid table-sorting clearfix">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                        <tr>
                            <th style="text-align:center" rowspan="2">List#</th>
                            <th style="text-align:center" rowspan="2"  width="15%">Sales Man</th>
                            <th style="text-align:center" rowspan="2" width="10%">Mohafaza </th>
                            <th style="text-align:center" rowspan="2" width="10%">Kazaa</th>
                            <th style="text-align:center" rowspan="2" width="10%">Area</th>
                            <th style="text-align:center" rowspan="2"  width="10%">Start Date</th>
                            <th style="text-align:center" rowspan="2" width="5%">Due Date</th>
                            <th style="text-align:center" colspan="3" width="5%">Pending</th>
                            <th style="text-align:center" colspan="2" width="5%">Done</th>
                            <th style="text-align:center" colspan="2" width="5%">Acc. Pending</th>
                            <th style="text-align:center" colspan="2" width="5%">Acc. Done</th>
                            <th style="text-align:center" rowspan="2" width="5%">Actions</th>
                        </tr>
                        <tr>
                            <th>View</th>
                            <th>Print</th>
                            <th>Change Salesman</th>
                            <th>View</th>
                            <th>Print</th>
                            <th>View</th>
                            <th>Print</th>
                            <th>View</th>
                            <th>Print</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if(count($query)>0){
                            foreach($query as $row){
                                $acc=$this->Task->GetAccCompanies($row->sales_man_id,$row->governorate_id,$row->district_id,$row->area_id);
                                
                                ?>
                                
                                
                                <tr>
                                    <td><?=$row->list_id?></td>
                                    <td><?=$row->sales_man_ar?></td>
                                    <td><?=$row->governorate_ar?></td>
                                    <td><?=$row->district_ar?></td>
                                    <td><?=$row->area_ar?></td>
                                    <td><?=$row->start_date?></td>
                                    <td><?=$row->due_date?></td>
                                  <!--  <td><span class="btn btn-mini btn-warning"><?=$row->pending_count ?></span></td> -->
                                    <td><?=anchor('tasks/showPendingTask?area_id='.$row->area_id.'&district_id='.$row->district_id.'&governorate_id='.$row->governorate_id.'&salesman='.$row->sales_man_id.'&status=pending',$row->pending_count,array('class'=>'btn btn-mini btn-warning'))?></td>
                                    <td><a href="#<?=$row->governorate_id.'-'.$row->district_id.'-'.$row->area_id?>PendingListModal" data-toggle="modal"><span class="isb-print"></span></a></td>
                                    <td><a onclick="GetTaskDetailsDetails(<?=$row->list_id?>,<?=$row->sales_man_id?>)">Change</a></td>
                                    <td><?=anchor('tasks/details?list='.$row->list_id.'&salesman='.$row->sales_man_id.'&status=done',$row->done_count,array('class'=>'btn btn-mini btn-success'))?></td>
                                    <td><a href="#<?=$row->governorate_id.'-'.$row->district_id.'-'.$row->area_id?>DoneListModal" data-toggle="modal"><span class="isb-print"></span></a></td>

                                    <td><?=anchor('tasks/acc?area_id='.$row->area_id.'&district_id='.$row->district_id.'&governorate_id='.$row->governorate_id.'&salesman='.$row->sales_man_id.'&status=no',$acc[0]->acc_pending,array('class'=>'btn btn-mini btn-warning'))?></td>
                                    <td><a href="#<?=$row->governorate_id.'-'.$row->district_id.'-'.$row->area_id?>PendingListACCModal" data-toggle="modal"><span class="isb-print"></span></a></td>
                                    <td><?=anchor('tasks/acc?area_id='.$row->area_id.'&district_id='.$row->district_id.'&governorate_id='.$row->governorate_id.'&salesman='.$row->sales_man_id.'&status=yes',$acc[0]->acc_done,array('class'=>'btn btn-mini btn-success'))?></td>
                                    <td><a href="#<?=$row->governorate_id.'-'.$row->district_id.'-'.$row->area_id?>DoneListACCModal" data-toggle="modal"><span class="isb-print"></span></a></td>

                                    <td nowrap="nowrap">
                                        <?php
                                       // echo anchor('tasks/listview/'.$row->list_id.'/'.$row->sales_man_id.'/','<span class="isb-print"></span>',array('target'=>'_blank'));
                                        echo _show_delete('tasks/delete_all_list/'.$row->list_id.'/'.$row->sales_man_id,$p_delete);

                                        ?>
                                    </td>
                                </tr>
                                <div id="<?=$row->governorate_id.'-'.$row->district_id.'-'.$row->area_id?>PendingListModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h3 id="myModalLabel">Pending Print</h3>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="block-fluid">
                                            <div class="row-form clearfix">
                                                <div class="span6"><?=anchor('tasks/listview/'.$row->list_id.'/'.$row->sales_man_id.'/pending','<h3>Print List</h3>',array('target'=>'_blank'));?></div>
                                                <div class="span6"><?=anchor('tasks/print_all?company='.@$company_id.'&list='.@$row->list_id.'&sales_man='.@$row->sales_man_id.'&year='.@$year.'&from_start='.@$from_start.'&to_start='.@$to_start.'&from_due='.@$from_due.'&to_due='.@$to_due.'&status=pending&category='.@$category.'&search=Search','<h3>Print All</h3>',array('target'=>'_blank'))?></div>
                                            </div>
                                        </div>
                                        <div class="dr"><span></span></div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                                    </div>
                                </div>
                                <div id="<?=$row->governorate_id.'-'.$row->district_id.'-'.$row->area_id?>DoneListModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h3 id="myModalLabel">Done Print</h3>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="block-fluid">
                                            <div class="row-form clearfix">
                                                <div class="span6"><?=anchor('tasks/listview/'.$row->list_id.'/'.$row->sales_man_id.'/done','<h3>Print List</h3>',array('target'=>'_blank'));?></div>
                                                <div class="span6"><?=anchor('tasks/print_all?company='.@$company_id.'&list='.@$row->list_id.'&sales_man='.@$row->sales_man_id.'&year='.@$year.'&from_start='.@$from_start.'&to_start='.@$to_start.'&from_due='.@$from_due.'&to_due='.@$to_due.'&status=done&category='.@$category.'&search=Search','<h3>Print All</h3>',array('target'=>'_blank'))?></div>
                                            </div>
                                        </div>
                                        <div class="dr"><span></span></div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                                    </div>
                                </div>
                                <div id="<?=$row->governorate_id.'-'.$row->district_id.'-'.$row->area_id?>DoneListACCModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h3 id="myModalLabel">Done ACC Print</h3>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="block-fluid">
                                            <div class="row-form clearfix">
                                               <div class="span6"><?=anchor('tasks/lis_acc?area_id='.$row->area_id.'&district_id='.$row->district_id.'&governorate_id='.$row->governorate_id.'&salesman='.$row->sales_man_id.'&status=yes','<h3>Print List</h3>',array('target'=>'_blank'));?></div>
                                                <div class="span6"><?=anchor('tasks/print_all_acc?company='.@$company_id.'&list='.@$row->list_id.'&sales_man='.@$row->sales_man_id.'&area_id='.$row->area_id.'&district_id='.$row->district_id.'&governorate_id='.$row->governorate_id.'&year='.@$year.'&from_start='.@$from_start.'&to_start='.@$to_start.'&from_due='.@$from_due.'&to_due='.@$to_due.'&status=yes&category='.@$category.'&search=Search','<h3>Print All</h3>',array('target'=>'_blank'))?></div>
                                            </div>
                                        </div>
                                        <div class="dr"><span></span></div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                                    </div>
                                </div>
                                <div id="<?=$row->governorate_id.'-'.$row->district_id.'-'.$row->area_id?>PendingListACCModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h3 id="myModalLabel">Pending ACC Print</h3>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="block-fluid">
                                            <div class="row-form clearfix">
                                               <div class="span6"><?=anchor('tasks/lis_acc?area_id='.$row->area_id.'&district_id='.$row->district_id.'&governorate_id='.$row->governorate_id.'&salesman='.$row->sales_man_id.'&status=no','<h3>Print List</h3>',array('target'=>'_blank'));?></div>
                                                <div class="span6"><?=anchor('tasks/print_all_acc?company='.@$company_id.'&list='.@$row->list_id.'&sales_man='.@$row->sales_man_id.'&area_id='.$row->area_id.'&district_id='.$row->district_id.'&governorate_id='.$row->governorate_id.'&year='.@$year.'&from_start='.@$from_start.'&to_start='.@$to_start.'&from_due='.@$from_due.'&to_due='.@$to_due.'&status=no&category='.@$category.'&search=Search','<h3>Print All</h3>',array('target'=>'_blank'))?></div>
                                            </div>
                                        </div>
                                        <div class="dr"><span></span></div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                                    </div>
                                </div>
                                <?php
                            } }
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
            </div>
        </div>
        <div class="dr"><span></span></div>
    </div>
</div>
<?php
echo form_open('tasks/task_district_update',array('id'=>'form_id','name'=>'form1'));
?>
<div id="DistrictModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Change Salesman</h3>
    </div>
    <div class="row-fluid">
        <div class="block-fluid">
            <div class="row-form clearfix">
                <div class="span3">Old Salesman :</div>
                <div class="span9"><?php
                    foreach($sales as $man)
                    {
                        $array_salesman[$man->id]=$man->fullname;
                    }

                    echo form_dropdown('old_salesman',$array_salesman,'',' onchange="GetDistrictsBySalesman(this.value)" class="select2" style="width:100% !important"');
                    ?>
                </div>
            </div>
            <div class="row-form clearfix">
                <div class="span3">Kazaa :</div>
                <div class="span9" id="salesdistrict"><?php
                    echo form_dropdown('district_id',array());
                    ?>
                </div>
            </div>
            <div class="row-form clearfix">
                <div class="span3">New Salesman :</div>
                <div class="span9"><?php
                    foreach($sales as $man)
                    {
                        $array_salesman[$man->id]=$man->fullname;
                    }

                    echo form_dropdown('salesman',$array_salesman,'','class="select2" style="width:100% !important"');
                    ?>
                </div>
            </div>

        </div>
        <div class="dr"><span></span></div>
    </div>
    <div class="modal-footer">
        <?=form_submit(array('name'=>'save','value'=>'Save','class'=>'btn'))?>
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    </div>
</div>
<?=form_close()?>
<div id="ChangeSalesModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <?php echo form_open('tasks/task_update',array('id'=>'form_id','name'=>'form1'));?>
<input type="hidden" id="Elist" name="old_list" />
<input type="hidden" id="Esalesman" name="old_sales" />
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Change Salesman</h3>
    </div>
    <div class="row-fluid">
        <div class="block-fluid">

            <div class="row-form clearfix">
                <div class="span3">Assign To :</div>
                <div class="span9"><?php
                    foreach($sales as $man)
                    {
                        $array_salesman[$man->id]=$man->fullname;
                    }

                    echo form_dropdown('salesman',$array_salesman,'');
                    ?>
                </div>
            </div>

        </div>
        <div class="dr"><span></span></div>
    </div>
    <div class="modal-footer">
        <?=form_submit(array('name'=>'save','value'=>'Save','class'=>'btn'))?>
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    </div>
    <?=form_close()?>
</div>
<script type="text/javascript">
    function GetTaskDetailsDetails(list,salesman)
    {
        $("#Elist").val(list);
        $("#Esalesman").val(salesman);
        $("#ChangeSalesModal").modal('show');
        return false;
    }
</script>

