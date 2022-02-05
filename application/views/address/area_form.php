
<?php
$g_js='onchange="getdistricts(this.value)"';
$add_js='onchange="getdistrictsadd(this.value)"';
?>
<script language="JavaScript" type="text/JavaScript">

    function printall()
    {
        checkboxes = document.getElementsByName('checkall');
        checkboxes.checked =true;
        document.getElementById("form_id").target = "_blank";
        document.getElementById("form_id").action = "<?=base_url().'companies/printall'?>";
        document.getElementById("form_id").submit();

    }

    function getdistricts(gov_id)
    {
        $("#district").html("loading ... ");
        $.ajax({
            url: "<?php echo base_url();?>addresses/GetDistricts",
            type: "post",
            data: "id="+gov_id,
            success: function(result){
                $("#district").html(result);
            }
        });
    }
    function getdistrictsadd(gov_id)
    {
        $("#district_add").html("loading ... ");
        $.ajax({
            url: "<?php echo base_url();?>addresses/GetDistricts",
            type: "post",
            data: "id="+gov_id,
            success: function(result){
                $("#district_add").html(result);
            }
        });
    }
    function geteditdistricts(gov_id,itemid)
    {
        $("#district"+itemid).html("loading ... ");
        $.ajax({
            url: "<?php echo base_url();?>addresses/GetDistricts",
            type: "post",
            data: "id="+gov_id,
            success: function(result){
                $("#district"+itemid).html(result);
            }
        });
    }
    function getarea(district_id)
    {
        $("#area").html("loading ... ");
        $.ajax({
            url: "<?php echo base_url();?>banks/GetArea",
            type: "post",
            data: "id="+district_id,
            success: function(result){
                $("#area").html(result);
            }
        });
    }
    jQuery(function($){
        $("#app_refill_date").mask("9999-99-99");
        $("#end_date").mask("9999-99-99");
        $("#x_location").mask("99°99'99\"");
        $("#y_location").mask("99°99'99\"");
    });
</script>
<div class="content">
   <?=$this->load->view("includes/_bread")?>         
    <div class="workplace">
        <div class="page-header">
            <h1>Area Edit</h1>
        </div>                  
            <div class="row-fluid">
                <div class="span12">
                    <div class="head clearfix">
                        <div class="isw-documents"></div>
                        <h1>Area Edit</h1>
                    </div>
                <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'validation'));
                ?>
                <div class="block-fluid">
                    <div class="row-form clearfix">
                        <div class="span3">Title In english *:</div>
                        <div class="span9"><input type="text" name="label_en" value="<?=$query['label_en']?>" required="required" /></div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span3">Title In arabic *:</div>
                        <div class="span9"><input type="text" name="label_ar" value="<?=$query['label_ar']?>" required="required" /></div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span3">Governorate *:</div>
                        <div class="span9">
                            <?php
                            $dists=$this->Address->GetDistrictByGov('online',$query['governorate_id']);
                            $js='onchange="geteditdistricts(this.value,'.$query['id'].')"';
                            $array_governorate[0]='Select Governorate ';
                            foreach($governorates as $governorate)
                            {
                                if($governorate->id!=0)
                                    $array_governorate[$governorate->id]=$governorate->label_ar.' ('.$governorate->label_en.')';
                            }

                            echo form_dropdown('governorate_id',$array_governorate,$query['governorate_id'],$js);

                            ?></div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span3">District *:</div>
                        <div class="span9">
                            <div id="district<?=$query['id']?>">
                                <?php
                                $array_dist['']='Select District ';
                                foreach($districts as $dist)
                                {
                                    if($dist->id!=0)
                                        $array_dist[$dist->id]=$dist->label_ar.' ('.$dist->label_en.')';
                                }

                                	echo form_dropdown('district',$array_dist,$query['district_id'],'class="select2"');

                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span3">Status</div>
                        <div class="span9"><?php $array_status=array('online'=>'Online','offline'=>'Offline');
                            echo form_dropdown('status',$array_status,$query['status']);
                            ?></div>
                    </div>
                    <div class="footer tar">
                        <center><input type="submit" name="save" value="Save" class="btn"></center>
                    </div>
                </div>
                <?=form_close()?>
                <div class="dr"><span></span></div>
            </div>
            </div>
    </div>
</div>