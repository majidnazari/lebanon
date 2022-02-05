
<?php
$g_js='onchange="getdistricts(this.value)"';
?>
<script language="JavaScript" type="text/JavaScript">


    function getolddistricts(gov_id)
    {
        $("#district").html("loading ... ");
        $.ajax({
            url: "<?php echo base_url();?>addresses/GetOldDistricts",
            type: "post",
            data: "id="+gov_id,
            success: function(result){
                $("#old-district").html(result);
            }
        });
    }
    function getdistricts(gov_id)
    {
        $("#district").html("loading ... ");
        $.ajax({
            url: "<?php echo base_url();?>addresses/GetDistricts",
            type: "post",
            data: "id="+gov_id,
            success: function(result){
                $("#new-district").html(result);
            }
        });
    }


    function getoldarea(district_id)
    {
        $("#area").html("loading ... ");
        $.ajax({
            url: "<?php echo base_url();?>addresses/GetOldArea",
            type: "post",
            data: "id="+district_id,
            success: function(result){
                $("#old-area").html(result);
            }
        });
    }
    function getarea(district_id)
    {
        $("#area").html("loading ... ");
        $.ajax({
            url: "<?php echo base_url();?>addresses/GetArea",
            type: "post",
            data: "id="+district_id,
            success: function(result){
                $("#new-area").html(result);
            }
        });
    }

</script>
<div class="content">
   <?=$this->load->view("includes/_bread")?>         
    <div class="workplace">
        <div class="page-header">
            <h1>Area Move</h1>
        </div>                  
            <div class="row-fluid">
                <div class="span12">
                    <div class="head clearfix">
                        <div class="isw-documents"></div>
                        <h1>Area Move</h1>
                    </div>
                <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'validation'));
                ?>
                <div class="block-fluid">
                    <div class="row-form clearfix">
                        <div class="span4">Old Governorate *:<br>
                            <?php
                            $js='onchange="getolddistricts(this.value)"';
                            $array_governorate[0]='Select Governorate ';
                            foreach($governorates as $governorate)
                            {
                                if($governorate->id!=0)
                                    $array_governorate[$governorate->id]=$governorate->label_ar.' ('.$governorate->label_en.')';
                            }

                            echo form_dropdown('old_gov',$array_governorate,'',$js);

                            ?></div>

                        <div class="span4">Old District *:<br>
                            <div id="old-district"><?=form_dropdown('o_d',array(),'');?></div>
                        </div>
                        <div class="span4">Old Area *:<br>
                            <div id="old-area"><?=form_dropdown('o_a',array(),'');?></div>
                        </div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span4">New Governorate *:<br>
                            <?php
                            $js='onchange="getdistricts(this.value)"';
                            $array_governorate[0]='Select Governorate ';
                            foreach($governorates as $governorate)
                            {
                                if($governorate->id!=0)
                                    $array_governorate[$governorate->id]=$governorate->label_ar.' ('.$governorate->label_en.')';
                            }

                            echo form_dropdown('new_gov',$array_governorate,'',$js);

                            ?></div>

                        <div class="span4">New District *:<br>
                            <div id="new-district"><?=form_dropdown('n_d',array(),'');?></div>
                        </div>
                        <div class="span4">New Area *:<br>
                            <div id="new-area"><?=form_dropdown('n_a',array(),'');?></div>
                        </div>
                    </div>

                    <div class="footer tar">
                        <center><input type="submit" name="save" value="Move" class="btn"></center>
                    </div>
                </div>
                <?=form_close()?>
                <div class="dr"><span></span></div>
            </div>
            </div>
    </div>
</div>