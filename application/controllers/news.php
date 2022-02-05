<?php

class News extends Application
{

    public function __construct()
    {

        parent::__construct();
        $this->ag_auth->restrict('news'); // restrict this controller to admins only
        $this->load->model(array('Administrator'));
        $this->data['Ctitle']='Industry';

    }

    public function delete($id)
    {
        if((int)$id > 0){

            $this->General->delete('news',array('id'=>$id));
            $this->session->set_userdata(array('admin_message'=>'Deleted'));
            redirect('news');

        }
    }
    public function remove_thumbnail($id)
    {
        if((int)$id > 0){
            $this->Administrator->edit('news',array('url'=>''),$id);
            $this->session->set_userdata(array('admin_message'=>'Thumbnail Deleted'));
            redirect('news');

        }
    }

    public function remove_img($id)
    {
        if((int)$id > 0){

            $this->Administrator->edit('news',array('img'=>''),$id);
            $this->session->set_userdata(array('admin_message'=>'Image Deleted'));
            redirect('news');

        }
    }


    public function delete_checked()
    {
        $delete_array=$this->input->post('checkbox1');
        if(empty($delete_array)) {
            $this->session->set_userdata(array('admin_message'=>'No Item Checked'));
        }
        else {
            foreach($delete_array as $d_id) {
                $this->General->delete('news',array('id'=>$d_id));
            }
            $this->session->set_userdata(array('admin_message'=>'Deleted'));
            redirect('news/');
        }

    }

    public function index()
    {
        /*	$p_delete=$this->ag_auth->check_privilege($this->session->userdata('privileges'),6,17,'delete');
            $p_edit=$this->ag_auth->check_privilege($this->session->userdata('privileges'),6,17,'edit');
            $p_add=$this->ag_auth->check_privilege($this->session->userdata('privileges'),6,16,'add');
            */
        $this->data['p_delete']=TRUE;
        $this->data['p_edit']=TRUE;
        $this->data['p_add']=TRUE;
        $this->data['msg']=$this->session->userdata('admin_message');
        $this->session->unset_userdata('admin_message');
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard','dashboard');
        $this->breadcrumb->add_crumb('News');
        $this->data['title'] = $this->data['Ctitle']." - Banner";
        $this->data['subtitle'] = "Banner";
        $this->data['query']=$this->Administrator->GetNews('');
        $this->template->load('_template', 'news', $this->data);
    }
    public function details($id)
    {
        /*	$p_delete=$this->ag_auth->check_privilege($this->session->userdata('privileges'),6,17,'delete');
            $p_edit=$this->ag_auth->check_privilege($this->session->userdata('privileges'),6,17,'edit');
            $p_add=$this->ag_auth->check_privilege($this->session->userdata('privileges'),6,16,'add');
            */
        $query=$this->Administrator->GetCompanyById($id);
        $this->data['query']=$query;

        $this->data['p_delete']=TRUE;
        $this->data['p_edit']=TRUE;
        $this->data['p_add']=TRUE;
        $this->data['msg']=$this->session->userdata('admin_message');
        $this->session->unset_userdata('admin_message');
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard','dashboard');
        $this->breadcrumb->add_crumb('Companies');
        $this->data['title'] = $this->data['Ctitle']." - Companies - الشركات";;
        $this->data['subtitle'] = "Companies - الشركات";
        $this->data['sectors']=$this->Item->GetSector('online',0,0);
        $this->data['sections']=$this->Item->GetSection('online',0,0);
        $this->data['governorates']=$this->Address->GetGovernorateById($query['governorate_id']);
        $this->data['districts']=$this->Address->GetDistrictById($query['district_id']);
        $this->data['area']=$this->Address->GetAreaById($query['are_code_office']);
        $this->data['items']=$this->Company->GetProductionInfo($id);
        $this->template->load('_template', 'company/details', $this->data);
    }

    public function create()
    {
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard','dashboard');
        $this->breadcrumb->add_crumb('Banners','banners');
        $this->breadcrumb->add_crumb('Add New Banner');

        $this->form_validation->set_rules('title_ar', 'Banner Title in arabic', 'required');
        $this->form_validation->set_rules('title_en', 'Banner Title in english', 'trim');
        $this->form_validation->set_rules('details_ar', 'details_ar', 'trim');
        $this->form_validation->set_rules('details_en', 'details_en', 'trim');
        $this->form_validation->set_rules('fdate', 'From date', 'trim');
        $this->form_validation->set_rules('tdate', 'To date', 'trim');
        $this->form_validation->set_rules('status', 'status', 'trim');
        $this->form_validation->set_rules('category', 'Category', 'trim');
        $this->form_validation->set_rules('position', 'Position', 'required');
        $this->form_validation->set_rules('type', 'Type', 'required');
        $this->form_validation->set_rules('external_link', 'External link', 'trim');


        if ($this->form_validation->run()) {

            $array=$this->Administrator->do_upload('uploads/');

            if($array['target_path']!=""){
                $path=$array['target_path'];
            }
            else{
                $path=$this->input->post('url');
            }
            $array1=$this->Administrator->do_upload('uploads/','img');

            if($array1['target_path']!=""){
                $path1=$array1['target_path'];
            }
            else{
                $path1=$this->input->post('img_url');
            }

            $msg=$array['error'];
            $data = array(
                'title_ar'=> $this->form_validation->set_value('title_ar'),
                'title_en'=> $this->form_validation->set_value('title_en'),
                'details_ar'=> $this->form_validation->set_value('details_ar'),
                'details_en'=> $this->form_validation->set_value('details_en'),
                'url'	=>$path,
                'img'	=>$path1,
                'fdate'=> $this->form_validation->set_value('fdate'),
                'tdate'=> $this->form_validation->set_value('tdate'),
                'status'=> $this->form_validation->set_value('status'),
                'category'=> 'vacancy',
                'position'=> $this->form_validation->set_value('position'),
                'external_link'=> $this->form_validation->set_value('external_link'),
                'type'=> $this->form_validation->set_value('type'),
                'create_time' =>  date('Y-m-d H:i:s'),
                'update_time' =>  date('Y-m-d H:i:s'),
                'user_id' =>  $this->session->userdata('id'),
            );

            if($id=$this->General->save('news',$data))
            {
                $this->session->set_userdata(array('admin_message'=>'Banner Added successfully'));
                redirect('news');
            }
            else
            {
                $this->session->set_userdata(array('admin_message'=>'Error'));
                redirect('news/create');
            }

        }

        $this->data['subtitle'] = 'Add New Banner';
        $this->data['title'] = $this->data['Ctitle']."- Add New Banner";
        $this->template->load('_template', 'news_form', $this->data);
    }

    public function edit($id)
    {
        $this->data['query']=$query=$this->Administrator->GetNewsById($id);
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard','dashboard');
        $this->breadcrumb->add_crumb('Banners','banners');
        $this->breadcrumb->add_crumb('Edit');

        $this->form_validation->set_rules('title_ar', 'Banner Title in arabic', 'required');
        $this->form_validation->set_rules('title_en', 'Banner Title in english', 'trim');
        $this->form_validation->set_rules('details_ar', 'details_ar', 'trim');
        $this->form_validation->set_rules('details_en', 'details_en', 'trim');
        $this->form_validation->set_rules('fdate', 'From date', 'trim');
        $this->form_validation->set_rules('tdate', 'To date', 'trim');
        $this->form_validation->set_rules('status', 'status', 'trim');
        $this->form_validation->set_rules('category', 'Category', 'trim');
        $this->form_validation->set_rules('position', 'Position', 'required');
        $this->form_validation->set_rules('external_link', 'External link', 'trim');
        $this->form_validation->set_rules('type', 'Type', 'required');


        if ($this->form_validation->run()) {



            $array=$this->Administrator->do_upload('uploads/');

            if($array['target_path']!=""){
                $path=$array['target_path'];
            }
            else{
                $path=$this->input->post('url');
            }

            $array1=$this->Administrator->do_upload('uploads/','img');

            if($array1['target_path']!=""){
                $path1=$array1['target_path'];
            }
            else{
                $path1=$this->input->post('img_url');
            }

            $msg=$array['error'];
            $data = array(
                'title_ar'=> $this->form_validation->set_value('title_ar'),
                'title_en'=> $this->form_validation->set_value('title_en'),
                'details_ar'=> $this->form_validation->set_value('details_ar'),
                'details_en'=> $this->form_validation->set_value('details_en'),
                'url'	=>$path,
                'img'	=>$path1,
                'fdate'=> $this->form_validation->set_value('fdate'),
                'tdate'=> $this->form_validation->set_value('tdate'),
                'status'=> $this->form_validation->set_value('status'),
                'category'=> 'vacancy',
                'position'=> $this->form_validation->set_value('position'),
                'external_link'=> $this->form_validation->set_value('external_link'),
                'type'=> $this->form_validation->set_value('type'),
                'update_time' =>  date('Y-m-d H:i:s'),
            );

            if($this->Administrator->edit('news',$data,$id))
            {
                $this->session->set_userdata(array('admin_message'=>'Updated successfully'));
                redirect('news');
            }
            else
            {
                $this->session->set_userdata(array('admin_message'=>'Error'));
                redirect('news/edit/'.$id);
            }

        }

        $this->data['subtitle'] = 'Edit';
        $this->data['title'] = $this->data['Ctitle']."- Edit";
        $this->template->load('_template', 'news_form', $this->data);
    }
    public function power($id,$item_id='')
    {

        /*	$p_delete=$this->ag_auth->check_privilege($this->session->userdata('privileges'),6,17,'delete');
            $p_edit=$this->ag_auth->check_privilege($this->session->userdata('privileges'),6,17,'edit');
            $p_add=$this->ag_auth->check_privilege($this->session->userdata('privileges'),6,16,'add');
            */
        $query=$this->Company->GetCompanyById($id);
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard','dashboard');
        $this->breadcrumb->add_crumb('Companies','companies');
        $this->breadcrumb->add_crumb($query['name_en'],'companies/details/'.$id);
        $this->breadcrumb->add_crumb('Electric Power','companies/power/'.$id);

        $this->form_validation->set_rules('fuel', 'fuel', 'required');
        $this->form_validation->set_rules('diesel', 'diesel', 'required');
        if ($this->form_validation->run()) {
            if($_POST['action']=='add'){
                $data = array(
                    'company_id'=> $id,
                    'fuel'=> $this->form_validation->set_value('fuel'),
                    'diesel'=> $this->form_validation->set_value('diesel'),
                    'create_time' =>  date('Y-m-d H:i:s'),
                    'update_time' =>  date('Y-m-d H:i:s'),
                    'user_id' =>  $this->session->userdata('id'),
                );

                if($this->General->save($this->company_power,$data))
                {
                    $this->session->set_userdata(array('admin_message'=>'Electric Power Item Added successfully'));
                    redirect('companies/power/'.$id);
                }
                else
                {
                    $this->session->set_userdata(array('admin_message'=>'Error'));
                    redirect('companies/power/'.$id.'/'.$item_id);
                }
            }
            else{
                $data = array(
                    'company_id'=> $id,
                    'fuel'=> $this->form_validation->set_value('fuel'),
                    'diesel'=> $this->form_validation->set_value('diesel'),
                    'update_time' =>  date('Y-m-d H:i:s'),
                    'user_id' =>  $this->session->userdata('id'),
                );

                if($this->Administrator->edit($this->company_power,$data,$item_id))
                {
                    $this->session->set_userdata(array('admin_message'=>'Electric Power Item Updated successfully'));
                    redirect('companies/power/'.$id);
                }
                else
                {
                    $this->session->set_userdata(array('admin_message'=>'Error'));
                    redirect('companies/power/'.$id.'/'.$item_id);
                }
            }
        }
        if($item_id==''){

            $this->data['subtitle'] = 'Add';
            $this->data['action'] = 'add';
            $this->data['display']='';
            $fuel='';
            $diesel='';

        }
        else{

            $row=$this->Company->GetCompanyElectricPowerById($item_id);

            $this->data['subtitle'] = 'Edit';
            $this->data['action'] = 'edit';
            $this->data['display']=$row['fuel'].'<br><hr />'.$row['diesel'];
            $fuel=$row['fuel'];
            $diesel=$row['diesel'];
        }
        $this->data['c_id'] = $id;

        $this->data['fuel'] = $fuel;
        $this->data['diesel'] = $diesel;
        $this->data['query']=$query;

        $this->data['p_delete']=TRUE;
        $this->data['p_edit']=TRUE;
        $this->data['p_add']=TRUE;
        $this->data['msg']=$this->session->userdata('admin_message');
        $this->session->unset_userdata('admin_message');
        $this->data['items']=$this->Company->GetCompanyElectricPowers($id);
        $this->data['title'] = $this->data['Ctitle']." - Companies - الشركات";
        $this->template->load('_template', 'company/electric_power', $this->data);
    }


}

?>