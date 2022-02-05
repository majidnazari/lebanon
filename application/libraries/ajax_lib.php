<?php
ob_start();

class Ajax_Lib
{
	var $CI; // The CI object
	public function __construct()
	{
		log_message('debug', 'Auth Library Loaded');

		$this->CI =& get_instance();

		$this->CI->load->model('general','');
		$this->CI->load->library('session');
	}
	
	public function saveClientItems($data)
	{
		if(empty($data))
		{
		    return 'Error Data';
		}
		else
		{
		    $client_id=$this->CI->input->post('client_id');
		    $client_type=$this->CI->input->post('client_type');
		    $status_type=$this->CI->input->post('status_type');
		    $start_date=$this->CI->input->post('start_date');
		    $end_date=$this->CI->input->post('end_date');
		    $status=$this->CI->input->post('status');
		    $sales_man_id=$this->CI->input->post('sales_man_id');
		    if(is_null($client_id) or is_null($status_type) or is_null($start_date) or is_null($end_date) or is_null($status))
		    {
		        return 'Error Data';
		    }
		    else{
		        $this->CI->Administrator->update('clients_status', array('status' => 'inactive'),['client_id'=>$client_id,'client_type'=>$client_type]);
		        $data_array=[
		            'client_id'=>$client_id,
		            'client_type'=>$client_type,
		            'status_type'=>$status_type,
		            'start_date'=>$start_date,
		            'end_date'=>$end_date,
		            'status'=>$status,
		            'sales_man_id'=>$sales_man_id,
		            'create_time'=>date('Y-m-d H:i:s'),
		            'update_time'=>date('Y-m-d H:i:s'),
		            'user_id'=>$this->CI->session->userdata('id'),
		            ];
		            $this->CI->General->save('clients_status', $data_array);
		            return 'Success';
		    }

		}
		
	} 
}

