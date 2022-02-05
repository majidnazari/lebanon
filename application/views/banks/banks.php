<style type="text/css">
    #district_id{
        width: 100% !important;
    }
    #area{
        width: 100% !important;
    }
</style>
<script language="javascript">
    $(document).ready(function() {
        $("#district_id").select2();
        $("#area_id").select2();
    });
function getdistrict(gov_id,district_id)
	{
		$("#datadistrict").html("loading ... ");
		$.ajax({
			url: "<?php echo base_url();?>banks/GetDistricts",
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
        url: "<?php echo base_url();?>banks/GetArea",
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
            document.getElementById("form_id").action = "<?=base_url().'banks/printall'?>";
            document.getElementById("form_id").submit();

        }
function delete_checked()
        {
			checkboxes = document.getElementsByName('checkall');
			checkboxes.checked =true;
            document.getElementById("form_id").action = "<?=base_url().'banks/delete_checked'?>";
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
                <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'validation','method'=>'get'));?> 
                <div class="block-fluid"> 
                <div class="row-form clearfix">
                        <div class="span3">ID#<br /><?php echo form_input(array('name'=>'id','id'=>'id','value'=>$id));?></div>
                        <div class="span3">Name (English or arabic)<br /><?php echo form_input(array('name'=>'name','id'=>'name','value'=>$name));?></div>
                        <div class="span3">Phone<br /><?php echo form_input(array('name'=>'phone','id'=>'phone','value'=>$phone));?></div>
                        <div class="span3">Fax<br /><?php echo form_input(array('name'=>'fax','id'=>'fax','value'=>$fax));?></div>
                        
  </div>                       
                    <div class="row-form clearfix">
                        <div class="span3">Mohafaza<br />
						<?php 
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
											
								echo form_dropdown('district_id',$array_district,$districtID,'  onchange="getarea(this.value)" id="district_id"');
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
                                        $array_area[$area->id]=$area->label_ar.' ('.$area->total.' )';
                                }

                                echo form_dropdown('area_id',$array_area,$areaID,' id="area_id"');
                                ?>
                            </div>
                        </div>

                        <div class="span2">Status<br />
						<?php $array_status=array('all'=>'All','1'=>'Online','0'=>'Offline');
							echo form_dropdown('status',$array_status,$status);
							?></div>
                        <div class="span2"><br /><input type="submit" name="search" value="Search" class="btn">
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
						echo form_hidden('p','banks');
				?>   
                                          
                <div class="head clearfix">
                    <div class="isw-grid"></div>
                    <h1><?=$subtitle?></h1>
					  <?php 
					  echo _show_add_pop('#ChangingModal','Changing Bank in industrial companies',$p_changing);
					  if($p_delete){ ?>
					  <a href="javascript:void(0)" onclick="delete_checked()"><h2 style="float:right; color:#FFF !important">Delete Checked</h2></a>
					 <?php }
                      if($p_add){
                      echo anchor('banks/create','<h3 style="float:right !important">Add New</h3>');
					  
					  }?>
                      <a href="javascript:void(0)" onclick="printall()"><h3 style="float:right !important">Print Selected</h3></a>
                      <?php 
                     // if($search){
					  echo anchor('banks/listview?id='.@$id.'&name='.@$name.'&phone='.@$phone.'&fax='.@$fax.'&gov='.@$govID.'&district_id='.@$districtID.'&area_id='.@$areaID.'&status='.@$status.'&search=Search','<h3 style="float:right !important">Print List</h3>',array('target'=>'_blank'));
					 // }
					 
                     // if($search){
                         echo anchor('banks/printed_search?id='.@$id.'&name='.@$name.'&phone='.@$phone.'&fax='.@$fax.'&gov='.@$govID.'&district_id='.@$districtID.'&area_id='.@$areaID.'&status='.@$status.'&search=Search','<h3 style="float:right !important">Print Search Result</h3>',array('target'=>'_blank'));
                     // }
					  ?>
                                                       
                </div>  
                <div class="block-fluid table-sorting clearfix">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                                <th><input type="checkbox" name="checkall"/></th>
                                <th style="text-align:center">اسم المصرف</th>
                                <th style="text-align:center">العنوان</th>
                                <th style="text-align:center" width="21%">هاتف</th>
                                <th style="text-align:center" width="16%">معلن</th>                                
                                <th style="text-align:center" width="16%">حجز  نسخة</th>                                
                                <th>Actions</th>                                                                  
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
						if(count($query)>0){
						foreach($query as $row){
							if($row->is_adv==1)
							{
								$ad='Yes';	
							}
							else{
								$ad='No';	
								}
						if($row->copy_res==1)
							{
								$copy_res='Yes';	
							}
							else{
								$copy_res='No';	
								}
							?>
                            <tr>
                                <td><input type="checkbox" id="check" name="checkbox1[]" value="<?=$row->id?>"/><?=$row->id?></td>
                                <td><?=anchor('banks/details/'.$row->id,$row->name_en.'<br>'.$row->name_ar)?></td>
                                <td><?php 
									//$governorate=$this->Address->GetGovernorateById($row->governorate_id);
									//$district=$this->Address->GetDistrictById($row->district_id);
									$area=$this->Address->GetAreaById($row->area_id);
									echo $area['label_ar'].' - '.$row->street_ar?></td>
                                <td>
                                	<?php 
									if($row->phone != ""){
										echo $row->phone.'<br>';
										}
									else{
										echo 'N/A';
										}
									if($row->email != ""){
										echo '<a href="mailto:'.$row->email.'">'.$row->email.'</a><br>';
										}
									else{
										echo 'N/A';
										}
										?>	
                                </td>
                                <td><?=$ad?></td>
                                <td><?=$copy_res?></td>
                                <td>
								<?php 
										echo anchor('banks/view/'.$row->id,'<span class="isb-print"></span>',array('target'=>'_blank'));
										//echo _show_delete('banks/delete/id/'.$row->id.'/st/banks'.$status,$p_delete);
										echo _show_edit('banks/edit/'.$row->id,$p_edit);
										
									
								if($row->online==1)
								echo '<span class="label label-success">Online</span>';
								else
								echo '<span class="label">Offline</span>';
							
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
                                <td colspan="8">Total : <?=$total_row?><div class="dataTables_paginate paging_full_numbers"><?=$links?></div></td></tr>
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
		$array_company=array(''=>'Select Bank');
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
                	<?=form_dropdown('old_company',$array_company,'','required="required"')?>
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

