
<script language="javascript">



    function ShowDeliveryDate(value,id)
    {
        if(value=='done')
        {
            $("#delivery"+id).show();
        }
        else{
            $("#delivery"+id).hide();
        }

    }

function change_status(id,status)
	{
		$("#status-area-"+id).html("loading ... ");
		$.ajax({
			url: "<?php echo base_url();?>companies/change_status",
			type: "post",
			data: "id="+id+"&status="+status,
			success: function(result){
				$("#status-area-"+id).html(result);
			}
		});
	}
function getdistrict(gov_id,district_id)
	{
		$("#datadistrict").html("loading ... ");
		$.ajax({
			url: "<?php echo base_url();?>companies/GetDistricts",
			type: "post",
			data: "id="+gov_id+"&district_id="+district_id,
			success: function(result){
				$("#datadistrict").html(result);
			}
		});
	}
function getarea(district_id)
	{
		$("#area").html("loading ... ");
		$.ajax({
			url: "<?php echo base_url();?>companies/GetArea",
			type: "post",
			data: "id="+district_id,
			success: function(result){
				$("#area").html(result);
			}
		});
	}
$(function () {
    $(".delivery-date").hide();
    $(".select2").select2();
    $(".datep").datepicker({
        dateFormat: "yy-mm-dd"
    });
})

$(document).ready(function () {
    $("#company").select2({
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
$array_name=array('id'=>'name','name'=>'name','value'=>@$name);
$array_id=array('id'=>'id','name'=>'id','value'=>@$id);

$array_phone=array('id'=>'phone','name'=>'phone','value'=>@$phone);

$array_activity=array('id'=>'activity','name'=>'activity','value'=>@$activity);
if(@$districtID=='')
$districtID=0;
$class_sect=' class="search-select" id="sector_id" onchange="getdistrict(this.value,'.@$district.')" ';
$class_sect1=' class="validate[required]"  required="required" id="sector" onchange="getsection1(this.value,0)"';
$class_sect2=' class="validate[required]"  required="required" id="sector2" onchange="getsection2(this.value,0)"';

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

    function printarea()
    {
        checkboxes = document.getElementsByName('checkall');
        checkboxes.checked =true;
        //document.getElementById("form_id").target = "_blank";
        document.getElementById("form_id").action = "<?=base_url().'companies/task_create'?>";
        document.getElementById("form_id").submit();

    }
</script>
<style type="text/css">
.sub-link{
	padding-left:10px !important;
}
</style>
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
                <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'validation','method'=>'get'));
                ?>
                  <div class="block-fluid">
                    <div class="row-form clearfix">
                        <div class="span1">ID : </div>
                        <div class="span2"><?php echo form_input(array('name'=>'company_id','value'=>$this->input->get('company_id'),'placeholder'=>'Company ID','class'=>'')); ?></div>
                        <div class="span1"><input type="submit" name="search" value="Search" class="btn"></div>
                        <div class="span1"><input type="submit" name="clear" value="Clear" class="btn"></div>
                    </div>                            
                  </div>
				<?=form_close()?>
            </div>
        </div>
        
        <?=$this->load->view('delivery/_items_grid')?>
        <div class="dr"><span></span></div>            
    </div>
</div>
