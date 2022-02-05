<?php
class Ws extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('Webservice','Item','Address','Company','Bank','Insurance'));
	}
	public function getsponsors()
	{
		$query=$this->Webservice->GetSponsors();
		echo json_encode($query);
	}
	public function getcompanies()
	{
		$query=$this->Webservice->GetCompanies();
		echo json_encode($query);
	}
	public function getbanks()
	{
		$query=$this->Webservice->GetBanks();
		echo json_encode($query);
	}
	public function getimporters()
	{
		$query=$this->Webservice->GetImporters();
		echo json_encode($query);
	}
	public function getinsurances()
	{
		$query=$this->Webservice->GetInsurances();
		echo json_encode($query);
	}
	public function gettransport()
	{
		$query=$this->Webservice->GetTransport();
		echo json_encode($query);
	}
	
	public function getcompanydetails($id)
	{
		$query=$this->Webservice->GetCompanyById($id);
		$insurances=$this->Webservice->GetCompanyInsurances($id);
		$banks=$this->Webservice->GetCompanyBanks($id);
		$heading=$this->Webservice->GetProductionInfo($id);
		echo json_encode(array('details'=>$query,'insurances'=>$insurances,'banks'=>$banks,'heading'=>$heading));
	}						

public function getbankdetails($id)
	{
		$query=$this->Webservice->GetBankById($id);
		$directors=$this->Webservice->GetBankDirectors($id);
		$branches=$this->Webservice->GetBankBranches($id);
		echo json_encode(array('details'=>$query,'directors'=>$directors,'branches'=>$branches));
	}	
public function getimporterdetails($id)
{
	$query=$this->Webservice->GetImporterById($id);
	$directors=$this->Webservice->GetImporterInsuranceDirectors($id);
	$fcompanies=$this->Webservice->GetImporterForeignCompanies($id);
	$ids=explode(',',$query['activities']);
	$activities=$this->Webservice->GetImporterActivitiesByIds($ids);
	echo json_encode(array('details'=>$query,'directors'=>$directors,'fcompanies'=>$fcompanies,'activities'=>$activities));
}
public function getinsurancedetails($id)
{
	$query=$this->Webservice->GetInsuranceById($id);
	$ids=explode(',',$query['activities']);
	$activities=$this->Insurance->GetInsuranceActivitiesByIds($ids);
	echo json_encode(array('details'=>$query,'activities'=>$activities));
}	
public function gettransportdetails($id)
{
	$query=$this->Webservice->GetInsuranceById($id);
	$ports=$this->Webservice->GetTransportPorts($id);
	$represented=$this->Webservice->GetTransportLineRepresented($id);
	echo json_encode(array('details'=>$query,'ports'=>$ports,'represented'=>$represented));
}						

public function getothercountries($hid)
{
	$query=$this->Webservice->GetHeadingOtherCountries($id);
	$ports=$this->Webservice->GetTransportPorts($id);
	$represented=$this->Webservice->GetTransportLineRepresented($id);
	echo json_encode(array('details'=>$query,'ports'=>$ports,'represented'=>$represented));
}						

	public function index()
	{
		echo 'Functions: <br>
			getsponsors()<br>
			getcompanies()<br>
			getbanks()<br>
			getimporters()<br>
			getinsurances()<br>
			gettransport()<br>
			getcompanydetails($id)<br>
			getbankdetails($id)<br>
			getimporterdetails($id)<br>
			getinsurancedetails($id)<br>
			gettransportdetails($id)<br>
		';	
		
	}
	
	
										
}

?>