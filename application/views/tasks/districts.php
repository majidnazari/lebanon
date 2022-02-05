
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

<?php 
$array_name=array('id'=>'name','name'=>'name','value'=>@$name);
$array_id=array('id'=>'id','name'=>'id','value'=>@$id);

$array_phone=array('id'=>'phone','name'=>'phone','value'=>@$phone);

$array_activity=array('id'=>'activity','name'=>'activity','value'=>@$activity);
if(@$districtID=='')
$districtID=0;
$class_sect=' class="search-select" id="sector_id" onchange="getdistrict(this.value,'.$district.')" ';
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
											
								echo form_dropdown('governorate',$array_governorates,@$governorate_id,$class_sect);
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
											
								echo form_dropdown('district_id',$array_district,@$district_id,'  onchange="getarea(this.value)" class="search-select"');
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
                                <li><a  href="javascript:void(0)" onclick="printall()"><h3>Print Selected</h3></a></li>
                            </ul>
                </div>  
                <div class="block-fluid table-sorting clearfix">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                                <th style="text-align:center"  width="15%">Mohafaza</th>
                                <th style="text-align:center"  width="15%">Kazaa</th>
                                <th style="text-align:center"  width="15%">All</th>
                                <th style="text-align:center"  width="15%">UnTask</th>
                                <th style="text-align:center" width="15%">Pending </th>
                                <th style="text-align:center" width="10%">Done</th>
                            </tr>
                        </thead>
                        <tbody> 
                        <?php 
						if(count($query)>0){
						foreach($query as $row){
                            $sql=$this->Task->GetGeoNotTasked($row->governorate_id,$row->district_id,'',date('Y'),0,0);
							?>
                            <tr>
                                <td style="text-align:center"><?=$row->governorate_ar?></td>
                                <td style="text-align:center"><?=$row->district_ar?></td>
                                <td style="text-align:center"><?=$row->all_count?></td>
                                <td style="text-align:center"><?=$sql['num_results']?></td>
                                <td style="text-align:center"><?=anchor('tasks/district-view/pending/'.$row->district_id,'View ('.$row->pending_count.')',array('target'=>'_blank'))?></td>
                                <td style="text-align:center"><?=anchor('tasks/district-view/done/'.$row->district_id,'View ('.$row->done_count.')',array('target'=>'_blank'))?></td>
                            </tr>
                            
                        <?php } }
						else{
								echo '<tr>
                            	<td colspan="6"><center><strong>No Data Found</strong></center></td>
                            </tr>';
							}
						
						?>    
                        </tbody>
                        <tfoot>
                        	<tr>
                                <td colspan="6">Total : <?=$total_row?><div class="dataTables_paginate paging_full_numbers"><?=$links?></div></td></tr>
                        </tfoot>
                    </table>
                    
                </div>
                <?php echo form_close();?>
            </div>                                
        </div>            
        <div class="dr"><span></span></div>            
    </div>
</div>
