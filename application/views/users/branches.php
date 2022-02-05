<script language="javascript">
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
            document.getElementById("form_id").action = "<?=base_url().'banks/printall'?>";
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
            <?php if($msg!=''){ ?>
              	<div class="alert alert-success">               
                    <?php echo $msg;?>
                </div> 
                <?php } ?>    
                <?php echo form_open('',array('id'=>'form_id','name'=>'form1'));?>   
                                          
                <div class="head clearfix">
                    <div class="isw-grid"></div>
                    <h1><?=$subtitle?></h1>
					 <?=_show_delete_checked('#',$p_delete)?>                                    
                <?=anchor('banks/createbranches/'.$b_id,'<h3 style="float:right !important">Add New Branche</h3>')?>
                     </div>  
                <div class="block-fluid table-sorting clearfix">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                                <th><input type="checkbox" name="checkall"/></th>
                                <th>Name</th>
                                <th width="21%">Phone / Fax</th>
                                <th width="21%">PO Box</th>
                                <th width="16%">Email / Website</th>                                
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
                                <td><?=anchor('banks/branchdetails/'.$row->id,$row->name_en.'<br>'.$row->name_ar)?></td>
                                <td><?php echo $row->phone.'<br>'.$row->fax?></td>
                                <td align="right" style="text-align:right !important">
                                	<?php 
										echo $row->pobox_en.'<br>';
										echo $row->pobox_ar;?>	
                                </td>
                                <td><?php 
										echo '<a href="mailto:'.$row->email.'">'.$row->email.'</a><br><br>'.$row->web_page;
										?>	
								</td>
                                <td>
								<?php 
										echo _show_delete('parameters/items/delete/id/'.$row->id.'/p/chapter/st/'.$st,$p_delete);
										echo _show_edit('banks/editbranch/'.$row->id,$p_edit);
										
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
