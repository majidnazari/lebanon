<style type="text/css">
    .ar{
        text-align:right !important;
        direction:rtl;
    }
</style>
<?php
$array_code = array('name' => 'code', 'id' => 'code', 'value' => $code);
$array_item = array('name' => 'item', 'id' => 'item', 'value' => $item);
$array_description = array('name' => 'description', 'id' => 'description', 'value' => $description);
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
</script>
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
                        <div class="span3">H.S Code <br /><?php echo form_input($array_code);?></div>
                        <div class="span3">Item<br /><?php echo form_input($array_item);?></div>
                        <div class="span3">Description<br /><?php echo form_input($array_description);?></div>
                        <div class="span3"><br /><input type="submit" name="search" value="Search" class="btn">
                            <input type="submit" name="clear" value="Clear" class="btn">
                        </div>
                    </div>
                </div>
                <?php echo form_close()?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <?php if($msg != '') {?>
                    <div class="alert alert-success">
                        <?php echo $msg;?>
                    </div>
                <?php }?>
                <?php echo form_open('', array('id' => 'form_id', 'name' => 'form1'));?>
                <div class="head clearfix">
                    <div class="isw-grid"></div>
                    <h1><?=$subtitle?></h1>
                    <?php
					 echo _show_add_pop('#ChangingModal','Moving Items between companies',$p_move_item);
                    echo _show_add('items/create', 'Add New Item', $p_add_item);
                    echo _show_delete_checked('#', $p_delete_item)
                    ?>
                </div>
                <div class="block-fluid table-sorting clearfix">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table" style="direction:rtl !important">
                        <thead>
                            <tr>
                                <th><input type="checkbox" name="checkall"/></th>
                                <th style="text-align:center">الرمز</th>
                                <th style="text-align:center" width="25%">الصنف</th>
                                <th style="text-align:center" width="25%">وصف خاص</th>
                                <th style="text-align:center; border:1px solid #DDDDDD" width="25%">الفصل</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if(count($query) > 0) {
                                foreach($query as $row) {
                                    $user = $this->Administrator->GetUserById($row->user_id);
                                    if(count($user) > 0) {
                                        $createdBy = $user['fullname'].' ('.$user['username'].' )';
                                    }
                                    else {
                                        $createdBy = 'N/A';
                                    }
                                    ?>
                                    <tr>
                                        <td><input type="checkbox" id="check" name="checkbox1[]" value="<?=$row->id?>"/></td>
                                        <td style="text-align:center"><?=$row->hs_code.'<br>'.$row->hs_code_print?></td>
                                        <td class="ar"><?=anchor('items/details/'.$row->id, $row->label_ar.'<br>'.$row->label_en)?></td>
                                        <td class="ar"><?=$row->description_ar.'<br>'.$row->description_en?></td>
                                        <td class="ar" style=" border:1px solid #DDDDDD;"><?=$row->chapter_ar.'<br>'.$row->chapter_en?></td>

                                        <td>

                                            <?php
                                            echo anchor('items/details/'.$row->id, 'View');
                                            echo _show_new('items/create/'.$row->id, $p_add_item);
                                            echo _show_delete('items/delete/id/'.$row->id.'/p/item/', $p_delete_item);
                                            echo _show_edit('items/edit/'.$row->id, $p_edit_item);


                                            if($row->status == 'online')
                                                echo '<span class="label label-success">Online</span>';
                                            else
                                                echo '<span class="label">Offline</span>';
                                            ?>
                                        </td>
                                    </tr>

                                    <?php
                                }
                            }
                            else {
                                echo '<tr>
                            	<td colspan="6"><center><strong>No Data Found</strong></center></td>
                            </tr>';
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7" style="direction:ltr !important">Total : <?=$total_row?><div class="dataTables_paginate paging_full_numbers"><?=$links?></div></td></tr>
                        </tfoot>
                    </table>

                </div>
                <?php echo form_close();?>
            </div>
        </div>
        <div class="dr"><span></span></div>
    </div>
</div>

<?php if($p_move_item){ 
		
?>
<div id="ChangingModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Moving  Items</h3>
    </div>  
    <?php echo form_open_multipart('items/moving_item',array('id'=>'validation'));?>      
    <div class="row-fluid">
        <div class="block-fluid">
            <div class="row-form clearfix">
                <div class="span3">Old Item *:</div>
                <div class="span9">
                	<?=form_input(array('name'=>'old_item','required'=>'required'))?>
                </div>
            </div>            
            <div class="row-form clearfix">
                <div class="span3">New Item *:</div>
                <div class="span9"><?=form_input(array('name'=>'new_item','required'=>'required'))?></div>
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


