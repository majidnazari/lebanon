<?php

class Items extends Application {
    var $p_delete_sector = FALSE;
    var $p_edit_sector = FALSE;
    var $p_add_sector = FALSE;
    var $p_view_sector = FALSE;
    var $p_delete_section = FALSE;
    var $p_edit_section = FALSE;
    var $p_add_section = FALSE;
    var $p_view_section = FALSE;
    var $p_delete_chapter = FALSE;
    var $p_edit_chapter = FALSE;
    var $p_add_chapter = FALSE;
    var $p_view_chapter = FALSE;
    var $p_delete_subhead = FALSE;
    var $p_edit_subhead = FALSE;
    var $p_add_subhead = FALSE;
    var $p_view_subhead = FALSE;
    var $page_denied = FALSE;

    public function __construct() {

        parent::__construct();
        $this->ag_auth->restrict('items'); // restrict this controller to admins only
        $this->load->model(array('Administrator', 'Item', 'Address', 'Company', 'Bank', 'Parameter'));
        $this->data['Ctitle'] = 'Industry - Items ';

        $this->p_delete_sector = $this->ag_auth->check_privilege(49, 'delete');
        $this->p_edit_sector = $this->ag_auth->check_privilege(49, 'edit');
        $this->p_add_sector = $this->ag_auth->check_privilege(49, 'add');
        $this->p_view_sector = $this->ag_auth->check_privilege(49, 'view');
        $this->data['p_delete_sector'] = $this->p_delete_sector;
        $this->data['p_edit_sector'] = $this->p_edit_sector;
        $this->data['p_add_sector'] = $this->p_add_sector;
        $this->data['p_view_sector'] = $this->p_view_sector;

        $this->p_delete_section = $this->ag_auth->check_privilege(50, 'delete');
        $this->p_edit_section = $this->ag_auth->check_privilege(50, 'edit');
        $this->p_add_section = $this->ag_auth->check_privilege(50, 'add');
        $this->p_view_section = $this->ag_auth->check_privilege(50, 'view');
        $this->data['p_delete_section'] = $this->p_delete_section;
        $this->data['p_edit_section'] = $this->p_edit_section;
        $this->data['p_add_section'] = $this->p_add_section;
        $this->data['p_view_section'] = $this->p_view_section;

        $this->p_delete_chapter = $this->ag_auth->check_privilege(51, 'delete');
        $this->p_edit_chapter = $this->ag_auth->check_privilege(51, 'edit');
        $this->p_add_chapter = $this->ag_auth->check_privilege(51, 'add');
        $this->p_view_chapter = $this->ag_auth->check_privilege(51, 'view');
        $this->data['p_delete_chapter'] = $this->p_delete_chapter;
        $this->data['p_edit_chapter'] = $this->p_edit_chapter;
        $this->data['p_add_chapter'] = $this->p_add_chapter;
        $this->data['p_view_chapter'] = $this->p_view_chapter;

        $this->p_delete_item = $this->ag_auth->check_privilege(52, 'delete');
        $this->p_edit_item = $this->ag_auth->check_privilege(52, 'edit');
        $this->p_add_item = $this->ag_auth->check_privilege(52, 'add');
        $this->p_view_item = $this->ag_auth->check_privilege(52, 'view');
		$this->data['p_move_item'] =$this->p_move_item = $this->ag_auth->check_privilege(52, 'move');
        $this->data['p_delete_item'] = $this->p_delete_item;
        $this->data['p_edit_item'] = $this->p_edit_item;
        $this->data['p_add_item'] = $this->p_add_item;
        $this->data['p_view_item'] = $this->p_view_item;

        $this->p_delete_subhead = $this->ag_auth->check_privilege(53, 'delete');
        $this->p_edit_subhead = $this->ag_auth->check_privilege(53, 'edit');
        $this->p_add_subhead = $this->ag_auth->check_privilege(53, 'add');
        $this->p_view_subhead = $this->ag_auth->check_privilege(53, 'view');
        $this->data['p_delete_subhead'] = $this->p_delete_subhead;
        $this->data['p_edit_subhead'] = $this->p_edit_subhead;
        $this->data['p_add_subhead'] = $this->p_add_subhead;
        $this->data['p_view_subhead'] = $this->p_view_subhead;


        $this->page_denied = 'denied';
        $this->data['page_denied'] = $this->page_denied;
    }
public function moving_item()
	{
		if($this->p_move_item)
		{
		$old_item=$this->input->post('old_item');
		$new_item=$this->input->post('new_item');
		if($old_item=='' or $new_item==''){
			$this->session->set_userdata(array('admin_message'=>'Old and new Items are required'));
		}
		else{
			$olds = $this->Item->GetItemByCode($old_item);
			$new = $this->Item->GetItemByCode($new_item);
			if(count($olds)==0)
			{
				$this->session->set_userdata(array('admin_message'=>'Old Item not exist'));
				redirect('items');		
			}
			if(count($new)==0)
			{
				$this->session->set_userdata(array('admin_message'=>'New Item not exist'));
				redirect('items');		
			}
			$companies=$this->Administrator->update('tbl_company_heading',array('heading_id'=>$olds['id']),array('heading_id'=>$new['id']));
		
			$this->session->set_userdata(array('admin_message'=>'Updated Successfully<br>'.$companies.' companies'));
		}
			redirect('items');					
		
		}
		else{
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}

    public function delete() {
        $get = $this->uri->ruri_to_assoc();
        if((int)$get['id'] > 0) {
            switch($get['p']) {
                case 'sector':
                    if($this->p_delete_sector) {
                        $query = $this->Item->GetSectorById($get['id']);
                        $history = array('action' => 'delete', 'logs_id' => 0, 'item_id' => $get['id'], 'item_title' => $query['label_ar'], 'type' => 'sector', 'details' => json_encode($query), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                        $h_id = $this->General->save('logs', $history);
                        $this->General->delete('tbl_sectors', array('id' => $get['id']));
                        $this->session->set_userdata(array('admin_message' => 'Deleted'));
                        redirect('items/sectors');
                    }
                    else {
                        $this->session->set_userdata(array('admin_message' => 'Access Denied'));
                        redirect($this->page_denied);
                    }
                    break;

                case 'section':
                    if($this->p_delete_section) {
                        $query = $this->Item->GetSectionById($get['id']);
                        $history = array('action' => 'delete', 'logs_id' => 0, 'item_id' => $get['id'], 'item_title' => $query['label_ar'], 'type' => 'section', 'details' => json_encode($query), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                        $h_id = $this->General->save('logs', $history);
                        $this->General->delete('tbl_section', array('id' => $get['id']));
                        $this->session->set_userdata(array('admin_message' => 'Deleted'));
                        redirect('items/sections');
                    }
                    else {
                        $this->session->set_userdata(array('admin_message' => 'Access Denied'));
                        redirect($this->page_denied);
                    }
                    break;

                case 'chapter':
                    if($this->p_delete_chapter) {
                        $query = $this->Item->GetChapterById($get['id']);
                        $history = array('action' => 'delete', 'logs_id' => 0, 'item_id' => $get['id'], 'item_title' => $query['label_ar'], 'type' => 'chapter', 'details' => json_encode($query), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                        $h_id = $this->General->save('logs', $history);

                        $this->General->delete('tbl_chapter', array('id' => $get['id']));
                        $this->session->set_userdata(array('admin_message' => 'Deleted'));
                        redirect('items/chapters');
                    }
                    else {
                        $this->session->set_userdata(array('admin_message' => 'Access Denied'));
                        redirect($this->page_denied);
                    }
                    break;
                case 'item':
                    if($this->p_delete_item) {
                        $query = $this->Item->GetItemById($get['id']);
                        $history = array('action' => 'delete', 'logs_id' => 0, 'item_id' => $get['id'], 'item_title' => $query['label_ar'], 'type' => 'heading', 'details' => json_encode($query), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                        $h_id = $this->General->save('logs', $history);
                        $this->General->delete('tbl_heading', array('id' => $get['id']));
                        $this->session->set_userdata(array('admin_message' => 'Deleted'));
                        redirect('items');
                    }
                    else {
                        $this->session->set_userdata(array('admin_message' => 'Access Denied'));
                        redirect($this->page_denied);
                    }
                    break;

                case 'subhead':
                    if($this->p_delete_subhead) {
                        $query = $this->Item->GetSubheadById($get['id']);
                        $history = array('action' => 'delete', 'logs_id' => 0, 'item_id' => $get['id'], 'item_title' => $query['label_ar'], 'type' => 'subhead', 'details' => json_encode($query), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                        $h_id = $this->General->save('logs', $history);
                        $this->General->delete('tbl_subhead', array('id' => $get['id']));
                        $this->session->set_userdata(array('admin_message' => 'Deleted'));
                        redirect('items/subhead');
                    }
                    else {
                        $this->session->set_userdata(array('admin_message' => 'Access Denied'));
                        redirect($this->page_denied);
                    }
                    break;
                case 'rate':
                    //if($this->p_delete_subhead){
                    //$query=$this->Item->GetSubheadById($get['id']);
                    //$history=array('action'=>'delete','details'=>json_encode($query),'create_time'=>date('Y-m-d H:i:s'),'user_id' =>  $this->session->userdata('id'));
                    //$this->General->save('history_subhead',$history);
                    $this->General->delete('tbl_heading_rate', array('id' => $get['id']));
                    $this->session->set_userdata(array('admin_message' => 'Deleted'));
                    redirect('items/edit/'.$get['item']);
                    //}
                    //else{
                    //	$this->session->set_userdata(array('admin_message'=>'Access Denied'));
                    //	redirect($this->page_denied);
                    //	}
                    break;
            }
        }
    }

    public function sectors() {
        if($this->p_view_sector) {

            $query = $this->Item->GetSector('', 0, 0);
            $this->breadcrumb->clear();
            $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
            $this->breadcrumb->add_crumb('Items');
            $this->breadcrumb->add_crumb('Sectors', 'items/sectors/');
            $this->data['subtitle'] = 'Sectors';
            $this->data['query'] = $query;
            $this->data['msg'] = $this->session->userdata('admin_message');
            $this->session->unset_userdata('admin_message');
            $this->data['title'] = $this->data['Ctitle']." | Sectors";
            $this->template->load('_template', 'items/sector', $this->data);
        }
        else {

            $this->session->set_userdata(array('admin_message' => 'Access Denied'));
            redirect($this->page_denied);
        }
    }

    public function create_sector() {
        if($this->p_add_sector) {
            $label_ar = $this->input->post('label_ar');
            $label_en = $this->input->post('label_en');

            $data = array(
                    'label_ar' => $label_ar,
                    'label_en' => $label_en,
                    'create_time' => date('Y-m-d H:i:s'),
                    'update_time' => date('Y-m-d H:i:s'),
                    'user_id' => $this->session->userdata('id'),
            );

            if($id = $this->General->save('tbl_sectors', $data)) {
                $history = array('action' => 'add', 'logs_id' => 0, 'type' => 'sector', 'details' => json_encode($data), 'item_id' => $id, 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                $this->General->save('logs', $history);
                $this->session->set_userdata(array('admin_message' => 'Add Successfully'));
                redirect('items/sectors/');
            }
        }
        else {
            $this->session->set_userdata(array('admin_message' => 'Access Denied'));
            redirect($this->page_denied);
        }
    }

    public function edit_sector() {
        if($this->p_edit_sector) {
            $label_ar = $this->input->post('label_ar');
            $label_en = $this->input->post('label_en');
            $id = $this->input->post('id');

            $data = array(
                    'label_ar' => $label_ar,
                    'label_en' => $label_en,
                    'update_time' => date('Y-m-d H:i:s'),
                    'user_id' => $this->session->userdata('id'),
            );
            $query = $this->Item->GetSectorById($id);
            if($this->Administrator->edit('tbl_sectors', $data, $id)) {
                $newdata = $this->Administrator->affected_fields($query, $data);
                $history = array('action' => 'edit', 'logs_id' => 0, 'item_id' => $id, 'item_title' => $query['label_ar'], 'type' => 'section', 'details' => json_encode($newdata), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                $LID = $this->General->save('logs', $history);
                $this->session->set_userdata(array('admin_message' => 'Updated Successfully'));

                redirect('items/sectors/');
            }
        }
        else {
            $this->session->set_userdata(array('admin_message' => 'Access Denied'));
            redirect($this->page_denied);
        }
    }

    public function sections() {
        if($this->p_view_section) {

            $query = $this->Item->GetSection('', 0, 0);
            $this->breadcrumb->clear();
            $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
            $this->breadcrumb->add_crumb('Items');
            $this->breadcrumb->add_crumb('Sections', 'items/sections/');
            $this->data['subtitle'] = 'Sections';
            $this->data['query'] = $query;
            $this->data['sectors'] = $this->Item->GetSector('online', 0, 0);
            $this->data['msg'] = $this->session->userdata('admin_message');
            $this->session->unset_userdata('admin_message');
            $this->data['title'] = $this->data['Ctitle']." | Sections";
            $this->template->load('_template', 'items/section', $this->data);
        }
        else {

            $this->session->set_userdata(array('admin_message' => 'Access Denied'));
            redirect($this->page_denied);
        }
    }

    public function create_section() {
        if($this->p_add_section) {
            $label_ar = $this->input->post('label_ar');
            $label_en = $this->input->post('label_en');
            $sector_id = $this->input->post('sector');
            $scn_nbr = $this->input->post('scn_nbr');

            $data = array(
                    'label_ar' => $label_ar,
                    'label_en' => $label_en,
                    'sector_id' => $sector_id,
                    'scn_nbr' => $scn_nbr,
                    'create_time' => date('Y-m-d H:i:s'),
                    'update_time' => date('Y-m-d H:i:s'),
                    'user_id' => $this->session->userdata('id'),
            );

            if($id = $this->General->save('tbl_section', $data)) {
                $history = array('action' => 'add', 'logs_id' => 0, 'type' => 'section', 'details' => json_encode($data), 'item_id' => $id, 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                $this->General->save('logs', $history);
                $this->session->set_userdata(array('admin_message' => 'Add Successfully'));
                redirect('items/sections/');
            }
        }
        else {
            $this->session->set_userdata(array('admin_message' => 'Access Denied'));
            redirect($this->page_denied);
        }
    }

    public function edit_section() {
        if($this->p_edit_section) {
            $label_ar = $this->input->post('label_ar');
            $label_en = $this->input->post('label_en');
            $sector_id = $this->input->post('sector');
            $scn_nbr = $this->input->post('scn_nbr');
            $id = $this->input->post('id');
            $data = array(
                    'label_ar' => $label_ar,
                    'label_en' => $label_en,
                    'sector_id' => $sector_id,
                    'scn_nbr' => $scn_nbr,
                    'update_time' => date('Y-m-d H:i:s'),
                    'user_id' => $this->session->userdata('id'),
            );
            $query = $this->Item->GetSectionById($id);
            if($this->Administrator->edit('tbl_section', $data, $id)) {
                $newdata = $this->Administrator->affected_fields($query, $data);
                $history = array('action' => 'edit', 'logs_id' => 0, 'item_id' => $id, 'item_title' => $query['label_ar'], 'type' => 'section', 'details' => json_encode($newdata), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                $LID = $this->General->save('logs', $history);
                $this->session->set_userdata(array('admin_message' => 'Updated Successfully'));

                redirect('items/sections/');
            }
        }
        else {
            $this->session->set_userdata(array('admin_message' => 'Access Denied'));
            redirect($this->page_denied);
        }
    }

    public function chapters() {
        if($this->p_view_chapter) {

            $query = $this->Item->GetChapter('', 0, 0);
            $this->breadcrumb->clear();
            $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
            $this->breadcrumb->add_crumb('Items');
            $this->breadcrumb->add_crumb('Chapters', 'items/chapters/');
            $this->data['subtitle'] = 'Chapters';
            $this->data['query'] = $query;
            $this->data['sections'] = $this->Item->GetSection('online', 0, 0);
            $this->data['msg'] = $this->session->userdata('admin_message');
            $this->session->unset_userdata('admin_message');
            $this->data['title'] = $this->data['Ctitle']." | Chapters";
            $this->template->load('_template', 'items/chapter', $this->data);
        }
        else {

            $this->session->set_userdata(array('admin_message' => 'Access Denied'));
            redirect($this->page_denied);
        }
    }

    public function create_chapter() {
        if($this->p_add_chapter) {
            $label_ar = $this->input->post('label_ar');
            $label_en = $this->input->post('label_en');
            $section_id = $this->input->post('section');
            $cha_nbr = $this->input->post('cha_nbr');

            $data = array(
                    'label_ar' => $label_ar,
                    'label_en' => $label_en,
                    'section_id' => $section_id,
                    'cha_nbr' => $cha_nbr,
                    'create_time' => date('Y-m-d H:i:s'),
                    'update_time' => date('Y-m-d H:i:s'),
                    'user_id' => $this->session->userdata('id'),
            );

            if($this->General->save('tbl_chapter', $data)) {
                $history = array('action' => 'add', 'logs_id' => 0, 'type' => 'chapter', 'details' => json_encode($data), 'item_id' => $id, 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                $this->General->save('logs', $history);
                $this->session->set_userdata(array('admin_message' => 'Add Successfully'));
                redirect('items/chapters/');
            }
        }
        else {
            $this->session->set_userdata(array('admin_message' => 'Access Denied'));
            redirect($this->page_denied);
        }
    }

    public function edit_chapter() {
        if($this->p_edit_chapter) {
            $label_ar = $this->input->post('label_ar');
            $label_en = $this->input->post('label_en');
            $section_id = $this->input->post('section');
            $cha_nbr = $this->input->post('cha_nbr');
            $id = $this->input->post('id');

            $data = array(
                    'cha_nbr' => $cha_nbr,
                    'label_ar' => $label_ar,
                    'label_en' => $label_en,
                    'section_id' => $section_id,
                    'update_time' => date('Y-m-d H:i:s'),
                    'user_id' => $this->session->userdata('id'),
            );
            $query = $this->Item->GetChapterById($id);
            if($this->Administrator->edit('tbl_chapter', $data, $id)) {
                $newdata = $this->Administrator->affected_fields($query, $data);
                $history = array('action' => 'edit', 'logs_id' => 0, 'item_id' => $id, 'item_title' => $query['label_ar'], 'type' => 'chapter', 'details' => json_encode($newdata), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                $LID = $this->General->save('logs', $history);
                $this->session->set_userdata(array('admin_message' => 'Updated Successfully'));

                redirect('items/chapters/');
            }
        }
        else {
            $this->session->set_userdata(array('admin_message' => 'Access Denied'));
            redirect($this->page_denied);
        }
    }

    public function index($row = 0) {
        if($this->p_view_item) {
            $limit = 15;

            if(isset($_GET['search'])) {
                $row = $this->input->get('per_page');
                $code = $this->input->get('code');
                $item = $this->input->get('item');
                $description = $this->input->get('description');
                $query = $this->Item->SearchItems($code, $item, $description, FALSE, $row, $limit);
                $total_row = count($this->Item->SearchItems($code, $item, $description, FALSE, 0, 0));

                $config['base_url'] = base_url().'items?code='.$code.'&item='.$item.'&description='.$description.'&search=Search';
                $config['enable_query_strings'] = TRUE;
                $config['page_query_string'] = TRUE;
            }
            elseif(isset($_GET['clear'])) {
                redirect('items/');
            }
            else {
                $code = '';
                $item = '';
                $description = '';
                $config['base_url'] = base_url().'items/index';
                //$config['uri_segment'] = 12;
                $query = $this->Item->GetItems('', $row, $limit);

                $total_row = count($this->Item->GetItems('', 0, 0));

                $this->pagination->initialize($config);
            }

            $this->data['code'] = $code;
            $this->data['item'] = $item;
            $this->data['description'] = $description;



            $config['total_rows'] = $total_row;
            $config['per_page'] = $limit;

            $config['num_links'] = 6;


            $this->pagination->initialize($config);
            $this->data['query'] = $query;
            $this->data['total_row'] = $total_row;

            $this->data['links'] = $this->pagination->create_links();
            $this->data['st'] = $this->uri->segment(4);

            $this->breadcrumb->clear();
            $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
            $this->breadcrumb->add_crumb('Items');
            $this->data['subtitle'] = 'Items';
            $this->data['query'] = $query;
            $this->data['msg'] = $this->session->userdata('admin_message');
            $this->session->unset_userdata('admin_message');
            $this->data['title'] = $this->data['Ctitle']." | Items";
            $this->template->load('_template', 'items/items', $this->data);
        }
        else {

            $this->session->set_userdata(array('admin_message' => 'Access Denied'));
            redirect($this->page_denied);
        }
    }

    public function details($id) {
        if($this->p_view_item) {
            $query = $this->Item->GetItemById($id);
            $this->data['query'] = $query;

            $this->data['msg'] = $this->session->userdata('admin_message');
            $this->session->unset_userdata('admin_message');
            $this->breadcrumb->clear();
            $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
            $this->breadcrumb->add_crumb('Items', 'items');
            $this->breadcrumb->add_crumb($query['hs_code_print'], 'items/details/'.$id);
            $this->data['title'] = $this->data['Ctitle']." - Items";

            $this->data['subtitle'] = $query['hs_code'];
            $this->data['id'] = $id;
            $this->data['rating'] = $this->Item->GetItemRating($id);
            $this->data['squery'] = $this->Item->GetItemsByCode($query['hs_code_print'], $id);
            $this->template->load('_template', 'items/details', $this->data);
        }
        else {

            $this->session->set_userdata(array('admin_message' => 'Access Denied'));
            redirect($this->page_denied);
        }
    }

    public function create($id = '') {

        if($this->p_add_item) {
            $this->data['nav'] = FALSE;
            if($id != '')
                $query = $this->Item->GetItemById($id);
            else
                $query = array();
            $this->breadcrumb->clear();
            $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
            $this->breadcrumb->add_crumb('Items', 'items');
            $this->breadcrumb->add_crumb('Add New item');

            $this->form_validation->set_rules('label_ar', 'الصنف', 'required');
            $this->form_validation->set_rules('label_en', 'Item in english', 'required');
            $this->form_validation->set_rules('hs_code', 'H.S.Code', 'required|is_unique[tbl_heading.hs_code]');
            $this->form_validation->set_rules('hs_code_print', 'الرمز المنسق الاصلي', 'required');
            $this->form_validation->set_rules('description_en', 'Special description', 'trim');
            $this->form_validation->set_rules('description_ar', 'وصف خاص', 'trim');
            $this->form_validation->set_rules('chapter_id', 'Chapter', 'required');
            $this->form_validation->set_rules('subhead_id', 'Subhead', 'required');

            if($this->form_validation->run()) {

                $data = array(
                        'label_ar' => $this->input->post('label_ar'),
                        'label_en' => $this->input->post('label_en'),
                        'hs_code' => $this->input->post('hs_code'),
                        'hs_code_print' => $this->input->post('hs_code_print'),
                        'description_en' => $this->input->post('description_en'),
                        'description_ar' => $this->input->post('description_ar'),
                        'chapter_id' => $this->input->post('chapter_id'),
                        'subhead_id' => $this->input->post('subhead_id'),
                        'create_time' => date('Y-m-d H:i:s'),
                        'update_time' => date('Y-m-d H:i:s'),
                        'status' => $this->input->post('status'),
                        'user_id' => $this->session->userdata('id'),
                );

                if($insert_id = $this->General->save('tbl_heading', $data)) {
                    $history = array('action' => 'add', 'logs_id' => 0, 'item_id' => $insert_id, 'item_title' => $data['label_ar'], 'type' => 'heading', 'details' => json_encode($data), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                    $LID = $this->General->save('logs', $history);

                    $countries = $this->input->post('countries');
                    $rate = $this->input->post('rate');
                    $import_lbp = $this->input->post('import_lbp');
                    $import_usd = $this->input->post('import_usd');
                    $tones_import = $this->input->post('tones_import');
                    $export_lbp = $this->input->post('export_lbp');
                    $export_usd = $this->input->post('export_usd');
                    $tones_export = $this->input->post('tones_export');
                    $year = $this->input->post('year');
                    for($i = 0; $i < count($countries); $i++) {
                        $data = array(
                                'heading_id' => $insert_id,
                                'country_id' => $countries[$i],
                                'rate' => $rate[$i],
                                'import_lbp' => $import_lbp[$i],
                                'import_usd' => $import_usd[$i],
                                'tones_import' => $tones_import[$i],
                                'export_lbp' => $export_lbp[$i],
                                'export_usd' => $export_usd[$i],
                                'tones_export' => $tones_export[$i],
                                'year' => $year[$i],
                                'create_time' => date('Y-m-d H:i:s'),
                                'update_time' => date('Y-m-d H:i:s'),
                                'user_id' => $this->session->userdata('id'),
                        );
                        $id = $this->General->save('tbl_heading_rate', $data);
                        $data['id'] = $id;
                        $history = array('action' => 'add', 'logs_id' => $LID, 'item_id' => $id, 'type' => 'item_rating', 'details' => json_encode($data), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                        $this->General->save('logs', $history);
                    }

                    $this->session->set_userdata(array('admin_message' => 'Add Successfully'));
                    $action = $this->input->post('action');
                    if($action == 'view') {
                        redirect('items/details/'.$insert_id);
                    }
                    else {
                        redirect('items/create/'.$id);
                    }
                }
                else {
                    $this->session->set_userdata(array('admin_message' => 'Error'));
                    redirect('items/create/'.$id);
                }
            }
            $this->data['i_id'] = '';
            $this->data['label_ar'] = (!isset($query['label_ar'])) ? set_value('label_ar') : $query['label_ar'];
            $this->data['label_en'] = (!isset($query['label_en'])) ? set_value('label_en') : $query['label_en'];
            $this->data['hs_code'] = (!isset($query['hs_code'])) ? set_value('hs_code') : $query['hs_code'];
            $this->data['hs_code_print'] = (!isset($query['hs_code_print'])) ? set_value('hs_code_print') : $query['hs_code_print'];
            $this->data['description_en'] = set_value('description_en');
            $this->data['description_ar'] = set_value('description_ar');
            $this->data['chapter_id'] = (!isset($query['chapter_id'])) ? set_value('chapter_id') : $query['chapter_id'];
            $this->data['subhead_id'] = (!isset($query['subhead_id'])) ? set_value('subhead_id') : $query['subhead_id'];
            $this->data['status'] = (!isset($query['status'])) ? set_value('status') : $query['status'];

            $this->data['chapters'] = $this->Item->GetChapter('online', 0, 0);
            $this->data['subhead'] = $this->Item->GetSubhead('online', 0, 0);
            $this->data['subhead'] = $this->Item->GetSubhead('online', 0, 0);
            $this->data['rates'] = array();
            $this->data['countries'] = $this->Address->GetCountries('online', 0, 0);
            $this->data['subtitle'] = 'Add New Item';
            $this->data['title'] = $this->data['Ctitle']."- Add New Item";
            $this->template->load('_template', 'items/item_form', $this->data);
        }
        else {

            $this->session->set_userdata(array('admin_message' => 'Access Denied'));
            redirect($this->page_denied);
        }
    }

    public function edit($id) {

        if($this->p_edit_item) {
            $this->data['nav'] = TRUE;
            $query = $this->Item->GetItemById($id);
            $this->breadcrumb->clear();
            $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
            $this->breadcrumb->add_crumb('Items', 'items');
            $this->breadcrumb->add_crumb($query['hs_code'], 'items/details/'.$id);
            $this->breadcrumb->add_crumb('Edit');

            $this->form_validation->set_rules('label_ar', 'الصنف', 'required');
            $this->form_validation->set_rules('label_en', 'Item in english', 'required');
            $this->form_validation->set_rules('hs_code', 'company name in arabic', 'required');
            $this->form_validation->set_rules('hs_code_print', 'company name in arabic', 'required');
            $this->form_validation->set_rules('description_en', 'Special description', 'trim');
            $this->form_validation->set_rules('description_ar', 'وصف خاص', 'trim');
            $this->form_validation->set_rules('chapter_id', 'Chapter', 'required');
            $this->form_validation->set_rules('subhead_id', 'Subhead', 'required');

            if($this->form_validation->run()) {

                $data = array(
                        'label_ar' => $this->input->post('label_ar'),
                        'label_en' => $this->input->post('label_en'),
                        'hs_code' => $this->input->post('hs_code'),
                        'hs_code_print' => $this->input->post('hs_code_print'),
                        'description_en' => $this->input->post('description_en'),
                        'description_ar' => $this->input->post('description_ar'),
                        'chapter_id' => $this->input->post('chapter_id'),
                        'subhead_id' => $this->input->post('subhead_id'),
                        'update_time' => date('Y-m-d H:i:s'),
                        'status' => $this->input->post('status'),
                        'user_id' => $this->session->userdata('id'),
                );
                $newdata = $this->Administrator->affected_fields($query, $data);
                if($this->Administrator->edit('tbl_heading', $data, $id)) {
                    $data['id'] = $id;

                    $history_i = array('action' => 'edit', 'logs_id' => 0, 'item_id' => $id, 'item_title' => $query['label_ar'], 'type' => 'item', 'details' => json_encode($newdata), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                    $LID = $this->General->save('logs', $history_i);

                    $actions_rate = $this->input->post('actions');
                    $countries = $this->input->post('countries');
                    $rate = $this->input->post('rate');
                    $import_lbp = $this->input->post('import_lbp');
                    $import_usd = $this->input->post('import_usd');
                    $tones_import = $this->input->post('tones_import');
                    $export_lbp = $this->input->post('export_lbp');
                    $export_usd = $this->input->post('export_usd');
                    $tones_export = $this->input->post('tones_export');
                    $year = $this->input->post('year');
                    for($i = 0; $i < count($countries); $i++) {
                        $data = array(
                                'heading_id' => $id,
                                'country_id' => $countries[$i],
                                'rate' => $rate[$i],
                                'import_lbp' => $import_lbp[$i],
                                'import_usd' => $import_usd[$i],
                                'tones_import' => $tones_import[$i],
                                'export_lbp' => $export_lbp[$i],
                                'export_usd' => $export_usd[$i],
                                'tones_export' => $tones_export[$i],
                                'year' => $year[$i],
                                'update_time' => date('Y-m-d H:i:s'),
                                'user_id' => $this->session->userdata('id'),
                        );
                        if($actions_rate[$i] == 'add') {
                            $hID = $this->General->save('tbl_heading_rate', $data);
                            $data['create_time'] = date('Y-m-d H:i:s');
                            $history = array('action' => 'add', 'logs_id' => $LID, 'item_id' => $hID, 'item_title' => $hID, 'type' => 'item_rating', 'details' => json_encode($data), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                            $this->General->save('logs', $history);
                        }
                        elseif($actions_rate[$i] == 'edit') {

                            $rateID = $this->input->post('RateID');
                            $rate = $this->Item->GetItemRatingById($rateID);
                            $newdata = $this->Administrator->affected_fields($rate, $data);
                            $history = array('action' => 'edit', 'logs_id' => $LID, 'item_id' => $id, 'item_title' => $id, 'type' => 'item_rating', 'details' => json_encode($newdata), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                            $this->General->save('logs', $history);

                            $this->Administrator->edit('tbl_heading_rate', $data, $rateID[$i]);
                        }
                    }


                    $this->session->set_userdata(array('admin_message' => 'Updated Successfully'));
                    $action = $this->input->post('action');
                    echo $action;

                    if($action == 'view') {
                        redirect('items/details/'.$id);
                    }
                    elseif($action == 'edit') {
                        $next = $this->Item->GetNextHeadingById($id);
                        if(count($next) > 0) {
                            redirect('items/edit/'.$next['id']);
                        }
                        else {
                            redirect('items/create/');
                        }
                    }
                    else {
                        redirect('items/create/'.$id);
                    }
                }
                else {
                    $this->session->set_userdata(array('admin_message' => 'Error'));
                    redirect('items/edit/'.$id);
                }
            }
            $this->data['i_id'] = '';
            $this->data['id'] = $id;
            $this->data['label_ar'] = (!isset($query['label_ar'])) ? set_value('label_ar') : $query['label_ar'];
            $this->data['label_en'] = (!isset($query['label_en'])) ? set_value('label_en') : $query['label_en'];
            $this->data['hs_code'] = (!isset($query['hs_code'])) ? set_value('hs_code') : $query['hs_code'];
            $this->data['hs_code_print'] = (!isset($query['hs_code_print'])) ? set_value('hs_code_print') : $query['hs_code_print'];
            $this->data['description_en'] = (!isset($query['description_en'])) ? set_value('description_en') : $query['description_en'];
            $this->data['description_ar'] = (!isset($query['description_ar'])) ? set_value('description_ar') : $query['description_ar'];
            $this->data['chapter_id'] = (!isset($query['chapter_id'])) ? set_value('chapter_id') : $query['chapter_id'];
            $this->data['subhead_id'] = (!isset($query['subhead_id'])) ? set_value('subhead_id') : $query['subhead_id'];
            $this->data['status'] = (!isset($query['status'])) ? set_value('status') : $query['status'];

            $this->data['chapters'] = $this->Item->GetChapter('online', 0, 0);
            $this->data['subhead'] = $this->Item->GetSubhead('online', 0, 0);
            $this->data['subtitle'] = 'Edit Item';
            $this->data['title'] = $this->data['Ctitle']."- Edit Item";
            $this->data['squery'] = $this->Item->GetItemsByCode($query['hs_code_print'], $id);
            $this->data['rates'] = $this->Item->GetItemRating($id);
            $this->data['countries'] = $this->Address->GetCountries('online', 0, 0);
            $this->template->load('_template', 'items/item_form', $this->data);
        }
        else {

            $this->session->set_userdata(array('admin_message' => 'Access Denied'));
            redirect($this->page_denied);
        }
    }

    function editraterow() {
        $id = $this->input->post('id');
        $countries = $this->Address->GetCountries('online', 0, 0);
        $rates = $this->Item->GetItemRatingById($id);
        $array_countries = array();
        foreach($countries as $country) {
            $array_countries[$country->id] = $country->label_en;
        }

        echo '<td>'.form_input(array("name" => "actions[]", "value" => 'edit', "type" => "hidden")).form_input(array("name" => "RateID[]", "value" => $id, "id" => "RateID".$id, "type" => "hidden")).form_dropdown('countries[]', $array_countries, $rates['country_id'], 'id="countryID'.$id.'"').'</td>
			  <td>'.form_input(array("name" => "rate[]", "id" => "ratev".$id, "value" => $rates['rate'])).'</td>
			  <td>'.form_input(array("name" => "import_lbp[]", "id" => "import_lbp".$id, "value" => $rates['import_lbp'])).'</td>
			  <td>'.form_input(array("name" => "import_usd[]", "id" => "import_usd".$id, "value" => $rates['import_usd'])).'</td>
			  <td>'.form_input(array("name" => "tones_import[]", "id" => "tones_import".$id, "value" => $rates['tones_import'])).'</td>
			  <td>'.form_input(array("name" => "export_lbp[]", "id" => "export_lbp".$id, "value" => $rates['export_lbp'])).'</td>
			  <td>'.form_input(array("name" => "export_usd[]", "id" => "export_usd".$id, "value" => $rates['export_usd'])).'</td>
			  <td>'.form_input(array("name" => "tones_export[]", "id" => "tones_export".$id, "value" => $rates['tones_export'])).'</td>
			  <td>'.form_input(array("name" => "year[]", "id" => "year".$id, "value" => $rates['year'])).'</td>
			  <td><a  style="cursor:pointer" onclick="updateRate('.$id.',countryID'.$id.'.value,ratev'.$id.'.value,import_lbp'.$id.'.value,import_usd'.$id.'.value,tones_import'.$id.'.value,export_lbp'.$id.'.value,export_usd'.$id.'.value,tones_export'.$id.'.value,year'.$id.'.value)"><img src="'.base_url().'img/save.png" style="height:16px;" /></a>
			  </td>';
    }

    function updateraterow() {
        $id = $this->input->post('id');

        $data = array(
                'country_id' => $this->input->post('countryID'),
                'rate' => $this->input->post('rate'),
                'import_lbp' => $this->input->post('import_lbp'),
                'import_usd' => $this->input->post('import_usd'),
                'tones_import' => $this->input->post('tones_import'),
                'export_lbp' => $this->input->post('export_lbp'),
                'export_usd' => $this->input->post('export_usd'),
                'tones_export' => $this->input->post('tones_export'),
                'year' => $this->input->post('year'),
                'update_time' => date('Y-m-d H:i:s'),
                'user_id' => $this->session->userdata('id'),
        );

        $this->Administrator->edit('tbl_heading_rate', $data, $id);
        $rates = $this->Item->GetItemRatingById($id);
        $newdata = $this->Administrator->affected_fields($rates, $data);
        $history = array('action' => 'edit', 'logs_id' => 0, 'item_id' => $id, 'item_title' => $id, 'type' => 'item_rating', 'details' => json_encode($newdata), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
        $this->General->save('logs', $history);
        echo '<td>'.$rates['country_en'].'</td>
			  <td>'.$rates['rate'].'</td>
			  <td>'.$rates['import_lbp'].'</td>
			  <td>'.$rates['import_usd'].'</td>
			  <td>'.$rates['tones_import'].'</td>
			  <td>'.$rates['export_lbp'].'</td>
			  <td>'.$rates['export_usd'].'</td>
			  <td>'.$rates['tones_export'].'</td>
			  <td>'.$rates['year'].'</td>
			  <td>'._show_delete('items/delete/id/'.$id.'/item/'.$rates['heading_id'].'/p/rate', TRUE).'
			  		<a  style="cursor:pointer" onclick="editRate('.$id.')"><i class="isb-edit"></i></a>
			  </td>';
    }

    function saveraterow() {

        $data = array(
                'country_id' => $this->input->post('countryID'),
                'rate' => $this->input->post('rate'),
                'import_lbp' => $this->input->post('import_lbp'),
                'import_usd' => $this->input->post('import_usd'),
                'tones_import' => $this->input->post('tones_import'),
                'export_lbp' => $this->input->post('export_lbp'),
                'export_usd' => $this->input->post('export_usd'),
                'tones_export' => $this->input->post('tones_export'),
                'year' => $this->input->post('year'),
                'create_time' => date('Y-m-d H:i:s'),
                'update_time' => date('Y-m-d H:i:s'),
                'user_id' => $this->session->userdata('id'),
        );
        $id = $this->General->save('tbl_heading_rate', $data);
        $history = array('action' => 'edit', 'logs_id' => 0, 'item_id' => $id, 'item_title' => $id, 'type' => 'item_rating', 'details' => json_encode($data), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
        $this->General->save('logs', $history);
        $rates = $this->Item->GetItemRatingById($id);

        echo '<td>'.$rates['country_en'].'</td>
			  <td>'.$rates['rate'].'</td>
			  <td>'.$rates['import_lbp'].'</td>
			  <td>'.$rates['import_usd'].'</td>
			  <td>'.$rates['tones_import'].'</td>
			  <td>'.$rates['export_lbp'].'</td>
			  <td>'.$rates['export_usd'].'</td>
			  <td>'.$rates['tones_export'].'</td>
			  <td>'.$rates['year'].'</td>
			  <td>'._show_delete('items/delete/id/'.$id.'/item/'.$rates['heading_id'].'/p/rate', TRUE).'
			  		<a  style="cursor:pointer" onclick="editRate('.$id.')"><i class="isb-edit"></i></a>
			  </td>';
    }

    public function create_subhead() {
        if($this->p_add_subhead) {
            $code = $this->input->post('code');
            $title_ar = $this->input->post('title_ar');
            $title_en = $this->input->post('title_en');
            $status = $this->input->post('status');

            $data = array(
                    'code' => $code,
                    'title_ar' => $title_ar,
                    'title_en' => $title_en,
                    'code' => $code,
                    'create_time' => date('Y-m-d H:i:s'),
                    'update_time' => date('Y-m-d H:i:s'),
                    'user_id' => $this->session->userdata('id'),
            );

            if($id = $this->General->save('tbl_subhead', $data)) {
                $data['id'] = $id;
                $history = array('action' => 'add', 'logs_id' => $LID, 'item_id' => $id, 'type' => 'subhead', 'details' => json_encode($data), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                $this->General->save('logs', $history);
                $this->session->set_userdata(array('admin_message' => 'Add Successfully'));
                redirect('items/subhead/');
            }
        }
        else {
            $this->session->set_userdata(array('admin_message' => 'Access Denied'));
            redirect($this->page_denied);
        }
    }

    public function edit_subhead() {
        if($this->p_edit_subhead) {
            $code = $this->input->post('code');
            $title_ar = $this->input->post('title_ar');
            $title_en = $this->input->post('title_en');
            $status = $this->input->post('status');
            $id = $this->input->post('id');

            $data = array(
                    'code' => $code,
                    'title_ar' => $title_ar,
                    'title_en' => $title_en,
                    'status' => $status,
                    'update_time' => date('Y-m-d H:i:s'),
                    'user_id' => $this->session->userdata('id'),
            );
            $query = $this->Item->GetSubheadById($id);
            if($this->Administrator->edit('tbl_subhead', $data, $id)) {
                $newdata = $this->Administrator->affected_fields($query, $data);
                $history = array('action' => 'edit', 'logs_id' => 0, 'item_id' => $id, 'item_title' => $query['label_ar'], 'type' => 'subhead', 'details' => json_encode($newdata), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                $LID = $this->General->save('logs', $history);
                $this->session->set_userdata(array('admin_message' => 'Updated Successfully'));

                redirect('items/subhead/');
            }
        }
        else {
            $this->session->set_userdata(array('admin_message' => 'Access Denied'));
            redirect($this->page_denied);
        }
    }

    public function subhead($row = 0) {
        if($this->p_view_subhead) {
            $limit = 10;
            if(isset($_GET['search'])) {
                $row = $this->input->get('per_page');
                $code = $this->input->get('code');
                $description = $this->input->get('description');
                $query = $this->Item->SearchSubhead($code, $description, FALSE, $row, $limit);
                $total_row = count($this->Item->SearchSubhead($code, $description, FALSE, 0, 0));
                $config['base_url'] = base_url().'items/subhead?code='.$code.'&description='.$description.'&search=Search';
                $config['enable_query_strings'] = TRUE;
                $config['page_query_string'] = TRUE;
            }
            elseif(isset($_GET['clear'])) {
                redirect('items/subhead');
            }
            else {
                $code = '';
                $description = '';
                $config['base_url'] = base_url().'items/subhead';
                $query = $this->Item->GetSubhead('', $row, $limit);
                $total_row = count($this->Item->GetSubhead('', 0, 0));
                $this->pagination->initialize($config);
            }
            $this->data['code'] = $code;
            $this->data['description'] = $description;
            $config['total_rows'] = $total_row;
            $config['per_page'] = $limit;
            $config['num_links'] = 6;
            $this->pagination->initialize($config);
            $this->data['query'] = $query;
            $this->data['total_row'] = $total_row;
            $this->data['links'] = $this->pagination->create_links();
            $this->data['st'] = $this->uri->segment(4);

            $this->breadcrumb->clear();
            $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
            $this->breadcrumb->add_crumb('Items');
            $this->breadcrumb->add_crumb('Subhead', 'items/subhead/');
            $this->data['subtitle'] = 'Subhead';
            $this->data['query'] = $query;
            $this->data['msg'] = $this->session->userdata('admin_message');
            $this->session->unset_userdata('admin_message');
            $this->data['title'] = $this->data['Ctitle']." | Subhead";
            $this->template->load('_template', 'items/subhead', $this->data);
        }
        else {

            $this->session->set_userdata(array('admin_message' => 'Access Denied'));
            redirect($this->page_denied);
        }
    }

}
?>