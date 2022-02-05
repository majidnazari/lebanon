<?php

class Administrator extends CI_Model {

    function GetNews($status) {
        $this->db->select('news.*');
        $this->db->from('news');
        if($status != '') {
            $this->db->where('news.status', $status);
        }
        $query = $this->db->get();
        return $query->result();
    }
    function GetNewsById($id) {
        $this->db->select('news.*');
        $this->db->from('news');
        $this->db->where('news.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    function GetSalesMen() {
        $this->db->select('tbl_sales_man.*');
        $this->db->from('tbl_sales_man');
         $this->db->where('tbl_sales_man.status', 'online');
        $this->db->order_by('fullname', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }
    function GetSalesMan($id) {
        $this->db->select('tbl_sales_man.*');
        $this->db->from('tbl_sales_man');
        $this->db->where('tbl_sales_man.id', $id);
        $this->db->order_by('fullname', 'ASC');
        $query = $this->db->get();
        return $query->row_array();
    }
    function GetGovernorateByName($name)
    {
        $this->db->select('tbl_governorates.*');
        $this->db->from('tbl_governorates');
        $this->db->like('tbl_governorates.label_ar',$name);
        $query = $this->db->get();
        return $query->row_array();
    }
    function GetDistrictByName($name)
    {
        $this->db->select('tbl_districts.*');
        $this->db->from('tbl_districts');
        $this->db->like('tbl_districts.label_ar',$name);
        $query = $this->db->get();
        return $query->row_array();
    }
    function GetAreaByName($name)
    {
        $this->db->select('tbl_area.*');
        $this->db->from('tbl_area');
        $this->db->like('tbl_area.label_ar',$name);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function Degree2Decimal($x) {
        $array = explode('°', $x);
        $array1 = explode("'", $array[1]);
        $degree = $array[0];
        $minute = $array1[0];
        $second = str_replace('"', '', $array1[0]);
        $decimal = $degree + ($minute / 60) + ($second / 3600);
        return $decimal;
    }

    public function GetStatesUsers($year) {
        $this->db->select('monthname(create_time) AS Month, year(create_time) AS Year, COUNT(id) AS Views');
        $this->db->from('states_users');
        if($year != '') {
            $this->db->where('year(create_time)', $year);
        }
        $this->db->group_by('year(create_time)');
        $this->db->group_by('monthname(create_time)');
        $this->db->order_by('year(create_time)', 'DESC');
        $this->db->order_by('month(create_time)', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function GetVisitorsByCountries($date) {
        $this->db->select('*, COUNT(id) AS Views');
        $this->db->from('states_users');
        if($date != '') {
            $this->db->where('year(create_time)', date('Y', strtotime($date)));
            $this->db->where('month(create_time)', date('m', strtotime($date)));
        }
        $this->db->group_by('country');
        $this->db->order_by('Views', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function GetDailyVisitors($day) {
        $this->db->select('COUNT(id) AS Views');
        $this->db->from('states_users');
        if($day != '') {
            $this->db->where('DATE(create_time)', $day);
        }
        $this->db->group_by('year(create_time)');
        $this->db->group_by('monthname(create_time)');
        $this->db->order_by('year(create_time)', 'DESC');
        $this->db->order_by('DAY(create_time)', 'DESC');
        $this->db->order_by('month(create_time)', 'ASC');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function GetVisitorsByDays($day) {
        $this->db->select('day(create_time) AS day, monthname(create_time) AS Month, year(create_time) AS Year, COUNT(id) AS Views');
        $this->db->select('COUNT(id) AS Views');
        $this->db->from('states_users');
        if($day != '') {
            $this->db->where('month(create_time)', $day);
        }
        $this->db->group_by('year(create_time)');
        $this->db->group_by('monthname(create_time)');
        $this->db->group_by('DAY(create_time)');
        $this->db->order_by('year(create_time)', 'DESC');
        $this->db->order_by('DAY(create_time)', 'ASC');
        $this->db->order_by('month(create_time)', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }
    public function SearchVisitorsByDays($from,$to) {
        $this->db->select('DATE(create_time) AS day, COUNT(id) AS Views');
        $this->db->select('COUNT(id) AS Views');
        $this->db->from('states_users');
        if($from != '') {
            $this->db->where('DATE(create_time) >=', $from);
        }
        if($to != '') {
            $this->db->where('DATE(create_time) <=', $to);
        }
        $this->db->group_by('DATE(create_time)');
        $this->db->order_by('DATE(create_time)', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function GetValue($key, $value) {
        $this->load->model(array('Item', 'Address', 'Company'));
        $data = array();
        $label = '';
        $new_value = '';
        switch($key) {
            case "chapter_id":
                $query = $this->Item->GetChapterById($value);
                $label = 'Chapter';
                $new_value = (@$query['label_ar'] ? $query['label_ar'] : $value);
                break;
            case "governorate_id":
                $query = $this->Address->GetGovernorateById($value);
                $label = 'Mohafaza';
                $new_value = (@$query['label_ar'] ? $query['label_ar'] : $value);
                break;
            case "district_id":
                $query = $this->Address->GetDistrictById($value);
                $label = 'Kazaa';
                $new_value = (@$query['label_ar'] ? $query['label_ar'] : $value);
                break;
            case "area_id":
                $query = $this->Address->GetAreaById($value);
                $label = 'Area';
                $new_value = (@$query['label_ar'] ? $query['label_ar'] : $value);
                break;
            case "section_id":
                $query = $this->Item->GetSectionById($value);
                $label = 'Section';
                $new_value = (@$query['label_ar'] ? $query['label_ar'] : $value);

                break;
            case "sector_id":
                $query = $this->Item->GetSectorById($value);
                $label = 'Sector';
                $new_value = (@$query['label_ar'] ? $query['label_ar'] : $value);

                break;
            case "heading_id":
                $query = $this->Item->GetItemById($value);
                $label = 'Item';
                $new_value = (@$query['label_ar'] ? $query['hs_code_print'].' : '.$query['label_ar'] : $value);

                break;
            case "position_id":
                $query = $this->Item->GetPositionById($value);
                $label = 'Position';
                $new_value = (@$query['label_ar'] ? $query['label_ar'] : $value);
                break;
            case "sales_man_id":
                $query = $this->Company->GetSalesMan($value);
                $label = 'Sales Man';
                $new_value = (@$query['fullname'] ? $query['fullname'] : $value);
                break;
            case "license_source_id":
                $query = $this->Company->GetLicenseSourceById($value);
                $label = 'مصدر السجل';
                $new_value = (@$query['label_ar'] ? $query['label_ar'] : $value);
                break;
            case "company_type_id":
                $query = $this->Company->GetCompanyTypeById($value);
                $label = 'نوع الشركة';
                $new_value = (@$query['label_ar'] ? $query['label_ar'] : $value);
                break;
            default:
                $label = $key;
                $new_value = $value;
        }

        return array('label' => $label, 'value' => $new_value);
    }

    public function affected_fields($array1, $array2) {
        $data = array();
        foreach($array2 as $key => $value2) {
            if(array_key_exists($key, $array1)) {

                if($array1[$key] != $array2[$key]) {
                    $data[$key] = array('old' => $array1[$key], 'new' => $array2[$key]);
                }
            }
        }

        return $data;
    }

    function GetDocumentsByItemId($item, $type) {
        $this->db->select('documents.*');
        $this->db->from('documents');
        $this->db->where('documents.item_id', $item);
        $this->db->where('documents.item_type', $type);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function GetUsersByRole($role_id) {
        $this->db->select('users.*');
        $this->db->from('users');
        $this->db->where('users.group_id', $role_id);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function GetUserById($id) {
        $this->db->select('users.*');
        $this->db->from('users');
        $this->db->where('users.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    function GetUserByUsername($username, $field_type) {
        $this->db->select('users.*');
        $this->db->from('users');
        $this->db->where($field_type, $username);
        $this->db->where('users.status', 'online');
        $query = $this->db->get();
        return $query->row_array();
    }

    function GetAllUsers() {
        $this->db->select('users.*');
        $this->db->select('groups.name as group_name');
        $this->db->from('users');
        $this->db->join('groups', 'groups.id = users.group_id ', 'left');
        $this->db->order_by('fullname', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function GetCategories() {
        $this->db->select('categories.*');
        $this->db->from('categories');
        $query = $this->db->get();
        return $query->result();
    }

    function GetAllGroups() {
        $this->db->select('groups.*');
        $this->db->from('groups');
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function GetGroups() {
        $this->db->select('navigations.*');
        $this->db->from('navigations');
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function GetPermissions() {
        $this->db->select('navigations.*');
        $this->db->from('navigations');
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function GetPermissionById($id) {
        $this->db->select('navigations.*');
        $this->db->from('navigations');
        $this->db->where('navigations.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    function GetCategoryById($id) {
        $this->db->select('categories.*');
        $this->db->from('categories');
        $this->db->where('categories.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    function GetCities($id) {
        $this->db->select('cities.*');
        $this->db->from('cities');
        $this->db->where('cities.countryid', $id);
        $query = $this->db->get();
        return $query->result();
    }

    function GetCategory() {
        $query = $this->db->get('categories');
        return $query->result();
    }

    function delete($table, $array_id) {
        if($this->db->delete($table, $array_id))
            return true;
    }

    function save($table, $data) {

        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    function edit($table, $data, $id) {
        $this->db->where('id', $id);
        $this->db->update($table, $data);
        return $id;
    }
    function update($table, $data, $where) {
        $this->db->where($where);
        $this->db->update($table, $data);
        return $this->db->affected_rows();
    }
    function edit_all($table, $data) {
        $this->db->update($table, $data);
        return $id;
    }

    function do_upload($dir, $file_input = 'userfile') {
//$dir = 'uploads/';
//echo $dir;
        $config['overwrite'] = TRUE;
        $config['upload_path'] = $dir;
//die(var_dump(is_dir($config['upload_path'])));
        $config['allowed_types'] = '*';
        $config['max_size'] = '10000';
        $config['max_width'] = 0;
        $config['max_height'] = 0;

        $this->load->library('upload', $config);
        $target_path = "";
        if(!$this->upload->do_upload($file_input)) {
            $error = $this->upload->display_errors();
        }
        else {
            $data = array('upload_data' => $this->upload->data());
            $file = $data['upload_data']['file_name']; // set the file variable
            $type = $data['upload_data']['image_type'];
            $target_path = $dir.$file;
            $error = "Uploading Successful";
        }
        $list = array("target_path" => $target_path, "error" => $error);
        return $list;
    }

    function upload_pif() {
        $dir = 'uploads/';
        $config['overwrite'] = FALSE;
        $config['upload_path'] = $dir;
        $config['allowed_types'] = 'doc|docx|pdf';
        $config['max_size'] = '2000';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        $this->upload->do_upload();


        $target_path = "";
        if(!$this->upload->do_upload()) {
            $error = $this->upload->display_errors();
        }
        else {
            $data = array('upload_data' => $this->upload->data());
            $file = $data['upload_data']['file_name']; // set the file variable
            $target_path = "uploads/".$file;
            $error = "Uploading Successful";
        }
        $list = array("target_path" => $target_path, "error" => $error);
        return $list;
    }

}