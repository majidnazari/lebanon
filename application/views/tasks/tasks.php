
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
$array_company_name=array('id'=>'name','name'=>'name','value'=>@$CompanyName);
$array_id=array('id'=>'id','name'=>'id','value'=>@$id);

$array_phone=array('id'=>'phone','name'=>'phone','value'=>@$phone);

$array_activity=array('id'=>'activity','name'=>'activity','value'=>@$activity);
if(@$districtID=='')
$districtID=0;
$class_sect=' class="search-select" id="sector_id" onchange="getdistrict(this.value,'.$district.')" ';
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
                     <ul class="buttons">
                         <li>&nbsp;<?=anchor('tasks/lists?ref='.@$ref.'&company='.@$company_id.'&governorate='.@$governorate_id.'&district='.@$district_id.'&area='.@$area_id.'&list='.@$list.'&sales_man='.@$sales_man.'&year='.@$year.'&from_start='.@$from_start.'&to_start='.@$to_start.'&from_due='.@$from_due.'&to_due='.@$to_due.'&status='.@$status.'&category='.@$category.'&search=Search','<h3>Print List</h3>',array('target'=>'_blank'))?>&nbsp;</li>
                         <li>&nbsp;<?=anchor('tasks/print_all?ref='.@$ref.'&company='.@$company_id.'&governorate='.@$governorate_id.'&district='.@$district_id.'&area='.@$area_id.'&list='.@$list.'&sales_man='.@$sales_man.'&year='.@$year.'&from_start='.@$from_start.'&to_start='.@$to_start.'&from_due='.@$from_due.'&to_due='.@$to_due.'&status='.@$status.'&category='.@$category.'&search=Search','<h3>Print All</h3>',array('target'=>'_blank'))?>&nbsp;</li>
                     </ul>
                 </div>
                <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'validation','method'=>'get'));
                ?>
                  <div class="block-fluid">
                    <div class="row-form clearfix">
                        <div class="span1">List : <br /><?php echo form_input(array('name'=>'list','value'=>@$list,'placeholder'=>'List number')); ?></div>
                        <div class="span1">ID : <br /><?php echo form_input(array('name'=>'company_id','value'=>@$company_id,'placeholder'=>'Company ID')); ?></div>
                        <div class="span2">Company Name (اسم الشركة)<br />
                        <?php echo form_input(array('name'=>'company_name','value'=>@$company_name,'placeholder'=>'Company Name')); ?>
                        <!-- <?=form_dropdown('company',@$array_companies,@$company,'id="company" style="width:100% !important"'); ?> -->
                    </div>
                        <div class="span2">Sales Man<br /><?php
                        $array_sales_men=array(''=>'Select');
                        foreach($sales as $salesman){

                            $array_sales_men[$salesman->id]=$salesman->fullname;
                        }

                            echo form_dropdown('sales_man',$array_sales_men,@$sales_man,' class="select2" style="width:100% !important"'); ?></div>
                        <div class="span3">Start Date
                            <div class="span12">
                            <div class="span6"><?php echo form_input(array('name'=>'from_start','value'=>@$from_start,'class'=>'datep','placeholder'=>'From')); ?></div>
                            <div class="span6"><?php echo form_input(array('name'=>'to_start','value'=>@$to_start,'class'=>'datep','placeholder'=>'To')); ?></div>
                            </div>
                        </div>
                        <div class="span3">Due Date
                            <div class="span12">
                            <div class="span6"><?php echo form_input(array('name'=>'from_due','value'=>@$from_due,'class'=>'datep','placeholder'=>'From')); ?></div>
                            <div class="span6"><?php echo form_input(array('name'=>'to_due','value'=>@$to_due,'class'=>'datep','placeholder'=>'To')); ?></div>
                            </div>
                        </div>
                        
                    </div>                            
                               

                    <div class="row-form clearfix">
                        <div class="span2">Mohafaza<br /><?php
								$array_governorates[0]='All ';
								foreach($governorates as $governorate)
								{
									if($governorate->id!=0)
									$array_governorates[$governorate->id]=$governorate->label_ar;	
								}
											
								echo form_dropdown('governorate_id',$array_governorates,@$governorate_id,$class_sect);
							?>
                        </div>

                        <div class="span2">Kazaa (القضاء)<br />
						<div id="datadistrict">
						<?php 
								$array_district[0]='All ';
								foreach($districts as $district)
								{
									if($district->id!=0)
									$array_district[$district->id]=$district->label_ar;	
								}
											
								echo form_dropdown('district_id',$array_district,@$district_id,'  onchange="getarea(this.value)" class="search-select"');
							?>
                            </div>
                        </div>
                        <div class="span2">City (المنطقة)<br />
						<div id="area">
						<?php 
								$array_area[0]='All ';
								foreach($areas as $area)
								{
									if($area->id!=0)
									$array_area[$area->id]=$area->label_ar;	
								}
											
								echo form_dropdown('area_id',$array_area,@$area_id,' class="search-select"');
							?>
                            </div>
                        </div>

                        <div class="span2">Status<br /><?php $array_status=array(''=>'Any','done'=>'Done','pending'=>'Pending','canceled'=>'Canceled');
												echo form_dropdown('status',$array_status,$status);
							?></div>
                        <div class="span2">Category<br /><?php $array_categories=array(''=>'Any','scanning'=>'Scanning','delivery'=>'Delivery');
                            echo form_dropdown('category',$array_categories,@$category);
                            ?></div>
                        <div class="span2"><br /><input type="submit" name="search" value="Search" class="btn">
                        <input type="submit" name="clear" value="Clear" class="btn">
                        </div>
                    </div>                            
                </div>
				<?=form_close()?>
            </div>
        </div>
        <script>
            function SubmitForm(id)
            {
                document.getElementById("form_id").action = "<?=base_url().'tasks/update_status/'?>"+id;
                document.getElementById("form_id").submit();

            }
        </script>
        <?=$this->load->view('tasks/_task_grid')?>
        <div class="dr"><span></span></div>            
    </div>
</div>
