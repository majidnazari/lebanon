<script language="javascript">
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

function getarea(district_id,area_id)
	{
		$("#dataarea").html("loading ... ");
		$.ajax({
			url: "<?php echo base_url();?>companies/GetArea",
			type: "post",
			data: "id="+district_id+"&area_id="+area_id,
			success: function(result){
				$("#dataarea").html(result);
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
$class_sect=' class="validate[required]" id="gov_id" onchange="getdistrict(this.value,'.$districtID.')"';
$class_district=' class="validate[required]"  required="required" id="district" onchange="getarea(this.value,0)"';
?>

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
                        <div class="span3">Governorates<br />
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
                        <div class="span3">District (القضاء)<br />
						<div id="datadistrict">
						<?php 
								$array_district[0]='All ';
								foreach($districts as $district)
								{
									if($district->id!=0)
									$array_district[$district->id]=$district->label_ar;	
								}
											
								echo form_dropdown('district_id',$array_district,$districtID,$class_district);
							?>
                            </div>
                        </div>
                        <div class="span3">Area (البلدة)<br />
						<div id="dataarea">
						<?php 
								$array_area[0]='All ';
								foreach($areas as $area)
								{
									if($district->id!=0)
									$array_area[$area->id]=$area->label_ar;	
								}
											
								echo form_dropdown('area_id',$array_area,$areaID);
							?>
                            </div>
                        </div>

                        <div class="span1">Status<br />
						<?php $array_status=array('all'=>'All','online'=>'Online','offline'=>'Offline');
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
					 <?php 

			   echo anchor('reports/export_banks?gov='.$govID.'&district_id='.$districtID.'&area_id='.$areaID.'&status='.$status.'&search=Search','<h3 style="float:right !important; color:#FFF !important">Export To Excel</h3>');
        ?>                                  
                </div>  
                <div class="block-fluid table-sorting clearfix">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                                <th><input type="checkbox" name="checkall"/></th>
                                <th>Bank Name</th>
                                <th width="21%">No. & Place of C.R</th>
                                <th width="21%">Phone / Email</th>
                                <th width="16%">Bank Establish date</th>                                
                                <th>Actions</th>                                    
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
						if(count($query)>0){
						foreach($query as $row){
							?>
                            <tr>
                                <td><input type="checkbox" id="check" name="checkbox1[]" value="<?=$row->id?>"/></td>
                                <td><?=anchor('banks/details/'.$row->id,$row->name_en.'<br>'.$row->name_ar)?></td>
                                <td><?php echo $row->commercial_register_en.'<br>'.$row->commercial_register_ar?></td>
                                <td align="right" style="text-align:right !important">
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
                                <td><?php 
									if($row->establish_date != 0){
										echo $row->establish_date;
										}
									else{
										echo 'N/A';
										}
										?>	
								</td>
                                <td>
								<?php 
										echo anchor('banks/view/'.$row->id,'<span class="isb-print"></span>',array('target'=>'_blank'));
										echo _show_delete('banks/delete/id/'.$row->id.'/status/'.$status,$p_delete);
										echo _show_edit('banks/edit/'.$row->id,$p_edit);
										
									
								if($row->status=='online')
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
                                <td colspan="7">
                                <?php if(count($query)>0){ ?>
                                Total : <?=count($query)?>
                                <?php } ?>
                                </td></tr>
                        </tfoot>
                    </table>
                    
                </div>
                <?php echo form_close();?>
            </div>                                
        </div>            
        <div class="dr"><span></span></div>            
    </div>
</div>
