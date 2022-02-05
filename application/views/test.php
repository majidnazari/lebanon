<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/jquery.field.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/jquery.calculation.js"></script>
	<script type="text/javascript">
	var bIsFirebugReady = (!!window.console && !!window.console.log);

	$(document).ready(
		function (){
			// update the plug-in version
			$("#idPluginVersion").text($.Calculation.version);
			// bind the recalc function to the quantity fields
			$("input[name^=qty_item_]").bind("keyup", recalc);
			// run the calculation function now
			recalc();
			// the values are changes via the keyup event
			$("input[name^=sum]").sum("keyup", "#totalSum");
			$("#idTotalTextSum").click(
				function (){
					var sum = $(".textSum").sum();
					$("#totalTextSum").text("$" + sum.toString());
				}
			);

			// this calculates the average for some text nodes

		}
	);
	
	function recalc(){
		$("[id^=total_item]").calc(
			// the equation to use for the calculation
			function ($this){
				// sum the total of the $("[id^=total_item]") selector
				var sum = $this.sum();
				
				$("#grandTotal").text(
					// round the results to 2 digits
					"$" + sum.toFixed(2)
				);
			}
		);
	}
	</script>

<script language="javascript">
jQuery(function($){
   $("#birthdate").mask("9999-99-99");
   $("#end_date").mask("9999-99-99");
});
		function getschedules(company_id,s_id)
		{
			$("#schedule_p").html("loading ... ");
			$.ajax({
				url: "<?php echo base_url();?>invoices/GetListSchedules",
				type: "post",
				data: "id="+company_id+"&schedule_id="+s_id,
				success: function(result){
					$("#schedule_p").html(result);
				}
			});
		}
</script>    

<?php
$invoice_number = array(
	'name'	=> 'invoice_number',
	'id'	=> 'invoice_number',
	'value' => $invoice_number,
);
$hijri_date = array(
	'name'	=> 'hijri_date',
	'id'	=> 'hijri_date',
	'value' => $hijri_date,
);
$vendor_name = array(
	'name'	=> 'vendor_name',
	'id'	=> 'vendor_name',
	'value' => $vendor_name,
);
$vendor_name_ar = array(
	'name'	=> 'vendor_name_ar',
	'id'	=> 'vendor_name_ar',	
	'value' => $vendor_name_ar,
);
$vendor_number = array(
	'name'	=> 'vendor_number',
	'id'	=> 'vendor_number',	
	'value' => $vendor_number,
);
$contract_name = array(
	'name'	=> 'contract_name',
	'id'	=> 'contract_name',	
	'value' => $contract_name,
);
$contract_name_ar = array(
	'name'	=> 'contract_name_ar',
	'id'	=> 'contract_name_ar',	
	'value' => $contract_name_ar,
);
$contract_number = array(
	'name'	=> 'contract_number',
	'id'	=> 'contract_number',	
	'value' => $contract_number,
);
$phone = array(
	'name'	=> 'phone',
	'id'	=> 'phone',	
	'value' => $phone,
);
$fax = array(
	'name'	=> 'fax',
	'id'	=> 'fax',	
	'value' => $fax,
);
$mobile = array(
	'name'	=> 'mobile',
	'id'	=> 'mobile',	
	'value' => $mobile,
);
$email = array(
	'name'	=> 'email',
	'id'	=> 'email',	
	'value' => $email,
);
$job_title = array(
	'name'	=> 'job_title',
	'id'	=> 'job_title',	
	'value' => $job_title,
);
$business_type = array(
	'name'	=> 'business_type',
	'id'	=> 'business_type',	
	'value' => $business_type,
);
$birthdate = array(
	'name'	=> 'birthdate',
	'id'	=> 'birthdate',	
	'value' => $birthdate,
);

$others = array(
	'name'	=> 'others',
	'id'	=> 'others',
	'class'	=> '',	
	'value' => $others,
	'cols'  =>35,
	'rows'  =>5,	
);
$sch_js='id="schedule_id" onchange="getclients(this.value,'.$company_id.')"';
//if($city=='')
//$city=0;
//$class_country=' class="validate[required]" id="country_id" onchange="getcity(this.value,'.$city.')"';
$company_js='id="company_id" onchange="getschedules(this.value,0)"';
?>
<div class="content">
<legend>Calculation Examples</legend>
<div id="schedule_p"></div>
   <?=$this->load->view("includes/_bread")?>         
    <div class="workplace">
    
        <div class="page-header">
            <h1><?=$subtitle?></h1>
        </div> 
		 <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'validation'));
          echo form_hidden('invoice_id',$invoice_id); ?>                     
        <div class="row-fluid">
            <div class="span12">

                
                <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1>Biding Invoice</h1>
                </div>
                <div class="block-fluid">
					<div class="row-form clearfix">
                        <div class="span2">Invoice Number:</div>
                        <div class="span2"><?php echo form_input($invoice_number); ?>
                        <font color="#FF0000"><?php echo form_error('invoice_number'); ?></font></div>
                        <div class="span2">Hijri Date:</div>
                        <div class="span2"><?php echo form_input($hijri_date); ?>
                        <font color="#FF0000"><?php echo form_error('hijri_date'); ?></font></div>
                        <div class="span1">Company:</div>
                        <div class="span3"><?php 
								$array_clients[0]='Select Client';
								foreach($clients as $client)
								{
									if($client->id!=0)
									$array_clients[$client->id]=$client->name;	
								}
								
											
								echo form_dropdown('company_id',$array_clients,$company_id,$company_js);
							?></div>
                    </div>
					<div class="row-form clearfix">
                        <div class="span2">Vendor Name:</div>
                        <div class="span2"><?php echo form_input($vendor_name); ?>
                        <font color="#FF0000"><?php echo form_error('vendor_name'); ?></font></div>
                        <div class="span2">Vendor Name(باللغة العربية):</div>
                        <div class="span2"><?php echo form_input($vendor_name_ar); ?>
                        <font color="#FF0000"><?php echo form_error('vendor_name_ar'); ?></font></div>
                        <div class="span2">Vendor Number:</div>
                        <div class="span2"><?php echo form_input($vendor_number); ?>
                        <font color="#FF0000"><?php echo form_error('vendor_number'); ?></font></div>
                    </div>
					<div class="row-form clearfix">
                        <div class="span2">Contract Name:</div>
                        <div class="span2"><?php echo form_input($contract_name); ?>
                        <font color="#FF0000"><?php echo form_error('contract_name'); ?></font></div>
                        <div class="span2">Contract Name(باللغة العربية):</div>
                        <div class="span2"><?php echo form_input($contract_name_ar); ?>
                        <font color="#FF0000"><?php echo form_error('contract_name_ar'); ?></font></div>
                        <div class="span2">Contract Number:</div>
                        <div class="span2"><?php echo form_input($contract_number); ?>
                        <font color="#FF0000"><?php echo form_error('contract_number'); ?></font></div>
                    </div>                                                                               
                </div>
                  
            </div>
		</div>
        <div class="row-fluid">	            
			<div class="span12">
                <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1>Classes Schedules</h1>
                </div>            
                <div class="block-fluid"> 
                <div id="schedule_p"></div>

                 
                 	<div class="row-form clearfix">
                        <div class="span3">Total Amount</div>
                        <div class="span7"> <input id="Text1" class="amt" type="text" /><br />
    <input id="Text2" class="amt" type="text" /><br />
    <input id="Text3" class="amt" type="text" /><br />  
    <input id="addAll" type="button" value="Sum all Textboxes" /><br />
    <p id="para" /></div>
                    </div> 
                    <div class="footer tar">
                    	<center><input type="submit" name="save" value="Save" class="btn"></center>
                    </div> 
                 </div>                         
            </div> 
        </div>
        
        <?=form_close()?>
    </div>
</div>