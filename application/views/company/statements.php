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
if($districtID=='')
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
</script>
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
                <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'validation','method'=>'get'));
					  
					   ?> 
                  <div class="block-fluid">                        
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

                        <div class="span3">Year<br />
						<?php 
							$j=date('Y');
							$array_years[0]='Select a Year';		
							for($i=2016;$i<=$j;$i++)
							{
								$array_years[$i]=$i;		
							}
							echo form_dropdown('year',$array_years,@$year);
							?></div>
                        <div class="span12"><br /><center><input type="submit" name="search" value="Search" class="btn">
                        <input type="submit" name="clear" value="Clear" class="btn"></center>
                        </div>
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
                <?php } 
				 echo form_open('',array('id'=>'form_id','name'=>'form1'));?>   
                <div class="head clearfix">
                    <div class="isw-grid"></div>
                    <h1><?=$subtitle?></h1>
                   
                     <a href="javascript:void(0)" onclick="printall()"><h3 style="float:right !important">Print Selected</h3></a>
                      <?=anchor('companies/liststatements?gov='.$govID.'&district_id='.$districtID.'&year='.$year,'<h3 style="float:right !important">Print List</h3>')?>
                                                       
                </div>  
                <div class="block-fluid table-sorting clearfix">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                                <th><input type="checkbox" name="checkall"/></th>
                                <th style="text-align:center">اسم الشركة</th>
                                <th style="text-align:center" width="21%">اسم المسؤول</th>
                                <th style="text-align:center" width="21%">هاتف</th>
                                <th style="text-align:center" width="16%">معلن</th>                                
                                <th>Actions</th>                                    
                            </tr>
                        </thead>
                        <?php if(count($query)>0){ ?>
                        <tbody> 
                        <?php 
						foreach($query as $row){
							$sector=$this->Item->GetSectorById($row->sector_id);
							$type=$this->Company->GetCompanyTypeById($row->company_type_id);
							?>
                            <tr>
                                <td><input type="checkbox" id="check" name="checkbox1[]" value="<?=$row->id?>"/><?=$row->id?></td>
                                <td><?=anchor('companies/details/'.$row->id,$row->name_ar.'<br>'.$row->name_en)?></td>
                                <td><?=$row->owner_name.'<br>'.$row->owner_name_en?></td>
                                <td><?php echo $row->phone;?></td>
                                <td><?php 
								
										if($row->is_adv==1){
										echo 'Yes';
										}
										else{
											echo 'No';
											}
										?></td>
                                <td>
								
								<?php 
										echo anchor('companies/view/'.$row->id,'<span class="isb-print"></span>',array('target'=>'_blank'));
										//echo _show_delete('companies/delete/id/'.$row->id.'/p/company/',$p_delete);
										echo _show_edit('companies/edit/'.$row->id,$p_edit);
										
								echo '<div id="status-area-'.$row->id.'">';	
								if($row->show_online==1)
								echo '<a href="javascript:;" onclick="change_status('.$row->id.',0)"><span class="label label-success">Online</span></a>';
								else
								echo '<a href="javascript:;" onclick="change_status('.$row->id.',1)"><span class="label">Offline</span></a>';
								echo '</div>';
							
									?>                                        
                                </td>                                    
                            </tr>
                            
                        <?php } ?>    
                        </tbody>
                        <tfoot>
                        	<tr>
                                <td colspan="7">Total : <?=$total_row?><div class="dataTables_paginate paging_full_numbers"><?=$links?></div></td></tr>
                                
                        </tfoot>
                        <?php } ?>
                    </table>
                    
                </div>
                <?php echo form_close();?>
            </div>                                
        </div>            
        <div class="dr"><span></span></div>            
    </div>
</div>
