<?php
/* * ******************General Info********************* */
$array_name_ar = array('id' => 'name_ar', 'name' => 'name_ar', 'value' => $name_ar);
$array_name_en = array('id' => 'name_en', 'name' => 'name_en', 'value' => $name_en);

$array_cr_ar = array('id' => 'cr_ar', 'name' => 'cr_ar', 'value' => $cr_ar);
$array_cr_en = array('id' => 'cr_en', 'name' => 'cr_en', 'value' => $cr_en);
$array_est_date = array('id' => 'est_date', 'name' => 'est_date', 'value' => $est_date);

$array_owner_ar = array('id' => 'owner_ar', 'name' => 'owner_ar', 'value' => $owner_ar);
$array_owner_en = array('id' => 'owner_en', 'name' => 'owner_en', 'value' => $owner_en);


$array_personal_notes = array('id' => 'personal_notes', 'name' => 'personal_notes', 'value' => $personal_notes, 'style' => 'height:250px !important');

/* * *******************Address************************ */
$array_street_ar = array('id' => 'street_ar', 'name' => 'street_ar', 'value' => $street_ar);
$array_street_en = array('id' => 'street_en', 'name' => 'street_en', 'value' => $street_en);

$array_bldg_ar = array('id' => 'bldg_ar', 'name' => 'bldg_ar', 'value' => $bldg_ar);
$array_bldg_en = array('id' => 'bldg_en', 'name' => 'bldg_en', 'value' => $bldg_en);

$array_fax = array('id' => 'fax', 'name' => 'fax', 'value' => $fax);
$array_phone = array('id' => 'phone', 'name' => 'phone', 'value' => $phone);
$array_whatsapp = array('id' => 'whatsapp', 'name' => 'whatsapp', 'value' => $whatsapp);

$array_pobox_ar = array('id' => 'pobox_ar', 'name' => 'pobox_ar', 'value' => $pobox_ar, 'style' => 'direction:rtl');
$array_pobox_en = array('id' => 'pobox_en', 'name' => 'pobox_en', 'value' => $pobox_en);

$array_email = array('id' => 'email', 'name' => 'email', 'value' => $email);
$array_website = array('id' => 'website', 'name' => 'website', 'value' => $website);
$array_x_location = array('id' => 'x_location', 'name' => 'x_location', 'value' => $x_location);
$array_y_location = array('id' => 'y_location', 'name' => 'y_location', 'value' => $y_location);

/* * *******************Molhak************************ */
$array_res_person_ar = array('id' => 'res_person_ar', 'name' => 'res_person_ar', 'value' => $res_person_ar);
$array_res_person_en = array('id' => 'res_person_en', 'name' => 'res_person_en', 'value' => $res_person_en);

$array_app_fill_date = array('id' => 'app_refill_date', 'name' => 'app_refill_date', 'value' => @$app_refill_date);

$array_adv_pic = array('id' => 'adv_pic', 'name' => 'adv_pic', 'value' => $adv_pic);
?>

<script language="javascript">
    $(function () {
        $("#app_refill_date").datepicker({
            dateFormat: "yy-mm-dd"
        });
        $("#end_date").datepicker({
            dateFormat: "yy-mm-dd"
        });
        //$( "#app_fill_date" ).datepicker();
    });
    $(document).ready(function () {
        $("#other-area").hide();
        $("#other").click(function () {
            if($('#other').is(":checked"))
            {
                $("#other-area").show();
            } else
            {
                $("#other-area").hide();
            }
        });
    });
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

</script>

<style type="text/css">
    .row-form{
        font-size:14px !important;
    }
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
        float:right !important;
        margin-left:5px !important;
        text-align:right !important;
        font-size:15px !important;
    }
    .h1-ar{
        float:right !important;
        margin-right:10px !important;
        font-size:18px !important
    }
</style>

<?php
$jsgov = 'id="gov_id" onchange="getdistricts(this.value)" required="required"';
$jsdis = 'id="district_id" onchange="getarea(this.value)" required="required"';
?>
<div class="content">
    <?=$this->load->view("includes/_bread")?>
    <?php
    echo form_open_multipart($this->uri->uri_string(), array('id' => 'validation'));
    echo form_hidden('c_id', $c_id);
    //echo form_hidden('adv_pic',$adv_pic);
    ?>
    <div class="workplace">

        <div class="page-header">
            <h1><?=$subtitle?>
                <input type="submit" name="save" value="Save" class="btn btn-large" style="float:right !important">
                &nbsp;

                <?php
                if($nave) {
                    echo anchor('transportations/details/'.$id, 'Cancel', array('class' => 'btn btn-large', 'style' => 'float:right !important; margin-right:10px'));
                }
                else {
                    echo anchor('transportations/', 'Cancel', array('class' => 'btn btn-large', 'style' => 'float:right !important; margin-right:10px'));
                }
                ?>
            </h1>
        </div>

        <div class="row-fluid">
            <?php
            if($nave) {
                echo '<div class="span4">';
            }
            else {
                echo '<div class="span6">';
            }
            ?>
            <div class="head clearfix">
                <div class="isw-documents"></div>
                <h1>Address</h1>
                <h1 style="float:right; margin-right:10px"> عنوان المؤسسة</h1>
            </div>
            <div class="block-fluid">
                <div class="row-form clearfix">
                    <div class="span8"><?php echo form_input(array('name' => 'ref', 'value' => @$ref));?>
                        <font color="#FF0000"><?php echo form_error('ref');?></font></div>
                    <div class="span4" style="text-align:right !important">مرجع</div>
                </div>
                <div class="row-form clearfix">

                    <?php
                    $gover = array('' => 'اختر المحافظة');
                    foreach($governorates as $governorate) {

                        $gover[$governorate->id] = $governorate->label_ar.' ( '.$governorate->label_en.' )';
                    }
                    ?>
                    <div class="span8"><?php echo form_dropdown('governorate_id', $gover, $governorate_id, $jsgov);?>
                        <font color="#FF0000"><?php echo form_error('governorate_id');?></font></div>
                    <div class="span4" style="text-align:right !important"><font color="#FF0000">*</font>: المحافظة</div>
                </div>
                <div class="row-form clearfix">

                    <div class="span8">
                        <div id="district">
                            <?php
                            $district_array = array('' => 'اختر القضاء');
                            if(count($districts) > 0) {
                                foreach($districts as $district) {

                                    $district_array[$district->id] = $district->label_ar.' ( '.$district->label_en.' )';
                                }
                            }
                            echo form_dropdown('district_id', $district_array, $district_id, $jsdis);
                            ?>
                            <font color="#FF0000"><?php echo form_error('district_id');?></font></div>
                    </div>
                    <div class="span4" style="text-align:right !important"><font color="#FF0000">*</font>:  القضاء</div>
                </div>
                <div class="row-form clearfix">

                    <div class="span8">
                        <div id="area">
                            <?php
                            $area_array = array('' => 'اختر البلدة');
                            if(count($areas) > 0) {
                                foreach($areas as $area) {

                                    $area_array[$area->id] = $area->label_ar.' ( '.$area->label_en.' )';
                                }
                            }
                            echo form_dropdown('area_id', $area_array, $area_id, ' required="required"');
                            ?>
                            <font color="#FF0000"><?php echo form_error('district_id');?></font></div>
                    </div>
                    <div class="span4" style="text-align:right"><font color="#FF0000">*</font>:  البلدة</div>
                </div>
                <div class="row-form clearfix">
                    <div class="span8" style="text-align:right"><?php echo form_input($array_street_ar);?>
                        <font color="#FF0000"><?php echo form_error('street_ar');?></font></div>
                    <div class="span4" style="text-align:right"> :   شارع</div>
                </div>
                <div class="row-form clearfix">

                    <div class="span8"><?php echo form_input($array_street_en);?>
                        <font color="#FF0000"><?php echo form_error('street_en');?></font></div>
                    <div class="span4" style="text-align:right" > : Street</div>
                </div>
                <div class="row-form clearfix">
                    <div class="span8" style="text-align:right"><?php echo form_input($array_bldg_ar);?>
                        <font color="#FF0000"><?php echo form_error('bldg_ar');?></font></div>
                    <div class="span4" style="text-align:right"> : بناية </div>
                </div>
                <div class="row-form clearfix">
                    <div class="span8"><?php echo form_input($array_bldg_en);?>
                        <font color="#FF0000"><?php echo form_error('bldg_en');?></font></div>
                    <div class="span4" style="text-align:right">: Building</div>
                </div>
                <div class="row-form clearfix">
                    <div class="span8" style="text-align:right">
                        <?php echo form_input(array('name' => 'address2_ar', 'value' => @$address2_ar));?>
                        <font color="#FF0000"><?php echo form_error('address2_ar');?></font></div>
                    <div class="span4" style="text-align:right"> : العنوان ٢ </div>
                </div>
                <div class="row-form clearfix">
                    <div class="span8"><?php echo form_input(array('name' => 'address2_en', 'value' => @$address2_en));?>
                        <font color="#FF0000"><?php echo form_error('address2_en');?></font></div>
                    <div class="span4" style="text-align:right">: Address 2</div>
                </div>

                <div class="row-form clearfix">
                    <div class="span8"><?php echo form_input($array_phone);?>
                        <font color="#FF0000"><?php echo form_error('phone');?></font></div>
                    <div class="span4" style="text-align:right">: هاتف</div>
                </div>
                <div class="row-form clearfix">
                    <div class="span8"><?php echo form_input($array_whatsapp);?>
                        <font color="#FF0000"><?php echo form_error('whatsapp');?></font></div>
                    <div class="span4" style="text-align:right">: واتساپ</div>
                </div>
                <div class="row-form clearfix">
                    <div class="span8"><?php echo form_input($array_fax);?>
                        <font color="#FF0000"><?php echo form_error('fax');?></font></div>
                    <div class="span4" style="text-align:right">: فاكس </div>
                </div>
                <div class="row-form clearfix">
                    <div class="span8" style="text-align:right !important"><?php echo form_input($array_pobox_ar);?>
                        <font color="#FF0000"><?php echo form_error('pobox_ar');?></font></div>
                    <div class="span4" style="text-align:right"> : صندوق بريد </div>
                </div>
                <div class="row-form clearfix">

                    <div class="span8"><?php echo form_input($array_pobox_en);?>
                        <font color="#FF0000"><?php echo form_error('pobox_en');?></font></div>
                    <div class="span4" style="text-align:right">: P.O. Box </div>
                </div>
                <div class="row-form clearfix">
                    <div class="span8"><?php echo form_input($array_email);?>
                        <font color="#FF0000"><?php echo form_error('email');?></font></div>
                    <div class="span4" style="text-align:right">: Email</div>
                </div>
                <div class="row-form clearfix">
                    <div class="span8"><?php echo form_input($array_website);?>
                        <font color="#FF0000"><?php echo form_error('website');?></font></div>
                    <div class="span4" style="text-align:right">: Website</div>
                </div>
                <?php /*
                  $x1 = explode('°', $x_location);
                  $x2 = explode("'", @$x1[1]);
                  $x3 = explode('"', @$x2[1]);

                  $y1 = explode('°', $y_location);
                  $y2 = explode("'", @$y1[1]);
                  $y3 = explode('"', @$y2[1]);
                 *

                  ?>
                  <div class="row-form clearfix">
                  <div class="span8">
                  <?php echo form_input(array('name' => 'x1', 'value' => @$x1[0], 'style' => 'width:25%')).'° '.form_input(array('name' => 'x2', 'value' => @$x2[0], 'style' => 'width:25%'))."' ".form_input(array('name' => 'x3', 'value' => @$x3[0], 'style' => 'width:25%')).'"';?>
                  <font color="#FF0000"><?php echo form_error('x_location');?></font></div>
                  <div class="span4" style="text-align:right">: N Location</div>
                  </div>
                  <div class="row-form clearfix">
                  <div class="span8"><?php echo form_input(array('name' => 'y1', 'value' => @$y1[0], 'style' => 'width:25%')).'° '.form_input(array('name' => 'y2', 'value' => @$y2[0], 'style' => 'width:25%'))."' ".form_input(array('name' => 'y3', 'value' => @$y3[0], 'style' => 'width:25%')).'"';?>
                  <font color="#FF0000"><?php echo form_error('y_location');?></font></div>
                  <div class="span4" style="text-align:right">: E Location</div>
                  </div>
                 *
                 */?>
                <div class="row-form clearfix">
                    <div class="span8"><?php echo form_input(array('name' => 'x_location', 'value' => @$x_location));?>
                        <font color="#FF0000"><?php echo form_error('x_location');?></font></div>
                    <div class="span4" style="text-align:right !important">: X Decimal</div>
                </div>
                <div class="row-form clearfix">
                    <div class="span8"><?php echo form_input(array('name' => 'y_location', 'value' => @$y_location));?>
                        <font color="#FF0000"><?php echo form_error('y_location');?></font></div>
                    <div class="span4" style="text-align:right !important"> : Y Decimal</div>
                </div>
            </div>

            <div class="head clearfix">
                <div class="isw-documents"></div>
                <h1></h1>
                <h1 style="float:right; margin-right:10px"> ملحق الشركة</h1>
            </div>
            <div class="block-fluid">
                <div class="row-form clearfix">
                    <div class="span8"><?php echo form_input($array_res_person_ar);?>
                        <font color="#FF0000"><?php echo form_error('res_person_ar');?></font></div>
                    <div class="span4" style="text-align:right !important">: مع من تمت المقابلة</div>
                </div>
                <div class="row-form clearfix">
                    <div class="span8"><?php echo form_input($array_res_person_en);?>
                        <font color="#FF0000"><?php echo form_error('res_person_en');?></font></div>
                    <div class="span4" style="text-align:right !important"> : Interviewer</div>
                </div>
                <div class="row-form clearfix">
                    <div class="span8">
                        <?php
                        $positiosn_array = array(0 => 'اختر ');
                        if(count($positions) > 0) {
                            foreach($positions as $position) {

                                $positiosn_array[$position->id] = $position->label_ar.' ( '.$position->label_en.' )';
                            }
                        }
                        echo form_dropdown('position_id', $positiosn_array, @$position_id, 'style="direction:rtl"');
                        ?>
                        <font color="#FF0000"><?php echo form_error('position_id');?></font>
                    </div>
                    <div class="span4" style="text-align:right !important">:صفته في المؤسسة</div>
                </div>
                <div class="row-form clearfix">

                    <div class="span8">
                        <?php
                        $sales_array = array(0 => 'اختر');
                        if(count($sales) > 0) {
                            foreach($sales as $item) {

                                $sales_array[$item->id] = $item->fullname;
                            }
                        }
                        echo form_dropdown('sales_man_id', $sales_array, $sales_man_id, 'style="direction:rtl"');
                        ?>
                        <font color="#FF0000"><?php echo form_error('sales_man_id');?></font></div>
                    <div class="span4" style="text-align:right">: المندوب</div>
                </div>
                <div class="row-form clearfix">
                    <div class="span8"><?php echo form_input($array_app_fill_date);?>yyyy-mm-dd
                        <font color="#FF0000"><?php echo form_error('app_refill_date');?></font></div>
                    <div class="span4" style="text-align:right" >تاريخ ملء الاستمارة</div>
                </div>
                <div class="row-form clearfix">
                    <div class="span5"><?php
                        if($is_adv != 1) {

                            $checkedis_adv = FALSE;
                        }
                        else {
                            $checkedis_adv = TRUE;
                        }
                        echo 'Advertisment&nbsp;'.form_checkbox('is_adv', 1, $checkedis_adv);
                        ?>
                    </div>
                </div>
                <div class="row-form clearfix">

                    <div class="span5" style="text-align:right">
                        <?=form_input($array_adv_pic)?>
                    <!--<input type="file" name="userfile" />-->

                    </div>
                    <div class="span4" style="text-align:right">صورة الاعلان </div>
                </div>
                <div class="row-form clearfix">

                    <div class="span4"><?php
                        if($status == 1) {
                            $checkedonline = TRUE;
                        }
                        else {
                            $checkedonline = FALSE;
                        }
                        echo 'Online&nbsp;'.form_checkbox('status', 1, $checkedonline);
                        ?>
                    </div>

                    <div class="span6"><?php
                        if($copy_res == 1) {
                            $checkedcopy_res = TRUE;
                        }
                        else {
                            $checkedcopy_res = FALSE;
                        }
                        echo 'Copy Reservation&nbsp;'.form_checkbox('copy_res', 1, $checkedcopy_res);
                        ?>
                    </div>
                </div>
            </div>

        </div>
        <?php
        if($nave) {
            echo '<div class="span5">';
        }
        else {
            echo '<div class="span6">';
        }
        ?>
        <div class="head clearfix">
            <div class="isw-documents"></div>
            <h1>General Info

            </h1>
            <h1 style="float:right !important; margin-right:10px;">معلومات عامة</h1>
        </div>
        <div class="block-fluid">
            <div class="row-form clearfix">
                <div class="span8"style="text-align:right !important"><?php echo form_input($array_name_ar);?>
                    <font color="#FF0000"><?php echo form_error('name_ar');?></font></div>
                <div class="span4" style="text-align:right !important">: اسم الشركة </div>
            </div>
            <div class="row-form clearfix">
                <div class="span8"><?php echo form_input($array_name_en);?>
                    <font color="#FF0000"><?php echo form_error('name_en');?></font></div>
                <div class="span4" style="text-align:right !important">: Company Name</div>
            </div>
            <div class="row-form clearfix">

                <div class="span8"><?php echo form_input($array_owner_ar);?>
                    <font color="#FF0000"><?php echo form_error('owner_ar');?></font></div>
                <div class="span4" style="text-align:right">: صاحب / اصحاب الشركة  </div>
            </div>
            <div class="row-form clearfix">
                <div class="span8"><?php echo form_input($array_owner_en);?>
                    <font color="#FF0000"><?php echo form_error('owner_en');?></font></div>
                <div class="span4" style="text-align:right"> : Owner / Owners of the Company</div>
            </div>
            <?php
            $array_license_sources = array();
            if(count($license_sources) > 0) {
                foreach($license_sources as $licence) {
                    $array_license_sources[$licence->id] = $licence->label_ar;
                }
            }
            ?>
            <div class="row-form clearfix">
                <div class="span8">
                    <?php echo form_input(array('id' => 'trade_license', 'name' => 'trade_license', 'value' => @$trade_license));?>
                    <font color="#FF0000"><?php echo form_error('trade_license');?></font></div>
                <div class="span4" style="text-align:right">سجل تجاري </div>

            </div>
            <div class="row-form clearfix">
                <div class="span8">
                    <?php echo form_dropdown('license_source_id', $array_license_sources, @$license_source_id, 'class="search-select"');?>
                    <font color="#FF0000"><?php echo form_error('license_source_id');?></font></div>
                <div class="span4" style="text-align:right">مصدر السجل</div>

            </div>
            <?php /*
              <div class="row-form clearfix">
              <div class="span8"><?php echo form_input($array_cr_ar); ?>
              <font color="#FF0000"><?php echo form_error('cr_ar'); ?></font></div>
              <div class="span4" style="text-align:right"> : رقم الترخيص</div>
              </div>

              <div class="row-form clearfix">
              <div class="span8"><?php echo form_input($array_cr_en); ?>
              <font color="#FF0000"><?php echo form_error('cr_en'); ?></font></div>
              <div class="span4" style="text-align:right"> : C.R</div>
              </div>
             */?>
            <div class="row-form clearfix">
                <div class="span8"><?php echo form_input($array_est_date);?>
                    <font color="#FF0000"><?php echo form_error('est_date');?></font></div>
                <div class="span4" style="text-align:right"> : تاريخ التأسيس</div>
            </div>



        </div>
        <div class="head clearfix">
            <div class="isw-documents"></div>
            <h1>Membership in Organization : </h1>
            <h1  class="h1-ar"> :عضويتها في هيئات </h1>
        </div>
        <div class="block-fluid">

            <div class="row-form clearfix">
                <div class="span12 label-ar">
                    <?php
                    if($maritime == 1) {
                        $s_maritime = TRUE;
                    }
                    else {
                        $s_maritime = FALSE;
                    }
                    if($airline == 1) {
                        $s_airline = TRUE;
                    }
                    else {
                        $s_airline = FALSE;
                    }

                    if($member_local == 1) {
                        $s_local = TRUE;
                    }
                    else {
                        $s_local = FALSE;
                    }
                    if($member_overseas == 1) {
                        $s_overseas = TRUE;
                    }
                    else {
                        $s_overseas = FALSE;
                    }
                    ?>
                    <ul class="label-ar" style="float:right !important; list-style:none !important">
                        <li><?='(Maritime) بحرية  '.form_checkbox(array('name' => 'maritime', 'value' => 1, 'checked' => $s_maritime))?></li>
                        <li><?='(Overseas) في الخارج '.form_checkbox(array('name' => 'member_overseas', 'value' => 1, 'checked' => $s_overseas))?></li>
                        <li><?='(Airline) جوية '.form_checkbox(array('name' => 'airline', 'value' => 1, 'checked' => $s_airline))?></li>
                        <li><?='(Locally) محليا'.form_checkbox(array('name' => 'member_local', 'value' => 1, 'checked' => $s_local))?></li>
                    </ul>
                </div>
            </div>

        </div>
        <div class="head clearfix">
            <div class="isw-documents"></div>
            <h1>Services : </h1>
            <h1 class="h1-ar">:  خدمات النقل</h1>
        </div>
        <div class="block-fluid">
            <div class="row-form clearfix">
                <?php
                if($service_landline == 1) {
                    $s_landline = TRUE;
                }
                else {
                    $s_landline = FALSE;
                }
                if($service_maritime == 1) {
                    $s_maritime = TRUE;
                }
                else {
                    $s_maritime = FALSE;
                }

                if($service_airline == 1) {
                    $s_airline = TRUE;
                }
                else {
                    $s_airline = FALSE;
                }
                ?>
                <!--<div class="span6">
                <div class="span4"><?=form_checkbox(array('name' => 'service_landline', 'checked' => $s_landline, 'readonly' => 'readonly', 'disabled' => 'disabled'))?>Landline</div>
                <div class="span4"><?=form_checkbox(array('name' => 'is_adv', 'checked' => $s_landline, 'readonly' => 'readonly', 'disabled' => 'disabled'))?>(Maritime)</div>
                <div class="span4"><?=form_checkbox(array('name' => 'is_adv', 'checked' => $s_airline, 'readonly' => 'readonly', 'disabled' => 'disabled'))?>(Airline)</div>
            </div>-->
                <div class="span12">
                    <ul class="label-ar" style="float:right !important; list-style:none !important">
                        <li> (Landline) برية   <?=form_checkbox(array('name' => 'service_landline', 'checked' => $s_landline, 'value' => 1))?></li>
                        <li>(Maritime) بحرية <?=form_checkbox(array('name' => 'service_maritime', 'checked' => $s_maritime, 'value' => 1))?></li>
                        <li>(Airline) جوية <?=form_checkbox(array('name' => 'service_airline', 'checked' => $s_airline, 'value' => 1))?></li>
                    </ul>

                </div>
            </div>
        </div>
        <div class="head clearfix">
            <h1>Services : </h1>
            <h1 class="h1-ar"> : الخدمات  </h1>
        </div>
        <div class="block-fluid">

            <div class="row-form clearfix">
                <ul style="list-style:none; float:right; direction:rtl">
                    <?php
                    foreach($activities as $activity) {
                        if(in_array($activity->id, $activities_data)) {
                            $checked = TRUE;
                        }
                        else {
                            $checked = FALSE;
                        }

                        echo '<li style="display:inline-block; width:100%; margin-top:5px">'.form_checkbox('activities[]', $activity->id, $checked, 'style="float:left; margin:5px"');
                        ?><?=$activity->label_ar.' ('.$activity->label_en.')'?></li>
                    <?php }?>
                </ul>

            </div>

        </div>
        <!--                <div class="head clearfix">
                            <h1>Franchises Represented By The Agency : </h1>
                            <h1 class="h1-ar"> : الوكالات الاجنبية التي تمثلها الشركة   </h1>
                        </div>
                        <div class="block-fluid">

                        <div class="row-form clearfix">
                                <ul style="list-style:none; float:right; direction:rtl">
        <?php
        foreach($activities as $activity) {
            if(in_array($activity->id, $activities_data)) {
                $checked = TRUE;
            }
            else {
                $checked = FALSE;
            }

            echo '<li style="display:inline-block; width:100%; margin-top:5px">'.form_checkbox('activities[]', $activity->id, $checked, 'style="float:left; margin:5px"');
            ?><?=$activity->label_ar.' ('.$activity->label_en.')'?></li>
        <?php }?>
                                </ul>

                            </div>

                        </div>-->
        <div class="head clearfix">
            <div class="isw-documents"></div>
            <h1>Note :</h1>
            <h1 style="float:right; margin-right:10px;">ملاحظات شخصية</h1>
        </div>
        <div class="block-fluid">
            <div class="row-form clearfix">
                <div class="span12" ><?php echo form_textarea($array_personal_notes);?></div>
            </div>
            <div class="row-form clearfix">
                <div class="span6 label-ar"><?php
        if(@$display_directory == 1) {
            if(@$directory_interested == 1) {
                $interested1 = TRUE;
                $interested2 = FALSE;
            }
            else {
                $interested1 = FALSE;
                $interested2 = TRUE;
            }
        }
        else {
            $interested1 = FALSE;
            $interested2 = FALSE;
        }
        if(@$display_directory == 1) {
            $checked_display_directory = TRUE;
        }
        else {
            $checked_display_directory = FALSE;
        }
        echo form_checkbox(array('checked' => $checked_display_directory, 'name' => 'display_directory', 'value' => 1)).'&nbsp;<u>تم عرض الدليل&nbsp;</u>';
        ?>
                </div>
                <div class="span3 label-ar"><?php echo form_checkbox(array('checked' => $interested1, 'name' => 'directory_interested', 'value' => 1)).'&nbsp;مهتم';?>
                </div>
                <div class="span3 label-ar"><?php echo form_checkbox(array('checked' => $interested2, 'name' => 'directory_interested', 'value' => 0)).'&nbsp;غير مهتم';?>
                </div>


            </div>
            <div class="row-form clearfix">
                <div class="span6 label-ar"><?php
                    if(@$display_exhibition == 1) {
                        if(@$exhibition_interested == 1) {
                            $exinterested1 = TRUE;
                            $exinterested2 = FALSE;
                        }
                        else {
                            $exinterested1 = FALSE;
                            $exinterested2 = TRUE;
                        }
                    }
                    else {
                        $exinterested1 = FALSE;
                        $exinterested2 = FALSE;
                    }
                    if(@$display_exhibition == 1) {
                        $checked_display_exhibition = TRUE;
                    }
                    else {
                        $checked_display_exhibition = FALSE;
                    }

                    echo form_checkbox(array('checked' => $checked_display_exhibition, 'name' => 'display_exhibition', 'value' => 1)).'&nbsp;<u>تم عرض المعرض</u>';
        ?>
                </div>
                <div class="span3 label-ar"><?php echo form_checkbox(array('checked' => $exinterested1, 'name' => 'exhibition_interested', 'value' => 1)).'&nbsp;مهتم';?>
                </div>
                <div class="span3 label-ar"><?php echo form_checkbox(array('checked' => $exinterested2, 'name' => 'exhibition_interested', 'value' => 0)).'&nbsp;غير مهتم';?>
                </div>

            </div>
        </div>
        <?php $this->load->view('clients',['client_id'=>$c_id,'client_type'=>'transport','status_type'=>'show_items','title'=>'Show Activities']);?>
    </div>
    <?php
    if($nave) {
        echo $this->load->view('transportation/_navigation');
    }
    ?>

</div>
<?=form_close()?>
</div>