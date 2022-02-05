<?php
/* * ******************General Info********************* */
$array_name_ar = array('id' => 'name_ar', 'name' => 'name_ar', 'value' => @$name_ar, 'tabindex' => '1', 'style' => 'direction:rtl !important;', 'required' => 'required');
$array_name_en = array('id' => 'name_en', 'name' => 'name_en', 'value' => @$name_en, 'tabindex' => '2', 'required' => 'required');

$array_address_ar = array('id' => 'address_ar', 'name' => 'address_ar', 'value' => @$address_ar, 'tabindex' => '3', 'style' => 'direction:rtl !important');
$array_address_en = array('id' => 'address_en', 'name' => 'address_en', 'value' => @$address_en, 'tabindex' => '4');

$array_items_ar = array('id' => 'items_ar', 'name' => 'items_ar', 'value' => @$items_ar, 'tabindex' => '5', 'style' => 'direction:rtl !important;');
$array_items_en = array('id' => 'items_en', 'name' => 'items_en', 'value' => @$items_en, 'tabindex' => '6');

$array_trade_mark_ar = array('id' => 'trade_mark_ar', 'name' => 'trade_mark_ar', 'value' => @$trade_mark_ar, 'tabindex' => '7', 'style' => 'direction:rtl !important;');
$array_trade_mark_en = array('id' => 'trade_mark_en', 'name' => 'trade_mark_en', 'value' => @$trade_mark_en, 'tabindex' => '8');
?>
<style type="text/css">
    select{
        direction:rtl !important;
        font-size:14px !important;
    }
    input{
        font-size:14px !important;

    }
    textarea{
        font-size:14px !important;

    }
    .label-ar{
        font-size:14px;
        text-align:right !important;

    }
</style>
<div class="content">
    <?=$this->load->view("includes/_bread")?>
    <?php echo form_open_multipart($this->uri->uri_string(), array('id' => 'validation'));?>
    <div class="workplace">
        <div class="page-header">
            <h1><?=$subtitle?></h1>
        </div>

        <div class="row-fluid">

            <div class="span9">
                <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1>Add Foreign Company</h1>
                    <h1 style="float:right !important; margin-right:10px;">الشركات الاجنبية التي تمثلها في لبنان :</h1>
                </div>
                <div class="block-fluid">
                    <div class="row-form clearfix">
                        <div class="span2">Company Name</div>
                        <div class="span4"><?php echo form_input($array_name_en);?>
                            <font color="#FF0000"><?php echo form_error('name_en');?></font></div>
                        <div class="span4"style="text-align:right !important"><?php echo form_input($array_name_ar);?>
                            <font color="#FF0000"><?php echo form_error('name_ar');?></font></div>
                        <div class="span2 label-ar">: اسم الشركة </div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span2">Address : </div>
                        <div class="span4"><?php echo form_input($array_address_en);?>
                            <font color="#FF0000"><?php echo form_error('address_ar');?></font></div>
                        <div class="span4"style="text-align:right !important"><?php echo form_input($array_address_ar);?>
                            <font color="#FF0000"><?php echo form_error('address_ar');?></font></div>
                        <div class="span2 label-ar"> : العنوان </div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span2">Item : </div>
                        <div class="span4"><?php echo form_input($array_items_en);?>
                            <font color="#FF0000"><?php echo form_error('items_en');?></font></div>
                        <div class="span4"style="text-align:right !important"><?php echo form_input($array_items_ar);?>
                            <font color="#FF0000"><?php echo form_error('items_ar');?></font></div>
                        <div class="span2 label-ar"> : المنتج</div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span2">Trade Mark : </div>
                        <div class="span4"><?php echo form_input($array_trade_mark_en);?>
                            <font color="#FF0000"><?php echo form_error('trade_mark_en');?></font></div>
                        <div class="span4"style="text-align:right !important"><?php echo form_input($array_trade_mark_ar);?>
                            <font color="#FF0000"><?php echo form_error('trade_mark_ar');?></font></div>
                        <div class="span2 label-ar">: العلامة التجارية</div>
                    </div>
                    <div class="footer tar">
                        <center><input type="submit" name="save" value="Save" class="btn">
                            &nbsp;
                            <?=anchor('importers/foreign-companies/'.$id, 'Cancel', array('class' => 'btn'))?>
                        </center>
                    </div>
                </div>
                <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1>Foreign Companies Represented in Lebanon</h1>
                    <h1 style="float:right; margin-right:10px">: الشركات الاجنبية التي تمثلها في لبنان </h1>
                </div>
                <div class="block-fluid">

                    <div class="row-form clearfix">
                        <?php if(count($fcompanies) > 0) {?>
                            <table  cellpadding="0" cellspacing="0" width="100%" class="table">
                                <thead>
                                    <tr>
                                        <th><strong>Company Name</strong></th>
                                        <th><strong>Address</strong></th>
                                        <th><strong>Items Imported</strong></th>
                                        <th><strong>Trade Mark</strong></th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                </tr>
                                <tbody>
                                    <?php foreach($fcompanies as $fcompany) {?>
                                        <tr>
                                            <td><?php echo $fcompany->name_ar?></td>
                                            <td><?php echo $fcompany->address_ar?></td>
                                            <td><?php echo $fcompany->items_ar?></td>
                                            <td><?php echo $fcompany->trade_mark_ar?></td>
                                            <td><?php
                                        echo _show_delete('importers/delete/id/'.$fcompany->id.'/p/foreign/imp/'.$id, $p_foreign_companies);
                                        echo _show_edit('importers/update/'.$fcompany->id.'/'.$id, $p_foreign_companies);
                                        ?></td>
                                        </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        <?php }?>


                    </div>


                </div>
            </div>
            <?=$this->load->view('importer/_navigation')?>
        </div>
        <?=form_close()?>
    </div>