<script language="javascript">
$(function () {
        displaySponsor('ar');
    })
    function displaySponsor(lang) {
        $("#display-area").html("<center><img src='<?=base_url()?>img/loading.gif' /></center>");
        $.ajax({
            url: "<?php echo base_url();?>sponsors/DisplaySponsors",
            type: "post",
            data: "lang=" + lang+"&category=gold",
            success: function (result) {

                $("#display-area").html(result);
            }
        });
    }
    

</script>
<div class="content">
	<?=$this->load->view("includes/_bread")?>
    <div class="workplace">
        <div class="row-fluid">
            <div class="12">
                    <div class="head clearfix">
                        <div class="isw-documents"></div>
                        <h1>Language</h1>
                    </div>
                    <div class="block-fluid">
                       <div class="row-form clearfix">
                            <div class="span3"><?php $array_language=array('ar'=>'Ar','en'=>'En');
            										echo form_dropdown('language',$array_language,@$language,'onchange="displaySponsor(this.value);"');?></div>
            				<div class="span9"><div class="silver-sponsor" id="display-area"></div></div>
                        </div>
                      </div>
                </div>
            </div>
    </div>
</div>
