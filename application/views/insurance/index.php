<style type="text/css">
    #district_id{
        width: 100% !important;
    }
    #area{
        width: 100% !important;
    }
</style>
<script language="javascript">
$(function() {
	$(".search-select").select2();
    $("#district_id").select2();
    $("#area_id").select2();
  });
function change_status(id,status)
	{
		$("#status-area-"+id).html("loading ... ");
		$.ajax({
			url: "<?php echo base_url();?>insurances/change_status",
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
			url: "<?php echo base_url();?>insurances/GetDistricts",
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
        url: "<?php echo base_url();?>insurances/GetArea",
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
if($search){
if($districtID=='')
$districtID=0;
$class_sect=' class="validate[required]" id="sector_id" onchange="getdistrict(this.value,'.$districtID.')"';
$class_sect1=' class="validate[required]"  required="required" id="sector" onchange="getsection1(this.value,0)"';
$class_sect2=' class="validate[required]"  required="required" id="sector2" onchange="getsection2(this.value,0)"';
}

?>
<script language="JavaScript" type="text/JavaScript">

    function printall()
        {
			checkboxes = document.getElementsByName('checkall');
			checkboxes.checked =true;
			document.getElementById("form_id").target = "_blank";
            document.getElementById("form_id").action = "<?=base_url().'insurances/printall'?>";
            document.getElementById("form_id").submit();

        }
function delete_checked()
        {
			checkboxes = document.getElementsByName('checkall');
			checkboxes.checked =true;
            document.getElementById("form_id").action = "<?=base_url().'insurances/delete_checked'?>";
			var answer = confirm("Are You Sure ?")
				if (answer){
					document.getElementById("form_id").submit();
				}
				else{
					return false
				}
            

        }		
</script>
<div class="content">
	<?=$this->load->view("includes/_bread")?>
    <div class="workplace">
        <div class="page-header">
            <h1><?=$subtitle;?></h1>
        </div> 
        <?php if($search){ ?>
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
                        <div class="span1">ID# </div>
                        <div class="span1"><?=form_input(array('name'=>'id','id'=>'ID','value'=>@$id));?></div>
                        <div class="span1">Name </div>
                        <div class="span3"><?=form_input(array('name'=>'name','id'=>'name','value'=>@$name));?></div>
                        <div class="span1">Phone</div>
                        <div class="span3"> <?=form_input(array('name'=>'phone','id'=>'phone','value'=>@$phone));?></div>
                        <div class="span1">Status </div>
                        <div class="span1"><?php $array_status=array('all'=>'All','online'=>'Online','offline'=>'Offline');
                            echo form_dropdown('status',$array_status,$status);
                            ?></div>
                    </div>
                    <div class="row-form clearfix">
                    	<div class="span1">Mohafaza </div>
                        <div class="span3"><?php 
								$array_governorates[0]='All ';
								foreach($governorates as $governorate)
								{
									if($governorate->id!=0)
									$array_governorates[$governorate->id]=$governorate->label_ar;	
								}
											
								echo form_dropdown('gov',$array_governorates,$govID,$class_sect);
							?>
                        </div>
						<div class="span1">Kazaa</div>
                        <div class="span3">
						<div id="datadistrict">
						<?php 
								$array_district[0]='All ';
								foreach($districts as $district)
								{
									if($district->id!=0)
									$array_district[$district->id]=$district->label_ar;	
								}
											
								echo form_dropdown('district_id',$array_district,$districtID,'  onchange="getarea(this.value)" id="district_id"');
							?>
                            </div>
                        </div>
                        <div class="span1">City (المنطقة)</div>
                        <div class="span3">
                            <div id="area">
                                <?php
                                $array_area[0]='All ';
                                foreach($areas as $area)
                                {
                                    if($area->id!=0)
                                        $array_area[$area->id]=$area->label_ar.' ('.$area->total.' )';
                                }

                                echo form_dropdown('area_id',$array_area,$areaID,' id="area_id"');
                                ?>
                            </div>
                        </div>
                    </div>

                        <div class="row-form clearfix" style="text-align: center !important">
                        <div class="span12"><input type="submit" name="search" value="Search" class="btn">
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
						echo form_hidden('st',@$st);
						echo form_hidden('p','insurance');
				?>   
                                          
                <div class="head clearfix">
                    <div class="isw-grid"></div>
                    <h1><?=$subtitle?></h1>
                   
                     <?php
					 echo _show_add_pop('#ChangingModal','Changing Insurance in industrial companies',$p_changing);
					  if($p_delete){ ?>
					  <a href="javascript:void(0)" onclick="delete_checked()"><h2 style="float:right; color:#FFF !important">Delete Checked</h2></a>
					 <?php } ?>
                     <a href="javascript:void(0)" onclick="printall()"><h3 style="float:right !important">Print Selected</h3></a>
                      <?php 
					  if($search){
					  echo anchor('insurances/listview?gov='.$govID.'&district_id='.$districtID.'&status='.$status,'<h3 style="float:right !important">Print List</h3>',array('target'=>'_blank'));
					  }
                      echo anchor('insurances/printed_search?id='.@$id.'&name='.@$name.'&phone='.@$phone.'&gov='.@$govID.'&district_id='.@$districtID.'&area_id='.@$areaID.'&status='.@$status.'&search=Search','<h3 style="float:right !important">Print Search Result</h3>',array('target'=>'_blank'));
					  ?>
                                                       
                </div>  
                <div class="block-fluid table-sorting clearfix">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                               <th><input type="checkbox" name="checkall"/></th>
                                <th style="text-align:center">اسم الشركة</th>
                                <th style="text-align:center">اسم المسؤول</th>
                                <th style="text-align:center">العنوان</th>
                                <th style="text-align:center">هاتف</th>
                                <th style="text-align:center">معلن</th>                                
                                <th style="text-align:center">حجز  نسخة</th>                                
                                <th>Actions</th>                                                              
                            </tr>
                        </thead>
                        <tbody> 
                        <?php 
						if(count($query)>0){
						foreach($query as $row){
							?>
                            <tr>
                                <td><input type="checkbox" id="check" name="checkbox1[]" value="<?=$row->id?>"/><?=$row->id?></td>
                                <td><?=anchor('insurances/details/'.$row->id,$row->name_ar.'<br>'.$row->name_en)?></td>
                                <td><?=$row->manager_ar.'<br>'.$row->manager_en?></td>
                                <td><?php 
									$governorate=$this->Address->GetGovernorateById($row->governorate_id);
									$district=$this->Address->GetDistrictById($row->district_id);
									$area=$this->Address->GetAreaById($row->area_id);
									echo $area['label_ar'].' - '.$row->street_ar?></td>
                                <td><?php echo $row->phone;?></td>
                                <td><?php 
										if($row->is_adv==1){
										echo 'Yes';
										}
										else{
											echo 'No';
											}
										?></td>
                                   <td><?php 
										if($row->copy_res==1){
										echo 'Yes';
										}
										else{
											echo 'No';
											}
										?></td>     
                                <td>
								
								<?php 
										echo anchor('insurances/view/'.$row->id,'<span class="isb-print"></span>',array('target'=>'_blank'));
										//echo _show_delete('insurances/delete/id/'.$row->id.'/p/chapter/st/'.$st,$p_delete);
										echo _show_edit('insurances/edit/'.$row->id,$p_edit);
										
									
								echo '<div id="status-area-'.$row->id.'">';	
								if($row->online==1)
								echo '<a href="javascript:;" onclick="change_status('.$row->id.',0)"><span class="label label-success">Online</span></a>';
								else
								echo '<a href="javascript:;" onclick="change_status('.$row->id.',1)"><span class="label">Offline</span></a>';
								echo '</div>';
							
									?>                                        
                                </td>                                    
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
            </div>                                
        </div>            
        <div class="dr"><span></span></div>            
    </div>
</div>

<?php if($p_changing){ 
		$array_company=array(''=>'Select Insurance Company');
		foreach($query1 as $row1){
			$array_company[$row1->id]=$row1->name_ar.' ( '.$row1->name_en.' )';
		}
?>
<div id="ChangingModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Changing Company</h3>
    </div>  
    <?php echo form_open_multipart('insurances/changing_company',array('id'=>'validation'));?>      
    <div class="row-fluid">
        <div class="block-fluid">
            <div class="row-form clearfix">
                <div class="span3">Old Company *:</div>
                <div class="span9">
                	<?=form_dropdown('old_company',$array_company,'','required="required" class=""')?>
                </div>
            </div>            
            <div class="row-form clearfix">
                <div class="span3">New Company *:</div>
                <div class="span9"><?=form_dropdown('new_company',$array_company,'','required="required"')?></div>
            </div>            
        </div>                
        <div class="dr"><span></span></div>
    </div>                    
    <div class="modal-footer">
        <input type="submit" name="save" value="Save" class="btn">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>            
    </div>
    <?=form_close()?>
</div>
<?php } ?>
