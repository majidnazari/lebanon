<?php $class_sect=' class="search-select" id="governorate" onchange="getdistrict(this.value,'.@$district.')" ';?>
<?php $class_sect1=' class="search-select" id="governorate-d" onchange="getGovDistrict(this.value,'.@$districtg.')" ';?>
<script language="javascript">
$(function() {
    
    $('#salesman').hide();
    $('#area').hide(); 
    $('#district').hide();
    $('#sub').hide();
    
    $('#salesman').find('*').prop('disabled',true);
    $('#area').find('*').prop('disabled',true);
    $('#district').find('*').prop('disabled',true);
    $('#sub').find('*').prop('disabled',true);
    
    getType();
    function getType()
    {
        if($('#type').val() == 'salesman') {
            $('#salesman').show();
            $('#area').hide(); 
            $('#district').hide();
            $('#sub').show();
            
            $('#salesman').find('*').removeProp( "disabled" );
            $('#area').find('*').prop('disabled',true);
            $('#district').find('*').prop('disabled',true);
           $('#sub').find('*').removeProp( "disabled" );
           
        } else if($('#type').val() == 'area') {
             $('#salesman').hide();
            $('#area').show(); 
            $('#district').hide();
            $('#sub').show();
            
            $('#area').find('*').removeProp( "disabled" );
            $('#sub').find('*').removeProp( "disabled" );

            $('#salesman').find('*').prop('disabled',true);
            
            $('#district').find('*').prop('disabled',true);
            
            
        } 
        else if($('#type').val() == 'district') {
             $('#salesman').hide();
            $('#area').hide(); 
            $('#district').show();
            $('#sub').show();
            
            $('#district').find('*').removeProp( "disabled" );
            $('#sub').find('*').removeProp( "disabled" );

            $('#salesman').find('*').prop('disabled',true);
            
            $('#area').find('*').prop('disabled',true);
        } 
        else{
            $('#salesman').hide();
            $('#area').hide(); 
            $('#district').hide();
            $('#sub').hide();
            
            $('#sub').find('*').prop('disabled',true);
            $('#district').find('*').prop('disabled',true);

            $('#salesman').find('*').prop('disabled',true);
            
            $('#area').find('*').prop('disabled',true);
        }
    }
    $('#type').change(getType);
});
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

function getGovDistrict(gov_id,district_id)
	{
		$("#datagovdistrict").html("loading ... ");
		$.ajax({
			url: "<?php echo base_url();?>tasks/GetDistricts",
			type: "post",
			data: "id="+gov_id+"&district_id="+district_id,
			success: function(result){
				$("#datagovdistrict").html(result);
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
		$("#dataarea").html("loading ... ");
		$.ajax({
			url: "<?php echo base_url();?>companies/GetArea",
			type: "post",
			data: "id="+district_id,
			success: function(result){
				$("#dataarea").html(result);
			}
		});
	}


function printpage(url)
{
for (var i = 2; i < 9; i++) {
  child = window.open(url+'/'+i, "", "height=1px, width=1px");  //Open the child in a tiny window.
  window.focus();  //Hide the child as soon as it is opened.
  child.print();  //Print the child.
  child.close();  //Immediately close the child.
}
}
</script>                    

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
                <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'validation','method'=>'get'));?>
                  <div class="block-fluid">
                      <div class="row-form clearfix">
                        <div class="span2">Report Type</div>  
                        <div class="span4"><?=form_dropdown('type',array(''=>'Select a type','salesman'=>'By Salesmen','area'=>'By Area','district'=>'By Kazaa'),@$type,'id="type"');?></div>
                    </div>
                    <div class="row-form clearfix" id="salesman">
                        <div class="span2">Sales Man</div>  
                        <div class="span4"><?php
								$array_sales['']='All ';
								foreach($sales as $salesrow)
								{
                                    $array_sales[$salesrow->id]=$salesrow->fullname;
								}
											
								echo form_dropdown('salesman',$array_sales,@$salesman);
							?>
                        </div>
                    </div>
                    <div class="row-form clearfix" id="area">
                        <div class="span1">Mohafaza</div> 
                        <div class="span3"><?php 
								$array_governorates['']='All ';
								foreach($governorates as $governorate)
								{
									if($governorate->id!=0)
									$array_governorates[$governorate->id]=$governorate->label_ar;	
								}
											
								echo form_dropdown('governorate',$array_governorates,@$governorate_id,$class_sect);
							?>
                        </div>
                        <div class="span1">Kazaa</div> 
                        <div class="span3">
						<div id="datadistrict">
						<?php 
								$array_district['']='All ';
								foreach($districts as $district)
								{
									if($district->id!=0)
									$array_district[$district->id]=$district->label_ar;	
								}
											
								echo form_dropdown('district_id',$array_district,@$district_id,'  onchange="getarea(this.value)" class="search-select"');
							?>
                            </div>
                        </div>
                        <div class="span1">City</div> 
                        <div class="span3">
						<div id="dataarea">
						<?php 
								$array_area['']='All ';
								foreach($areas as $area)
								{
									if($area->id!=0)
									$array_area[$area->id]=$area->label_ar;	
								}
											
								echo form_dropdown('area_id',$array_area,@$area_id,' class="search-select"');
							?>
                            </div>
                    </div>                            
                </div>
                <div class="row-form clearfix" id="district">
                        <div class="span1">Mohafaza</div> 
                        <div class="span3"><?php 
								$array_governorates['']='All ';
								foreach($governorates as $governorate)
								{
									if($governorate->id!=0)
									$array_governorates[$governorate->id]=$governorate->label_ar;	
								}
											
								echo form_dropdown('governorate',$array_governorates,@$governorate_id,$class_sect1);
							?>
                        </div>
                        <div class="span1">Kazaa</div> 
                        <div class="span3">
						<div id="datagovdistrict">
						<?php 
								$array_district['']='All ';
								foreach($districts as $district)
								{
									if($district->id!=0)
									$array_district[$district->id]=$district->label_ar;	
								}
											
								echo form_dropdown('district_id',$array_district,@$district_id,' class="search-select"');
							?>
                            </div>
                        </div>
                        </div>
                      <div class="row-form clearfix" id="sub">
                        <div class="span12" style="text-align: center !important;"><input type="submit" name="search" value="Search" class="btn">
                            <input type="submit" name="clear" value="Clear" class="btn">
                        </div>
                    </div>                            
                </div>
				<?=form_close()?>
            </div>
        </div> 
        <div class="row-fluid">
            <div class="span12">
                <?=$display_view?>
            </div>                                
        </div>            
        <div class="dr"><span></span></div>            
    </div>
</div>
