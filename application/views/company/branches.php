<style type="text/css">
.yellow tr, .yellow td{
	background:#9F0 !important;
}
</style>
<script language="javascript">
function branch_status(id,status)
	{
		$("#status-area-"+id).html("loading ... ");
		$.ajax({
			url: "<?php echo base_url();?>companies/branch_status",
			type: "post",
			data: "id="+id+"&status="+status,
			success: function(result){
				$("#status-area-"+id).html(result);
			}
		});
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
        <?php if($msg!=''){ ?>
                <div class="row-fluid">
              	<div class="alert alert-success">               
                    <?php echo $msg;?>
                </div> 
                </div>
                <?php } ?>  
       <div class="row-fluid">       
        <div class="span9">              
        <div class="row-fluid">
            <div class="span12">
           
                <?php echo form_open('companies/delete_checked',array('id'=>'form_id','name'=>'form1'));
						echo form_hidden('st','branches');
						echo form_hidden('company',$query['id']);
				?>   
                                          
                <div class="head clearfix">
                    <div class="isw-grid"></div>
                    <h1>Branches : <?=count($branches)?></h1>
					 <?php //_show_delete_checked('#',$this->p_branch_delete)?>
                  <?php 
				  if($this->p_branch_add){
					                                      
                	echo anchor('companies/branch-create/'.$query['id'],'<h3 style="float:right !important">Add New Branch</h3>');
				  }
				?>
                     </div>  
                <div class="block-fluid table-sorting clearfix">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table" id="tSortable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>المحافظة -القضاء  -البلدة</th>
                                <th>الشارع</th>
                                <th>Phone / Fax</th>                             
                                <th>Actions</th>                                    
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
						if(count($branches)>0){
						foreach($branches as $row){
							///$b_area=$this->Address->GetAreaById($row->area_id);
                    		///$b_district=$this->Address->GetDistrictById($b_area['district_id']);
                    		//$b_gov=$this->Address->GetGovernorateById($b_district['governorate_id']);
							$sdate=date('Y-m-d');
							$css='';
							if( $row->update_time >= $sdate.' 00:00:00' and $row->update_time <= $sdate.' 23:59:59')
							{
								$css='yellow';
								}
							?>
                            <tr class="<?=$css?>">
                                <td><?=$row->id?></td>
                                <td><?=$row->governorate_ar?> - <?=$row->district_ar?> - <?=$row->area_ar?></td>
                                <td><?=$row->street_ar?></td>
                                <td><?php echo $row->phone.' - '.$row->fax?></td>
                                <td>
								<?php 
									echo _show_delete('companies/delete/id/'.$row->id.'/company/'.$query['id'].'/p/branches',$this->p_branch_delete);
									echo _show_edit('companies/branch-edit/'.$row->id,$this->p_branch_edit);
										
								
								echo '<div id="status-area-'.$row->id.'">';	
								if($row->status=='online')
								echo '<a href="javascript:;" onclick="branch_status('.$row->id.',\'offline\')"><span class="label label-success">Online</span></a>';
								else
								echo '<a href="javascript:;" onclick="branch_status('.$row->id.',\'online\')"><span class="label">Offline</span></a>';
								echo '</div>';
							
								
								
							
									?>                                        
                                </td>                                    
                            </tr>
                            
                        <?php } 
						}
												
						?>    
                        </tbody>
                    
                    </table>
                    
                </div>
                <?php echo form_close();?>
            </div>  
            </div>
            </div> 
            <?=$this->load->view('company/_navigation')?>
        </div>            
        <div class="dr"><span></span></div>
	</div>
</div>
