<?php

class Invoices extends Application
{
	
	public function __construct()
	{

		parent::__construct();
		$this->ag_auth->restrict('invoices'); // restrict this controller to admins only
		$this->load->model(array('Administrator','Schedule','Course','Country','Provider','Registration','Client','Bank','Invoice'));
						
	}
	public function delete()
	{
		$get = $this->uri->uri_to_assoc();
		if((int)$get['id'] > 0){
			$this->General->delete('training_invoices',array('id'=>$get['id']));
			$this->session->set_userdata(array('admin_message'=>'Deleted'));
			redirect($_SERVER['HTTP_REFERER']);
		 } 
	}
	public function major_delete()
	{
		$get = $this->uri->uri_to_assoc();
		if((int)$get['id'] > 0){
			$this->General->delete('training_schedules',array('id'=>$get['id']));
			$this->session->set_userdata(array('admin_message'=>'Deleted'));
			redirect('courses/majors');
		 } 
	}
	public function delete_checked()
	{
		$delete_array=$this->input->post('checkbox1');
		//var_dump()
			if(empty($delete_array)) {
				$this->session->set_userdata(array('admin_message'=>'No Item Checked'));
				redirect($_SERVER['HTTP_REFERER']);
    // No items checked
			}
		else {
    			foreach($delete_array as $d_id) {
				
				$this->General->delete('training_invoices',array('id'=>$d_id));
        // delete the item with the id $id
    		}
				$this->session->set_userdata(array('admin_message'=>'Deleted'));
				redirect($_SERVER['HTTP_REFERER']);
		}
	}
	public function GetClients()
	{
		
		$s_id	= $_POST['id'];
		$company_id	= $_POST['company_id'];
		$clients=$this->Invoice->GetClientByScheduleId($s_id);
		$array_clients['']='Select Client';
		//$array_clients[0]='Private Client';
		foreach($clients as $client)
			{
				$array_clients[$client->company_id]=$client->company;
			}
		$client_class=' id="company_id"  class="validate[required]"  onchange="getTrainees(this.value,0)"';	
		echo form_dropdown('company_id', $array_clients,$company_id,$client_class);
		}	
	public function GetListSchedules()
	{
		
	echo '<script language="javascript">
	var bIsFirebugReady = (!!window.console && !!window.console.log);
 $(document).ready(function() {
	// alert();
 $("#discount").on("keyup keypress blur change load", function() {
 var dis = $("#discount");//reading the discount percentage
// var disamt = $("#txtDisAmt");//reading the discount amount
 var amt = $("#total_amount");//Reading Amount
 var net = $("#total_net_amount");// Reading Net amount
 var net1;
 if (amt.val() > 0) {
 if (dis.val() > 0) {
 	net1 = amt.val() * (100 - dis.val()) ; //net amount calculation
	net=net1/100 + "";
// disamt = amt.val() - net;//Discount amount calculation
 $("#total_net_amount").attr("value", net); //assign net amount to html control
// $("#txtDisAmt").attr("value", disamt); //assign Discount amount to html control
 } else {
 amt = amt.val() + "";
 $("#total_net_amount").attr("value", amt);
 }
 }
 });
 });
 	
	$(document).ready(
		function (){
			// update the plug-in version
			$("#idPluginVersion").text($.Calculation.version);
			
			$("input[name^=amount]").sum("keyup", "#total_amount");
			//$("input[name^=amount]").sum("keyup", "#total_net_amount");
			
			// automatically update the "#totalAvg" field every time
			// the values are changes via the keyup event

			// this calculates the sum for some text nodes
			$("#idTotalTextSum").click(
				function (){
					// get the sum of the elements
					var sum = $(".textSum").sum();

					// update the total
					$("#totalTextSum").text("$" + sum.toString());
				}
			);

			// this calculates the average for some text nodes

		}
		
	);
	
	function recalc(){
		$("[id^=total_net_amount]").calc(
		// the equation to use for the calculation
			//"(discount * cost)/100",
			// define the variables used in the equation, these can be a jQuery object
			{
				//discount: $("input[name^=discount]"),
				cost: $("input[name^=total_amount]")
			},
			// define the formatting callback, the results of the calculation are passed to this function
			function (s){
				// return the number as a dollar amount
				return "$" + s.toFixed(2);
			},

			// the equation to use for the calculation

			// define the formatting callback, the results of the calculation are passed to this function

			// define the finish callback, this runs after the calculation has been complete
			function ($this){
				// sum the total of the $("[id^=total_item]") selector
				var sum = $this.sum();
				
				$("#total_net_amount").text(
					// round the results to 2 digits
					"$" + sum.toFixed(2)
				);
				
			}
		);
	}
	</script>
	<script type="text/javascript" src="http://sdsajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	';	
		$company_id	= $_POST['id'];
		
		//$city_id	= $_POST['city_id'];
		//$hotel_id	= $_POST['hotel_id'];
		
		$schedules=$this->Schedule->GetSchedulesByCompanyId($company_id);
		$ivs=$this->Invoice->GetInvoiceByCompanyId($company_id,1);
		$array_t=array();
		foreach($ivs as $item)
		{
			$array_v=json_decode($item->schedules_amounts,true);
			if(is_array($array_v)){
				if(count($array_v)){
					foreach($array_v as $key=>$value)
					{
						array_push($array_t,$key);
						}
			
				}
			}
		}
		//var_dump($schedules);
		$array_schedule['']='Select City';
		$js=' class="input_control"';
		$total_amount_v=0;
		$discount_v='';
		$total_net_amount_v=0;
		$total_amount = array('name'=>'total_amount','id'=>'total_amount','value' =>$total_amount_v,'readonly'=>'readonly');
		$discount = array('name'=>'discount','id'=>'discount','value'=>$discount_v, 'class'=>'validate[required]');
		$total_net_amount = array('name'=>'total_net_amount','id'=>'total_net_amount','value'=>$total_net_amount_v,'readonly'	=> 'readonly');		
		foreach($schedules as $schedule)
			{
				if(!in_array($schedule->id,$array_t)){
				$code=array('name'=>'code'.$schedule->id,'disabled'=>'disabled');
				$amount=array('name'=>'amount'.$schedule->id,'disabled'=>'disabled','value'=>0);
			echo "<div class='row-form clearfix'>
					<div class='span1'>".form_checkbox('schedules[]', $schedule->id,FALSE,$js)."</div>
					<div class='span7'>".$schedule->course.' ( '.$schedule->start_date.' - '.$schedule->end_date.' ) '.$schedule->city.' - '.$schedule->country."</div>
					<div class='span1'>Code </div>
					<div class='span1'>".form_input($code)."</div>
					<div class='span1'>Amount </div>
					<div class='span1'>".form_input($amount)."</div>
				</div>";	
				}
			}
			echo "<script type='text/javascript'>
    $(document).ready(function(){
		
        $('.input_control').attr('checked', false);
        $('.input_control').click(function(){
            if($('input[name=amount'+ $(this).attr('value')+']').attr('disabled') == false){
                $('input[name=amount'+ $(this).attr('value')+']').attr('disabled', true);
				$('input[name=code'+ $(this).attr('value')+']').attr('disabled', true);
            }else{
                $('input[name=amount'+ $(this).attr('value')+']').attr('disabled', false);
				$('input[name=code'+ $(this).attr('value')+']').attr('disabled', false);   
            }
        });
    });
</script>
<div class='row-form clearfix'>
	<div class='span3'>Total Amount</div>
	<div class='span3'>".form_input($total_amount)."<font color='#FF0000'></font></div>
</div>
<div class='row-form clearfix'>
	<div class='span3'>Discount (%)</div>
	<div class='span3'>".form_input($discount)."<font color='#FF0000'>if not discount please enter a 0</font></div>
</div>  
<div class='row-form clearfix'>
	<div class='span3'>Net Total Amount</div>
	<div class='span3'>".form_input($total_net_amount)."</div>
</div>  
";
		}

	public function _GetListSchedules()
	{
		
	echo '<script language="javascript">
	var bIsFirebugReady = (!!window.console && !!window.console.log);
 $(document).ready(function() {
	// alert();
 $("#discount").on("keyup keypress blur change load", function() {
 var dis = $("#discount");//reading the discount percentage
// var disamt = $("#txtDisAmt");//reading the discount amount
 var amt = $("#total_amount");//Reading Amount
 var net = $("#total_net_amount");// Reading Net amount
 var net1;
 if (amt.val() > 0) {
 if (dis.val() > 0) {
 	net1 = amt.val() * (100 - dis.val()) ; //net amount calculation
	net=net1/100 + "";
// disamt = amt.val() - net;//Discount amount calculation
 $("#total_net_amount").attr("value", net); //assign net amount to html control
// $("#txtDisAmt").attr("value", disamt); //assign Discount amount to html control
 } else {
 amt = amt.val() + "";
 $("#total_net_amount").attr("value", amt);
 }
 }
 });
 });
 	
	$(document).ready(
		function (){
			// update the plug-in version
			$("#idPluginVersion").text($.Calculation.version);
			
			$("input[name^=amount]").sum("keyup", "#total_amount");
			//$("input[name^=amount]").sum("keyup", "#total_net_amount");
			
			// automatically update the "#totalAvg" field every time
			// the values are changes via the keyup event

			// this calculates the sum for some text nodes
			$("#idTotalTextSum").click(
				function (){
					// get the sum of the elements
					var sum = $(".textSum").sum();

					// update the total
					$("#totalTextSum").text("$" + sum.toString());
				}
			);

			// this calculates the average for some text nodes

		}
		
	);
	
	function recalc(){
		$("[id^=total_net_amount]").calc(
		// the equation to use for the calculation
			//"(discount * cost)/100",
			// define the variables used in the equation, these can be a jQuery object
			{
				//discount: $("input[name^=discount]"),
				cost: $("input[name^=total_amount]")
			},
			// define the formatting callback, the results of the calculation are passed to this function
			function (s){
				// return the number as a dollar amount
				return "$" + s.toFixed(2);
			},

			// the equation to use for the calculation

			// define the formatting callback, the results of the calculation are passed to this function

			// define the finish callback, this runs after the calculation has been complete
			function ($this){
				// sum the total of the $("[id^=total_item]") selector
				var sum = $this.sum();
				
				$("#total_net_amount").text(
					// round the results to 2 digits
					"$" + sum.toFixed(2)
				);
				
			}
		);
	}
	</script>
	<script type="text/javascript" src="http://sdsajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	';	
		$company_id	= $_POST['id'];
		
		//$city_id	= $_POST['city_id'];
		//$hotel_id	= $_POST['hotel_id'];
		
		$schedules=$this->Schedule->GetSchedulesByCompanyId($company_id);
		$ivs=$this->Invoice->GetInvoiceByCompanyId($company_id,1);
		$array_t=array();
		foreach($ivs as $item)
		{
			$array_v=json_decode($item->schedules_amounts,true);
			if(is_array($array_v)){
				if(count($array_v)){
					foreach($array_v as $key=>$value)
					{
						array_push($array_t,$key);
						}
			
				}
			}
		}
		//var_dump($schedules);
		$array_schedule['']='Select City';
		$js=' class="input_control"';
		$total_amount_v=0;
		$discount_v='';
		$total_net_amount_v=0;
		$total_amount = array('name'=>'total_amount','id'=>'total_amount','value' =>$total_amount_v,'readonly'=>'readonly');
		$discount = array('name'=>'discount','id'=>'discount','value'=>$discount_v, 'class'=>'validate[required]');
		$total_net_amount = array('name'=>'total_net_amount','id'=>'total_net_amount','value'=>$total_net_amount_v,'readonly'	=> 'readonly');		
		foreach($schedules as $schedule)
			{
				if(!in_array($schedule->id,$array_t)){
				$code=array('name'=>'code'.$schedule->id,'disabled'=>'disabled');
				$amount=array('name'=>'amount'.$schedule->id,'disabled'=>'disabled','value'=>0);
			echo "<div class='row-form clearfix'>
					<div class='span1'>".form_checkbox('schedules[]', $schedule->id,FALSE,$js)."</div>
					<div class='span7'>".$schedule->course.' ( '.$schedule->start_date.' - '.$schedule->end_date.' ) '.$schedule->city.' - '.$schedule->country."</div>
					<div class='span1'>Code </div>
					<div class='span1'>".form_input($code)."</div>
					<div class='span1'>Amount </div>
					<div class='span1'>".form_input($amount)."</div>
				</div>";	
				}
			}
			echo "<script type='text/javascript'>
    $(document).ready(function(){
		
        $('.input_control').attr('checked', false);
        $('.input_control').click(function(){
            if($('input[name=amount'+ $(this).attr('value')+']').attr('disabled') == false){
                $('input[name=amount'+ $(this).attr('value')+']').attr('disabled', true);
				$('input[name=code'+ $(this).attr('value')+']').attr('disabled', true);
            }else{
                $('input[name=amount'+ $(this).attr('value')+']').attr('disabled', false);
				$('input[name=code'+ $(this).attr('value')+']').attr('disabled', false);   
            }
        });
    });
</script>
<div class='row-form clearfix'>
	<div class='span3'>Total Amount</div>
	<div class='span3'>".form_input($total_amount)."<font color='#FF0000'></font></div>
</div>
<div class='row-form clearfix'>
	<div class='span3'>Discount (%)</div>
	<div class='span3'>".form_input($discount)."<font color='#FF0000'>if not discount please enter a 0</font></div>
</div>  
<div class='row-form clearfix'>
	<div class='span3'>Net Total Amount</div>
	<div class='span3'>".form_input($total_net_amount)."</div>
</div>  
";
		}

	public function GetListTrainees()
	{
		
	echo '<script language="javascript">
	var bIsFirebugReady = (!!window.console && !!window.console.log);
 $(document).ready(function() {
	// alert();
 $("#discount").on("keyup keypress blur change load", function() {
 var dis = $("#discount");//reading the discount percentage
// var disamt = $("#txtDisAmt");//reading the discount amount
 var amt = $("#total_amount");//Reading Amount
 var net = $("#total_net_amount");// Reading Net amount
 var net1;
 if (amt.val() > 0) {
 if (dis.val() > 0) {
 	net1 = amt.val() * (100 - dis.val()) ; //net amount calculation
	net=net1/100 + "";
// disamt = amt.val() - net;//Discount amount calculation
 $("#total_net_amount").attr("value", net); //assign net amount to html control
// $("#txtDisAmt").attr("value", disamt); //assign Discount amount to html control
 } else {
 amt = amt.val() + "";
 $("#total_net_amount").attr("value", amt);
 }
 }
 });
 });
 	
	$(document).ready(
		function (){
			// update the plug-in version
			$("#idPluginVersion").text($.Calculation.version);
			
			$("input[name^=amount]").sum("keyup", "#total_amount");
			//$("input[name^=amount]").sum("keyup", "#total_net_amount");
			
			// automatically update the "#totalAvg" field every time
			// the values are changes via the keyup event

			// this calculates the sum for some text nodes
			$("#idTotalTextSum").click(
				function (){
					// get the sum of the elements
					var sum = $(".textSum").sum();

					// update the total
					$("#totalTextSum").text("$" + sum.toString());
				}
			);

			// this calculates the average for some text nodes

		}
		
	);
	
	function recalc(){
		$("[id^=total_net_amount]").calc(
		// the equation to use for the calculation
			//"(discount * cost)/100",
			// define the variables used in the equation, these can be a jQuery object
			{
				//discount: $("input[name^=discount]"),
				cost: $("input[name^=total_amount]")
			},
			// define the formatting callback, the results of the calculation are passed to this function
			function (s){
				// return the number as a dollar amount
				return "$" + s.toFixed(2);
			},

			// the equation to use for the calculation

			// define the formatting callback, the results of the calculation are passed to this function

			// define the finish callback, this runs after the calculation has been complete
			function ($this){
				// sum the total of the $("[id^=total_item]") selector
				var sum = $this.sum();
				
				$("#total_net_amount").text(
					// round the results to 2 digits
					"$" + sum.toFixed(2)
				);
				
			}
		);
	}
	</script>
	<script type="text/javascript" src="http://sdsajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	';	
		$company_id	= $_POST['id'];
		$schedule_id	= $_POST['schedule_id'];
		//$city_id	= $_POST['city_id'];
		//$hotel_id	= $_POST['hotel_id'];
	//	echo $schedule_id;
		$trainees=$this->Registration->GetRegistrationsInfoByCAS($company_id,$schedule_id);
	//	var_dump($trainees);
		$ivs=$this->Invoice->GetInvoiceByCAS($company_id,$schedule_id);
		$array_t=array();
		foreach($ivs as $item)
		{
			$array_v=json_decode($item->registrations_details,true);
			if(is_array($array_v)){
				if(count($array_v)){
					foreach($array_v as $key=>$value)
					{
						array_push($array_t,$key);
						}
			
				}
			}
		}
		//var_dump($schedules);
		$array_schedule['']='Select City';
		$js=' class="input_t"';
		$total_amount_v=0;
		$discount_v='';
		$total_net_amount_v=0;
		$total_amount = array('name'=>'total_amount','id'=>'total_amount','value' =>$total_amount_v,'readonly'=>'readonly');
		$discount = array('name'=>'discount','id'=>'discount','value'=>$discount_v, 'class'=>'validate[required]');
		$total_net_amount = array('name'=>'total_net_amount','id'=>'total_net_amount','value'=>$total_net_amount_v,'readonly'	=> 'readonly');		
		foreach($trainees as $trainee)
			{
				if(!in_array($trainee->id,$array_t)){
				$code=array('name'=>'code'.$trainee->id);
				$amount=array('name'=>'amount'.$trainee->id,'value'=>'0');
			echo "<div class='row-form clearfix'>
					<div class='span1'>".form_checkbox('trainees[]', $trainee->id,FALSE,$js)."</div>
					<div class='span7'>".$trainee->fullname.' ( '.$trainee->company." ) </div>
					<div class='span1'>Code </div>
					<div class='span1'>".form_input($code)."</div>
					<div class='span1'>Amount </div>
					<div class='span1'>".form_input($amount)."</div>
				</div>";	
				}
			}
			echo "<script type='text/javascript'>
    $(document).ready(function(){
		
        $('.input_t').attr('checked', true);
        $('.input_t').click(function(){
            if($('input[name=amount'+ $(this).attr('value')+']').attr('disabled') == true){
				
                $('input[name=amount'+ $(this).attr('value')+']').attr('disabled', false);
				$('input[name=code'+ $(this).attr('value')+']').attr('disabled', false);
            } if($('input[name=amount'+ $(this).attr('value')+']').attr('disabled') == false){
				//alert($('input[name=amount'+ $(this).attr('value')+']').attr('value'));
                $('input[name=amount'+ $(this).attr('value')+']').attr('disabled', true);
				$('input[name=code'+ $(this).attr('value')+']').attr('disabled', true);   
            }
        });
    });
</script>
<div class='row-form clearfix'>
	<div class='span3'>Total Amount</div>
	<div class='span3'>".form_input($total_amount)."<font color='#FF0000'></font></div>
</div>
<div class='row-form clearfix'>
	<div class='span3'>Discount (%)</div>
	<div class='span3'>".form_input($discount)."<font color='#FF0000'>if not discount please enter a 0</font></div>
</div>  
<div class='row-form clearfix'>
	<div class='span3'>Net Total Amount</div>
	<div class='span3'>".form_input($total_net_amount)."</div>
</div>  
";
		}
 
 function number_pad($number,$n) {
	return str_pad((int) $number,$n,"0",STR_PAD_LEFT);
	}
	public function index()
	{
	$get = $this->uri->uri_to_assoc();
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Dashboard','dashboard');
		$this->breadcrumb->add_crumb('Public Invoices');
		if(isset($get['status'])){
			$status=$get['status'];
			$status_t='( '.ucfirst($status).' )';
			$this->breadcrumb->add_crumb($status);
			}
		else{
			$status='';
			$status_t='';
			}
		if($get['status']=='pending')
		$r=31;
		if($get['status']=='paid')
		$r=29;	
		$p_delete=$this->ag_auth->check_privilege($this->session->userdata('privileges'),12,$r,'delete');
		$p_edit=$this->ag_auth->check_privilege($this->session->userdata('privileges'),12,$r,'edit');
		$p_add=$this->ag_auth->check_privilege($this->session->userdata('privileges'),12,$r,'add');
		$this->data['p_delete']=$p_delete;
		$this->data['p_edit']=$p_edit;
		$this->data['p_add']=$p_add;			
		$this->data['pending_invoices']=$this->Invoice->GetNumberOfInvoice(2,'pending');	
		$this->data['paid_invoices']=$this->Invoice->GetNumberOfInvoice(2,'paid');	
		$this->data['canceled_invoices']=$this->Invoice->GetNumberOfInvoice(2,'canceled');	
		$this->data['msg']=$this->session->userdata('admin_message');
		$this->session->unset_userdata('admin_message');		
		$this->data['query']=$this->Invoice->GetInvoices(2,$status);	
		$this->data['subtitle'] = ' '.$status_t.' - Public Invoices';
		$this->data['title'] = "Inma Kingdom Training System - Invoices List";
		$this->template->load('_template', 'public_invoices', $this->data);		
	}
	public function create_biding()
	{
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Invoices','invoices');
			$this->breadcrumb->add_crumb('Biding Invoices','invoices/biding_invoices');
			$this->breadcrumb->add_crumb('Create Invoice');		
			$this->form_validation->set_rules('invoice_number', 'invoice_number', 'trim');
			$this->form_validation->set_rules('company_id', 'company_id', 'trim');
			$this->form_validation->set_rules('company_details', 'company_details', 'trim');
			$this->form_validation->set_rules('vendor_name', 'vendor_name', 'trim');
			$this->form_validation->set_rules('vendor_name_ar', 'vendor_name_ar', 'trim');
			$this->form_validation->set_rules('vendor_number', 'vendor_number', 'trim');
			$this->form_validation->set_rules('contract_name', 'contract_name', 'trim');
			$this->form_validation->set_rules('contract_name_ar', 'contract_name_ar', 'trim');
			$this->form_validation->set_rules('contract_number', 'contract_number', 'trim');
			$this->form_validation->set_rules('schedules_details', 'schedules_details', 'trim');
			$this->form_validation->set_rules('total_amount', 'total_amount', 'trim');
			$this->form_validation->set_rules('discount', 'discount', 'trim');
			$this->form_validation->set_rules('total_net_amount', 'total_net_amount', 'trim');
			$this->form_validation->set_rules('amount_in_word', 'amount_in_word', 'trim');
			$this->form_validation->set_rules('amount_in_word_ar', 'amount_in_word_ar', 'trim');
			$this->form_validation->set_rules('bank_id', 'bank_id', 'trim');
			$this->form_validation->set_rules('status', 'status', 'trim');
			$this->form_validation->set_rules('hijri_date', 'hijri_date', 'trim');
			
			if ($this->form_validation->run()) {
				
				$schedule_array=array();
				$code_array=array();
				$amount_array=array();
				$schedules=$this->input->post('schedules');
				foreach($schedules as $value)
				{
					$schedule=$this->Schedule->GetScheduleId($value);
					$schedule_array[$value]=$schedule;
					$code_array[$value]=$this->input->post('code'.$value);
					$amount_array[$value]=$this->input->post('amount'.$value);
					}
							
				$companies=$this->Client->GetClientById($this->form_validation->set_value('company_id'));		
				$company_details=json_encode($companies);
				$schedules_details=json_encode($schedule_array);
				$schedules_code=json_encode($code_array);
				$schedules_amount=json_encode($amount_array);
				$invoice_number=$this->input->post('invoice_number_year').$this->input->post('invoice_number');
			//	var_dump($amount_array);
			//	die;
				$data = array(
				'invoice_number' => $invoice_number,
				'company_id' => $this->form_validation->set_value('company_id'),
				'company_details' => $company_details,
				'vendor_name' => $this->form_validation->set_value('vendor_name'),
				'vendor_name_ar' => $this->form_validation->set_value('vendor_name_ar'),
				'vendor_number' => $this->form_validation->set_value('vendor_number'),
				'contract_name' => $this->form_validation->set_value('contract_name'),
				'contract_name_ar' => $this->form_validation->set_value('contract_name_ar'),
				'contract_number' => $this->form_validation->set_value('contract_number'),
				'schedules_details' => $schedules_details,
				'schedules_code' => $schedules_code,
				'schedules_amounts' => $schedules_amount,
				'total_amount' => $this->form_validation->set_value('total_amount'),
				'discount' => $this->form_validation->set_value('discount'),
				'total_net_amount' => $this->form_validation->set_value('total_net_amount'),
				'amount_in_word' => $this->form_validation->set_value('amount_in_word'),
				'amount_in_word_ar' => $this->form_validation->set_value('amount_in_word_ar'),
				'bank_id' => $this->form_validation->set_value('bank_id'),
				'status' => $this->form_validation->set_value('status'),
				'category_id' => 1,
				'hijri_date' => $this->form_validation->set_value('hijri_date'),
				'create_time' =>  date('Y-m-d H:i:s'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);

				if($id=$this->General->save('training_invoices',$data))
				{
				/*	if($this->input->post('category_id')==2){
						$this->db->set('no_of_participants', 'no_of_participants+1', FALSE);
						$this->db->where('id', $this->form_validation->set_value('schedule_id'));
						$this->db->update('training_schedules');
					}
					*/
					$this->session->set_userdata(array('admin_message'=>'Invoice Created Successfully'));	
					redirect('invoices/biding_view/id/'.$id);
				}
				else
				{
					$this->session->set_userdata(array('admin_message'=>'Error'));	
					redirect('invoices/create_biding');					
				}
				
			 }
			 	$invoice_nbrs=$this->Invoice->GetNextInvoiceID();
				//echo $invoice_nbrs['invoice_number'];
				if($invoice_nbrs['invoice_number']!=''){
					$invoice_item=$invoice_nbrs['invoice_number'];
					$x=substr($invoice_item,4,strlen($invoice_item)-4);
					//echo (int)$x.'<br>';
					$x++;

				//	echo $x.'<br>';
					if(strlen($x)<5){					
					$x=$this->number_pad($x,(5-strlen($x)));
					}

				}
				else{
					$x=1;
					$x=$this->number_pad($x,(5-strlen($x)));
					}
				$invoice_item=$invoice_nbrs['invoice_number'];	
					$invoice_item++;
					$invoice_item=$this->number_pad($invoice_item,(5-strlen($invoice_item)));
				$this->data['schedules']=$this->Schedule->GetSchedulesByCompanyId(2);
				$this->data['invoice_id'] = '';
				$this->data['invoice_number'] = $x;
				$this->data['invoice_number_year'] = date('Y');
				$this->data['hijri_date'] = $this->hijridate->hijriCal();
				$this->data['company_id'] = '';
				$this->data['vendor_name'] = '';
				$this->data['vendor_name_ar'] = '';
				$this->data['vendor_number'] = '';
				$this->data['contract_name'] = '';
				$this->data['contract_name_ar'] = '';
				$this->data['contract_number'] = '';
				$this->data['schedules_details'] = '';
				$this->data['amount'] = '';
				$this->data['total_amount'] = '';
				$this->data['discount'] = '';
				$this->data['total_net_amount'] = '';
				$this->data['amount_in_word'] = '';
				$this->data['amount_in_word_ar'] = '';
				$this->data['bank_id'] = '';
				$this->data['status'] = '';
								
				//$this->data['categories']   =$this->Schedule->GetCategories();
				$this->data['majors']   =$this->Course->GetAllMajors();
				$this->data['courses']   =$this->Course->GetCourses();
			//	$this->data['schedules']=array();
				$this->data['cities_data']=array();
				$this->data['hotels_data']=array();
				$this->data['instructors_data']=array();				
				//$this->data['countries']   =$this->Country->GetCountries();
				//$this->data['providers']   =$this->Provider->GetProviders();
				$this->data['clients']   =$this->Client->GetAllClients();
				//$this->data['genders']   =$this->Registration->GetGenders();
				//$this->data['audiences']   =$this->Registration->GetAudiences();
				//$this->data['experiences']   =$this->Registration->GetExperiences();
				//$this->data['purposes']   =$this->Registration->GetPurposes();
				
				$this->data['banks']   =$this->Bank->GetBanks();
				$this->data['subtitle'] = 'Create Biding Invoice';
				$this->data['title'] = "Inma Kingdom training system - Create Biding Invoice";
				$this->template->load('_template', 'invoice_biding_form', $this->data);	
	}
	public function edit_biding()
	{
			$get = $this->uri->uri_to_assoc();
			$row=$this->Invoice->GetInvoiceById($get['id']);
			$schedules=$this->Schedule->GetSchedulesByCompanyId($row['company_id']);
			$ivs=$this->Invoice->GetInvoiceByCompanyId($row['company_id'],1);
			$array_t=array();
			foreach($ivs as $item)
			{
				$array_v=json_decode($item->schedules_amounts,true);
				if(is_array($array_v)){
					if(count($array_v)){
						foreach($array_v as $key=>$value)
						{
							array_push($array_t,$key);
							}
				
					}
				}
			}
			
								
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Invoices','invoices');
			$this->breadcrumb->add_crumb('Biding Invoices','invoices/biding_invoices');
			$this->breadcrumb->add_crumb('Edit Invoice');		
			$this->form_validation->set_rules('invoice_number', 'invoice_number', 'trim');
			$this->form_validation->set_rules('company_id', 'company_id', 'trim');
			$this->form_validation->set_rules('company_details', 'company_details', 'trim');
			$this->form_validation->set_rules('vendor_name', 'vendor_name', 'trim');
			$this->form_validation->set_rules('vendor_name_ar', 'vendor_name_ar', 'trim');
			$this->form_validation->set_rules('vendor_number', 'vendor_number', 'trim');
			$this->form_validation->set_rules('contract_name', 'contract_name', 'trim');
			$this->form_validation->set_rules('contract_name_ar', 'contract_name_ar', 'trim');
			$this->form_validation->set_rules('contract_number', 'contract_number', 'trim');
			$this->form_validation->set_rules('schedules_details', 'schedules_details', 'trim');
			$this->form_validation->set_rules('total_amount', 'total_amount', 'trim');
			$this->form_validation->set_rules('discount', 'discount', 'trim');
			$this->form_validation->set_rules('total_net_amount', 'total_net_amount', 'trim');
			$this->form_validation->set_rules('amount_in_word', 'amount_in_word', 'trim');
			$this->form_validation->set_rules('amount_in_word_ar', 'amount_in_word_ar', 'trim');
			$this->form_validation->set_rules('bank_id', 'bank_id', 'trim');
			$this->form_validation->set_rules('status', 'status', 'trim');
			$this->form_validation->set_rules('hijri_date', 'hijri_date', 'trim');
			
			if ($this->form_validation->run()) {
				
				$schedule_array=array();
				$code_array=array();
				$amount_array=array();
				$schedules=$this->input->post('schedules');
				foreach($schedules as $value)
				{
					$schedule=$this->Schedule->GetScheduleId($value);
					$schedule_array[$value]=$schedule;
					$code_array[$value]=$this->input->post('code'.$value);
					$amount_array[$value]=$this->input->post('amount'.$value);
					}
							
				$companies=$this->Client->GetClientById($this->form_validation->set_value('company_id'));		
				$company_details=json_encode($companies);
				$schedules_details=json_encode($schedule_array);
				$schedules_code=json_encode($code_array);
				$schedules_amount=json_encode($amount_array);
				$invoice_number=$this->input->post('invoice_number_year').$this->input->post('invoice_number');
			//	var_dump($amount_array);
			//	die;
				$data = array(
				'invoice_number' => $invoice_number,
				'company_id' => $this->form_validation->set_value('company_id'),
				'company_details' => $company_details,
				'vendor_name' => $this->form_validation->set_value('vendor_name'),
				'vendor_name_ar' => $this->form_validation->set_value('vendor_name_ar'),
				'vendor_number' => $this->form_validation->set_value('vendor_number'),
				'contract_name' => $this->form_validation->set_value('contract_name'),
				'contract_name_ar' => $this->form_validation->set_value('contract_name_ar'),
				'contract_number' => $this->form_validation->set_value('contract_number'),
				'schedules_details' => $schedules_details,
				'schedules_code' => $schedules_code,
				'schedules_amounts' => $schedules_amount,
				'total_amount' => $this->form_validation->set_value('total_amount'),
				'discount' => $this->form_validation->set_value('discount'),
				'total_net_amount' => $this->form_validation->set_value('total_net_amount'),
				'amount_in_word' => $this->form_validation->set_value('amount_in_word'),
				'amount_in_word_ar' => $this->form_validation->set_value('amount_in_word_ar'),
				'bank_id' => $this->form_validation->set_value('bank_id'),
				'status' => $this->form_validation->set_value('status'),
				'category_id' => 1,
				'hijri_date' => $this->form_validation->set_value('hijri_date'),
				'create_time' =>  date('Y-m-d H:i:s'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);

				if($id=$this->General->save('training_invoices',$data))
				{
				/*	if($this->input->post('category_id')==2){
						$this->db->set('no_of_participants', 'no_of_participants+1', FALSE);
						$this->db->where('id', $this->form_validation->set_value('schedule_id'));
						$this->db->update('training_schedules');
					}
					*/
					$this->session->set_userdata(array('admin_message'=>'Invoice Created Successfully'));	
					redirect('invoices/biding_view/id/'.$id);
				}
				else
				{
					$this->session->set_userdata(array('admin_message'=>'Error'));	
					redirect('invoices/create_biding');					
				}
				
			 }
			 	$invoice_nbrs=$this->Invoice->GetNextInvoiceID();
				//echo $invoice_nbrs['invoice_number'];
				if($invoice_nbrs['invoice_number']!=''){
					$invoice_item=$invoice_nbrs['invoice_number'];
					$x=substr($invoice_item,4,strlen($invoice_item)-4);
					//echo (int)$x.'<br>';
					$x++;

				//	echo $x.'<br>';
					if(strlen($x)<5){					
					$x=$this->number_pad($x,(5-strlen($x)));
					}

				}
				else{
					$x=1;
					$x=$this->number_pad($x,(5-strlen($x)));
					}
				$invoice_item=$invoice_nbrs['invoice_number'];	
					$invoice_item++;
					$invoice_item=$this->number_pad($invoice_item,(5-strlen($invoice_item)));
				$year=substr($row['invoice_number'],0,4);
				//$regidtrations_details=$row['registrations_details'];
				$regidtrations_details=json_decode($row['registrations_details'],true);	
				$schedules_amounts=json_decode($row['schedules_amounts'],true);	
				$this->data['schedules']=$this->Schedule->GetSchedulesByCompanyId($row['company_id']);
				$this->data['invoice_id'] = $row['id'];
				$this->data['invoice_number'] = substr($row['invoice_number'],4,$row['invoice_number']);
				$this->data['invoice_number_year'] = $year;
				$this->data['hijri_date'] = $row['hijri_date'];
				$this->data['company_id'] = $row['company_id'];
				$this->data['vendor_name'] = $row['vendor_name'];
				$this->data['vendor_name_ar'] = $row['vendor_name_ar'];
				$this->data['vendor_number'] = $row['vendor_number'];
				$this->data['contract_name'] = $row['contract_name'];
				$this->data['contract_name_ar'] = $row['contract_name_ar'];
				$this->data['contract_number'] = $row['contract_number'];
				$this->data['schedules_details'] = $row['schedules_details'];
				$this->data['regidtrations_details'] = $regidtrations_details;
				$this->data['schedules_amounts'] = $schedules_amounts;
				//$this->data['amount'] = $row['total_amount'];
				$this->data['total_amount_v'] = $row['total_amount'];
				$this->data['discount_v'] = $row['discount'];
				$this->data['total_net_amount_v'] = $row['total_net_amount'];
				$this->data['amount_in_word'] = $row['amount_in_word'];
				$this->data['amount_in_word_ar'] = $row['amount_in_word_ar'];
				$this->data['bank_id'] = $row['bank_id'];
				$this->data['status'] = $row['status'];
								
				//$this->data['categories']   =$this->Schedule->GetCategories();
				$this->data['majors']   =$this->Course->GetAllMajors();
				$this->data['courses']   =$this->Course->GetCourses();
			//	$this->data['schedules']=array();
				$this->data['cities_data']=array();
				$this->data['hotels_data']=array();
				$this->data['instructors_data']=array();				
				//$this->data['countries']   =$this->Country->GetCountries();
				//$this->data['providers']   =$this->Provider->GetProviders();
				$this->data['clients']   =$this->Client->GetAllClients();
				//$this->data['genders']   =$this->Registration->GetGenders();
				//$this->data['audiences']   =$this->Registration->GetAudiences();
				//$this->data['experiences']   =$this->Registration->GetExperiences();
				//$this->data['purposes']   =$this->Registration->GetPurposes();
				
				$this->data['banks']   =$this->Bank->GetBanks();
				$this->data['subtitle'] = 'Create Biding Invoice';
				$this->data['title'] = "Inma Kingdom training system - Create Biding Invoice";
				$this->template->load('_template', 'invoice_biding_edit', $this->data);	
	}


	public function create_public()
	{
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Invoices','invoices');
			$this->breadcrumb->add_crumb('Public Invoices','invoices/public_invoices');
			$this->breadcrumb->add_crumb('Create Invoice');		
			$this->form_validation->set_rules('invoice_number', 'invoice_number', 'trim');
			$this->form_validation->set_rules('company_id', 'company_id', 'trim');
			$this->form_validation->set_rules('company_details', 'company_details', 'trim');
			$this->form_validation->set_rules('vendor_name', 'vendor_name', 'trim');
			$this->form_validation->set_rules('vendor_name_ar', 'vendor_name_ar', 'trim');
			$this->form_validation->set_rules('vendor_number', 'vendor_number', 'trim');
			$this->form_validation->set_rules('contract_name', 'contract_name', 'trim');
			$this->form_validation->set_rules('contract_name_ar', 'contract_name_ar', 'trim');
			$this->form_validation->set_rules('contract_number', 'contract_number', 'trim');
			$this->form_validation->set_rules('schedules_details', 'schedules_details', 'trim');
			$this->form_validation->set_rules('total_amount', 'total_amount', 'trim');
			$this->form_validation->set_rules('discount', 'discount', 'trim');
			$this->form_validation->set_rules('total_net_amount', 'total_net_amount', 'trim');
			$this->form_validation->set_rules('amount_in_word', 'amount_in_word', 'trim');
			$this->form_validation->set_rules('amount_in_word_ar', 'amount_in_word_ar', 'trim');
			$this->form_validation->set_rules('bank_id', 'bank_id', 'trim');
			$this->form_validation->set_rules('status', 'status', 'trim');
			$this->form_validation->set_rules('hijri_date', 'hijri_date', 'trim');
			
			if ($this->form_validation->run()) {
				
				$schedule_array=array();
				$code_array=array();
				$amount_array=array();
			//	echo "<pre>";
			//	var_dump($_POST);
			//	echo "</pre>";
				$trainees=$this->input->post('trainees');
			//	die;
				foreach($trainees as $value)
				{
					$trainee=$this->Registration->GetRegisterInfoById($value);
					$trainee_array[$value]=$trainee;
					$code_array[$value]=$this->input->post('code'.$value);
					$amount_array[$value]=$this->input->post('amount'.$value);
					}
							
				$companies=$this->Client->GetClientById($this->input->post('company_id'));
				$schedules=$this->Schedule->GetScheduleId($this->input->post('schedule_id'));		
				$company_details=json_encode($companies);
				$schedules_details=json_encode($schedules);
				$registrations_details=json_encode($trainee_array);
				$schedules_code=json_encode($code_array);
				$schedules_amount=json_encode($amount_array);
				$invoice_number=$this->input->post('invoice_number_year').$this->input->post('invoice_number');
			//	var_dump($amount_array);
			//	die;
				$data = array(
				'invoice_number' => $invoice_number,
				'company_id' => $this->input->post('company_id'),
				'company_details' => $company_details,
				'vendor_name' => $this->form_validation->set_value('vendor_name'),
				'vendor_name_ar' => $this->form_validation->set_value('vendor_name_ar'),
				'vendor_number' => $this->form_validation->set_value('vendor_number'),
				'contract_name' => $this->form_validation->set_value('contract_name'),
				'contract_name_ar' => $this->form_validation->set_value('contract_name_ar'),
				'contract_number' => $this->form_validation->set_value('contract_number'),
				'contract_number' => $this->form_validation->set_value('contract_number'),
				'schedule_id' => $this->input->post('schedule_id'),
				'schedules_details' => $schedules_details,
				'schedules_code' => $schedules_code,
				'schedules_amounts' => $schedules_amount,
				'registrations_details' => $registrations_details,
				'total_amount' => $this->form_validation->set_value('total_amount'),
				'discount' => $this->form_validation->set_value('discount'),
				'total_net_amount' => $this->form_validation->set_value('total_net_amount'),
				'amount_in_word' => $this->form_validation->set_value('amount_in_word'),
				'amount_in_word_ar' => $this->form_validation->set_value('amount_in_word_ar'),
				'bank_id' => $this->form_validation->set_value('bank_id'),
				'status' => $this->form_validation->set_value('status'),
				'category_id' => 2,
				'hijri_date' => $this->form_validation->set_value('hijri_date'),
				'create_time' =>  date('Y-m-d H:i:s'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);

				if($id=$this->General->save('training_invoices',$data))
				{
				/*	if($this->input->post('category_id')==2){
						$this->db->set('no_of_participants', 'no_of_participants+1', FALSE);
						$this->db->where('id', $this->form_validation->set_value('schedule_id'));
						$this->db->update('training_schedules');
					}
					*/
					$this->session->set_userdata(array('admin_message'=>'Invoice Created Successfully'));	
					redirect('invoices/public_view/id/'.$id);
				}
				else
				{
					$this->session->set_userdata(array('admin_message'=>'Error'));	
					redirect('invoices/create_public');					
				}
				
			 }
			 	$invoice_nbrs=$this->Invoice->GetNextInvoiceID();
				//echo $invoice_nbrs['invoice_number'];
				if($invoice_nbrs['invoice_number']!=''){
					$invoice_item=$invoice_nbrs['invoice_number'];
					$x=substr($invoice_item,4,strlen($invoice_item)-4);
					//echo (int)$x.'<br>';
					$x++;

				//	echo $x.'<br>';
					if(strlen($x)<5){					
					$x=$this->number_pad($x,(5-strlen($x)));
					}

				}
				else{
					$x=1;
					$x=$this->number_pad($x,(5-strlen($x)));
					}
				$invoice_item=$invoice_nbrs['invoice_number'];	
					$invoice_item++;
					$invoice_item=$this->number_pad($invoice_item,(5-strlen($invoice_item)));
				$this->data['schedules']=$this->Schedule->GetSchedulesByCompanyId(2);
				$this->data['invoice_id'] = '';
				$this->data['invoice_number'] = $x;
				$this->data['invoice_number_year'] = date('Y');
				$this->data['hijri_date'] = $this->hijridate->hijriCal();
				$this->data['company_id'] = '';
				$this->data['schedule_id'] = '';
				$this->data['vendor_name'] = '';
				$this->data['vendor_name_ar'] = '';
				$this->data['vendor_number'] = '';
				$this->data['contract_name'] = '';
				$this->data['contract_name_ar'] = '';
				$this->data['contract_number'] = '';
				$this->data['schedules_details'] = '';
				$this->data['amount'] = '';
				$this->data['total_amount'] = '';
				$this->data['discount'] = '';
				$this->data['total_net_amount'] = '';
				$this->data['amount_in_word'] = '';
				$this->data['amount_in_word_ar'] = '';
				$this->data['bank_id'] = '';
				$this->data['status'] = '';
								
				//$this->data['categories']   =$this->Schedule->GetCategories();
				$this->data['majors']   =$this->Course->GetAllMajors();
				$this->data['courses']   =$this->Course->GetCourses();
			//	$this->data['schedules']=array();
				$this->data['cities_data']=array();
				$this->data['hotels_data']=array();
				$this->data['instructors_data']=array();				
				//$this->data['countries']   =$this->Country->GetCountries();
				//$this->data['providers']   =$this->Provider->GetProviders();
				//$this->data['clients']   =$this->Client->GetAllClients();
				//$this->data['genders']   =$this->Registration->GetGenders();
				//$this->data['audiences']   =$this->Registration->GetAudiences();
				//$this->data['experiences']   =$this->Registration->GetExperiences();
				//$this->data['purposes']   =$this->Registration->GetPurposes();
				
				$this->data['banks']   =$this->Bank->GetBanks();
				$this->data['schedules']   =$this->Schedule->GetActiveSchedules(2);
				//var_dump($this->data['schedules']);
				$this->data['subtitle'] = 'Create Public Invoice';
				$this->data['title'] = "Inma Kingdom training system - Create Biding Invoice";
				$this->template->load('_template', 'invoice_public_form', $this->data);	
	}

	public function edit_public()
	{
			$get = $this->uri->uri_to_assoc();
			$row=$this->Invoice->GetInvoiceById($get['id']);		
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Invoices','invoices');
			$this->breadcrumb->add_crumb('Public Invoices','invoices/public_invoices');
			$this->breadcrumb->add_crumb('Create Invoice');		
			$this->form_validation->set_rules('invoice_number', 'invoice_number', 'trim');
			$this->form_validation->set_rules('company_id', 'company_id', 'trim');
			$this->form_validation->set_rules('company_details', 'company_details', 'trim');
			$this->form_validation->set_rules('vendor_name', 'vendor_name', 'trim');
			$this->form_validation->set_rules('vendor_name_ar', 'vendor_name_ar', 'trim');
			$this->form_validation->set_rules('vendor_number', 'vendor_number', 'trim');
			$this->form_validation->set_rules('contract_name', 'contract_name', 'trim');
			$this->form_validation->set_rules('contract_name_ar', 'contract_name_ar', 'trim');
			$this->form_validation->set_rules('contract_number', 'contract_number', 'trim');
			$this->form_validation->set_rules('schedules_details', 'schedules_details', 'trim');
			$this->form_validation->set_rules('total_amount', 'total_amount', 'trim');
			$this->form_validation->set_rules('discount', 'discount', 'trim');
			$this->form_validation->set_rules('total_net_amount', 'total_net_amount', 'trim');
			$this->form_validation->set_rules('amount_in_word', 'amount_in_word', 'trim');
			$this->form_validation->set_rules('amount_in_word_ar', 'amount_in_word_ar', 'trim');
			$this->form_validation->set_rules('bank_id', 'bank_id', 'trim');
			$this->form_validation->set_rules('status', 'status', 'trim');
			$this->form_validation->set_rules('hijri_date', 'hijri_date', 'trim');
			
			if ($this->form_validation->run()) {
				
				$schedule_array=array();
				$code_array=array();
				$amount_array=array();
			//	echo "<pre>";
			//	var_dump($_POST);
			//	echo "</pre>";
				$trainees=$this->input->post('trainees');
			//	die;
				foreach($trainees as $value)
				{
					$trainee=$this->Registration->GetRegisterInfoById($value);
					$trainee_array[$value]=$trainee;
					$code_array[$value]=$this->input->post('code'.$value);
					$amount_array[$value]=$this->input->post('amount'.$value);
					}
							
				$companies=$this->Client->GetClientById($this->input->post('company_id'));
				$schedules=$this->Schedule->GetScheduleId($this->input->post('schedule_id'));		
				$company_details=json_encode($companies);
				$schedules_details=json_encode($schedules);
				$registrations_details=json_encode($trainee_array);
				$schedules_code=json_encode($code_array);
				$schedules_amount=json_encode($amount_array);
				$invoice_number=$this->input->post('invoice_number_year').$this->input->post('invoice_number');
			//	var_dump($amount_array);
			//	die;
				$data = array(
				'invoice_number' => $invoice_number,
				'company_id' => $this->input->post('company_id'),
				'company_details' => $company_details,
				'vendor_name' => $this->form_validation->set_value('vendor_name'),
				'vendor_name_ar' => $this->form_validation->set_value('vendor_name_ar'),
				'vendor_number' => $this->form_validation->set_value('vendor_number'),
				'contract_name' => $this->form_validation->set_value('contract_name'),
				'contract_name_ar' => $this->form_validation->set_value('contract_name_ar'),
				'contract_number' => $this->form_validation->set_value('contract_number'),
				'contract_number' => $this->form_validation->set_value('contract_number'),
				'schedule_id' => $this->input->post('schedule_id'),
				'schedules_details' => $schedules_details,
				'schedules_code' => $schedules_code,
				'schedules_amounts' => $schedules_amount,
				'registrations_details' => $registrations_details,
				'total_amount' => $this->form_validation->set_value('total_amount'),
				'discount' => $this->form_validation->set_value('discount'),
				'total_net_amount' => $this->form_validation->set_value('total_net_amount'),
				'amount_in_word' => $this->form_validation->set_value('amount_in_word'),
				'amount_in_word_ar' => $this->form_validation->set_value('amount_in_word_ar'),
				'bank_id' => $this->form_validation->set_value('bank_id'),
				'status' => $this->form_validation->set_value('status'),
				'category_id' => 2,
				'hijri_date' => $this->form_validation->set_value('hijri_date'),
				'create_time' =>  date('Y-m-d H:i:s'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);

				if($id=$this->General->save('training_invoices',$data))
				{
				/*	if($this->input->post('category_id')==2){
						$this->db->set('no_of_participants', 'no_of_participants+1', FALSE);
						$this->db->where('id', $this->form_validation->set_value('schedule_id'));
						$this->db->update('training_schedules');
					}
					*/
					$this->session->set_userdata(array('admin_message'=>'Invoice Created Successfully'));	
					redirect('invoices/public_view/id/'.$id);
				}
				else
				{
					$this->session->set_userdata(array('admin_message'=>'Error'));	
					redirect('invoices/create_public');					
				}
				
			 }
			 	$invoice_nbrs=$this->Invoice->GetNextInvoiceID();
				//echo $invoice_nbrs['invoice_number'];
				if($invoice_nbrs['invoice_number']!=''){
					$invoice_item=$invoice_nbrs['invoice_number'];
					$x=substr($invoice_item,4,strlen($invoice_item)-4);
					//echo (int)$x.'<br>';
					$x++;

				//	echo $x.'<br>';
					if(strlen($x)<5){					
					$x=$this->number_pad($x,(5-strlen($x)));
					}

				}
				else{
					$x=1;
					$x=$this->number_pad($x,(5-strlen($x)));
					}
					
				$invoice_item=$invoice_nbrs['invoice_number'];	
					$invoice_item++;
					$invoice_item=$this->number_pad($invoice_item,(5-strlen($invoice_item)));
				//$this->data['schedules']=$this->Schedule->GetSchedulesByCompanyId(2);
				$this->data['clients']=$this->Invoice->GetClientByScheduleId($row['schedule_id']);
				//var_dump($this->data['clients']);
				$trainees=$this->Registration->GetRegistrationsInfoByCAS($row['company_id'],$row['schedule_id']);
					//	var_dump($trainees);
						$ivs=$this->Invoice->GetInvoiceByCAS($row['company_id'],$row['schedule_id']);
						$array_t=array();
						foreach($ivs as $item)
						{
							$array_v=json_decode($item->registrations_details,true);
							if(is_array($array_v)){
								if(count($array_v)){
									foreach($array_v as $key=>$value)
									{
										array_push($array_t,$key);
										}
							
								}
							}
						}
				$this->data['trainees']=$trainees;		
				$this->data['array_t'] = $array_t;						
				$this->data['invoice_id'] = $row['id'];
				$this->data['invoice_number'] = substr($row['invoice_number'],4,strlen($row['invoice_number']));
				$this->data['invoice_number_year'] = substr($row['invoice_number'],0,4);
				$this->data['hijri_date'] = $row['hijri_date'];
				$this->data['company_id'] = $row['company_id'];
				$this->data['schedule_id'] = $row['schedule_id'];
				$this->data['vendor_name'] = $row['vendor_name'];
				$this->data['vendor_name_ar'] = $row['vendor_name_ar'];
				$this->data['vendor_number'] = $row['vendor_number'];
				$this->data['contract_name'] = $row['contract_name'];
				$this->data['contract_name_ar'] = $row['contract_name_ar'];
				$this->data['contract_number'] = $row['contract_number'];
				$this->data['schedules_details'] = $row['schedules_details'];
				//$this->data['amount'] = $row[''];
				$this->data['total_amount'] = $row['total_amount'];
				$this->data['discount'] = $row['total_net_amount'];
				$this->data['total_net_amount'] = $row['total_net_amount'];
				$this->data['amount_in_word'] = $row['amount_in_word'];
				$this->data['amount_in_word_ar'] = $row['amount_in_word_ar'];
				$this->data['bank_id'] = $row['bank_id'];
				$this->data['status'] = $row['status'];
								
				//$this->data['categories']   =$this->Schedule->GetCategories();
	/*			$this->data['majors']   =$this->Course->GetAllMajors();
				$this->data['courses']   =$this->Course->GetCourses();
			//	$this->data['schedules']=array();
				$this->data['cities_data']=array();
				$this->data['hotels_data']=array();
				$this->data['instructors_data']=array();				
				//$this->data['countries']   =$this->Country->GetCountries();
				//$this->data['providers']   =$this->Provider->GetProviders();
				//$this->data['clients']   =$this->Client->GetAllClients();
				//$this->data['genders']   =$this->Registration->GetGenders();
				//$this->data['audiences']   =$this->Registration->GetAudiences();
				//$this->data['experiences']   =$this->Registration->GetExperiences();
				//$this->data['purposes']   =$this->Registration->GetPurposes();
				*/
				//$this->data['clients']   =$this->Client->GetClientsBy();
				$this->data['banks']   =$this->Bank->GetBanks();
				$this->data['schedules']   =$this->Schedule->GetActiveSchedules(2);
				//var_dump($this->data['schedules']);
				$this->data['subtitle'] = 'Create Public Invoice';
				$this->data['title'] = "Inma Kingdom training system - Create Biding Invoice";
				$this->template->load('_template', 'invoice_public_edit', $this->data);	
	}
		
	public function biding()
	{
	$get = $this->uri->uri_to_assoc();
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Dashboard','dashboard');
		$this->breadcrumb->add_crumb('Biding Invoices');
		if(isset($get['status'])){
			$status=$get['status'];
			$status_t='( '.ucfirst($status).' )';
			$this->breadcrumb->add_crumb($status);
			}
		else{
			$status='';
			$status_t='';
			}
		if($get['status']=='pending')
		$r=31;
		if($get['status']=='paid')
		$r=29;	
		$p_delete=$this->ag_auth->check_privilege($this->session->userdata('privileges'),12,$r,'delete');
		$p_edit=$this->ag_auth->check_privilege($this->session->userdata('privileges'),12,$r,'edit');
		$p_add=$this->ag_auth->check_privilege($this->session->userdata('privileges'),12,$r,'add');
		$this->data['p_delete']=$p_delete;
		$this->data['p_edit']=$p_edit;
		$this->data['p_add']=$p_add;			
		$this->data['pending_invoices']=$this->Invoice->GetNumberOfInvoice(1,'pending');	
		$this->data['paid_invoices']=$this->Invoice->GetNumberOfInvoice(1,'paid');	
		$this->data['canceled_invoices']=$this->Invoice->GetNumberOfInvoice(1,'canceled');	
		$this->data['msg']=$this->session->userdata('admin_message');
		$this->session->unset_userdata('admin_message');		
		$this->data['query']=$this->Invoice->GetInvoices(1,$status);	
		$this->data['subtitle'] = ' '.$status_t.' - Biding Invoices';
		$this->data['title'] = "Inma Kingdom Training System - Invoices List";
		$this->template->load('_template', 'biding_invoices', $this->data);		
	}

	public function biding_view()
	{
	$get = $this->uri->uri_to_assoc();	
	if(isset($get['id'])){
		$query=$this->Invoice->GetInvoiceById($get['id']);
		$this->data['query']=$query;
		if(count($query)){	
		$this->data['banks']=$this->Bank->GetBankById($query['bank_id']);
	if(isset($get['lang']))
		{
			if($get['lang']=='ar'){
		$this->data['title'] = "مركز االانماء للتدريب";	
		$this->load->view('biding_invoice_view_ar', $this->data);	
			}
		}
		else{
		$this->data['title'] = "Inma Kingdom Training System - Biding Invoice";
		$this->load->view('biding_invoice_view', $this->data);	
		//$this->template->load('_template', 'biding_invoice_view', $this->data);
			}}
		else{
			redirect('p403');
			}				
	}
		else{
			redirect('p403');
			}				
	}

	public function public_view()
	{
	$get = $this->uri->uri_to_assoc();	
	if(isset($get['id'])){
		$query=$this->Invoice->GetInvoiceById($get['id']);
		$this->data['query']=$query;
		if(count($query)){	
		$this->data['banks']=$this->Bank->GetBankById($query['bank_id']);
		if(isset($get['lang']))
		{
			if($get['lang']=='ar'){
		$this->data['title'] = "مركز االانماء للتدريب";
		$this->load->view('public_invoice_view_ar', $this->data);	
				
				}
		}
		else{
		$this->data['title'] = "Inma Kingdom Training System - Public Invoice";
		$this->load->view('public_invoice_view', $this->data);	
		}
		//$this->template->load('_template', 'biding_invoice_view', $this->data);
			}
		else{
			redirect('p403');
			}				
	}
		else{
			redirect('p403');
			}				
	}

	public function schedules()
	{
		$get = $this->uri->uri_to_assoc();
		$schedule=$this->Schedule->GetScheduleId($get['id']);
		$cat=$get['cat'];
		$categories=$this->Schedule->GetCategoryById($cat);	
		$cat_title=$schedule['course'].' ( '.$schedule['country'].' - '.$schedule['city'].' / '.date("d-m-Y", strtotime($schedule['start_date'])).' to '.date("d-m-Y", strtotime($schedule['end_date'])).' )';
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Dashboard','dashboard');
		$this->breadcrumb->add_crumb($categories['title'].' Class Schedules','registrations/index/cat/'.$cat);
		$this->breadcrumb->add_crumb($schedule['course'].' ( '.$schedule['country'].' - '.$schedule['city'].' / '.date("d-m-Y", strtotime($schedule['start_date'])).' to '.date("d-m-Y", strtotime($schedule['end_date'])).' )');
		$this->breadcrumb->add_crumb('Registrations List');
		if(isset($get['status'])){
			$status=$get['status'];
			$status_t='( '.ucfirst($status).' )';
			$this->breadcrumb->add_crumb(ucfirst($cat_title).' - '.$status);
			}
		else{
			$status='';
			$status_t='';
			}
		$this->data['cat_link']=$cat;
		$this->data['pending_schedules']=$this->Registration->GetNumberOfRegistration($cat,'pending');	
		$this->data['canceled_schedules']=$this->Registration->GetNumberOfRegistration($cat,'canceled');	
		$this->data['done_schedules']=$this->Registration->GetNumberOfRegistration($cat,'done');	
		$this->data['msg']=$this->session->userdata('admin_message');
		$this->session->unset_userdata('admin_message');		
		$this->data['query']=$this->Registration->GetRegistrationsInfoBySchedule($get['id']);	
		$this->data['subtitle'] = ucfirst($cat_title).' '.$status_t.' - Registration List';
		$this->data['title'] = "Inma Kingdom Training System - Registered Trainees List";
		$this->template->load('_template', 'registrations', $this->data);		
	}

	public function company()
	{
		$get = $this->uri->uri_to_assoc();
		$company=$this->Client->GetClientById($get['id']);
		$cat=$get['cat'];
		$categories=$this->Schedule->GetCategoryById($cat);	
		$cat_title=$company['name'];
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Dashboard','dashboard');
		$this->breadcrumb->add_crumb($categories['title'].' Class Schedules','registrations/index/cat/'.$cat);
		$this->breadcrumb->add_crumb($cat_title);
		$this->breadcrumb->add_crumb('Registrations List');
		if(isset($get['status'])){
			$status=$get['status'];
			$status_t='( '.ucfirst($status).' )';
			$this->breadcrumb->add_crumb(ucfirst($cat_title).' - '.$status);
			}
		else{
			$status='';
			$status_t='';
			}
		$this->data['cat_link']=$cat;
		$this->data['pending_schedules']=$this->Registration->GetNumberOfRegistration($cat,'pending');	
		$this->data['canceled_schedules']=$this->Registration->GetNumberOfRegistration($cat,'canceled');	
		$this->data['done_schedules']=$this->Registration->GetNumberOfRegistration($cat,'done');	
		$this->data['msg']=$this->session->userdata('admin_message');
		$this->session->unset_userdata('admin_message');		
		$this->data['query']=$this->Registration->GetRegistrationsInfoByCompany($get['id']);	
		$this->data['subtitle'] = ucfirst($cat_title).' '.$status_t.' - Registration List';
		$this->data['title'] = "Inma Kingdom Training System - Registered Trainees List";
		$this->template->load('_template', 'registrations', $this->data);		
	}
	
	public function details()
	{
		$get = $this->uri->uri_to_assoc();
		$row=$this->Registration->GetRegisterInfoById($get['id']);
		$this->data['clients']=$this->Client->GetClientById($row['company_id']);
		$this->data['query']=$row;
		$this->data['genders']   =$this->Registration->GetGenders();
		$this->data['audiences']   =$this->Registration->GetAudiences();
		$this->data['experiences']   =$this->Registration->GetExperiences();
		$this->data['purposes']   =$this->Registration->GetPurposes();
		$this->data['recalls']   =$this->Registration->GetRecalls();		
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Dashboard','dashboard');
		$this->breadcrumb->add_crumb('Registrations','registrations');
		$this->breadcrumb->add_crumb('Registration info : '.$row['first_name'].' '.$row['last_name']);
		$this->breadcrumb->add_crumb('Details');		
		$this->data['msg']=$this->session->userdata('admin_message');
		$this->session->unset_userdata('admin_message');
		$this->data['subtitle'] = "Personal Information Form";		
		$this->data['title'] = "Inma Kingdom Training System - Course Info";
		$this->template->load('_template', 'registration_details', $this->data);		
	}
	
	public function view()
	{
		$get = $this->uri->uri_to_assoc();
		$row=$this->Registration->GetRegisterInfoById($get['id']);
		$this->data['clients']=$this->Client->GetClientById($row['company_id']);
		$this->data['query']=$row;
		$this->data['genders']   =$this->Registration->GetGenders();
		$this->data['audiences']   =$this->Registration->GetAudiences();
		$this->data['experiences']   =$this->Registration->GetExperiences();
		$this->data['purposes']   =$this->Registration->GetPurposes();
		$this->data['recalls']   =$this->Registration->GetRecalls();		
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Dashboard','dashboard');
		$this->breadcrumb->add_crumb('Registrations','registrations');
		$this->breadcrumb->add_crumb('Registration info : '.$row['first_name'].' '.$row['last_name']);
		$this->breadcrumb->add_crumb('Details');		
		$this->data['msg']=$this->session->userdata('admin_message');
		$this->session->unset_userdata('admin_message');
		$this->data['subtitle'] = "Personal Information Form";		
		$this->data['title'] = "Inma Kingdom Training System - Course Info";
		$this->load->view('registration_view', $this->data);		
	}	
	public function GetSchedules()
	{
		$biding_id	= $_POST['id'];
		$schedule_id	= $_POST['schedule_id'];
		$client_id	= $_POST['client_id'];
		$schedules=$this->Schedule->GetSchedules($biding_id,'pending');
		$array_schedules['']='Select Class Schedule';
		foreach($schedules as $schedule)
			{
				$array_schedules[$schedule->id]=$schedule->course.'('.$schedule->start_date.' To '.$schedule->end_date.' / '.$schedule->city.')';
			}
		if($client_id=='')
		$client_id=0;	
		$city_class=' id="city_id"  class="validate[required]" onchange="getclients(this.value,'.$client_id.')"';	
		echo form_dropdown('schedule_id', $array_schedules,$schedule_id,$city_class);
		}
	
	
	public function GetClientsd()
	{
		$schedule_id	= $_POST['id'];
		$client_id	= $_POST['client_id'];
		$schedules=$this->Schedule->GetScheduleId($schedule_id);
		if($schedules['client_id']==0){
		$clients=$this->Client->GetAllClients($schedule_id);
		$array_clients['']='Select Client';
		$array_clients[0]='Private';
		foreach($clients as $client)
			{
				if($client->id!=0)
				$array_clients[$client->id]=$client->name;
			}		
		}
		else{
			$clients=$this->Client->GetClientById($schedule_id);
			$array_clients[$clients['id']]=$clients['name'];
			}

		if($client_id=='')
		$client_id=0;		
		echo form_dropdown('company_id', $array_clients,$client_id);
		}				
	public function edit()
	{
			$get = $this->uri->uri_to_assoc();
			$row=$this->Registration->GetRegisterInfoById($get['id']);
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Registrations','registrations');
			$this->breadcrumb->add_crumb('Registration info : '.$row['first_name'].' '.$row['last_name']);
			$this->breadcrumb->add_crumb('Edit');		
			$this->form_validation->set_rules('code', 'code', 'trim');
			$this->form_validation->set_rules('s_code', 's_code', 'trim');
			$this->form_validation->set_rules('first_name', 'first_name', 'trim');
			$this->form_validation->set_rules('second_name', 'second_name', 'trim');
			$this->form_validation->set_rules('last_name', 'last_name', 'trim');
			$this->form_validation->set_rules('fullname', 'fullname', 'trim');
			$this->form_validation->set_rules('country', 'country', 'trim');
			$this->form_validation->set_rules('city', 'city', 'trim');
			$this->form_validation->set_rules('address', 'address', 'trim');
			$this->form_validation->set_rules('pobox', 'pobox', 'trim');
			$this->form_validation->set_rules('phone', 'phone', 'trim');
			$this->form_validation->set_rules('fax', 'fax', 'trim');
			$this->form_validation->set_rules('mobile', 'mobile', 'trim');
			$this->form_validation->set_rules('email', 'email', 'trim');
			$this->form_validation->set_rules('job_title', 'job_title', 'trim');
			$this->form_validation->set_rules('business_type', 'business_type', 'trim');
			$this->form_validation->set_rules('audience', 'audience', 'trim');
			$this->form_validation->set_rules('experience', 'experience', 'trim');
			$this->form_validation->set_rules('birthdate', 'birthdate', 'trim');
			$this->form_validation->set_rules('training_recalls', 'training_recalls', 'trim');
			$this->form_validation->set_rules('others', 'others', 'trim');
			$this->form_validation->set_rules('sex', 'sex', 'trim');
			$this->form_validation->set_rules('schedule_id', 'schedule_id', 'trim');
			$this->form_validation->set_rules('company_id', 'company_id', 'trim');
			$this->form_validation->set_rules('status', 'status', 'trim');

			if ($this->form_validation->run()) {

				$data = array(
				'code' => $this->form_validation->set_value('code'),
				's_code' => $this->form_validation->set_value('s_code'),
				'first_name' => $this->form_validation->set_value('first_name'),
				'second_name' => $this->form_validation->set_value('second_name'),
				'last_name' => $this->form_validation->set_value('last_name'),
				'fullname' => $this->form_validation->set_value('fullname'),
				'country' => $this->form_validation->set_value('country'),
				'city' => $this->form_validation->set_value('city'),
				'address' => $this->form_validation->set_value('address'),
				'pobox' => $this->form_validation->set_value('pobox'),
				'phone' => $this->form_validation->set_value('phone'),
				'fax' => $this->form_validation->set_value('fax'),
				'mobile' => $this->form_validation->set_value('mobile'),
				'email' => $this->form_validation->set_value('email'),
				'job_title' => $this->form_validation->set_value('job_title'),
				'business_type' => $this->form_validation->set_value('business_type'),
				'audience' => $this->form_validation->set_value('audience'),
				'experience' => $this->form_validation->set_value('experience'),
				'birthdate' => $this->form_validation->set_value('birthdate'),
				'training_recalls' => $this->form_validation->set_value('training_recalls'),
				'purpose_training' => $purpose,
				'others' => $this->form_validation->set_value('others'),
				'sex' => $this->form_validation->set_value('sex'),
				'schedule_id' => $this->form_validation->set_value('schedule_id'),
				'company_id' => $this->form_validation->set_value('company_id'),
				'status' => $this->form_validation->set_value('status'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);
				if($this->Administrator->edit('training_registrations',$data,$get['id']))
				{
					$this->session->set_userdata(array('admin_message'=>'Class Schedule Updated successfully'));
					redirect('registrations/details/id/'.$get['id']);
				}
				else
				{
					$this->session->set_userdata(array('admin_message'=>'Error'));	
					redirect('registrations/edit/id/'.$get['id']);					
				}
				
			 }
				$this->data['registration_id'] = $row['id'];
				$this->data['code'] = $row['code'];
				$this->data['s_code'] = $row['s_code'];
				$this->data['first_name'] = $row['first_name'];
				$this->data['second_name'] = $row['second_name'];
				$this->data['last_name'] = $row['last_name'];
				$this->data['fullname'] = $row['fullname'];
				$this->data['country'] = $row['country'];
				$this->data['city'] = $row['city'];
				$this->data['address'] = $row['address'];
				$this->data['pobox'] = $row['pobox'];
				$this->data['phone'] = $row['phone'];
				$this->data['fax'] = $row['fax'];
				$this->data['mobile'] = $row['mobile'];
				$this->data['email'] = $row['email'];
				$this->data['job_title'] = $row['job_title'];
				$this->data['business_type'] = $row['business_type'];
				$this->data['audience'] = $row['audience'];
				$this->data['experience'] = $row['experience'];
				$this->data['birthdate'] = $row['birthdate'];
				$this->data['training_recalls'] = $row['training_recalls'];
				$this->data['purpose_training'] = $row['purpose_training'];
				$this->data['others'] = $row['others'];
				$this->data['sex'] = $row['sex'];
				$this->data['schedule_id'] = $row['schedule_id'];
				$this->data['company_id'] = $row['company_id'];
				$this->data['status'] = $row['status'];
				$this->data['subtitle'] = 'Register New Trainee';
				$this->data['categories']   =$this->Schedule->GetCategories();
				$this->data['majors']   =$this->Course->GetAllMajors();
				$this->data['courses']   =$this->Course->GetCourses();
				$schedules=$this->Schedule->GetScheduleId($row['schedule_id']);
				$this->data['category_id']=$schedules['category_id'];
				$this->data['schedules']=$this->Schedule->GetSchedules($schedules['category_id'],'pending');
				$this->data['cities_data']=array();
				$this->data['hotels_data']=array();
				$this->data['instructors_data']=array();				
				$this->data['countries']   =$this->Country->GetCountries();
				$this->data['providers']   =$this->Provider->GetProviders();
				$this->data['clients']   =$this->Client->GetAllClients();
				$this->data['genders']   =$this->Registration->GetGenders();
				$this->data['audiences']   =$this->Registration->GetAudiences();
				$this->data['experiences']   =$this->Registration->GetExperiences();
				$this->data['purposes']   =$this->Registration->GetPurposes();
				$this->data['recalls']   =$this->Registration->GetRecalls();
				$this->data['title'] = "Inma Kingdom training system - Register New Trainee";
				$this->template->load('_template', 'registartion_form', $this->data);	
	}
	
	public function tools()
	{
			$get = $this->uri->uri_to_assoc();
			if(isset($get['id']))
			$row=$this->Schedule->GetScheduleInstructionDetailsById($get['id']);
			$schedules=$this->Schedule->GetScheduleId($row['schedule_id']);
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Class Schedules','schedules');
			$this->breadcrumb->add_crumb($schedules['course'].'('.$schedules['start_date'].' To '.$schedules['end_date'].') '.$schedules['country'].' - '.$schedules['city'],'schedules/details/id/'.$schedules['id']);
			$this->breadcrumb->add_crumb('Manage Instructor Tools');		
			$this->form_validation->set_rules('schedule_id', 'Class Schedule', 'required');
			$this->form_validation->set_rules('instructor_id', 'Instructor', 'required');
			$this->form_validation->set_rules('hotel_meeting_id', 'hotel', 'trim');
			$this->form_validation->set_rules('eveluation', 'Eveluation', 'trim');
			$this->form_validation->set_rules('visa', 'visa', 'trim');
			$this->form_validation->set_rules('ticket', 'ticket', 'trim');
			if ($this->form_validation->run()) {
				
				$data = array(
				'schedule_id' => $this->form_validation->set_value('schedule_id'),
				'instructor_id' => $this->form_validation->set_value('instructor_id'),
				'hotel_id' => $this->form_validation->set_value('hotel_meeting_id'),
				'eveluation' => $this->form_validation->set_value('eveluation'),
				'visa' => $this->form_validation->set_value('visa'),
				'ticket' => $this->form_validation->set_value('ticket'),
				'create_time' =>  date('Y-m-d H:i:s'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);

			if($this->Administrator->edit('training_schedule_instructors',$data,$get['id']))
				{
					$this->session->set_userdata(array('admin_message'=>'Instructor Tools Updated successfully'));
					redirect('schedules/details/id/'.$this->form_validation->set_value('schedule_id'));
				}
				else
				{
					$this->session->set_userdata(array('admin_message'=>'Error'));	
					redirect('schedules/tools/id/'.$get['id']);					
				}
				
			 
				
			 }
				$this->data['t_id'] = $row['id'];
				$this->data['schedule_id'] = $row['schedule_id'];
				$this->data['class_schedule'] = $schedules['course'].'('.$schedules['start_date'].' To '.$schedules['end_date'].') '.$schedules['country'].' - '.$schedules['city'];
				$this->data['instructor'] = $schedules['instructor'];
				$this->data['provider'] = $schedules['provider'];
				$this->data['instructor_id'] = $row['instructor_id'];
				$this->data['hotel_id'] = $row['hotel_id'];
				$this->data['eveluation'] = $row['eveluation'];
				$this->data['visa'] = $row['visa'];
				$this->data['ticket'] = $row['ticket'];
								
				$locations=$this->Hotel->GetHotelById($row['hotel_id']);	
				$this->data['country_id'] = $locations['country_id'];
				$this->data['city_id'] = $locations['city_id'];
				$this->data['countries']   =$this->Country->GetCountries();
				$this->data['cities_data']=$this->Country->GetCitiesByCountryId($locations['country_id']);
				$this->data['hotels_data']=$this->Hotel->GetHotelsByCityId($locations['city_id']);				
				$this->data['subtitle'] = 'Class Schedule - Instructor Tools';
				$this->data['title'] = "Inma Kingdom training system -Class Schedule - Instructor Tools";
				$this->template->load('_template', 'schedule_tools', $this->data);	
	}	
	public function edit_major()
	{
			$get = $this->uri->uri_to_assoc();
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Courses','courses');
			$this->breadcrumb->add_crumb('Majors','courses/majors');
			$this->breadcrumb->add_crumb('Edit Major');		
			$this->form_validation->set_rules('major_title', 'Course Title', 'required');
			if ($this->form_validation->run()) {
				
				$data = array(
				'title' => $this->form_validation->set_value('major_title'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);

			if($this->Administrator->edit('training_majors',$data,$get['id']))
				{
					$this->session->set_userdata(array('admin_message'=>'Course Updated successfully'));
					redirect('courses/majors');
				}
				else
				{
					$this->session->set_userdata(array('admin_message'=>'Error'));	
					redirect('courses/edit_major/id/'.$get['id']);					
				}
				
			 }
			 	$row=$this->Course->GetMajorId($get['id']);
				$this->data['major_id'] = $row['id'];
				$this->data['major_title'] = $row['title'];
				$this->data['subtitle'] = 'Edit Major';
				$this->data['title'] = "Inma Kingdom training system - Edit Major";
				$this->template->load('_template', 'major_form', $this->data);	
	}										
											
}

?>