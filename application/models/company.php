<?php

class Company extends CI_Model {
    function SaveDeliveryCompany($_array=array())
    {
        if(count($_array)>0)
        {
            if(@$_array['id']>0)
            {
                $this->edit('delivery_items',array('delivery_man_id'=>$_array['delivery_man_id'],'receiver_name'=>$_array['receiver_name'],'receiver_date'=>$_array['receiver_date'],'copy_quantity'=>$_array['copy_quantity'],'notes'=>$_array['notes'],'status'=>$_array['status'],'url'=>$_array['url']),array('id'=>$_array['id']));
                
            }
            if($_array['status']=='done')
            {
                $delivery=1;
            }
            else{
               $delivery=0; 
            }
            	$data = array(
				'title'=>'Delivery Docs',
				'url'=> $_array['url'],
				'item_id'=> $_array['item_id'],
				'item_type'=> 'company',
				'create_time' =>  date('Y-m-d H:i:s'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);
           // $this->saveDocument($data);
            $this->edit('tbl_company',array('delivery_by'=>$_array['delivery_man_id'],'receiver_name'=>$_array['receiver_name'],'delivery_date'=>$_array['receiver_date'],'copy_qty'=>$_array['copy_quantity'],'delivery'=>$delivery),array('id'=>$_array['item_id']));
        }
    }
    function saveDocument($data)
    {
           
			$this->save('documents',$data);
    }
    function edit($table,$data,$where)
    {
        $this->db->where($where);
        $this->db->update($table, $data);
    }
function save($table,$data)
	{	
		
	$this->db->insert($table, $data);
	return $this->db->insert_id();
	}
    function GetAdCompanies($sales_man,$row,$limit)
    {
        $this->db->select('SQL_CALC_FOUND_ROWS tbl_company.*', FALSE);
        $this->db->select('tbl_sales_man.fullname as salesman');
        $this->db->select('tbl_governorates.label_ar as governorate_ar,tbl_governorates.label_en as governorate_en');
        $this->db->select('tbl_districts.label_ar as district_ar, tbl_districts.label_en as district_en');
        $this->db->select('tbl_area.label_ar as area_ar, tbl_area.label_en as area_en');
        $this->db->select('users.username, users.fullname');
        $this->db->select('COUNT(tbl_company_heading.id) as CNbr');
        $this->db->select('tbl_companies_guide_pages.guide_pages_ar, tbl_companies_guide_pages.guide_pages_en');
        $this->db->from('tbl_company');
        $this->db->join('tbl_sales_man', 'tbl_sales_man.id = tbl_company.adv_salesman_id', 'left');
        $this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_company.governorate_id', 'left');
        $this->db->join('tbl_districts', 'tbl_districts.id = tbl_company.district_id', 'left');
        $this->db->join('tbl_area', 'tbl_area.id = tbl_company.area_id', 'left');
        $this->db->join('tbl_company_heading', 'tbl_company_heading.company_id = tbl_company.id', 'left');
        $this->db->join('tbl_companies_guide_pages', 'tbl_companies_guide_pages.company_id = tbl_company.id', 'left');
        $this->db->join('users', 'users.id = tbl_company.user_id', 'left');
         $this->db->where('tbl_company.is_closed', 0);
        $this->db->where('tbl_company.error_address', 0);
        $this->db->where('tbl_company.is_adv', 1);
        $this->db->where('tbl_company.adv_pic !=', '');
        if($sales_man!=''){
             $this->db->where('tbl_company.adv_salesman_id', $sales_man);
         }
       
        $this->db->group_by('tbl_company.id');
         $this->db->order_by('tbl_sales_man.fullname', 'DESC');
        $this->db->order_by('tbl_governorates.label_ar', 'ASC');
        $this->db->order_by('tbl_districts.label_ar', 'ASC');
        $this->db->order_by('tbl_area.label_ar', 'ASC');
       
        /* if($company_id!=''){
             $this->db->where('tbl_update_info_logs.company_id', $company_id);
         }
         if($from!=''){
             $this->db->where('tbl_update_info_logs.create_time >=', $from.' 00:00:00');
         }
         if($to!=''){
             $this->db->where('tbl_update_info_logs.create_time <=', $to.' 23:59:59');
         }
         if($company_id!=''){
             $this->db->where('tbl_update_info_logs.user_id', $user_id);
         }
        */

        if ($limit != 0)
            $this->db->limit($limit, $row);
        $query = $this->db->get();
        $query1 = $this->db->query('SELECT FOUND_ROWS() AS `total_rows`');
        $objCount = $query1->result_array();
        $totalres = $objCount[0]['total_rows'];
        $data_array = array('total' => $totalres, 'rows' => $query->result());
        return $data_array;
    }
    function GetBranches($status='', $id)
    {
        $this->db->select('tbl_company_branches.*');
        $this->db->select('tbl_governorates.label_ar as governorate_ar');
        $this->db->select('tbl_governorates.label_en as governorate_en');
        $this->db->select('tbl_districts.label_ar as district_ar');
        $this->db->select('tbl_districts.label_en as district_en');
        $this->db->select('tbl_area.label_ar as area_ar');
        $this->db->select('tbl_area.label_en as area_en');
        $this->db->from('tbl_company_branches');
        $this->db->join('tbl_area', 'tbl_area.id = tbl_company_branches.area_id', 'left');
        $this->db->join('tbl_districts', 'tbl_districts.id = tbl_company_branches.district_id', 'left');
        $this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_company_branches.governorate_id', 'left');
        $this->db->where('tbl_company_branches.company_id',$id);
        if($status!='')
            $this->db->where('tbl_company_branches.status',$status);
        $this->db->order_by('governorate_ar', 'ASC');
        $this->db->order_by('district_ar', 'ASC');
        $this->db->order_by('area_ar', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }
    function GetBranchById($id)
	{
		$this->db->select('tbl_company_branches.*');
		$this->db->from('tbl_company_branches');	
		$this->db->where('tbl_company_branches.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}
    function GetUpdateInfoLogs($company_id,$from,$to,$user_id,$row,$limit)
    {
        $this->db->select('SQL_CALC_FOUND_ROWS tbl_update_info_logs.id as logs_id, tbl_update_info_logs.update_info as logs_update_info, tbl_update_info_logs.create_time as logs_create_time, tbl_update_info_logs.update_time as logs_update, tbl_update_info_logs.user_id as logs_user_id, tbl_update_info_logs.company_id as logs_company_id', FALSE);
        $this->db->select('tbl_company.*');
         $this->db->select('tbl_governorates.label_ar as governorate_ar,tbl_governorates.label_en as governorate_en');
        $this->db->select('tbl_districts.label_ar as district_ar, tbl_districts.label_en as district_en');
        $this->db->select('tbl_area.label_ar as area_ar, tbl_area.label_en as area_en');
        $this->db->select('users.username, users.fullname');
        $this->db->from('tbl_update_info_logs');
        $this->db->join('tbl_company', 'tbl_company.id = tbl_update_info_logs.company_id', 'left');
        $this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_company.governorate_id', 'left');
        $this->db->join('tbl_districts', 'tbl_districts.id = tbl_company.district_id', 'left');
        $this->db->join('tbl_area', 'tbl_area.id = tbl_company.area_id', 'left');
        $this->db->join('users', 'users.id = tbl_update_info_logs.user_id', 'left');
        if($company_id!=''){
        $this->db->where('tbl_update_info_logs.company_id', $company_id);
        }
        if($from!=''){
        $this->db->where('tbl_update_info_logs.create_time >=', $from.' 00:00:00');
        }
        if($to!=''){
        $this->db->where('tbl_update_info_logs.create_time <=', $to.' 23:59:59');
        }
        if($company_id!=''){
        $this->db->where('tbl_update_info_logs.user_id', $user_id);
        }

        if ($limit != 0)
            $this->db->limit($limit, $row);
        $query = $this->db->get();
        $query1 = $this->db->query('SELECT FOUND_ROWS() AS `total_rows`');
        $objCount = $query1->result_array();
        $totalres = $objCount[0]['total_rows'];
        $data_array = array('total' => $totalres, 'rows' => $query->result());
        return $data_array;
    }
function GetClosedCompanies($closed = '', $row, $limit) {
        $this->db->select('tbl_company.*');
        //$this->db->select('tbl_company_type.label_en as type_en');
        //$this->db->select('tbl_company_type.label_ar as type_ar');
        $this->db->from('tbl_company');
        if($closed)
            $this->db->where('tbl_company.is_closed', $closed);

        //$this->db->join('tbl_company_type', 'tbl_company_type.id = tbl_company.company_type_id', 'inner');
        //if($status!='')
        //$this->db->where('tbl_company.status',$status);
        $this->db->order_by('tbl_company.id', 'DESC');
        if($limit != 0)
            $this->db->limit($limit, $row);
        $query = $this->db->get();
        return $query->result();
    }
        function GetErrorAddressesCompanies($errora = '', $row, $limit) {
        $this->db->select('tbl_company.*');
        //$this->db->select('tbl_company_type.label_en as type_en');
        //$this->db->select('tbl_company_type.label_ar as type_ar');
        $this->db->from('tbl_company');
        if($errora)
            $this->db->where('tbl_company.error_address', $errora);

        //$this->db->join('tbl_company_type', 'tbl_company_type.id = tbl_company.company_type_id', 'inner');
        //if($status!='')
        //$this->db->where('tbl_company.status',$status);
        $this->db->order_by('tbl_company.id', 'DESC');
        if($limit != 0)
            $this->db->limit($limit, $row);
        $query = $this->db->get();
        return $query->result();
    }
    function GetUpdatedInfoCompanies()
    {
        $this->db->select('task_activities.*');

        $this->db->from('task_activities');
            $this->db->where('task_activities.updated_info',1);
        $query = $this->db->get();
        return $query->result();
    }

    function GetAreaByDistrict($status='',$did,$lang='ar')
    {
        $this->db->select('tbl_area.*');
        $this->db->select('COUNT(tbl_company.id) as total');
        $this->db->from('tbl_area');
        $this->db->join('tbl_company', 'tbl_company.area_id = tbl_area.id', 'left');
        if($status!='')
            $this->db->where('tbl_area.status',$status);
        if($did!='' and $did!=0)
            $this->db->where('tbl_area.district_id',$did);
        $this->db->group_by('tbl_company.area_id');
        if($lang=='en')
            $this->db->order_by('tbl_area.label_en', 'ASC');
        else
            $this->db->order_by('tbl_area.label_ar', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }
function GetAreaByDistrictID($status='',$did,$lang='ar')
    {
        $this->db->select('tbl_area.*');
        $this->db->from('tbl_area');
        if($status!='')
            $this->db->where('tbl_area.status',$status);
        if($did!='' and $did!=0)
            $this->db->where('tbl_area.district_id',$did);

        if($lang=='en')
            $this->db->order_by('tbl_area.label_en', 'ASC');
        else
            $this->db->order_by('tbl_area.label_ar', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }
    function GetGeoCompaniesByGovernorate() {
        $this->db->select('COUNT(*) as company_count, tbl_company.governorate_id');
        $this->db->select('tbl_governorates.label_ar as governorate_ar');
        $this->db->select('tbl_governorates.label_en as governorate_en');
        $this->db->from('tbl_company');

        $this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_company.governorate_id', 'left');
        $this->db->join('tbl_districts', 'tbl_districts.id = tbl_company.district_id', 'left');

        $this->db->where('tbl_company.show_online', 1);
        $this->db->order_by('tbl_company.governorate_id', 'DESC');
        $this->db->group_by('tbl_company.governorate_id');
        $query = $this->db->get();
        return $query->result();
    }
    function GetGeoCompaniesByDistrict() {
        $this->db->select('COUNT(*) as company_count, tbl_company.governorate_id, tbl_company.district_id');
        $this->db->select('tbl_governorates.label_ar as governorate_ar');
        $this->db->select('tbl_governorates.label_en as governorate_en');
        $this->db->select('tbl_districts.label_ar as district_ar');
        $this->db->select('tbl_districts.label_en as district_en');
        $this->db->from('tbl_company');

        $this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_company.governorate_id', 'left');
        $this->db->join('tbl_districts', 'tbl_districts.id = tbl_company.district_id', 'left');

        $this->db->where('tbl_company.show_online', 1);
        $this->db->order_by('tbl_company.governorate_id', 'DESC');
        $this->db->order_by('tbl_company.district_id', 'DESC');

        $this->db->group_by('tbl_company.district_id');
        $query = $this->db->get();
        return $query->result();
    }

    function GetTasksActivitiesStatistics($governorate_id,$district_id,$area_id,$assigne_to,$category,$year,$type,$printed,$row=0,$limit=0)
    {
        $this->db->select('SQL_CALC_FOUND_ROWS COUNT(CASE WHEN task_activities.status =  "pending" THEN 1 END) pending_count',FALSE);
        $this->db->select('COUNT(CASE WHEN task_activities.status =  "done" THEN 1 END) done_count');
        //$this->db->select('COUNT(tbl_company.id) as company_count');
        $this->db->select('tasks.*');
        $this->db->select('tbl_governorates.label_ar as governorate_ar,tbl_governorates.label_en as governorate_en');
        $this->db->select('tbl_districts.label_ar as district_ar, tbl_districts.label_en as district_en');
        $this->db->select('tbl_area.label_ar as area_ar, tbl_area.label_en as area_en');
        $this->db->select('tbl_sales_man.fullname');
        $this->db->from('tasks');
        $this->db->join('task_activities', 'task_activities.task_id = tasks.id', 'left');
        $this->db->join('tbl_governorates', 'tbl_governorates.id = tasks.governorate_id', 'left');
        $this->db->join('tbl_districts', 'tbl_districts.id = tasks.district_id', 'left');
        $this->db->join('tbl_area', 'tbl_area.id = tasks.area_id', 'left');
        $this->db->join('tbl_sales_man', 'tbl_sales_man.id = tasks.assigne_to', 'left');
        //$this->db->join('tbl_company', 'tbl_company.area_id = tasks.area_id', 'left');
        if($governorate_id != '' and $governorate_id!=0) {
            $this->db->where('tasks.governorate_id', $governorate_id);
        }
        if($district_id != '' and $district_id!=0) {
            $this->db->where('tasks.district_id', $district_id);
        }
        if($area_id != '' and $area_id!=0) {
            $this->db->where('tasks.area_id', $area_id);
        }
        if($category != '') {
            $this->db->where('tasks.category', $category);
        }
        if($assigne_to != '') {
            $this->db->where('tasks.assigne_to', $assigne_to);
        }
        if($year != '') {
            $this->db->where('tasks.year', $year);
        }
        if($type != '') {
            $this->db->where('tasks.type', $type);
        }
        if($printed != '') {
        $this->db->where('tasks.printed', $printed);
    }
        $this->db->group_by('tasks.id');
        $this->db->group_by('tasks.area_id');
        if($limit != 0)
            $this->db->limit($limit, $row);
        $query = $this->db->get();
        $query1 = $this->db->query('SELECT FOUND_ROWS() AS `total_rows`');
        $objCount = $query1->result_array();
        $totalres = $objCount[0]['total_rows'];
        $data_array = array('num_results' =>$totalres , 'results' => $query->result() );
        return $data_array;
    }
    function GetTasks($governorate_id,$district_id,$area_id,$assigne_to,$category,$year,$type)
    {
        $this->db->select('tasks.*');
        $this->db->select('tbl_governorates.label_ar as governorate_ar,tbl_governorates.label_en as governorate_en');
        $this->db->select('tbl_districts.label_ar as district_ar, tbl_districts.label_en as district_en');
        $this->db->select('tbl_area.label_ar as area_ar, tbl_area.label_en as area_en');
        $this->db->from('tasks');
        $this->db->join('tbl_governorates', 'tbl_governorates.id = tasks.governorate_id', 'left');
        $this->db->join('tbl_districts', 'tbl_districts.id = tasks.district_id', 'left');
        $this->db->join('tbl_area', 'tbl_area.id = tasks.area_id', 'left');
        if($governorate_id != '' and $governorate_id!=0) {
            $this->db->where('tasks.governorate_id', $governorate_id);
        }
        if($district_id != '' and $district_id!=0) {
            $this->db->where('tasks.district_id', $district_id);
        }
        if($area_id != '' and $area_id!=0) {
            $this->db->where('tasks.area_id', $area_id);
        }
        if($category != '') {
            $this->db->where('tasks.category', $category);
        }
        if($assigne_to != '') {
            $this->db->where('tasks.assigne_to', $assigne_to);
        }
        if($year != '') {
            $this->db->where('tasks.year', $year);
        }
        if($type != '') {
            $this->db->where('tasks.type', $type);
        }

        $query = $this->db->get();
        return $query->result();
    }
    function GetTaskByActivityItemId($item_id,$salesman,$year)
    {

        $this->db->select('task_activities.*');
        $this->db->from('task_activities');
        $this->db->join('tasks', 'tasks.id = task_activities.task_id ', 'inner');
        $this->db->where('tasks.year', $year);
        $this->db->where('task_activities.item_id', $item_id);
        $this->db->where('task_activities.salesman_id', $salesman);
        $query = $this->db->get();
        return $query->row_array();
    }
    function GetTaskById($id)
    {
        $this->db->select('tasks.*');
        $this->db->select('tbl_governorates.label_ar as governorate_ar,tbl_governorates.label_en as governorate_en');
        $this->db->select('tbl_districts.label_ar as district_ar, tbl_districts.label_en as district_en');
        $this->db->select('tbl_area.label_ar as area_ar, tbl_area.label_en as area_en');
        $this->db->select('tbl_sales_man.fullname');
        $this->db->from('tasks');
        $this->db->join('tbl_governorates', 'tbl_governorates.id = tasks.governorate_id', 'left');
        $this->db->join('tbl_districts', 'tbl_districts.id = tasks.district_id', 'left');
        $this->db->join('tbl_area', 'tbl_area.id = tasks.area_id', 'left');
        $this->db->join('tbl_sales_man', 'tbl_sales_man.id = tasks.assigne_to', 'left');


            $this->db->where('tasks.id', $id);


        $query = $this->db->get();
        return $query->row_array();
    }
    function GetActivityTask($task_id,$item_id,$status,$category='company')
    {
        switch ($category) {
            case 'company':
                $this->db->select('tbl_company.name_ar as company_name_ar,tbl_company.name_en as company_name_en, tbl_company.copy_res as copy_res, tbl_company.is_adv as advertiser, tbl_sectors.label_ar as sector_ar, tbl_company.phone, tbl_company.street_ar, tbl_company.owner_name');
                $this->db->select('tbl_governorates.label_ar as governorate_ar');
                $this->db->select('tbl_governorates.label_en as governorate_en');
                $this->db->select('tbl_districts.label_ar as district_ar');
                $this->db->select('tbl_districts.label_en as district_en');
                $this->db->select('tbl_area.label_ar as area_ar');
                $this->db->select('tbl_area.label_en as area_en');
                $this->db->join('tbl_company', 'tbl_company.id = task_activities.item_id', 'left');
                $this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_company.governorate_id', 'left');
                $this->db->join('tbl_districts', 'tbl_districts.id = tbl_company.district_id', 'left');
                $this->db->join('tbl_area', 'tbl_area.id = tbl_company.area_id', 'left');
                $this->db->join('tbl_sectors', 'tbl_sectors.id = tbl_company.sector_id', 'left');
                break;
            case 'bank':
                echo "i equals 1";
                break;
            case 'importer':
                echo "i equals 2";
                break;
            case 'transport':
                echo "i equals 2";
                break;
            case 'insurance':
                echo "i equals 2";
                break;
        }
        $this->db->select('tasks.title as task_title');
        $this->db->select('task_activities.*');
        $this->db->select('tbl_sales_man.fullname');
        $this->db->from('task_activities');
        $this->db->join('tasks', 'tasks.id = task_activities.task_id', 'left');
        $this->db->join('tbl_sales_man', 'tbl_sales_man.id = task_activities.salesman_id', 'left');
        if($task_id != '' and $task_id!=0) {
            $this->db->where('task_activities.task_id', $task_id);
        }
        if($item_id != '' and $item_id!=0) {
            $this->db->where('task_activities.item_id', $item_id);
        }
        if($status != '') {
            $this->db->where('task_activities.status', $status);
        }
        $query = $this->db->get();
        return $query->result();
    }
    function GetAreaCompanies()
    {
        $this->db->select('tbl_area.*');
        $this->db->select('COUNT(tbl_company.id) as company_count');
        $this->db->from('tbl_area');
        $this->db->join('tbl_company', 'tbl_company.area_id = tbl_area.id', 'left');

        $this->db->group_by('tbl_area.id');
        $query = $this->db->get();
        return $query->result();
    }

    function GetGeoCompanies() {
        $this->db->select('COUNT(*) as company_count, tbl_company.governorate_id,tbl_company.district_id,tbl_company.area_id');
        $this->db->select('tbl_governorates.label_ar as governorate_ar');
        $this->db->select('tbl_governorates.label_en as governorate_en');
        $this->db->select('tbl_districts.label_ar as district_ar');
        $this->db->select('tbl_districts.label_en as district_en');
        $this->db->select('tbl_area.label_ar as area_ar');
        $this->db->select('tbl_area.label_en as area_en');
        $this->db->from('tbl_company');

        $this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_company.governorate_id', 'left');
        $this->db->join('tbl_districts', 'tbl_districts.id = tbl_company.district_id', 'left');
        $this->db->join('tbl_area', 'tbl_area.id = tbl_company.area_id', 'left');
       // $this->db->join('(SELECT id as task_id, status as task_status from tasks where year=YEAR(CURDATE()) as tbl_task)','tbl_task.area_id=tbl_area.id','left');
        $this->db->where('tbl_company.show_online', 1);
        $this->db->order_by('tbl_company.governorate_id', 'DESC');
        $this->db->order_by('tbl_company.district_id', 'DESC');
        $this->db->order_by('tbl_company.area_id', 'DESC');

        $this->db->group_by('tbl_company.area_id');
        $query = $this->db->get();
        return $query->result();
    }
    function GetGeoCompaniesByArea($governorate,$district,$area) {
        $this->db->select('COUNT(*) as company_count, tbl_company.governorate_id,tbl_company.district_id,tbl_company.area_id');
        $this->db->select('tbl_governorates.label_ar as governorate_ar');
        $this->db->select('tbl_governorates.label_en as governorate_en');
        $this->db->select('tbl_districts.label_ar as district_ar');
        $this->db->select('tbl_districts.label_en as district_en');
        $this->db->select('tbl_area.label_ar as area_ar');
        $this->db->select('tbl_area.label_en as area_en');
        $this->db->from('tbl_company');

        $this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_company.governorate_id', 'left');
        $this->db->join('tbl_districts', 'tbl_districts.id = tbl_company.district_id', 'left');
        $this->db->join('tbl_area', 'tbl_area.id = tbl_company.area_id', 'left');
        // $this->db->join('(SELECT id as task_id, status as task_status from tasks where year=YEAR(CURDATE()) as tbl_task)','tbl_task.area_id=tbl_area.id','left');
        if($governorate!='' and $governorate!=0) {
            $this->db->where('tbl_company.governorate_id', $governorate);
        }
        if($district!='' and $district!=0) {
            $this->db->where('tbl_company.district_id', $district);
        }
        if($area!='' and $area!=0) {
            $this->db->where('tbl_company.area_id', $area);
        }
        $this->db->where('tbl_company.show_online', 1);
        $this->db->order_by('tbl_company.governorate_id', 'DESC');
        $this->db->order_by('tbl_company.district_id', 'DESC');
        $this->db->order_by('tbl_company.area_id', 'DESC');

        $this->db->group_by('tbl_company.area_id');
        $query = $this->db->get();
        return $query->result();
    }
    function GetApplicationsByCompany($id) {
        $this->db->select('posting_companies.*');
        $this->db->select('tbl_governorates.label_ar as governorate_ar');
        $this->db->select('tbl_governorates.label_en as governorate_en');
        $this->db->select('tbl_districts.label_ar as district_ar');
        $this->db->select('tbl_districts.label_en as district_en');
        $this->db->select('tbl_area.label_ar as area_ar');
        $this->db->select('tbl_area.label_en as area_en');
        $this->db->select('tbl_license_sources.label_ar as license_source_ar');
        $this->db->select('tbl_license_sources.label_en as license_source_en');
        $this->db->select('tbl_company_type.label_ar as company_type_ar');
        $this->db->select('tbl_company_type.label_en as company_type_en');
        $this->db->from('posting_companies');
        $this->db->join('tbl_governorates', 'tbl_governorates.id = posting_companies.governorate_id', 'left');
        $this->db->join('tbl_districts', 'tbl_districts.id = posting_companies.district_id', 'left');
        $this->db->join('tbl_area', 'tbl_area.id = posting_companies.area_id', 'left');
        $this->db->join('tbl_license_sources', 'tbl_license_sources.id = posting_companies.license_source_id', 'left');
        $this->db->join('tbl_company_type', 'tbl_company_type.id = posting_companies.company_type_id', 'left');
        $this->db->where('posting_companies.company_id', $id);
        $this->db->order_by('posting_companies.id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function GetApplicationById($id) {
        $this->db->select('posting_companies.*');
        $this->db->select('tbl_governorates.label_ar as governorate_ar');
        $this->db->select('tbl_governorates.label_en as governorate_en');
        $this->db->select('tbl_districts.label_ar as district_ar');
        $this->db->select('tbl_districts.label_en as district_en');
        $this->db->select('tbl_area.label_ar as area_ar');
        $this->db->select('tbl_area.label_en as area_en');
        $this->db->select('tbl_license_sources.label_ar as license_source_ar');
        $this->db->select('tbl_license_sources.label_en as license_source_en');
        $this->db->select('tbl_company_type.label_ar as company_type_ar');
        $this->db->select('tbl_company_type.label_en as company_type_en');
        $this->db->select('tbl_industrial_room.label_ar as iro_ar');
        $this->db->select('tbl_industrial_room.label_en as iro_en');
        $this->db->select('tbl_industrial_group.label_ar as igr_ar');
        $this->db->select('tbl_industrial_group.label_en as igr_en');
        $this->db->select('tbl_economical_assembly.label_ar as eas_ar');
        $this->db->select('tbl_economical_assembly.label_en as eas_en');

        $this->db->from('posting_companies');
        $this->db->join('tbl_governorates', 'tbl_governorates.id = posting_companies.governorate_id', 'left');
        $this->db->join('tbl_districts', 'tbl_districts.id = posting_companies.district_id', 'left');
        $this->db->join('tbl_area', 'tbl_area.id = posting_companies.area_id', 'left');
        $this->db->join('tbl_license_sources', 'tbl_license_sources.id = posting_companies.license_source_id', 'left');
        $this->db->join('tbl_company_type', 'tbl_company_type.id = posting_companies.company_type_id', 'left');
        $this->db->join('tbl_industrial_room', 'tbl_industrial_room.id = posting_companies.iro_code', 'left');
        $this->db->join('tbl_industrial_group', 'tbl_industrial_group.id = posting_companies.igr_code', 'left');
        $this->db->join('tbl_economical_assembly', 'tbl_economical_assembly.id = posting_companies.eas_code', 'left');
        $this->db->where('posting_companies.id', $id);
        $this->db->order_by('posting_companies.id', 'DESC');
        $query = $this->db->get();
        return $query->row_array();
    }

    function GetIndustrialCompanies($copy_res = '', $is_adv = '', $row, $limit) {
        $this->db->select('tbl_company.*');
        //$this->db->select('tbl_company_type.label_en as type_en');
        //$this->db->select('tbl_company_type.label_ar as type_ar');
        $this->db->from('tbl_company');
        //$this->db->join('tbl_company_type', 'tbl_company_type.id = tbl_company.company_type_id', 'inner');
        if($copy_res != '')
            $this->db->where('tbl_company.copy_res', $copy_res);
        if($is_adv != '')
            $this->db->where('tbl_company.is_adv', $is_adv);
        $this->db->order_by('tbl_company.id', 'DESC');
        if($limit != 0)
            $this->db->limit($limit, $row);
        $query = $this->db->get();
        return $query->result();
    }

    function GetStatementsIDs($year) {
        $this->db->select('tbl_companies_statements.*');
        $this->db->select('tbl_company.name_en,tbl_company.name_ar');
        $this->db->from('tbl_companies_statements');
        $this->db->join('tbl_company', 'tbl_company.id = tbl_companies_statements.company_id', 'inner');
        $this->db->where('tbl_companies_statements.year', $year);
        $this->db->group_by("tbl_companies_statements.company_id");
        $query = $this->db->get();
        return $query->result();
    }

    function GetStatementsByCompanyId($cid) {
        $this->db->select('tbl_companies_statements.*');
        $this->db->select('users.username, users.fullname');
        $this->db->from('tbl_companies_statements');
        $this->db->join('users', 'users.id = tbl_companies_statements.user_id', 'left');
        $this->db->where('tbl_companies_statements.company_id', $cid);
        $this->db->order_by('tbl_companies_statements.year', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function GetStatementById($id) {
        $this->db->select('tbl_companies_statements.*');
        $this->db->select('users.username, users.fullname');
        $this->db->from('tbl_companies_statements');
        $this->db->join('users', 'users.id = tbl_companies_statements.user_id', 'left');
        $this->db->where('tbl_companies_statements.id', $id);
        $this->db->order_by('tbl_companies_statements.year', 'DESC');
        $query = $this->db->get();
        return $query->row_array();
    }

    function GetScanningCompanies($array_ids, $gov, $district, $area, $row, $limit) {
        $this->db->select('tbl_company.*');
        if($gov != '' and $gov != 0) {
            $this->db->select('tbl_governorates.label_ar as governorate_ar');
            $this->db->select('tbl_governorates.label_en as governorate_en');
        }
        if($district != '' and $district != 0) {
            $this->db->select('tbl_districts.label_ar as district_ar');
            $this->db->select('tbl_districts.label_en as district_en');
        }
        if($area != '' and $area != 0) {
            $this->db->select('tbl_area.label_ar as area_ar');
            $this->db->select('tbl_area.label_en as area_en');
        }
        $this->db->from('tbl_company');
        if(count($array_ids) > 0) {
            $this->db->where_in('tbl_company.id', $array_ids);
        }
        if($gov != '' and $gov != 0) {
            $this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_company.governorate_id', 'left');
            $this->db->where('tbl_company.governorate_id', $gov);
        }
        if($district != '' and $district != 0) {
            $this->db->join('tbl_districts', 'tbl_districts.id = tbl_company.district_id', 'left');
            $this->db->where('tbl_company.district_id', $district);
        }
        if($area != '' and $area != 0) {
            $this->db->join('tbl_area', 'tbl_area.id = tbl_company.area_id', 'left');

            $this->db->where('tbl_company.area_id', $area);
        }
        if($gov != '' and $gov != 0) {
            $this->db->order_by('governorate_en', 'ASC');
        }
        if($district != '' and $district != 0) {
            $this->db->order_by('district_en', 'ASC');
        }
        if($area != '' and $area != 0) {
            $this->db->order_by('area_en', 'ASC');
        }
        $this->db->order_by('tbl_company.id', 'DESC');
        if($limit != 0)
            $this->db->limit($limit, $row);
        $query = $this->db->get();
        return $query->result();
    }

    function GetStatementsCompanies($array_ids, $gov, $district, $area, $row, $limit) {
        $this->db->select('tbl_company.*');
        if($gov != '' and $gov != 0) {
            $this->db->select('tbl_governorates.label_ar as governorate_ar');
            $this->db->select('tbl_governorates.label_en as governorate_en');
        }
        if($district != '' and $district != 0) {
            $this->db->select('tbl_districts.label_ar as district_ar');
            $this->db->select('tbl_districts.label_en as district_en');
        }
        if($area != '' and $area != 0) {
            $this->db->select('tbl_area.label_ar as area_ar');
            $this->db->select('tbl_area.label_en as area_en');
        }
        $this->db->from('tbl_company');
        if(count($array_ids) > 0) {
            $this->db->where_not_in('tbl_company.id', $array_ids);
        }
        if($gov != '' and $gov != 0) {
            $this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_company.governorate_id', 'left');
            $this->db->where('tbl_company.governorate_id', $gov);
        }
        if($district != '' and $district != 0) {
            $this->db->join('tbl_districts', 'tbl_districts.id = tbl_company.district_id', 'left');
            $this->db->where('tbl_company.district_id', $district);
        }
        if($area != '' and $area != 0) {
            $this->db->join('tbl_area', 'tbl_area.id = tbl_company.area_id', 'left');

            $this->db->where('tbl_company.area_id', $area);
        }
        if($gov != '' and $gov != 0) {
            $this->db->order_by('governorate_en', 'ASC');
        }
        if($district != '' and $district != 0) {
            $this->db->order_by('district_en', 'ASC');
        }
        if($area != '' and $area != 0) {
            $this->db->order_by('area_en', 'ASC');
        }
        $this->db->order_by('tbl_company.id', 'DESC');
        if($limit != 0)
            $this->db->limit($limit, $row);
        $query = $this->db->get();
        return $query->result();
    }

    function GetGovernorateByName($name) {
        $this->db->select('tbl_governorates.*');
        $this->db->from('tbl_governorates');
        $this->db->where('tbl_governorates.label_ar', $name);
        $query = $this->db->get();
        return $query->row_array();
    }

    function GetDistrictByName($name) {
        $this->db->select('tbl_districts.*');
        $this->db->from('tbl_districts');
        $this->db->where('tbl_districts.label_ar', $name);
        $query = $this->db->get();
        return $query->row_array();
    }

    function GetAreaByName($name) {
        $this->db->select('tbl_area.*');
        $this->db->from('tbl_area');
        $this->db->where('tbl_area.label_ar', $name);
        $query = $this->db->get();
        return $query->row_array();
    }
function GetCompaniesNoTIn($array)
{
    $this->db->select('tbl_company.*');
    $this->db->select('tbl_governorates.label_ar as governorate_ar');
    $this->db->select('tbl_governorates.label_en as governorate_en');
    $this->db->select('tbl_districts.label_ar as district_ar');
    $this->db->select('tbl_districts.label_en as district_en');
    $this->db->select('tbl_area.label_ar as area_ar');
    $this->db->select('tbl_area.label_en as area_en');
    $this->db->from('tbl_company');
    $this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_company.governorate_id', 'left');
    $this->db->join('tbl_districts', 'tbl_districts.id = tbl_company.district_id', 'left');
    $this->db->join('tbl_area', 'tbl_area.id = tbl_company.area_id', 'left');
if(count($array) >0){
    $this->db->where_not_in('tbl_company.id', $array);
}


$this->db->order_by('tbl_company.id', 'DESC');
$query = $this->db->get();
return $query->result();
}
    function GetTaskCompanies($id, $name, $activity, $phone, $status = '', $gov, $district, $area, $row, $limit,$data_type,$sales_man_id) {
        $this->db->select('tbl_company.*');
        //$this->db->select('tbl_company_type.label_en as type_en');
        //$this->db->select('tbl_company_type.label_ar as type_ar');
        if($gov != '' and $gov != 0) {
            $this->db->select('tbl_governorates.label_ar as governorate_ar');
            $this->db->select('tbl_governorates.label_en as governorate_en');
        }
        if($district != '' and $district != 0) {
            $this->db->select('tbl_districts.label_ar as district_ar');
            $this->db->select('tbl_districts.label_en as district_en');
        }
        if($area != '' and $area != 0) {
            $this->db->select('tbl_area.label_ar as area_ar');
            $this->db->select('tbl_area.label_en as area_en');
        }
       // $this->db->select('COUNT(tbl_company_heading.id) as CNbr');
        $this->db->from('tbl_company');
        // $this->db->join('tbl_company_heading', 'tbl_company_heading.company_id = tbl_company.id', 'left');
        $this->db->join('tbl_company_branches', 'tbl_company_branches.company_id = tbl_company.id', 'left');
        if($id != '')
            $this->db->where('tbl_company.id', $id);
      
        if($name != '') {
            $where1 = "( tbl_company.name_ar LIKE '%$name%' OR tbl_company.name_en LIKE '%$name%')";
            //$this->db->like('tbl_company.name_ar',$name);
            //$this->db->or_like('tbl_company.name_en',$name);
            $this->db->where($where1);
        }
        if($activity != '') {
            $where2 = "( tbl_company.activity_ar LIKE '%$activity%' OR tbl_company.activity_ar LIKE '%$activity%')";
            $this->db->where($where2);
        }
         
        if($phone != '') {
            $this->db->or_like('tbl_company.phone', $phone);
        }

        if($gov != '' and $gov != 0) {
            $this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_company.governorate_id', 'left');

            //$this->db->where('tbl_company.governorate_id', $gov);
            $this->db->where('(tbl_company.governorate_id='.$gov.' OR tbl_company_branches.governorate_id='.$gov.')');
        }
        if($district != '' and $district != 0) {
            $this->db->join('tbl_districts', 'tbl_districts.id = tbl_company.district_id', 'left');
            
            //$this->db->where('tbl_company.district_id', $district);
            $this->db->where('(tbl_company.district_id='.$district.' OR tbl_company_branches.district_id='.$district.')');
        }
        if($area != '' and $area != 0) {
            $this->db->join('tbl_area', 'tbl_area.id = tbl_company.area_id', 'left');

            $this->db->where('(tbl_company.area_id='.$area.' OR tbl_company_branches.area_id='.$area.')');
        }
        if($status != 'all')
            $this->db->where('tbl_company.status', $status);
			
		if($data_type!='all')
		{
		    if($data_type=='is_adv')
		    {
		      $this->db->where('tbl_company.is_adv', 1);	   
		    }
		    elseif($data_type=='copy_res')
		    {
		    $this->db->where('tbl_company.copy_res', 1);    
		    }
		    elseif($data_type=='adv_copy')
		    {
		        $this->db->where('(tbl_company.is_adv=1 AND tbl_company.copy_res=1)'); 
		    }
		     elseif($data_type=='adv_or_copy')
		    {
		        $this->db->where('(tbl_company.is_adv=1 OR tbl_company.copy_res=1)'); 
		    }
		    
           
        }
        if($sales_man_id != '') {
            $this->db->where('tbl_company.sales_man_id', $sales_man_id);
        }
        if($gov != '' and $gov != 0) {
            $this->db->order_by('governorate_en', 'ASC');
        }
        if($district != '' and $district != 0) {
            $this->db->order_by('district_en', 'ASC');
        }
        if($area != '' and $area != 0) {
            $this->db->order_by('area_en', 'ASC');
        }
        $this->db->group_by('tbl_company.id');
        $this->db->order_by('tbl_company.street_ar', 'ASC');
        $this->db->order_by('tbl_company.id', 'DESC');
        if($limit != 0)
            $this->db->limit($limit, $row);
        $query = $this->db->get();
        return $query->result();
    }
    function SearchCompanies($id, $name, $activity, $phone, $status = '', $gov, $district, $area, $row, $limit,$reservation=FALSE,$ad=FALSE,$ministry_id=FALSE) {
        $this->db->select('tbl_company.*');
        //$this->db->select('tbl_company_type.label_en as type_en');
        //$this->db->select('tbl_company_type.label_ar as type_ar');
        if($gov != '' and $gov != 0) {
            $this->db->select('tbl_governorates.label_ar as governorate_ar');
            $this->db->select('tbl_governorates.label_en as governorate_en');
        }
        if($district != '' and $district != 0) {
            $this->db->select('tbl_districts.label_ar as district_ar');
            $this->db->select('tbl_districts.label_en as district_en');
        }
        if($area != '' and $area != 0) {
            $this->db->select('tbl_area.label_ar as area_ar');
            $this->db->select('tbl_area.label_en as area_en');
        }
        $this->db->from('tbl_company');
        $this->db->where('tbl_company.error_address', 0);
        $this->db->where('tbl_company.is_closed', 0);
        $this->db->join('tbl_company_branches', 'tbl_company_branches.company_id = tbl_company.id', 'left');
        if($id != '')
            $this->db->where('tbl_company.id', $id);
        if($ministry_id != '')
            $this->db->where('tbl_company.ministry_id', $ministry_id);
        if($name != '') {
            $where1 = "( tbl_company.name_ar LIKE '%$name%' OR tbl_company.name_en LIKE '%$name%')";
            //$this->db->like('tbl_company.name_ar',$name);
            //$this->db->or_like('tbl_company.name_en',$name);
            $this->db->where($where1);
        }
        if($activity != '') {
            $where2 = "( tbl_company.activity_ar LIKE '%$activity%' OR tbl_company.activity_ar LIKE '%$activity%')";
            $this->db->where($where2);
        }
        if($phone != '') {
            $this->db->or_like('tbl_company.phone', $phone);
        }

        if($gov != '' and $gov != 0) {
            $this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_company.governorate_id', 'left');

            //$this->db->where('tbl_company.governorate_id', $gov);
            $this->db->where('(tbl_company.governorate_id='.$gov.' OR tbl_company_branches.governorate_id='.$gov.')');
        }
        if($district != '' and $district != 0) {
            $this->db->join('tbl_districts', 'tbl_districts.id = tbl_company.district_id', 'left');
            
            //$this->db->where('tbl_company.district_id', $district);
            $this->db->where('(tbl_company.district_id='.$district.' OR tbl_company_branches.district_id='.$district.')');
        }
        if($area != '' and $area != 0) {
            $this->db->join('tbl_area', 'tbl_area.id = tbl_company.area_id', 'left');

            $this->db->where('(tbl_company.area_id='.$area.' OR tbl_company_branches.area_id='.$area.')');
        }
        if($status != 'all')
            $this->db->where('tbl_company.status', $status);
			
		if($reservation)
            $this->db->where('tbl_company.copy_res', $reservation);
		if($ad)
            $this->db->where('tbl_company.is_adv', $ad);	
        if($gov != '' and $gov != 0) {
            $this->db->order_by('governorate_en', 'ASC');
        }
        if($district != '' and $district != 0) {
            $this->db->order_by('district_en', 'ASC');
        }
        if($area != '' and $area != 0) {
            $this->db->order_by('area_en', 'ASC');
        }
        $this->db->group_by('tbl_company.id');
        $this->db->order_by('tbl_company.street_ar', 'ASC');
        $this->db->order_by('tbl_company.id', 'DESC');
        if($limit != 0)
            $this->db->limit($limit, $row);
        $query = $this->db->get();
        return $query->result();
    }
    function GetDuplicateName()
{

        $this->db->select('tbl_company.*, COUNT(tbl_company.name_ar) as c');
        $this->db->select('tbl_governorates.label_ar as governorate_ar');
            $this->db->select('tbl_governorates.label_en as governorate_en');
            $this->db->select('tbl_districts.label_ar as district_ar');
            $this->db->select('tbl_districts.label_en as district_en');

            $this->db->select('tbl_area.label_ar as area_ar');
            $this->db->select('tbl_area.label_en as area_en');
        $this->db->from('tbl_company');
    $this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_company.governorate_id', 'left');
    $this->db->join('tbl_districts', 'tbl_districts.id = tbl_company.district_id', 'left');
    $this->db->join('tbl_area', 'tbl_area.id = tbl_company.area_id', 'left');

        $this->db->group_by('tbl_company.name_ar');
        $this->db->having('c >',1);
        $this->db->order_by('c', 'DESC');

        $query = $this->db->get();
        return $query->result();
}

    function GetCompaniesWithoutId() {
        $this->db->select('tbl_company.*');
               $this->db->select('tbl_governorates.label_ar as governorate_ar');
            $this->db->select('tbl_governorates.label_en as governorate_en');
            $this->db->select('tbl_districts.label_ar as district_ar');
            $this->db->select('tbl_districts.label_en as district_en');

            $this->db->select('tbl_area.label_ar as area_ar');
            $this->db->select('tbl_area.label_en as area_en');
        $this->db->from('tbl_company');

            $this->db->where('tbl_company.ministry_id <=', 0);


        $this->db->order_by('tbl_company.id', 'DESC');

        $query = $this->db->get();
        return $query->result();
    }
    function SearchCompaniesArea($id, $name, $activity, $phone, $status = '', $gov, $district, $area, $row, $limit,$reservation=FALSE,$ad=FALSE,$ministry_id=FALSE) {
        $this->db->select('tbl_company.*');
        //$this->db->select('tbl_company_type.label_en as type_en');
        //$this->db->select('tbl_company_type.label_ar as type_ar');
        if($gov != '' and $gov != 0) {
            $this->db->select('tbl_governorates.label_ar as governorate_ar');
            $this->db->select('tbl_governorates.label_en as governorate_en');
        }
        if($district != '' and $district != 0) {
            $this->db->select('tbl_districts.label_ar as district_ar');
            $this->db->select('tbl_districts.label_en as district_en');
        }
        if($area != '' and $area != 0) {
            $this->db->select('tbl_area.label_ar as area_ar');
            $this->db->select('tbl_area.label_en as area_en');
        }
        $this->db->from('tbl_company');
        $this->db->where('tbl_company.area_id', null);
        if($id != '')
            $this->db->where('tbl_company.id', $id);
        if($ministry_id != '')
            $this->db->where('tbl_company.ministry_id', $ministry_id);
        if($name != '') {
            $where1 = "( tbl_company.name_ar LIKE '%$name%' OR tbl_company.name_en LIKE '%$name%')";
            //$this->db->like('tbl_company.name_ar',$name);
            //$this->db->or_like('tbl_company.name_en',$name);
            $this->db->where($where1);
        }
        if($activity != '') {
            $where2 = "( tbl_company.activity_ar LIKE '%$activity%' OR tbl_company.activity_ar LIKE '%$activity%')";
            $this->db->where($where2);
        }
        if($phone != '') {
            $this->db->or_like('tbl_company.phone', $phone);
        }

        if($gov != '' and $gov != 0) {
            $this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_company.governorate_id', 'left');

            $this->db->where('tbl_company.governorate_id', $gov);
        }
        if($district != '' and $district != 0) {
            $this->db->join('tbl_districts', 'tbl_districts.id = tbl_company.district_id', 'left');

            $this->db->where('tbl_company.district_id', $district);
        }
        if($area != '' and $area != 0) {
            $this->db->join('tbl_area', 'tbl_area.id = tbl_company.area_id', 'left');

           // $this->db->where('tbl_company.area_id', $area);
        }
        if($status != 'all')
            $this->db->where('tbl_company.status', $status);

        if($reservation)
            $this->db->where('tbl_company.copy_res', $reservation);
        if($ad)
            $this->db->where('tbl_company.is_adv', $ad);
        if($gov != '' and $gov != 0) {
            $this->db->order_by('governorate_en', 'ASC');
        }
        if($district != '' and $district != 0) {
            $this->db->order_by('district_en', 'ASC');
        }
        if($area != '' and $area != 0) {
            $this->db->order_by('area_en', 'ASC');
        }
        $this->db->order_by('tbl_company.id', 'DESC');
        if($limit != 0)
            $this->db->limit($limit, $row);
        $query = $this->db->get();
        return $query->result();
    }

    function AdvancedSearchCompanies($id, $name, $activity, $phone, $row, $limit) {
        $this->db->select('tbl_company.*');
        //$this->db->select('tbl_company_type.label_en as type_en');
        //$this->db->select('tbl_company_type.label_ar as type_ar');
        $this->db->from('tbl_company');
        //$this->db->join('tbl_company_type', 'tbl_company_type.id = tbl_company.company_type_id', 'inner');
        if($id != '')
            $this->db->where('tbl_company.id', $id);
        if($name != '') {
            $where1 = "( tbl_company.name_ar LIKE '%$name%' OR tbl_company.name_en LIKE '%$name%')";
            //$this->db->like('tbl_company.name_ar',$name);
            //$this->db->or_like('tbl_company.name_en',$name);
            $this->db->where($where1);
        }
        if($activity != '') {
            $where2 = "( tbl_company.activity_ar LIKE '%$activity%' OR tbl_company.activity_ar LIKE '%$activity%')";

            //$this->db->like('tbl_company.activity_ar',$activity);
            //$this->db->like('tbl_company.activity_en',$activity);
            $this->db->where($where2);
        }
        $this->db->like('tbl_company.phone', $phone);
        $this->db->order_by('tbl_company.id', 'DESC');
        if($limit != 0)
            $this->db->limit($limit, $row);
        $query = $this->db->get();
        return $query->result();
    }

    function SearchProductions($code, $description, $row = 0, $limit = 0) {
        $this->db->select('tbl_heading.*');
        $this->db->from('tbl_heading');
        if($code != '') {
            $where1 = "( tbl_heading.hs_code LIKE '%$code%' OR tbl_heading.hs_code_print LIKE '%$code%')";
            $this->db->where($where1);
        }
        if($description != '') {
            //	$where2 = "( tbl_heading.label_ar LIKE '%$description%' OR tbl_heading.label_en LIKE '%$description%' OR tbl_heading.description_ar LIKE '%$description%' OR tbl_heading.description_en LIKE '%$description%')";
            $where2 = "(tbl_heading.description_ar LIKE '%$description%' OR tbl_heading.description_en LIKE '%$description%')";

            $this->db->where($where2);
        }
        if($limit != 0)
            $this->db->limit($limit, $row);
        $query = $this->db->get();
        return $query->result();
    }

    function GetAdvertisingCompanies($ad = '', $row, $limit) {
        $this->db->select('tbl_company.*');
        $this->db->from('tbl_company');
        if($ad != '')
            $this->db->where('tbl_company.is_adv', $ad);
        $this->db->order_by('tbl_company.id', 'DESC');
        if($limit != 0)
            $this->db->limit($limit, $row);
        $query = $this->db->get();
        return $query->result();
    }

    function GetReservationsCompanies($reservation = '', $row, $limit) {
        $this->db->select('tbl_company.*');
        $this->db->from('tbl_company');
        if($reservation != '')
            $this->db->where('tbl_company.copy_res', $reservation);
        $this->db->order_by('tbl_company.id', 'DESC');
        if($limit != 0)
            $this->db->limit($limit, $row);
        $query = $this->db->get();
        return $query->result();
    }

function GetFMinistryCompanies($name,$phone,$id) {
    $this->db->select('tbl_company.*');
    $this->db->from('tbl_company');

    if($name != '') {
        //$where1 = "( tbl_company.name_ar LIKE '%$name%')";
        //$this->db->where($where1);
        $this->db->like('tbl_company.name_ar', $name);
    }
/*
    if($phone!='') {
        $this->db->like('tbl_company.phone', $phone);
    }

*/
    $this->db->where('tbl_company.id !=', $id);
    $this->db->order_by('tbl_company.id', 'DESC');

    $query = $this->db->get();
    return $query->result();
    }
    function GetAllMinistryCompanies($row,$limit) {
        $this->db->select('ministry_industry.*');
        $this->db->from('ministry_industry');
        $this->db->order_by('ministry_industry.id', 'ASC');

        if($limit != 0)
            $this->db->limit($limit, $row);
        $query = $this->db->get();
        return $query->result();
    }
    function GetAllMinistry($row,$limit) {
        $this->db->select('ministry_company.*');
        $this->db->from('ministry_company');
        $this->db->order_by('ministry_company.origin', 'DESC');
        $this->db->order_by('ministry_company.investment', 'DESC');
        if($limit != 0)
            $this->db->limit($limit, $row);
        $query = $this->db->get();
        return $query->result();
    }
    function GetMinistryById($id) {
        $this->db->select('ministry_company.*');
        $this->db->from('ministry_company');
        $this->db->where('ministry_company.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
    function GetMinistryReport($id) {
        $this->db->select('ministry_reports.*');
        $this->db->from('ministry_reports');
        $this->db->where('ministry_reports.ministry_id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
    function GetMinistryCompanyById($id) {
        $this->db->select('ministry_industry.*');
        $this->db->from('ministry_industry');
        $this->db->where('ministry_industry.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
	function GetCompaniesByMinistry($phone1,$phone2,$phone3,$mobile1,$mobile2) {
        $this->db->select('tbl_company.*');
        $this->db->from('tbl_company');

         if($phone1 != '') {
            $this->db->like('tbl_company.phone', $phone1);
        }
		if($phone2 != '') {
            $this->db->or_like('tbl_company.phone', $phone2);
        }
		if($phone3 != '') {
            $this->db->or_like('tbl_company.phone', $phone3);
        }
		if($mobile1 != '') {
            $this->db->or_like('tbl_company.phone', $mobile1);
        }
		if($mobile2 != '') {
            $this->db->or_like('tbl_company.phone', $mobile2);
        }

        
        $this->db->order_by('tbl_company.id', 'DESC');
       
        $query = $this->db->get();
        return $query->result();
    }
 

    function GetCompanies($status = '', $row, $limit,$reservation=FALSE,$ad=FALSE) {
        $this->db->select('tbl_company.*',false);
        $this->db->from('tbl_company');
		if($reservation){
            $this->db->where('tbl_company.copy_res', $reservation);
		}
		if($ad)
		{
            $this->db->where('tbl_company.is_adv', $ad);	
		}
        //$this->db->join('tbl_company_type', 'tbl_company_type.id = tbl_company.company_type_id', 'inner');
        //if($status!='')
        //$this->db->where('tbl_company.status',$status);
        $this->db->order_by('tbl_company.id', 'DESC');
        if($limit != 0)
        {
            $this->db->limit($limit, $row);
        }
        
        
        $query = $this->db->get();
        $res= $query->result();
        
        return $res;
       // return [];
    }
     function GetSCompanies($q = '', $row, $limit) {
        $this->db->select('tbl_company.*');
        $this->db->from('tbl_company');
		if($q!='')
            $this->db->like('tbl_company.email', $q);	
        
        $this->db->order_by('tbl_company.id', 'DESC');
        if($limit != 0)
            $this->db->limit($limit, $row);
        $query = $this->db->get();
        return $query->result();
    }

    function GetCompanyById($id) {
        $this->db->select('tbl_company.*');
        $this->db->select('tbl_company_type.label_en as type_en');
        $this->db->select('tbl_company_type.label_ar as type_ar');
        //$this->db->select('tbl_sales_man.id as sales_man_id2');
        $this->db->from('tbl_company');
        $this->db->join('tbl_company_type', 'tbl_company_type.id = tbl_company.company_type_id', 'left');
       // $this->db->join('tbl_sales_man', 'tbl_sales_man.id = tbl_company.sales_man_id', 'left');
        $this->db->where('tbl_company.id', $id);
        $query = $this->db->get();      
        return $query->row_array();
    }

    function GetEconomicalAssembly($status = '') {
        $this->db->select('tbl_economical_assembly.*');
        $this->db->from('tbl_economical_assembly');
        if($status != '')
            $this->db->where('tbl_economical_assembly.status', $status);
        $query = $this->db->get();
        return $query->result();
    }

    function GetCompanyTypes($status = '') {
        $this->db->select('tbl_company_type.*');
        $this->db->from('tbl_company_type');
        if($status != '')
            $this->db->where('tbl_company_type.status', $status);
        $query = $this->db->get();
        return $query->result();
    }

    function GetCompanyTypeById($id) {
        $this->db->select('tbl_company_type.*');
        $this->db->from('tbl_company_type');
        $this->db->where('tbl_company_type.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    function SearchPosition($status = '', $description) {
        $this->db->select('tbl_positions.*');
        $this->db->from('tbl_positions');
        if($description != '') {
            $this->db->like('tbl_positions.label_en', $description);
            $this->db->or_like('tbl_positions.label_ar', $description);
        }

        if($status != '')
            $this->db->like('tbl_positions.status', $status);

        $query = $this->db->get();
        return $query->result();
    }

    function GetSubHeading($status = '', $row, $limit) {
        $this->db->select('tbl_subhead.*');
        $this->db->from('tbl_subhead');
        if($status != '')
            $this->db->where('tbl_subhead.status', $status);
        $this->db->order_by('tbl_subhead.code', 'ASC');
        if($limit != 0)
            $this->db->limit($limit, $row);
        $query = $this->db->get();
        return $query->result();
    }

    function SearchSubHeading($status, $code, $description) {
        $this->db->select('tbl_subhead.*');
        $this->db->from('tbl_subhead');
        if($description != '') {
            $this->db->like('tbl_subhead.title_en', $description);
            $this->db->or_like('tbl_subhead.title_ar', $description);
        }

        if($status != '')
            $this->db->like('tbl_subhead.status', $status);
        if($code != '')
            $this->db->like('tbl_subhead.code', $code);
        $this->db->order_by('tbl_subhead.code', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function GetSector($status = '', $row, $limit) {
        $this->db->select('tbl_sectors.*');
        $this->db->from('tbl_sectors');
        if($status != '')
            $this->db->where('tbl_sectors.status', $status);
        $this->db->order_by('tbl_sectors.label_en', 'ASC');
        if($limit != 0)
            $this->db->limit($limit, $row);
        $query = $this->db->get();
        return $query->result();
    }

    function SearchSector($status, $description) {
        $this->db->select('tbl_sectors.*');
        $this->db->from('tbl_sectors');
        if($description != '') {
            $this->db->like('tbl_sectors.label_en', $description);
            $this->db->or_like('tbl_sectors.label_ar', $description);
            $this->db->or_like('tbl_sectors.intro_ar', $description);
            $this->db->or_like('tbl_sectors.intro_en', $description);
        }

        if($status != '')
            $this->db->like('tbl_sectors.status', $status);
        $this->db->order_by('tbl_sectors.label_en', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function GetSection($status = '', $row, $limit) {
        $this->db->select('tbl_section.*');
        $this->db->select('tbl_sectors.label_ar as sector_ar');
        $this->db->select('tbl_sectors.label_en as sector_en');
        $this->db->select('tbl_sectors.label_en as sector_en');
        $this->db->from('tbl_section');
        $this->db->join('tbl_sectors', 'tbl_sectors.id = tbl_section.sector_id', 'inner');
        if($status != '')
            $this->db->where('tbl_section.status', $status);
        $this->db->order_by('tbl_section.label_en', 'ASC');
        if($limit != 0)
            $this->db->limit($limit, $row);
        $query = $this->db->get();
        return $query->result();
    }

    function GetSectionsBySectorId($status = '', $sector) {
        $this->db->select('tbl_section.*');
        $this->db->select('tbl_sectors.label_ar as sector_ar');
        $this->db->select('tbl_sectors.label_en as sector_en');
        $this->db->from('tbl_section');
        $this->db->join('tbl_sectors', 'tbl_sectors.id = tbl_section.sector_id', 'inner');
        if($status != '')
            $this->db->where('tbl_section.status', $status);
        if($sector != 0)
            $this->db->where('tbl_section.sector_id', $sector);
        $this->db->order_by('tbl_section.label_en', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function SearchSection($status, $description, $sector) {
        $this->db->select('tbl_section.*');
        $this->db->select('tbl_sectors.label_ar as sector_ar');
        $this->db->select('tbl_sectors.label_en as sector_en');
        $this->db->from('tbl_section');
        $this->db->join('tbl_sectors', 'tbl_sectors.id = tbl_section.sector_id', 'inner');
        if($sector != 0)
            $this->db->where('tbl_section.sector_id', $sector);
        if($description != '') {
            //$this->db->like("(tbl_section.label_en=".$description." OR tbl_section.label_ar=".$description.")", NULL, FALSE);
            //$this->db->or_like('tbl_section.label_ar',$description);
            $where = "( tbl_section.label_en LIKE '%$description%' OR tbl_section.label_ar LIKE '%$description%')";
            $this->db->where($where);
        }

        if($status != '')
            $this->db->like('tbl_section.status', $status);

        $this->db->order_by('tbl_section.label_en', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function GetChapter($status = '', $row, $limit) {
        $this->db->select('tbl_chapter.*');
        $this->db->select('tbl_section.label_ar as section_ar');
        $this->db->select('tbl_section.label_en as section_en');
        $this->db->select('tbl_section.sector_id as sector_id');
        $this->db->from('tbl_chapter');
        $this->db->join('tbl_section', 'tbl_section.id = tbl_chapter.section_id', 'inner');
        if($status != '')
            $this->db->where('tbl_chapter.status', $status);
        $this->db->order_by('tbl_chapter.label_en', 'ASC');
        if($limit != 0)
            $this->db->limit($limit, $row);
        $query = $this->db->get();
        return $query->result();
    }

    function SearchChapter($status, $description, $section, $sector) {
        $this->db->select('tbl_chapter.*');
        $this->db->select('tbl_section.label_ar as section_ar');
        $this->db->select('tbl_section.label_en as section_en');
        $this->db->select('tbl_section.sector_id as sector_id');
        $this->db->from('tbl_chapter');
        $this->db->join('tbl_section', 'tbl_section.id = tbl_chapter.section_id', 'inner');
        if($section != 0)
            $this->db->where('tbl_chapter.section_id', $section);
        if($sector != 0)
            $this->db->where('tbl_section.sector_id', $sector);

        if($description != '') {
            //$this->db->like("(tbl_section.label_en=".$description." OR tbl_section.label_ar=".$description.")", NULL, FALSE);
            //$this->db->or_like('tbl_section.label_ar',$description);
            $where = "( tbl_chapter.label_en LIKE '%$description%' OR tbl_chapter.label_ar LIKE '%$description%')";
            $this->db->where($where);
        }

        if($status != '')
            $this->db->like('tbl_chapter.status', $status);

        $this->db->order_by('tbl_chapter.label_en', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function GetItems($status = '', $row, $limit) {
        $this->db->select('tbl_heading.*');
        $this->db->select('tbl_chapter.label_ar as chapter_ar');
        $this->db->select('tbl_chapter.label_en as chapter_en');
        $this->db->select('tbl_subhead.title_en as subhead_en');
        $this->db->select('tbl_subhead.title_ar as subhead_ar');
        $this->db->from('tbl_heading');
        $this->db->join('tbl_chapter', 'tbl_chapter.id = tbl_heading.chapter_id', 'inner');
        $this->db->join('tbl_subhead', 'tbl_subhead.id = tbl_heading.subhead_id', 'inner');
        if($status != '')
            $this->db->where('tbl_heading.status', $status);
        $this->db->order_by('tbl_heading.label_en', 'ASC');
        if($limit != 0)
            $this->db->limit($limit, $row);
        $query = $this->db->get();
        return $query->result();
    }

    function SearchItems($status, $description, $section, $sector) {
        $this->db->select('tbl_chapter.*');
        $this->db->select('tbl_section.label_ar as section_ar');
        $this->db->select('tbl_section.label_en as section_en');
        $this->db->select('tbl_section.sector_id as sector_id');
        $this->db->from('tbl_chapter');
        $this->db->join('tbl_section', 'tbl_section.id = tbl_chapter.section_id', 'inner');
        if($section != 0)
            $this->db->where('tbl_chapter.section_id', $section);
        if($sector != 0)
            $this->db->where('tbl_section.sector_id', $sector);

        if($description != '') {
            //$this->db->like("(tbl_section.label_en=".$description." OR tbl_section.label_ar=".$description.")", NULL, FALSE);
            //$this->db->or_like('tbl_section.label_ar',$description);
            $where = "( tbl_chapter.label_en LIKE '%$description%' OR tbl_chapter.label_ar LIKE '%$description%')";
            $this->db->where($where);
        }

        if($status != '')
            $this->db->like('tbl_chapter.status', $status);

        $this->db->order_by('tbl_chapter.label_en', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function GetProductionInfo($company_id) {
        $this->db->select('tbl_company_heading.*');
        $this->db->select('tbl_heading.hs_code as hscode');
        $this->db->select('tbl_heading.hs_code_print as hscodeprint');
        $this->db->select('tbl_heading.label_ar as heading_ar');
        $this->db->select('tbl_heading.label_en as heading_en');

        $this->db->select('tbl_heading.description_ar as heading_description_ar');
        $this->db->select('tbl_heading.description_en as heading_description_en');
        $this->db->from('tbl_company_heading');
        $this->db->join('tbl_heading', 'tbl_heading.id = tbl_company_heading.heading_id', 'inner');
        $this->db->where('tbl_company_heading.company_id', $company_id);
        $this->db->order_by('tbl_company_heading.id', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function GetProductionInfoById($id) {
        $this->db->select('tbl_company_heading.*');
        $this->db->select('tbl_heading.hs_code as hscode');
        $this->db->select('tbl_heading.label_ar as heading_ar');
        $this->db->select('tbl_heading.label_en as heading_en');
        $this->db->select('tbl_heading.description_ar as description_ar');
        $this->db->select('tbl_heading.description_en as description_en');
        $this->db->from('tbl_company_heading');
        $this->db->join('tbl_heading', 'tbl_heading.id = tbl_company_heading.heading_id', 'inner');
        $this->db->where('tbl_company_heading.id', $id);
        $this->db->order_by('tbl_company_heading.id', 'ASC');
        $query = $this->db->get();
        return $query->row_array();
    }

    function GetCompanyBanks($company_id) {
        $this->db->select('tbl_banks_company.*');

        $this->db->select('tbl_bank.name_ar as bank_ar');
        $this->db->select('tbl_bank.name_en as bank_en');
        $this->db->from('tbl_banks_company');
        $this->db->join('tbl_bank', 'tbl_bank.id = tbl_banks_company.bank_id', 'inner');
        $this->db->where('tbl_banks_company.company_id', $company_id);
        $this->db->order_by('tbl_banks_company.id', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function GetCompanyBankById($id) {
        $this->db->select('tbl_banks_company.*');
        $this->db->select('tbl_bank.name_ar as bank_ar');
        $this->db->select('tbl_bank.name_en as bank_en');
        $this->db->from('tbl_banks_company');
        $this->db->join('tbl_bank', 'tbl_bank.id = tbl_banks_company.bank_id', 'inner');
        $this->db->where('tbl_banks_company.id', $id);
        $this->db->order_by('tbl_banks_company.id', 'ASC');
        $query = $this->db->get();
        return $query->row_array();
    }

    function GetCompanyInsurances($company_id) {
        $this->db->select('tbl_insurances_company.*');

        $this->db->select('tbl_insurances.name_ar as insurance_ar');
        $this->db->select('tbl_insurances.name_en as insurance_en');
        $this->db->from('tbl_insurances_company');
        $this->db->join('tbl_insurances', 'tbl_insurances.id = tbl_insurances_company.insurance_id', 'inner');
        $this->db->where('tbl_insurances_company.company_id', $company_id);
        $this->db->order_by('tbl_insurances_company.id', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function GetCompanyInsuranceById($id) {
        $this->db->select('tbl_insurances_company.*');

        $this->db->select('tbl_insurances.name_ar as insurance_ar');
        $this->db->select('tbl_insurances.name_en as insurance_en');
        $this->db->from('tbl_insurances_company');
        $this->db->join('tbl_insurances', 'tbl_insurances.id = tbl_insurances_company.insurance_id', 'inner');
        $this->db->where('tbl_insurances_company.id', $id);
        $this->db->order_by('tbl_insurances_company.id', 'ASC');
        $query = $this->db->get();
        return $query->row_array();
    }

    function GetMarkets($status) {
        $this->db->select('tbl_markets.*');
        $this->db->from('tbl_markets');
        $this->db->where('tbl_markets.status', $status);
        $this->db->order_by('tbl_markets.label_en', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function GetMarketByCountryId($status, $country_id) {
        $this->db->select('tbl_markets.*');
        $this->db->from('tbl_markets');
        //$this->db->where('tbl_markets.country_id',$country_id);
        $this->db->where('tbl_markets.status', $status);
        $this->db->order_by('tbl_markets.label_en', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function GetCompanyMarkets($company_id) {
        $this->db->select('tbl_markets_company.*');
//		$this->db->select('tbl_markets.label_ar as market_ar');
//		$this->db->select('tbl_markets.label_en as market_en');
        $this->db->from('tbl_markets_company');
        //	$this->db->join('tbl_markets', 'tbl_markets.id = tbl_markets_company.market_id', 'inner');
        $this->db->where('tbl_markets_company.company_id', $company_id);
        $this->db->order_by('tbl_markets_company.id', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function GetCompanyMarketsById($id) {
        $this->db->select('tbl_markets_company.*');
        //	$this->db->select('tbl_markets.label_ar as market_ar');
        //	$this->db->select('tbl_markets.label_en as market_en');
        $this->db->from('tbl_markets_company');
        //	$this->db->join('tbl_markets', 'tbl_markets.id = tbl_markets_company.market_id', 'inner');
        $this->db->where('tbl_markets_company.id', $id);
        $this->db->order_by('tbl_markets_company.id', 'ASC');
        $query = $this->db->get();
        return $query->row_array();
    }

    function GetCompanyElectricPowers($company_id) {
        $this->db->select('tbl_power_company.*');
        $this->db->from('tbl_power_company');
        $this->db->where('tbl_power_company.company_id', $company_id);
        $this->db->order_by('tbl_power_company.id', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function GetCompanyElectricPowerById($id) {
        $this->db->select('tbl_power_company.*');
        $this->db->from('tbl_power_company');
        $this->db->where('tbl_power_company.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    function GetCompanyEPower($id) {
        $this->db->select('tbl_power_company.*');
        $this->db->from('tbl_power_company');
        $this->db->where('tbl_power_company.company_id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    function GetCompanySponsors($status) {
        $this->db->select('tbl_sponsors.*');
        $this->db->from('tbl_sponsors');
        $this->db->where('tbl_sponsors.status', $status);
        $query = $this->db->get();
        return $query->result();
    }

    function GetCountries($status = '', $row, $limit) {
        $this->db->select('tbl_countries.*');
        $this->db->from('tbl_countries');
        if($status != '')
            $this->db->where('tbl_countries.status', $status);
        if($limit != 0)
            $this->db->limit($limit, $row);
        $this->db->order_by('tbl_countries.label_ar', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function GetCountryById($id) {
        $this->db->select('tbl_countries.*');
        $this->db->from('tbl_countries');
        $this->db->where('tbl_countries.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    function GetCitiesByCountryId($country_id) {
        $this->db->select('cities.*');
        $this->db->from('cities');
        $this->db->order_by('city', 'ASC');
        $this->db->where('cities.countryid', $country_id);
        $query = $this->db->get();
        return $query->result();
    }

    function GetCityId($id) {
        $this->db->select('cities.*');
        $this->db->from('cities');
        $this->db->where('cities.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    function GetIndustrialRooms() {
        $this->db->select('tbl_industrial_room.*');
        $this->db->from('tbl_industrial_room');
        $query = $this->db->get();
        return $query->result();
    }

    function GetIndustrialRoomById($id) {
        $this->db->select('tbl_industrial_room.*');
        $this->db->from('tbl_industrial_room');
        $this->db->where('tbl_industrial_room.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    function GetIndustrialGroups() {
        $this->db->select('tbl_industrial_group.*');
        $this->db->from('tbl_industrial_group');
        $query = $this->db->get();
        return $query->result();
    }

    function GetIndustrialGroupById($id) {
        $this->db->select('tbl_industrial_group.*');
        $this->db->from('tbl_industrial_group');
        $this->db->where('tbl_industrial_group.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    function GetEconomicalAssemblies() {
        $this->db->select('tbl_economical_assembly.*');
        $this->db->from('tbl_economical_assembly');
        $query = $this->db->get();
        return $query->result();
    }

    function GetEconomicalAssemblyById($id) {
        $this->db->select('tbl_economical_assembly.*');
        $this->db->from('tbl_economical_assembly');
        $this->db->where('tbl_economical_assembly.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    function GetPositions() {
        $this->db->select('tbl_positions.*');
        $this->db->from('tbl_positions');
        $query = $this->db->get();
        return $query->result();
    }

    function GetSalesMan($id) {
        $this->db->select('tbl_sales_man.*');
        $this->db->from('tbl_sales_man');
        $this->db->where('tbl_sales_man.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    function GetSalesMen() {
        $this->db->select('tbl_sales_man.*');
        $this->db->from('tbl_sales_man');
        $query = $this->db->get();
        return $query->result();
    }

    function GetLicenseSourceById($id) {
        $this->db->select('tbl_license_sources.*');
        $this->db->from('tbl_license_sources');
        $this->db->where('tbl_license_sources.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    function GetLicenseSources() {
        $this->db->select('tbl_license_sources.*');
        $this->db->from('tbl_license_sources');
        $query = $this->db->get();
        return $query->result();
    }

}