
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
                <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'validation','method'=>'get'));
					  
					   ?>



                  <div class="block-fluid">
                    <div class="row-form clearfix">
                        <div class="span4">Sales Man<br /><?php
								$array_sales['']='All ';
								foreach($sales as $salesman)
								{
                                    $array_sales[$salesman->id]=$salesman->fullname;
								}
											
								echo form_dropdown('id',$array_sales,@$sales_man);
							?>
                        </div>
                        <div class="span2">Start Date<br />
                            <?=form_input(array('name'=>'start_date','id'=>'start_date','value'=>@$start_date,'class'=>'datep'));?>
                        </div>
                        <div class="span2">Due Date<br />
                            <?=form_input(array('name'=>'due_date','id'=>'due_date','value'=>@$due_date,'class'=>'datep'));?>
                        </div>
                        <div class="span2">Delivery Date<br />
                            <?=form_input(array('name'=>'delivery_date','id'=>'delivery_date','value'=>@$delivery_date,'class'=>'datep'));?>
                        </div>
                        <div class="span2">Status<br />
                            <?php $array_status=array(''=>'All','done'=>'Done','pending'=>'Pending','canceled'=>'Canceled');
												echo form_dropdown('status',$array_status,$status);
							?></div>
                    </div>
                      <div class="row-form clearfix">
                        <div class="span12" style="text-align: center !important;"><input type="submit" name="search" value="Search" class="btn">
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
                                <li><?=anchor('tasks/sales_list?id='.$sales_man.'&start_date='.@$start_date.'&due_date='.@$due_date.'&delivery_date='.@$delivery_date.'&status='.@$status.'&search=Search','<h3>Print List</h3>',array('target'=>'_blank'))?></li>
                            </ul>
                </div>  
                <div class="block-fluid table-sorting clearfix">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                                <th style="text-align:center"  width="15%">Sales Man</th>
                                <th style="text-align:center"  width="15%">Lists</th>
                                <th style="text-align:center"  width="15%">All </th>
                                <th style="text-align:center" width="15%">Pending </th>
                                <th style="text-align:center" width="10%">Done</th>
                                <th style="text-align:center" width="10%">ACC. Done</th>
                            </tr>
                        </thead>
                        <tbody> 
                        <?php 
						if(count($query)>0){
						foreach($query as $row){
                            $all = $this->Task->GetListTasks('', '', '', '', '', '', $row->salesman_id, date('Y'), '', '', '', '', '','', 0, 0);
							?>
                            <tr>
                                <td style="text-align:center"><?=$row->salesman?></td>
                                <td style="text-align:center"><?=anchor('tasks/lists?list=&sales_man='.$row->salesman_id.'&from_start=&to_start=&from_due=&to_due=&gov=0&district_id=0&area_id=0&status=&category=&search=Search',$all['num_results'])?></td>
                                <td style="text-align:center"><?=$row->all_count?></td>
                                <td style="text-align:center"><?=anchor('tasks?list=&sales_man='.$row->salesman_id.'&from_start=&to_start=&from_due=&to_due=&gov=0&district_id=0&area_id=0&status=pending&category=&search=Search','View ('.$row->pending_count.')')?></td>
                                <td style="text-align:center"><?=anchor('tasks?list=&sales_man='.$row->salesman_id.'&from_start=&to_start=&from_due=&to_due=&gov=0&district_id=0&area_id=0&status=done&category=&search=Search','View ('.$row->done_count.')')?></td>
                                <td style="text-align:center"><?=anchor('tasks/acc?area_id=&district_id=&governorate_id=&salesman='.$row->salesman_id.'&status=yes','View ('.$row->done_acc.')')?></td>
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
