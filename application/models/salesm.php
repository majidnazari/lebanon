<?php

class Salesm extends CI_Model {
    
    function GetCompanyById($id)
    {
        $this->db->select('tbl_company.*', FALSE);
        $this->db->from('tbl_company');
        $this->db->where('tbl_company.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
    function UpdateSalesTasks($_array=array())
    {
        if(count($_array)>0)
        {
            if(@$_array['id']>0)
            {
                $this->edit('sales_items',array('copy_reservation'=>$_array['copy_reservation'],'advertisment'=>$_array['advertisment'],'notes'=>$_array['note'],'status'=>$_array['status']),array('id'=>$_array['id']));
                
            }
            $data=array();
            if($_array['status']=='done' and $_array['copy_reservation']>0)
            {
                $data['copy_res']=1;
                $data['copy_res_salesman_id']=$_array['copy_reservation'];
            }
             if($_array['status']=='done' and $_array['advertisment']>0)
            {
                $data['is_adv']=1;
                $data['adv_salesman_id']=$_array['advertisment'];
            }
            $company=$this->GetCompanyById($_array['item_id']);
            if($_array['note']!='')
            {
                $all_note='<br>'.$_array['note'];
            }
            $data['sales_note']=$company['sales_note'].$all_note;
             
            $this->edit('tbl_company',$data,array('id'=>$_array['item_id']));
            if($_array['status']=='canceled')
            {
                $this->db->delete('sales_items', array('id'=>$_array['id']));
            }
        }
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
    function GetSalesTaskById($id)
    {
        $this->db->select('sales.*, GROUP_CONCAT(DISTINCT(tbl_area.label_ar)) as Areas',FALSE);
        $this->db->select('tbl_sales_man.fullname as salesman');
        $this->db->select('users.username, users.fullname');
        $this->db->select('sales_schedules.start_date as StartDate, sales_schedules.end_date as EndDate');
        $this->db->from('sales');
        $this->db->join('sales_items', 'sales_items.sales_id = sales.id', 'inner');
        $this->db->join('tbl_company', 'tbl_company.id = sales_items.item_id AND sales_items.item_type="company"', 'left',false);
        $this->db->join('tbl_area', 'tbl_area.id = tbl_company.area_id', 'left');
        $this->db->join('tbl_sales_man', 'tbl_sales_man.id = sales.salesman_id', 'left');
        $this->db->join('sales_schedules', 'sales_schedules.sales_id = sales.id', 'inner');
        $this->db->join('users', 'users.id = sales.user_id', 'left');
        $this->db->where('sales.id', $id);
        $this->db->group_by('sales.id');
        $query = $this->db->get();
        return $query->row_array();
    }
   

    function GetSalesTasks($sales_id,$salesman,$company_id,$status,$row,$limit)
    {
        $this->db->select('SQL_CALC_FOUND_ROWS sales.*', FALSE);
        $this->db->select('GROUP_CONCAT(DISTINCT(tbl_area.label_ar)) as Areas',FALSE);
        $this->db->select('COUNT(CASE WHEN sales_items.status="pending" THEN sales_items.id END) as TotalPending',FALSE);
        $this->db->select('COUNT(CASE WHEN sales_items.status="done" THEN sales_items.id END) as TotalDone',FALSE);
        $this->db->select('sales_schedules.start_date as StartDate, sales_schedules.end_date as EndDate');
        $this->db->select('tbl_sales_man.fullname as salesman');
        $this->db->select('users.username, users.fullname');
        $this->db->from('sales');
        $this->db->join('sales_items', 'sales_items.sales_id = sales.id', 'inner');
        $this->db->join('tbl_company', 'tbl_company.id = sales_items.item_id AND sales_items.item_type="company"', 'left',false);
        $this->db->join('tbl_area', 'tbl_area.id = tbl_company.area_id', 'left');
        $this->db->join('sales_schedules', 'sales_schedules.sales_id = sales.id', 'left');
        $this->db->join('tbl_sales_man', 'tbl_sales_man.id = sales.salesman_id', 'left');
        $this->db->join('users', 'users.id = sales.user_id', 'left');
        if($sales_id!='') {
            $this->db->where('sales.id', $sales_id);
        }
        if($status!='')
        {
            $this->db->where('sales.status', $status);
        }
        if($salesman!='')
        {
            $this->db->where('sales.salesman_id', $salesman);
        }
        if($company_id!='')
        {
            $this->db->where('sales_items.item_id', $company_id);
            $this->db->where('sales_items.item_type', 'company');
        }
        $this->db->group_by('sales.id');
        $this->db->order_by('sales_schedules.id', 'DESC');

        if ($limit != 0)
            $this->db->limit($limit, $row);
        $query = $this->db->get();
        $query1 = $this->db->query('SELECT FOUND_ROWS() AS `total_rows`');
        $objCount = $query1->result_array();
        $totalres = $objCount[0]['total_rows'];
        $data_array = array('total' => $totalres, 'rows' => $query->result());
        return $data_array;
    }
    function GetCompaniesBySalesman($gov='',$district='',$area_id='',$salesman_array=array())
    {
        $this->db->select('tbl_company.*');

        $this->db->from('tbl_company');
        $this->db->where('tbl_company.is_closed', 0);
        $this->db->where('tbl_company.error_address', 0);

        if(count($salesman_array)>0){
            $where='(';
            for($i=0;$i<count($salesman_array);$i++){
                if(count($salesman_array[$i]['area']==0))
                {
                    $where.='( adv_salesman_id='.$salesman_array[$i]['salesman'].' or (copy_res_salesman_id='.$salesman_array[$i]['salesman'].' and adv_salesman_id=0))';
                }
                else{
                    $areawhere='and area_id IN ('.implode(",", $salesman_array[$i]['area']).')';

                    $where.='(( adv_salesman_id='.$salesman_array[$i]['salesman'].' '.$areawhere.') or (copy_res_salesman_id='.$salesman_array[$i]['salesman'].' and adv_salesman_id=0 '.$areawhere.' ))';
                }


                if($i<count($salesman_array)-1)
                {
                    $where.=' OR ';
                }
            }
            $where.=' )';
        }
        $this->db->where($where);
        if($gov!='' and $gov!=0)
            $this->db->where('tbl_company.governorate_id',$gov);
        if($district!='' and $district!=0)
            $this->db->where('tbl_company.district_id',$district);
        if($area_id!='' and $area_id!=0)
            $this->db->where('tbl_company.area_id',$area_id);
        $this->db->order_by('tbl_company.name_ar', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }
    function GetCompaniesByAreaIds($array_area=array())
    {
        $this->db->select('tbl_company.*');
        $this->db->select('sales_items.id as SalesId');
        $this->db->from('tbl_company');
        $this->db->join('sales_items', 'sales_items.item_id = tbl_company.id AND sales_items.item_type="company"', 'left',false);
        $this->db->join('tbl_area', 'tbl_area.id = tbl_company.area_id', 'inner');
        $this->db->where('tbl_company.is_closed', 0);
        $this->db->where('tbl_company.error_address', 0);
        $this->db->where('tbl_company.adv_salesman_id', 0);
        $this->db->where('tbl_company.copy_res_salesman_id', 0);
        $this->db->where('sales_items.id', NULL);
        $this->db->where_in('tbl_company.area_id',$array_area);
        $this->db->order_by('tbl_area.label_ar', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }
    function GetAreaByDistrictID($gov='',$district='',$array_category=array())
    {
        if(in_array('company',$array_category))
        {
            $select_company='COUNT(CASE WHEN tbl_company.is_closed=0 AND tbl_company.error_address=0 AND tbl_company.adv_salesman_id=0 AND tbl_company.copy_res_salesman_id=0 AND sales_items.item_id IS NULL THEN tbl_company.id END) as TotalCompanies';
            $join_company='COUNT(tbl_company.id) as TotalCompanies';
        }
        else{
            $select_company='0 as TotalCompanies';
        }
        if(in_array('insurance',$array_category))
        {
            $select_insurance='COUNT(tbl_insurances.id) as TotalInsurance';
        }
        else{
            $select_insurance='0 as TotalInsurance';
        }
        if(in_array('importer',$array_category))
        {
            $select_importer='COUNT(tbl_importers.id) as TotalImporter';
        }
        else{
            $select_importer='0 as TotalImporter';
        }
        if(in_array('transport',$array_category))
        {
            $select_transport='COUNT(tbl_transport.id) as TotalTransport';
        }
        else{
            $select_transport='0 as TotalTransport';
        }
        $this->db->select('tbl_area.*');
        $this->db->select($select_company,FALSE);
       // $this->db->select($select_insurance,FALSE);
       // $this->db->select($select_importer,FALSE);
       // $this->db->select($select_transport,FALSE);
        $this->db->select('COUNT(sales_items.id) as TotalSales');
        $this->db->from('tbl_area');
        $this->db->join('tbl_company', 'tbl_company.area_id = tbl_area.id', 'left');
      //  $this->db->join('tbl_insurances', 'tbl_insurances.area_id = tbl_area.id', 'left');
      //  $this->db->join('tbl_importers', 'tbl_importers.area_id = tbl_area.id', 'left');
      //  $this->db->join('tbl_transport', 'tbl_transport.area_id = tbl_area.id', 'left');
        $this->db->join('sales_items', 'sales_items.item_id = tbl_company.id AND sales_items.item_type="company"', 'left',false);


        if($gov!='' and $gov!=0)
            $this->db->where('tbl_area.governorate_id',$gov);
        if($district!='' and $district!=0)
            $this->db->where('tbl_area.district_id',$district);
       $this->db->group_by('tbl_area.id');
       // $this->db->having('TotalSales',0);
        $this->db->having('TotalCompanies >',0);
        $this->db->order_by('tbl_area.label_ar', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }
    function GetCompanies($sales_id,$status='',$row,$limit,$item_id='')
    {
        $this->db->select('SQL_CALC_FOUND_ROWS tbl_company.*', FALSE);
        $this->db->select('sales_items.sales_id as SalesId,sales_items.item_type as SalesItemType,sales_items.copy_reservation as CopyReservation');
        $this->db->select('sales_items.advertisment as Advertisment,sales_items.notes as SalesNotes, sales_items.status as SalesStatus, sales_items.id as SalesItemId');
        $this->db->select('sales_schedules.start_date as StartDate, sales_schedules.end_date as EndDate');
        $this->db->select('tbl_sales_man.fullname as salesman');
        $this->db->select('dc.fullname as TaskSales');
        $this->db->select('tbl_governorates.label_ar as governorate_ar,tbl_governorates.label_en as governorate_en');
        $this->db->select('tbl_districts.label_ar as district_ar, tbl_districts.label_en as district_en');
        $this->db->select('tbl_area.label_ar as area_ar, tbl_area.label_en as area_en');
        $this->db->select('users.username, users.fullname');
        $this->db->select('COUNT(tbl_company_heading.id) as CNbr');
        $this->db->select('tbl_companies_guide_pages.guide_pages_ar, tbl_companies_guide_pages.guide_pages_en');
        $this->db->select('delivery.salesman_id as delivery_man,delivery_items.delivery_id, delivery_items.delivery_man_id, delivery_items.receiver_name, delivery_items.receiver_date, 
        delivery_items.copy_quantity as delivery_copy_qty, delivery_items.notes as delivery_notes, delivery_items.status as delivery_status,delivery_items.paid_status');
        $this->db->from('tbl_company');
        $this->db->join('sales_items', 'sales_items.item_id = tbl_company.id', 'inner');
        $this->db->join('sales', 'sales.id = sales_items.sales_id', 'inner');
        $this->db->join('sales_schedules', 'sales_schedules.sales_id = sales.id', 'left');
        $this->db->join('tbl_sales_man', 'tbl_sales_man.id = tbl_company.sales_man_id', 'left');
        $this->db->join('tbl_sales_man dc', 'dc.id = sales.salesman_id', 'left');
        $this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_company.governorate_id', 'left');
        $this->db->join('tbl_districts', 'tbl_districts.id = tbl_company.district_id', 'left');
        $this->db->join('tbl_area', 'tbl_area.id = tbl_company.area_id', 'left');
        $this->db->join('tbl_company_heading', 'tbl_company_heading.company_id = tbl_company.id', 'left');
        $this->db->join('tbl_companies_guide_pages', 'tbl_companies_guide_pages.company_id = tbl_company.id', 'left');
        $this->db->join('users', 'users.id = sales.user_id', 'left');
         $this->db->join('delivery_items', 'delivery_items.item_id = tbl_company.id', 'left');
         $this->db->join('delivery', 'delivery.id = delivery_items.delivery_id', 'left');
        if($sales_id)
        {
            $this->db->where('sales_items.sales_id', $sales_id);
        }
        if($item_id)
        {
            $this->db->where('sales_items.item_id', $item_id);
        }
        if($status!='')
        {
            $this->db->where('sales_items.status', $status);
        }
        $this->db->group_by('sales_items.id');
        $this->db->group_by('tbl_company.id');
        $this->db->order_by('tbl_governorates.label_ar', 'ASC');
        $this->db->order_by('tbl_districts.label_ar', 'ASC');
        $this->db->order_by('tbl_area.label_ar', 'ASC');
        $this->db->order_by('sales_schedules.id', 'DESC');
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
    function GetActivities($status)
    {
        $this->db->select('magazine_activities.*,magazine_activities.name as text');
        $this->db->select('users.username, users.fullname');
        $this->db->from('magazine_activities');
        $this->db->join('users', 'users.id = magazine_activities.user_id', 'left');
        if($status!=''){
            $this->db->where('magazine_activities.status', $status);
        }
        $query = $this->db->get();
        return $query->result();
    }
    function GetActivityById($id)
    {
        $this->db->select('magazine_activities.*');
        $this->db->select('users.username, users.fullname');
        $this->db->from('magazine_activities');
        $this->db->join('users', 'users.id = magazine_activities.user_id', 'left');
        $this->db->where('magazine_activities.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
    function GetSources($status)
    {
        $this->db->select('magazine_sources.*, magazine_sources.name as text');
        $this->db->select('users.username, users.fullname');
        $this->db->from('magazine_sources');
        $this->db->join('users', 'users.id = magazine_sources.user_id', 'left');
        if($status!=''){
            $this->db->where('magazine_sources.status', $status);
        }
        $query = $this->db->get();
        return $query->result();
    }
    function GetSourceById($id)
    {
        $this->db->select('magazine_sources.*');
        $this->db->select('users.username, users.fullname');
        $this->db->from('magazine_sources');
        $this->db->join('users', 'users.id = magazine_sources.user_id', 'left');
        $this->db->where('magazine_sources.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
    function GetLegalForms($status)
    {
        $this->db->select('magazine_legal_forms.*');
        $this->db->select('users.username, users.fullname');
        $this->db->from('magazine_legal_forms');
        $this->db->join('users', 'users.id = magazine_legal_forms.user_id', 'left');
        if($status!=''){
            $this->db->where('magazine_legal_forms.status', $status);
        }
        $query = $this->db->get();
        return $query->result();
    }
    function GetLegalFormById($id)
    {
        $this->db->select('magazine_legal_forms.*');
        $this->db->select('users.username, users.fullname');
        $this->db->from('magazine_legal_forms');
        $this->db->join('users', 'users.id = magazine_legal_forms.user_id', 'left');
        $this->db->where('magazine_legal_forms.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
    function GetLabels()
    {
        $this->db->select('magazine_labels.*');
        $this->db->select('users.username, users.fullname');
        $this->db->from('magazine_labels');
        $this->db->join('users', 'users.id = magazine_labels.user_id', 'left');
        $query = $this->db->get();
        return $query->result();
    }
    function GetLabelId($id)
    {
        $this->db->select('magazine_labels.*');
        $this->db->select('users.username, users.fullname');
        $this->db->from('magazine_labels');
        $this->db->join('users', 'users.id = magazine_labels.user_id', 'left');
        $this->db->where('magazine_labels.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    function GetCountries()
    {
        $this->db->select('tbl_countries.*');
        $this->db->select('users.username, users.fullname');
        $this->db->from('tbl_countries');
        $this->db->join('users', 'users.id = tbl_countries.user_id', 'left');
        $query = $this->db->get();
        return $query->result();
    }
    function GetAllGeo()
    {
        $this->db->select('tbl_countries.id, tbl_countries.label_ar as name');
        $this->db->select('users.username, users.fullname');
        $this->db->from('tbl_countries');
        $this->db->join('users', 'users.id = tbl_countries.user_id', 'left');
        $query = $this->db->get();
        return $query->result();
    }
    function GetAllGovernorateByCountry($country)
    {
        $this->db->select('tbl_governorates.id, tbl_governorates.label_ar as name');
        $this->db->select('users.username, users.fullname');
        $this->db->from('tbl_governorates');
        $this->db->join('users', 'users.id = tbl_governorates.user_id', 'left');
        $this->db->where('tbl_governorates.country_id',$country);
        $this->db->order_by('tbl_governorates.label_ar','asc');
        $query = $this->db->get();
        return $query->result();
    }
    function GetDistrictJsonByGovernorate($governorate)
    {
        $this->db->select('tbl_districts.id, tbl_districts.label_ar as name');
        $this->db->select('users.username, users.fullname');
        $this->db->from('tbl_districts');
        $this->db->join('users', 'users.id = tbl_districts.user_id', 'left');
        $this->db->where('tbl_districts.governorate_id',$governorate);
        $this->db->order_by('tbl_districts.label_ar','asc');
        $query = $this->db->get();
        return $query->result();
    }
    function GetAreaJsonByDistrict($district)
    {
        $this->db->select('tbl_area.id, tbl_area.label_ar as name');
        $this->db->select('users.username, users.fullname');
        $this->db->from('tbl_area');
        $this->db->join('users', 'users.id = tbl_area.user_id', 'left');
        $this->db->where('tbl_area.district_id',$district);
        $this->db->order_by('tbl_area.label_ar','asc');
        $query = $this->db->get();
        return $query->result();
    }
    function GetSalesmen()
    {
        $this->db->select('tbl_sales_man.*');
        $this->db->select('users.username, users.fullname as user_fullname');
        $this->db->from('tbl_sales_man');
        $this->db->join('users', 'users.id = tbl_sales_man.user_id', 'left');
        $this->db->order_by('tbl_sales_man.fullname','asc');
        $query = $this->db->get();
        return $query->result();
    }


}