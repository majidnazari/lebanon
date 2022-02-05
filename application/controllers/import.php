<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Import extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
				
		log_message('debug', 'Application Loaded');
		$this->load->model(array('General','Administrator','Item'));
		header("Content-Type: text/html; charset=UTF-8");
				
	}
    public function index()
	{
		//die;
			$name = $_FILES;
			include APPPATH.'libraries/PHPExcel/IOFactory.php';
			$objPHPExcel = PHPExcel_IOFactory::load('52018.xlsx');
			$maxCell = $objPHPExcel->getActiveSheet()->getHighestRowAndColumn();
			$sheetData = $objPHPExcel->getActiveSheet()->rangeToArray('A1:' . $maxCell['column'] . $maxCell['row']);
			$sheetData = array_map('array_filter', $sheetData);
			$sheetData = array_filter($sheetData);
			
				unset($sheetData[0]);
				//unset($sheetData[1]);
				foreach($sheetData as $data)
				{
					if($data[6]!=''){$data[6]=$data[6].' - ';}
					if($data[7]!=''){$data[7]=$data[7].' - ';}
					if($data[8]!=''){$data[8]=$data[8].' - ';}
					if($data[9]!=''){$data[9]=$data[9].' - ';}
					$array=array(
							'name_ar'=>@$data[0],
							'activity_ar'=>@$data[1],
							'address2_ar'=>@$data[2].' - '.@$data[3],
							'street_ar'=>@$data[4],
							'bldg_ar'=>@$data[5],
							'phone'=>@$data[6].@$data[7].@$data[8].@$data[9].@$data[10],
							'email'=>@$data[11],
							'wezara_type'=>@$data[12],
					);
					echo '<pre>';
					var_dump($array);
					echo '</pre>';
				//	$this->General->save('tbl_company',$array);
					
					//die;
					//var_dump($array);
					//die;
					//$this->General->save('companies_gps',$array);
				}
			
	}
 public function update()
	{
		die;
		$gps=$this->General->GetGPSCompanies();
		foreach($gps as $gps_i){
		$data=array('x_decimal'=>$gps_i->x_location,'y_decimal'=>$gps_i->y_location);
		$this->Administrator->edit('tbl_company',$data,$gps_i->company_id);
		}
	}	
public function formatDate($datestring){
 
    //The expected format of the inputted date is dd-mm-yyyy. Split the date in parts:
    list($day, $month, $year) = explode("-", $datestring);    
 
    //Check if split succeeded and check if parts form valid date
    if($day != "" && $month != "" && $year != "") {
        if(is_numeric($day) && is_numeric($month) && is_numeric($year)) {
            if(checkdate($month, $day, $year) === false){
                //Input was numeric but not a valid Gregorian date
                return false;
                }
            else {
                //Input was valid. Reformat to yyyy-mm-dd
                return date('Y-m-d', strtotime($year."-".$month."-".$day));
            }
        }
    }
    //Date wasn't valid
    return false;
}
	 public function importRadioData()
	{
			$name = $_FILES;
			if(empty($name['userfile']['name'])){
			$this->session->set_flashdata('error', 'Please select file to upload');
			redirect('client/calenderradio');
			}
			include APPPATH.'libraries/PHPExcel/IOFactory.php';
			$objPHPExcel = PHPExcel_IOFactory::load($name['userfile']['tmp_name']);
			$maxCell = $objPHPExcel->getActiveSheet()->getHighestRowAndColumn();
			$sheetData = $objPHPExcel->getActiveSheet()->rangeToArray('A1:' . $maxCell['column'] . $maxCell['row']);
			$sheetData = array_map('array_filter', $sheetData);
			$sheetData = array_filter($sheetData);
			$format = array('title','Date (DD-MM-YYYY)','start time (HH:MM:SS AM/PM)','end time (HH:MM:SS AM/PM)','Tags (Comma Separated)','Is AD');
			if($sheetData[0] == $format)
			{
				unset($sheetData[0]);
				foreach($sheetData as $data)
				{
					$info=$this->session->userdata('logged_in');
					$data['userid'] = $info['id'];
					$data['title'] = (!empty($data['0'])?$data['0']:'');
					$data['tags'] = (!empty($data['4'])?$data['4']:'');
					$data['isAd'] = ($data['5']=='Y'?'1':'0');
					unset($data['0']);
					$date = $this->formatDate($data['1']);
					$data['start'] = date('Y-m-d H:i', strtotime($date.' '.$data['2']));
					$data['stop'] = date('Y-m-d H:i', strtotime($date.' '.$data['3']));
					unset($data['1']);
					unset($data['2']);
					unset($data['3']);
					unset($data['4']);
					unset($data['5']);
					$this->load->model('clientmodel');
					$this->clientmodel->addradioEvents($data);
				}
				redirect('client/calenderradio');
			}
			else
			{
				$this->session->set_flashdata('error', 'Error in uploading file..');
				redirect('client/calenderradio');
			}
	}
}