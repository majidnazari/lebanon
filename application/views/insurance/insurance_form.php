<?php
/* * ******************General Info********************* */
$array_name_ar = array('id' => 'name_ar', 'name' => 'name_ar', 'value' => $name_ar, 'style' => 'direction:rtl', 'required' => 'required');
$array_name_en = array('id' => 'name_en', 'name' => 'name_en', 'value' => $name_en, 'required' => 'required');

$array_cr_ar = array('id' => 'cr_ar', 'name' => 'cr_ar', 'value' => $cr_ar, 'style' => 'direction:rtl');
$array_cr_en = array('id' => 'cr_en', 'name' => 'cr_en', 'value' => $cr_en);

$array_capital = array('id' => 'capital', 'name' => 'capital', 'value' => $capital);
$array_ins_ecoo_no = array('id' => 'ins_ecoo_no', 'name' => 'ins_ecoo_no', 'value' => $ins_ecoo_no);


$array_chairman_ar = array('id' => 'chairman_ar', 'name' => 'chairman_ar', 'value' => $chairman_ar, 'style' => 'direction:rtl');
$array_chairman_en = array('id' => 'chairman_en', 'name' => 'chairman_en', 'value' => $chairman_en);

$array_manager_ar = array('id' => 'manager_ar', 'name' => 'manager_ar', 'value' => $manager_ar, 'style' => 'direction:rtl');
$array_manager_en = array('id' => 'manager_en', 'name' => 'manager_en', 'value' => $manager_en);

$array_ins_number = array('id' => 'ins_number', 'name' => 'ins_number', 'value' => $ins_number);

$array_activity_ar = array('id' => 'activity_other_ar', 'name' => 'activity_other_ar', 'value' => $activity_other_ar, 'style' => 'direction:rtl');
$array_activity_en = array('id' => 'activity_other_en', 'name' => 'activity_other_en', 'value' => $activity_other_en);
//$array_establish_date=array('id'=>'establish_date','name'=>'establish_date','value'=>$establish_date);

$array_personal_notes = array('id' => 'personal_notes', 'name' => 'personal_notes', 'value' => $personal_notes, 'style' => 'height:250px !important');

/* * *******************Address************************ */
$array_street_ar = array('id' => 'street_ar', 'name' => 'street_ar', 'value' => $street_ar, 'style' => 'direction:rtl');
$array_street_en = array('id' => 'street_en', 'name' => 'street_en', 'value' => $street_en);

$array_bldg_ar = array('id' => 'bldg_ar', 'name' => 'bldg_ar', 'value' => $bldg_ar, 'style' => 'direction:rtl');
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
$array_rep_person_ar = array('id' => 'rep_person_ar', 'name' => 'rep_person_ar', 'value' => $rep_person_ar, 'style' => 'direction:rtl');
$array_rep_person_en = array('id' => 'rep_person_en', 'name' => 'rep_person_en', 'value' => $rep_person_en);

$array_entry_date = array('id' => 'entry_date', 'name' => 'entry_date', 'value' => @$entry_date);
$array_adv_pic = array('id' => 'adv_pic', 'name' => 'adv_pic', 'value' => $adv_pic);
?>

<script language="javascript">
    $(function () {
        $("#entry_date").datepicker({
            dateFormat: "yy-mm-dd"
        });
        $("#end_date").datepicker({
            dateFormat: "yy-mm-dd"
        });
        //$( "#app_fill_date" ).datepicker();
        $('#selecctall').on('click', function () {

            if($(this).is(':checked')) {
                //alert('test');
                $('.chkbox').each(function () {
                    this.checked = true;
                });
            } else {
                $('.chkbox').each(function () {
                    this.checked = false;
                });
            }
        })
        /*
         $('#selecctall').on('click',function(){
         alert('1');
         if(this.checked){
         alert('12');
         $('.checkbox_1').each(function(){
         this.prop('checked',true);

         //alert(this.val());
         //this.checked = true;
         });
         }else{
         $('.checkbox_1').each(function(){
         this.checked = false;
         });
         }
         });

         $('.checkbox_1').on('click',function(){
         if($('.checkbox_1:checked').length == $('.checkbox_1').length){
         $('#selecctall').prop('checked',true);
         }else{
         $('#selecctall').prop('checked',false);
         }
         });*/
    });
    $(document).ready(function () {
        $("#other-area").hide();
		<?php if($activity_other_ar!='' or $activity_other_en!=''){ ?>
						 $("#other-area").show();		
						<?php		} ?>
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
// echo form_hidden('adv_pic',$adv_pic);
    ?>
    <div class="workplace">

        <div class="page-header">
            <h1><?=$subtitle?>
                <input type="submit" name="save" value="Save" class="btn btn-large" style="float:right !important">
                &nbsp;
                <?php
                if($nave) {
                    echo anchor('insurances/details/'.$id, 'Cancel', array('class' => 'btn btn-large', 'style' => 'float:right !important; margin-right:10px'));
                }
                else {
                    echo anchor('insurances', 'Cancel', array('class' => 'btn btn-large', 'style' => 'float:right !important; margin-right:10px'));
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
                    <div class="span4" style="text-align:right">: WhatsApp</div>
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
                <?php
                /*
                  $x1=explode('°',$x_location);
                  $x2=explode("'",@$x1[1]);
                  $x3=explode('"',@$x2[1]);

                  $y1=explode('°',$y_location);
                  $y2=explode("'",@$y1[1]);
                  $y3=explode('"',@$y2[1]);

                 */
                ?>
                <div class="row-form clearfix">
                    <div class="span8"><?php echo form_input($array_x_location);?>
                        <font color="#FF0000"><?php echo form_error('x_location');?></font></div>
                    <div class="span4" style="text-align:right">: X Location (Decimal)</div>
                </div>
                <div class="row-form clearfix">
                    <div class="span8"><?php echo form_input($array_y_location);?>
                        <font color="#FF0000"><?php echo form_error('y_location');?></font></div>
                    <div class="span4" style="text-align:right">: Y Location (Decimal)</div>
                </div>



            </div>
            <div class="head clearfix">
                <div class="isw-documents"></div>
                <h1></h1>
                <h1 style="float:right; margin-right:10px"> ملحق الشركة</h1>
            </div>
            <div class="block-fluid">

                <div class="row-form clearfix">
                    <div class="span8"><?php echo form_input($array_rep_person_ar);?>
                        <font color="#FF0000"><?php echo form_error('rep_person_ar');?></font></div>
                    <div class="span4" style="text-align:right !important">: مع من تمت المقابلة</div>
                </div>
                <div class="row-form clearfix">
                    <div class="span8"><?php echo form_input($array_rep_person_en);?>
                        <font color="#FF0000"><?php echo form_error('rep_person_en');?></font></div>
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
                        echo form_dropdown('position_id', $positiosn_array, $position_id, 'style="direction:rtl"');
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
                    <div class="span8"><?php echo form_input($array_entry_date);?>yyyy-mm-dd
                        <font color="#FF0000"><?php echo form_error('entry_date');?></font></div>
                    <div class="span4" style="text-align:right" >تاريخ ملء الاستمارة</div>
                </div>
                <div class="row-form clearfix">
                    <div class="span3"><?php
                        if($is_adv != 1) {

                            $checkedis_adv = FALSE;
                        }
                        else {
                            $checkedis_adv = TRUE;
                        }
                        echo 'Advertisment&nbsp;'.form_checkbox('is_adv', 1, $checkedis_adv);
                        ?>
                    </div>
                    <div class="span5" style="text-align:right">
                    <!--<input type="file" name="userfile" />-->
                        <?=form_input($array_adv_pic)?>
                        <br />
                    </div>
                    <div class="span4" style="text-align:right">صورة الاعلان </div>
                </div>
                <div class="row-form clearfix">
                    <!--<div class="span3"><?php
                    if($is_exporter == 1) {
                        $checkedis_exporter = TRUE;
                    }
                    else {
                        $checkedis_exporter = FALSE;
                    }
                    echo 'Is Exporter&nbsp;'.form_checkbox('is_exporter', 1, $checkedis_exporter);
                    ?>
                    </div> -->
                    <div class="span2"><?php
                        if($online == 1) {
                            $checkedonline = TRUE;
                        }
                        else {
                            $checkedonline = FALSE;
                        }
                        echo 'Online&nbsp;'.form_checkbox('online', 1, $checkedonline);
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
                <div class="row-form clearfix">
                    <div class="span3 label-ar"><?php
                        if($display_directory == 1) {
                            if($directory_interested == 1) {
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
                        echo form_checkbox('directory_interested', 0, $interested2).'&nbsp;غير مهتم';
                        ?>
                    </div>
                    <div class="span3 label-ar"><?php echo form_checkbox('directory_interested', 1, $interested1).'&nbsp;مهتم';?>
                    </div>
                    <div class="span6 label-ar"><?php
                        if($display_directory == 1) {
                            $checked_display_directory = TRUE;
                        }
                        else {
                            $checked_display_directory = FALSE;
                        }
                        echo form_checkbox('display_directory', 1, $checked_display_directory).'&nbsp;<u>تم عرض الدليل&nbsp;</u>';
                        ?>
                    </div>

                </div>
                <div class="row-form clearfix">
                    <div class="span3 label-ar"><?php
                        if($display_exhibition == 1) {
                            if($exhibition_interested == 1) {
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
                        echo form_checkbox('exhibition_interested', 0, $exinterested2).'&nbsp;غير مهتم';
                        ?>
                    </div>
                    <div class="span3 label-ar"><?php echo form_checkbox('exhibition_interested', 1, $exinterested1).'&nbsp;مهتم';?>
                    </div>
                    <div class="span6 label-ar"><?php
                        if($display_exhibition == 1) {
                            $checked_display_exhibition = TRUE;
                        }
                        else {
                            $checked_display_exhibition = FALSE;
                        }
                        echo form_checkbox('display_exhibition', 1, $checked_display_directory).'&nbsp;<u>تم عرض المعرض</u>';
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
            <div class="row-form clearfix">
                <div class="span8"><?php echo form_input($array_capital);?>
                    <font color="#FF0000"><?php echo form_error('capital');?></font></div>
                <div class="span4" style="text-align:right"> :  رأس المال </div>
            </div>
            <div class="row-form clearfix">
                <div class="span8"><?php echo form_input($array_ins_number);?>
                    <font color="#FF0000"><?php echo form_error('ins_number');?></font></div>
                <div class="span4" style="text-align:right"> : رقم التسجيل في وزارة الاقتصاد والتجارة </div>
            </div>

            <div class="row-form clearfix">
                <div class="span8" style="text-align:right !important"><?php echo form_input($array_ins_ecoo_no);?>
                    <font color="#FF0000"><?php echo form_error('ins_ecoo_no');?></font></div>
                <div class="span4" style="text-align:right !important"> : رقم الانتساب لجمعية شركات الضمان في لبنان </div>
            </div>
            <div class="row-form clearfix">
                <div class="span8"><?php echo form_input($array_manager_ar);?>
                    <font color="#FF0000"><?php echo form_error('manager_ar');?></font></div>
                <div class="span4" style="text-align:right !important">: مجلس الادارة </div>
            </div>
            <div class="row-form clearfix">
                <div class="span8"><?php echo form_input($array_manager_en);?>
                    <font color="#FF0000"><?php echo form_error('manager_en');?></font></div>
                <div class="span4" style="text-align:right">: Board of Directors</div>

            </div>

            <div class="row-form clearfix">

                <div class="span8"><?php echo form_input($array_chairman_ar);?>
                    <font color="#FF0000"><?php echo form_error('chairman_ar');?></font></div>
                <div class="span4" style="text-align:right"> : الادارة التنفيذية</div>
            </div>
            <div class="row-form clearfix">
                <div class="span8"><?php echo form_input($array_chairman_en);?>
                    <font color="#FF0000"><?php echo form_error('chairman_en');?></font></div>
                <div class="span4" style="text-align:right"> : Executives Managing </div>
            </div>


        </div>
        <div class="head clearfix">
            <div class="isw-documents"></div>
            <h1>Classes of Business Transacted : </h1>
            <h1 style="float:right; margin-right:10px;">: أوجه النشاط التي تمارسها الشركة</h1>
        </div>
        <div class="block-fluid">

            <div class="row-form clearfix">
                <table cellpadding="0" cellspacing="0" width="100%" class="table" id="tSortable_2">
                    <thead>
                        <tr>
                            <th width="80%" style="text-align:right !important">النشاط</th>
                            <th><input type="checkbox" name="checkall"/></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($activities as $activity) {
                            if(in_array($activity->id, $activities_data)) {
                                $checked = TRUE;
                            }
                            else {
                                $checked = FALSE;
                            }
                            if($activity->id == 15) {
                                $act_js = 'id="other"';
								if($activity_other_ar!='' or $activity_other_en!=''){
								$checked = TRUE;
								}
                            }
                            else {
                                $act_js = '';
                            }
							
                            ?>
                            <tr style="margin:0px !important; padding:0px !important">
                                <td style="text-align:right !important; direction:rtl !important;margin:0px !important; padding:0px 5px !important"><?=$activity->label_ar?></td>
                                <td style="margin:0px !important; padding:0px 5px !important"><?=form_checkbox('activities[]', $activity->id, $checked, $act_js);?></td>
                            </tr>
                        <?php }?>
                    </tbody>
                </table>
                <?php /*
                  <ul style="list-style:none; float:right; direction:rtl">
                  <li><?=form_checkbox('all[]', 0, FALSE,' id="selecctall" style="float:left; margin:5px"');?>اختيار الكل</li>
                  <?php foreach($activities as $activity){
                  if(in_array($activity->id,$activities_data)){
                  $checked=TRUE;
                  }
                  else{
                  $checked=FALSE;
                  }
                  if($activity->id==15){
                  $act_js='id="other"';
                  }
                  else{
                  $act_js='';
                  }
                  echo '<li style="display:inline-block; width:30%; margin-top:5px">'.form_checkbox('activities[]', $activity->id, $checked,'class="chkbox" style="float:left; margin:5px"'.$act_js);?><?=$activity->label_ar?></li>
                  <?php } ?>
                  </ul>
                 */?>
            </div>
            <div id="other-area">
                <div class="row-form clearfix">
                    <div class="span8"><?php echo form_input($array_activity_ar);?>
                        <font color="#FF0000"><?php echo form_error('activity_other_ar');?></font></div>
                    <div class="span4" style="text-align:right">: نشاطات أخرى - حدد </div>

                </div>
                <div class="row-form clearfix">
                    <div class="span8"><?php echo form_input($array_activity_en);?>
                        <font color="#FF0000"><?php echo form_error('activity_other_en');?></font></div>
                    <div class="span4" style="text-align:right"> : Other - Specify </div>
                </div>
            </div>
        </div>
        <div class="head clearfix">
            <div class="isw-documents"></div>
            <h1>Note :</h1>
            <h1 style="float:right; margin-right:10px;">ملاحظات شخصية</h1>
        </div>
        <div class="block-fluid">
            <div class="row-form clearfix">
                <div class="span12" ><?php echo form_textarea($array_personal_notes);?></div>
            </div>
        </div>
        <?php $this->load->view('clients',['client_id'=>$c_id,'client_type'=>'insurance','status_type'=>'show_items','title'=>'Show Activities']);?>
    </div>
    
    <?php
    if($nave) {
        echo $this->load->view('insurance/_navigation');
    }
    ?>

</div>
<?=form_close()?>
</div>