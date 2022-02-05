
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

    function updatestatus()
        {
			checkboxes = document.getElementsByName('checkall');
			checkboxes.checked =true;
            document.getElementById("form_id").action = "<?=base_url().'reports/update_tasks'?>";
            document.getElementById("form_id").submit();

        }
    function addcomments(id)
    {
       var _id=id;
        document.getElementById("comment"+_id).action = "<?=base_url().'reports/tasks_comments'?>";
        document.getElementById("comment"+_id).submit();

    }
</script>
<?php
if(@$districtID=='')
$districtID=0;
$class_sect='  id="governorate_id" onchange="getdistrict(this.value,'.$districtID.')"';

?>
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
                <?php echo form_open('',array('id'=>'form_id','name'=>'form1'));
                            $b_status=($status == 'pending') ? 'done' : 'pending';
                        echo form_hidden('id',$id);
                        echo form_hidden('bstatus',$b_status);
                ?>
                <div class="head clearfix">
                    <div class="isw-grid"></div>
                    <h1><?=$subtitle?></h1>
                    <a href="javascript:void(0)" onclick="updatestatus()"><h1 style="float: right">Update Status</h1></a>
                    <?=anchor('companies/tasks_print/'.$id.'/'.$status,'<h1 style="float: right">Print All</h1>')?>
                    <?=anchor('reports/tasks_export/'.$id.'/'.$status,'<h1 style="float: right">Export To Excel</h1>')?>
                </div>  
                <div class="block-fluid table-sorting clearfix">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                                <th><input type="checkbox" name="checkall"/></th>
                                <th>Company</th>
                                <th>Mohafaz</th>
                                <th>Kazaa</th>
                                <th>Area</th>
                                <th>Status</th>
                                <th>Update Info</th>
                                <th>Assign To</th>
                                <th>Copy Reservation</th>
                                <th>Advertiser</th>
                                <th>Update Time</th>
                                <th>Comments</th>
                            </tr>
                        </thead>
                        <tbody> 
                        <?php

						if(count($query)>0){
						foreach($query as $row){
                            echo form_open_multipart('',array('id'=>'comment'.$row->id));
                            echo form_hidden('id',$row->id);
                            ?>
                            <div id="CreateModal<?=$row->id?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h3 id="myModalLabel">Comments</h3>
                                </div>
                                <div class="row-fluid">
                                    <div class="block-fluid">

                                        <div class="row-form clearfix">
                                            <div class="span12"><?=form_textarea(array('name'=>'comments','cols'=>40,'rows'=>6,'value'=>@$row->comments));?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="dr"><span></span></div>
                                </div>
                                <div class="modal-footer">
                                    <a href="javascript:void(0)" onclick="addcomments(<?=$row->id?>)" class="btn">Save</a>
                                    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                                </div>
                            </div>
                            <?php echo form_close();
						    if($row->status=='pending')
						        $css='btn btn-warning';
						    else
                                $css='btn';
							?>
                            <tr>
                                <td><input type="checkbox" id="check" name="checkbox1[]" value="<?=$row->id?>"/><?=$row->item_id?></td>
                                <td><?=$row->company_name_ar.'<br>'.$row->company_name_en?></td>
                                <td><?=$row->governorate_ar.'<br>'.$row->governorate_en?></td>
                                <td><?=$row->district_ar.'<br>'.$row->district_en?></td>
                                <td><?=$row->area_ar.'<br>'.$row->area_en?></td>
                                <td><?=anchor('companies?id=&ministry_id=&name=&activity=&phone=&gov=',$row->status,array('class'=>$css))?></td>
                                <td><?php echo ($row->updated_info == 1) ? 'Yes' : 'No';?></td>
                                <td><?=$row->fullname?></td>
                                <td><?php echo ($row->copy_res == 1) ? 'Yes' : 'No';?></td>
                                <td><?php echo ($row->advertiser == 1) ? 'Yes' : 'No';?></td>
                                <td><?=$row->update_time?></td>
                                <td><a href="#CreateModal<?=$row->id?>" data-toggle="modal" class="btn">Comments</a></td>
                            </tr>
                            
                        <?php

						}
						}
						else{
								echo '<tr>
                            	<td colspan="11"><center><strong>No Data Found</strong></center></td>
                            </tr>';
							}
						
						?>    
                        </tbody>
                        <tfoot>
                        	<tr>
                                <td colspan="11">Total : <?=count($query)?></td></tr>
                        </tfoot>
                    </table>
                    
                </div>
                <?php echo form_close();?>
            </div>
        </div>
        <div class="dr"><span></span></div>            
    </div>
</div>
