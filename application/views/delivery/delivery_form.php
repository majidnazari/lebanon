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

        $("#data-type-area").hide();

        $('#category').change(function() {
            if (this.value == 'general') {
                $("#data-type-area").hide();
                $("#data-type-area").prop("disabled", true);
            }
            else  {

                $("#data-type-area").show();
                $("#data-type-area").prop("disabled", false);
            }
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

        });
    })
    function getNbCompanies() {
        $("#all-area").html("loading ... ");
        $.ajax({
            url: "<?php echo base_url();?>tasks/GetCountCompanies",
            type: "post",
            data: "id="+$("#sales_man").val()+"&data_type=general",
            success: function (result) {

                $("#all-area").html(result);
            }
        });
    }
    function getdistricts(gov_id) {
        $("#district").html("loading ... ");
        $.ajax({
            url: "<?php echo base_url();?>delivery/GetDistricts",
            type: "post",
            data: "id=" + gov_id,
            success: function (result) {

                $("#district").html(result);
                getarea(0);
            }
        });
    }
    function getarea(district_id) {
        $("#area").html("loading ... ");
        $.ajax({
            url: "<?php echo base_url();?>delivery/GetArea",
            type: "post",
            data: "id=" + district_id+"&gov="+$("#governorate_id").val()+"&sales_man="+$("#sales_man").val()+"&salesmen="+$("#sales_men").val(),
            success: function (result) {
                $("#area").html(result);
            }
        });
    }
    function getSalesmanCompanies() {

        $("#company_nbr").html('Loading.....');
        $.ajax({
            url: "<?php echo base_url();?>delivery/GetSalesmanCompanies",
            type: "post",
            data: "id=" + $("#sales_man").val()+"&category=general&salesmen="+$("#sales_men").val(),
            success: function (result) {
                $("#company_nbr").html(result);
                 getarea(0);
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
$jsgov = 'id="governorate_id" onchange="getdistricts(this.value)" class="select2" ';
$jsdis = 'id="district_id" onchange="getarea(this.value)" class="select2" ';
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
                        <div class="span2">Delivery Type </div>
                        <div class="span4"><?php echo form_dropdown('delivery_type', array('guide'=>'Guide','magazine'=>'Magazine','madelebanon'=>'Made Lebanon'), @$query['type']); ?><?=form_error('delivery_type'); ?></div>
                        <?php
                        $array_sales_men=array(''=>'Select');
                        $array_delivery_man=array();
                        foreach($sales as $salesman){

                            $array_sales_men[$salesman->id]=$salesman->fullname;
                            $array_delivery_man[$salesman->id]=$salesman->fullname;
                        }
                        ?>
                        <div class="span2">Data Sales Man </div>
                        <div class="span3"><?php echo form_multiselect('sales_men[]',$array_delivery_man,@$query['sales_man_id'],' class="select2" id="sales_men" style="width:100% !important" onchange="getSalesmanCompanies()"'); ?><?=form_error('sales_man_id'); ?></div>
                        <div class="span1"  id="company_nbr"></div>
                    </div>

                    <div class="row-form clearfix">
                        <div class="span2">Delivery Person </div>
                        <div class="span3"><?php echo form_dropdown('sales_man_id',$array_sales_men,@$query['sales_man_id'],' required="required" class="select2" id="sales_man" style="width:100% !important"'); ?><?=form_error('sales_man_id'); ?></div>
                    </div>

                    <div class="row-form clearfix">

                        <?php
                        $gover = array('' => 'اختر المحافظة');
                        foreach ($governorates as $governorate) {

                            $gover[$governorate->id] = $governorate->label_ar . ' ( ' . $governorate->label_en . ' )';
                        }
                        ?>
                        <div class="span2">Mohafaza</div>
                        <div class="span4"><?php echo form_dropdown('governorate_id', $gover, @$query['$governorate_id'], $jsgov); ?><div class="required"><?=form_error('governorate_id'); ?></div></div>
                        <div class="span2">Kazaa</div>
                        <div class="span4">
                            <div id="district">
                                <?php
                                $district_array = array('' => 'اختر القضاء');
                                if (count($districts) > 0) {
                                    foreach ($districts as $district) {

                                        $district_array[$district->id] = $district->label_ar . ' ( ' . $district->label_en . ' )';
                                    }
                                }
                                echo form_dropdown('district_id', $district_array, @$query['district_id'], $jsdis); ?></div>
                            <div class="required"><?=form_error('district_id'); ?></div>
                        </div>


                    </div>
                    <div class="row-form clearfix">
                        <div class="span2">Area</div>
                        <div class="span10">
                            <div id="area">

                                <?php /*
                                $area_array = array('' => 'اختر البلدة');
                                if (count($areas) > 0) {
                                    foreach ($areas as $area) {

                                        $area_array[$area->id] = $area->label_ar . ' ( ' . $area->label_en . ' )';
                                    }
                                }
                                echo form_multiselect('area_id[]', $area_array, @$query['area_id'], ' id="area_id" class="select2"  required="required"'); */ ?></div>
                            <div class="required"><?=form_error('area_id'); ?></div>
                        </div>

                    </div>

                    <div class="row-form clearfix">
                        <div class="span2">Start Date</div>
                        <div class="span4"><?php echo form_input(array('name'=>'start_date','value'=>@$query['start_date'],'class'=>'datep', 'required'=>"required")); ?><div class="required"><?=form_error('start_date'); ?></div></div>
                        <div class="span2">Due Date</div>
                        <div class="span4"><?php echo form_input(array('name'=>'due_date','value'=>@$query['due_date'],'class'=>'datep', 'required'=>"required")); ?><div class="required"><?=form_error('due_date'); ?></div></div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span2">Status</div>
                        <div class="span4"><?php $array_status=array('pending'=>'Pending','done'=>'Done','canceled'=>'Canceled');
                            echo form_dropdown('status',$array_status,@$query['status']);
                            ?> <div class="required"><?=form_error('status'); ?></div></div>
                        <div class="span2">Payment Status</div>
                        <div class="span4"><?php $array_payment_status=array('pending'=>'Pending','done'=>'Done','canceled'=>'Canceled');
                            echo form_dropdown('payment_status',$array_payment_status,@$query['payment_status']);
                            ?>
                            <div class="required"><?=form_error('payment_status'); ?></div></div>
                    </div>

                    <div class="row-form clearfix">
                        <div class="span2">Notes</div>
                        <div class="span10"><?=form_textarea(array('name'=>'comments','value'=>@$query['comments'],'cols'=>40,'rows'=>6));?></div>
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