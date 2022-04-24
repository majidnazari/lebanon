<?php
	class General extends CI_Model{
		
	
	function GetGPSCompanies()
	{
		$this->db->select('companies_gps.*');	
		$this->db->from('companies_gps');			
		$query = $this->db->get();
		return $query->result();
	}
	function GetPage($id)
	{
		$this->db->select('groups.*');	
		$this->db->from('groups');			
		$this->db->where('groups.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}
	function GetNavigations($group_id)
	{
		$this->db->select('navigations.*');	
		$this->db->from('navigations');		
		$this->db->where('navigations.group_id',$group_id);			
		$query = $this->db->get();
		return $query->row_array();
	}	
	function GetUserPrivileges($user_id)
	{
		$this->db->select('privilege.*');
		$this->db->from('privilege');			
		$this->db->where('privilege.user_id',$user_id);
		$query = $this->db->get();
		return $query->result();
	}
	function GetGroupPrivileges($user_id,$group_id)
	{
		$this->db->select('privilege.*');
		$this->db->from('privilege');			
		$this->db->where('privilege.user_id',$user_id);
		$this->db->where('privilege.group_id',$group_id);
		$query = $this->db->get();
		return $query->row_array();
	}	
	function GetSalesMen($status='')
	{
		$this->db->select('tbl_sales_man.*');
		$this->db->from('tbl_sales_man');
		if($status!='')
		$this->db->where('tbl_sales_man.status',$status);
		$this->db->order_by("fullname_en", "asc"); 
		$query = $this->db->get();
		return $query->result();
	}
	function GetSalesManById($id)
	{
		$this->db->select('tbl_sales_man.*');
		$this->db->from('tbl_sales_man');
		$this->db->where('tbl_sales_man.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}	
	public function GetPeriodeNummer() {
		$this->db->select_max('id');
		$query = $this->db->get('certificate_warranty');
		return $query->row_array();

	}	
	function GetPackageById($id)
	{
		$this->db->select('packages.*');
		$this->db->from('packages');
		$this->db->where('packages.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}	
	function GetMakes()
	{
		$query = $this->db->get('makes');
		return $query->result();
	}	
	function GetModels()
	{
		$query = $this->db->get('models');
		return $query->result();
	}	
	function GetColors()
	{
		$query = $this->db->get('colors');
		return $query->result();
	}			
	
	function GetGalleries($item_id,$cat_id)
	{
		$this->db->select('galleries.*');
		$this->db->from('galleries');
		$this->db->where('galleries.item_id',$item_id);
		$this->db->where('galleries.category_id',$cat_id);				
		$query = $this->db->get();
		return $query->result();
	}	
	
	function GetEvents($lang)
	{
		$this->db->select('news.*');
		$this->db->from('news');
		$this->db->where('news.status','online');
		$this->db->where('news.language',$lang);
		$this->db->order_by("id", "desc"); 
		$query = $this->db->get();
		return $query->result();
	}
	
	function GetEventById($id)
	{
		$this->db->select('news.*');
		$this->db->from('news');
		$this->db->where('news.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}	
		
	
	
	function NewsSearch($key)
	{
		$this->db->select('news.*');
		$this->db->select('news_categories.title as category');
		$this->db->select('news_categories.title_ar as category_ar');
		$this->db->from('news');
		$this->db->join('news_categories', 'news_categories.id = news.cat_news_id');
		$this->db->where('news.status','online');
		$this->db->like('news.title',$key);
		$this->db->or_like('news_categories.title',$key);			
		$this->db->order_by("id", "desc"); 
		$query = $this->db->get();
		return $query->result();
	}
	function GetLatestNews($lang)
	{
		$this->db->select('news.*');
		$this->db->from('news');
		$this->db->where('news.status','online');
		$this->db->where('news.language',$lang);
		$this->db->order_by("id", "desc"); 
		$query = $this->db->get();
		return $query->result();
	}	
	function GetAllGallery()
	{
		$this->db->select('galleries.*');
		$this->db->from('galleries');
		$this->db->where('galleries.category_id',0);
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}
		
	function VacanciesSearch($key)
	{
		$this->db->select('vacancies.*');
		$this->db->select('categories.category as category');
		$this->db->select('categories.category_ar as category_ar');
		$this->db->select('countries.country as country');
		$this->db->select('countries.country_ar as country_ar');
		$this->db->from('vacancies');
		$this->db->join('categories', 'categories.id = vacancies.category_id');
		$this->db->join('countries', 'countries.id = vacancies.country_id');
		$this->db->where('vacancies.activate','online');	
		$this->db->like('vacancies.title',$key);
		$this->db->or_like('countries.country',$key);
		$this->db->or_like('categories.category',$key);			
		$query = $this->db->get();
		return $query->result();
	}
	function IdeasSearch($key)
	{
		$this->db->select('ideas.*');
		$this->db->select('categories.category as category');
		$this->db->select('categories.category_ar as category_ar');
		$this->db->select('countries.country as country');
		$this->db->select('countries.country_ar as country_ar');
		$this->db->from('ideas');
		$this->db->join('categories', 'categories.id = ideas.category_id');
		$this->db->join('countries', 'countries.id = ideas.country_id');
		$this->db->where('ideas.status','online');
		$this->db->like('countries.country',$key);
		$this->db->or_like('categories.category',$key);	
		$this->db->order_by("ideas.id", "desc");				
		$query = $this->db->get();
		return $query->result();
	}	
	function GetNews($cat,$lang)
	{
		$this->db->select('news.*');
		$this->db->select('news_categories.title as category');
		$this->db->select('news_categories.title_ar as category_ar');
		$this->db->from('news');
		$this->db->join('news_categories', 'news_categories.id = news.cat_news_id');
		$this->db->where('news.status','online');
		$this->db->where('news.language',$lang);
		$this->db->where('news.cat_news_id',$cat);
		$this->db->order_by("id", "desc"); 
		$query = $this->db->get();
		return $query->result();
	}
	function GetRepresentatives($cat)
	{
		$this->db->select('representatives.*');
		$this->db->select('rep_categories.title as category');
		$this->db->select('rep_categories.title_ar as category_ar');
		$this->db->from('representatives');
		$this->db->join('rep_categories', 'rep_categories.id = representatives.rep_cat_id');
		$this->db->where('representatives.status','online');
		$this->db->where('representatives.rep_cat_id',$cat);
		$this->db->order_by("id", "desc"); 
		$query = $this->db->get();
		return $query->result();
	}		
	function GetRepCategoryById($cat)
	{
		$this->db->select('rep_categories.*');
		$this->db->from('rep_categories');
		$this->db->where('rep_categories.id',$cat);
		$query = $this->db->get();
		return $query->row_array();
	}		
	function GetGuides($cat,$subcat)
	{
		$this->db->select('guides.*');
		$this->db->select('guide_subcategories.title as category');
		$this->db->select('guide_subcategories.title_ar as category_ar');
		$this->db->from('guides');
		$this->db->join('guide_subcategories', 'guide_subcategories.id = guides.category_id');
		$this->db->where('guides.status','online');
		$this->db->where('guides.category_id',$cat);
		$this->db->where('guides.subcat_id',$subcat);
		$this->db->order_by("id", "desc"); 
		$query = $this->db->get();
		return $query->result();
	}
	function GetGuideSubCategoryById($id)
	{
		$this->db->select('guide_subcategories.*');
		$this->db->from('guide_subcategories');
		$this->db->where('guide_subcategories.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}
	function GetGuideById($id)
	{
		$this->db->select('guides.*');
		$this->db->select('guide_subcategories.title as category');
		$this->db->select('countries.country as country');
		$this->db->select('countries.country_ar as country_ar');
		$this->db->select('guide_subcategories.title_ar as category_ar');
		$this->db->from('guides');
		$this->db->join('guide_subcategories', 'guide_subcategories.id = guides.category_id');
		$this->db->join('countries', 'countries.id = guides.location_id');
		$this->db->where('guides.status','online');
		$this->db->where('guides.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}			
	function GetNewsHome($cat,$limit,$row,$lang)
	{
		$this->db->select('news.*');
		$this->db->select('news_categories.title as category');
		$this->db->select('news_categories.title_ar as category_ar');
		$this->db->from('news');
		$this->db->join('news_categories', 'news_categories.id = news.cat_news_id');
		$this->db->where('news.status','online');
		$this->db->where('news.language',$lang);
		$this->db->where('news.cat_news_id',$cat);
		$this->db->order_by("id", "desc"); 
		$this->db->limit($limit,$row);
		$query = $this->db->get();
		return $query->result();
	}	
	function GetNewsById($id)
	{
		$this->db->select('news.*');
		$this->db->select('news_categories.title as category');
		$this->db->select('news_categories.title_ar as category_ar');
		$this->db->from('news');
		$this->db->join('news_categories', 'news_categories.id = news.cat_news_id');
		$this->db->where('news.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}	
	function GetNewsNum($cat)
	{
		$this->db->select('news.*');
		$this->db->select('news_categories.title as category');
		$this->db->select('news_categories.title_ar as category_ar');
		$this->db->from('news');
		$this->db->join('news_categories', 'news_categories.id = news.cat_news_id');
		$this->db->where('news.cat_news_id',$cat);
		$this->db->order_by("id", "desc"); 
		$query = $this->db->get();
		return $query->num_rows();
	}
	function GetNewsCategoryById($id)
	{
		$this->db->select('news_categories.*');
		$this->db->from('news_categories');
		$this->db->where('news_categories.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}	
		function GetBanners()
	{
		$this->db->select('banners.*');
		$this->db->from('banners');
		$this->db->where('banners.status','online');
		$query = $this->db->get();
		return $query->result();
	}
	function GetAllTrustees()
	{
		$this->db->select('trustees.*');
		$this->db->from('trustees');
		$this->db->where('trustees.status','online');
		$this->db->order_by("fullname", "asc"); 
		$query = $this->db->get();
		return $query->result();
	}	
	function GetCategoryById($id)
	{
		$this->db->select('categories.*');
		$this->db->from('categories');
		$this->db->where('categories.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}
	function GetCategories()
	{
		$this->db->select('categories.*');
		$this->db->from('categories');
		$query = $this->db->get();
		return $query->result();
	}	
	function GetEmployers()
	{
		$this->db->select('employers.*');
		$this->db->select('categories.category as category');
		$this->db->select('categories.category_ar as category_ar');
		$this->db->select('countries.country as country');
		$this->db->select('countries.country_ar as country_ar');
		$this->db->from('employers');
		$this->db->join('categories', 'categories.id = employers.category_id');
		$this->db->join('countries', 'countries.id = employers.country_id');
		$this->db->order_by("employers.title", "asc");
		$query = $this->db->get();
		return $query->result();
	}
	function GetEmployerByCategory($cat)
	{
		$this->db->select('employers.*');
		$this->db->select('categories.category as category');
		$this->db->select('categories.category_ar as category_ar');
		$this->db->select('countries.country as country');
		$this->db->select('countries.country_ar as country_ar');
		$this->db->from('employers');
		$this->db->join('categories', 'categories.id = employers.category_id');
		$this->db->join('countries', 'countries.id = employers.country_id');
		$this->db->where('employers.category_id',$cat);
		$this->db->order_by("employers.title", "asc");
		$query = $this->db->get();
		return $query->result();
	}
	function GetEmployerByLocation($location)
	{
		$this->db->select('employers.*');
		$this->db->select('categories.category as category');
		$this->db->select('categories.category_ar as category_ar');
		$this->db->select('countries.country as country');
		$this->db->select('countries.country_ar as country_ar');
		$this->db->from('employers');
		$this->db->join('categories', 'categories.id = employers.category_id');
		$this->db->join('countries', 'countries.id = employers.country_id');
		$this->db->where('employers.country_id',$location);
		$this->db->order_by("employers.title", "asc");
		$query = $this->db->get();
		return $query->result();
	}
	function EmployersSearch($cat,$location,$emp)
	{
		$this->db->select('employers.*');
		$this->db->select('categories.category as category');
		$this->db->select('categories.category_ar as category_ar');
		$this->db->select('countries.country as country');
		$this->db->select('countries.country_ar as country_ar');
		$this->db->from('employers');
		$this->db->join('categories', 'categories.id = employers.category_id');
		$this->db->join('countries', 'countries.id = employers.country_id');
		if($emp!=0){
			$this->db->where('employers.id',$emp);
			}
		if($location!=0){
			$this->db->where('employers.country_id',$location);
			}
		if($cat!=0){				
		$this->db->where('employers.category_id',$cat);
		}
		$this->db->order_by("employers.title", "asc");
		$query = $this->db->get();
		return $query->result();
	}		
	function GetEmployerById($id)
	{
		$this->db->select('employers.*');
		$this->db->select('categories.category as category');
		$this->db->select('categories.category_ar as category_ar');
		$this->db->select('countries.country as country');
		$this->db->select('countries.country_ar as country_ar');
		$this->db->from('employers');
		$this->db->join('categories', 'categories.id = employers.category_id');
		$this->db->join('countries', 'countries.id = employers.country_id');
		$this->db->where('employers.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}		
	function GetSexById($id)
	{
		$this->db->select('sex.*');
		$this->db->from('sex');
		$this->db->where('sex.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}
	function GetSex()
	{
		$this->db->select('sex.*');
		$this->db->from('sex');
		$query = $this->db->get();
		return $query->result();
	}	
	function GetRelationshipById($id)
	{
		$this->db->select('relationship.*');
		$this->db->from('relationship');
		$this->db->where('relationship.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}
	function GetRelationship()
	{
		$this->db->select('relationship.*');
		$this->db->from('relationship');
		$query = $this->db->get();
		return $query->result();
	}	
	function GetLanguageById($id)
	{
		$this->db->select('languages.*');
		$this->db->from('languages');
		$this->db->where('languages.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}
	function GetLanguage()
	{
		$this->db->select('languages.*');
		$this->db->from('languages');
		$query = $this->db->get();
		return $query->result();
	}
	function GetMonths()
	{
		$this->db->select('months.*');
		$this->db->from('months');
		$query = $this->db->get();
		return $query->result();
	}		
	function GetCountryById($id)
	{
		$this->db->select('countries.*');
		$this->db->from('countries');
		$this->db->where('countries.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}				

	function GetCountries()
	{
		$query = $this->db->get('countries');
		return $query->result();
	}

	function GetAllEmployers()
	{
		$query = $this->db->get('employers');
		return $query->result();
	}

	function GetDegreeAttained()
	{
		$query = $this->db->get('degree_attained');
		return $query->result();
	}
	function GetExperienceLevels()
	{
		$query = $this->db->get('experience_levels');
		return $query->result();
	}
	function GetProficiencies()
	{
		$query = $this->db->get('proficiencies');
		return $query->result();
	}
	function GetCareersCategories()
	{
		$query = $this->db->get('careers_categories');
		return $query->result();
	}
	function GetSubCategoryById($id)
	{
		$this->db->select('careers_subcategories.*');
		$this->db->from('careers_subcategories');
		$this->db->where('careers_subcategories.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}	
	function GetGroupById($id)
	{
		$this->db->select('groups.*');
		$this->db->from('groups');
		$this->db->where('groups.id ',$id);
		$query = $this->db->get();
		return $query->row_array();
	}						
	function GetGroups($id)
	{
		$this->db->select('groups.*');
		$this->db->from('groups');
		$this->db->where('groups.id !='.$id);
		$query = $this->db->get();
		return $query->result();
	}	
	function GetCities($id)
	{
		$this->db->select('cities.*');
		$this->db->from('cities');
		$this->db->where('cities.countryid',$id);
		$query = $this->db->get();
		return $query->result();
	}	
	function GetCityById($id)
	{
		$this->db->select('cities.*');
		$this->db->from('cities');
		$this->db->where('cities.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}	
	function GetCategory()
	{
		$query = $this->db->get('categories');
		return $query->result();
	}
	function delete($table,$array_id)
	{
	  if($this->db->delete($table, $array_id))
	  return true;
	  
	}
	function save($table,$data)
	{
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}

	function edit($table,$data,$id){
		$this->db->where('id', $id);
        $this->db->update($table, $data);   
	}

	function do_upload()
	{
		$dir = 'uploads/';
		//echo $dir;
		$config['overwrite'] = TRUE;
		$config['upload_path'] =$dir;
		//die(var_dump(is_dir($config['upload_path'])));
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '1000';
		$config['max_width']  = '2048';
		$config['max_height']  = '1500';

		$this->load->library('upload', $config);
		$target_path="";
		if ( !$this->upload->do_upload())
		{
			$error = $this->upload->display_errors();
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			$file = $data['upload_data']['file_name']; // set the file variable
			$type=$data['upload_data']['image_type'];
			$target_path="uploads/".$file;
			$error = "Uploading Successful";
		}
		$list=array("target_path"=>$target_path,"error"=>$error);
		return $list;
	}
	function upload_cv()
	{
		$dir = 'cv/';
		$config['overwrite'] = TRUE;
		$config['upload_path'] =$dir;
		$config['allowed_types'] = 'doc|docx';
		$config['max_size'] = '2000';
		$this->load->library('upload', $config);
		$this->upload->initialize($config); 
		$this->upload->do_upload();

		
		$target_path="";
		if ( !$this->upload->do_upload())
		{
			$error = $this->upload->display_errors();
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			$file = $data['upload_data']['file_name']; // set the file variable
			$type=$data['upload_data']['image_type'];
			$target_path="cv/".$file;
			$error = "Uploading Successful";
		}
		$list=array("target_path"=>$target_path,"error"=>$error);
		return $list;
	}				
}