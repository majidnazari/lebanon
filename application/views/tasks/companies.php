
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
		
function getsection(sector_id,section_id)
	{
		$("#datasection").html("loading ... ");
		$.ajax({
			url: "<?php echo base_url();?>parameters/items/GetDataSection",
			type: "post",
			data: "id="+sector_id+"&section_id="+section_id,
			success: function(result){
				$("#datasection").html(result);
			}
		});
	}
function getsection1(sector_id,section_id)
	{
		$("#datasection1").html("loading ... ");
		$.ajax({
			url: "<?php echo base_url();?>parameters/items/GetDataSection1",
			type: "post",
			data: "id="+sector_id+"&section_id="+section_id,
			success: function(result){
				$("#datasection1").html(result);
			}
		});
	}
function getsection2(sector_id,section_id)
	{
		$("#datasection2").html("loading ... ");
		$.ajax({
			url: "<?php echo base_url();?>parameters/items/GetDataSection1",
			type: "post",
			data: "id="+sector_id+"&section_id="+section_id,
			success: function(result){
				$("#datasection2").html(result);
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

<?php 
$array_name=array('id'=>'name','name'=>'name','value'=>@$name);
$array_id=array('id'=>'id','name'=>'id','value'=>@$id);

$array_phone=array('id'=>'phone','name'=>'phone','value'=>@$phone);

$array_activity=array('id'=>'activity','name'=>'activity','value'=>@$activity);
if(@$districtID=='')
$districtID=0;
$class_sect=' class="validate[required]" id="sector_id" onchange="getdistrict(this.value,'.$districtID.')"';
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
        <?php if(@$search){ ?>
       <div class="row-fluid">
            <div class="span12">
                 <div class="head clearfix">
                    <div class="isw-zoom"></div>
                    <h1>Search</h1>
                </div>
                <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'validation','method'=>'get'));
					  
					   ?>



                  <div class="block-fluid">                        

                    <div class="row-form clearfix">
                        <div class="span1">ID : <br /><?php echo form_input($array_id); ?></div>
                        <div class="span1">وزارة ID : <br /><?php echo form_input(array('name'=>'ministry_id','id'=>'ministry_id','value'=>@$ministry_id)); ?></div>
                        <div class="span3">Company Name (اسم الشركة)
						<br /><?php echo form_input($array_name); ?></div>
                        <div class="span4">Activity<br /><?php echo form_input($array_activity); ?></div>
                        <div class="span2">Phone<br /><?php echo form_input($array_phone); ?></div>
                        
                    </div>                            
                               

                    <div class="row-form clearfix">
                        <div class="span3">Mohafaza<br /><?php 
								$array_governorates[0]='All ';
								foreach($governorates as $governorate)
								{
									if($governorate->id!=0)
									$array_governorates[$governorate->id]=$governorate->label_ar;	
								}
											
								echo form_dropdown('gov',$array_governorates,$govID,$class_sect);
							?>
                        </div>

                        <div class="span3">Kazaa (القضاء)<br />
						<div id="datadistrict">
						<?php 
								$array_district[0]='All ';
								foreach($districts as $district)
								{
									if($district->id!=0)
									$array_district[$district->id]=$district->label_ar;	
								}
											
								echo form_dropdown('district_id',$array_district,$districtID,'  onchange="getarea(this.value)"');
							?>
                            </div>
                        </div>
                        <div class="span3">City (المنطقة)<br />
						<div id="area">
						<?php 
								$array_area[0]='All ';
								foreach($areas as $area)
								{
									if($area->id!=0)
									$array_area[$area->id]=$area->label_ar;	
								}
											
								echo form_dropdown('area_id',$array_area,$areaID);
							?>
                            </div>
                        </div>

                        <div class="span1">Status<br /><?php $array_status=array('all'=>'All','online'=>'Online','offline'=>'Offline');
												echo form_dropdown('status',$array_status,$status);
							?></div>
                        <div class="span3"><br /><input type="submit" name="search" value="Search" class="btn">
                        <input type="submit" name="clear" value="Clear" class="btn">
                        </div>
                    </div>                            
                </div>
				<?=form_close()?>
            </div>
        </div> 
        <?php } ?>
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
                            <li><?=anchor('tasks/export_companies','<h3>Export To Excel</h3>')?>&nbsp;</li>
                            </ul>
                </div>  
                <div class="block-fluid table-sorting clearfix">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th style="text-align:center"  width="20%">اسم الشركة</th>
                                <th style="text-align:center" width="10%">اسم المسؤول</th>
                                <th style="text-align:center" width="15%">النشاط</th>
                                <th style="text-align:center" width="10%">العنوان</th>
                                <th style="text-align:center"  width="10%">هاتف</th>
                                <th style="text-align:center" width="6%">معلن</th>
                                <th style="text-align:center" width="6%">حاجز  نسخة</th>
                                <th style="text-align:center" width="6%">وزارة ID</th>
                                <th style="text-align:center" width="6%">مغلقة</th>
                            </tr>
                        </thead>
                        <tbody> 
                        <?php 
						if(count($query)>0){
						foreach($query as $row){
							$sector=$this->Item->GetSectorById($row->sector_id);
							$type=$this->Company->GetCompanyTypeById($row->company_type_id);
							?>
                            <tr>
                                <td><?=$row->id?></td>
                                <td><?=anchor('companies/details/'.$row->id,$row->name_ar.'<br>'.$row->name_en)?></td>
                                <td><?=$row->owner_name.'<br>'.$row->owner_name_en?></td>
                                <td><?=$row->activity_ar.'<br>'.$row->activity_en?></td>
                                <td><?=$row->area_ar.' - '.$row->street_ar?></td>
                                <td><?=$row->phone;?>
                                </td>
                                <td><?php 
								/*
									if(count($type)>0){
										echo $type['label_en'].'<br>'.$type['label_ar'];
										}
									else{
										echo 'N/A';
										}
										*/
										if($row->is_adv==1){
										echo 'Yes';
										}
										else{
											echo 'No';
											}
										?></td>
                                       <td><?php 
								/*
									if(count($type)>0){
										echo $type['label_en'].'<br>'.$type['label_ar'];
										}
									else{
										echo 'N/A';
										}
										*/
										if($row->copy_res==1){
										echo 'Yes';
										}
										else{
											echo 'No';
											}
										?></td>
                                <td><?=$row->ministry_id?></td>
                                <td><?php


                                    if($row->is_closed==1){
                                        echo 'Yes';
                                    }
                                    else{
                                        echo 'No';
                                    }
                                    ?></td>
                            </tr>
                            
                        <?php } }
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
                <?php echo form_close();?>
            </div>                                
        </div>            
        <div class="dr"><span></span></div>            
    </div>
</div>
