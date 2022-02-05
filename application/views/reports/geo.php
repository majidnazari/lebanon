<style type="text/css">
    .select2 {
        width: 100% !important;
    }
</style>
<script language="javascript">
    $(function () {
        $(".select2").select2();
    })
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

    function updatearea(id)
        {
            document.getElementById("area-"+id).action = "<?=base_url().'reports/task_edit'?>";
            document.getElementById("area-"+id).submit();

        }
</script>
<?php
if(@$districtID=='')
$districtID=0;
$class_sect='  id="governorate_id" onchange="getdistrict(this.value,'.$districtID.')" class="select2"';

?>
<style type="text/css">
.sub-link{
	padding-left:10px !important;
}
.green tr, .green td{
    background: #16ff2e !important;
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
                <?php if($msg!=''){ ?>
                    <div class="alert alert-success">
                        <?php echo $msg;?>
                    </div>
                <?php } ?>
                <div class="head clearfix">
                    <div class="isw-zoom"></div>
                    <h1>Search</h1>
                </div>
                <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'validation','method'=>'get'));?>
                <div class="block-fluid">
                    <div class="row-form clearfix">
                        <div class="span4">Mohafaza<br /><?php
                            $array_governorates[0]='All ';
                            foreach($governorates as $governorate)
                            {
                                if($governorate->id!=0)
                                    $array_governorates[$governorate->id]=$governorate->label_ar;
                            }

                            echo form_dropdown('gov',$array_governorates,$govID,$class_sect);
                            ?>
                        </div>

                        <div class="span4">Kazaa (القضاء)<br />
                            <div id="datadistrict">
                                <?php
                                $array_district[0]='All ';
                                foreach($districts as $district)
                                {
                                    if($district->id!=0)
                                        $array_district[$district->id]=$district->label_ar;
                                }

                                echo form_dropdown('district_id',$array_district,$districtID,'  onchange="getarea(this.value)"  class="select2"');
                                ?>
                            </div>
                        </div>
                        <div class="span4">City (المنطقة)<br />
                            <div id="area">
                                <?php
                                $array_area[0]='All ';
                                foreach($areas as $area)
                                {
                                    if($area->id!=0)
                                        $array_area[$area->id]=$area->label_ar;
                                }

                                echo form_dropdown('area_id',$array_area,$areaID,' class="select2"');
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span4">Type <br /><?=form_dropdown('type',array('scanning'=>'مسح','delivery'=>'تسليم النسخ'),@$type);?></div>
                        <div class="span4">Assign To <br /><?php
                            $array_salesman['']='All';
                            foreach($sales as $man)
                            {
                                $array_salesman[$man->id]=$man->fullname;
                            }

                            echo form_dropdown('assign_to',$array_salesman,$assign_to,' class="select2"');
                            ?></div>
                        <div class="span4">Printed <br /><?php
                                   echo form_dropdown('printed',array(''=>'All',1=>'Yes',0=>'No'),@$printed);
                            ?></div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span12"><center><input type="submit" name="search" value="Search" class="btn">
                            <?=anchor('reports/geo','Clear',array('class'=>'btn'))?></center>
                        </div>
                    </div>
                </div>
                <?=form_close()?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">

                <div class="head clearfix">
                    <div class="isw-grid"></div>
                    <h1><?=$subtitle?></h1>

                    <?=anchor('reports/geo_export?gov='.@$govID.'&district_id='.@$districtID.'&area_id='.@$areaID.'&type='.@$type.'&assign_to='.@$assign_to,'<h1 style="float: right">Export To Excel</h1>')?>
                </div>  
                <div class="block-fluid table-sorting clearfix">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                                <th>Mohafaz</th>
                                <th>Kazaa</th>
                                <th>Area</th>
                                <th>Total Companies</th>
                                <th>Pending</th>
                                <th>Done</th>
                                <th>Assign To</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody> 
                        <?php

						if(count($query)>0){
						foreach($query as $row){
						    $total_companies=$this->Company->GetGeoCompaniesByArea($row->governorate_id,$row->district_id,$row->area_id);
                            echo form_open_multipart('',array('id'=>'area-'.$row->id));
                            echo form_hidden('id',$row->id);
                            if($row->printed==1)
                            {
                                $css='green';
                            }
                            else{
                                $css='';
                            }
						    ?>
                            <div id="CreateModal<?=$row->id?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h3 id="myModalLabel">Add Task</h3>
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

                                                echo form_dropdown('assigne_to',$array_salesman,$row->assigne_to);
                                                ?>
                                            </div>
                                        </div>
                                        <div class="row-form clearfix">
                                            <div class="span3">Type :</div>
                                            <div class="span9"><?=form_dropdown('type',array('scanning'=>'مسح','delivery'=>'تسليم النسخ'),$row->type);?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="dr"><span></span></div>
                                </div>
                                <div class="modal-footer">
                                    <?=anchor('reports/task_release/'.$row->id,'Release',array('class'=>'btn'))?>
                                    <a href="javascript:void(0)" onclick="updatearea(<?=$row->id?>)" class="btn">Save</a>
                                    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                                </div>
                            </div>
                            <?=form_close();?>
                            <tr class="<?=$css?>">
                                <td><?=$row->governorate_ar.'<br>'.$row->governorate_en?></td>
                                <td><?=$row->district_ar.'<br>'.$row->district_en?></td>
                                <td><?=$row->area_ar.'<br>'.$row->area_en?></td>
                                <td><?=anchor('companies?id=&ministry_id=&name=&activity=&phone=&gov='.$row->governorate_id.'&district_id='.$row->district_id.'&area_id='.$row->area_id.'&status=all&search=Search','View ('.@$total_companies[0]->company_count.' )')?></td>
                                <td><?=anchor('reports/tasks/'.$row->id.'/pending','View ('.@$row->pending_count.' )',array('target'=>'_blank'))?></td>
                                <td><?=anchor('reports/tasks/'.$row->id.'/done','View ('.@$row->done_count.' )',array('target'=>'_blank'))?></td>
                                <td><?=$row->fullname?></td>
                                <td><a href="#CreateModal<?=$row->id?>" data-toggle="modal" class="btn">Update</a>
                                      <?=anchor('companies/tasks_print/'.$row->id.'/pending','Print',array('target'=>'_blank','class'=>'btn'))?>
                                    <?=anchor('companies/task_listview/'.$row->id.'/pending','Print List',array('target'=>'_blank','class'=>'btn'))?>
                                    <?=anchor('companies/rprint/'.$row->id,'Refresh Print',array('class'=>'btn'))?>
                                    <?=anchor('reports/delete_assign/'.$row->id,'Remove',array('class'=>'btn','onclick'=>'return confirmation();'))?>
                                </td>
                            </tr>
                            
                        <?php

						}
						}
						else{
								echo '<tr>
                            	<td colspan="10"><center><strong>No Data Found</strong></center></td>
                            </tr>';
							}
						
						?>    
                        </tbody>
                        <tfoot>
                        	<tr>
                                <td colspan="10">Total : <?=$total_row?><div class="dataTables_paginate paging_full_numbers"><?=$links?></div></td></tr>
                        </tfoot>
                    </table>
                    
                </div>
                <?php // echo form_close();?>
            </div>                                
        </div>            
        <div class="dr"><span></span></div>            
    </div>
</div>
