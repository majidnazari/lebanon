<?php
	class Log extends CI_Model{
	    var $LabelData;
    public function __construct()
	{

		parent::__construct();
	
		$this->LabelData = array(
		            'id' => 'ID',
                    'ref' => 'المرجع',
                    'name_ar' => 'الاسم',
                    'name_en' => 'Name',
                    'title_ar' => 'الاسم',
                    'title_en' => 'Name',
                    'sector_id' => 'القطاع',
                    'activity_ar' => 'النشاط',
                    'activity_en' => 'Activity',
                    'company_type_id' => 'نوع الشركة',
                    'governorate_id' => 'المحافظة',
                    'district_id' => 'القضاء',
                    'area_id' => 'البلدة',
                    'street_ar' => 'شارع',
                    'street_en' => 'Street in English',
                    'bldg_ar' => 'بناية',
                    'bldg_en' => 'Building in English',
                    'fax' => 'Fax',
                    'phone' => 'Phone',
                    'pobox_ar' => 'Pobox in Arabic',
                    'pobox_en' => 'Pobox in English',
                    'email' => 'Email',
                    'website' => 'Website',
                    'x_decimal' => 'N Location Decimal',
                    'y_decimal' => 'E Location Decimal',
                    'rep_person_ar' => 'مع من تمت المقابلة',
                    'rep_person_en' => 'Interviewer',
                    'position_id' => 'صفته في المؤسسة',
                    'iro_code' => 'غرفة التجارة الصناعة والزراعة في',
                    'igr_code' => 'تجمع صناعي',
                    'sales_man_id' => 'المندوب',
                    'auth_no' => 'سجل تجاري',
                    'owner_name' => 'صاحب المؤسسة',
                    'eas_code' => 'اتحادات مهنية اقليمية او دولية',
                    'show_online' => 'Online',
                    'owner_name_en' => 'Company Owner',
                    'copy_res' => 'Copy Reservation',
                    'is_adv' => 'Advertisment',
                    'auth_person_ar' => 'المفوض بالتوقيع',
                    'auth_person_en' => 'Auth. to sign',
                    'app_fill_date' => 'تاريخ ملء الاستمار',
                    'personal_notes' => 'ملاحظات شخصي',
                    'adv_pic' => 'صورة الاعل',
                    'ind_association' => 'جمعية الصناعيين اللبنانين',
                    'license_source_id' => 'مصدر السجل',

                    'display_directory' => 'تم عرض الدليل',
                    'directory_interested' => 'مهتم',
                    'display_exhibition' => 'تم عرض المعرض',
                    'address2_ar' => 'العنوان ٢',
                    'address2_en' => 'Address 2',

                    'wezara_source' => 'وزارة الصناعة',
                    'other_source' => 'اخرى / حدد',
                    'nbr_source' => 'رقم الرخصة',
                    'date_source' => 'تاريخ الرخصة',
                    'type_source' => 'الفئة - الرخصة',
                    'ministry_id' => 'ID وزارة',
                    'employees_number' => 'عدد العمال',
                    'is_closed' => 'مغلقة',
                    'error_address' => 'عنوان خطأ ',
                    'acc' => 'ACC. Done',
                    'closed_date' => 'تاريخ الاغلاق',
                    'related_companies'=>'Related Companies ID',
                    'create_time' => 'Create Date',
                    'update_time' => 'Last Update Date',
                    'user_id' => 'Created By',
                    'com_capital' => 'Capital',
                    'entry_date'=>'Entry Date',
                    'license_date'=>'License Date',
                    'update_info'=>'Update Info'
                );
			
						
	}
            
                
                function ShowData($key){
                   
                   
			            if(array_key_exists($key,$this->LabelData)){
			                $value=$this->LabelData[$key];
			            }
			            else{
			                $value=$key; 
			            }
			            
                   
			        return $value;
			
			}
		
    function GetLogs($id='',$keyword='',$from='', $to='', $user='',$type='',$action='',$logs_id='',$row,$limit)
	{
		$this->db->select('logs.*');
		$this->db->select('users.username, users.fullname');
		$this->db->from('logs');
		$this->db->join('users', 'users.id = logs.user_id', 'left');
		if($id!='')
		$this->db->where('logs.item_id',$id);
		if($keyword!='')
		{
		    $where='(logs.item_title LIKE "%'.$keyword.'%" OR logs.details LIKE "%'.$keyword.'%")';
		    $this->db->where($where);
		}
		
		if($from!='')
		$this->db->where('logs.create_time >=',$from.' 00:00:00');
		if($to!='')
		$this->db->where('logs.create_time <=',$to.' 23:59:59');
		if($user!='')
		$this->db->where('logs.user_id',$user);
		if($type!='')
		$this->db->where('logs.type',$type);
		if($action!='')
		$this->db->where('logs.action',$action);
		if($logs_id!='')
		$this->db->where('logs.logs_id',$logs_id);
		
		if($limit!=0)
		$this->db->limit($limit,$row);
		$this->db->order_by('id','DESC');
		$query = $this->db->get();
		return $query->result();
	}
	function GetLogById($id)
	{
		$this->db->select('logs.*');
		$this->db->select('users.username, users.fullname');
		$this->db->from('logs');
		$this->db->join('users', 'users.id = logs.user_id', 'left');
		$this->db->where('logs.id',$id);
		$this->db->order_by('id','DESC');
		$query = $this->db->get();
		return $query->row_array();
	}
	
	function GetCompaniesByUser($from='', $to='', $user='',$row,$limit)
	{
		$this->db->select('history_companies.*');
		$this->db->select('users.username, users.fullname');
		$this->db->from('history_companies');
		$this->db->join('users', 'users.id = history_companies.user_id', 'left');
		if($from!='')
		$this->db->where('history_companies.create_time >=',$from.' 00:00:00');
		if($to!='')
		$this->db->where('history_companies.create_time <=',$to.' 23:59:59');
		if($user!='')
		$this->db->where('history_companies.user_id',$user);
		
		if($limit!=0)
		$this->db->limit($limit,$row);
		$this->db->order_by('id','DESC');
		$query = $this->db->get();
		return $query->result();
	}	
	function GetBanksByUser($from='', $to='', $user='',$row,$limit)
	{
		$this->db->select('history_banks.*');
		$this->db->select('users.username, users.fullname');
		$this->db->from('history_banks');
		$this->db->join('users', 'users.id = history_banks.user_id', 'left');
		if($from!='')
		$this->db->where('history_banks.create_time >=',$from.' 00:00:00');
		if($to!='')
		$this->db->where('history_banks.create_time <=',$to.' 23:59:59');
		if($user!='')
		$this->db->where('history_banks.user_id',$user);
		
		if($limit!=0)
		$this->db->limit($limit,$row);
		$this->db->order_by('id','DESC');
		$query = $this->db->get();
		return $query->result();
	}
	function GetInsurancesByUser($from='', $to='', $user='',$row,$limit)
	{
		$this->db->select('history_insurances.*');
		$this->db->select('users.username, users.fullname');
		$this->db->from('history_insurances');
		$this->db->join('users', 'users.id = history_insurances.user_id', 'left');
		if($from!='')
		$this->db->where('history_insurances.create_time >=',$from.' 00:00:00');
		if($to!='')
		$this->db->where('history_insurances.create_time <=',$to.' 23:59:59');
		if($user!='')
		$this->db->where('history_insurances.user_id',$user);
		
		if($limit!=0)
		$this->db->limit($limit,$row);
		$this->db->order_by('id','DESC');
		$query = $this->db->get();
		return $query->result();
	}	
	function GetImportersByUser($from='', $to='', $user='',$row,$limit)
	{
		$this->db->select('history_importers.*');
		$this->db->select('users.username, users.fullname');
		$this->db->from('history_importers');
		$this->db->join('users', 'users.id = history_importers.user_id', 'left');
		if($from!='')
		$this->db->where('history_importers.create_time >=',$from.' 00:00:00');
		if($to!='')
		$this->db->where('history_importers.create_time <=',$to.' 23:59:59');
		if($user!='')
		$this->db->where('history_importers.user_id',$user);
		
		if($limit!=0)
		$this->db->limit($limit,$row);
		$this->db->order_by('id','DESC');
		$query = $this->db->get();
		return $query->result();
	}	
	function GetTransportationsByUser($from='', $to='', $user='',$row,$limit)
	{
		$this->db->select('history_transportations.*');
		$this->db->select('users.username, users.fullname');
		$this->db->from('history_transportations');
		$this->db->join('users', 'users.id = history_transportations.user_id', 'left');
		if($from!='')
		$this->db->where('history_transportations.create_time >=',$from.' 00:00:00');
		if($to!='')
		$this->db->where('history_transportations.create_time <=',$to.' 23:59:59');
		if($user!='')
		$this->db->where('history_transportations.user_id',$user);
		
		if($limit!=0)
		$this->db->limit($limit,$row);
		$this->db->order_by('id','DESC');
		$query = $this->db->get();
		return $query->result();
	}	
	function GetCompanies($from='', $to='', $action='',$row,$limit)
	{
		$this->db->select('history_companies.*');
		$this->db->select('users.username, users.fullname');
		$this->db->from('history_companies');
		$this->db->join('users', 'users.id = history_companies.user_id', 'left');
		if($from!='')
		$this->db->where('history_companies.create_time >=',$from.' 00:00:00');
		if($to!='')
		$this->db->where('history_companies.create_time <=',$to.' 23:59:59');
		if($action!='')
		$this->db->where('history_companies.action',$action);
		
		if($limit!=0)
		$this->db->limit($limit,$row);
		$this->db->order_by('id','DESC');
		$query = $this->db->get();
		return $query->result();
	}
	function GetCompanyById($id)
	{
		$this->db->select('history_companies.*');
		$this->db->select('users.username, users.fullname');
		$this->db->from('history_companies');
		$this->db->join('users', 'users.id = history_companies.user_id', 'left');
		$this->db->where('history_companies.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}
	function GetProductionInfo($h_id)
	{
		$this->db->select('history_company_heading.*');
		$this->db->select('users.username, users.fullname');
		$this->db->from('history_company_heading');
		$this->db->join('users', 'users.id = history_company_heading.user_id', 'left');
		$this->db->where('history_company_heading.history_c_id',$h_id);
		$query = $this->db->get();
		return $query->row_array();
	}
	function GetCompanyMarkets($h_id)
	{
		$this->db->select('history_markets_company.*');
		$this->db->select('users.username, users.fullname');
		$this->db->from('history_markets_company');
		$this->db->join('users', 'users.id = history_markets_company.user_id', 'left');
		$this->db->where('history_markets_company.history_c_id',$h_id);
		$query = $this->db->get();
		return $query->row_array();
	}	
	function GetCompanyElectricPowers($h_id)
	{
		$this->db->select('history_power_company.*');
		$this->db->select('users.username, users.fullname');
		$this->db->from('history_power_company');
		$this->db->join('users', 'users.id = history_power_company.user_id', 'left');
		$this->db->where('history_power_company.history_c_id',$h_id);
		$query = $this->db->get();
		return $query->row_array();
	}	
	function GetCompanyInsurances($h_id)
	{
		$this->db->select('history_insurances_company.*');
		$this->db->select('users.username, users.fullname');
		$this->db->from('history_insurances_company');
		$this->db->join('users', 'users.id = history_insurances_company.user_id', 'left');
		$this->db->where('history_insurances_company.history_c_id',$h_id);
		$query = $this->db->get();
		return $query->row_array();
	}	
	function GetCompanyBanks($h_id)
	{
		$this->db->select('history_banks_company.*');
		$this->db->select('users.username, users.fullname');
		$this->db->from('history_banks_company');
		$this->db->join('users', 'users.id = history_banks_company.user_id', 'left');
		$this->db->where('history_banks_company.history_c_id',$h_id);
		$query = $this->db->get();
		return $query->row_array();
	}	
 
 function GetBanks($from='', $to='', $action='',$row,$limit)
	{
		$this->db->select('history_banks.*');
		$this->db->select('users.username, users.fullname');
		$this->db->from('history_banks');
		$this->db->join('users', 'users.id = history_banks.user_id', 'left');
		if($from!='')
		$this->db->where('history_banks.create_time >=',$from.' 00:00:00');
		if($to!='')
		$this->db->where('history_banks.create_time <=',$to.' 23:59:59');
		if($action!='')
		$this->db->where('history_banks.action',$action);
		
		if($limit!=0)
		$this->db->limit($limit,$row);
		$this->db->order_by('id','DESC');
		$query = $this->db->get();
		return $query->result();
	}
	function GetBankById($id)
	{
		$this->db->select('history_banks.*');
		$this->db->select('users.username, users.fullname');
		$this->db->from('history_banks');
		$this->db->join('users', 'users.id = history_banks.user_id', 'left');
		$this->db->where('history_banks.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}
			
function GetBankDirectors($h_id)
	{
		$this->db->select('history_banks_directors.*');
		$this->db->select('users.username, users.fullname');
		$this->db->from('history_banks_directors');
		$this->db->join('users', 'users.id = history_banks_directors.user_id', 'left');
		$this->db->where('history_banks_directors.history_b_id',$h_id);
		$query = $this->db->get();
		return $query->row_array();
	}	
	function GetBankBranches($h_id)
	{
		$this->db->select('history_banks_branches.*');
		$this->db->select('users.username, users.fullname');
		$this->db->from('history_banks_branches');
		$this->db->join('users', 'users.id = history_banks_branches.user_id', 'left');
		$this->db->where('history_banks_branches.history_b_id',$h_id);
		$query = $this->db->get();
		return $query->row_array();
	}
 function GetInsurances($from='', $to='', $action='',$row,$limit)
	{
		$this->db->select('history_insurances.*');
		$this->db->select('users.username, users.fullname');
		$this->db->from('history_insurances');
		$this->db->join('users', 'users.id = history_insurances.user_id', 'left');
		if($from!='')
		$this->db->where('history_insurances.create_time >=',$from.' 00:00:00');
		if($to!='')
		$this->db->where('history_insurances.create_time <=',$to.' 23:59:59');
		if($action!='')
		$this->db->where('history_insurances.action',$action);
		
		if($limit!=0)
		$this->db->limit($limit,$row);
		$this->db->order_by('id','DESC');
		$query = $this->db->get();
		return $query->result();
	}
	function GetInsuranceById($id)
	{
		$this->db->select('history_insurances.*');
		$this->db->select('users.username, users.fullname');
		$this->db->from('history_insurances');
		$this->db->join('users', 'users.id = history_insurances.user_id', 'left');
		$this->db->where('history_insurances.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}
function GetInsuranceDirectors($h_id)
	{
		$this->db->select('history_insurance_directors.*');
		$this->db->select('users.username, users.fullname');
		$this->db->from('history_insurance_directors');
		$this->db->join('users', 'users.id = history_insurance_directors.user_id', 'left');
		$this->db->where('history_insurance_directors.history_id',$h_id);
		$query = $this->db->get();
		return $query->row_array();
	}	
	function GetInsuranceBranches($h_id)
	{
		$this->db->select('history_insurance_branches.*');
		$this->db->select('users.username, users.fullname');
		$this->db->from('history_insurance_branches');
		$this->db->join('users', 'users.id = history_insurance_branches.user_id', 'left');
		$this->db->where('history_insurance_branches.history_id',$h_id);
		$query = $this->db->get();
		return $query->row_array();
	}
	function GetInsuranceExecutive($h_id)
	{
		$this->db->select('history_insurance_managers.*');
		$this->db->select('users.username, users.fullname');
		$this->db->from('history_insurance_managers');
		$this->db->join('users', 'users.id = history_insurance_managers.user_id', 'left');
		$this->db->where('history_insurance_managers.history_id',$h_id);
		$query = $this->db->get();
		return $query->row_array();
	}
 function GetImporters($from='', $to='', $action='',$row,$limit)
	{
		$this->db->select('history_importers.*');
		$this->db->select('users.username, users.fullname');
		$this->db->from('history_importers');
		$this->db->join('users', 'users.id = history_importers.user_id', 'left');
		if($from!='')
		$this->db->where('history_importers.create_time >=',$from.' 00:00:00');
		if($to!='')
		$this->db->where('history_importers.create_time <=',$to.' 23:59:59');
		if($action!='')
		$this->db->where('history_importers.action',$action);
		
		if($limit!=0)
		$this->db->limit($limit,$row);
		$this->db->order_by('id','DESC');
		$query = $this->db->get();
		return $query->result();
	}
	function GetImporterById($id)
	{
		$this->db->select('history_importers.*');
		$this->db->select('users.username, users.fullname');
		$this->db->from('history_importers');
		$this->db->join('users', 'users.id = history_importers.user_id', 'left');
		$this->db->where('history_importers.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}
function GetImporterForeignCompanies($h_id)
	{
		$this->db->select('history_importer_foreign_companies.*');
		$this->db->select('users.username, users.fullname');
		$this->db->from('history_importer_foreign_companies');
		$this->db->join('users', 'users.id = history_importer_foreign_companies.user_id', 'left');
		$this->db->where('history_importer_foreign_companies.history_id',$h_id);
		$query = $this->db->get();
		return $query->row_array();
	}	
 function GetTransportations($from='', $to='', $action='',$row,$limit)
	{
		$this->db->select('history_transportations.*');
		$this->db->select('users.username, users.fullname');
		$this->db->from('history_transportations');
		$this->db->join('users', 'users.id = history_transportations.user_id', 'left');
		if($from!='')
		$this->db->where('history_transportations.create_time >=',$from.' 00:00:00');
		if($to!='')
		$this->db->where('history_transportations.create_time <=',$to.' 23:59:59');
		if($action!='')
		$this->db->where('history_transportations.action',$action);
		
		if($limit!=0)
		$this->db->limit($limit,$row);
		$this->db->order_by('id','DESC');
		$query = $this->db->get();
		return $query->result();
	}
	function GetTransportationById($id)
	{
		$this->db->select('history_transportations.*');
		$this->db->select('users.username, users.fullname');
		$this->db->from('history_transportations');
		$this->db->join('users', 'users.id = history_transportations.user_id', 'left');
		$this->db->where('history_transportations.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}
function GetTransportationBranches($h_id)
	{
		$this->db->select('history_transportations_branches.*');
		$this->db->select('users.username, users.fullname');
		$this->db->from('history_transportations_branches');
		$this->db->join('users', 'users.id = history_transportations_branches.user_id', 'left');
		$this->db->where('history_transportations_branches.history_id',$h_id);
		$query = $this->db->get();
		return $query->row_array();
	}	
function GetTransportationLineRepresented($h_id)
	{
		$this->db->select('history_transportations_line_represented.*');
		$this->db->select('users.username, users.fullname');
		$this->db->from('history_transportations_line_represented');
		$this->db->join('users', 'users.id = history_transportations_line_represented.user_id', 'left');
		$this->db->where('history_transportations_line_represented.history_id',$h_id);
		$query = $this->db->get();
		return $query->row_array();
	}	

function GetTransportationPorts($h_id)
	{
		$this->db->select('history_transportations_ports.*');
		$this->db->select('users.username, users.fullname');
		$this->db->from('history_transportations_ports');
		$this->db->join('users', 'users.id = history_transportations_ports.user_id', 'left');
		$this->db->where('history_transportations_ports.history_id',$h_id);
		$query = $this->db->get();
		return $query->row_array();
	}	
	
        
}