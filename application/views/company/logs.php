<script language="javascript">

    $(function () {
        $("#from").datepicker({
            dateFormat: "yy-mm-dd"
        });
        $("#to").datepicker({
            dateFormat: "yy-mm-dd"
        });
    })

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
                <?php echo form_open_multipart($this->uri->uri_string(), array('id' => 'validation', 'method' => 'get'));
                ?>
                <div class="block-fluid">

                    <div class="row-form clearfix">
                        <div class="span2">Company ID : <br /><?php echo form_input(array('name' => 'company', 'value' => @$company, 'id' => 'company'));?></div>
                        <div class="span2">From : <br /><?php echo form_input(array('name' => 'from', 'value' => @$from, 'id' => 'from'));?></div>
                        <div class="span2">To :<br /><?php echo form_input(array('name' => 'to', 'value' => @$to, 'id' => 'to'));?></div>
                        <div class="span2">Users<br />
                            <?php
                            $array_users = array('' => 'All');
                            if(count($users) > 0) {
                                foreach($users as $useri) {
                                    $array_users[$useri->id] = $useri->fullname.' ('.$useri->username.' )';
                                }
                            }
                            echo form_dropdown('user', $array_users, @$user);
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
                <?php echo form_open('',array('id'=>'form_id','name'=>'form1'));	?>
                <div class="head clearfix">
                    <div class="isw-grid"></div>
                    <h1><?=$subtitle?></h1>
                    <?php /*
                        <ul class="buttons">
                            <li><a href="#CreateModal" data-toggle="modal"><h3>Assign To</h3></a></li>
                           <!-- <li><?=anchor('companies/printw','<h3>Print Wizara</h3>')?></li>-->
                               <!-- <li><?=_show_delete_checked('#',$p_delete)?></li>-->
                                <li><a  href="javascript:void(0)" onclick="printall()"><h3>Print Selected</h3></a></li>
                                <?php if(@$search){ ?>
                                 <li><?=anchor('companies/listview?id=' . @$id . '&ministry_id=' . @$ministry_id . '&name=' . @$name . '&activity=' . @$activity . '&phone=' . @$phone . '&gov=' . @$govID . '&district_id=' . @$districtID . '&area_id=' . @$areaID . '&status=' . @$status,'<h3>Print List</h3>')?></li>
                                 <?php } ?>
                              
                            </ul> 
                            */?>
                </div>  
                <div class="block-fluid table-sorting clearfix">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                                <th style="text-align:center"  width="20%">Company ID</th>
                                <th style="text-align:center" width="10%">Company Name AR</th>
                                <th style="text-align:center" width="10%">Company Name EN</th>
                                <th style="text-align:center" width="15%">Date</th>
                                <th style="text-align:center" width="10%">User</th>
                                <th style="text-align:center" width="10%">User Full Name</th>
                            </tr>
                        </thead>
                        <tbody> 
                        <?php 
						if(count($query)>0){
						foreach($query as $row){?>
                            <tr>
                                <td><?=$row->id?></td>
                                <td><?=anchor('companies/details/'.$row->id,$row->name_ar)?></td>
                                <td><?=anchor('companies/details/'.$row->id,$row->name_en)?></td>
                                <td><?=$row->logs_create_time?></td>
                                <td><?=$row->username?></td>
                                <td><?=$row->fullname?></td>
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
