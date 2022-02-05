<style type="text/css">
    .title{
        width:200px !important;
    }
    .text1{
        margin-left:200px !important;
    }
</style>
<?php
$heading_option='id="country_id"  style="width:300px" ';
$market_option='id="market_id" style="width:300px"';
?>
<link href="<?=base_url()?>css/select22.css" rel="stylesheet"/>
<script src="<?=base_url()?>js/select2.js"></script>
<script>
    $(document).ready(function() {
        $("#country_id").select2();
        $("#market_id").select2();
    });
    $(document).ready(function () {
        $('#region-area').hide();
        $('#country-area').hide();
        $('#id_radio1').click(function () {
            $('#region-area').hide('fast');
            $('#country-area').show('fast');
        });
        $('#id_radio2').click(function () {
            $('#country-area').hide('fast');
            $('#region-area').show('fast');
        });
    });
</script>

<div class="content">
    <?=$this->load->view("includes/_bread")?>
    <div class="workplace">
        <div class="page-header">
            <h2><?=$query['name_en'].'/&nbsp;'.$query['name_ar']?></h2>
        </div>
        <div class="row-fluid">

            <div class="span9">
                <?php echo form_open_multipart('companies/market_export',array('id'=>'validation'));
                echo form_hidden('id',$c_id);
                ?>
                <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1>Means of Export :</h1>
                    <h1 style="float:right; margin-right:10px;"> طريقة التصدير </h1>
                </div>
                <div class="block-fluid">
                    <div class="row-form clearfix">
                        <div class="span3"></div>
                        <div class="span3 label-ar"><?php

                            if (@$query['is_exporter'] == 0) {
                                $checked_l = TRUE;
                                $checked_d = FALSE;
                                $checked_m = FALSE;
                            } elseif (@$query['is_exporter'] == 1) {
                                $checked_l = FALSE;
                                $checked_d = TRUE;
                                $checked_m = FALSE;
                            } elseif (@$query['is_exporter'] == 2) {
                                $checked_l = FALSE;
                                $checked_d = FALSE;
                                $checked_m = TRUE;
                            }
                            echo form_radio(array('checked' => $checked_m, 'name' => 'is_exporter', 'value' => 2)) . '&nbsp; بالواسطة'; ?>
                        </div>
                        <div class="span3 label-ar"><?php
                            echo form_radio(array('checked' => $checked_d, 'name' => 'is_exporter', 'value' => 1)) . '&nbsp;  مباشر'; ?>
                        </div>
                        <div class="span3 label-ar"><?php
                            echo form_radio(array('checked' => $checked_l, 'name' => 'is_exporter', 'value' => 0)) . '&nbsp; غير مصدر'; ?>
                        </div>
                    </div>
                    <div class="footer tar">
                        <center><input type="submit" name="save" value="Save" class="btn">
                            <?=anchor('companies/exports/'.$query['id'],'Cancel',array('class'=>'btn'))?></center>
                    </div>
                </div>
                <?=form_close()?>
                <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'validation'));
                echo form_hidden('c_id',$c_id);
                echo form_hidden('action',$action);
                ?>
                <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1><?=$subtitle?>

                    </h1>
                </div>
                <div class="block-fluid">
                    <div class="row-form clearfix">
                        <div class="span3">Market Type:</div>
                        <div class="span1">
                            <input type="radio" name="item_type" value="country" id="id_radio1" />Country</div>
                        <div class="span1"><input type="radio" name="item_type" value="region" id="id_radio2" />Region
                        </div>
                    </div>
                    <div class="row-form clearfix" id="country-area">
                        <div class="span3">Country (اسم الدولة):</div>
                        <div class="span6">
                            <?php
                            $item_array=array(''=>'Select Country');
                            foreach($countries as $country){
                                if(!in_array($country->id,$country_ids)){
                                    $item_array[$country->id]=$country->label_en.' ( '.$country->label_ar.' ) ';
                                }

                            }
                            echo form_dropdown('country_id',$item_array,$country_id,$heading_option);
                            ?>
                        </div>
                    </div>
                    <div class="row-form clearfix" id="region-area">
                        <div class="span3">Market (السوق) :</div>
                        <div class="span6">
                            <div id="marketarea">
                                <?php
                                $markets_array=array(''=>'Select Market');
                                //var_dump($markets_ids);
                                if(count($markets)){
                                    foreach($markets as $market){
                                        if(!in_array($market->id,$markets_ids)){
                                            //echo $market->id;
                                            $markets_array[$market->id]=$market->label_en.' ( '.$market->label_ar.' ) ';
                                        }
                                    }
                                }
                                //var_dump($markets_array);
                                echo form_dropdown('market_id',$markets_array,$market_id,$market_option);
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="footer tar">
                        <center><input type="submit" name="save" value="Save" class="btn">
                            <?=anchor('companies/exports/'.$query['id'],'Cancel',array('class'=>'btn'))?></center>
                    </div>
                </div>
                <?=form_close()?>
                <?php echo form_open('companies/delete_checked',array('id'=>'form_id','name'=>'form1'));
                echo form_hidden('company',$id);
                echo form_hidden('p','exports');
                ?>
                <div class="head clearfix">
                    <div class="isw-grid"></div>
                    <h1>Export & Trade Market &nbsp;&nbsp;
                        <div style="float:right !important; margin-right:10px;">(اسواق البيع والتصدير)</div>
                    </h1>
                    <?=_show_delete_checked('#',TRUE)?>
                </div>
                <div class="block-fluid">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                        <tr>
                            <th><input type="checkbox" name="checkall"/></th>
                            <th>Code</th>
                            <th>Arabic Market </th>
                            <th>English Market</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(count($items)){
                            foreach($items as $item){
                                if($item->item_type=='country')
                                {
                                    $row=$this->Parameter->GetCountryById($item->market_id);
                                    $label_en=$row['label_en'];
                                    $label_ar=$row['label_ar'];
                                }
                                elseif($item->item_type=='region')
                                {
                                    $row=$this->Parameter->GetCompanyMarketById($item->market_id);
                                    $label_en=$row['label_en'];
                                    $label_ar=$row['label_ar'];
                                }
                                ?>
                                <tr>
                                    <td><input type="checkbox" id="check" name="checkbox1[]" value="<?=$item->id?>"/></td>
                                    <td><?=$item->id?></td>
                                    <td><?=$label_ar?></td>
                                    <td><?=$label_en?></td>
                                    <td nowrap="nowrap"><?php echo _show_delete('companies/delete/id/'.$item->id.'/cid/'.$query['id'].'/p/exports',$p_export);
                                        //echo _show_edit('companies/exports/'.$query['id'].'/'.$item->id,$p_export);?></td>
                                </tr>
                            <?php }

                        }
                        else{
                            ?>
                            <tr>
                                <td colspan="5" align="center"><h3>No Trade Market Found</h3></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <?=form_close()?>
            </div>
            <?=$this->load->view('company/_navigation')?>
        </div>
    </div>
</div>
