<?php

class Addresses extends Application
{
	var $p_delete_governorate=FALSE;
	var $p_edit_governorate=FALSE;
	var $p_add_governorate=FALSE;
	var $p_view_governorate=FALSE;
	
	var $p_delete_district=FALSE;
	var $p_edit_district=FALSE;
	var $p_add_district=FALSE;
	var $p_view_district=FALSE;

	var $p_delete_area=FALSE;
	var $p_edit_area=FALSE;
	var $p_add_area=FALSE;
	var $p_view_area=FALSE;

	var $p_delete_country=FALSE;
	var $p_edit_country=FALSE;
	var $p_add_country=FALSE;
	var $p_view_country=FALSE;

	var $page_denied=FALSE;
	
	
	public function __construct()
	{

		parent::__construct();
		$this->ag_auth->restrict('items'); // restrict this controller to admins only
		$this->load->model(array('Administrator','Item','Address','Company','Bank','Parameter','Importer','Insurance','Transport'));
		$this->data['Ctitle']='Industry - Address ';
		
		$this->p_delete_governorate=$this->ag_auth->check_privilege(55,'delete');
		$this->p_edit_governorate=$this->ag_auth->check_privilege(55,'edit');
		$this->p_add_governorate=$this->ag_auth->check_privilege(55,'add');
		$this->p_view_governorate=$this->ag_auth->check_privilege(55,'view');
		$this->data['p_delete_governorate']=$this->p_delete_governorate;
		$this->data['p_edit_governorate']=$this->p_edit_governorate;
		$this->data['p_add_governorate']=$this->p_add_governorate;
		$this->data['p_view_governorate']=$this->p_view_governorate;
		
		$this->p_delete_district=$this->ag_auth->check_privilege(56,'delete');
		$this->p_edit_district=$this->ag_auth->check_privilege(56,'edit');
		$this->p_add_district=$this->ag_auth->check_privilege(56,'add');
		$this->p_view_district=$this->ag_auth->check_privilege(56,'view');
		$this->data['p_delete_district']=$this->p_delete_district;
		$this->data['p_edit_district']=$this->p_edit_district;
		$this->data['p_add_district']=$this->p_add_district;
		$this->data['p_view_district']=$this->p_view_district;

		$this->p_delete_area=$this->ag_auth->check_privilege(57,'delete');
		$this->p_edit_area=$this->ag_auth->check_privilege(57,'edit');
		$this->p_add_area=$this->ag_auth->check_privilege(57,'add');
		$this->p_view_area=$this->ag_auth->check_privilege(57,'view');
        $this->p_move_area=$this->ag_auth->check_privilege(57,'move');
		$this->data['p_delete_area']=$this->p_delete_area;
		$this->data['p_edit_area']=$this->p_edit_area;
		$this->data['p_add_area']=$this->p_add_area;
		$this->data['p_view_area']=$this->p_view_area;
        $this->data['p_move_area']=$this->p_move_area;

		$this->data['p_delete_country']=$this->p_delete_country=$this->ag_auth->check_privilege(61,'delete');
		$this->data['p_edit_country']=$this->p_edit_country=$this->ag_auth->check_privilege(61,'edit');
		$this->data['p_add_country']=$this->p_add_country=$this->ag_auth->check_privilege(61,'add');
		$this->data['p_view_country']=$this->p_view_country=$this->ag_auth->check_privilege(61,'view');
	
		$this->p_delete_subhead=$this->ag_auth->check_privilege(53,'delete');
		$this->p_edit_subhead=$this->ag_auth->check_privilege(53,'edit');
		$this->p_add_subhead=$this->ag_auth->check_privilege(53,'add');
		$this->p_view_subhead=$this->ag_auth->check_privilege(53,'view');
		$this->data['p_delete_subhead']=$this->p_delete_subhead;
		$this->data['p_edit_subhead']=$this->p_edit_subhead;
		$this->data['p_add_subhead']=$this->p_add_subhead;
		$this->data['p_view_subhead']=$this->p_view_subhead;
	
	
		$this->page_denied='denied';
		$this->data['page_denied']=$this->page_denied;
		
			
						
	}
	public function delete()
	{
		$get = $this->uri->ruri_to_assoc();
		if((int)$get['id'] > 0){
			switch($get['p'])
			{
				case 'governorate':
				if($this->p_delete_governorate){
					$query=$this->Address->GetGovernorateById($get['id']);
					$history=array('action'=>'delete','logs_id'=>0,'item_id'=>$get['id'],'item_title'=>$query['label_ar'],'type'=>'governorate','details'=>json_encode($query),'create_time'=>$this->datetime,'user_id' =>  $this->session->userdata('id'));
					$h_id=$this->General->save('logs',$history);
					
					$this->General->delete('tbl_governorates',array('id'=>$get['id']));
					$this->session->set_userdata(array('admin_message'=>'Deleted'));
					redirect('addresses/governorates');	
				}
				else{
					$this->session->set_userdata(array('admin_message'=>'Access Denied'));
					redirect($this->page_denied);	
					}
				break;
				
				case 'district':
				if($this->p_delete_district){
					$query=$this->Address->GetDistrictById($get['id']);
					$history=array('action'=>'delete','logs_id'=>0,'item_id'=>$get['id'],'item_title'=>$query['label_ar'],'type'=>'district','details'=>json_encode($query),'create_time'=>$this->datetime,'user_id' =>  $this->session->userdata('id'));
					$h_id=$this->General->save('logs',$history);
					$this->General->delete('tbl_districts',array('id'=>$get['id']));
					$this->session->set_userdata(array('admin_message'=>'Deleted'));
					redirect('addresses/districts');	
				}
				else{
					$this->session->set_userdata(array('admin_message'=>'Access Denied'));
					redirect($this->page_denied);	
					}			
				break;
				
				case 'area':
				if($this->p_delete_area){
					$query=$this->Address->GetAreaById($get['id']);
					$history=array('action'=>'delete','logs_id'=>0,'item_id'=>$get['id'],'item_title'=>$query['label_ar'],'type'=>'area','details'=>json_encode($query),'create_time'=>$this->datetime,'user_id' =>  $this->session->userdata('id'));
					$h_id=$this->General->save('logs',$history);
					$this->General->delete('tbl_area',array('id'=>$get['id']));
					$this->session->set_userdata(array('admin_message'=>'Deleted'));
					redirect('addresses/area');	
				}
				else{
					$this->session->set_userdata(array('admin_message'=>'Access Denied'));
					redirect($this->page_denied);	
					}					
				break;
				case 'country':
				if($this->p_delete_country){
					$query=$this->Address->GetCountryById($get['id']);
					$history=array('action'=>'delete','logs_id'=>0,'item_id'=>$get['id'],'item_title'=>$query['label_ar'],'type'=>'country','details'=>json_encode($query),'create_time'=>$this->datetime,'user_id' =>  $this->session->userdata('id'));
					$h_id=$this->General->save('logs',$history);
					$this->General->delete('tbl_countries',array('id'=>$get['id']));
					$this->session->set_userdata(array('admin_message'=>'Deleted'));
					redirect('addresses/countries');	
				}
				else{
					$this->session->set_userdata(array('admin_message'=>'Access Denied'));
					redirect($this->page_denied);	
					}
				break;
				
				
				}

		 } 
	}

public function GetDistricts()
	{
		$jsdis='id="district_id" onchange="getarea(this.value)" class="search-select"';
		$gov_id	= $_POST['id'];
		$districts=$this->Address->GetDistrictByGov('online',$gov_id);
        echo '
            <style type="text/css">
    #district_id{
        width:250px !important;
    }


</style>
            <script>
        $(document).ready(function() {
            $("#district_id").select2();
        });
    </script>';
		if(count($districts)>0){
		$array_districts['']='All';
		foreach($districts as $district)
			{
				$array_districts[$district->id]=$district->label_ar.' ('.$district->label_en.')';
			}
		}
		else{
				$array_districts['']='No Data Found';
			}			
		echo form_dropdown('district',$array_districts,'',$jsdis);
				}	
	public function GetArea()
	{
		$dist_id	= $_POST['id'];
        echo '
            <style type="text/css">
    #area_id{
        width:250px !important;
    }


</style>
            <script>
        $(document).ready(function() {
            $("#area_id").select2();
        });
    </script>';
		$areas=$this->Address->GetAreaByDistrict('online',$dist_id);
		if(count($areas)>0){
		$array_area['']='All';
		foreach($areas as $area)
			{
				$array_area[$area->id]=$area->label_ar.' ('.$area->label_en.')';
			}
		}
		else{
				$array_area['']='No Data Found';
			}			
		echo form_dropdown('area_id',$array_area,'','id="area_id" class="search-select"');
				}
    public function GetOldDistricts()
    {
        echo '
            <style type="text/css">
    #old_district_id{
        width:250px !important;
    }


</style>
            <script>
        $(document).ready(function() {
            $("#old_district_id").select2();
        });
    </script>';
        $jsdis='id="old_district_id" onchange="getoldarea(this.value)" class="search-select"';
        $gov_id	= $this->input->post('id');
        $districts=$this->Address->GetDistrictByGov('online',$gov_id);
        if(count($districts)>0){
            $array_districts['']='All';
            foreach($districts as $district)
            {
                $array_districts[$district->id]=$district->label_ar.' ('.$district->label_en.')';
            }
        }
        else{
            $array_districts['']='No Data Found';
        }
        echo form_dropdown('old_district',$array_districts,'',$jsdis);
    }
    public function GetOldArea()
    {
        $dist_id	= $this->input->post('id');
        $areas=$this->Address->GetAreaByDistrict('online',$dist_id);
        echo '
            <style type="text/css">
    #old_area_id{
    }


</style>
            <script>
        $(document).ready(function() {
            $("#old_area_id").select2();
        });
    </script>';
        if(count($areas)>0){
            $array_area['']='All';
            foreach($areas as $area)
            {
                $array_area[$area->id]=$area->label_ar.' ('.$area->label_en.')';
            }
        }
        else{
            $array_area['']='No Data Found';
        }
        echo form_dropdown('old_area_id',$array_area,'','id="old_area_id"  class="search-select"');
    }
    public function governorates()
	{
		if($this->p_view_governorate){
			
			$query=$this->Address->GetGovernorate('',0,0);
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Address');
			$this->breadcrumb->add_crumb('Governorates','addresses/governorates/');
			$this->data['subtitle'] = 'Governorates';	
			$this->data['query']=$query;
			$this->data['msg']=$this->session->userdata('admin_message');
			$this->session->unset_userdata('admin_message');		
			$this->data['title'] = $this->data['Ctitle']." | Sectors";
			$this->template->load('_template', 'address/governorates', $this->data);	
			}
		else{
			
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}	
	
	public function countries()
	{
		if($this->p_view_country){
			
			$query=$this->Address->GetCountries('',0,0);
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Address');
			$this->breadcrumb->add_crumb('Countries','addresses/countries/');
			$this->data['subtitle'] = 'Countries';	
			$this->data['query']=$query;
			$this->data['msg']=$this->session->userdata('admin_message');
			$this->session->unset_userdata('admin_message');		
			$this->data['title'] = $this->data['Ctitle']." | Countries";
			$this->template->load('_template', 'address/countries', $this->data);	
			}
		else{
			
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}	




	public function create_governorates()
	{
		if($this->p_add_governorate)
		{
		$label_ar=$this->input->post('label_ar');
		$label_en=$this->input->post('label_en');
		$status=$this->input->post('status');

		$data = array(
				'label_ar'=> $label_ar,
				'label_en'=> $label_en,
				'status'=> $status,
				'create_time' =>  date('Y-m-d H:i:s'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);

		if($id=$this->General->save('tbl_governorates',$data))
		{
			$history=array('action'=>'add','logs_id'=>0,'type'=>'governorate','details'=>json_encode($data),'item_id'=>$id,'create_time'=>$this->datetime,'user_id' =>  $this->session->userdata('id'));
            $this->General->save('logs',$history);
			$this->session->set_userdata(array('admin_message'=>'Add Successfully'));	
			redirect('addresses/governorates/');					
		}
		}
		else{
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}
	public function create_country()
	{
		if($this->p_add_country)
		{
		$label_ar=$this->input->post('label_ar');
		$label_en=$this->input->post('label_en');
		$status=$this->input->post('status');

		$data = array(
				'label_ar'=> $label_ar,
				'label_en'=> $label_en,
				'status'=> $status,
				'create_time' =>  date('Y-m-d H:i:s'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);

		if($id=$this->General->save('tbl_countries',$data))
		{
			$data['id']=$id;
			$history=array('action'=>'add','logs_id'=>0,'type'=>'country','details'=>json_encode($data),'item_id'=>$id,'create_time'=>$this->datetime,'user_id' =>  $this->session->userdata('id'));
            $this->General->save('logs',$history);
			$this->session->set_userdata(array('admin_message'=>'Add Successfully'));	
			redirect('addresses/countries/');					
		}
		}
		else{
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}
public function edit_governorates()
	{
		if($this->p_edit_governorate)
		{
		$label_ar=$this->input->post('label_ar');
		$label_en=$this->input->post('label_en');
		$status=$this->input->post('status');
		$id=$this->input->post('id');
		
		$data = array(
				'label_ar'=> $label_ar,
				'label_en'=> $label_en,
				'status'=> $status,
				'update_time' =>  date('Y-m-d H:i:s'),
			);
		$query=$this->Address->GetGovernorateById($id);
		if($this->Administrator->edit('tbl_governorates',$data,$id))
		{
			
			$newdata=$this->Administrator->affected_fields($query,$data);
			$history=array('action'=>'edit','logs_id'=>0,'item_id'=>$id,'item_title'=>$query['label_ar'],'type'=>'governorate','details'=>json_encode($newdata),'create_time'=>$this->datetime,'user_id' =>  $this->session->userdata('id'));
			$LID=$this->General->save('logs',$history);
			$this->session->set_userdata(array('admin_message'=>'Updated Successfully'));
				
			redirect('addresses/governorates/');					
		}
		}
		else{
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}

public function edit_country()
	{
		if($this->p_edit_country)
		{
		$label_ar=$this->input->post('label_ar');
		$label_en=$this->input->post('label_en');
		$status=$this->input->post('status');
		$id=$this->input->post('id');
		
		$data = array(
				'label_ar'=> $label_ar,
				'label_en'=> $label_en,
				'status'=> $status,
				'update_time' =>  date('Y-m-d H:i:s'),
			);
		$query=$this->Address->GetCountryById($id);
		if($this->Administrator->edit('tbl_countries',$data,$id))
		{
			$newdata=$this->Administrator->affected_fields($query,$data);
			$history=array('action'=>'edit','logs_id'=>0,'item_id'=>$id,'item_title'=>$query['label_ar'],'type'=>'country','details'=>json_encode($newdata),'create_time'=>$this->datetime,'user_id' =>  $this->session->userdata('id'));
			$LID=$this->General->save('logs',$history);
			$this->session->set_userdata(array('admin_message'=>'Updated Successfully'));
				
			redirect('addresses/countries/');					
		}
		}
		else{
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}

public function districts()
	{
		if($this->p_view_district){
			
			$query=$this->Address->GetDistrict('',0,0);
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Address');
			$this->breadcrumb->add_crumb('Districts','addresses/districts/');
			$this->data['subtitle'] = 'Districts';	
			$this->data['query']=$query;
			$this->data['governorates']=$this->Address->GetGovernorate('online',0,0);
			$this->data['msg']=$this->session->userdata('admin_message');
			$this->session->unset_userdata('admin_message');		
			$this->data['title'] = $this->data['Ctitle']." | Districts";
			$this->template->load('_template', 'address/districts', $this->data);	
			}
		else{
			
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}	
	public function create_district()
	{
		if($this->p_add_district)
		{
		$label_ar=$this->input->post('label_ar');
		$label_en=$this->input->post('label_en');
		$governorate_id=$this->input->post('governorate_id');

		$data = array(
				'label_ar'=> $label_ar,
				'label_en'=> $label_en,
				'governorate_id'=> $governorate_id,
				'create_time' =>  date('Y-m-d H:i:s'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);

		if($id=$this->General->save('tbl_districts',$data))
		{
			$history=array('action'=>'add','logs_id'=>0,'type'=>'district','details'=>json_encode($data),'item_id'=>$id,'create_time'=>$this->datetime,'user_id' =>  $this->session->userdata('id'));
            $this->General->save('logs',$history);
			$this->session->set_userdata(array('admin_message'=>'Add Successfully'));	
			redirect('addresses/districts/');					
		}
		}
		else{
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}
public function edit_district()
	{
		if($this->p_edit_district)
		{
		$label_ar=$this->input->post('label_ar');
		$label_en=$this->input->post('label_en');
		$governorate_id=$this->input->post('governorate_id');
		$id=$this->input->post('id');
		$data = array(
				'label_ar'=> $label_ar,
				'label_en'=> $label_en,
				'governorate_id'=> $governorate_id,
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);
		$query=$this->Address->GetDistrictById($id);
		if($this->Administrator->edit('tbl_districts',$data,$id))
		{
			$newdata=$this->Administrator->affected_fields($query,$data);
			$history=array('action'=>'edit','logs_id'=>0,'item_id'=>$id,'item_title'=>$query['label_ar'],'type'=>'district','details'=>json_encode($newdata),'create_time'=>$this->datetime,'user_id' =>  $this->session->userdata('id'));
			$LID=$this->General->save('logs',$history);
			$this->session->set_userdata(array('admin_message'=>'Updated Successfully'));
				
			redirect('addresses/districts/');					
		}
		}
		else{
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}

	public function create_area()
	{
		if($this->p_add_area)
		{
		$label_ar=$this->input->post('label_ar');
		$label_en=$this->input->post('label_en');
		$distric_id=$this->input->post('district');
		$governorate_id=$this->input->post('governorate_id');
		$status=$this->input->post('status');

		$data = array(
				'label_ar'=> $label_ar,
				'label_en'=> $label_en,
				'district_id'=> $distric_id,
				'governorate_id'=> $governorate_id,
				'status'=> $status,
				'create_time' =>  date('Y-m-d H:i:s'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);

		if($id=$this->General->save('tbl_area',$data))
		{
			$data['id']=$id;
			$history=array('action'=>'add','logs_id'=>0,'type'=>'area','details'=>json_encode($data),'item_id'=>$id,'create_time'=>$this->datetime,'user_id' =>  $this->session->userdata('id'));
            $this->General->save('logs',$history);
			$this->session->set_userdata(array('admin_message'=>'Add Successfully'));	
			redirect('addresses/area/');					
		}
		}
		else{
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}
    public function editarea($id)
    {
        if($this->p_edit_area)
        {
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Addresses');
        $this->breadcrumb->add_crumb('Cities', 'addresses/area/');
        $this->breadcrumb->add_crumb('Edit');

        $this->form_validation->set_rules('label_ar', 'الاسم', 'required');
        $this->form_validation->set_rules('label_en', 'Area english', 'required');

        $this->form_validation->set_rules('governorate_id', 'Mohafaza', 'required');
        $this->form_validation->set_rules('district', 'Kazaa', 'required');

        if($this->form_validation->run()) {


            $label_ar=$this->input->post('label_ar');
            $label_en=$this->input->post('label_en');
            $district_id=$this->input->post('district');
            $governorate_id=$this->input->post('governorate_id');
            $status=$this->input->post('status');

            $data = array(
                'label_ar'=> $label_ar,
                'label_en'=> $label_en,
                'district_id'=> $district_id,
                'governorate_id'=> $governorate_id,
                'status'=> $status,
                'update_time' =>  date('Y-m-d H:i:s'),
            );
            //var_dump($data);
            //die;
            $query=$this->Address->GetAreaById($id);
            if($this->Administrator->edit('tbl_area',$data,$id))
            {
                $newdata=$this->Administrator->affected_fields($query,$data);
                $history=array('action'=>'edit','logs_id'=>0,'item_id'=>$id,'item_title'=>$query['label_ar'],'type'=>'area','details'=>json_encode($newdata),'create_time'=>$this->datetime,'user_id' =>  $this->session->userdata('id'));
                $LID=$this->General->save('logs',$history);
                $this->session->set_userdata(array('admin_message'=>'Updated Successfully'));

                redirect('addresses/area/');
            }
            }
            $this->data['title'] = $this->data['Ctitle']." | Area";
            $this->data['query']=$query=$this->Address->GetAreaById($id);
            $this->data['governorates']=$this->Address->GetGovernorate('online',0,0);
            $this->data['districts']= $dists=$this->Address->GetDistrictByGov('online',@$query['governorate_id']);
            $this->template->load('_template', 'address/area_form', $this->data);
        }
        else{
            $this->session->set_userdata(array('admin_message'=>'Access Denied'));
            redirect($this->page_denied);

        }
    }

    public function edit_area()
	{
		if($this->p_edit_area)
		{
		$label_ar=$this->input->post('label_ar');
		$label_en=$this->input->post('label_en');
		$district_id=$this->input->post('district');
		$governorate_id=$this->input->post('governorate_id');
		$status=$this->input->post('status');
		$id=$this->input->post('id');
		var_dump($_POST);

            die;

		$data = array(
				'label_ar'=> $label_ar,
				'label_en'=> $label_en,
				'district_id'=> $district_id,
				'governorate_id'=> $governorate_id,
				'status'=> $status,
				'update_time' =>  date('Y-m-d H:i:s'),
			);
		//var_dump($data);
		//die;
		$query=$this->Address->GetAreaById($id);
		if($this->Administrator->edit('tbl_area',$data,$id))
		{
			$newdata=$this->Administrator->affected_fields($query,$data);
			$history=array('action'=>'edit','logs_id'=>0,'item_id'=>$id,'item_title'=>$query['label_ar'],'type'=>'area','details'=>json_encode($newdata),'create_time'=>$this->datetime,'user_id' =>  $this->session->userdata('id'));
			$LID=$this->General->save('logs',$history);
			$this->session->set_userdata(array('admin_message'=>'Updated Successfully'));
				
			redirect('addresses/area/');					
		}
		}
		else{
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}

public function area($row=0)
	{
		if($this->p_view_area){
				$limit=20;

		if(isset($_GET['search'])){
			$row=$this->input->get('per_page');	
			$area=$this->input->get('area');
			$district=$this->input->get('district');
			$gov=$this->input->get('gov');	
			$status=$this->input->get('status');	
			$query=$this->Address->SearchArea($area,$district,$gov,$status,$row,$limit);
			$total_row=count($this->Address->SearchArea($area,$district,$gov,$status,0,0));
			
			$config['base_url']=base_url().'addresses/area?area='.$area.'&district='.$district.'&gov='.$gov.'.&status='.$status.'&search=Search';	
			$config['enable_query_strings'] = TRUE;
			$config['page_query_string'] = TRUE; 
			$this->data['districts']=$this->Address->GetDistrictByGov('online',$gov);
			
			}
		elseif(isset($_GET['clear'])){
			redirect('addresses/area');	
			}	
		else{
		$area='';
		$district='';			
		$gov='';
		$status='';
		$this->data['districts']=array();
		$config['base_url']=base_url().'addresses/area';
		//$config['uri_segment'] = 12;		
		$query=$this->Address->GetArea($row,$limit);
		
		$total_row=count($this->Address->GetArea(0,0));
		
		$this->pagination->initialize($config);

			}	
			
			$this->data['area']=$area;
			$this->data['district']=$district;
			$this->data['gov']=$gov;
			$this->data['status']=$status;

		
		 
		$config['total_rows'] =$total_row;
		$config['per_page'] = $limit;
		
		$config['num_links'] = 6;
		
		
		$this->pagination->initialize($config); 	
		$this->data['query']=$query;
		$this->data['total_row']=$total_row;
		
		$this->data['links']=$this->pagination->create_links();
		$this->data['st']=$this->uri->segment(4);
		$this->data['governorates']=$this->Address->GetGovernorate('online',0,0);
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Dashboard','dashboard');
		$this->breadcrumb->add_crumb('Address');
		$this->breadcrumb->add_crumb('Area','addresses/area');
		$this->data['subtitle'] = 'Area';	
		$this->data['query']=$query;
		$this->data['msg']=$this->session->userdata('admin_message');
		$this->session->unset_userdata('admin_message');		
		$this->data['title'] = $this->data['Ctitle']." | Area";
		$this->template->load('_template', 'address/area', $this->data);	
		}
		else{
			
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}			
	}
    public function changing_area()
    {
        if($this->p_move_area)
        {
            $old_area=$this->input->post('old_area');
            $old_district=$this->input->post('old_district');
            $old_gov=$this->input->post('old_gov');

            $new_area=$this->input->post('new_area');
            $new_district=$this->input->post('new_district');
            $new_gov=$this->input->post('new_gov');

            $companies=$this->Administrator->update('tbl_company',array('area_id'=>$new_area,'district_id'=>$new_district,'governorate_id'=>$new_gov),array('area_id'=>$old_area,'district_id'=>$old_district,'governorate_id'=>$old_gov));
            $banks=$this->Administrator->update('tbl_bank',array('area_id'=>$new_area,'district_id'=>$new_district,'governorate_id'=>$new_gov),array('area_id'=>$old_area,'district_id'=>$old_district,'governorate_id'=>$old_gov));
            $importers=$this->Administrator->update('tbl_importers',array('area_id'=>$new_area,'district_id'=>$new_district,'governorate_id'=>$new_gov),array('area_id'=>$old_area,'district_id'=>$old_district,'governorate_id'=>$old_gov));
            $insurances=$this->Administrator->update('tbl_insurances',array('area_id'=>$new_area,'district_id'=>$new_district,'governorate_id'=>$new_gov),array('area_id'=>$old_area,'district_id'=>$old_district,'governorate_id'=>$old_gov));
            $transport=$this->Administrator->update('tbl_transport',array('area_id'=>$new_area,'district_id'=>$new_district,'governorate_id'=>$new_gov),array('area_id'=>$old_area,'district_id'=>$old_district,'governorate_id'=>$old_gov));


            $this->session->set_userdata(array('admin_message'=>'Updated Successfully<br>'.$companies.' companies<br>'.$banks.' banks<br>'.$importers.' importer companies<br>'.$insurances.' insurance companies<br>'.$transport.' transportation companies'));
            redirect('addresses/area/');

        }
        else{
            $this->session->set_userdata(array('admin_message'=>'Access Denied'));
            redirect($this->page_denied);

        }
    }
    public function changingarea()
    {
        if($this->p_move_area)
        {
            $this->breadcrumb->clear();
            $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
            $this->breadcrumb->add_crumb('Addresses');
            $this->breadcrumb->add_crumb('Cities', 'addresses/area/');
            $this->breadcrumb->add_crumb('Move');

            $this->form_validation->set_rules('old_area_id', 'Old Area', 'required');
            $this->form_validation->set_rules('old_district', 'Old District', 'required');
            $this->form_validation->set_rules('old_gov', 'Old Governorate', 'required');

            $this->form_validation->set_rules('area_id', 'New Area', 'required');
            $this->form_validation->set_rules('district', 'New District', 'required');
            $this->form_validation->set_rules('new_gov', 'New Governorate', 'required');

            if($this->form_validation->run()) {



                $old_area=$this->input->post('old_area_id');
                $old_district=$this->input->post('old_district');
                $old_gov=$this->input->post('old_gov');

                $new_area=$this->input->post('area_id');
                $new_district=$this->input->post('district');
                $new_gov=$this->input->post('new_gov');

                $companies=$this->Administrator->update('tbl_company',array('area_id'=>$new_area,'district_id'=>$new_district,'governorate_id'=>$new_gov),array('area_id'=>$old_area,'district_id'=>$old_district,'governorate_id'=>$old_gov));
                $banks=$this->Administrator->update('tbl_bank',array('area_id'=>$new_area,'district_id'=>$new_district,'governorate_id'=>$new_gov),array('area_id'=>$old_area,'district_id'=>$old_district,'governorate_id'=>$old_gov));
                $importers=$this->Administrator->update('tbl_importers',array('area_id'=>$new_area,'district_id'=>$new_district,'governorate_id'=>$new_gov),array('area_id'=>$old_area,'district_id'=>$old_district,'governorate_id'=>$old_gov));
                $insurances=$this->Administrator->update('tbl_insurances',array('area_id'=>$new_area,'district_id'=>$new_district,'governorate_id'=>$new_gov),array('area_id'=>$old_area,'district_id'=>$old_district,'governorate_id'=>$old_gov));
                $transport=$this->Administrator->update('tbl_transport',array('area_id'=>$new_area,'district_id'=>$new_district,'governorate_id'=>$new_gov),array('area_id'=>$old_area,'district_id'=>$old_district,'governorate_id'=>$old_gov));


                $this->session->set_userdata(array('admin_message'=>'Updated Successfully<br>'.$companies.' companies<br>'.$banks.' banks<br>'.$importers.' importer companies<br>'.$insurances.' insurance companies<br>'.$transport.' transportation companies'));
                redirect('addresses/area/');
            }
            $this->data['title'] = $this->data['Ctitle']." | Area";
            $this->data['governorates']=$this->Address->GetGovernorate('online',0,0);
            $this->template->load('_template', 'address/area_move', $this->data);
        }
        else{
            $this->session->set_userdata(array('admin_message'=>'Access Denied'));
            redirect($this->page_denied);

        }
    }
		
}

?>