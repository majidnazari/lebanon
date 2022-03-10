<style type="text/css">
    .title{
        width:200px !important;
    }
    .text1{
        margin-left:200px !important;
    }
</style>
<?php
$heading_option = 'id="country_id"  style="width:300px" ';
$market_option = 'id="market_id" style="width:300px"';
?>
<link href="<?=base_url()?>css/select22.css" rel="stylesheet"/>
<script src="<?=base_url()?>js/select2.js"></script>
<script>
    $(document).ready(function () {
        $("#country_id").select2();
        $("#market_id").select2();
    });
    $(document).ready(function () {
        $('#region-area').hide();
        $('#country-area').hide();
        $("#market_id").prop("disabled", true);
        $("#country_id").prop("disabled", true);

<?php
if(@$type == 'country') {
    ?>

            $("#country_id").prop("disabled", false);
            //  $("#country_id").attr("checked", true);
            $('#country-area').show();
    <?php
}
elseif(@$type == 'region') {
    ?>

            $("#market_id").prop("disabled", false);
            // $("#market_id").attr("checked", true);
            $('#region-area').show();
<?php }?>

        $('#id_radio1').click(function () {
            $('#region-area').hide('fast');
            $("#country_id").prop("disabled", false);
            $("#market_id").prop("disabled", true);
            $('#country-area').show('fast');

        });
        $('#id_radio2').click(function () {
            $('#country-area').hide('fast');
            $("#country_id").prop("disabled", true);
            $("#market_id").prop("disabled", false);
            $('#region-area').show('fast');
        });
    });
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
                <div class="row-fluid">
                    <div class="span12">
                        <?php
                        echo form_open_multipart($this->uri->uri_string(), array('id' => 'validation', 'method' => 'get'));
                        echo form_hidden('lang', 'ar');
                        ?>

                        <div class="block-fluid">
                            <div class="row-form clearfix">
                                <div class="span3">Market Type:</div>
                                <div class="span1">
                                    <?php
                                    $country_checked = '';
                                    $region_checked = '';
                                    if(@$type == 'country') {
                                        $country_checked = 'checked';
                                    }
                                    elseif(@$type == 'region') {
                                        $region_checked = 'checked';
                                    }
                                    ?>
                                    <input type = "radio" name = "type" <?=$country_checked?> value = "country" id = "id_radio1" />Country</div>
                                <div class = "span1"><input type = "radio" name = "type" <?=$region_checked?> value = "region" id = "id_radio2" />Region
                                </div>
                            </div>
                            <div class = "row-form clearfix" id = "country-area">
                                <div class = "span3">Country (اسم الدولة):</div>
                                <div class = "span6">
                                    <?php
                                    $item_array = array('' => 'Select Country');
                                    foreach($countries as $country) {
                                        $item_array[$country->id] = $country->label_en.' ( '.$country->label_ar.' ) ';
                                    }
                                    echo form_dropdown('id', $item_array, @$id, $heading_option);
                                    ?>
                                </div>
                            </div>
                            <div class="row-form clearfix" id="region-area">
                                <div class="span3">Market (السوق) :</div>
                                <div class="span6">
                                    <div id="marketarea">
                                        <?php
                                        $markets_array = array('' => 'Select Market');
                                        //var_dump($markets_ids);
                                        if(count($markets)) {
                                            foreach($markets as $market) {
                                                $markets_array[$market->id] = $market->label_en.' ( '.$market->label_ar.' ) ';
                                            }
                                        }
                                        //var_dump($markets_array);
                                        echo form_dropdown('id', $markets_array, @$id, $market_option);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="footer tar">
                                <center><input type="submit" name="search" value="Search" class="btn">
                                    <?=anchor('reports/markets', 'Cancel', array('class' => 'btn'))?></center>
                            </div>
                        </div>
                        <?=form_close()?>


                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <?php echo form_open('', array('id' => 'form_id', 'name' => 'form1'));?>
                        <div class="head clearfix">
                            <div class="isw-grid"></div>
                            <h1 style="float:right !important; margin-right:10px !important">الشركات المصدرة</h1>
                            <?php
                            // echo anchor('reports/markets/en', '<h3 style="float:left !important; color:#FFF !important">English  - </h3>');
                            echo anchor('reports/ExportMarkets?lang=ar&type='.@$type.'&id='.@$id.'&search=Search', '<h3 style="float:left !important; color:#FFF !important">Export To Excel</h3>');
                            ?>
                        </div>
                        <div class="block-fluid table-sorting clearfix">
                            <table cellpadding="0" cellspacing="0" width="100%" class="table">
                                <thead>
                                    <tr>
                                        <th>البريد اللكتروني</th>
                                        <th>ص.ب</th>
                                         <!--<th>فاكس</th>-->
                                        <th>هاتف</th>
                                        <th>واتساپ</th>
                                        <th>الشارع</th>
                                        <th>المدينة</th>
                                        <th>قضاء</th>
                                        <th>الشركة</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach($query as $row) {
                                        ?>
                                        <tr>
                                            <td style="text-align:right"><?=$row->email?></td>
                                            <td style="direction:rtl !important; text-align:right !important"><?=$row->pobox_ar?></td>
                                          <!--  <td style="text-align:right"><?=$row->fax?></td>-->
                                            <td style="text-align:right"><?=$row->phone?></td>
                                            <td style="text-align:right"><?=$row->whatsapp?></td>
                                            <td style="direction:rtl !important; text-align:right !important"><?=$row->street_ar?></td>
                                            <td style="text-align:right"><?=$row->area_ar?></td>
                                            <td style="text-align:right"><?=$row->district_ar?></td>
                                            <td style="direction:rtl !important; text-align:right !important"><?=$row->name_ar?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr><td colspan="6"></td></tr>
                                </tfoot>
                            </table>

                        </div>
                        <?php echo form_close();?>
                    </div>
                </div>
                <div class="dr"><span></span></div>
            </div>
        </div>
