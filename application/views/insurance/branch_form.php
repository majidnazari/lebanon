<?php
/* * ******************General Info********************* */
$array_name_ar = array('id' => 'name_ar', 'name' => 'name_ar', 'value' => $name_ar);
$array_name_en = array('id' => 'name_en', 'name' => 'name_en', 'value' => $name_en);


/* * *******************Address************************ */
$array_street_ar = array('id' => 'street_ar', 'name' => 'street_ar', 'value' => $street_ar);
$array_street_en = array('id' => 'street_en', 'name' => 'street_en', 'value' => $street_en);

$array_bldg_ar = array('id' => 'bldg_ar', 'name' => 'bldg_ar', 'value' => $bldg_ar);
$array_bldg_en = array('id' => 'bldg_en', 'name' => 'bldg_en', 'value' => $bldg_en);

$array_fax = array('id' => 'fax', 'name' => 'fax', 'value' => $fax);
$array_phone = array('id' => 'phone', 'name' => 'phone', 'value' => $phone);

$array_pobox_ar = array('id' => 'pobox_ar', 'name' => 'pobox_ar', 'value' => $pobox_ar);
$array_pobox_en = array('id' => 'pobox_en', 'name' => 'pobox_en', 'value' => $pobox_en);

$array_beside_ar = array('id' => 'beside_ar', 'name' => 'beside_ar', 'value' => $beside_ar);
$array_beside_en = array('id' => 'beside_en', 'name' => 'beside_en', 'value' => $beside_en);

$array_email = array('id' => 'email', 'name' => 'email', 'value' => $email);
$array_website = array('id' => 'website', 'name' => 'website', 'value' => $website);
?>
<script language="javascript">
    function getdistricts(gov_id)
    {
        $("#district").html("loading ... ");
        $.ajax({
            url: "<?php echo base_url();?>companies/GetDistricts",
            type: "post",
            data: "id=" + gov_id,
            success: function (result) {
                $("#district").html(result);
            }
        });
    }
    function getarea(district_id)
    {
        $("#area").html("loading ... ");
        $.ajax({
            url: "<?php echo base_url();?>companies/GetArea",
            type: "post",
            data: "id=" + district_id,
            success: function (result) {
                $("#area").html(result);
            }
        });
    }
    jQuery(function ($) {
        $("#x_location").mask("99°99'99.99\"");
        $("#y_location").mask("99°99'99.99\"");

    });
</script>
<?php
$jsgov = 'id="gov_id" onchange="getdistricts(this.value)"';
$jsdis = 'id="district_id" onchange="getarea(this.value)"';
?>

<style type="text/css">
    select{
        direction:rtl !important;
    }
    .label-ar{
        text-align:right !important;
        font-size:15px;
        font-weight:bold;
    }
</style>

<div class="content">
    <?=$this->load->view("includes/_bread")?>
    <?php
    echo form_open_multipart($this->uri->uri_string(), array('id' => 'validation'));
    echo form_hidden('insurance_id', $id);
    ?>
    <div class="workplace">
        <div class="page-header">
            <h1><?=$subtitle?></h1>
        </div>

        <div class="row-fluid">
            <div class="span9">
                <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1>Branch Info</h1>
                    <h1 style="float:right; margin-right:10px"> عنوان الفرع</h1>
                </div>
                <div class="block-fluid">
                    <div class="row-form clearfix">
                        <div class="span1">Name : </div>
                        <div class="span5"><?php echo form_input($array_name_en);?>
                            <font color="#FF0000"><?php echo form_error('name_en');?></font></div>
                        <div class="span5" style="text-align:right"><?php echo form_input($array_name_ar);?>
                            <font color="#FF0000"><?php echo form_error('name_ar');?></font></div>
                        <div class="span1 label-ar"> :   الاسم</div>

                    </div>
                    <div class="row-form clearfix">
                        <div class="span3">
                            <div id="area">
                                <?php
                                $area_array = array();
                                if(count($areas) > 0) {
                                    foreach($areas as $area) {

                                        $area_array[$area->id] = $area->label_en.' ( '.$area->label_ar.' )';
                                    }
                                }
                                echo form_dropdown('area_id', $area_array, $area_id);
                                ?>
                                <font color="#FF0000"><?php echo form_error('district_id');?></font></div>
                        </div>
                        <div class="span1 label-ar">البلدة</div>
                        <div class="span3">
                            <div id="district">
                                <?php
                                $district_array = array();
                                if(count($districts) > 0) {
                                    foreach($districts as $district) {

                                        $district_array[$district->id] = $district->label_en.' ( '.$district->label_ar.' )';
                                    }
                                }
                                echo form_dropdown('district_id', $district_array, $district_id, $jsdis);
                                ?>
                                <font color="#FF0000"><?php echo form_error('district_id');?></font></div>
                        </div>
                        <div class="span1 label-ar">  القضاء</div>

                        <?php
                        $gover = array(0 => 'اختر المحافظة');
                        foreach($governorates as $governorate) {

                            $gover[$governorate->id] = $governorate->label_en.' ( '.$governorate->label_ar.' )';
                        }
                        ?>
                        <div class="span3"><?php echo form_dropdown('governorate_id', $gover, $governorate_id, $jsgov);?>
                            <font color="#FF0000"><?php echo form_error('governorate_id');?></font></div>
                        <div class="span1 label-ar"> المحافظة</div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span1">Street : </div>
                        <div class="span5"><?php echo form_input($array_street_en);?>
                            <font color="#FF0000"><?php echo form_error('street_en');?></font></div>
                        <div class="span5" style="text-align:right"><?php echo form_input($array_street_ar);?>
                            <font color="#FF0000"><?php echo form_error('street_ar');?></font></div>
                        <div class="span1 label-ar"> :   شارع</div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span1">Beside : </div>
                        <div class="span5"><?php echo form_input($array_beside_en);?>
                            <font color="#FF0000"><?php echo form_error('beside_en');?></font></div>
                        <div class="span5" style="text-align:right"><?php echo form_input($array_beside_ar);?>
                            <font color="#FF0000"><?php echo form_error('beside_ar');?></font></div>
                        <div class="span1 label-ar"> :   بالقرب</div>

                    </div>
                    <div class="row-form clearfix">
                        <div class="span1">Building: </div>
                        <div class="span5"><?php echo form_input($array_bldg_en);?>
                            <font color="#FF0000"><?php echo form_error('bldg_en');?></font></div>
                        <div class="span5" style="text-align:right"><?php echo form_input($array_bldg_ar);?>
                            <font color="#FF0000"><?php echo form_error('bldg_ar');?></font></div>
                        <div class="span1 label-ar"> : ملك </div>

                    </div>
                    <div class="row-form clearfix">
                        <div class="span6"></div>
                        <div class="span5"><?php echo form_input($array_phone);?>
                            <font color="#FF0000"><?php echo form_error('phone');?></font></div>
                        <div class="span1 label-ar">: هاتف</div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span6"></div>
                        <div class="span5"><?php echo form_input($array_fax);?>
                            <font color="#FF0000"><?php echo form_error('fax');?></font></div>
                        <div class="span1 label-ar">: فاكس </div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span2" >P.O. Box : </div>
                        <div class="span4"><?php echo form_input($array_pobox_en);?>
                            <font color="#FF0000"><?php echo form_error('pobox_en');?></font></div>
                        <div class="span4" style="text-align:right"><?php echo form_input($array_pobox_ar);?>
                            <font color="#FF0000"><?php echo form_error('bldg_ar');?></font></div>
                        <div class="span2 label-ar"> : صندوق بريد </div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span6"></div>
                        <div class="span4"><?php echo form_input($array_email);?>
                            <font color="#FF0000"><?php echo form_error('email');?></font></div>
                        <div class="span2 label-ar">: البريد الالكتروني </div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span6"></div>
                        <div class="span4"><?php echo form_input($array_website);?>
                            <font color="#FF0000"><?php echo form_error('website');?></font></div>
                        <div class="span2 label-ar">: الموقع الالكتروني</div>
                    </div>

                    <div class="row-form clearfix">
                        <center><input type="submit" name="save" value="Save" class="btn btn-large"/>
                            &nbsp;<?=anchor('insurances/branches/'.$id, 'Cancel', array('class' => 'btn btn-large', 'style' => ''))?></center>
                    </div>
                </div>

            </div>
            <?=$this->load->view('insurance/_navigation')?>
        </div>
        <?=form_close()?>
    </div>