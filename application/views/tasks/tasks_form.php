<style type="text/css">
    .search, .select2{
        width:100%;
    }

</style>

<script type="text/javascript">
    $(function () {
        $(".select2").select2();
        $(".datep").datepicker({
            dateFormat: "yy-mm-dd"
        });

        $("#company-area").hide();
        $("#geo-area").hide();
        $("#all-area").hide();
        $('.category').change(function() {
            if (this.value == 'company') {
                $("#company-area").show();
                $("#geo-area").hide();
                $("#all-area").hide();
                $("#governorate_id").prop("disabled", true);
                $("#district_id").prop("disabled", true);
                $("#area_id").prop("disabled", true);
            }
            else if (this.value == 'area') {

                $("#geo-area").show();
                $("#company-area").hide();
                $("#all-area").hide();
                $("#governorate_id").prop("disabled", false);
                $("#district_id").prop("disabled", false);
                $("#area_id").prop("disabled", false);
            }
            else if (this.value == 'all') {
                getNbCompanies();
                $("#all-area").show();
                $("#geo-area").hide();
                $("#company-area").hide();
                $("#governorate_id").prop("disabled", true);
                $("#district_id").prop("disabled", true);
                $("#area_id").prop("disabled", true);
            }
        });
    })
    function getNbCompanies() {
        $("#all-area").html("loading ... ");
        $.ajax({
            url: "<?php echo base_url();?>tasks/GetCountCompanies",
            type: "post",
            data: "id="+$("#sales_man").val()+"&data_type="+$("#data_types").val(),
            success: function (result) {

                $("#all-area").html(result);
            }
        });
    }
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
            url: "<?php echo base_url();?>tasks/GetArea",
            type: "post",
            data: "id=" + district_id+"&sales_man="+$("#sales_man").val()+"&data_type="+$("#data_types").val(),
            success: function (result) {
                $("#area").html(result);
            }
        });
    }
    function getLastList(sales_man) {
        $("#list_id").val('Loading.....');
        $.ajax({
            url: "<?php echo base_url();?>tasks/GetLastList",
            type: "post",
            data: "id=" + sales_man,
            success: function (result) {
                $("#list_id").val(result);
            }
        });
    }

    $(document).ready(function () {

        $("#company_id").select2({
            <?php if(count(@$company_array)>0){ ?>
            initSelection: function(element, callback) {
                callback({id: <?=$company_array['id']?>, text: "<?=$company_array['name_ar']?>" });
            },
            <?php } ?>
            placeholder: 'اختر الشركة',
            allowClear: true,
            ajax: {
                url: "<?=base_url()?>tasks/GetCompanies",
                dataType: 'json',
                delay: 250,
                data: function (query) {
                    if (!query) query = 'Москва';

                    return {
                        geocode: query,
                        format: 'json'
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                results: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });
    });
</script>
<?php
$jsgov = 'id="governorate_id" onchange="getdistricts(this.value)" class="select2" required="required"';
$jsdis = 'id="district_id" onchange="getarea(this.value)" class="select2" required="required"';
?>
<div class="content">
    <?=$this->load->view("includes/_bread")?>
    <div class="workplace">
        <div class="page-header">
            <h1><?=$subtitle?></h1>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1>Tasks - استمارات</h1>
                </div>
                <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'validation')); ?>
                <div class="block-fluid">

                    <div class="row-form clearfix">
                        <?php
                        $array_sales_men=array(''=>'Select');
                        foreach($sales as $salesman){

                            $array_sales_men[$salesman->id]=$salesman->fullname;
                        }
                        ?>
                        <div class="span3">Sales Man</div>
                        <div class="span7"><?php echo form_dropdown('sales_man_id',$array_sales_men,@$query['sales_man_id'],' class="select2" id="sales_man" style="width:100% !important" onchange="getLastList(this.value)"'); ?></div>
                        <div class="span2 required"><?=form_error('sales_man_id'); ?></div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span3">List Number</div>
                        <div class="span7"><?=form_input(array('name'=>'list_id','readonly'=>'readonly','value'=>@$query['list_id'],'id'=>'list_id'))?></div>
                        <div class="span2 required"><?=form_error('list_id'); ?></div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span3">Category</div>
                        <div class="span7"><?php echo form_dropdown('category', array('scanning'=>'Scanning','delivery'=>'Delivery'), @$query['category']); ?></div>
                        <div class="span2 required"><?=form_error('category'); ?></div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span3">Data Type</div>
                        <?php
                            $data_types=array('all'=>'All','is_adv'=>'Advertiser','copy_res'=>'Copy Reservation','adv_copy'=>'Advertiser + Copy Reservation Only','adv_or_copy'=>'Advertiser OR Copy Reservation');
                        ?>
                        <div class="span7"><?=form_dropdown('data_types',@$data_types,'all','id="data_types" style="width:100% !important"'); ?></div>
                        <div class="span2 required"><?=form_error('data_types'); ?></div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span3">Type</div>
                        <div class="span2"><?php echo form_radio(array('name'=>'type','class'=>'category','value'=>'company')).' &nbsp;Company'; ?></div>
                        <div class="span2"><?php echo form_radio(array('name'=>'type','class'=>'category','value'=>'area')).' &nbsp;Area'; ?></div>
                        <div class="span2"><?php echo form_radio(array('name'=>'type','class'=>'category','value'=>'all')).' &nbsp;All'; ?></div>
                         <div class="span2 required" id="all-area"><?=form_error('type'); ?></div>
                        <div class="span2 required"><?=form_error('type'); ?></div>
                    </div>
                    <div class="row-form clearfix" id="company-area">
                        <div class="span3">Company</div>
                        <div class="span7"><?=form_multiselect('company_ids[]',@$array_companies,@$query['company_id'],'id="company_id" style="width:100% !important"'); ?></div>
                        <div class="span2 required"><?php echo form_error('company_id'); ?></div>
                    </div>
                    <div id="geo-area">
                    <div class="row-form clearfix">

                        <?php
                        $gover = array('' => 'اختر المحافظة');
                        foreach ($governorates as $governorate) {

                            $gover[$governorate->id] = $governorate->label_ar . ' ( ' . $governorate->label_en . ' )';
                        }
                        ?>
                        <div class="span3">Mohafaza</div>
                        <div class="span7"><?php echo form_dropdown('governorate_id', $gover, @$query['$governorate_id'], $jsgov); ?></div>
                        <div class="span2 required"><?=form_error('governorate_id'); ?></div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span3">Kazaa</div>
                        <div class="span7">
                            <div id="district">
                                <?php
                                $district_array = array('' => 'اختر القضاء');
                                if (count($districts) > 0) {
                                    foreach ($districts as $district) {

                                        $district_array[$district->id] = $district->label_ar . ' ( ' . $district->label_en . ' )';
                                    }
                                }
                                echo form_dropdown('district_id', $district_array, @$query['district_id'], $jsdis); ?></div>
                        </div>
                        <div class="span2 required"><?=form_error('district_id'); ?></div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span3">Area</div>
                        <div class="span7">
                            <div id="area">
                                <?php
                                $area_array = array('' => 'اختر البلدة');
                                if (count($areas) > 0) {
                                    foreach ($areas as $area) {

                                        $area_array[$area->id] = $area->label_ar . ' ( ' . $area->label_en . ' )';
                                    }
                                }
                                echo form_dropdown('area_id', $area_array, @$query['area_id'], ' id="area_id" class="select2"  required="required"'); ?></div>
                        </div>
                        <div class="span2 required"><?=form_error('area_id'); ?></div>
                    </div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span3">Start Date</div>
                        <div class="span7"><?php echo form_input(array('name'=>'start_date','value'=>@$query['start_date'],'class'=>'datep')); ?></div>
                        <div class="span2 required"><?=form_error('start_date'); ?></div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span3">Due Date</div>
                        <div class="span7"><?php echo form_input(array('name'=>'due_date','value'=>@$query['due_date'],'class'=>'datep')); ?></div>
                        <div class="span2 required"><?=form_error('due_date'); ?></div>
                    </div>

                    <div class="row-form clearfix">
                        <div class="span3">Status</div>
                        <div class="span7"><?php $array_status=array('pending'=>'Pending','done'=>'Done','canceled'=>'Canceled');
                            echo form_dropdown('status',$array_status,@$query['status']);
                            ?></div>
                        <div class="span2 required"><?=form_error('status'); ?></div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span3">Payment Status</div>
                        <div class="span7"><?php $array_payment_status=array('pending'=>'Pending','done'=>'Done','canceled'=>'Canceled');
                            echo form_dropdown('payment_status',$array_payment_status,@$query['payment_status']);
                            ?></div>
                        <div class="span2 required"><?=form_error('payment_status'); ?></div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span3">Notes</div>
                        <div class="span9"><?=form_textarea(array('name'=>'comments','value'=>@$query['comments'],'cols'=>40,'rows'=>6));?></div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span5"></div>
                        
                        <div class="span2"><?=form_submit(array('class'=>'btn','name'=>'save','value'=>'Save'))?></div>
                        <div class="span5"></div>
                    </div>
                </div>
                <?=form_close()?>
            </div>
        </div>
    </div>
</div>