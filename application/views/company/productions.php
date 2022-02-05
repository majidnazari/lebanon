<style type="text/css">
    .title{
        width:200px !important;
    }
    .text1{
        margin-left:200px !important;
    }
</style>

<script language="javascript">
    function delete_checked()
    {
        checkboxes = document.getElementsByName('checkall');
        checkboxes.checked = true;
        document.getElementById("form_id").action = "<?=base_url().'companies/delete_checked/delete_item'?>";
        var answer = confirm("Are You Sure ?")
        if(answer) {
            document.getElementById("form_id").submit();
        } else {
            return false
        }


    }

    function searchproduction()
    {
        var code = $("#heading").val();
        var desc = $("#description").val();
        //alert(desc);
        $("#item").html("loading ... ");
        $.ajax({
            url: "<?php echo base_url();?>companies/SearchProduction",
            type: "post",
            data: "code=" + code + "&description=" + desc + "&companyid=<?=$query['id']?>",
            success: function (result) {
                $("#item").html(result);
            }
        });
    }
</script>
<?php
$heading_option = 'id="heading_id" onchange="displayitem(this.value)" style="width:500px"';
$jsdis = 'id="district_id" onchange="getarea(this.value)"';
?>
<link href="<?=base_url()?>css/select22.css" rel="stylesheet"/>
<script src="<?=base_url()?>js/select2.js"></script>
<script>
    $(document).ready(function () {
        $("#heading_id").select2();
    });
</script>
<div class="content">
    <?=$this->load->view("includes/_bread")?>

    <div class="workplace">

        <div class="page-header">
            <h2><?=$query['name_en'].'/&nbsp;'.$query['name_ar']?></h2>
        </div>

        <?php if($msg != '') {?>
            <div class="row-fluid">
                <div class="alert alert-success">
                    <?php echo $msg;?>
                </div>
            </div>
        <?php }?>
        <div class="row-fluid">
            <div class="span9">
                <?php
                echo form_open_multipart($this->uri->uri_string(), array('id' => 'validation'));
                echo form_hidden('c_id', $c_id);
                echo form_hidden('action', $action);
                ?>
                <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1><?=$subtitle?></h1>
                </div>
                <div class="block-fluid">
                    <div class="row-form clearfix">
                        <div class="span2">H.S Code (البند الجمركي) :</div>
                        <div class="span3"><?php echo form_input(array('name' => 'label_h', 'id' => 'heading'));?></div>
                        <div class="span2">Description (الوصف)</div>
                        <div class="span3"><?php echo form_input(array('name' => 'description', 'id' => 'description'));?></div>
                        <div class="span2"><a href="javascript:void(0)" onclick="searchproduction()" class="btn">Search</a></div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span12"><div id="item"><?=$display?></div></div>
                    </div>

                </div>
                <?=form_close()?>
                <div class="row-fluid">

                    <div class="span12">
                        <div class="head clearfix">
                            <div class="isw-grid"></div>

                            <h1>Production Information &nbsp;&nbsp;: <?=count($productions)?> </h1>
                            <div style="float:right !important; margin-right:10px;">
                                <a href="javascript:void(0)" onclick="delete_checked()">
                                    <h2 style="float:right !important; color:#FFF !important">Delete Checked</h2></a></div>

                            <?php //_show_add('companies/production-create/'.$query['id'],'Add New',TRUE)?>
                        </div>
                        <div class="block-fluid">
                            <?php
                            echo form_open('', array('id' => 'form_id', 'name' => 'form1'));
                            echo form_hidden('company', $query['id']);
                            echo form_hidden('p', 'items');
                            ?>
                            <table cellpadding="0" cellspacing="0" width="100%" class="table">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" name="checkall"/></th>
                                        <th>H.S.Code</th>
                                        <th>الانتاج</th>
                                        <th>Items</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(count($productions)) {
                                        foreach($productions as $production) {
                                            if($production->heading_description_ar != '') {
                                                $item_ar = $production->heading_description_ar;
                                            }
                                            else {
                                                $item_ar = $production->heading_ar;
                                            }
                                            if($production->heading_description_en != '') {
                                                $item_en = $production->heading_description_en;
                                            }
                                            else {
                                                $item_en = $production->heading_en;
                                            }
                                            ?>
                                            <tr>
                                                <td><input type="checkbox" id="check" name="checkbox1[]" value="<?=$production->id?>"/></td>
                                                <td><?=$production->hscode?></td>
                                                <td style="direction:rtl !important; text-align:right"><?=$production->heading_description_ar?></td>
                                                <td><?=$production->heading_description_en?></td>
                                                <td nowrap="nowrap"><?php
                                                    echo _show_delete('companies/delete/id/'.$production->id.'/cid/'.$query['id'].'/p/items', $p_delete);
                                                    echo _show_edit('companies/productions/'.$query['id'].'/'.$production->id, $p_delete);
                                                    ?></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    else {
                                        ?>
                                        <tr>
                                            <td colspan="4" align="center"><h3>No Production Found</h3></td>
                                        </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?=$this->load->view('company/_navigation')?>
        </div>




        <div class="dr"><span></span></div>
    </div>
</div>

