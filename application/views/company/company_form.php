<script type='text/javascript' src='<?=base_url()?>js/plugins/tagsinput/jquery.tagsinput.min.js'></script>
<?php
/********************General Info**********************/
$array_ref = array('id' => 'ref', 'name' => 'ref', 'value' => @$ref);
$array_name_ar = array('id' => 'name_ar', 'name' => 'name_ar', 'value' => $name_ar, 'required' => 'required');
$array_name_en = array('id' => 'name_en', 'name' => 'name_en', 'value' => $name_en, 'required' => 'required');

$array_owner_name = array('id' => 'owner_name', 'name' => 'owner_name', 'value' => $owner_name);
$array_owner_name_en = array('id' => 'owner_name_en', 'name' => 'owner_name_en', 'value' => $owner_name_en);

$array_auth_person_ar = array('id' => 'auth_person_ar', 'name' => 'auth_person_ar', 'value' => $auth_person_ar);
$array_auth_person_en = array('id' => 'auth_person_en', 'name' => 'auth_person_en', 'value' => $auth_person_en);

$array_auth_no = array('id' => 'auth_no', 'name' => 'auth_no', 'value' => $auth_no);

$array_activity_ar = array('id' => 'activity_ar', 'name' => 'activity_ar', 'value' => $activity_ar);
$array_activity_en = array('id' => 'activity_en', 'name' => 'activity_en', 'value' => $activity_en);
$array_establish_date = array('id' => 'establish_date', 'name' => 'establish_date', 'value' => $establish_date);

$array_personal_notes = array('id' => 'personal_notes', 'name' => 'personal_notes', 'value' => str_replace('<br>','\n',$personal_notes), 'style' => 'height:250px !important');

/*********************Address*************************/
$array_street_ar = array('id' => 'street_ar', 'name' => 'street_ar', 'value' => $street_ar);
$array_street_en = array('id' => 'street_en', 'name' => 'street_en', 'value' => $street_en);

$array_bldg_ar = array('id' => 'bldg_ar', 'name' => 'bldg_ar', 'value' => $bldg_ar);
$array_bldg_en = array('id' => 'bldg_en', 'name' => 'bldg_en', 'value' => $bldg_en);

$array_fax = array('id' => 'fax', 'name' => 'fax', 'value' => $fax);
$array_phone = array('id' => 'phone', 'name' => 'phone', 'value' => $phone);
$array_whatsapp =array('id' => 'whatsapp', 'name' => 'whatsapp', 'value' => $whatsapp);

$array_pobox_ar = array('id' => 'pobox_ar', 'name' => 'pobox_ar', 'value' => $pobox_ar, 'style' => 'direction:rtl !important');
$array_pobox_en = array('id' => 'pobox_en', 'name' => 'pobox_en', 'value' => $pobox_en);

$array_email = array('id' => 'email', 'name' => 'email', 'value' => $email);
$array_website = array('id' => 'website', 'name' => 'website', 'value' => $website);
$array_x_location = array('id' => 'x_decimal', 'name' => 'x_decimal', 'value' => @$x_decimal);
$array_y_location = array('id' => 'y_decimal', 'name' => 'y_decimal', 'value' => @$y_decimal);

/*********************Molhak*************************/
$array_rep_person_ar = array('id' => 'rep_person_ar', 'name' => 'rep_person_ar', 'value' => $rep_person_ar);
$array_rep_person_en = array('id' => 'rep_person_en', 'name' => 'rep_person_en', 'value' => $rep_person_en);

$array_app_fill_date = array('id' => 'app_fill_date', 'name' => 'app_fill_date', 'value' => $app_fill_date);
$start_date_adv = array('id' => 'start_date_adv', 'name' => 'start_date_adv', 'value' => $start_date_adv);
$end_date_adv = array('id' => 'end_date_adv', 'name' => 'end_date_adv', 'value' => $end_date_adv);
$array_adv_pic = array('id' => 'adv_pic', 'name' => 'adv_pic', 'value' => $adv_pic);

?>
<style type="text/css">
    .select2 {
        width: 100% !important;
    }
</style>
<link href="<?= base_url() ?>css/select22.css" rel="stylesheet"/>
<script src="<?= base_url() ?>js/select2.js"></script>

<script language="javascript">

    $(function () {
        $(".select2").select2();

        $("#app_fill_date").datepicker({
            dateFormat: "yy-mm-dd"
        });
        $("#end_date").datepicker({
            dateFormat: "yy-mm-dd"
        });
        $("#end_date_adv").datepicker({
            dateFormat: "yy-mm-dd"
        });
        $("#start_date_adv").datepicker({
            dateFormat: "yy-mm-dd"
        });
        $("#closed_date").datepicker({
            dateFormat: "yy-mm-dd"
        });
         $("#delivery_date").datepicker({
            dateFormat: "yy-mm-dd"
        });
    })
    function getdistricts(gov_id) {
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
    function getarea(district_id) {
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
    select {
        direction: rtl !important;
        font-size: 14px !important;
    }

    input {
        font-size: 14px !important;

    }

    textarea {
        font-size: 14px !important;

    }

    .label-ar {
        float: right !important;
        margin-left: 5px !important;
        text-align: right !important;
    }
</style>

<script language="javascript">
    jQuery(function ($) {
        // $("#app_fill_date").mask("9999-99-99");
        //$("#end_date").mask("9999-99-99");
        $("#x_location").mask("99°99'99.99\"");
        $("#y_location").mask("99°99'99.99\"");
    });
</script>

<?php
$jsgov = 'id="gov_id" onchange="getdistricts(this.value)" class="select2" required="required"';
$jsdis = 'id="district_id" onchange="getarea(this.value)" class="select2" required="required"';
?>
<div class="content">
    <?= $this->load->view("includes/_bread") ?>
    <?php 
     //var_dump($this->uri->uri_string()); 
    // var_dump("<br>");
  
    // var_dump(array('id' => 'validation'));

    // var_dump("<br>");

    // var_dump('c_id', $c_id); 
    // die();
    echo form_open_multipart($this->uri->uri_string(), array('id' => 'validation'));
    echo form_hidden('c_id', $c_id);
    // echo form_hidden('adv_pic',$adv_pic);
    ?>
    <div class="workplace">

        <div class="page-header">
            <h1><?= $subtitle ?>
                <input type="submit" name="save" value="Save" class="btn btn-large" style="float:right !important">
                &nbsp;
                <?php
                if ($nave) {                   
                    echo anchor('companies/details/' . $id, 'Cancel', array('class' => 'btn btn-large', 'style' => 'float:right !important; margin-right:10px'));
                } else {
                    echo anchor('companies', 'Cancel', array('class' => 'btn btn-large', 'style' => 'float:right !important; margin-right:10px'));

                } ?>
            </h1>
        </div>

        <div class="row-fluid">
            <?php if ($nave) {
                $span = 'span9';
            } else {
                $span = 'span12';
            } ?>
            <div class="<?= $span ?>">
           
                <div class="span6">
                    <div class="head clearfix">
                        <div class="isw-documents"></div>
                        <h1>Address</h1>
                        <h1 style="float:right; margin-right:10px"> عنوان المؤسسة</h1>
                    </div>
                    <div class="block-fluid">
                        <?php
                        $task=array();
                        if(@$query['id']!=''){
                            $task=$this->Task->GetTaskByCompanyId($query['id']);
                        }
                        ?>
                        <?php if(count($task)>0){ ?>
                            <div class="row-form clearfix">
                                <div class="span8"><?=$task['sales_man_ar'].' - '.$task['list_id']?></div>
                                <div class="span4" style="text-align:right !important">  مسح 2017</div>
                            </div>
                        <?php } ?>
                        <div class="row-form clearfix">
                            <div class="span8"><?php echo form_input(array('name' => 'ref', 'value' => @$ref)); ?>
                                <font color="#FF0000"><?php echo form_error('ref'); ?></font></div>
                            <div class="span4" style="text-align:right !important"> : المرجع</div>
                        </div>

                        <div class="row-form clearfix">

                            <?php
                            $gover = array('' => 'اختر المحافظة');
                            foreach ($governorates as $governorate) {

                                $gover[$governorate->id] = $governorate->label_ar . ' ( ' . $governorate->label_en . ' )';
                            }
                            ?>
                            <div class="span8"><?php echo form_dropdown('governorate_id', $gover, $governorate_id, $jsgov); ?>
                                <font color="#FF0000"><?php echo form_error('governorate_id'); ?></font></div>
                            <div class="span4" style="text-align:right !important"><font color="#FF0000">*</font>:
                                المحافظة
                            </div>
                        </div>
                        <div class="row-form clearfix">

                            <div class="span8">
                                <div id="district">
                                    <?php
                                    $district_array = array('' => 'اختر القضاء');
                                    if (count($districts) > 0) {
                                        foreach ($districts as $district) {

                                            $district_array[$district->id] = $district->label_ar . ' ( ' . $district->label_en . ' )';
                                        }
                                    }
                                    echo form_dropdown('district_id', $district_array, $district_id, $jsdis); ?>
                                    <font color="#FF0000"><?php echo form_error('district_id'); ?></font></div>
                            </div>
                            <div class="span4" style="text-align:right !important"><font color="#FF0000">*</font>:
                                القضاء
                            </div>
                        </div>
                        <div class="row-form clearfix">

                            <div class="span8">
                                <div id="area">
                                    <?php
                                    $area_array = array('' => 'اختر البلدة');
                                    if (count($areas) > 0) {
                                        foreach ($areas as $area) {

                                            $area_array[$area->id] = $area->label_ar . ' ( ' . $area->label_en . ' )';
                                        }
                                    }
                                    echo form_dropdown('area_id', $area_array, $area_id, ' class="select2"  required="required"'); ?>
                                    <font color="#FF0000"><?php echo form_error('district_id'); ?></font></div>
                            </div>
                            <div class="span4" style="text-align:right"><font color="#FF0000">*</font>: البلدة</div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span8" style="text-align:right"><?php echo form_input($array_street_ar); ?>
                                <font color="#FF0000"><?php echo form_error('street_ar'); ?></font></div>
                            <div class="span4" style="text-align:right"> : شارع</div>
                        </div>
                        <div class="row-form clearfix">

                            <div class="span8"><?php echo form_input($array_street_en); ?>
                                <font color="#FF0000"><?php echo form_error('street_en'); ?></font></div>
                            <div class="span4" style="text-align:right"> : Street</div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span8" style="text-align:right"><?php echo form_input($array_bldg_ar); ?>
                                <font color="#FF0000"><?php echo form_error('bldg_ar'); ?></font></div>
                            <div class="span4" style="text-align:right"> : بناية</div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span8"><?php echo form_input($array_bldg_en); ?>
                                <font color="#FF0000"><?php echo form_error('bldg_en'); ?></font></div>
                            <div class="span4" style="text-align:right">: Building</div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span8"><?php echo form_input($array_phone); ?>
                                <font color="#FF0000"><?php echo form_error('phone'); ?></font></div>
                            <div class="span4" style="text-align:right">: هاتف</div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span8"><?php echo form_input($array_whatsapp); ?>
                                <font color="#FF0000"><?php echo form_error('whatsapp'); ?></font></div>
                            <div class="span4" style="text-align:right">: WhatsApp</div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span8"><?php echo form_input($array_fax); ?>
                                <font color="#FF0000"><?php echo form_error('fax'); ?></font></div>
                            <div class="span4" style="text-align:right">: فاكس</div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span8"
                                 style="text-align:right !important"><?php echo form_input($array_pobox_ar); ?>
                                <font color="#FF0000"><?php echo form_error('pobox_ar'); ?></font></div>
                            <div class="span4" style="text-align:right"> : صندوق بريد</div>
                        </div>
                        <div class="row-form clearfix">

                            <div class="span8"><?php echo form_input($array_pobox_en); ?>
                                <font color="#FF0000"><?php echo form_error('pobox_en'); ?></font></div>
                            <div class="span4" style="text-align:right">: P.O. Box</div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span8" style="text-align:right !important">
                                <?php echo form_input(array('name' => 'address2_ar', 'value' => @$address2_ar)); ?>
                                <font color="#FF0000"><?php echo form_error('address2_ar'); ?></font></div>
                            <div class="span4" style="text-align:right"> : العنوان ٢</div>
                        </div>
                        <div class="row-form clearfix">

                            <div class="span8"><?php echo form_input(array('name' => 'address2_en', 'value' => @$address2_en)); ?>
                                <font color="#FF0000"><?php echo form_error('address2_en'); ?></font></div>
                            <div class="span4" style="text-align:right">: Address 2</div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span8"><?php echo form_input($array_email); ?>
                                <font color="#FF0000"><?php echo form_error('email'); ?></font></div>
                            <div class="span4" style="text-align:right">: Email</div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span8"><?php echo form_input($array_website); ?>
                                <font color="#FF0000"><?php echo form_error('website'); ?></font></div>
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
                            <div class="span8">
                                <?php echo form_input($array_x_location); ?>
                                <font color="#FF0000"><?php echo form_error('x_decimal'); ?></font></div>
                            <div class="span4" style="text-align:right">: N Location Decimal</div>
                        </div>

                        <div class="row-form clearfix">
                            <div class="span8"><?php echo form_input($array_y_location); ?>
                                <font color="#FF0000"><?php echo form_error('y_decimal'); ?></font></div>
                            <div class="span4" style="text-align:right">: E Location Decimal</div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span8"><?php echo form_input(array('id' => 'facebook', 'name' => 'facebook', 'value' => @$query['facebook'])); ?>
                                <font color="#FF0000"><?php echo form_error('facebook'); ?></font></div>
                            <div class="span4" style="text-align:right">: FaceBook</div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span8"><?php echo form_input(array('id' => 'instagram', 'name' => 'instagram', 'value' => @$query['instagram'])); ?>
                                <font color="#FF0000"><?php echo form_error('instagram'); ?></font></div>
                            <div class="span4" style="text-align:right">: Instagram</div>
                        </div>
                       <!-- 
                           <div class="row-form clearfix">
                                <div class="span8"><?php echo form_input(array('id' => 'twitter', 'name' => 'twitter', 'value' => @$query['twitter'])); ?>
                                    <font color="#FF0000"><?php echo form_error('twitter'); ?></font></div>
                                <div class="span4" style="text-align:right">: Twitter</div>
                            </div>
                        -->
                        <?php /*
					 <div class="row-form clearfix">
                        <div class="span8">
						<?php echo form_input(array('name'=>'x1','value'=>@$x1[0],'style'=>'width:25%')).'° '.form_input(array('name'=>'x2','value'=>@$x2[0],'style'=>'width:25%'))."' ".form_input(array('name'=>'x3','value'=>@$x3[0],'style'=>'width:25%')).'"'; ?>
                        <font color="#FF0000"><?php echo form_error('x_location'); ?></font></div>
                        <div class="span4" style="text-align:right">: N Location</div>
                    </div>

 					<div class="row-form clearfix">
                        <div class="span8"><?php echo form_input(array('name'=>'y1','value'=>@$y1[0],'style'=>'width:25%')).'° '.form_input(array('name'=>'y2','value'=>@$y2[0],'style'=>'width:25%'))."' ".form_input(array('name'=>'y3','value'=>@$y3[0],'style'=>'width:25%')).'"'; ?>
                        <font color="#FF0000"><?php echo form_error('y_location'); ?></font></div>
                        <div class="span4" style="text-align:right">: E Location</div>
                    </div>
					*/ ?>
                    </div>
                    <div class="head clearfix">
                        <div class="isw-documents"></div>
                        <h1></h1>
                        <h1 style="float:right; margin-right:10px"> ملحق الشركة</h1>
                    </div>
                    <div class="block-fluid">

                        <div class="row-form clearfix">
                            <div class="span8"><?php echo form_input($array_rep_person_ar); ?>
                                <font color="#FF0000"><?php echo form_error('rep_person_ar'); ?></font></div>
                            <div class="span4" style="text-align:right !important">: مع من تمت المقابلة</div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span8"><?php echo form_input($array_rep_person_en); ?>
                                <font color="#FF0000"><?php echo form_error('rep_person_en'); ?></font></div>
                            <div class="span4" style="text-align:right !important"> : Interviewer</div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span8">
                                <?php
                                $positiosn_array = array(0 => 'اختر ');
                                if (count($positions) > 0) {
                                    foreach ($positions as $position) {

                                        $positiosn_array[$position->id] = $position->label_ar . ' ( ' . $position->label_en . ' )';
                                    }
                                }
                                echo form_dropdown('position_id', $positiosn_array, $position_id, 'style="direction:rtl"'); ?>
                                <font color="#FF0000"><?php echo form_error('position_id'); ?></font>
                            </div>
                            <div class="span4" style="text-align:right !important">:صفته في المؤسسة</div>
                        </div>
                        <div class="row-form clearfix">

                            <div class="span8">
                                <?php
                                $sales_array = array(0 => 'اختر');
                                if (count($sales) > 0) {
                                    foreach ($sales as $item) {

                                        $sales_array[$item->id] = $item->fullname;
                                    }
                                }
                                echo form_dropdown('sales_man_ids', $sales_array, $sales_man_ids, 'style="direction:rtl"'); ?>                              
                                <font color="#FF0000"><?php echo form_error('sales_man_ids'); ?></font>
                            </div>
                            <div class="span4" style="text-align:right">: المندوب</div>
                        </div>
                        <?php /*
                    <div class="row-form clearfix">
                        <div class="span8" style="text-align:right"><?php echo form_input($street_factory_ar); ?>
                        <font color="#FF0000"><?php echo form_error('street_factory_ar'); ?></font></div>
                        <div class="span4" style="text-align:right"> تاريخ تعديل الاستمارة</div>
                    </div>
					*/ ?>
                        <div class="row-form clearfix">
                            <div class="span8"><?php echo form_input($array_app_fill_date); ?>yyyy-mm-dd
                                <font color="#FF0000"><?php echo form_error('app_fill_date'); ?></font></div>
                            <div class="span4" style="text-align:right">تاريخ ملء الاستمارة</div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span3"><?php
                                if ($is_adv != 1) {

                                    $checkedis_adv = FALSE;


                                } else {
                                    $checkedis_adv = TRUE;
                                }
                                //echo 'Advertisment<br>' . form_checkbox('is_adv', 1, $checkedis_adv); ?>
                            </div>
                            <div class="span4" style="text-align:right">صورة الاعلان</br>
                                <?= form_input($array_adv_pic) ?>
                                <!--<input type="file" name="userfile" />-->
                            </div>
                            
                            <div class="span5" style="text-align:right">مندوب الإعلان 
                                <?php
                                $sales_array = array(0 => 'اختر');
                                if (count($sales) > 0) {
                                    foreach ($sales as $item) {

                                        $sales_array[$item->id] = $item->fullname;
                                    }
                                }
                                echo '<br>'.form_dropdown('adv_salesman_id', $sales_array, @$query['adv_salesman_id'], 'style="direction:rtl"'); ?>
                                

                            </div>
                           
                            <div class="span7" style="text-align:right">
                                Start Date </br>                           
                                    <?php echo form_input($start_date_adv); ?>
                                        <font color="#FF0000"><?php echo form_error('start_date_adv'); ?></font>
                                End Date </br>
                                    <?php echo form_input($end_date_adv); // echo form_input(['name'=>'end_date_adv','class'=>'datep','id'=>'endDateAdv','value'=>@$row_s->end_date_adv]);
                                     ?>
                                        <font color="#FF0000"><?php echo form_error('end_date_adv'); ?></font>
                                
                                Status </br> 
                                            <?php  $array_status=array('1'=>'Active','0'=>'Inactive');
                                            echo form_dropdown('status_adv',$array_status,@$status_adv,' id="status_adv"');
                                            ?>                                        
                            </div>   
                           
                        </div>                        
                        <div class="row-form clearfix">
                            <div class="span3"><?php
                                if ($copy_res == 1) {
                                    $checkedcopy_res = TRUE;
                                } else {
                                    $checkedcopy_res = FALSE;
                                }
                                echo 'Copy Res.<br>' . form_checkbox('copy_res', 1, $checkedcopy_res); ?>
                            </div>
                            <div class="span3"><?php
                                if (@$query['copy_res_bold'] == 1) {
                                    $checkedcopy_res_bold = TRUE;
                                } else {
                                    $checkedcopy_res_bold = FALSE;
                                }
                                echo 'Copy Res. Bold<br>' . form_checkbox('copy_res_bold', 1, $checkedcopy_res_bold); ?>
                            </div>
                            <div class="span6" style="text-align:right"> مندوب حجز النسخة 
                                <?php
                                $sales_array = array(0 => 'اختر');
                                if (count($sales) > 0) {
                                    foreach ($sales as $item) {

                                        $sales_array[$item->id] = $item->fullname;
                                    }
                                }
                                echo '<br>'.form_dropdown('copy_res_salesman_id', $sales_array, @$query['copy_res_salesman_id'], 'style="direction:rtl"'); ?>
                                

                        </div>
                        </div>
                        <div class="row-form clearfix">
                            <!--<div class="span3"><?php
                            if ($is_exporter == 1) {
                                $checkedis_exporter = TRUE;
                            } else {
                                $checkedis_exporter = FALSE;
                            }
                            echo 'Is Exporter&nbsp;' . form_checkbox('is_exporter', 1, $checkedis_exporter); ?>
                        </div> -->
                            <div class="span2"><?php
                                if ($show_online == 1) {
                                    $checkedonline = TRUE;
                                } else {
                                    $checkedonline = FALSE;
                                }
                                echo 'Online&nbsp;' . form_checkbox('show_online', 1, $checkedonline); ?>
                            </div>

                            <div class="span4">
                            </div>
                            <?php
                            $delivery=(@$query['update_info']==1) ? true : false;
                            $acc=(@$query['acc']=='yes') ? true : false;
                            // $task=array();
                            // if(@$query['id']!=''){
                            //    $task=$this->Task->GetTaskByCompanyId(@$query['id']);
                            // }

                            /*
                            <div class="span3"><?php

                                echo 'المسح &nbsp;' .data('Y').'&nbsp;' .form_checkbox('scanning', 1,@$scanning); ?>
                            </div>
 */?>
                            <?php

                            if(count($task)>0){
                                if($p_update_info){
                                    ?>
                                    <div class="span6"><?php
                                        // echo 'تم التسليم '.'&nbsp;';
                                        echo ' Update Info &nbsp;' .date('Y').'&nbsp;'.form_checkbox('task_status', 1, @$delivery); ?>
                                    </div>
                                <?php }
                                if($p_acc){ ?>
                                    <div class="span6"><?php
                                        // echo 'تم التسليم '.'&nbsp;';
                                        echo ' ACC. Done &nbsp;' .date('Y').'&nbsp;'.form_checkbox('acc', 'yes', @$acc); ?>
                                    </div>
                                <?php }
                            }
                            else{
                                
                            if(isset($query) and is_array($query) and count(@$query)>0){
                                echo '<font color="red">No Task<br>'.anchor('tasks/create','Add Task',array('target'=>'_blank')).'</font>';
                            }
                            else{
                            ?>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span4"><?php
                                echo ' Task add directly &nbsp;'.form_checkbox('add_task', '1'); ?>
                            </div>
                            <?php
                            echo '<div class="span3">Task Status </div><div class="span5">'.form_dropdown('task_status', array('done'=>'Done','pending'=>'Pending'),'','style="direction:ltr !important"'); ?>
                        </div>
                    <?php
                    }


                    }
                    ?>
                    </div>
                    <div class="row-form clearfix">
                         <div class="span4">Delivery Date<br>
                                 <?= form_input(array('name'=>'delivery_date', 'id' => 'delivery_date', 'value' => @$query['delivery_date'], 'style' => 'direction:rtl')); ?>
                            </div>
                            <?php
                            echo '<div class="span4">Delivery By<br>'.form_dropdown('delivery_by', $sales_array, @$query['delivery_by'], 'style="direction:rtl"'); ?>
                        </div>
                         <div class="span4">Copy Quantity<br>
                                 <?= form_input(array('name'=>'copy_qty', 'id' => 'copy_qty', 'value' => @$query['copy_qty'])); ?>
                            </div>
                            <div class="span12">Receiver Name<br>
                                 <?= form_input(array('name'=>'receiver_name', 'id' => 'receiver_name', 'value' => @$query['receiver_name'], 'style' => 'direction:rtl')); ?>
                            </div>
                    </div>
                    <div class="row-form clearfix">
                         
                         <div class="span12">Sales Note<br>
                            <?php echo form_textarea(array('name'=>'sales_note','value'=>@$query['sales_note'])); ?></div>
                    </div>
                    
                </div>
                <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1>Related Companies ID :</h1>
                </div>
                <div class="block-fluid">
                    <div class="row-form clearfix">
                        <div class="span3">Companies ID #</div>
                        <div class="span9"><?php
                            echo form_input(array('name' => 'related_companies', 'value' => @$query['related_companies'], 'class' => 'tags')); ?>
                            <span style="color: red">Press Enter after add company ID </span>
                        </div>

                    </div>
                </div>

            </div>
            <div class="span6">
                <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1>General Info

                    </h1>
                    <h1 style="float:right !important; margin-right:10px;">معلومات عامة</h1>
                </div>
                <div class="block-fluid">

                    <div class="row-form clearfix">
                        <div class="span8"
                             style="text-align:right !important"><?php echo form_input($array_name_ar); ?>
                            <font color="#FF0000"><?php echo form_error('name_ar'); ?></font></div>
                        <div class="span4" style="text-align:right !important"><font color="#FF0000">*</font> : اسم
                            المؤسسة
                        </div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span8"><?php echo form_input($array_name_en); ?>
                            <font color="#FF0000"><?php echo form_error('name_en'); ?></font></div>
                        <div class="span4" style="text-align:right !important"><font color="#FF0000">*</font>:
                            Company Name
                        </div>
                    </div>
                    <div class="row-form clearfix">

                        <div class="span8"><?php
                            if ($sector_id != '') {
                                $sct = $this->Item->GetSectorById($sector_id);
                                echo @$sct['label_ar'] . '<br>';
                            }
                            $array_sectors = array('' => 'اختر');
                            foreach ($sectors as $sector) {
                                $array_sectors[$sector->id] = $sector->label_ar;
                            }
                            echo form_dropdown('sector_id', $array_sectors, $sector_id, 'style="direction:rtl" id="sector_id" class="select2" required="required"');

                            ?>
                            <font color="#FF0000"><?php echo form_error('sector_id'); ?></font></div>
                        <div class="span4" style="text-align:right"><font color="#FF0000">*</font>القطاع</div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span8"
                             style="text-align:right !important"><?php echo form_input($array_owner_name); ?>
                            <font color="#FF0000"><?php echo form_error('owner_name'); ?></font></div>
                        <div class="span4" style="text-align:right !important"> : صاحب المؤسسة</div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span8"><?php echo form_input($array_owner_name_en); ?>
                            <font color="#FF0000"><?php echo form_error('owner_name_en'); ?></font></div>
                        <div class="span4" style="text-align:right !important">: Company Owner</div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span8"><?php echo form_input($array_auth_person_ar); ?>
                            <font color="#FF0000"><?php echo form_error('auth_person_ar'); ?></font></div>
                        <div class="span4" style="text-align:right"> : المفوض بالتوقيع</div>

                    </div>
                    <div class="row-form clearfix">

                        <div class="span8"><?php echo form_input($array_auth_person_en); ?>
                            <font color="#FF0000"><?php echo form_error('auth_person_en'); ?></font></div>
                        <div class="span4" style="text-align:right">: Auth. to sign</div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span8"><?php echo form_input($array_auth_no); ?>
                            <font color="#FF0000"><?php echo form_error('auth_no'); ?></font></div>
                        <div class="span4" style="text-align:right">سجل تجاري</div>

                    </div>
                    <div class="row-form clearfix">
                        <div class="span8"><?php
                            $array_licenses = array(0 => 'اختر');
                            foreach ($license_sources as $license_item) {
                                $array_licenses[$license_item->id] = $license_item->label_ar;
                            }
                            echo form_dropdown('license_source_id', $array_licenses, $license_source_id, 'style="direction:rtl"');

                            ?>
                            <font color="#FF0000"><?php echo form_error('license_source_id'); ?></font></div>
                        <div class="span4" style="text-align:right">مصدر السجل</div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span8"
                             style="text-align:right !important"><?php echo form_input($array_activity_ar); ?>
                            <font color="#FF0000"><?php echo form_error('activity_ar'); ?></font></div>
                        <div class="span4" style="text-align:right !important"> : النشاط</div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span8"><?php echo form_input($array_activity_en); ?>
                            <font color="#FF0000"><?php echo form_error('activity_en'); ?></font></div>
                        <div class="span4" style="text-align:right !important"> : Activity</div>
                    </div>

                    <div class="row-form clearfix">
                        <div class="span8">
                            <?php
                            $array_types = array(0 => 'اختر');
                            if (count($company_types) > 0) {
                                foreach ($company_types as $types) {
                                    $array_types[$types->id] = $types->label_ar;

                                }

                            }
                            echo form_dropdown('company_type_id', $array_types, $company_type_id, 'style="direction:rtl"');
                            ?>
                        </div>
                        <div class="span4" style="text-align:right">نوع الشركة</div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span8">
                            <?php

                            echo form_dropdown('employees_number', $array_employees, @$query['employees_number'], 'style="direction:rtl"');
                            ?>
                        </div>
                        <div class="span4" style="text-align:right"> عدد العمال</div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span8"  style="text-align:right">
                            <?php
                            $checked_error=(@$query['error_address'] == 1) ? TRUE : FALSE;

                            echo form_checkbox('error_address', 1, $checked_error); ?>

                        </div>
                        <div class="span4" style="text-align:right;  font-weight: bold !important;"> عنوان خطأ </div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span8"  style="text-align:right">
                            <?php
                            if (@$query['is_closed'] == 1) {
                                $checked_c = TRUE;
                            } else {
                                $checked_c = FALSE;
                            }
                            echo form_checkbox('is_closed', 1, $checked_c); ?>

                        </div>
                        <div class="span4" style="text-align:right;  font-weight: bold !important;"> مغلقة </div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span8">

                            <?php echo form_input(array('name'=>'closed_date','value'=>@$query['closed_date'],'id'=>'closed_date','palceholder'=>'تاريخ الاغلاق')); ?>

                        </div>
                        <div class="span4" style="text-align:right; font-weight: bold !important;"> تاريخ الاغلاق </div>
                    </div>

                    <!--  <div class="row-form clearfix">
                       <div class="span8" ><?php echo form_input($array_establish_date); ?>
                        <font color="#FF0000"><?php echo form_error('establish_date'); ?></font>
                        </div>
						<div class="span4" style="text-align:right"> : سنة التأسيس </div>
                   </div>  -->
                </div>
                <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <!--<h1>Affiliation to Economical & Technical Associations</h1>-->
                    <h1 style="float:right; margin-right:10px;">الانتساب الى هيئات اقتصادية او مهنية</h1>
                </div>
                <div class="block-fluid">
                    <div class="row-form clearfix">

                        <div class="span8" style="text-align:right"><?php
                            if ($ind_association == 1) {
                                $checked = TRUE;
                            } else {
                                $checked = FALSE;
                            }
                            echo form_checkbox('ind_association', 1, $checked); ?></div>
                        <div class="span4" style="text-align:right">جمعية الصناعيين اللبنانين</div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span8">
                            <?php
                            $array_iro = array(0 => 'اختر ');
                            if (count($iro_data) > 0) {
                                foreach ($iro_data as $iro_item) {
                                    $array_iro[$iro_item->id] = $iro_item->label_ar;

                                }

                            }
                            echo form_dropdown('iro_code', $array_iro, $iro_code, 'style="direction:rtl"');
                            ?>
                        </div>
                        <div class="span4" style="text-align:right">غرفة التجارة الصناعة والزراعة في</div>
                    </div>
                  <?php /*  <div class="row-form clearfix">
                        <div class="span6"> <?= form_input(array('name' => 'chambe_commerce_category', 'id' => 'chambe_commerce_category', 'value' => @$chambe_commerce_category, 'style' => 'direction:rtl')); ?></div>
                         <div class="span2" style="text-align:right">الفئة غرفة</div>
                        <div class="span2"> <?= form_input(array('name' => 'chambe_commerce_no', 'id' => 'chambe_commerce_no', 'value' => @$chambe_commerce_no, 'style' => 'direction:rtl')); ?></div>
                        <div class="span2" style="text-align:right">رقم الغرفة </div>
                    </div> */?>
                 
                    <div class="row-form clearfix">
                        <div class="span8">
                            <?php
                            $array_igr = array(0 => 'اختر ');
                            if (count($igr_data) > 0) {
                                foreach ($igr_data as $igr_item) {
                                    $array_igr[$igr_item->id] = $igr_item->label_ar;

                                }

                            }
                            echo form_dropdown('igr_code', $array_igr, $igr_code, 'style="direction:rtl"');
                            ?>
                        </div>
                        <div class="span4" style="text-align:right">تجمع صناعي</div>

                    </div>

                    <div class="row-form clearfix">

                        <div class="span8"><?php
                            $array_eas = array(0 => 'اختر ');
                            if (count($eas_data) > 0) {
                                foreach ($eas_data as $eas_item) {
                                    $array_eas[$eas_item->id] = $eas_item->label_ar;

                                }

                            }
                            echo form_dropdown('eas_code', $array_eas, $eas_code, 'style="direction:rtl"');
                            ?></div>
                        <div class="span4" style="text-align:right">اتحادات مهنية اقليمية او دولية</div>
                    </div>


                </div>
                <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <!--<h1>Affiliation to Economical & Technical Associations</h1>-->
                    <h1 style="float:right; margin-right:10px;">الرخصة</h1>
                </div>
                <div class="block-fluid">
                    <div class="row-form clearfix">
                        <div class="span8">
                            <?= form_input(array('name' => 'ministry_id', 'id' => 'ministry_id', 'value' => @$query['ministry_id'], 'style' => 'direction:rtl')); ?>
                        </div>
                        <div class="span4" style="text-align:right">ID وزارة</div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span6" style="text-align:right">مراجع اخرى / حدد
                            <?= form_input(array('name' => 'other_source', 'id' => 'other_source', 'value' => @$other_source, 'style' => 'direction:rtl')); ?>
                        </div>
                        <div class="span3" style="text-align:right">  &nbsp;وزارة الصناعة &nbsp;<?php
                            $checked = (@$wezara_source == 1) ? TRUE : FALSE;

                            echo form_checkbox('wezara_source', 1, $checked); ?></div>
                        <div class="span3" style="text-align:right">مصدر الرخصة</div>
                    </div>

                    <div class="row-form clearfix">
                        <div class="span8">
                            <?= form_input(array('name' => 'nbr_source', 'id' => 'nbr_source', 'value' => @$nbr_source, 'style' => 'direction:rtl !important; text-align:right')); ?>
                        </div>
                        <div class="span4" style="text-align:right">رقم الرخصة</div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span8">
                            <?= form_input(array('name' => 'date_source', 'id' => 'date_source', 'value' => @$date_source, 'style' => 'direction:rtl')); ?>
                        </div>
                        <div class="span4" style="text-align:right">التاريخ</div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span8">
                            <?= form_input(array('name' => 'type_source', 'id' => 'type_source', 'value' => @$type_source, 'style' => 'direction:rtl')); ?>
                        </div>
                        <div class="span4" style="text-align:right">الفئة</div>
                    </div>
                </div>

                <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1>Note :</h1>
                    <h1 style="float:right; margin-right:10px;">ملاحظات شخصية</h1>
                </div>
                <div class="block-fluid">
                    <div class="row-form clearfix">
                        <div class="span12"><?php echo form_textarea($array_personal_notes); ?></div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span6 label-ar"><?php

                            if (@$display_directory == 1) {
                                if (@$directory_interested == 1) {
                                    $interested1 = TRUE;
                                    $interested2 = FALSE;
                                } else {
                                    $interested1 = FALSE;
                                    $interested2 = TRUE;
                                }
                            } else {
                                $interested1 = FALSE;
                                $interested2 = FALSE;
                            }
                            if (@$display_directory == 1) {
                                $checked_display_directory = TRUE;
                            } else {
                                $checked_display_directory = FALSE;
                            }
                            echo form_checkbox(array('checked' => $checked_display_directory, 'name' => 'display_directory', 'value' => 1)) . '&nbsp;<u>تم عرض الدليل&nbsp;</u>'; ?>
                        </div>
                        <div class="span3 label-ar"><?php
                            echo form_checkbox(array('checked' => $interested1, 'name' => 'directory_interested', 'value' => 1)) . '&nbsp;مهتم'; ?>
                        </div>
                        <div class="span3 label-ar"><?php
                            echo form_checkbox(array('checked' => $interested2, 'name' => 'directory_interested', 'value' => 0)) . '&nbsp;غير مهتم'; ?>
                        </div>


                    </div>
                    <div class="row-form clearfix">
                        <div class="span6 label-ar"><?php
                            if (@$display_exhibition == 1) {
                                if (@$exhibition_interested == 1) {
                                    $exinterested1 = TRUE;
                                    $exinterested2 = FALSE;
                                } else {
                                    $exinterested1 = FALSE;
                                    $exinterested2 = TRUE;
                                }
                            } else {
                                $exinterested1 = FALSE;
                                $exinterested2 = FALSE;
                            }
                            if (@$display_exhibition == 1) {
                                $checked_display_exhibition = TRUE;
                            } else {
                                $checked_display_exhibition = FALSE;
                            }

                            echo form_checkbox(array('checked' => $checked_display_exhibition, 'name' => 'display_exhibition', 'value' => 1)) . '&nbsp;<u>تم عرض المعرض</u>'; ?>
                        </div>
                        <div class="span3 label-ar"><?php
                            echo form_checkbox(array('checked' => $exinterested1, 'name' => 'exhibition_interested', 'value' => 1)) . '&nbsp;مهتم'; ?>
                        </div>
                        <div class="span3 label-ar"><?php

                            echo form_checkbox(array('checked' => $exinterested2, 'name' => 'exhibition_interested', 'value' => 0)) . '&nbsp;غير مهتم'; ?>
                        </div>

                    </div>
                </div> 

                <?php $this->load->view('clients',['client_id'=>$c_id,'client_type'=>'company','status_type'=>'show_items','title'=>'Show Items']);?>
            </div>

        </div>
        <?php if ($nave) {
            echo $this->load->view('company/_navigation');
        } ?>
    </div>
    <?= form_close() ?>
</div>