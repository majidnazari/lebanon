
<script language="javascript">
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



    function printpage(url)
    {
        for (var i = 2; i < 9; i++) {
            child = window.open(url+'/'+i, "", "height=1px, width=1px");  //Open the child in a tiny window.
            window.focus();  //Hide the child as soon as it is opened.
            child.print();  //Print the child.
            child.close();  //Immediately close the child.
        }
    }
</script>

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
                </div>
                <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'validation','method'=>'get'));?>
                <div class="block-fluid">
                    <div class="row-form clearfix">
                        <div class="span1">SalesID<br />
                            <?=form_input(array('name'=>'sales_id','id'=>'sales_id','value'=>@$sales_id));?>
                        </div>
                        <div class="span1">CompanyID<br />
                            <?=form_input(array('name'=>'company_id','id'=>'company_id','value'=>@$company_id));?>
                        </div>
                        <div class="span2">Sales Man<br /><?php
                            $array_sales['']='All ';
                            foreach($sales as $sales_row)
                            {
                                $array_sales[$sales_row->id]=$sales_row->fullname;
                            }
                            echo form_dropdown('salesman',$array_sales,@$salesman);
                            ?>
                        </div>
                        <div class="span2">Start Date<br />
                            <?=form_input(array('name'=>'start_date','id'=>'start_date','value'=>@$start_date,'class'=>'datep'));?>
                        </div>
                        <div class="span2">Due Date<br />
                            <?=form_input(array('name'=>'due_date','id'=>'due_date','value'=>@$due_date,'class'=>'datep'));?>
                        </div>
                        <div class="span2">Sales Date<br />
                            <?=form_input(array('name'=>'sales_date','id'=>'sales_date','value'=>@$sales_date,'class'=>'datep'));?>
                        </div>
                        <div class="span1">Status<br />
                            <?php $array_status=array(''=>'All','done'=>'Done','pending'=>'Pending','canceled'=>'Canceled');
                            echo form_dropdown('status',$array_status,$status);
                            ?></div>

                    </div>
                    <div class="row-form clearfix">
                        <div class="span1"><input type="submit" name="search" value="Search" class="btn"></div>
                        <div class="span1"><input type="submit" name="clear" value="Clear" class="btn"></div>
                    </div>
                </div>
                <?=form_close()?>
            </div>
        </div>
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
                    <ul class="buttons">
                        <li><?=anchor('sales/sales_list?id='.$salesman.'&start_date='.@$start_date.'&due_date='.@$due_date.'&delivery_date='.@$delivery_date.'&status='.@$status.'&search=Search','<h3>Print List</h3>',array('target'=>'_blank'))?></li>
                    </ul>
                </div>
                <div class="block-fluid table-sorting clearfix">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                        <tr>
                            <th style="text-align:center" width="5%" rowspan="2">Task ID#</th>
                            <th style="text-align:center"  width="12%" rowspan="2">Sales Man</th>
                            <th style="text-align:center"  width="10%" rowspan="2">Start Date</th>
                            <th style="text-align:center"  width="10%" rowspan="2">Due Date</th>
                            <th style="text-align:center"  width="10%" rowspan="2">Area</th>
                            <th style="text-align:center"  width="15%" colspan="4">All </th>
                            <th style="text-align:center" width="15%" colspan="4">Pending </th>
                            <th style="text-align:center" width="10%" colspan="4">Done</th>
                            <th style="text-align:center" width="10%" rowspan="2">Actions</th>
                        </tr>
                        <tr>
                            <th style="text-align:center">View</th>
                            <th style="text-align:center">List</th>
                            <th style="text-align:center">All</th>
                            <th style="text-align:center">Pages</th>
                            <th style="text-align:center">View</th>
                            <th style="text-align:center">List</th>
                            <th style="text-align:center">All</th>
                            <th style="text-align:center">Pages</th>
                            <th style="text-align:center">View</th>
                            <th style="text-align:center">List</th>
                            <th style="text-align:center">All</th>
                            <th style="text-align:center">Pages</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if(count($query)>0){
                            foreach($query as $row){
                                ?>
                                <tr>
                                    <td style="text-align:center"><?=$row->id?></td>
                                    <td style="text-align:center"><?=$row->salesman?></td>
                                    <td style="text-align:center"><?=$row->StartDate?></td>
                                    <td style="text-align:center"><?=$row->EndDate?></td>
                                    <td style="text-align:center"><?=$row->Areas?></td>
                                    <td style="text-align:center"><?=anchor('sales/items/'.$row->id,$row->TotalPending+$row->TotalDone,array('class'=>'btn btn-mini'))?></td>
                                    <td style="text-align:center"><?=anchor('sales/listview/'.$row->id,'<span class="isb-print"></span>',array('target'=>'_blank'))?></td>
                                    <td style="text-align:center"><?=anchor('sales/detailsview/'.$row->id,'<span class="isb-print"></span>',array('target'=>'_blank'))?></td>
                                    <td style="text-align:center"><?=anchor('sales/pages/'.$row->id,'<span class="isb-print"></span>',array('target'=>'_blank'))?></td>
                                    <td style="text-align:center"><?=anchor('sales/items/'.$row->id.'/pending',$row->TotalPending,array('class'=>'btn btn-mini btn-warning'))?></td>
                                    <td style="text-align:center"><?=anchor('sales/listview/'.$row->id.'/pending','<span class="isb-print"></span>',array('target'=>'_blank'))?></td>
                                    <td style="text-align:center"><?=anchor('sales/detailsview/'.$row->id.'/pending','<span class="isb-print"></span>',array('target'=>'_blank'))?></td>
                                    <td style="text-align:center"><?=anchor('sales/pages/'.$row->id.'/pending','<span class="isb-print"></span>',array('target'=>'_blank'))?></td>
                                    <td style="text-align:center"><?=anchor('sales/items/'.$row->id.'/done',$row->TotalDone,array('class'=>'btn btn-mini btn-success'))?></td>
                                    <td style="text-align:center"><?=anchor('sales/listview/'.$row->id.'/done','<span class="isb-print"></span>',array('target'=>'_blank'))?></td>
                                    <td style="text-align:center"><?=anchor('sales/detailsview/'.$row->id.'/done','<span class="isb-print"></span>',array('target'=>'_blank'))?></td>
                                    <td style="text-align:center"><?=anchor('sales/pages/'.$row->id.'/done','<span class="isb-print"></span>',array('target'=>'_blank'))?></td>
                                    <td style="text-align:center"><?=_show_delete('sales/delete/'.$row->id.'/delivery/',$this->p_delete);?></td>
                                </tr>

                            <?php } }
                        else{
                            echo '<tr>
                            	<td colspan="18"><center><strong>No Data Found</strong></center></td>
                            </tr>';
                        }

                        ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="18">Total : <?=$total_row?><div class="dataTables_paginate paging_full_numbers"><?=$links?></div></td></tr>
                        </tfoot>
                    </table>

                </div>
                <?php echo form_close();?>
            </div>
        </div>
        <div class="dr"><span></span></div>
    </div>
</div>
