
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
                    <div class="isw-grid"></div>
                    <h1><?=$subtitle?></h1>

                        <?=anchor('reports/minitry_export','<h1 style="float: right">Export To Excel</h1>')?>
                </div>  
                <div class="block-fluid table-sorting clearfix">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th style="text-align:center">اسم الشركة</th>
                                <th style="text-align:center">الشركات</th>
                                <th style="text-align:center" width="16%">Update Time</th>
                                <th style="text-align:center" width="16%">Created By</th>
                            </tr>
                        </thead>
                        <tbody> 
                        <?php

						if(count($query)>0){
						foreach($query as $row){
                            $companies=json_decode($row->companies);
                            //$companies=array();
							?>
                            <tr>
                                <td><?=$row->ministry_id?></td>
                                <td><?=$row->title?></td>
                                <td>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Company ID</th>
                                                <th>Wezara ID</th>
                                                <th>Name</th>
                                            </tr>
                                        </thead>
                                        <?php
                                            if(count($companies)>0) {
                                                foreach ($companies as $company) {

                                                    echo '<tr><td>' . $company->id . '</td><td>' . $company->ministry_id . '</td><td>' . $company->name_ar . '</td></tr>';
                                                }
                                            }

								?>
                                    </table>
                                        </td>
                                
                                <td><?=$row->update_time?></td>
                                <td><?=$row->username?></td>
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
