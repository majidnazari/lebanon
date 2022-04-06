<?php

class Reports extends Application
{
    public function __construct()
    {

        parent::__construct();
        $this->ag_auth->restrict('reports'); // restrict this controller to admins only
        $this->load->model(array('Administrator', 'Company', 'Item', 'Address', 'Bank', 'Client', 'Report', 'Importer', 'Parameter'));
        $this->load->library('export');
        $this->data['Ctitle'] = 'Industry Reports';
        $datetime = new DateTime('now', new DateTimeZone('Asia/Beirut'));
        $this->datetime = ($datetime->format("Y-m-d H:i:s"));
        $this->tdate = ($datetime->format("Y-m-d"));
        ini_set('max_execution_time', 1000);
    }

    public function companyd()
    {
        $query = $this->Company->GetDuplicateName();
        //var_dump($query);
    }
    public function export_schedules_to_excel() {
        $get = $this->uri->uri_to_assoc();
        $query = $this->Report->GetDataScheduleByCategory($get['from'], $get['to'], 'done', '');
        $data = array(array('Course', 'Date', 'Location', 'Class Schedule Category'));
        foreach($query as $row) {
            array_push($data, array($row->course, date('d-m-Y', strtotime($row->start_date)).' to '.date('d-m-Y', strtotime($row->end_date)), $row->city.' - '.$row->country, $row->category));
        }
        $this->export->to_excel($data, $get['from'].$get['to']);
        //redirect('reports/schedules?from='.$get['from'].'&to='.$get['to']);
    }

    public function GetSections($sector, $section_id) {
        $sections = $this->Item->GetSectionsBySectorId('online', $sector);
        $array_section[0] = 'All ';
        if(count($sections) > 0) {

            foreach($sections as $section) {
                if($section->id != 0)
                    $array_section[$section->id] = $section->label_ar;
            }
        }
        $class_chap = ' class="validate[required]"  required="required" id="section" onchange="getchapter(this.value)"';
        echo form_dropdown('section', $array_section, $section_id, $class_chap);
    }

    public function GetChapters($section_id) {
        $chapters = $this->Item->GetChaptersBySectionId('online', $section_id);
        //var_dump($chapters);
        $array_chapters[0] = 'All ';
        if(count($chapters) > 0) {

            foreach($chapters as $chapter) {
                if($chapter->id != 0)
                    $array_chapters[$chapter->id] = $chapter->label_ar;
            }
        }
        //$class_chap=' class="validate[required]"  required="required" id="section" onchange="getchapter(this.value)"';
        echo form_dropdown('chapters', $array_chapters, '');
    }

    public function ministry_export() {

        // filename for download
        $filename = "ministry-".time().".xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');
        echo '<style type="text/css">
				tr, td, table, tr{
					border:1px solid #D0D0D0;
				}
				.yellow{
						background:#FF0 !important;
					}
					.bold{
						font-weight:bold !important;
					}
				</style>   ';
        $query = $this->Company->GetAllMinistryCompanies(0,0);
        // $query=$all['results'];
        // $total_row = $all['num_results'];

        echo '<table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>اسم الشركة</th>
                                 <th>عدد الشركات</th>
                               	 <th>الشركات</th>
                            </tr>
                        </thead>
                        <tbody>';
        foreach($query as $row) {
            if($row->phone1!='' or $row->phone2!='' or $row->phone3!='' or $row->mobile1!='' or $row->mobile2!=''){
                $companies = $this->Company->GetCompaniesByMinistry($row->phone1, @$row->phone2, $row->phone3, $row->mobile1, $row->mobile2);
                echo '<tr>
                                    <td style="text-align:right;">'.$row->id.'</td>
                                    <td style="direction:rtl !important; text-align:right !important;">'.$row->name.'</td>
                                     <td>'.$row->phone1.'</td>
                                    <td>'.$row->phone2.'</td>
                                    <td>'.$row->phone3.'</td>
                                    <td>'.$row->mobile1.'</td>
                                    <td>'.$row->mobile2.'</td>
                                    <td style="text-align:right;">'.count($companies).'</td>
                                    <td style="text-align:right;">';

                if(count($companies)>0) {
                    foreach ($companies as $company) {

                        echo 'ID : ' . $company->id . ' Wezara ID : ' . $company->ministry_id . ' - ' . $company->name_ar . '<br>';
                    }
                }
                echo '</td>
                                   
                                </tr>';
            }
        }
        echo '</tbody>';

        echo '</table>';

        //return $filename;
        exit;
    }
    public function ministry_companies() {

        // filename for download
        $filename = "ministry-companies-".time().".xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');
        echo '<style type="text/css">
				tr, td, table, tr{
					border:1px solid #D0D0D0;
				}
				.yellow{
						background:#FF0 !important;
					}
					.bold{
						font-weight:bold !important;
					}
				</style>   ';
        $query = $this->Company->GetAllMinistry(0,0);
        // $query=$all['results'];
        // $total_row = $all['num_results'];

        echo '<table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>اسم الشركة</th>
                                <th>هاتف ١</th>
                                <th>هاتف ٢</th>
                                <th>هاتف ٣</th>
                                <th>هاتف ٤</th>
                                <th>هاتف ٥</th>
                                 <th>عدد الشركات</th>
                               	 <th>الشركات</th>
                            </tr>
                        </thead>
                        <tbody>';
        foreach($query as $row) {
            if($row->phone1!='' or $row->phone2!='' or $row->phone3!='' or $row->mobile1!='' or $row->mobile2!=''){
                $companies = $this->Company->GetCompaniesByMinistry($row->phone1, @$row->phone2,$row->phone3,$row->mobile1,$row->mobile2);
                echo '<tr>
                                    <td style="text-align:right;">'.$row->id.'</td>
                                    <td style="direction:rtl !important; text-align:right !important;">'.$row->name.'</td>
                                     <td>'.$row->phone1.'</td>
                                    <td>'.$row->phone2.'</td>
                                    <td>'.$row->phone3.'</td>
                                    <td>'.$row->mobile1.'</td>
                                    <td>'.$row->mobile2.'</td>
                                    <td style="text-align:right;">'.count($companies).'</td>
                                    <td style="text-align:right;">';

                if(count($companies)>0) {
                    foreach ($companies as $company) {

                        echo 'ID : ' . $company->id . ' Wezara ID : ' . $company->ministry_id . ' - ' . $company->name_ar . '<br>';
                    }
                }
                echo '</td>
                                   
                                </tr>';
            }
        }
        echo '</tbody>';

        echo '</table>';

        //return $filename;
        exit;
    }
    public function delete_assign($id) {
        $this->General->delete('tasks', array('id' => $id));
        $this->General->delete('task_activities', array('task_id' => $id));
        $this->session->set_userdata(array('admin_message' => 'Deleted'));
        redirect($this->agent->referrer());
    }
    public function geo($row=0) {

        $limit=20;
        if($this->input->get('search')){
            $governorate_id=$this->input->get('governorate_id');
            $district_id=$this->input->get('district_id');
            $area_id=$this->input->get('area_id');
            $assign_to=$this->input->get('assign_to');
            $type=$this->input->get('type');
            $printed=$this->input->get('printed');
        }
        $all = $this->Company->GetTasksActivitiesStatistics(@$governorate_id,@$district_id,@$area_id,@$assign_to,'company',date('Y'),@$type,@$printed,$row,$limit);

        $query=$all['results'];
        $total_row = $all['num_results'];

        $config['total_rows'] = $total_row;


        $this->data['query'] = $query;

        $this->data['govID'] = @$governorate_id;
        $this->data['districtID'] = @$district_id;
        $this->data['areaID'] = @$area_id;
        $this->data['assign_to'] = @$assign_to;
        $this->data['type'] = @$type;
        $this->data['printed'] = @$printed;


        $config['enable_query_strings'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $total_row;
        $config['per_page'] = $limit;
        $config['num_links'] = 6;
        $config['base_url'] = base_url() . 'reports/geo?gov='.@$governorate_id.'&district_id='.@$district_id.'&area_id='.@$area_id.'&type='.@$type.'&assign_to='.@$assign_to.'&printed='.@$printed.'&search=Search';
        $this->pagination->initialize($config);

        $this->data['links'] = $this->pagination->create_links();
        $this->data['total_row'] = $total_row;
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Reports');
        $this->breadcrumb->add_crumb('Geo Companies');
        $this->data['title'] = $this->data['Ctitle']."- Geo Companies";
        $this->data['subtitle'] = "Geo Companies";
        $this->data['msg'] = $this->session->userdata('admin_message');
        $this->session->unset_userdata('admin_message');

        $this->data['districts'] = $this->Address->GetDistrictByGov('online', @$governorate_id);
        $this->data['governorates'] = $this->Address->GetGovernorate('online', 0, 0);
        $this->data['areas'] = $this->Address->GetAreaByDistrict('online', @$district_id);
        $this->data['sales'] = $this->Company->GetSalesMen();

        $this->template->load('_template', 'reports/geo', $this->data);

    }
    public function update_tasks()
    {
        $ids = $this->input->post('checkbox1');
        $status=$this->input->post('bstatus');

        foreach ($ids as $id) {
            $this->Administrator->edit('task_activities',array('status'=>$status),$id);
        }
        redirect($this->agent->referrer());
    }
    public function tasks_comments()
    {
        $id = $this->input->post('id');
        $comments=$this->input->post('comments').' <br> Added By : '.username();

        $this->Administrator->edit('task_activities',array('comments'=>$comments),$id);
        redirect($this->agent->referrer());
    }
    public function task_edit()
    {
        $assigne_to=$this->input->post('assigne_to');
        $id=$this->input->post('id');
        $nbr=$this->Administrator->update('task_activities',array('salesman_id'=>$assigne_to,'update_time' => $this->datetime,'user_id' => $this->session->userdata('id')),array('task_id'=>$id,'status'=>'pending'));
        if($nbr>0)
        {
            $this->Administrator->edit('tasks',array('assigne_to'=>$assigne_to,'update_time' => $this->datetime,'user_id' => $this->session->userdata('id')),$id) ;
        }
        $this->session->set_userdata(array('admin_message' => 'Area Updated'));
        redirect($this->agent->referrer());
    }
    public function task_release($id)
    {
        $nbr=$this->Administrator->update('task_activities',array('salesman_id'=>0,'update_time' => $this->datetime,'user_id' => $this->session->userdata('id')),array('task_id'=>$id,'status'=>'pending'));
        echo $nbr;
        if($nbr>0)
        {
            $this->Administrator->edit('tasks',array('assigne_to'=>0,'printed'=>0,'update_time' => $this->datetime,'user_id' => $this->session->userdata('id')),$id) ;
        }
        $this->session->set_userdata(array('admin_message' => 'Area Released'));
        //redirect($this->agent->referrer());
    }
    public function companies_status() {
        $closed=$this->input->get('closed');
        $wrong_address=$this->input->get('wrong_address');
        $status=$this->input->get('status');
        if($this->input->get('search')){
        $this->data['query']=$query = $this->Report->GetCompaniesStatus(@$status,$closed,$wrong_address,0,0);
        }
        else{
            $this->data['query']=array('num_results'=>0,'results'=>array());
        }
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Reports');
        $this->breadcrumb->add_crumb('Status Companies');
        $this->data['title'] = $this->data['Ctitle']."- Status - Companies";
        $this->data['subtitle'] = "Companies By Status";

        
        $this->data['closed']=$closed;
        $this->data['wrong_address']=$wrong_address;
        $this->data['status']=$status;

        $this->template->load('_template', 'reports/companies_status', $this->data);

    }
    public function ExportCompaniesStatus()
    {
        
        $closed=$this->input->get('closed');
        $wrong_address=$this->input->get('wrong_address');
        $status=$this->input->get('status');
        $query = $this->Report->GetCompaniesStatus(@$status,$closed,$wrong_address,0,0);
       
        $filename = "companies-status-".time().".xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');
        echo '<style type="text/css">
				tr, td, table, tr{
					border:1px solid #D0D0D0;
				}
				.yellow{
						background:#FF0 !important;
					}
					.bold{
						font-weight:bold !important;
					}
				</style>   ';

//$query=$all['results'];
       //$total_row = $all['num_results'];

        echo '<table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                                <th>Company ID</th>
                            	<th>Company Name Ar</th>
                            	<th>Company Name En</th>
                            	<th>Mohafaza</th>
                            	<th>Kazaa</th>
                            	<th>Area</th>
                            	<th>Activity</th>
                            	<th>Status</th>
                            	<th>Closed</th>
                            	<th>Wrong Address</th>
                            	<th>Personal Notes</th>
                               
                            </tr>
                        </thead>
                        <tbody>';
        foreach($query['results'] as $row) {
           	echo '<tr><td>'.$row->id.'</td><td>'.$row->name_ar.'</td><td>'.$row->name_en.'</td><td>'.$row->governorate_ar.'</td><td>'.$row->district_ar.'</td>
							<td>'.$row->area_ar.'</td><td>'.$row->activity_ar.'</td>
							<td>'.(($row->show_online == 1) ? 'Online' : 'Offline').'</td>
							<td>'.(($row->is_closed == 1) ? 'Yes' : 'No').'</td>
							<td>'.(($row->error_address == 1) ? 'Yes' : 'No').'</td>
							<td>'.$row->personal_notes.'</td>
							</tr>';
        }
        echo '</tbody>';

        echo '</table>';

        //return $filename;
        exit;
    }
    public function advandcopy()
    {  
        $query = $this->Report->GetAdvAndCopyCompanies();        
       //var_dump( $query); die();
        $filename = "advcopy-".time().".xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');
        echo '<style type="text/css">
				tr, td, table, tr{
					border:1px solid #D0D0D0;
				}
				.yellow{
						background:#FF0 !important;
					}
					.bold{
						font-weight:bold !important;
					}
				</style>   ';

//$query=$all['results'];
       //$total_row = $all['num_results'];

        echo '<table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
        	<th>رقم</th>
            <th>Code</th>
            <th style="width: 150px !important">الشركة</th>
            <th>المسؤول</th>
            <th>النشاط</th>
            <th style="width: 100px !important">المنطقة</th>
            <th>الشارع</th>
            <th>هاتف</th>
            <th>واتساپ</th>
            <th>المندوب</th>
            <th>عدد انترنت</th>
            <th>معلن</th>
           <!-- <th>حاجز نسخة</th> -->
           <!--  <th>عدد دليل</th> -->
            
             <th style="width: 100px !important">start_date_ads </th>
             <th style="width: 100px !important">end_date_ads </th>
             <th>status</th>
             <th style="width: 75px !important">start_date </th>
             <th style="width: 75px !important">end_date </th>
 
    <!-- <th style="width: 100px !important">صفحات عربي</th> -->
      <!--      <th style="width: 100px !important">صفحات إنجليزي</th> -->
      <!--      <th style="width: 100px !important">إسم المستلم</th> -->
             <th style="width: 75px !important">التاريخ</th>
             <th style="width: 75px !important">الموزع</th>
            <th style="width: 150px !important">ملاحظات</th>

          

        </tr>
       
                        </thead>
                        <tbody>';
       	$i=1;
	
		foreach($query as $row){
            
				if($row->is_exporter==1){
					$exporter='نعم';
				}
				else{
					$exporter='كلا';
					}
				if($row->is_adv==1){
					$is_adv='نعم';
				}
				else{
					$is_adv='كلا';
					}	
					if($row->copy_res==1){
					$copy_res='نعم';
				}
				else{
					$copy_res='كلا';
					}	
	$phone=explode('-',$row->phone);
			
        	echo '<tr>
                    <td>'.$i.'</td>
                    <td>'.$row->id.'</td>
                    <td>'.$row->company_ar.'</td>
                    <td>'.$row->owner_name.'</td>
                    <td>'.$row->activity_ar.'</td>
                    <td>'.$row->area_ar.'</td>
                    <td>'.$row->street_ar.'</td>
                    <td>'.@$phone[0].'</td>
                    <td>'.$row->whatsapp.'</td>
                    <td>'.$row->sales_man_ar.'</td>
                    <td align="center">'.(($row->CNbr*2)+4).'</td>
                    <td align="center">'.$is_adv.'</td>
                  <!--  <td align="center">'.$copy_res.'</td> -->
                  <!-- <td align="center">'.(($row->CNbr*2)+1).'</td> -->
                   
                    <td>'.$row->start_date_adv.'</td>
                    <td>'.$row->end_date_adv.'</td>

                    <td>'.$row->status.'</td>
                    <td>'.$row->start_date.'</td>
                    <td>'.$row->due_date.'</td>


                  <!--   <td>'.$row->guide_pages_ar.'</td> -->
                  <!--  <td>'.$row->guide_pages_en.'</td> -->
                  <!--  <td>'.$row->receiver_name.'</td> -->
                    <td>'.$row->delivery_date.'</td>
                    <td>'.$row->delivery_by_ar.'</td>
                    <td>'.$row->personal_notes.'</td>


                   

                </tr>';
           
		   $i++;
		   }  
           
        echo '</tbody>';

        echo '</table>';

        //return $filename;
        exit;
    }

    public function showitem()
    {     
        $query = $this->Report->GetShowItemCompanies();   
        // foreach($query as $row)
        // {
        //  echo $row->id. "<br>";   
        // }
        // die();  
       //var_dump($query); die();
        $filename = "showitem_advertisement".time().".xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');
        echo '<style type="text/css">
				tr, td, table, tr{
					border:1px solid #D0D0D0;
				}
				.yellow{
						background:#FF0 !important;
					}
					.bold{
						font-weight:bold !important;
					}
				</style>   ';

            //$query=$all['results'];
        //$total_row = $all['num_results'];

        echo '<table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
        	<th>رقم</th>
            <th>Code</th>
            <th style="width: 150px !important">الشركة</th>
            <th>المسؤول</th>
            <th>النشاط</th>
            <th style="width: 100px !important">المنطقة</th>
            <th>الشارع</th>
            <th>هاتف</th>
            <th>واتساپ</th>
            <th>المندوب</th>
            <th>عدد انترنت</th>
            <th>معلن</th>
            <!-- <th>حاجز نسخة</th> -->
            <!--  <th>عدد دليل</th> -->
            
             <th style="width: 100px !important">start_date_ads </th>
             <th style="width: 100px !important">end_date_ads </th>
             <th> show item </th> <!-- tha status of showing item -->
             <th style="width: 150px !important"> item start_date </th>
             <th style="width: 150px !important"> item end_date </th>
 
            <!-- <th style="width: 100px !important">صفحات عربي</th> -->
            <!--      <th style="width: 100px !important">صفحات إنجليزي</th> -->
            <!--      <th style="width: 100px !important">إسم المستلم</th> -->
            <th style="width: 75px !important">التاريخ</th>
            <th style="width: 75px !important">الموزع</th>
            <th style="width: 150px !important">ملاحظات</th>

          

        </tr>
       
                        </thead>
                        <tbody>';
       	$i=1;
	
		foreach($query as $row){
            
                $showstatus="";
                if($row->show_item_status=="active")
                {
                    $showstatus="Yes";
                }
                else if($row->show_item_status=="inactive")
                {
                    $showstatus="No";
                }
                else if($row->show_item_status=="pending")
                {
                    $showstatus="Pending";
                }
				if($row->is_exporter==1){
					$exporter='نعم';
				}
				else{
					$exporter='كلا';
					}
				if($row->is_adv==1){
					//$is_adv='نعم';
					$is_adv='Yes';
				}
				else{
					//$is_adv='كلا';
					$is_adv='No';
					}	
					if($row->copy_res==1){
					//$copy_res='نعم';
					$copy_res='Yes';
				}
				else{
					//$copy_res='كلا';
					$copy_res='No';
					}	
	            $phone=explode('-',$row->phone);
			
        	    echo '<tr>
                    <td>'.$i.'</td>
                    <td>'.$row->id.'</td>
                    <td>'.$row->company_ar.'</td>
                    <td>'.$row->owner_name.'</td>
                    <td>'.$row->activity_ar.'</td>
                    <td>'.$row->area_ar.'</td>
                    <td>'.$row->street_ar.'</td>
                    <td>'.@$phone[0].'</td>
                    <td>'.$row->whatsapp.'</td>
                    <td>'.$row->sales_man_ar.'</td>
                    <td align="center">'.(($row->CNbr*2)+4).'</td>
                    <td align="center">'.$is_adv.'</td>
                  <!--  <td align="center">'.$copy_res.'</td> -->
                  <!-- <td align="center">'.(($row->CNbr*2)+1).'</td> -->
                   
                    <td>'.$row->start_date_adv.'</td>
                    <td>'.$row->end_date_adv.'</td>

                    <td align="center" >'. $showstatus.'</td>
                    <td>'.$row->show_item_start_date.'</td>
                    <td>'.$row->show_item_end_date.'</td>


                  <!--   <td>'.$row->guide_pages_ar.'</td> -->
                  <!--  <td>'.$row->guide_pages_en.'</td> -->
                  <!--  <td>'.$row->receiver_name.'</td> -->
                    <td>'.$row->delivery_date.'</td>
                    <td>'.$row->delivery_by_ar.'</td>
                    <td>'.$row->personal_notes.'</td>


                   

                </tr>';
           
		    $i++;
		   }  
           
        echo '</tbody>';

        echo '</table>';

        //return $filename;
        exit;
    }
     public function advertisers()
    {
        
        
        $companies = $this->Report->GetCompaniesAdvertiser();
        
        $banks = $this->Report->GetBanksAdvertiser();
        $insurances = $this->Report->GetInsurancesAdvertiser();
        $importers = $this->Report->GetImportersAdvertiser();
        $transports = $this->Report->GetTransportAdvertiser();
       
        $filename = "advertiser-".time().".xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');
        echo '<style type="text/css">
				tr, td, table, tr{
					border:1px solid #D0D0D0;
				}
				.yellow{
						background:#FF0 !important;
					}
					.bold{
						font-weight:bold !important;
					}
				</style>   ';

//$query=$all['results'];
       //$total_row = $all['num_results'];

        echo '<table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                            	<th>Name</th>
                            	<th>Sections</th>
                               
                            </tr>
                        </thead>
                        <tbody>';
        foreach($companies as $crow) {
           	echo '<tr><td>'.$crow->id.'</td><td>'.$crow->name_en.'</td><td>Companies</td></tr>';
        }
        foreach($banks as $brow) {
           	echo '<tr><td>'.$brow->id.'</td><td>'.$brow->name_en.'</td><td>Banks</td></tr>';
        }
        foreach($insurances as $insrow) {
           	echo '<tr><td>'.$insrow->id.'</td><td>'.$insrow->name_en.'</td><td>Insurances Companies</td></tr>';
        }
        foreach($importers as $improw) {
           	echo '<tr><td>'.$improw->id.'</td><td>'.$improw->name_en.'</td><td>Importers Companies</td></tr>';
        }
        foreach($transports as $transrow) {
           	echo '<tr><td>'.$transrow->id.'</td><td>'.$transrow->name_en.'</td><td>Transports</td></tr>';
        }
        echo '</tbody>';

        echo '</table>';

        //return $filename;
        exit;
    }
    public function ViewCompaniesStatus()
    {
        
        $closed=$this->input->get('closed');
        $wrong_address=$this->input->get('wrong_address');
        $status=$this->input->get('status');
        $this->data['query']=$query = $this->Report->GetCompaniesStatus(@$status,$closed,$wrong_address,0,0);
        $this->load->view('reports/company_status_list',$this->data);
    
    }
    public function companies_hs() {
        $nbr_code=$this->input->get('nbr');
        $op=$this->input->get('op');
        $this->data['query']=$query = $this->Report->GetCompaniesHSCode(@$nbr_code,$op,0,0);
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Reports');
        $this->breadcrumb->add_crumb('Geo Companies');
        $this->data['title'] = $this->data['Ctitle']."- H.S. Code - Companies";
        $this->data['subtitle'] = "H.S. Code - Companies";

        
        $this->data['nbr']=$nbr_code;
        $this->data['op']=$op;

        $this->template->load('_template', 'reports/companies_hs', $this->data);

    }
    
    public function ExportCompaniesHSCode()
    {
        
        $nbr_code=$this->input->get('nbr');
        $op=$this->input->get('op');
        $this->data['query']=$query = $this->Report->GetCompaniesHSCode(@$nbr_code,$op,0,0);
        $filename = "companies-hscode-".time().".xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');
        echo '<style type="text/css">
				tr, td, table, tr{
					border:1px solid #D0D0D0;
				}
				.yellow{
						background:#FF0 !important;
					}
					.bold{
						font-weight:bold !important;
					}
				</style>   ';

//$query=$all['results'];
       //$total_row = $all['num_results'];

        echo '<table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Company Name Ar</th>
                                <th>Company Name En</th>
                                <th>H.S. Code Count</th>
                               
                            </tr>
                        </thead>
                        <tbody>';
        foreach($query['results'] as $row) {
            echo '<tr>
                            <td>'.$row->id.'</td>
                            <td>'.$row->name_ar.'</td>
                            <td>'.$row->name_en.'</td>
                            <td>'.$row->hscode_count.'</td>
                            </tr>';
        }
        echo '</tbody>';

        echo '</table>';

        //return $filename;
        exit;
    }
public function companies_hscode()
    {
        

        $filename = "companies-hscode-".time().".xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');
        echo '<style type="text/css">
				tr, td, table, tr{
					border:1px solid #D0D0D0;
				}
				.yellow{
						background:#FF0 !important;
					}
					.bold{
						font-weight:bold !important;
					}
				</style>   ';
        $query = $this->Report->GetCompaniesWithourHSCode();

//$query=$all['results'];
       //$total_row = $all['num_results'];

        echo '<table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Company Name Ar</th>
                                <th>Company Name En</th>
                                <th>H.S. Code Count</th>
                               
                            </tr>
                        </thead>
                        <tbody>';
        foreach($query as $row) {
            echo '<tr>
                            <td>'.$row->id.'</td>
                            <td>'.$row->name_ar.'</td>
                            <td>'.$row->name_en.'</td>
                            <td>'.$row->hscode_count.'</td>
                            </tr>';
        }
        echo '</tbody>';

        echo '</table>';

        //return $filename;
        exit;
    }
    public function geo_export()
    {
        $governorate_id=$this->input->get('governorate_id');
        $district_id=$this->input->get('district_id');
        $area_id=$this->input->get('area_id');
        $assign_to=$this->input->get('assign_to');
        $type=$this->input->get('type');

        $filename = "geo-".time().".xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');
        echo '<style type="text/css">
				tr, td, table, tr{
					border:1px solid #D0D0D0;
				}
				.yellow{
						background:#FF0 !important;
					}
					.bold{
						font-weight:bold !important;
					}
				</style>   ';
        $all = $this->Company->GetTasksActivitiesStatistics(@$governorate_id,@$district_id,@$area_id,@$assign_to,'company',date('Y'),@$type);

        $query=$all['results'];
        $total_row = $all['num_results'];

        echo '<table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                                <th>Mohafaz</th>
                                <th>Kazaa</th>
                                <th>Area</th>
                                <th>Total Companies</th>
                                <th>Pending</th>
                                <th>Done</th>
                                <th>Assign To</th>
                            </tr>
                        </thead>
                        <tbody>';
        foreach($query as $row) {
            $total_companies=$this->Company->GetGeoCompaniesByArea($row->governorate_id,$row->district_id,$row->area_id);
            echo '<tr>
                            <td>'.$row->governorate_ar.'<br>'.$row->governorate_en.'</td>
                            <td>'.$row->district_ar.'<br>'.$row->district_en.'</td>
                            <td>'.$row->area_ar.'<br>'.$row->area_en.'</td>
                            <td>'.$total_companies[0]->company_count.'</td>
                            <td>'.$row->pending_count.'</td>
                            <td>'.$row->done_count.'</td>
                            <td>'.$row->fullname.'</td>
                            </tr>';
        }
        echo '</tbody>';

        echo '</table>';

        //return $filename;
        exit;
    }
    public function tasks($id,$status) {
        //  if($this->input->get('search')){
        //     $this->data['query']=$query = $this->Company->GetActivityTask(@$id,'',@$status,'company');
        // }
        // else{
        $this->data['query']=$query = $this->Company->GetActivityTask(@$id,'',@$status,'company');
        // }

        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Reports');
        $this->breadcrumb->add_crumb('Geo Companies');
        $this->data['title'] = $this->data['Ctitle']."- Geo Companies";
        $this->data['subtitle'] = "Geo Companies";

        $this->data['districts'] = $this->Address->GetDistrictByGov('online', @$governorate_id);
        $this->data['governorates'] = $this->Address->GetGovernorate('online', 0, 0);
        $this->data['areas'] = $this->Address->GetAreaByDistrict('online', @$district_id);
        $this->data['sales'] = $this->Company->GetSalesMen();
        $this->data['status']=$status;
        $this->data['id']=$id;

        $this->template->load('_template', 'reports/geo_task_activities', $this->data);

    }
    public function tasks_export($id,$status)
    {
        $filename = "tasks-".time().".xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');
        echo '<style type="text/css">
				tr, td, table, tr{
					border:1px solid #D0D0D0;
				}
				.yellow{
						background:#FF0 !important;
					}
					.bold{
						font-weight:bold !important;
					}
				</style>   ';
        $query = $this->Company->GetActivityTask(@$id,'',@$status,'company');

        echo '<table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Company</th>
                                <th>Mohafaz</th>
                                <th>Kazaa</th>
                                <th>Area</th>
                                <th>Status</th>
                                <th>Update Info</th>
                                <th>Assign To</th>
                                <th>Copy Reservation</th>
                                <th>Advertiser</th>
                                <th>Update Time</th>
                            </tr>
                        </thead>
                        <tbody>';
        foreach($query as $row) {
            echo '<tr>
                            <td>'.$row->item_id.'</td>
                            <td>'.$row->company_name_ar.'<br>'.$row->company_name_en.'</td>
                            <td>'.$row->governorate_ar.'<br>'.$row->governorate_en.'</td>
                            <td>'.$row->district_ar.'<br>'.$row->district_en.'</td>
                            <td>'.$row->area_ar.'<br>'.$row->area_en.'</td>
                            <td>'.$row->status.'</td>
                            <td>'.(($row->updated_info == 1) ? 'Yes' : 'No').'</td>
                            <td>'.$row->fullname.'</td>
                            <td>'.(($row->copy_res == 1) ? 'Yes' : 'No').'</td>
                            <td>'.(($row->advertiser == 1) ? 'Yes' : 'No').'</td>
                            <td>'.$row->update_time.'</td>
                            </tr>';
        }
        echo '</tbody>';

        echo '</table>';

        //return $filename;
        exit;
    }

    public function ministry($row=0) {

        $limit=10;
        $all = $this->Report->GetMinistryReports($row,$limit);
        $query=$all['results'];
        $total_row = $all['num_results'];

        $config['total_rows'] = $total_row;


        $this->pagination->initialize($config);
        $this->data['query'] = $query;
        $this->data['total_row'] = $total_row;

        $config['enable_query_strings'] = FALSE;
        $config['page_query_string'] = FALSE;
        $config['total_rows'] = $total_row;
        $config['per_page'] = $limit;
        $config['num_links'] = 6;
        $config['base_url'] = base_url() . 'reports/ministry';
        $this->pagination->initialize($config);

        $this->data['links'] = $this->pagination->create_links();
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Reports');
        $this->breadcrumb->add_crumb('وزارة الصناعة');
        $this->data['title'] = $this->data['Ctitle']." - وزارة الصناعة";
        $this->data['subtitle'] = "وزارة الصناعة";

        $this->template->load('_template', 'reports/ministry', $this->data);

    }
    public function productions($lang = 'ar') {
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Reports');
        $this->breadcrumb->add_crumb('الفهرس السلعي');
        $this->data['title'] = $this->data['Ctitle']." - الفهرس السلعي";
        $this->data['subtitle'] = "الفهرس السلعي";
        $this->data['query'] = $this->Report->GetIndexProductions($lang);
        $this->template->load('_template', 'reports/production_'.$lang, $this->data);
    }
function export_productions($lang = 'ar') {
        // filename for download
        $filename = "productions-".$lang.".xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');
        $flag = false;
        echo '<style type="text/css">
				.table tr td {
					border:1px solid #000;
				}
				.yellow{
				        font-weight: bold;
					}
				.table tr th{
					border:1px solid #FFF;
					background: #000;
					color: #FFF;
					font-weight: bold;
				}
				.htitle{
				border:1px solid #FFF !important;
				height:5px !important;
					}
				</style>   ';
                $query = $this->Report->GetIndexProductions($lang);
                        $x=TRUE;
                        echo '<body style="width:1080;font-family: Arial;"><table style="width:1080px !important; border:1px solid #000;" cellpadding="0" cellspacing="0" width="1080" class="table">';
                       if($lang == 'ar') {
                        echo'<tr>
                                <th>السلعة</th>
                                <th>رقم البند</th>
                            </tr>
                        ';
                       }
                       else{
                            echo'<tr>
                                    <th>H.S Code</th>
                                    <th>Description</th>
                                </tr>';
                       }
                       $css_ex = 'font-size:12px !important';
                        foreach($query as $row) {
                             
                                        if($lang=='ar'){
                                         echo '<tr>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->description_ar.'</td>
                                          	<td style="text-align:center; '.$css_ex.'">'.$row->hs_code_print.'</td>
                                        </tr>';
                                        }
                                        else{
                                            echo '<tr>
                                            <td style="text-align:center !important; '.$css_ex.'">'.$row->hs_code_print.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->description_en.'</td>
                                            
                                        </tr>'; 
                                        }
                            
                        }
        echo '</table></body>';
        exit;
    }
    public function export_productions1($lang = 'ar') {
        //echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
        $query = $this->Report->GetIndexProductions($lang);

        $data = array();

        foreach($query as $row) {
            if($lang == 'ar') {
                array_push($data, array(
                        'رقم البند' => $row->hs_code_print,
                        'السلعة' => $row->description_ar,
                    )
                );
            }
            else {

                array_push($data, array(
                        'H.S Code' => $row->hs_code_print,
                        'Description' => $row->description_en,
                    )
                );
            }
        }
        $name = 'Reports-productions';
        $this->export->Excel($data, $name);
    }

    public function banks($lang = 'ar') {
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Reports');
        $this->breadcrumb->add_crumb('Banks');
        $this->data['title'] = $this->data['Ctitle']." -  Banks";
        $this->data['subtitle'] = "Banks ";
        $this->data['query'] = $this->Report->GetBanks($lang);
        $this->template->load('_template', 'reports/banks_'.$lang, $this->data);
    }
function export_banks($lang = 'ar') {
        // filename for download
        $filename = "banks-".$lang.".xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');
        $flag = false;
        echo '<style type="text/css">
				.table tr td {
					border:1px solid #000;
				}
				.yellow{
				        font-weight: bold;
					}
				.table tr th{
					border:1px solid #FFF;
					background: #000;
					color: #FFF;
					font-weight: bold;
				}
				.htitle{
				border:1px solid #FFF !important;
				height:5px !important;
					}
				</style>   ';
                $query = $this->Report->GetBanks($lang);
                        $x=TRUE;
                        echo '<body style="width:1080;font-family: Arial;"><table style="width:1080px !important; border:1px solid #000;" cellpadding="0" cellspacing="0" width="1080" class="table">';
                       if($lang == 'ar') {
                        echo'<tr>
                                <th>البريد الكتروني</th>
                                <th>فاكس</th>
                               <th>هاتف</th>
                               <th>واتساپ</th>
                                <th>الشارع</th>
                                <th>المدينة</th>
                                <th>قضاء</th>
                                <th style="width: 250px !important;">اسم المصرف</th>
                            </tr>
                        ';
                       }
                       else{
                            echo'<tr>
                                    <th style="width: 250px !important;">Bank Name</th>
                                    <th>Kazaa</th>
                                    <th>City</th>
                                    <th>Street</th>
                                    <th>Phone</th>
                                    <th>WhatsApp</th>
                                    <th>Fax</th>
                                    <th>Email</th>
                                </tr>';
                       }
                        foreach($query as $row) {
                             if(@$row->is_adv == 1)
                                        $css_ex = 'font-weight:bold; font-size:14px !important';
                                    elseif(@$row->copy_res == 1)
                                        $css_ex = 'font-weight:bold; font-size:13px !important';
                                    else
                                        $css_ex = 'font-size:12px !important';
                                        if($lang=='ar'){
                                         echo '<tr>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->email.'</td>
                                          	<td style="text-align:center; '.$css_ex.'">'.$row->fax.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->phone.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->whatsapp.'</td>
                                            <td style="direction:rtl !important; text-align:center !important; '.$css_ex.'">'.$row->street_ar.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->area_ar.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->district_ar.'</td>
                                            <td style="direction:rtl !important; text-align:center !important; '.$css_ex.'">'.$row->name_ar.'</td>
                                        </tr>';
                                        }
                                        else{
                                            echo '<tr>
                                            <td style="text-align:center !important; '.$css_ex.'">'.$row->name_en.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->district_en.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->area_en.'</td>
                                            <td style="text-align:center !important; '.$css_ex.'">'.$row->street_en.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->phone.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->whatsapp.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->fax.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->email.'</td>
                                        </tr>'; 
                                        }
                            
                        }
        echo '</table></body>';
        exit;
    }
    public function export_banks1($lang = 'ar') {
        //echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
        $query = $this->Report->GetBanks($lang);

        $data = array();

        foreach($query as $row) {
            if($lang == 'ar') {
                array_push($data, array(
                        'اسم المصرف' => $row->name_ar,
                        'قضاء' => $row->district_ar,
                        'المدينة' => $row->area_ar,
                        'الشارع' => $row->street_ar,
                        'هاتف' => $row->phone,
                        'واتساپ' => $row->whatsapp,
                        'فاكس' => $row->fax,
                        'ص.ب' => $row->pobox_ar,
                        'البريد اللكتروني' => $row->email,
                    )
                );
            }
            else {

                array_push($data, array(
                        'Bank Name' => $row->name_en,
                        'Kazaa' => $row->district_en,
                        'City' => $row->area_en,
                        'Street' => $row->street_en,
                        'Phone' => $row->phone,
                        'WhatsApp' => $row->whatsapp,
                        'Fax' => $row->fax,
                        'P.O.BOX' => $row->pobox_en,
                        'Email' => $row->email,
                    )
                );
            }
        }
        $name = 'Reports-banks';
        $this->export->Excel($data, $name);
    }

    public function branches($lang = 'ar') {
        if($this->input->get('search')) {
            $lang = $this->input->get('lang');
            $gov_id = $this->input->get('gov');
        }
       
        $this->data['gov_id']=@$gov_id;
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Reports');
        $this->breadcrumb->add_crumb('Banks');
        $this->data['title'] = $this->data['Ctitle']." -  Banks";
        $this->data['subtitle'] = "Banks ";
        $this->data['query'] = $this->Report->GetBankBranches($lang);
        $this->data['governorates'] = $this->Address->GetGovernorate('', 0, 0);
        $this->template->load('_template', 'reports/branches_'.$lang, $this->data);
    }
function ExportGeoBanksAr($gov = '') {
        // filename for download
        
        $gov_array = $this->Address->GetGovernorateById($gov);
        
        $filename = "banks-geo-".@$gov_array['label_en']."-ar.xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');
        $flag = false;
        echo '<style type="text/css">
				.table tr td {
					border:1px solid #000;
				}
				.yellow{
				        font-weight: bold;
					}
				.table tr th{
					border:1px solid #FFF;
					background: #000;
					color: #FFF;
					font-weight: bold;
				}
				.htitle{
				border:1px solid #FFF !important;
				height:5px !important;
					}
				</style>   ';
      
                        $x=TRUE;
                        echo '<body style="width:1080;font-family: Arial;"><table style="width:1080px !important;" cellpadding="0" cellspacing="0" width="1080" class="table">';
        $css_ex = 'font-size:12px !important';
        if($gov != '') {
            $districts = $this->Address->GetDistrictByGov('', $gov_array['id'],'ar');
            echo '<tr><td colspan="6" align="center" style="border:none !important;"><center><h3 style="margin:5px; font-size:29px !important">'.$gov_array['label_ar'].'</h3></center></td></tr>';
            foreach($districts as $district) {
                
                echo '<tr><td class="htitle" colspan="6" align="center" style="font-weight:bold"></td></tr>
                <tr><td style="background:#A6A6A6; font-weight:bold;  font-size:21px !important; border:none !important;" colspan="6" align="center"><center>قضاء  : '.$district->label_ar.'</center></td></tr>';
                $areas = $this->Address->GetAreaByDistrict('', $district->id);
                foreach($areas as $area) {

                    $query = $this->Report->GetBankBranchesByArea($area->id, 'ar');
                    if(count($query) > 0) {
                        echo '<tr><td colspan="6"  class="htitle" align="center" style="font-weight:bold"></td></tr>
                        <tr><td colspan="6" align="center" style="background:#BFBFBF; font-weight:bold; font-size:19px !important; text-align:center !important; border:none !important;"><center>'.$area->label_ar.'</center></td></tr>';
                            echo '<tr><td class="htitle" colspan="6" align="center" style="font-weight:bold"></td></tr>';
                            foreach($query as $row) {
                                      if($x)
                                      {
                                               echo'<tr>
                                                        <th>البريد الكتروني</th>
                                                        <th>فاكس</th>
                                                       <th>هاتف</th>
                                                       <th>واتساپ</th>
                                                        <th>الشارع</th>
                                                        <th>مدير الفرع </th>
                                                        <th style="width: 250px !important;">اسم المصرف</th>
                                                    </tr>'; 
                                                $x=FALSE;
                                      }
                                    echo '<tr>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->email.'</td>
                                          	<td style="text-align:center; '.$css_ex.'">'.$row->fax.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->phone.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->whatsapp.'</td>
                                            <td style="direction:rtl !important; text-align:center !important; '.$css_ex.'">'.$row->street_ar.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->beside_ar.'</td>
                                            <td style="direction:rtl !important; text-align:center !important; '.$css_ex.'">'.$row->bank_ar.'</td>
                                        </tr>';
                                }

                    }
                }
            }
        }
        else{
            
        }
       // echo '</tbody>';

        echo '</table></body>';

        //return $filename;
        exit;
    }
    function ExportGeoBanksEn($gov = '') {
        // filename for download
        
        $gov_array = $this->Address->GetGovernorateById($gov);
        
        $filename = "banks-geo-".@$gov_array['label_en']."-en.xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');
        $flag = false;
        echo '<style type="text/css">
				.table tr td {
					border:1px solid #000;
				}
				.yellow{
				        font-weight: bold;
					}
				.table tr th{
					border:1px solid #FFF;
					background: #000;
					color: #FFF;
					font-weight: bold;
				}
				.htitle{
				border:1px solid #FFF !important;
				height:5px !important;
					}
				</style>   ';
      
                        $x=TRUE;
                        echo '<body style="width:1080;font-family: Arial;"><table style="width:1080px !important;" cellpadding="0" cellspacing="0" width="1080" class="table">';
        $css_ex = 'font-size:12px !important';
        if($gov != '') {
            $districts = $this->Address->GetDistrictByGov('', $gov_array['id'],'en');
            echo '<tr><td colspan="6" align="center" style="border:none !important;"><center><h3 style="margin:5px; font-size:29px !important">'.$gov_array['label_en'].'</h3></center></td></tr>';
            foreach($districts as $district) {
                
                echo '<tr><td class="htitle" colspan="6" align="center" style="font-weight:bold"></td></tr>
                <tr><td style="background:#A6A6A6; font-weight:bold;  font-size:21px !important; border:none !important;" colspan="6" align="center"><center>Kazzaa  : '.$district->label_en.'</center></td></tr>';
                $areas = $this->Address->GetAreaByDistrict('', $district->id);
                foreach($areas as $area) {

                    $query = $this->Report->GetBankBranchesByArea($area->id, 'en');
                    if(count($query) > 0) {
                        echo '<tr><td colspan="6"  class="htitle" align="center" style="font-weight:bold"></td></tr>
                        <tr><td colspan="6" align="center" style="background:#BFBFBF; font-weight:bold; font-size:19px !important; text-align:center !important; border:none !important;"><center>'.$area->label_en.'</center></td></tr>';
                            echo '<tr><td class="htitle" colspan="6" align="center" style="font-weight:bold"></td></tr>';
                            foreach($query as $row) {
                                      if($x)
                                      {
                                               echo'<tr>
                                                        <th style="width: 250px !important;">Bank Name</th>
                                                        <th>Branch Manager</th>
                                                        <th>Street</th>
                                                        <th>Phone</th>
                                                        <th>WhatsApp</th>
                                                        <th>Fax</th>
                                                        <th>Email</th>
                                                    </tr>'; 
                                                $x=FALSE;
                                      }
                                    echo '<tr>
                                    <td style="text-align:center !important; '.$css_ex.'">'.$row->bank_en.'</td>
                                    <td style="text-align:center; '.$css_ex.'">'.$row->beside_en.'</td>
                                    <td style="text-align:center !important; '.$css_ex.'">'.$row->street_en.'</td>
                                     <td style="text-align:center; '.$css_ex.'">'.$row->whatsapp.'</td>
                                     <td style="text-align:center; '.$css_ex.'">'.$row->fax.'</td>
                                    <td style="text-align:center; '.$css_ex.'">'.$row->email.'</td>
                                        </tr>';
                                }

                    }
                }
            }
        }
        else{
            
        }
       // echo '</tbody>';

        echo '</table></body>';

        //return $filename;
        exit;
    }
    public function export_branches1($lang = 'ar') {
        //echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
        $query = $this->Report->GetBankBranches($lang);

        $data = array();

        foreach($query as $row) {
            if($lang == 'ar') {
                array_push($data, array(
                        'اسم المصرف' => $row->bank_ar,
                        'مدير الفرع ' => $row->beside_ar,
                        ' المحافظة ' => $row->governorate_ar,
                        'قضاء' => $row->district_ar,
                        'المدينة' => $row->area_ar,
                        'الشارع' => $row->street_ar,
                        'هاتف' => $row->phone,
                        'واتساپ' => $row->whatsapp,
                        'فاكس' => $row->fax,
                        'ص.ب' => $row->pobox_ar,
                        'البريد اللكتروني' => $row->email,
                    )
                );
            }
            else {

                array_push($data, array(
                        'Bank Name' => $row->bank_en,
                        'Branch Manager' => $row->beside_en,
                        'Mohafaza' => $row->governorate_en,
                        'Kazaa' => $row->district_en,
                        'City' => $row->area_en,
                        'Street' => $row->street_en,
                        'Phone' => $row->phone,
                        'WhatsApp' => $row->whatsapp,
                        'Fax' => $row->fax,
                        'P.O.BOX' => $row->pobox_en,
                        'Email' => $row->email,
                    )
                );
            }
        }
        $name = 'Reports-banks-'.$lang;
        $this->export->Excel($data, $name);
    }

    public function importers($lang = 'ar') {
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Reports');
        $this->breadcrumb->add_crumb('Importers Companies');
        $this->data['title'] = $this->data['Ctitle']." -  Importers Companies";
        $this->data['subtitle'] = "Importers Companies ";
        $this->data['activities'] = $this->Importer->GetImporterActivities('online');
        $this->data['query'] = $this->Report->GetImporters($lang);
        $this->template->load('_template', 'reports/importers_'.$lang, $this->data);
    }

    public function export_importers($lang = 'ar') {
        $filename = "importers-".$lang.".xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');
        $flag = false;
        echo '<style type="text/css">
				.table tr td {
					border:1px solid #000;
				}
				.yellow{
				        font-weight: bold;
					}
				.table tr th{
					border:1px solid #FFF;
					background: #000;
					color: #FFF;
					font-weight: bold;
				}
				.htitle{
				border:1px solid #FFF !important;
				height:5px !important;
					}
				</style>   ';
      
        echo '<body style="width:1080;font-family: Arial;"><table style="width:1080px !important; border:1px solid #000;" cellpadding="0" cellspacing="0" width="1080" class="table">';
        $activities = $this->Importer->GetImporterActivities('online');
        $query = $this->Report->GetImporters($lang);
        $x=TRUE;
        foreach($activities as $activity) {
            if($lang == 'ar') {
                $act=$activity->label_ar;
                echo '<tr><td class="htitle" colspan="7" align="center" style="font-weight:bold"></td></tr>
                <tr><td style="background:#A6A6A6; font-weight:bold;  font-size:21px !important; border:none !important;" colspan="8" align="center"><center>'.$activity->label_ar.'</center></td></tr>';
            }
            else {
                 $act=$activity->label_en;
                echo '<tr><td class="htitle" colspan="7" align="center" style="font-weight:bold"></td></tr>
                <tr><td style="background:#A6A6A6; font-weight:bold;  font-size:21px !important; border:none !important;" colspan="8" align="center"><center>'.$activity->label_en.'</center></td></tr>';
            }
            if(count($query) > 0) {
                $i = 1;
                foreach($query as $row) {
                    if(@$row->is_adv == 1)
                                        $css_ex = 'font-weight:bold; font-size:14px !important';
                                    elseif(@$row->copy_res == 1)
                                        $css_ex = 'font-weight:bold; font-size:13px !important';
                                    else
                                        $css_ex = 'font-size:12px !important';

                                   
                                      if($x)
                                      {
                                          if($lang == 'ar') {
                                                echo '<tr>
                        								<th>البريد اللكتروني</th>
                                                        <th>فاكس</th>
                                                        <th>هاتف</th>
                                                        <th>واتساپ</th>
                                                        <th>الشارع</th>
                                                        <th>المدينة</th>
                                                        <th>قضاء</th>
                                                        <th>نوع النشاط</th>
                        								<th>صاحب الشركة</th>
                                                        <th>الشركة</th>
                                                    </tr>';
                                            }
                                            else {
                                                echo '<tr>
                                                       	 <th>Company</th>
                                                         <th>Owner</th>
                                                         <th>Activity</th>
                        								 <th>Kazaa</th>
                                                         <th>City</th>
                                                         <th>Street</th>
                                                         <th>Tel</th>
                                                         <th>Fax</th>
                                                        <th>E-mail</th>
                                                    </tr>';
                                            }
                                           
                                             $x=FALSE;
                                      }
                    $array_activity = array();
                    $array_activity = explode(',', $row->activities);
                    if(in_array($activity->id, $array_activity)) {
                        if($lang == 'ar') {
                              echo '<tr class="'.@$css.'">
                                            <td style="text-align:center; '.$css_ex.'">'.$row->email.'</td>
                                          	<td style="text-align:center; '.$css_ex.'">'.$row->fax.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->phone.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->whatsapp.'</td>
                                            <td style="direction:rtl !important; text-align:center !important; '.$css_ex.'">'.$row->street_ar.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->area_ar.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->district_ar.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$act.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->owner_ar.'</td>
                                            <td style="text-align:center !important; '.$css_ex.'">'.$row->name_ar.'</td>
                                        </tr>';
                            
                        }
                        else {
                             echo '<tr class="'.@$css.'">
                                         <td style="direction:rtl !important; text-align:center !important; '.$css_ex.'">'.$row->name_en.'</td>
                                         <td style="text-align:center; '.$css_ex.'">'.$row->owner_en.'</td>
                                         <td style="text-align:center; '.$css_ex.'">'.$act.'</td>
                                         <td style="text-align:center; '.$css_ex.'">'.$row->district_en.'</td>
                                         <td style="text-align:center; '.$css_ex.'">'.$row->area_en.'</td>
                                         <td style="text-align:center !important; '.$css_ex.'">'.$row->street_en.'</td>
                                         <td style="text-align:center; '.$css_ex.'">'.$row->phone.'</td>
                                         <td style="text-align:center; '.$css_ex.'">'.$row->whatsapp.'</td>
                                         <td style="text-align:center; '.$css_ex.'">'.$row->fax.'</td>
                                        <td style="text-align:center; '.$css_ex.'">'.$row->email.'</td>
                                    </tr>';
                            
                           
                        }
                    }
                }
            }
        }
        echo '</table></body>';

        //return $filename;
        exit;
    }

    public function transportation($lang = 'ar') {
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Reports');
        $this->breadcrumb->add_crumb('Transportations');

        $this->data['query'] = $this->Report->GetTransportation($lang);
        if($lang == 'en') {
            $this->data['title'] = $this->data['Ctitle']." -  Transport & Trading Companies Operating in Lebanon";
            $this->data['subtitle'] = "Transport & Trading Companies Operating in Lebanon ";
        }
        else {
            $this->data['title'] = $this->data['Ctitle']." -  شركات النقل والتخليص العاملة في لبنان";
            $this->data['subtitle'] = "شركات النقل والتخليص العاملة في لبنان ";
        }
        $this->template->load('_template', 'reports/transportation_'.$lang, $this->data);
    }
function export_transportation($lang = 'ar') {
        // filename for download
        $filename = "transportation-".$lang.".xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');
        $flag = false;
        echo '<style type="text/css">
				.table tr td {
					border:1px solid #000;
				}
				.yellow{
				        font-weight: bold;
					}
				.table tr th{
					border:1px solid #FFF;
					background: #000;
					color: #FFF;
					font-weight: bold;
				}
				.htitle{
				border:1px solid #FFF !important;
				height:5px !important;
					}
				</style>   ';
				
                $query = $this->Report->GetTransportation($lang);
                        $x=TRUE;
                        echo '<body style="width:1080;font-family: Arial;"><table style="width:1080px !important; border:1px solid #000;" cellpadding="0" cellspacing="0" width="1080" class="table">';
                       if($lang == 'ar') {
                        echo'<tr>
                                <th>البريد الكتروني</th>
                                <th>فاكس</th>
                               <th>هاتف</th>
                               <th>واتساپ</th>
                                <th>الشارع</th>
                                <th>المدينة</th>
                                <th>قضاء</th>
                                <th>صاحب الشركة</th>
                                <th style="width: 250px !important;">الشركة</th>
                            </tr>
                        ';
                       }
                       else{
                            echo'<tr>
                                    <th style="width: 250px !important;">Bank Name</th>
                                    <th>Owner</th>
                                    <th>Kazaa</th>
                                    <th>City</th>
                                    <th>Street</th>
                                    <th>Phone</th>
                                    <th>WhatsApp</th>
                                    <th>Fax</th>
                                    <th>Email</th>
                                </tr>';
                       }
                        foreach($query as $row) {
                             if(@$row->is_adv == 1)
                                        $css_ex = 'font-weight:bold; font-size:14px !important';
                                    elseif(@$row->copy_res == 1)
                                        $css_ex = 'font-weight:bold; font-size:13px !important';
                                    else
                                        $css_ex = 'font-size:12px !important';
                                        if($lang=='ar'){
                                         echo '<tr>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->email.'</td>
                                          	<td style="text-align:center; '.$css_ex.'">'.$row->fax.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->phone.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->whatsapp.'</td>
                                            <td style="direction:rtl !important; text-align:center !important; '.$css_ex.'">'.$row->street_ar.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->area_ar.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->district_ar.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->owner_ar.'</td>
                                            <td style="direction:rtl !important; text-align:center !important; '.$css_ex.'">'.$row->name_ar.'</td>
                                        </tr>';
                                        }
                                        else{
                                            echo '<tr>
                                            <td style="text-align:center !important; '.$css_ex.'">'.$row->name_en.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->owner_en.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->district_en.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->area_en.'</td>
                                            <td style="text-align:center !important; '.$css_ex.'">'.$row->street_en.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->phone.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->whatsapp.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->fax.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->email.'</td>
                                        </tr>'; 
                                        }
                            
                        }
        echo '</table></body>';
        exit;
    }
    public function export_transportation1($lang = 'ar') {
        //echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
        $query = $this->Report->GetTransportation($lang);

        $data = array();

        foreach($query as $row) {
            if($lang == 'ar') {
                array_push($data, array(
                        'الشركة ' => $row->name_ar,
                        'صاحب الشركة ' => $row->owner_ar,
                        'قضاء' => $row->district_ar,
                        'المدينة' => $row->area_ar,
                        'الشارع' => $row->street_ar,
                        'هاتف' => $row->phone,
                        'واتساپ' => $row->whatsapp,
                        'فاكس' => $row->fax,
                        'ص.ب' => $row->pobox_ar,
                        'البريد اللكتروني' => $row->email,
                    )
                );
            }
            else {

                array_push($data, array(
                        'Company' => $row->name_en,
                        'Owner' => $row->owner_en,
                        'Kazaa' => $row->district_en,
                        'City' => $row->area_en,
                        'Street' => $row->street_en,
                        'Phone' => $row->phone,
                        'WhatsApp' => $row->whatsapp,
                        'Fax' => $row->fax,
                        'P.O.BOX' => $row->pobox_en,
                        'Email' => $row->email,
                    )
                );
            }
        }
        $name = 'Reports-transportation-'.$lang;
        $this->export->Excel($data, $name);
    }

    public function insurance($lang = 'ar') {
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Reports');
        $this->breadcrumb->add_crumb('Insurance');

        $this->data['query'] = $this->Report->GetInsurance($lang);
        if($lang == 'en') {
            $this->data['title'] = $this->data['Ctitle']." -  The Insurance Company";
            $this->data['subtitle'] = "The Insurance Company ";
        }
        else {
            $this->data['title'] = $this->data['Ctitle']." شركات التأمين العاملة في لبنان";
            $this->data['subtitle'] = "شركات التأمين العاملة في لبنان";
        }
        $this->template->load('_template', 'reports/insurance_'.$lang, $this->data);
    }
function export_insurance($lang = 'ar') {
        // filename for download
        $filename = "insurances-".$lang.".xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');
        $flag = false;
        echo '<style type="text/css">
				.table tr td {
					border:1px solid #000;
				}
				.yellow{
				        font-weight: bold;
					}
				.table tr th{
					border:1px solid #FFF;
					background: #000;
					color: #FFF;
					font-weight: bold;
				}
				.htitle{
				border:1px solid #FFF !important;
				height:5px !important;
					}
				</style>   ';
				
                $query = $this->Report->GetInsurance($lang);
                        $x=TRUE;
                        echo '<body style="width:1080;font-family: Arial;"><table style="width:1080px !important; border:1px solid #000;" cellpadding="0" cellspacing="0" width="1080" class="table">';
                       if($lang == 'ar') {
                        echo'<tr>
                                <th>البريد الكتروني</th>
                                <th>فاكس</th>
                               <th>هاتف</th>
                               <th>واتساپ</th>
                                <th>الشارع</th>
                                <th>المدينة</th>
                                <th>قضاء</th>
                                <th>صاحب الشركة</th>
                                <th style="width: 250px !important;">الشركة</th>
                            </tr>
                        ';
                       }
                       else{
                            echo'<tr>
                                    <th style="width: 250px !important;">Bank Name</th>
                                    <th>Owner</th>
                                    <th>Kazaa</th>
                                    <th>City</th>
                                    <th>Street</th>
                                    <th>Phone</th>
                                    <th>WhatsApp</th>
                                    <th>Fax</th>
                                    <th>Email</th>
                                </tr>';
                       }
                        foreach($query as $row) {
                             if(@$row->is_adv == 1)
                                        $css_ex = 'font-weight:bold; font-size:14px !important';
                                    elseif(@$row->copy_res == 1)
                                        $css_ex = 'font-weight:bold; font-size:13px !important';
                                    else
                                        $css_ex = 'font-size:12px !important';
                                        if($lang=='ar'){
                                         echo '<tr>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->email.'</td>
                                          	<td style="text-align:center; '.$css_ex.'">'.$row->fax.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->phone.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->whatsapp.'</td>
                                            <td style="direction:rtl !important; text-align:center !important; '.$css_ex.'">'.$row->street_ar.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->area_ar.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->district_ar.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->chairman_ar.'</td>
                                            <td style="direction:rtl !important; text-align:center !important; '.$css_ex.'">'.$row->name_ar.'</td>
                                        </tr>';
                                        }
                                        else{
                                            echo '<tr>
                                            <td style="text-align:center !important; '.$css_ex.'">'.$row->name_en.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->chairman_en.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->district_en.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->area_en.'</td>
                                            <td style="text-align:center !important; '.$css_ex.'">'.$row->street_en.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->phone.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->whatsapp.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->fax.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->email.'</td>
                                        </tr>'; 
                                        }
                            
                        }
        echo '</table></body>';
        exit;
    }
    public function export_insurance1($lang = 'ar') {
        //echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
        $query = $this->Report->GetInsurance($lang);

        $data = array();

        foreach($query as $row) {
            if($lang == 'ar') {
                array_push($data, array(
                        'الشركة ' => $row->name_ar,
                        'صاحب الشركة ' => $row->chairman_ar,
                        'قضاء' => $row->district_ar,
                        'المدينة' => $row->area_ar,
                        'الشارع' => $row->street_ar,
                        'هاتف' => $row->phone,
                        'واتساپ' => $row->whatsapp,
                        'فاكس' => $row->fax,
                        'ص.ب' => $row->pobox_ar,
                        'البريد اللكتروني' => $row->email,
                    )
                );
            }
            else {

                array_push($data, array(
                        'Company' => $row->name_en,
                        'Owner' => $row->chairman_en,
                        'Kazaa' => $row->district_en,
                        'City' => $row->area_en,
                        'Street' => $row->street_en,
                        'WhatsApp' => $row->whatsapp,
                        'Fax' => $row->fax,
                        'P.O.BOX' => $row->pobox_en,
                        'Email' => $row->email,
                    )
                );
            }
        }
        $name = 'Reports-insurance-'.$lang;
        $this->export->Excel($data, $name);
    }

    public function geocompany($lang = 'ar') {

        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Reports');
        $this->breadcrumb->add_crumb('Geo Compnay');
        $secter = 0;
        if(isset($_GET['search'])) {
            $lang = $this->input->get('lang');
            $gov_id = $this->input->get('gov');
        }

        //$this->data['query']=$this->Report->GetCompany($lang);
        if($lang == 'en') {
            $this->data['title'] = $this->data['Ctitle']." -  Geo Company";
            $this->data['subtitle'] = " Geo  Company ";
        }
        else {
            $this->data['title'] = $this->data['Ctitle']."الشركات الصناعية - ";
            $this->data['subtitle'] = "الشركات الصناعية ";
        }


        $this->data['governorates'] = $this->Address->GetGovernorate('', 0, 0);
        $this->data['gov_id'] = @$gov_id;
        $this->template->load('_template', 'reports/geocompanies_'.$lang, $this->data);
    }
function ExportGeoCompanyAr($gov = '') {
        // filename for download
        $filename = "companies-geo-ar.xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');
        $flag = false;
        echo '<style type="text/css">
				.table tr td {
					border:1px solid #000;
				}
				.yellow{
				        font-weight: bold;
					}
				.table tr th{
					border:1px solid #FFF;
					background: #000;
					color: #FFF;
					font-weight: bold;
				}
				.htitle{
				border:1px solid #FFF !important;
				height:5px !important;
					}
				</style>   ';
      
                        $x=TRUE;
                        echo '<body style="width:1080;font-family: Arial;"><table style="width:1080px !important;" cellpadding="0" cellspacing="0" width="1080" class="table">';
        if($gov != '') {
             $gov_array = $this->Address->GetGovernorateById($gov);
            $districts = $this->Address->GetDistrictByGov('', $gov_array['id']);
            echo '<tr><td colspan="6" align="center" style="border:none !important;"><center><h3 style="margin:5px; font-size:29px !important">'.$gov_array['label_ar'].'</h3></center></td></tr>';
            foreach($districts as $district) {
                
                echo '<tr><td class="htitle" colspan="6" align="center" style="font-weight:bold"></td></tr>
                <tr><td style="background:#A6A6A6; font-weight:bold;  font-size:21px !important; border:none !important;" colspan="6" align="center"><center>قضاء  : '.$district->label_ar.'</center></td></tr>';
                $areas = $this->Address->GetAreaByDistrict('', $district->id);
                foreach($areas as $area) {

                    $companies = $this->Report->GetCompaniesByArea($area->id, 'ar');
                    if(count($companies) > 0) {
                        echo '<tr><td colspan="6"  class="htitle" align="center" style="font-weight:bold"></td></tr>
                        <tr><td colspan="6" align="center" style="background:#BFBFBF; font-weight:bold; font-size:19px !important; text-align:center !important; border:none !important;"><center>'.$area->label_ar.'</center></td></tr>';
                            echo '<tr><td colspan="6"  class="htitle" align="center" style="font-weight:bold"></td></tr>';
                            foreach($companies as $row) {
                                     if($row->is_adv == 1)
                                        $css_ex = 'font-weight:bold; font-size:14px !important';
                                    elseif($row->copy_res == 1)
                                        $css_ex = 'font-weight:bold; font-size:13px !important';
                                    else
                                        $css_ex = 'font-size:12px !important';

                                   
                                      if($x)
                                      {
                                               echo'<tr>
                                                        <th>البريد الكتروني</th>
                                                        <th>فاكس</th>
                                                       <th>هاتف</th>
                                                       <th>واتساپ</th>
                                                        <th>الشارع</th>
                                                        <th>النشاط</th>
                                                        <th style="width: 250px !important;">الشركة</th>
                                                    </tr>'; 
                                                $x=FALSE;
                                      }
                                    echo '<tr>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->email.'</td>
                                          	<td style="text-align:center; '.$css_ex.'">'.$row->fax.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->phone.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->whatsapp.'</td>
                                            <td style="direction:rtl !important; text-align:center !important; '.$css_ex.'">'.$row->street_ar.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->activity_ar.'</td>
                                            <td style="direction:rtl !important; text-align:center !important; '.$css_ex.'">'.$row->name_ar.'</td>
                                        </tr>';
                                }

                    }
                }
            }
        }
        else{
            
        }
       // echo '</tbody>';

        echo '</table></body>';

        //return $filename;
        exit;
    }
    function ExportGeoCompanyEn($gov = '') {
        // filename for download
        $filename = "companies-geo-en.xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');
        $flag = false;
        echo '<style type="text/css">
				.table tr td {
					border:1px solid #000;
				}
				.yellow{
				        font-weight: bold;
					}
				.table tr th{
					border:1px solid #FFF;
					background: #000;
					color: #FFF;
					font-weight: bold;
				}
				.htitle{
				border:1px solid #FFF !important;
				height:5px !important;
					}
				</style>   ';
      
                        $x=TRUE;
                        echo '<body style="width:1080;font-family: Arial;"><table style="width:1080px !important;" cellpadding="0" cellspacing="0" width="1080" class="table">';
        if($gov != '') {
             $gov_array = $this->Address->GetGovernorateById($gov);
            $districts = $this->Address->GetDistrictByGov('', $gov_array['id']);
            echo '<tr><td colspan="6" align="center" style="border:none !important;"><center><h3 style="margin:5px; font-size:29px !important">'.$gov_array['label_en'].'</h3></center></td></tr>';
            foreach($districts as $district) {
                
                echo '<tr><td class="htitle" colspan="6" align="center" style="font-weight:bold"></td></tr>
                <tr><td style="background:#A6A6A6; font-weight:bold;  font-size:21px !important; border:none !important;" colspan="6" align="center"><center>Kazaa  : '.$district->label_en.'</center></td></tr>';
                $areas = $this->Address->GetAreaByDistrict('', $district->id);
                foreach($areas as $area) {

                    $companies = $this->Report->GetCompaniesByArea($area->id, 'en');
                    if(count($companies) > 0) {
                        echo '<tr><td colspan="6"  class="htitle" align="center" style="font-weight:bold"></td></tr>
                        <tr><td colspan="6" align="center" style="background:#BFBFBF; font-weight:bold; font-size:19px !important; text-align:center !important; border:none !important;"><center>'.$area->label_en.'</center></td></tr>';
                        echo '<tr><td colspan="6"  class="htitle" align="center" style="font-weight:bold"></td></tr>';    
                            foreach($companies as $row) {
                                     if($row->is_adv == 1)
                                        $css_ex = 'font-weight:bold; font-size:14px !important';
                                    elseif($row->copy_res == 1)
                                        $css_ex = 'font-weight:bold; font-size:13px !important';
                                    else
                                        $css_ex = 'font-size:12px !important';

                                   
                                      if($x)
                                      {
                                               echo' <tr>
                                                       <th>Company</th>
                        								<th>Activity</th>
                        								<th>Street</th>
                        								<th>Phone</th>
                        								<th>WhatsApp</th>
                        								<th>Fax</th>
                                                        <th>Email</th>
                                                    </tr>'; 
                                                $x=FALSE;
                                      }
                                    echo '<tr>
                                            <td style="text-align:center !important; '.$css_ex.'">'.$row->name_en.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->activity_en.'</td>
                                            <td style="text-align:center !important; '.$css_ex.'">'.$row->street_en.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->phone.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->whatsapp.'</td>
                                          	<td style="text-align:center; '.$css_ex.'">'.$row->fax.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->email.'</td>
                                        </tr>';
                                }

                    }
                }
            }
        }
        else{
            
        }
       // echo '</tbody>';

        echo '</table></body>';

        //return $filename;
        exit;
    }
    public function ExportGeoCompanyAr1($gov = '') {

        // filename for download
        $filename = "geo-companies-ar-".$gov.".xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');
        $flag = false;
        echo '<style type="text/css">
				tr, td, table, tr{
					border:1px solid #D0D0D0;
				}
				.yellow{
						background:#FF0 !important;
					}
					.bold{
						font-weight:bold !important;
					}
				</style>   ';
        echo '<table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                                <th>البريد اللكتروني</th>
                                <th>ص.ب</th>
                                 <th>فاكس</th>
                               	 <th>هاتف</th>
                                 <th>واتساپ</th>
                                <th>الشارع</th>
                                <th>النشاط</th>
                                <th>الشركة</th>
                            </tr>
                        </thead>
                        <tbody>';
        if($gov != '') {
            $gov_array = $this->Address->GetGovernorateById($gov);
            $districts = $this->Address->GetDistrictByGov('', $gov_array['id']);
            echo '<tr><td colspan="7" align="center"><center><h3 style="margin:0px; padding:0px">'.$gov_array['label_ar'].'</h3></center></td></tr><tr><td colspan="8" align="center" style="font-weight:bold"></td></tr>	';
            foreach($districts as $district) {
                echo '<tr><td colspan="7" align="center" style="font-weight:bold"><center>قضاء  : '.$district->label_ar.'</center></td></tr><tr><td colspan="8" align="center" style="font-weight:bold"></td></tr>	';
                $areas = $this->Address->GetAreaByDistrict('', $district->id);
                foreach($areas as $area) {


                    $companies = $this->Report->GetCompaniesByArea($area->id, 'ar');
                    if(count($companies) > 0) {
                        echo '<tr><td colspan="7" align="center" style="font-weight:bold"><center>'.$area->label_ar.'</center></td></tr><tr><td colspan="8" align="center" style="font-weight:bold"></td></tr>	';
                        foreach($companies as $row) {

                            if($row->copy_res == 1)
                                $css_ex = 'font-weight:bold';
                            else
                                $css_ex = '';

                            if($row->is_adv == 1)
                                $css = 'yellow';
                            else
                                $css = '';

                            echo '<tr class="'.$css.'">
                                            <td class="'.$css.'" style="text-align:right; '.$css_ex.'">'.$row->email.'</td>
                                            <td class="'.$css.'" style="direction:rtl !important; text-align:right !important; '.$css_ex.'">'.$row->pobox_ar.'</td>
                                          	<td class="'.$css.'" style="text-align:right; '.$css_ex.'">'.$row->fax.'</td>
                                            <td class="'.$css.'" style="text-align:right; '.$css_ex.'">'.$row->phone.'</td>
                                            <td class="'.$css.'" style="text-align:right; '.$css_ex.'">'.$row->whatsapp.'</td>
                                            <td class="'.$css.'" style="direction:rtl !important; text-align:right !important '.$css_ex.'">'.$row->street_ar.'</td>
                                            <td class="'.$css.'" style="text-align:right; '.$css_ex.'">'.$row->activity_ar.'</td>
                                            <td class="'.$css.'" style="direction:rtl !important; text-align:right !important; '.$css_ex.'">'.$row->name_ar.'</td>
                                        </tr>';
                        }
                    }
                }
            }
        }
        else {
            $governorates = $this->Address->GetGovernorate('', 0, 0);
            foreach($governorates as $governorate) {
                $districts = $this->Address->GetDistrictByGov('', $governorate->id);
                echo '<tr><td colspan="7" align="center"><center><h3 style="margin:0px; padding:0px">'.$governorate->label_ar.'</h3></center></td></tr><tr><td colspan="8" align="center" style="font-weight:bold"></td></tr>	';
                foreach($districts as $district) {
                    echo '<tr><td colspan="7" align="center" style="font-weight:bold"><center>قضاء  : '.$district->label_ar.'</center></td></tr><tr><td colspan="8" align="center" style="font-weight:bold"></td></tr>	';
                    $areas = $this->Address->GetAreaByDistrict('', $district->id, 'ar');
                    foreach($areas as $area) {


                        $companies = $this->Report->GetCompaniesByArea($area->id, 'ar');
                        if(count($companies) > 0) {
                            echo '<tr><td colspan="7" align="center" style="font-weight:bold"><center>'.$area->label_ar.'</center></td></tr><tr><td colspan="8" align="center" style="font-weight:bold"></td></tr>	';
                            foreach($companies as $row) {
                                if($row->copy_res == 1)
                                    $css_ex = 'font-weight:bold';
                                else
                                    $css_ex = '';

                                if($row->is_adv == 1)
                                    $css = 'yellow';
                                else
                                    $css = '';

                                echo '<tr class="'.$css.'">
                                            <td class="'.$css.'" style="text-align:right; '.$css_ex.'">'.$row->email.'</td>
                                            <td class="'.$css.'" style="direction:rtl !important; text-align:right !important; '.$css_ex.'">'.$row->pobox_ar.'</td>
                                          	<td class="'.$css.'" style="text-align:right; '.$css_ex.'">'.$row->fax.'</td>
                                            <td class="'.$css.'" style="text-align:right; '.$css_ex.'">'.$row->phone.'</td>
                                            <td class="'.$css.'" style="text-align:right; '.$css_ex.'">'.$row->whatsapp.'</td>
                                            <td class="'.$css.'" style="direction:rtl !important; text-align:right !important; '.$css_ex.'">'.$row->street_ar.'</td>
                                            <td class="'.$css.'" style="text-align:right; '.$css_ex.'">'.$row->activity_ar.'</td>
                                            <td class="'.$css.'" style="direction:rtl !important; text-align:right !important; '.$css_ex.'">'.$row->name_ar.'</td>
                                        </tr>';
                            }
                        }
                    }
                }
            }
        }
        echo '</tbody>';

        echo '</table>';

        //return $filename;
        exit;
    }

    public function ExportGeoCompanyEn1($gov = '') {

        // filename for download
        $filename = "geo-companies-en-".$gov.".xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');
        $flag = false;
        echo '<style type="text/css">
				tr, td, table, tr{
					border:1px solid #D0D0D0;
				}
				.yellow{
						background:#FF0 !important;
					}
				.bold{
						font-weight:bold !important;
					}
				</style>   ';
        echo '<table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                               <th>Company</th>
								<th>Activity</th>
								<th>Street</th>
								<th>Phone</th>
								<th>WhatsApp</th>
								<th>Fax</th>
								<th>P.O.BOX</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>';
        if($gov != '') {
            $gov_array = $this->Address->GetGovernorateById($gov);
            $districts = $this->Address->GetDistrictByGov('', $gov_array['id']);
            echo '<tr><td colspan="7" align="center"><center><h3 style="margin:0px; padding:0px">'.$gov_array['label_en'].'</h3></center></td></tr>
							<tr><td colspan="8" align="center" style="font-weight:bold"></td></tr>	';
            foreach($districts as $district) {
                echo '<tr><td colspan="7" align="center" style="font-weight:bold"><center>Kazaa  : '.$district->label_en.'</center></td></tr>
								  <tr><td colspan="8" align="center" style="font-weight:bold"></td></tr>	';
                $areas = $this->Address->GetAreaByDistrict('', $district->id, 'en');
                foreach($areas as $area) {


                    $companies = $this->Report->GetCompaniesByArea($area->id, 'en');
                    if(count($companies) > 0) {
                        echo '<tr><td colspan="7" align="center" style="font-weight:bold"><center>'.$area->label_en.'</center></td></tr>
											 <tr><td colspan="8" align="center" style="font-weight:bold"></td></tr>	';
                        foreach($companies as $row) {
                            if($row->copy_res == 1)
                                $css_ex = 'font-weight:bold';
                            else
                                $css_ex = '';
                            if($row->is_adv == 1)
                                $css = 'yellow';
                            else
                                $css = '';

                            echo '<tr class="'.$css.'" style="'.$css_ex.'">
									  		<td class="'.$css.'" style="'.$css_ex.'" >'.$row->name_en.'</td>
											<td class="'.$css.'" style=" style="'.$css_ex.'">'.$row->activity_en.'</td>
											<td class="'.$css.'" style="'.$css_ex.'">'.$row->street_en.'</td>
											<td class="'.$css.'" style="'.$css_ex.'">'.$row->phone.'</td>
											<td class="'.$css.'" style="'.$css_ex.'">'.$row->whatsapp.'</td>
											<td class="'.$css.'" style="'.$css_ex.'">'.$row->fax.'</td>
											<td class="'.$css.'" style="'.$css_ex.'">'.$row->pobox_en.'</td>
                                            <td class="'.$css.'" style="'.$css_ex.'">'.$row->email.'</td>
                                        </tr>';
                        }
                    }
                }
            }
        }
        else {

            $governorates = $this->Address->GetGovernorate('', 0, 0);
            foreach($governorates as $governorate) {
                $districts = $this->Address->GetDistrictByGov('', $governorate->id);
                echo '<tr><td colspan="7" align="center"><center><h3 style="margin:0px; padding:0px">'.$governorate->label_en.'</h3></center></td></tr>
							<tr><td colspan="8" align="center" style="font-weight:bold"></td></tr>	';
                foreach($districts as $district) {
                    echo '<tr><td colspan="7" align="center" style="font-weight:bold"><center>Kazaa  : '.$district->label_en.'</center></td></tr>
								  <tr><td colspan="8" align="center" style="font-weight:bold"></td></tr>	';
                    $areas = $this->Address->GetAreaByDistrict('', $district->id);
                    foreach($areas as $area) {


                        $companies = $this->Report->GetCompaniesByArea($area->id, 'en');
                        if(count($companies) > 0) {
                            echo '<tr><td colspan="7" align="center" style="font-weight:bold"><center>'.$area->label_en.'</center></td></tr>
											 <tr><td colspan="8" align="center" style="font-weight:bold"></td></tr>	';
                            foreach($companies as $row) {
                                if($row->copy_res == 1)
                                    $css_ex = 'font-weight:bold';
                                else
                                    $css_ex = '';

                                if($row->is_adv == 1)
                                    $css = 'yellow';
                                else
                                    $css = '';

                                echo '<tr class="'.$css.'" style="'.$css_ex.'">
									  		<td class="'.$css.'" style="'.$css_ex.'" >'.$row->name_en.'</td>
											<td class="'.$css.'" style="'.$css_ex.'">'.$row->activity_en.'</td>
											<td class="'.$css.'" style="'.$css_ex.'">'.$row->street_en.'</td>
											<td class="'.$css.'" style="'.$css_ex.'">'.$row->phone.'</td>
											<td class="'.$css.'" style="'.$css_ex.'">'.$row->whatsapp.'</td>
											<td class="'.$css.'" style="'.$css_ex.'">'.$row->fax.'</td>
											<td class="'.$css.'" style="'.$css_ex.'">'.$row->pobox_en.'</td>
                                            <td class="'.$css.'" style="'.$css_ex.'">'.$row->email.'</td>
                                        </tr>';
                            }
                        }
                    }
                }
            }
        }
        echo '</tbody>';

        echo '</table>';

        //return $filename;
        exit;
    }

    public function duplicate_name() {
        // filename for download
        $filename = "duplicatename-".time().".xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');
        $flag = false;

        echo '<style type="text/css">
tr, td, table, tr{
	border:1px solid #D0D0D0;
}
.yellow{
						background:#FF0 !important;
					}
</style>   ';
        $query = $this->Company->GetDuplicateName();
        //$query=array();


        echo '<table cellpadding="0" cellspacing="0" style="border:1px solid; background:none !important" width="100%" class="table">
                        <thead>
                            <tr>
								<th>Code</th>
								<th>Name AR</th>
								<th>Name EN</th>
								<th>OWNER NAME AR?</th>
								<th>OWNER NAME EN</th>
								 <th>Activity AR</th>
                                 <th>Activity EN</th>
                                 <th>Mohafaza AR</th>
                                 <th>Mohafaza EN</th>
								 <th>Kazaa AR</th>
								 <th>Kazaa EN</th>
                                 <th>Are AR</th>
                                <th>Area EN</th>
								<th>Street AR</th>
								<th>Street EN</th>
								<th>Phone</th>
								<th>WhatsApp</th>
								<th>Fax</th>
								<th>POBOX AR</th>
								<th>POBOX EN</th>
								<th>Website</th>
								<th>Email</th>
								<th>X Location</th>
								<th>Y Location</th>
								<th>Advertised</th>
								<th>Responsable AR</th>
								<th>Responsable EN</th>
								<th>Exporter?</th>
								<th>Is Closed?</th>
								<th>Closed Date</th>
								<th>Number of Labour</th>
								<th>Wezara ID</th>

                              </tr>
                        </thead>
                        <tbody>';
        foreach($query as $row) {
            echo ' <tr>
									<td>'.$row->id.'</td>
									<td>'.$row->name_ar.'</td>
									<td>'.$row->name_en.'</td>
									<td>'.$row->owner_name.'</td>
									<td>'.$row->owner_name_en.'</td>
									<td>'.$row->activity_ar.'</td>
									<td>'.$row->activity_en.'</td>
									<td>'.$row->governorate_ar.'</td>
									<td>'.$row->governorate_en.'</td>
									<td>'.$row->district_ar.'</td>
									<td>'.$row->district_en.'</td>
									<td>'.$row->area_ar.'</td>
									<td>'.$row->area_en.'</td>
									<td>'.$row->street_ar.'</td>
									<td>'.$row->street_en.'</td>
									<td>'.$row->phone.'</td>
									<td>'.$row->whatsapp.'</td>
									<td>'.$row->fax.'</td>
									<td>'.$row->pobox_ar.'</td>
									<td>'.$row->pobox_en.'</td>
									<td>'.$row->website.'</td>
									<td>'.$row->email.'</td>
									<td>'.$row->x_location.'</td>
									<td>'.$row->y_location.'</td>
									<td>'.$row->is_adv.'</td>
									<td>'.$row->rep_person_ar.'</td>
									<td>'.$row->rep_person_en.'</td>
									<td>'.$row->is_exporter.'</td>
									<td>'.$row->is_closed.'</td>
									<td>'.$row->closed_date.'</td>
									<td>'.$row->employees_number.'</td>
									<td>'.$row->ministry_id.'</td>

								</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        //exit;

    }
    public function heading_companies() {
        // filename for download
        $filename = "heading-companies.xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
       header('Content-type: text/html; charset=UTF-8');
        $flag = false;

        echo '<style type="text/css">
tr, td, table, tr{
	border:1px solid #D0D0D0;
}
.yellow{
						background:#FF0 !important;
					}
</style>   ';
        $query = $this->Report->GetHeadingCompaniesRep();

        echo '<table cellpadding="0" cellspacing="0" style="border:1px solid; background:none !important" width="100%" class="table">
                        <thead>
                            <tr>
								<th rowspan="3">H.S Code</th>
								<th rowspan="3">الوصف الخاص</th>
								<th rowspan="3">النسبة</th>
								<th rowspan="3">عدد المصانع</th>
								<th colspan="9">استيراد</th>
								<th colspan="9">تصدير</th>
                              </tr>
                               <tr>
								<th colspan="3">2018</th>
								<th colspan="3">2017</th>
								<th colspan="3">2016</th>
								<th colspan="3">2018</th>
								<th colspan="3">2017</th>
								<th colspan="3">2016</th>
                              </tr>
                               <tr>
								<th>الكمية بالطن</th>
								<th>ليرة لبنانية</th>
								<th>دولار اميركي</th>
								<th>الكمية بالطن</th>
								<th>ليرة لبنانية</th>
								<th>دولار اميركي</th>
								<th>الكمية بالطن</th>
								<th>ليرة لبنانية</th>
								<th>دولار اميركي</th>
								<th>الكمية بالطن</th>
								<th>ليرة لبنانية</th>
								<th>دولار اميركي</th>
								<th>الكمية بالطن</th>
								<th>ليرة لبنانية</th>
								<th>دولار اميركي</th>
								<th>الكمية بالطن</th>
								<th>ليرة لبنانية</th>
								<th>دولار اميركي</th>
                              </tr>
                        </thead>
                        <tbody>';
        foreach($query as $row) {
            echo ' <tr>
									<td>'.$row->hs_code_print.'</td>
									<td>'.$row->description_ar.'</td>
									<td>'.$row->rate1.'</td>
									<td>'.$row->TotalCompanies.'</td>
									<td>'.$row->tones_import_2018.'</td>
									<td>'.$row->import_lbp_2018.'</td>
									<td>'.$row->import_usd_2018.'</td>
									<td>'.$row->tones_import_2017.'</td>
									<td>'.$row->import_lbp_2017.'</td>
									<td>'.$row->import_usd_2017.'</td>
									<td>'.$row->tones_import_2016.'</td>
									<td>'.$row->import_lbp_2016.'</td>
									<td>'.$row->import_usd_2016.'</td>
									<td>'.$row->tones_export_2018.'</td>
									<td>'.$row->export_lbp_2018.'</td>
									<td>'.$row->export_usd_2018.'</td>
									<td>'.$row->tones_export_2017.'</td>
									<td>'.$row->export_lbp_2017.'</td>
									<td>'.$row->export_usd_2017.'</td>
									<td>'.$row->tones_export_2016.'</td>
									<td>'.$row->export_lbp_2016.'</td>
									<td>'.$row->export_usd_2016.'</td>
								
								</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        //exit;
    }
    public function fulldata() {
        // filename for download
        $filename = "full-data.xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');
        $flag = false;

        echo '<style type="text/css">
tr, td, table, tr{
	border:1px solid #D0D0D0;
}
.yellow{
						background:#FF0 !important;
					}
</style>   ';
        $query = $this->Report->GetFullCompanies();

        echo '<table cellpadding="0" cellspacing="0" style="border:1px solid; background:none !important" width="100%" class="table">
                        <thead>
                            <tr>
								<th>Code</th>
								<th>Name AR</th>
								<th>Name EN</th>
								<th>OWNER NAME AR?</th>
								<th>OWNER NAME EN</th>
                                <th>Sector AR</th>
								<th>Sector EN</th>
								 <th>Activity AR</th>
                                 <th>Activity EN</th>
                                 <th>Mohafaza AR</th>
                                 <th>Mohafaza EN</th>
								 <th>Kazaa AR</th>
								 <th>Kazaa EN</th>
                                 <th>Are AR</th>
                                <th>Area EN</th>
								<th>Street AR</th>
								<th>Street EN</th>
								<th>Phone</th>
								<th>WhatsApp</th>
								<th>Fax</th>
								<th>POBOX AR</th>
								<th>POBOX EN</th>
								<th>Website</th>
								<th>Email</th>
								<th>X Location</th>
								<th>Y Location</th>
								<th>Advertised</th>
								<th>Responsable AR</th>
								<th>Responsable EN</th>
								
								<th>Exporter?</th>
								<th>Is Closed?</th>
								<th>Closed Date</th>
								<th>Number of Labour</th>
								<th>Wezara ID</th>
                                <th>Comments</th>
								<th>Error In Address</th>
								<th>Update Info</th>
								<th>Done Acc.</th>
                              </tr>
                        </thead>
                        <tbody>';
        foreach($query as $row) {
            echo ' <tr>
									<td>'.$row->id.'</td>
									<td>'.$row->name_ar.'</td>
									<td>'.$row->name_en.'</td>
									<td>'.$row->owner_name.'</td>
									<td>'.$row->owner_name_en.'</td>

                                    <td>'.$row->sector_ar.'</td>
									<td>'.$row->sector_en.'</td>

									<td>'.$row->activity_ar.'</td>
									<td>'.$row->activity_en.'</td>
									<td>'.$row->governorate_ar.'</td>
									<td>'.$row->governorate_en.'</td>
									<td>'.$row->district_ar.'</td>
									<td>'.$row->district_en.'</td>
									<td>'.$row->area_ar.'</td>
									<td>'.$row->area_en.'</td>
									<td>'.$row->street_ar.'</td>
									<td>'.$row->street_en.'</td>
									<td>'.$row->phone.'</td>
									<td>'.$row->whatsapp.'</td>
									<td>'.$row->fax.'</td>
									<td>'.$row->pobox_ar.'</td>
									<td>'.$row->pobox_en.'</td>
									<td>'.$row->website.'</td>
									<td>'.$row->email.'</td>
									<td>'.$row->x_decimal.'</td>
									<td>'.$row->y_decimal.'</td>
									<td>'.$row->is_adv.'</td>
									<td>'.$row->rep_person_ar.'</td>
									<td>'.$row->rep_person_en.'</td>
									
									<td>'.$row->is_exporter.'</td>
									<td>'.(($row->is_closed==1)? 'yes' : '').'</td>
									<td>'.$row->closed_date.'</td>
									<td>'.$row->employees_number.'</td>
									<td>'.$row->ministry_id.'</td>
									<td>'.$row->personal_notes.'</td>
                                    <td>'.(($row->error_address==1)? 'yes' : '').'</td>
                                    <td>'.(($row->update_info==1)? 'yes' : '').'</td>
                                    <td>'.$row->acc.'</td>

								</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        //exit;
    }
    public function tst()
    {
        echo 'test';
    }
    public function fulldataar() {
        // filename for download
        //$query = $this->Report->GetFullCompanies();
        $query = $this->Report->GetfullCompaniesNew();
        $filename = "full-data-ar.xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');
        $flag = false;

        echo '<style type="text/css">
tr, td, table, tr{
	border:1px solid #D0D0D0;
}
.yellow{
						background:#FF0 !important;
					}
</style>   ';
        

        echo '<table cellpadding="0" cellspacing="0" style="border:1px solid; background:none !important" width="100%" class="table">
                        <thead>
                            <tr>
								<th>وزارة ID</th>
								<th>شركة الدليل الصناعي ID</th>
								<th>اسم المؤسسة</th>
								<th>صاحب / أصحاب الشركة</th>
								<th>اسم المفوض بالتوقيع</th>
								<th>رقم ومحل السجل التجاري</th>

                                <th> القطاع </th>
                                
								 <th>نوع النشاط</th>
                                 <th>مصدر الترخيص</th>
                                 <th>رقم الترخيص</th>
                                 <th>التاريخ</th>
								 <th>الفئة</th>
								 <th>نوع الشركة</th>
                                <th>جمعية الصناعيين اللبنانيين</th>
								<th>غرفة الصناعة والتجارة في </th>
								<th>تجمع صناعي</th>
								<th>نقابات أو اتحادات</th>
								<th>المحافظة</th>
								<th>القضاء</th>
								<th>البلدة أو المحلة</th>
								<th>الشارع</th>
								<th>هاتف</th>
                                <th>واتساپ</th>
								<th>فاكس</th>
								<th>ص. بريد</th>
								<th>البريد الالكتروني</th>
								<th>الموقع الالكتروني</th>
								<th>E Location</th>
								<th>N Location</th>
								<th>اسواق البيع والتصدير  </th>
								<th>عدد العمال</th>
								<th>طريقة التصدير</th>
                                <th>هل المؤسسة مؤمنة</th>
								<th>اسم الشركة</th>
								<th>المصارف المعتمدة</th>
								<th>استعمال الطاقة - فيول / طن او ليتر</th>
								<th>استعمال الطاقة - مازوت / طن أو ليتر</th>
								<th>اسم الشخص الذي تمت معه المقابلة في المؤسسة</th>
								<th>صفته في المؤسسة</th>
								<th>Related ID</th>
								<th>حاجز نسخة</th>
								<th>معلن</th>


                                <th>Start Date Ads</th>
                                <th>End Date Ads</th>
                                <th>Status Ads</th>

                                <th>Show Item Status </th>
                                <th>Show Item Start Date</th>
                                <th>Show Item End Date</th>

                                <th>SalesMan FullName </th>

                              </tr>
                        </thead>
                        <tbody>';
        foreach($query as $row) {
           // $items = $this->Company->GetProductionInfo($row->id);
            $position = $this->Item->GetPositionById($row->position_id);
            if(count($position) > 0) {
                $pos = $position['label_ar'];
            }
            else {
                $pos = '';
            }
            $banks = $this->Company->GetCompanyBanks($row->id);
            $banks_com='';
            if(count($banks)) {
                foreach($banks as $bank) {
                    $banks_com.= $bank->bank_ar.'<br>';
                }
            }
            $markets = $this->Company->GetCompanyMarkets($row->id);

            $array_market_ar = array();
            $array_market_en = array();
            if(count($markets)) {
                foreach($markets as $item) {
                    if($item->item_type == 'country') {
                        $row1 = $this->Parameter->GetCountryById($item->market_id);
                        if(isset($row1['label_ar']) && isset($row1['label_en']))
                        {
                            array_push($array_market_ar,$row1['label_ar']);
                            array_push($array_market_en,$row1['label_en']);
                        }
                    }
                    elseif($item->item_type == 'region') {
                        $row1 = $this->Parameter->GetCompanyMarketById($item->market_id);
                        if(isset($row1['label_ar']) && isset($row1['label_en']))
                        {
                            array_push($array_market_ar,$row1['label_ar']);
                            array_push($array_market_en,$row1['label_en']);
                        }
                    }



                }
            }
            $insurances = $this->Company->GetCompanyInsurances($row->id);
            $insurance_companies='';
            if(count($insurances)>0)
            {
                $is_insurance='نعم';
                foreach($insurances as $insurance) {
                    $insurance_companies .= $insurance->insurance_ar.'<br>';
                }
            }
            else{
                $is_insurance=' كلا';
            }
            $powers = $this->Company->GetCompanyElectricPowers($row->id);
            $fuel='';
            $diesel='';
            if(count($powers)) {
                foreach($powers as $power) {
                    $fuel= $power->fuel;
                    $diesel=$power->diesel;
                }
            }

            $industrial_room = $this->Company->GetIndustrialRoomById($row->iro_code);
            if(count($industrial_room) > 0) {
                $industrial_room_en = $industrial_room['label_en'];
                $industrial_room_ar = $industrial_room['label_ar'];
            }
            else {
                $industrial_room_en = '';
                $industrial_room_ar = '';
            }

            $industrial_group = $this->Company->GetIndustrialGroupById($row->igr_code);
            if(count($industrial_group) > 0) {
                $industrial_group_en = $industrial_group['label_en'];
                $industrial_group_ar = $industrial_group['label_ar'];
            }
            else {
                $industrial_group_en = '';
                $industrial_group_ar = '';
            }

            $economical_assembly = $this->Company->GetEconomicalAssemblyById($row->eas_code);
            if(count($economical_assembly) > 0) {
                $economical_assembly_en = $economical_assembly['label_en'];
                $economical_assembly_ar = $economical_assembly['label_ar'];
            }
            else {
                $economical_assembly_en = '';
                $economical_assembly_ar = '';
            }

            $license = $this->Company->GetLicenseSourceById($row->license_source_id);
            if(count(@$license) > 0) {
                $license_en = $license['label_en'];
                $license_ar = $license['label_ar'];
            }
            else {
                $license_en = '';
                $license_ar = '';
            }
            $source1='';
            $source2='';
            $source3='';
            if(@$row->wezara_source == 1)
            {
                $source1='وزارة الصناعة';
            }
            elseif($row->investment==1)
            {
                $source2='رخصة استثمار';
            }
            elseif($row->origin==1)
            {
                $source3='رخصة انشاء';
            }

            $export_m = '';

            if(@$row->is_exporter == 0) {
                $export_m = 'غير مصدر';
            }
            elseif(@$query['is_exporter'] == 1) {
                $export_m = 'مباشر';
            }
            elseif(@$query['is_exporter'] == 2) {
                $export_m = 'بالواسطة';
            }
            if($row->is_adv==1){
					$is_adv='نعم';
				}
				else{
					$is_adv='كلا';
					}	
					if($row->copy_res==1){
					$copy_res='نعم';
				}
				else{
					$copy_res='كلا';
					}	

            $status_adv="";
            if($row->status_adv==1)        	
            {
                $status_adv="Active";
            }
            elseif($row->status_adv==0)
            {
                $status_adv="Inactive";

            }
            echo ' <tr>
									<td>'.$row->ministry_id.'</td>
									<td>'.$row->id.'</td>
									<td>'.$row->name_ar.'</td>
									<td>'.$row->owner_name.'</td>
									<td>'.$row->auth_person_ar.'</td>
									<td>'.$row->auth_no.' / '.$license_ar.'</td>

                                    <td>'.$row->sector_ar.'</td>

									<td>'.$row->activity_ar.'</td>
									<td>'.$source1.' '.$source2.' '.$source3.'</td>
									<td>'.$row->nbr_source.'</td>
									<td>'.$row->date_source.'</td>
									<td>'.$row->type_source.'</td>
									<td>'.$row->type_ar.'</td>
									<td>'.(($row->ind_association==1)? 'نعم' : 'كلا').'</td>
									<td>'.$industrial_room_ar.'</td>
									<td>'.$industrial_group_ar.'</td>
									<td>'.$economical_assembly_ar.'</td>
									<td>'.$row->governorate_ar.'</td>
									<td>'.$row->district_ar.'</td>
									<td>'.$row->area_ar.'</td>
									<td>'.$row->street_ar.'</td>
									<td>'.$row->phone.'</td>
									<td>'.$row->whatsapp.'</td>
									<td>'.$row->fax.'</td>
									<td>'.$row->pobox_ar.'</td>
									<td>'.$row->email.'</td>
									<td>'.$row->website.'</td>
									<td>'.$row->x_decimal.'</td>
									<td>'.$row->y_decimal.'</td>
									<td>'.implode(' , ',$array_market_ar).'</td>
									<td>'.str_replace('-', '->', $row->employees_number).'</td>
									<td>'.$export_m.'</td>
									<td>'.$is_insurance.'</td>
									<td>'.$insurance_companies.'</td>
									<td>'.$banks_com.'</td>
									<td>'.$fuel.'</td>
									<td>'.$diesel.'</td>
									<td>'.$row->rep_person_ar.'</td>
									<td>'.$pos.'</td>
									<td>'.$row->related_companies.'</td>
									<td>'.$copy_res.'</td>
									<td>'.$is_adv.'</td>

                                    <td>'.$row->start_date_adv.'</td>
                                    <td>'.$row->end_date_adv.'</td>
                                    <td>'.$status_adv.'</td>

                                    <td>'.$row->clients_status_status.'</td>
                                    <td>'.$row->clients_status_start_date.'</td>
                                    <td>'.$row->clients_status_end_date.'</td>
                                  
                                    <td>'.$row->salesman_fullname_ar.'</td>


								</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        exit;
    }

    public function fulldataen() 
    {
        //$query = $this->Report->GetFullCompanies();
        $query = $this->Report->GetfullCompaniesNew();

        // filename for download
        $filename = "full-data-en.xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');
        $flag = false;

        echo '<style type="text/css">
                        tr, td, table, tr{
                            border:1px solid #D0D0D0;
                        }
                        .yellow{
                                                background:#FF0 !important;
                                            }
                        </style>   ';
       
        echo '<table cellpadding="0" cellspacing="0" style="border:1px solid; background:none !important" width="100%" class="table">
                        <thead>
                            <tr>
                            <th>Wezara ID</th>
                            <th>ID</th>
                            <th>Company Name</th>
                            <th>Company Owner</th>
                            <th>Auth. to sign</th>
                            <th>No. & Place of C.R </th>
                        
                            <th>Sector EN</th>

                            <th>Activity</th>     
                            <th> مصدر الترخیص </th>
                            <th> رقم الترخیص </th>
                            <th> التاریخ </th>
                            <th> الفئة</th>


                            <th>Company Type</th>
                            <th>Associations of Lebanese Industrialists</th>
                            <th>Chambre of Commerce & Industry of </th>
                            <th>Industrial Assembly</th>
                            <th>Assemblies of Economical, Technical</th>
                            <th>Mohafaza</th>
                            <th>Kazaa</th>
                            <th>City</th>
                            <th>Street</th>
                            <th>Phone</th>
                            <th>WhatsApp</th>
                            <th>Fax</th>
                            <th>P.O.Box</th>
                            <th>Email</th>
                            <th>Website</th>
                            <th>E Location</th>
                            <th>N Location</th>
                            <th>Export & Trade Market  </th>
                            <th>Number of Labour</th>
                            <th>Means of Export</th>
                            <th>Do You Have Insurance</th>
                            <th>Insurance Co. Name</th>
                            <th>Banks</th>
                            <th>Electric Power/year - Fuel / Ton Or Litre</th>
                            <th>Electric Power/year - Diesel / Ton Or Litre</th>
                            <th>اسم الشخص الذي تمت معه المقابلة في المؤسسة</th>								
                            <th>صفته في المؤسسة</th>
                            <th>Related ID</th>

                            <th>Start Date Ads</th>
                            <th>End Date Ads</th>
                            <th>Status Ads</th>

                            <th>Show Item Status </th>
                            <th>Show Item Start Date</th>
                            <th>Show Item End Date</th>
                            
                            <th>SalesMan FullName </th>
                        </tr>
                        </thead>
                        <tbody>';
        foreach($query as $row) {
           // $items = $this->Company->GetProductionInfo($row->id);
            $position = $this->Item->GetPositionById($row->position_id);
            if(count($position) > 0) {
                $pos = $position['label_ar'];
            }
            else {
                $pos = '';
            }
            $banks = $this->Company->GetCompanyBanks($row->id);
            $banks_com='';
            if(count($banks)) {
                foreach($banks as $bank) {
                    $banks_com.= $bank->bank_ar.'<br>';
                }
            }
            $markets = $this->Company->GetCompanyMarkets($row->id);

            $array_market_ar = array();
            $array_market_en = array();
            if(count($markets)) {
                foreach($markets as $item) {
                    if($item->item_type == 'country') {
                        $row1 = $this->Parameter->GetCountryById($item->market_id);
                        if(isset($row1['label_ar']) && isset($row1['label_en']))
                        {
                            array_push($array_market_ar,$row1['label_ar']);
                            array_push($array_market_en,$row1['label_en']);
                        }
                    }
                    elseif($item->item_type == 'region') {
                        $row1 = $this->Parameter->GetCompanyMarketById($item->market_id);
                        if(isset($row1['label_ar']) && isset($row1['label_en']))
                        {
                            array_push($array_market_ar,$row1['label_ar']);
                            array_push($array_market_en,$row1['label_en']);
                        }
                    }



                }
            }
            $insurances = $this->Company->GetCompanyInsurances($row->id);
            $insurance_companies='';
            if(count($insurances)>0)
            {
                $is_insurance='نعم';
                foreach($insurances as $insurance) {
                    $insurance_companies .= $insurance->insurance_ar.'<br>';
                }
            }
            else{
                $is_insurance=' كلا';
            }
            $powers = $this->Company->GetCompanyElectricPowers($row->id);
            $fuel='';
            $diesel='';
            if(count($powers)) {
                foreach($powers as $power) {
                    $fuel= $power->fuel;
                    $diesel=$power->diesel;
                }
            }

            $industrial_room = $this->Company->GetIndustrialRoomById($row->iro_code);
            if(count($industrial_room) > 0) {
                $industrial_room_en = $industrial_room['label_en'];
                $industrial_room_ar = $industrial_room['label_ar'];
            }
            else {
                $industrial_room_en = '';
                $industrial_room_ar = '';
            }

            $industrial_group = $this->Company->GetIndustrialGroupById($row->igr_code);
            if(count($industrial_group) > 0) {
                $industrial_group_en = $industrial_group['label_en'];
                $industrial_group_ar = $industrial_group['label_ar'];
            }
            else {
                $industrial_group_en = '';
                $industrial_group_ar = '';
            }

            $economical_assembly = $this->Company->GetEconomicalAssemblyById($row->eas_code);
            if(count($economical_assembly) > 0) {
                $economical_assembly_en = $economical_assembly['label_en'];
                $economical_assembly_ar = $economical_assembly['label_ar'];
            }
            else {
                $economical_assembly_en = '';
                $economical_assembly_ar = '';
            }

            $license = $this->Company->GetLicenseSourceById($row->license_source_id);
            if(count(@$license) > 0) {
                $license_en = $license['label_en'];
                $license_ar = $license['label_ar'];
            }
            else {
                $license_en = '';
                $license_ar = '';
            }
            $source1='';
            $source2='';
            $source3='';
            if(@$row->wezara_source == 1)
            {
                $source1='وزارة الصناعة';
            }
            elseif($row->investment==1)
            {
                $source2='رخصة استثمار';
            }
            elseif($row->origin==1)
            {
                $source3='رخصة انشاء';
            }

            $export_m = '';

            if(@$row->is_exporter == 0) {
                $export_m = 'غير مصدر';
            }
            elseif(@$query['is_exporter'] == 1) {
                $export_m = 'مباشر';
            }
            elseif(@$query['is_exporter'] == 2) {
                $export_m = 'بالواسطة';
            }
            if($row->is_adv==1){
					$is_adv='نعم';
				}
				else{
					$is_adv='كلا';
					}	
					if($row->copy_res==1){
					$copy_res='نعم';
				}
				else{
					$copy_res='كلا';
					}

            $status_adv="";
            if($row->status_adv==1)        	
            {
               $status_adv="Active";
            }
            elseif($row->status_adv==0)
            {
               $status_adv="Inactive";

            }

                echo ' <tr>
                            <td>'.$row->ministry_id.'</td>
                            <td>'.$row->id.'</td>
                            <td>'.$row->name_en.'</td>
                            <td>'.$row->owner_name_en.'</td>
                            <td>'.$row->auth_person_en.'</td>
                            <td>'.$row->auth_no.' / '.$license_en.'</td>
                            
                            <td>'.$row->sector_en.'</td>

                            <td>'.$row->activity_en.'</td>
                            <td>'.$source1.' '.$source2.' '.$source3.'</td>
                            <td>'.$row->nbr_source.'</td>
                            <td>'.$row->date_source.'</td>
                            <td>'.$row->type_source.'</td>
                            <td>'.$row->type_en.'</td>
                            <td>'.(($row->ind_association==1)? 'Yes' : 'No').'</td>
                            <td>'.$industrial_room_en.'</td>
                            <td>'.$industrial_group_en.'</td>
                            <td>'.$economical_assembly_en.'</td>
                            <td>'.$row->governorate_en.'</td>
                            <td>'.$row->district_en.'</td>
                            <td>'.$row->area_en.'</td>
                            <td>'.$row->street_en.'</td>
                            <td>'.$row->phone.'</td>
                            <td>'.$row->whatsapp.'</td>
                            <td>'.$row->fax.'</td>
                            <td>'.$row->pobox_en.'</td>
                            <td>'.$row->email.'</td>
                            <td>'.$row->website.'</td>
                            <td>'.$row->x_decimal.'</td>
                            <td>'.$row->y_decimal.'</td>
                            <td>'.implode(' , ',$array_market_en).'</td>
                            <td>'.str_replace('-', '->', $row->employees_number).'</td>
                            <td>'.$export_m.'</td>
                            <td>'.$is_insurance.'</td>
                            <td>'.$insurance_companies.'</td>
                            <td>'.$banks_com.'</td>
                            <td>'.$fuel.'</td>
                            <td>'.$diesel.'</td>
                            <td>'.$row->rep_person_en.'</td>
                            <td>'.$pos.'</td>
                            <td>'.$row->related_companies.'</td>

                            <td>'.$row->start_date_adv.'</td>
                            <td>'.$row->end_date_adv.'</td>
                            <td>'. $status_adv .'</td>

                            <td>'.$row->clients_status_status.'</td>
                            <td>'.$row->clients_status_start_date.'</td>
                            <td>'.$row->clients_status_end_date.'</td>

                            <td>'.$row->salesman_fullname_en.'</td>
                </tr>';
        }
        echo '</tbody>';
        echo '</table>';
        exit;
    }


    public function fulldataen2() {
        // filename for download
        $filename = "full-data-en.xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');
        // header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        // header('Content-type: text/html; charset=UTF-8');
        $flag = false;

        echo '<style type="text/css">
tr, td, table, tr{
	border:1px solid #D0D0D0;
}
.yellow{
						background:#FF0 !important;
					}
</style>   ';
        $query = $this->Report->GetFullCompanies();

        echo '<table cellpadding="0" cellspacing="0" style="border:1px solid; background:none !important" width="100%" class="table">
                        <thead>
                            <tr>
								<th>Wezara ID</th>
								<th>ID</th>
								<th>Company Name</th>
								<th>Company Owner</th>
								<th>Auth. to sign</th>
								<th>No. & Place of C.R </th>
                               
								<th>Sector EN</th>

								 <th>Activity</th>     
                                 <th> مصدر الترخیص </th>
                                 <th> رقم الترخیص </th>
                                 <th> التاریخ </th>
								 <th> الفئة</th>


								 <th>Company Type</th>
                                <th>Associations of Lebanese Industrialists</th>
								<th>Chambre of Commerce & Industry of </th>
								<th>Industrial Assembly</th>
								<th>Assemblies of Economical, Technical</th>
								<th>Mohafaza</th>
								<th>Kazaa</th>
								<th>City</th>
								<th>Street</th>
								<th>Phone</th>
								<th>WhatsApp</th>
								<th>Fax</th>
								<th>P.O.Box</th>
								<th>Email</th>
								<th>Website</th>
								<th>E Location</th>
								<th>N Location</th>
								<th>Export & Trade Market  </th>
								<th>Number of Labour</th>
								<th>Means of Export</th>
                                <th>Do You Have Insurance</th>
								<th>Insurance Co. Name</th>
								<th>Banks</th>
								<th>Electric Power/year - Fuel / Ton Or Litre</th>
								<th>Electric Power/year - Diesel / Ton Or Litre</th>
								<th>اسم الشخص الذي تمت معه المقابلة في المؤسسة</th>								
								<th>صفته في المؤسسة</th>
								<th>Related ID</th>
                              </tr>
                        </thead>
                        <tbody>';
        foreach($query as $row) {
            // $items = $this->Company->GetProductionInfo($row->id);
            $position = $this->Item->GetPositionById($row->position_id);
            if(count($position) > 0) {
                $pos = $position['label_en'];
            }
            else {
                $pos = '';
            }
            $banks = $this->Company->GetCompanyBanks($row->id);
            $banks_com='';
            if(count($banks)) {
                foreach($banks as $bank) {
                    $banks_com.= $bank->bank_en.'<br>';
                }
            }
            $markets = $this->Company->GetCompanyMarkets($row->id);

            $array_market_ar = array();
            $array_market_en = array();
            if(count($markets)) {
                foreach($markets as $item) {
                    if($item->item_type == 'country') {
                        $row1 = $this->Parameter->GetCountryById($item->market_id);
                        if(isset($row1['label_ar']) && isset($row1['label_en']))
                        {
                            array_push($array_market_ar,$row1['label_ar']);
                            array_push($array_market_en,$row1['label_en']);
                        }
                        
                    }
                    elseif($item->item_type == 'region') {
                        $row1 = $this->Parameter->GetCompanyMarketById($item->market_id);
                        if(isset($row1['label_ar']) && isset($row1['label_en']))
                        {
                            array_push($array_market_ar,$row1['label_ar']);
                            array_push($array_market_en,$row1['label_en']);
                        }
                        //array_push($array_market_ar,$row1['label_ar']);
                        //array_push($array_market_en,$row1['label_en']);
                    }



                }
            }
            $insurances = $this->Company->GetCompanyInsurances($row->id);
            $insurance_companies='';
            if(count($insurances)>0)
            {
                $is_insurance='Yes';
                foreach($insurances as $insurance) {
                    $insurance_companies .= $insurance->insurance_en.'<br>';
                }
            }
            else{
                $is_insurance=' No';
            }
            $powers = $this->Company->GetCompanyElectricPowers($row->id);
            $fuel='';
            $diesel='';
            if(count($powers)) {
                foreach($powers as $power) {
                    $fuel= $power->fuel;
                    $diesel=$power->diesel;
                }
            }

            $industrial_room = $this->Company->GetIndustrialRoomById($row->iro_code);
            if(count($industrial_room) > 0) {
                $industrial_room_en = $industrial_room['label_en'];
                $industrial_room_ar = $industrial_room['label_ar'];
            }
            else {
                $industrial_room_en = '';
                $industrial_room_ar = '';
            }

            $industrial_group = $this->Company->GetIndustrialGroupById($row->igr_code);
            if(count($industrial_group) > 0) {
                $industrial_group_en = $industrial_group['label_en'];
                $industrial_group_ar = $industrial_group['label_ar'];
            }
            else {
                $industrial_group_en = '';
                $industrial_group_ar = '';
            }

            $economical_assembly = $this->Company->GetEconomicalAssemblyById($row->eas_code);
            if(count($economical_assembly) > 0) {
                $economical_assembly_en = $economical_assembly['label_en'];
                $economical_assembly_ar = $economical_assembly['label_ar'];
            }
            else {
                $economical_assembly_en = '';
                $economical_assembly_ar = '';
            }

            $license = $this->Company->GetLicenseSourceById($row->license_source_id);
            if(count(@$license) > 0) {
                $license_en = $license['label_en'];
                $license_ar = $license['label_ar'];
            }
            else {
                $license_en = '';
                $license_ar = '';
            }
            $source1='';
            $source2='';
            $source3='';
            if(@$row->wezara_source == 1)
            {
                $source1='وزارة الصناعة';
            }
            elseif($row->investment==1)
            {
                $source2='رخصة استثمار';
            }
            elseif($row->origin==1)
            {
                $source3='رخصة انشاء';
            }

            $export_m = '';

            if(@$row->is_exporter == 0) {
                $export_m = 'Export Less ';
            }
            elseif(@$query['is_exporter'] == 1) {
                $export_m = 'Direct';
            }
            elseif(@$query['is_exporter'] == 2) {
                $export_m = 'Mediation';
            }

            echo ' <tr>
									<td>'.$row->ministry_id.'</td>
									<td>'.$row->id.'</td>
									<td>'.$row->name_en.'</td>
									<td>'.$row->owner_name_en.'</td>
									<td>'.$row->auth_person_en.'</td>
									<td>'.$row->auth_no.' / '.$license_en.'</td>
                                    
									<td>'.$row->sector_en.'</td>

									<td>'.$row->activity_en.'</td>
									<td>'.$source1.' '.$source2.' '.$source3.'</td>
									<td>'.$row->nbr_source.'</td>
									<td>'.$row->date_source.'</td>
									<td>'.$row->type_source.'</td>
									<td>'.$row->type_en.'</td>
									<td>'.(($row->ind_association==1)? 'Yes' : 'No').'</td>
									<td>'.$industrial_room_en.'</td>
									<td>'.$industrial_group_en.'</td>
									<td>'.$economical_assembly_en.'</td>
									<td>'.$row->governorate_en.'</td>
									<td>'.$row->district_en.'</td>
									<td>'.$row->area_en.'</td>
									<td>'.$row->street_en.'</td>
									<td>'.$row->phone.'</td>
									<td>'.$row->whatsapp.'</td>
									<td>'.$row->fax.'</td>
									<td>'.$row->pobox_en.'</td>
									<td>'.$row->email.'</td>
									<td>'.$row->website.'</td>
									<td>'.$row->x_decimal.'</td>
									<td>'.$row->y_decimal.'</td>
									<td>'.implode(' , ',$array_market_en).'</td>
									<td>'.str_replace('-', '->', $row->employees_number).'</td>
									<td>'.$export_m.'</td>
									<td>'.$is_insurance.'</td>
									<td>'.$insurance_companies.'</td>
									<td>'.$banks_com.'</td>
									<td>'.$fuel.'</td>
									<td>'.$diesel.'</td>
									<td>'.$row->rep_person_en.'</td>
									<td>'.$pos.'</td>
									<td>'.$row->related_companies.'</td>
								</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        exit;
    }
    public function updated_companies_ar() {
        // filename for download
        $filename = "updated-companies-ar.xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');
        $flag = false;

        echo '<style type="text/css">
tr, td, table, tr{
	border:1px solid #D0D0D0;
}
.yellow{
						background:#FF0 !important;
					}
</style>   ';
        $query = $this->Report->GetUpdatedCompanies();

        echo '<table cellpadding="0" cellspacing="0" style="border:1px solid; background:none !important" width="100%" class="table">
                        <thead>
                            <tr>
								<th>وزارة ID</th>
								<th>شركة الدليل الصناعي ID</th>
								<th>اسم المؤسسة</th>
								<th>صاحب / أصحاب الشركة</th>
								<th>اسم المفوض بالتوقيع</th>
								<th>رقم ومحل السجل التجاري</th>							
                                
								 <th>نوع النشاط</th>
                                 <th>مصدر الترخيص</th>
                                 <th>رقم الترخيص</th>
                                 <th>التاريخ</th>
								 <th>الفئة</th>
								 <th>نوع الشركة</th>
                                <th>جمعية الصناعيين اللبنانيين</th>
								<th>غرفة الصناعة والتجارة في </th>
								<th>تجمع صناعي</th>
								<th>نقابات أو اتحادات</th>
								<th>المحافظة</th>
								<th>القضاء</th>
								<th>البلدة أو المحلة</th>
								<th>الشارع</th>
								<th>هاتف</th>
                                <th>واتساپ</th>
								<th>فاكس</th>
								<th>ص. بريد</th>
								<th>البريد الالكتروني</th>
								<th>الموقع الالكتروني</th>
								<th>E Location</th>
								<th>N Location</th>
								<th>اسواق البيع والتصدير  </th>
								<th>عدد العمال</th>
								<th>طريقة التصدير</th>
                                <th>هل المؤسسة مؤمنة</th>
								<th>اسم الشركة</th>
								<th>المصارف المعتمدة</th>
								<th>استعمال الطاقة - فيول / طن او ليتر</th>
								<th>استعمال الطاقة - مازوت / طن أو ليتر</th>
								<th>اسم الشخص الذي تمت معه المقابلة في المؤسسة</th>
								<th>صفته في المؤسسة</th>
                              </tr>
                        </thead>
                        <tbody>';
        foreach($query as $row) {
            // $items = $this->Company->GetProductionInfo($row->id);
            $position = $this->Item->GetPositionById($row->position_id);
            if(count($position) > 0) {
                $pos = $position['label_ar'];
            }
            else {
                $pos = '';
            }
            $banks = $this->Company->GetCompanyBanks($row->id);
            $banks_com='';
            if(count($banks)) {
                foreach($banks as $bank) {
                    $banks_com.= $bank->bank_ar.'<br>';
                }
            }
            $markets = $this->Company->GetCompanyMarkets($row->id);

            $array_market_ar = array();
            $array_market_en = array();
            if(count($markets)) {
                foreach($markets as $item) {
                    if($item->item_type == 'country') {
                        $row1 = $this->Parameter->GetCountryById($item->market_id);
                        array_push($array_market_ar,$row1['label_ar']);
                        array_push($array_market_en,$row1['label_en']);
                    }
                    elseif($item->item_type == 'region') {
                        $row1 = $this->Parameter->GetCompanyMarketById($item->market_id);
                        array_push($array_market_ar,$row1['label_ar']);
                        array_push($array_market_en,$row1['label_en']);
                    }



                }
            }
            $insurances = $this->Company->GetCompanyInsurances($row->id);
            $insurance_companies='';
            if(count($insurances)>0)
            {
                $is_insurance='نعم';
                foreach($insurances as $insurance) {
                    $insurance_companies .= $insurance->insurance_ar.'<br>';
                }
            }
            else{
                $is_insurance=' كلا';
            }
            $powers = $this->Company->GetCompanyElectricPowers($row->id);
            $fuel='';
            $diesel='';
            if(count($powers)) {
                foreach($powers as $power) {
                    $fuel= $power->fuel;
                    $diesel=$power->diesel;
                }
            }

            $industrial_room = $this->Company->GetIndustrialRoomById($row->iro_code);
            if(count($industrial_room) > 0) {
                $industrial_room_en = $industrial_room['label_en'];
                $industrial_room_ar = $industrial_room['label_ar'];
            }
            else {
                $industrial_room_en = '';
                $industrial_room_ar = '';
            }

            $industrial_group = $this->Company->GetIndustrialGroupById($row->igr_code);
            if(count($industrial_group) > 0) {
                $industrial_group_en = $industrial_group['label_en'];
                $industrial_group_ar = $industrial_group['label_ar'];
            }
            else {
                $industrial_group_en = '';
                $industrial_group_ar = '';
            }

            $economical_assembly = $this->Company->GetEconomicalAssemblyById($row->eas_code);
            if(count($economical_assembly) > 0) {
                $economical_assembly_en = $economical_assembly['label_en'];
                $economical_assembly_ar = $economical_assembly['label_ar'];
            }
            else {
                $economical_assembly_en = '';
                $economical_assembly_ar = '';
            }

            $license = $this->Company->GetLicenseSourceById($row->license_source_id);
            if(count(@$license) > 0) {
                $license_en = $license['label_en'];
                $license_ar = $license['label_ar'];
            }
            else {
                $license_en = '';
                $license_ar = '';
            }
            $source1='';
            $source2='';
            $source3='';
            if(@$row->wezara_source == 1)
            {
                $source1='وزارة الصناعة';
            }
            elseif($row->investment==1)
            {
                $source2='رخصة استثمار';
            }
            elseif($row->origin==1)
            {
                $source3='رخصة انشاء';
            }

            $export_m = '';

            if(@$row->is_exporter == 0) {
                $export_m = 'غير مصدر';
            }
            elseif(@$query['is_exporter'] == 1) {
                $export_m = 'مباشر';
            }
            elseif(@$query['is_exporter'] == 2) {
                $export_m = 'بالواسطة';
            }

            echo ' <tr>
									<td>'.$row->ministry_id.'</td>
									<td>'.$row->id.'</td>
									<td>'.$row->name_ar.'</td>
									<td>'.$row->owner_name.'</td>
									<td>'.$row->auth_person_ar.'</td>
									<td>'.$row->auth_no.' / '.$license_ar.'</td>									

									<td>'.$row->activity_ar.'</td>
									<td>'.$source1.' '.$source2.' '.$source3.'</td>
									<td>'.$row->nbr_source.'</td>
									<td>'.$row->date_source.'</td>
									<td>'.$row->type_source.'</td>
									<td>'.$row->type_ar.'</td>
									<td>'.(($row->ind_association==1)? 'نعم' : 'كلا').'</td>
									<td>'.$industrial_room_ar.'</td>
									<td>'.$industrial_group_ar.'</td>
									<td>'.$economical_assembly_ar.'</td>
									<td>'.$row->governorate_ar.'</td>
									<td>'.$row->district_ar.'</td>
									<td>'.$row->area_ar.'</td>
									<td>'.$row->street_ar.'</td>
									<td>'.$row->phone.'</td>
									<td>'.$row->whatsapp.'</td>
									<td>'.$row->fax.'</td>
									<td>'.$row->pobox_ar.'</td>
									<td>'.$row->email.'</td>
									<td>'.$row->website.'</td>
									<td>'.$row->x_decimal.'</td>
									<td>'.$row->y_decimal.'</td>
									<td>'.implode(' , ',$array_market_ar).'</td>
									<td>'.str_replace('-', '->', $row->employees_number).'</td>
									<td>'.$export_m.'</td>
									<td>'.$is_insurance.'</td>
									<td>'.$insurance_companies.'</td>
									<td>'.$banks_com.'</td>
									<td>'.$fuel.'</td>
									<td>'.$diesel.'</td>
									<td>'.$row->rep_person_ar.'</td>
									<td>'.$pos.'</td>
								</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        exit;
    }
    public function updated_companies_en() {
        // filename for download
        $filename = "updated-companies-en.xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');
        $flag = false;

        echo '<style type="text/css">
tr, td, table, tr{
	border:1px solid #D0D0D0;
}
.yellow{
						background:#FF0 !important;
					}
</style>   ';
        $query = $this->Report->GetUpdatedCompanies();

        echo '<table cellpadding="0" cellspacing="0" style="border:1px solid; background:none !important" width="100%" class="table">
                        <thead>
                            <tr>
								<th>Wezara ID</th>
								<th>ID</th>
								<th>Company Name</th>
								<th>Company Owner</th>
								<th>Auth. to sign</th>
								<th>No. & Place of C.R </th>
								 <th>Activity</th>
                                 <th>مصدر الترخيص</th>
                                 <th>رقم الترخيص</th>
                                 <th>التاريخ</th>
								 <th>الفئة</th>
								 <th>Company Type</th>
                                <th>Associations of Lebanese Industrialists</th>
								<th>Chambre of Commerce & Industry of </th>
								<th>Industrial Assembly</th>
								<th>Assemblies of Economical, Technical</th>
								<th>Mohafaza</th>
								<th>Kazaa</th>
								<th>City</th>
								<th>Street</th>
								<th>Phone</th>
								<th>WhatsApp</th>
								<th>Fax</th>
								<th>P.O.Box</th>
								<th>Email</th>
								<th>Website</th>
								<th>E Location</th>
								<th>N Location</th>
								<th>Export & Trade Market  </th>
								<th>Number of Labour</th>
								<th>Means of Export</th>
                                <th>Do You Have Insurance</th>
								<th>Insurance Co. Name</th>
								<th>Banks</th>
								<th>Electric Power/year - Fuel / Ton Or Litre</th>
								<th>Electric Power/year - Diesel / Ton Or Litre</th>
								<th>اسم الشخص الذي تمت معه المقابلة في المؤسسة</th>
								<th>صفته في المؤسسة</th>
                              </tr>
                        </thead>
                        <tbody>';
        foreach($query as $row) {
            // $items = $this->Company->GetProductionInfo($row->id);
            $position = $this->Item->GetPositionById($row->position_id);
            if(count($position) > 0) {
                $pos = $position['label_en'];
            }
            else {
                $pos = '';
            }
            $banks = $this->Company->GetCompanyBanks($row->id);
            $banks_com='';
            if(count($banks)) {
                foreach($banks as $bank) {
                    $banks_com.= $bank->bank_en.'<br>';
                }
            }
            $markets = $this->Company->GetCompanyMarkets($row->id);

            $array_market_ar = array();
            $array_market_en = array();
            if(count($markets)) {
                foreach($markets as $item) {
                    if($item->item_type == 'country') {
                        $row1 = $this->Parameter->GetCountryById($item->market_id);
                        array_push($array_market_ar,$row1['label_ar']);
                        array_push($array_market_en,$row1['label_en']);
                    }
                    elseif($item->item_type == 'region') {
                        $row1 = $this->Parameter->GetCompanyMarketById($item->market_id);
                        array_push($array_market_ar,$row1['label_ar']);
                        array_push($array_market_en,$row1['label_en']);
                    }



                }
            }
            $insurances = $this->Company->GetCompanyInsurances($row->id);
            $insurance_companies='';
            if(count($insurances)>0)
            {
                $is_insurance='Yes';
                foreach($insurances as $insurance) {
                    $insurance_companies .= $insurance->insurance_en.'<br>';
                }
            }
            else{
                $is_insurance=' No';
            }
            $powers = $this->Company->GetCompanyElectricPowers($row->id);
            $fuel='';
            $diesel='';
            if(count($powers)) {
                foreach($powers as $power) {
                    $fuel= $power->fuel;
                    $diesel=$power->diesel;
                }
            }

            $industrial_room = $this->Company->GetIndustrialRoomById($row->iro_code);
            if(count($industrial_room) > 0) {
                $industrial_room_en = $industrial_room['label_en'];
                $industrial_room_ar = $industrial_room['label_ar'];
            }
            else {
                $industrial_room_en = '';
                $industrial_room_ar = '';
            }

            $industrial_group = $this->Company->GetIndustrialGroupById($row->igr_code);
            if(count($industrial_group) > 0) {
                $industrial_group_en = $industrial_group['label_en'];
                $industrial_group_ar = $industrial_group['label_ar'];
            }
            else {
                $industrial_group_en = '';
                $industrial_group_ar = '';
            }

            $economical_assembly = $this->Company->GetEconomicalAssemblyById($row->eas_code);
            if(count($economical_assembly) > 0) {
                $economical_assembly_en = $economical_assembly['label_en'];
                $economical_assembly_ar = $economical_assembly['label_ar'];
            }
            else {
                $economical_assembly_en = '';
                $economical_assembly_ar = '';
            }

            $license = $this->Company->GetLicenseSourceById($row->license_source_id);
            if(count(@$license) > 0) {
                $license_en = $license['label_en'];
                $license_ar = $license['label_ar'];
            }
            else {
                $license_en = '';
                $license_ar = '';
            }
            $source1='';
            $source2='';
            $source3='';
            if(@$row->wezara_source == 1)
            {
                $source1='وزارة الصناعة';
            }
            elseif($row->investment==1)
            {
                $source2='رخصة استثمار';
            }
            elseif($row->origin==1)
            {
                $source3='رخصة انشاء';
            }

            $export_m = '';

            if(@$row->is_exporter == 0) {
                $export_m = 'Export Less ';
            }
            elseif(@$query['is_exporter'] == 1) {
                $export_m = 'Direct';
            }
            elseif(@$query['is_exporter'] == 2) {
                $export_m = 'Mediation';
            }

            echo ' <tr>
									<td>'.$row->ministry_id.'</td>
									<td>'.$row->id.'</td>
									<td>'.$row->name_en.'</td>
									<td>'.$row->owner_name_en.'</td>
									<td>'.$row->auth_person_en.'</td>
									<td>'.$row->auth_no.' / '.$license_en.'</td>
									<td>'.$row->activity_en.'</td>
									<td>'.$source1.' '.$source2.' '.$source3.'</td>
									<td>'.$row->nbr_source.'</td>
									<td>'.$row->date_source.'</td>
									<td>'.$row->type_source.'</td>
									<td>'.$row->type_en.'</td>
									<td>'.(($row->ind_association==1)? 'Yes' : 'No').'</td>
									<td>'.$industrial_room_en.'</td>
									<td>'.$industrial_group_en.'</td>
									<td>'.$economical_assembly_en.'</td>
									<td>'.$row->governorate_en.'</td>
									<td>'.$row->district_en.'</td>
									<td>'.$row->area_en.'</td>
									<td>'.$row->street_en.'</td>
									<td>'.$row->phone.'</td>
									<td>'.$row->whatsapp.'</td>
									<td>'.$row->fax.'</td>
									<td>'.$row->pobox_en.'</td>
									<td>'.$row->email.'</td>
									<td>'.$row->website.'</td>
									<td>'.$row->x_decimal.'</td>
									<td>'.$row->y_decimal.'</td>
									<td>'.implode(' , ',$array_market_en).'</td>
									<td>'.str_replace('-', '->', $row->employees_number).'</td>
									<td>'.$export_m.'</td>
									<td>'.$is_insurance.'</td>
									<td>'.$insurance_companies.'</td>
									<td>'.$banks_com.'</td>
									<td>'.$fuel.'</td>
									<td>'.$diesel.'</td>
									<td>'.$row->rep_person_en.'</td>
									<td>'.$pos.'</td>
								</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        exit;
    }
    public function company_insurance($lang = 'ar') {

        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Reports');
        $this->breadcrumb->add_crumb('Company - Insurance');
        if(isset($_GET['search'])) {
            $lang = $this->input->get('lang');
            $insurance = $this->input->get('insurance');
            $this->data['insurances'] = $this->Report->SearchInsurancesByName($insurance, $lang);
        }
        else {
            $this->data['insurances'] = array();
        }

        if($lang == 'en') {
            $this->data['title'] = $this->data['Ctitle']." -  The Company";
            $this->data['subtitle'] = "Company - Banks";
        }
        else {
            $this->data['title'] = $this->data['Ctitle']."الشركات الصناعية - ";
            $this->data['subtitle'] = "الشركات الصناعية ";
        }
        $this->data['insurance'] = @$insurance;
        $this->template->load('_template', 'reports/companies_insurance_'.$lang, $this->data);
    }

    function export_cinsurance() {
        $insurance = $this->input->get('insurance');
        $lang = $this->input->get('lang');
        // filename for download
        $filename = "cinsurance-".$lang.".xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');
        $flag = false;

        echo '<style type="text/css">
tr, td, table, tr{
	border:1px solid #D0D0D0;
}
.yellow{
						background:#FF0 !important;
					}
</style>   ';
        $insurances = $this->Report->SearchInsurancesByName($insurance, $lang);
        //var_dump($banks);
        //die;
        echo '<table cellpadding="0" cellspacing="0" style="border:1px solid; background:none !important" width="100%" class="table">
                        <thead>
                            <tr>';
        if($lang == 'en') {
            echo '<th>Company</th>
								 <th>Owner</th>
                                 <th>Kazaa</th>
                                 <th>City</th>
                                 <th>Street</th>
								 <th>Phone</th>
								 <th>WhatsApp</th>
								 <th>Fax</th>
                                 <th>P.O.BOX</th>
                                <th>Email</th>
                              ';
        }
        else {
            echo '<th>البريد اللكتروني</th>
                                <th>ص.ب</th>
                                 <th>فاكس</th>
                               	 <th>هاتف</th>
                                 <th>واتساپ</th>
                                <th>الشارع</th>
                                <th>المدينة</th>
                                <th>قضاء</th>
								<th>صاحب الشركة</th>
                                <th>الشركة</th>';
        }
        echo '</tr>
                        </thead>
                        <tbody>';
        foreach($insurances as $item) {
            $query = $this->Report->GetCompanyByInsuranceId($item->id, $lang);
            if(count($query) > 0) {
                if($lang == 'en') {
                    echo '<tr>
                            	<td colspan="9" align="center" style="text-align:center !important; font-size:18px !important; font-weight:bold !important">'.$item->name_en.'</td>
                            </tr>';
                }
                else {
                    echo '<tr>
                            	<td colspan="9" align="center" style="text-align:center !important; font-size:18px !important; font-weight:bold !important" dir="rtl">'.$item->name_ar.'</td>
                            </tr>';
                }
                foreach($query as $row) {
                    if($lang == 'en') {
                        echo ' <tr>
                                            <td>'.$row->name_en.'</td>
											<td>'.$row->owner_name_en.'</td>
                                            <td>'.$row->district_en.'</td>
                                            <td>'.$row->area_en.'</td>
                                            <td>'.$row->street_en.'</td>
											<td>'.$row->phone.'</td>
											<td>'.$row->whatsapp.'</td>
                                            <td>'.$row->fax.'</td>
                                            <td>'.$row->pobox_en.'</td>
                                            <td>'.$row->email.'</td>

                                        </tr>';
                    }
                    else {
                        echo '<tr>
                                <td style="text-align:right">'.$row->email.'</td>
                                <td style="direction:rtl !important; text-align:right !important">'.$row->pobox_ar.'</td>
                              	<td style="text-align:right">'.$row->fax.'</td>
                                <td style="text-align:right">'.$row->phone.'</td>
                                <td style="text-align:right">'.$row->whatsapp.'</td>
                                <td style="direction:rtl !important; text-align:right !important">'.$row->street_ar.'</td>
                                <td style="text-align:right">'.$row->area_ar.'</td>
                                <td style="text-align:right">'.$row->district_ar.'</td>
								<td style="text-align:right">'.$row->owner_name.'</td>
                                <td style="direction:rtl !important; text-align:right !important">'.$row->name_ar.'</td>
                            </tr>';
                    }
                }
            }
        }
        echo '</tbody>';

        echo '</table>';

        //return $filename;
        exit;
    }

    public function company_banks($lang = 'ar') {

        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Reports');
        $this->breadcrumb->add_crumb('Company - Banks');
        $secter = 0;
        if(isset($_GET['search'])) {
            $lang = $this->input->get('lang');
            $bank = $this->input->get('bank');
            $this->data['banks'] = $this->Report->SearchBanksByName($bank, $lang);
        }
        else {
            $this->data['banks'] = array();
        }

        if($lang == 'en') {
            $this->data['title'] = $this->data['Ctitle']." -  The Company";
            $this->data['subtitle'] = "Company - Banks";
        }
        else {
            $this->data['title'] = $this->data['Ctitle']."الشركات الصناعية - ";
            $this->data['subtitle'] = "الشركات الصناعية ";
        }
        $this->data['bank'] = @$bank;
        $this->template->load('_template', 'reports/companies_banks_'.$lang, $this->data);
    }

    function export_cbanks() {
        $bank = $this->input->get('bank');
        $lang = $this->input->get('lang');
        // filename for download
        $filename = "cbank-".$lang.".xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');
        $flag = false;

        echo '<style type="text/css">
tr, td, table, tr{
	border:1px solid #D0D0D0;
}
.yellow{
						background:#FF0 !important;
					}
</style>   ';
        $banks = $this->Report->SearchBanksByName($bank, $lang);
        //var_dump($banks);
        //die;
        echo '<table cellpadding="0" cellspacing="0" style="border:1px solid; background:none !important" width="100%" class="table">
                        <thead>
                            <tr>';
        if($lang == 'en') {
            echo '<th>Company</th>
								 <th>Owner</th>
                                 <th>Kazaa</th>
                                 <th>City</th>
                                 <th>Street</th>
								 <th>Phone</th>
								 <th>WhatsApp</th>
								 <th>Fax</th>
                                 <th>P.O.BOX</th>
                                <th>Email</th>
                              ';
        }
        else {
            echo '<th>البريد اللكتروني</th>
                                <th>ص.ب</th>
                                 <th>فاكس</th>
                               	 <th>هاتف</th>
                                 <th>واتساپ</th>
                                <th>الشارع</th>
                                <th>المدينة</th>
                                <th>قضاء</th>
								<th>صاحب الشركة</th>
                                <th>الشركة</th>';
        }
        echo '</tr>
                        </thead>
                        <tbody>';
        foreach($banks as $item) {
            $query = $this->Report->GetCompanyByBankId($item->id, $lang);
            if(count($query) > 0) {
                if($lang == 'en') {
                    echo '<tr>
                            	<td colspan="9" align="center" style="text-align:center !important; font-size:18px !important; font-weight:bold !important">'.$item->name_en.'</td>
                            </tr>';
                }
                else {
                    echo '<tr>
                            	<td colspan="9" align="center" style="text-align:center !important; font-size:18px !important; font-weight:bold !important" dir="rtl">'.$item->name_ar.'</td>
                            </tr>';
                }
                foreach($query as $row) {
                    if($lang == 'en') {
                        echo ' <tr>
                                            <td>'.$row->name_en.'</td>
											<td>'.$row->owner_name_en.'</td>
                                            <td>'.$row->district_en.'</td>
                                            <td>'.$row->area_en.'</td>
                                            <td>'.$row->street_en.'</td>
											<td>'.$row->phone.'</td>
											<td>'.$row->whatsapp.'</td>
                                            <td>'.$row->fax.'</td>
                                            <td>'.$row->pobox_en.'</td>
                                            <td>'.$row->email.'</td>

                                        </tr>';
                    }
                    else {
                        echo '<tr>
                                <td style="text-align:right">'.$row->email.'</td>
                                <td style="direction:rtl !important; text-align:right !important">'.$row->pobox_ar.'</td>
                              	<td style="text-align:right">'.$row->fax.'</td>
                                <td style="text-align:right">'.$row->phone.'</td>
                                <td style="text-align:right">'.$row->whatsapp.'</td>
                                <td style="direction:rtl !important; text-align:right !important">'.$row->street_ar.'</td>
                                <td style="text-align:right">'.$row->area_ar.'</td>
                                <td style="text-align:right">'.$row->district_ar.'</td>
								<td style="text-align:right">'.$row->owner_name.'</td>
                                <td style="direction:rtl !important; text-align:right !important">'.$row->name_ar.'</td>
                            </tr>';
                    }
                }
            }
        }
        echo '</tbody>';

        echo '</table>';

        //return $filename;
        exit;
    }

    public function company($lang = 'ar') {

        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Reports');
        $this->breadcrumb->add_crumb('Compnay');
        $secter = 0;
        if(isset($_GET['search'])) {
            $lang = $this->input->get('lang');
            $sector = $this->input->get('sector');
        }

        //$this->data['query']=$this->Report->GetCompany($lang);
        if($lang == 'en') {
            $this->data['title'] = $this->data['Ctitle']." -  The Company";
            $this->data['subtitle'] = "The Company ";
        }
        else {
            $this->data['title'] = $this->data['Ctitle']."الشركات الصناعية - ";
            $this->data['subtitle'] = "الشركات الصناعية ";
        }


        $this->data['sectors'] = $this->Item->GetSector('online', 0, 0);
        $this->data['sector_id'] = @$sector;
        $this->template->load('_template', 'reports/companies_'.$lang, $this->data);
    }

    function ExportCompaniesAr($sectorID = '') {
        // filename for download
        $filename = "companies-ar.xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');
        $flag = false;
        echo '<style type="text/css">
				.table tr td {
					border:1px solid #000;
				}
				.yellow{
				        font-weight: bold;
					}
				.table tr th{
					border:1px solid #FFF;
					background: #000;
					color: #FFF;
					font-weight: bold;
				}
				.htitle{
				border:1px solid #FFF !important;
				height:5px !important;
					}
				</style>   ';
      
                        $x=TRUE;
                        echo '<body style="width:1080;font-family: Arial;"><table style="width:1080px !important; border:1px solid #000;" cellpadding="0" cellspacing="0" width="1080" class="table">';
        if($sectorID != '') {
            $sectors = $this->Item->GetSectorById($sectorID);

            $sections = $this->Item->GetSectionsBySectorId('', $sectors['id']);
            echo '<tr><td colspan="7" align="center" style="border:none !important;"><center><h3 style="margin:5px; font-size:29px !important">'.$sectors['label_ar'].'</h3></center></td></tr>';
            foreach($sections as $section) {
                
                echo '<tr><td class="htitle" colspan="7" align="center" style="font-weight:bold"></td></tr>
                <tr><td style="background:#A6A6A6; font-weight:bold;  font-size:21px !important; border:none !important;" colspan="7" align="center"><center>القسم '.$section->scn_nbr.' : '.$section->label_ar.'</center></td></tr>
                ';
                $chapters = $this->Item->GetChaptersBySectionId('', $section->id);
                foreach($chapters as $chapter) {

                    $items = $this->Item->GetSubHeadingByChapterId('', $chapter->id);
                    if(count($items) > 0) {
                        echo '<tr><td colspan="7"  class="htitle" align="center" style="font-weight:bold"></td></tr>
                        <tr><td colspan="7" align="center" style="background:#BFBFBF; font-weight:bold; font-size:19px !important; text-align:center !important; border:none !important;"><center>الفصل '.$chapter->cha_nbr.' : '.$chapter->label_ar.'</center></td></tr>
											';
                        foreach($items as $item) {
                            $companies = $this->Report->GetCompaniesSubHeading($item->id, 'ar');
                            if(count($companies) > 0) {
                                echo '<tr><td colspan="7"  class="htitle" align="center" style="font-weight:bold"></td></tr>
                                <tr>
                            	<td colspan="7" align="center" style="background:#D9D9D9;  font-size:16px !important; font-weight:bold !important; text-align:center !important; border:none !important;" ><center>البند الجمركي  : '.$item->hs_code.' '.$item->description_ar.'</center></td></tr>
								<tr><td colspan="7"  class="htitle" align="center" style="font-weight:bold"></td></tr>	';
                                foreach($companies as $row) {
                                     if($row->is_adv == 1)
                                        $css_ex = 'font-weight:bold; font-size:14px !important';
                                    elseif($row->copy_res == 1)
                                        $css_ex = 'font-weight:bold; font-size:13px !important';
                                    else
                                        $css_ex = 'font-size:12px !important';

                                   
                                      if($x)
                                      {
                                           
                                               echo'
                                                    <tr>
                                                        <th>البريد الكتروني</th>
                                                        <th>فاكس</th>
                                                       <th>هاتف</th>
                                                       <th>واتساپ</th>
                                                        <th>الشارع</th>
                                                        <th>المدينة</th>
                                                        <th>قضاء</th>
                                                        <th style="width: 250px !important;">الشركة</th>
                                                    </tr>
                                                '; 
                                                $x=FALSE;
                                      }
                                    echo '<tr>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->email.'</td>
                                          	<td style="text-align:center; '.$css_ex.'">'.$row->fax.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->phone.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->whatsapp.'</td>
                                            <td style="direction:rtl !important; text-align:center !important; '.$css_ex.'">'.$row->street_ar.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->area_ar.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->district_ar.'</td>
                                            <td style="direction:rtl !important; text-align:center !important; '.$css_ex.'">'.$row->name_ar.'</td>
                                        </tr>';
                                }
                            }
                        }
                    }
                }
            }
        }
        else {
            $sectors = $this->Item->GetSector('online', 0, 0);

            foreach($sectors as $sector) {
                $sections = $this->Item->GetSectionsBySectorId('', $sector->id);
                echo '<tr><td colspan="8" align="center"><center><h3>'.$sector->label_ar.'</h3></center></td></tr>';
                foreach($sections as $section) {
                    echo '<tr><td colspan="8" align="center" style="font-weight:bold"><center>القسم '.$section->scn_nbr.' : '.$section->label_ar.'</center></td></tr>
								 <tr><td colspan="8" align="center" style="font-weight:bold"></td></tr>';
                    $chapters = $this->Item->GetChaptersBySectionId('', $section->id);
                    foreach($chapters as $chapter) {

                        $items = $this->Item->GetSubHeadingByChapterId('', $chapter->id);
                        if(count($items) > 0) {
                            echo '<tr><td colspan="8" align="center" style="font-weight:bold"><center>الفصل '.$chapter->cha_nbr.' : '.$chapter->label_ar.'</center></td></tr>
										<tr><td colspan="8" align="center" style="font-weight:bold"></td></tr>	';
                            foreach($items as $item) {
                                $companies = $this->Report->GetCompaniesSubHeading($item->id, 'ar');
                                if(count($companies) > 0) {
                                    echo '<tr>
                            	<td colspan="8" align="center" style=" font-weight:bold !important;  text-align:center !important"><center>البند الجمركي  : '.$item->hs_code.' '.$item->description_ar.'</center></td></tr>
								<tr><td colspan="8" align="center" style="font-weight:bold"></td></tr>
								';
                                    foreach($companies as $row) {
                                        if($row->copy_res == 1)
                                            $css_ex = 'font-weight:bold';
                                        else
                                            $css_ex = '';
                                        if($row->is_adv == 1)
                                            $css = 'yellow';
                                        else
                                            $css = '';
                                        echo '<tr class="'.$css.'">
                                            <td style="text-align:right; '.$css_ex.'">'.$row->email.'</td>
                                          	<td style="text-align:right; '.$css_ex.'">'.$row->fax.'</td>
                                            <td style="text-align:right; '.$css_ex.'">'.$row->phone.'</td>
                                            <td style="text-align:right; '.$css_ex.'">'.$row->whatsapp.'</td>
                                            <td style="direction:rtl !important; text-align:right !important; '.$css_ex.'">'.$row->street_ar.'</td>
                                            <td class="'.$css.'" style="text-align:right; '.$css_ex.'">'.$row->area_ar.'</td>
                                            <td class="'.$css.'" style="text-align:right; '.$css_ex.'">'.$row->district_ar.'</td>
                                            <td class="'.$css.'" style="direction:rtl !important; text-align:right !important; '.$css_ex.'">'.$row->name_ar.'</td>
                                        </tr>';
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
       // echo '</tbody>';

        echo '</table></body>';

        //return $filename;
        exit;
    }
function ExportCompaniesEn($sectorID = '') {
        // filename for download
        $filename = "companies-en.xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');
        $flag = false;
        echo '<style type="text/css">
				.table tr td {
					border:1px solid #000;
				}
				.yellow{
				        font-weight: bold;
					}
				.table tr th{
					border:1px solid #FFF;
					background: #000;
					color: #FFF;
					font-weight: bold;
				}
				.htitle{
				border:1px solid #FFF !important;
				height:5px !important;
					}
				</style>   ';
      
                        $x=TRUE;
                        echo '<body style="width:1080;font-family: Arial;"><table style="width:1080px !important; border:1px solid #000;" cellpadding="0" cellspacing="0" width="1080" class="table">';
        if($sectorID != '') {
            $sectors = $this->Item->GetSectorById($sectorID);

            $sections = $this->Item->GetSectionsBySectorId('', $sectors['id']);
            echo '<tr><td colspan="7" align="center" style="border:none !important;"><center><h3 style="margin:5px; font-size:29px !important">'.$sectors['label_en'].'</h3></center></td></tr>';
            foreach($sections as $section) {
                
                echo '<tr><td class="htitle" colspan="7" align="center" style="font-weight:bold"></td></tr>
                <tr><td style="background:#A6A6A6; font-weight:bold;  font-size:21px !important; border:none !important;" colspan="7" align="center"><center>Section '.$section->scn_nbr.' : '.$section->label_en.'</center></td></tr>
                ';
                $chapters = $this->Item->GetChaptersBySectionId('', $section->id);
                foreach($chapters as $chapter) {

                    $items = $this->Item->GetSubHeadingByChapterId('', $chapter->id);
                    if(count($items) > 0) {
                        echo '<tr><td colspan="7"  class="htitle" align="center" style="font-weight:bold"></td></tr>
                        <tr><td colspan="7" align="center" style="background:#BFBFBF; font-weight:bold; font-size:19px !important; text-align:center !important; border:none !important;"><center>Chapter '.$chapter->cha_nbr.' : '.$chapter->label_en.'</center></td></tr>
											';
                        foreach($items as $item) {
                            $companies = $this->Report->GetCompaniesSubHeading($item->id, 'en');
                            if(count($companies) > 0) {
                                echo '<tr><td colspan="7"  class="htitle" align="center" style="font-weight:bold"></td></tr>
                                <tr>
                            	<td colspan="7" align="center" style="background:#D9D9D9;  font-size:16px !important; font-weight:bold !important; text-align:center !important; border:none !important;" ><center>H.S. Code  : '.$item->hs_code.' '.$item->description_en.'</center></td></tr>
								<tr><td colspan="7"  class="htitle" align="center" style="font-weight:bold"></td></tr>	';
                                foreach($companies as $row) {
                                     if($row->is_adv == 1)
                                        $css_ex = 'font-weight:bold; font-size:14px !important';
                                    elseif($row->copy_res == 1)
                                        $css_ex = 'font-weight:bold; font-size:13px !important';
                                    else
                                        $css_ex = 'font-size:12px !important';

                                   
                                      if($x)
                                      {
                                           
                                               echo'
                                                    <tr>
                                                      	<th>Company</th>
                        								<th>Kazaa</th>
                        								<th>City</th>
                        								<th>Street</th>
                        								<th>Phone</th>
                        								<th>WhatsApp</th>
                        								<th>Fax</th>
                                                        <th>Email</th>
                                                    </tr>
                                                '; 
                                                $x=FALSE;
                                      }
                                    echo '<tr>
                                            <td style="direction:rtl !important; text-align:center !important; '.$css_ex.'">'.$row->name_en.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->district_en.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->area_en.'</td>
                                            <td style="direction:rtl !important; text-align:center !important; '.$css_ex.'">'.$row->street_en.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->phone.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->whatsapp.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->fax.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->email.'</td>
                                        </tr>';
                                }
                            }
                        }
                    }
                }
            }
        }
        else {
            $sectors = $this->Item->GetSector('online', 0, 0);

            foreach($sectors as $sector) {
                $sections = $this->Item->GetSectionsBySectorId('', $sector->id);
                echo '<tr><td colspan="8" align="center"><center><h3>'.$sector->label_ar.'</h3></center></td></tr>';
                foreach($sections as $section) {
                    echo '<tr><td colspan="8" align="center" style="font-weight:bold"><center>القسم '.$section->scn_nbr.' : '.$section->label_ar.'</center></td></tr>
								 <tr><td colspan="8" align="center" style="font-weight:bold"></td></tr>';
                    $chapters = $this->Item->GetChaptersBySectionId('', $section->id);
                    foreach($chapters as $chapter) {

                        $items = $this->Item->GetSubHeadingByChapterId('', $chapter->id);
                        if(count($items) > 0) {
                            echo '<tr><td colspan="8" align="center" style="font-weight:bold"><center>الفصل '.$chapter->cha_nbr.' : '.$chapter->label_ar.'</center></td></tr>
										<tr><td colspan="8" align="center" style="font-weight:bold"></td></tr>	';
                            foreach($items as $item) {
                                $companies = $this->Report->GetCompaniesSubHeading($item->id, 'ar');
                                if(count($companies) > 0) {
                                    echo '<tr>
                            	<td colspan="8" align="center" style=" font-weight:bold !important;  text-align:center !important"><center>البند الجمركي  : '.$item->hs_code.' '.$item->description_ar.'</center></td></tr>
								<tr><td colspan="8" align="center" style="font-weight:bold"></td></tr>
								';
                                    foreach($companies as $row) {
                                        if($row->copy_res == 1)
                                            $css_ex = 'font-weight:bold';
                                        else
                                            $css_ex = '';
                                        if($row->is_adv == 1)
                                            $css = 'yellow';
                                        else
                                            $css = '';
                                        echo '<tr class="'.$css.'">
                                            <td style="text-align:right; '.$css_ex.'">'.$row->email.'</td>
                                          	<td style="text-align:right; '.$css_ex.'">'.$row->fax.'</td>
                                            <td style="text-align:right; '.$css_ex.'">'.$row->phone.'</td>
                                            <td style="text-align:right; '.$css_ex.'">'.$row->whatsapp.'</td>
                                            <td style="direction:rtl !important; text-align:right !important; '.$css_ex.'">'.$row->street_ar.'</td>
                                            <td class="'.$css.'" style="text-align:right; '.$css_ex.'">'.$row->area_ar.'</td>
                                            <td class="'.$css.'" style="text-align:right; '.$css_ex.'">'.$row->district_ar.'</td>
                                            <td class="'.$css.'" style="direction:rtl !important; text-align:right !important; '.$css_ex.'">'.$row->name_ar.'</td>
                                        </tr>';
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
       // echo '</tbody>';

        echo '</table></body>';

        //return $filename;
        exit;
    }

    function ExportCompaniesEn1($sectorID = '') {
        // filename for download
        $filename = "companies-en.xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');
        $flag = false;

         echo '<style type="text/css">
				.table tr td {
					border:1px solid #000;
				}
				.yellow{
				        font-weight: bold;
					}
				.table tr th{
					border:1px solid #FFF;
					background: #000;
					color: #FFF;
					font-weight: bold;
				}
				.htitle{
				border:1px solid #FFF !important;
				height:5px !important;
					}
				</style>   ';
      
        echo '<table cellpadding="0" cellspacing="0" style="border:1px solid; background:none !important" width="100%" class="table">
                        <thead>
                            <tr>
								<th>Company</th>
								<th>Kazaa</th>
								<th>City</th>
								<th>Street</th>
								<th>Phone</th>
								<th>WhatsApp</th>
								<th>Fax</th>
								<th>P.O.BOX</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>';
        if($sectorID != '') {
            $sectors = $this->Item->GetSectorById($sectorID);

            $sections = $this->Item->GetSectionsBySectorId('', $sectors['id']);
            echo '<tr><td colspan="8" align="center"><center><h3>'.$sectors['label_en'].'</h3></center></td></tr>';
            foreach($sections as $section) {
                echo '<tr><td colspan="8" align="center" style="font-weight:bold"><center>Section '.$section->scn_nbr.' : '.$section->label_en.'</center></td></tr>
								 <tr><td colspan="8" align="center" style="font-weight:bold"></td></tr>	';
                $chapters = $this->Item->GetChaptersBySectionId('', $section->id);
                foreach($chapters as $chapter) {

                    $items = $this->Item->GetSubHeadingByChapterId('', $chapter->id);
                    if(count($items) > 0) {
                        echo '<tr><td colspan="8" align="center" style="font-weight:bold"><center>Chapter '.$chapter->cha_nbr.' : '.$chapter->label_en.'</center></td></tr>
										<tr><td colspan="8" align="center" style="font-weight:bold"></td></tr>	';
                        foreach($items as $item) {
                            $companies = $this->Report->GetCompaniesSubHeading($item->id, 'ar');
                            if(count($companies) > 0) {
                                echo '<tr><td colspan="8" style=" font-weight:bold !important;  text-align:center !important"><center> H.S Code  : '.$item->hs_code.' '.$item->description_en.'</center></td></tr>
											<tr><td colspan="8" align="center" style="font-weight:bold"></td></tr>
											';
                                foreach($companies as $row) {
                                    if($row->copy_res == 1)
                                        $css_ex = 'font-weight:bold';
                                    else
                                        $css_ex = '';
                                    if($row->is_adv == 1)
                                        $css = 'yellow';
                                    else
                                        $css = '';
                                    echo '<tr class="'.$css.'">
											<td class="'.$css.'"  style="'.$css_ex.'">'.$row->name_en.'</td>
											<td class="'.$css.'" style="'.$css_ex.'">'.$row->district_en.'</td>
											<td class="'.$css.'" style="'.$css_ex.'">'.$row->area_en.'</td>
											<td class="'.$css.'" style="'.$css_ex.'">'.$row->street_en.'</td>
											<td class="'.$css.'" style="'.$css_ex.'">'.$row->phone.'</td>
											<td class="'.$css.'" style="'.$css_ex.'">'.$row->whatsapp.'</td>
											<td class="'.$css.'" style="'.$css_ex.'">'.$row->fax.'</td>
											<td class="'.$css.'" style="'.$css_ex.'">'.$row->pobox_en.'</td>
	                                        <td class="'.$css.'" style="'.$css_ex.'">'.$row->email.'</td>
                                        </tr>';
                                }
                            }
                        }
                    }
                }
            }
        }
        else {
            $sectors = $this->Item->GetSector('online', 0, 0);
            foreach($sectors as $sector) {
                $sections = $this->Item->GetSectionsBySectorId('', $sector->id);
                echo '<tr><td colspan="8" align="center"><center><h3>'.$sector->label_en.'</h3></center></td></tr>
							<tr><td colspan="8" align="center" style="font-weight:bold"></td></tr>
							';
                foreach($sections as $section) {
                    echo '<tr><td colspan="8" align="center" style="font-weight:bold"><center>Section '.$section->scn_nbr.' : '.$section->label_en.'</center></td></tr>
								 <tr><td colspan="8" align="center" style="font-weight:bold"></td></tr>	';
                    $chapters = $this->Item->GetChaptersBySectionId('', $section->id);
                    foreach($chapters as $chapter) {

                        $items = $this->Item->GetSubHeadingByChapterId('', $chapter->id);
                        if(count($items) > 0) {
                            echo '<tr><td colspan="8" align="center" style="font-weight:bold"><center>Chapter '.$chapter->cha_nbr.' : '.$chapter->label_en.'</center></td></tr>
										<tr><td colspan="8" align="center" style="font-weight:bold"></td></tr>	';
                            foreach($items as $item) {
                                $companies = $this->Report->GetCompaniesSubHeading($item->id, 'ar');
                                if(count($companies) > 0) {
                                    echo '<tr><td colspan="8"  align="center" style=" font-weight:bold !important; text-align:center !important" ><center> H.S Code  : '.$item->hs_code.' '.$item->description_en.'</center></td></tr>
											<tr><td colspan="8" align="center" style="font-weight:bold"></td></tr>
											';
                                    foreach($companies as $row) {
                                        if($row->copy_res == 1)
                                            $css_ex = 'font-weight:bold';
                                        else
                                            $css_ex = '';
                                        if($row->is_adv == 1)
                                            $css = 'yellow';
                                        else
                                            $css = '';
                                        echo '<tr class="'.$css.'">
											<td class="'.$css.'" style="'.$css_ex.'">'.$row->name_en.'</td>
											<td class="'.$css.'" style="'.$css_ex.'">'.$row->district_en.'</td>
											<td class="'.$css.'" style="'.$css_ex.'">'.$row->area_en.'</td>
											<td class="'.$css.'" style="'.$css_ex.'">'.$row->street_en.'</td>
											<td class="'.$css.'" style="'.$css_ex.'">'.$row->phone.'</td>
											<td class="'.$css.'" style="'.$css_ex.'">'.$row->whatsapp.'</td>
											<td class="'.$css.'" style="'.$css_ex.'">'.$row->fax.'</td>
											<td class="'.$css.'" style="'.$css_ex.'">'.$row->pobox_en.'</td>
	                                        <td class="'.$css.'" style="'.$css_ex.'">'.$row->email.'</td>
                                        </tr>';
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }


        echo '</tbody>';

        echo '</table>';

        //return $filename;
        exit;
    }

    public function companies($lang = 'ar') {

        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Reports');
        $this->breadcrumb->add_crumb('Compnay');
        $query = array();
        $secter = 0;
        $section = 0;
        $chapter = 0;
        if(isset($_GET['search'])) {
            $lang = $this->input->get('lang');
            $chapter = $this->input->get('chapters');
            $section = $this->input->get('section');
            $sector = $this->input->get('sector');
            $query = $this->Report->SearchCompany($sector, $section, $chapter, $lang);
        }

        //$this->data['query']=$this->Report->GetCompany($lang);
        if($lang == 'en') {
            $this->data['title'] = $this->data['Ctitle']." -  The Company";
            $this->data['subtitle'] = "The Company ";
        }
        else {
            $this->data['title'] = $this->data['Ctitle']."الشركات الصناعية - ";
            $this->data['subtitle'] = "الشركات الصناعية ";
        }
        $this->data['query'] = $query;

        $this->data['sectors'] = $this->Item->GetSector('online', 0, 0);
        $this->data['sections'] = $this->Item->GetSection('online', 0, 0);
        $this->data['chapters'] = $this->Item->GetSection('online', 0, 0);
        $this->data['sector_id'] = @$sector;
        $this->data['section_id'] = @$section;
        $this->data['chapter_id'] = @$chapter;
        $this->template->load('_template', 'reports/company_'.$lang, $this->data);
    }

    public function sectors($lang = 'ar') {

        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Reports');
        $this->breadcrumb->add_crumb('Mohafazat');
        $gov = 0;
        $mohafaza = '';
        if(isset($_GET['search'])) {
            $lang = $this->input->get('lang');
            $gov = $this->input->get('gov');
            $mohafaza = $this->Address->GetGovernorateById($gov);
        }

        //$this->data['query']=$this->Report->GetCompany($lang);
        if($lang == 'en') {
            $this->data['title'] = $this->data['Ctitle']." -  Distrubution of Industrial Firms among Mohafazats according to sector and geographical situation";
            $this->data['subtitle'] = "Distrubution of Industrial Firms among Mohafazats according to sector and geographical situation"."<br>".@$mohafaza['label_en'];
        }
        else {
            $this->data['title'] = $this->data['Ctitle']."   ";
            $this->data['subtitle'] = "توزيع المصانع اللبنانية على المحافظات بحسب القطاع والجغرافيا"."<br>".@$mohafaza['label_ar'];
        }

        $this->data['query'] = $query = $this->Report->GetCompanyByGov($gov, $lang);
        $this->data['sectors'] = $this->Item->GetSector('online', 0, 0);
        $this->data['governorates'] = $this->Address->GetGovernorate('online', 0, 0);
        $this->data['gov'] = @$gov;
        $this->template->load('_template', 'reports/sectors_'.$lang, $this->data);
    }

    public function geosectors() {
        //$id=0;
        if(isset($_GET['search']) & $this->input->get('gov') != 0) {

            $this->breadcrumb->clear();
            $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
            $this->breadcrumb->add_crumb('Reports');
            $this->breadcrumb->add_crumb('Geo Sectors');
            $gov = 0;

            $lang = $this->input->get('lang');
            $id = $this->input->get('gov');
            $mohafaza = $this->Address->GetGovernorateById($id);


            //$this->data['query']=$this->Report->GetCompany($lang);
            if($lang == 'en') {
                $this->data['title'] = $this->data['Ctitle']." -  The Company";
                $this->data['subtitle'] = "Percentages of Industrial Firms distribution in ".@$mohafaza['label_en'];
            }
            else {
                $this->data['title'] = $this->data['Ctitle']."   ";
                $this->data['subtitle'] = "توزيع المصانع في محافظة "." ".@$mohafaza['label_ar']." حسب النشاط";
            }

            $this->data['query'] = $query = $this->Report->GetCompanyByGovById($id, $lang);
            $this->data['sectors'] = $this->Item->GetSector('online', 0, 0);
            $this->data['governorates'] = $this->Address->GetGovernorate('online', 0, 0);
            $this->data['districts'] = $districts = $this->Address->GetDistrictByGov('online', $id);
            $this->data['gov'] = @$id;
            $this->template->load('_template', 'reports/geosectors_'.$lang, $this->data);
        }
        else {
            redirect('reports/sectors/'.$lang);
        }
    }

    function ExportSectors($lang = 'ar') {
        // filename for download
        $filename = "allmohafazat".$this->tdate.$lang.".xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');
        $flag = false;

        echo '<style type="text/css">
tr, td, table, tr{
	border:1px solid #D0D0D0;
}
.yellow{
						background:#FF0 !important;
					}
</style>   ';
        $query = $this->Report->GetCompanyByGov('', $lang);
        $sectors = $this->Item->GetSector('online', 0, 0);
        $governorates = $this->Address->GetGovernorate('online', 0, 0);
        echo '<table cellpadding="0" cellspacing="0" style="border:1px solid; background:none !important" width="100%" class="table">
                        <thead>
                            <tr>
								<th></th>';
        foreach($sectors as $sector) {
            if($lang == 'en') {
                $sector_title = $sector->label_en;
            }
            else {
                $sector_title = $sector->label_ar;
            }
            echo '<th>'.$sector_title.'</th>';
        }
        ' </tr>
                        </thead>
                        <tbody>';
        foreach($governorates as $gover) {
            $total = 0;
            if($lang == 'en') {
                $gover_title = $gover->label_en;
            }
            else {
                $gover_title = $gover->label_ar;
            }
            echo '<tr><td nowrap="nowrap">'.$gover_title.'</td>';

            foreach($query as $row) {
                if($row->governorate_id == $gover->id) {
                    $total = $total + $row->company_nbr;
                }
            }


            foreach($sectors as $sector) {

                $cell = '<td>0<div class="r1">0 %</div></td>';
                foreach($query as $row) {

                    if($row->governorate_id == $gover->id and $row->sectorID == $sector->id) {
                        $cell = '<td>'.$row->company_nbr.'<br>'.round(($row->company_nbr * 100) / $total, 2).' %</td>';
                    }
                }
                echo $cell;
            }

            echo '</tr>';
        }
        echo '</tbody>';

        echo '</table>';

        //return $filename;
        exit;
    }

    function ExportGeoSectors($gov, $lang = 'ar') {
        // filename for download
        $mohafaza = $this->Address->GetGovernorateById($gov);
        $filename = $mohafaza['label_en']."-".$this->tdate.$lang.".xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');
        $flag = false;

        echo '<style type="text/css">
tr, td, table, tr{
	border:1px solid #D0D0D0;
}
.yellow{
						background:#FF0 !important;
					}
</style>   ';
        $query = $this->Report->GetCompanyByGovById($gov, $lang);
        $sectors = $this->Item->GetSector('online', 0, 0);
        $governorates = $this->Address->GetGovernorate('online', 0, 0);
        $districts = $this->Address->GetDistrictByGov('online', $gov);

        echo '<table cellpadding="0" cellspacing="0" style="border:1px solid; background:none !important" width="100%" class="table">
                        <thead>
                            <tr>
								<th></th>';
        foreach($sectors as $sector) {
            if($lang == 'en') {
                $sector_title = $sector->label_en;
            }
            else {
                $sector_title = $sector->label_ar;
            }
            echo '<th>'.$sector_title.'</th>';
        }
        ' </tr>
                        </thead>
                        <tbody>';
        foreach($districts as $district) {
            $total = 0;
            if($lang == 'en') {
                $district_title = $district->label_en;
            }
            else {
                $district_title = $district->label_ar;
            }
            echo '<tr><td nowrap="nowrap">'.$district_title.'</td>';

            foreach($query as $row) {
                if($row->districtID == $district->id) {
                    $total = $total + $row->company_nbr;
                }
            }


            foreach($sectors as $sector) {

                $cell = '<td>0<div class="r1">0 %</div></td>';
                foreach($query as $row) {

                    if($row->districtID == $district->id and $row->sectorID == $sector->id) {
                        $cell = '<td>'.$row->company_nbr.'<br>'.round(($row->company_nbr * 100) / $total, 2).' %</td>';
                    }
                }
                echo $cell;
            }

            echo '</tr>';
        }
        echo '</tbody>';

        echo '</table>';

        //return $filename;
        //	exit;
    }

    public function heading($lang = 'ar') {
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Reports');
        $this->breadcrumb->add_crumb('Heading');
        $query = array();
        if(isset($_GET['search'])) {


            $lang = $this->input->get('lang');
            $hscode = $this->input->get('hscode');
            $this->data['query'] = $query = $this->Report->GetHeadingByTitle($hscode, $lang);
        }

        //$this->data['query']=$this->Report->GetCompany($lang);
        if($lang == 'en') {
            $this->data['title'] = $this->data['Ctitle']." -  Heading";
            $this->data['subtitle'] = "Heading ";
        }
        else {
            $this->data['title'] = $this->data['Ctitle']."الانتاج";
            $this->data['subtitle'] = "الانتاج";
        }
        $this->data['query'] = $query;
        $this->data['hscode'] = @$hscode;
        $this->data['lang'] = @$lang;
        $this->template->load('_template', 'reports/heading_'.$lang, $this->data);
    }

    function ExportHeading($hscode, $lang = 'ar',$ex=false) {
        // filename for download
        $filename = $hscode."-".$lang.".xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');
        $flag = false;

        echo '<style type="text/css">
tr, td, table, tr{
	border:1px solid #D0D0D0;
}
.yellow{
						background:#FF0 !important;
					}
</style>   ';
        $query = $this->Report->GetCompanyByHSCode($hscode, $lang);


        echo '<table cellpadding="0" cellspacing="0" style="border:1px solid; background:none !important" width="100%" class="table">
                        <thead>
                            <tr>';
        if($ex == 'en') {
            echo '
								<th>ID</th>
								<th>Company</th>
								<th>Owner</th>
								<th>Kazaa</th>
								<th>City</th>
								<th>Street</th>
								<th>Phone</th>
								<th>WhatsApp</th>
								<th>Fax</th>
								<th>P.O.BOX</th>
                                <th>Email</th>
                           ';
        }
        else {
            echo '<th>البريد اللكتروني</th>
                                <th>ص.ب</th>
                                <th>فاكس</th>
                               <th>هاتف</th>
                               <th>واتساپ</th>
                               <th>واتساپ</th>
                                <th>الشارع</th>
                                <th>المدينة</th>
                                <th>قضاء</th>
								<th>صاحب الشركة</th>
                                <th>الشركة</th>
								 <th>الرمز</th>';
        }
        echo ' </tr>
                        </thead>
                        <tbody>';
        foreach($query as $row) {
            if($ex == 'en') {
                if($row->copy_res == 1)
                    $css_ex = 'font-weight:bold';
                else
                    $css_ex = '';
                if($row->is_adv == 1)
                    $css = 'yellow';
                else
                    $css = '';
                echo '<tr class="'.$css.'">
								<td class="'.$css.'" style="'.$css_ex.'">'.$row->id.'</td>
								<td class="'.$css.'" style="'.$css_ex.'">'.$row->name_en.'</td>
								<td class="'.$css.'" style="'.$css_ex.'">'.$row->owner_name_en.'</td>
								<td class="'.$css.'" style="'.$css_ex.'">'.$row->district_en.'</td>
								<td class="'.$css.'" style="'.$css_ex.'">'.$row->area_en.'</td>
								<td class="'.$css.'" style="'.$css_ex.'">'.$row->street_en.'</td>
								<td class="'.$css.'" style="'.$css_ex.'">'.$row->phone.'</td>
								<td class="'.$css.'" style="'.$css_ex.'">'.$row->whatsapp.'</td>
								<td class="'.$css.'" style="'.$css_ex.'">'.$row->fax.'</td>
								<td class="'.$css.'" style="'.$css_ex.'">'.$row->pobox_en.'</td>
								<td class="'.$css.'" style="'.$css_ex.'">'.$row->email.'</td>
							</tr>';
            }
            else {
                if($row->copy_res == 1)
                    $css_ex = 'font-weight:bold';
                else
                    $css_ex = '';
                if($row->is_adv == 1)
                    $css = 'yellow';
                else
                    $css = '';
                echo '<tr class="'.$css.'">
									<td style="text-align:right; '.$css_ex.'">'.$row->email.'</td>
									<td style="direction:rtl !important; text-align:right !important; '.$css_ex.'">'.$row->pobox_ar.'</td>
									<td style="text-align:right; '.$css_ex.'">'.$row->fax.'</td>
									<td style="text-align:right; '.$css_ex.'">'.$row->phone.'</td>
									<td style="text-align:right; '.$css_ex.'">'.$row->whatsapp.'</td>
									<td style="direction:rtl !important; text-align:right !important; '.$css_ex.'">'.$row->street_ar.'</td>
									<td class="'.$css.'" style="text-align:right; '.$css_ex.'">'.$row->area_ar.'</td>
									<td class="'.$css.'" style="text-align:right; '.$css_ex.'">'.$row->district_ar.'</td>
									<td class="'.$css.'" style="text-align:right; '.$css_ex.'">'.$row->owner_name.'</td>
									<td class="'.$css.'" style="direction:rtl !important; text-align:right !important; '.$css_ex.'">'.$row->name_ar.'</td>
									<td class="'.$css.'" style="direction:rtl !important; text-align:right !important; '.$css_ex.'">'.$row->id.'</td>
                                   </tr>';
            }
        }
        echo '</tbody>';

        echo '</table>';

        //return $filename;
        //	exit;
    }

    public function markets($lang = 'ar') {
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Reports');
        $this->breadcrumb->add_crumb('Industrial Markets Report');
        $query = array();
        $this->data['countries'] = $this->Company->GetCountries('online', 0, 0);
        $this->data['markets'] = $this->Parameter->GetCompanyMarkets('online');


        if(isset($_GET['search'])) {

            $lang = $this->input->get('lang');
            $id = $this->input->get('id');
            $type = $this->input->get('type');
            $this->data['query'] = $query = $this->Report->GetCompanyByMarkets($id, $type, $lang);
        }

        //$this->data['query']=$this->Report->GetCompany($lang);
        if($lang == 'en') {
            $this->data['title'] = $this->data['Ctitle']." -  Industrial Markets";
            $this->data['subtitle'] = "Industrial Markets";
        }
        else {
            $this->data['title'] = $this->data['Ctitle']." اسواق التصدير";
            $this->data['subtitle'] = "اسواق التصدير";
        }
        $this->data['query'] = $query;
        $this->data['id'] = @$id;
        $this->data['type'] = @$type;
        $this->data['lang'] = @$lang;
        $this->template->load('_template', 'reports/company_markets_'.$lang, $this->data);
    }

    function ExportMarkets() {
        // filename for download
        $lang = $this->input->get('lang');
        $type = $this->input->get('type');
        $id = $this->input->get('id');

        if($type == 'region') {
            $market = $this->Parameter->GetCompanyMarketById($id);
        }
        else {
            $market = $this->Parameter->GetCountryById($id);
            // $filename = $hscode."-".$lang.".xls";
        }
        $filename = $market['label_en']."-".$lang.".xls";
        //$filename = $hscode."-".$lang.".xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');
        $flag = false;
        echo '<style type="text/css">
tr, td, table, tr{
	border:1px solid #D0D0D0;
}
.yellow{
						background:#FF0 !important;
					}
</style>   ';
        $query = $this->Report->GetCompanyByMarkets($id, $type, $lang);


        echo '<table cellpadding="0" cellspacing="0" style="border:1px solid; background:none !important" width="100%" class="table">
                        <thead>
                            <tr>';
        if($lang == 'en') {
            echo '
								<th>ID</th>
								<th>Company</th>
								<th>Owner</th>
								<th>Kazaa</th>
								<th>City</th>
								<th>Street</th>
								<th>Phone</th>
								<th>WhatsApp</th>
								<th>Fax</th>
								<th>P.O.BOX</th>
                                <th>Email</th>
                           ';
        }
        else {
            echo '<th>البريد اللكتروني</th>
                                <th>ص.ب</th>
                                <th>فاكس</th>
                               <th>هاتف</th>
                               <th>واتساپ</th>
                                <th>الشارع</th>
                                <th>المدينة</th>
                                <th>قضاء</th>
								<th>صاحب الشركة</th>
                                <th>الشركة</th>
								 <th>الرمز</th>';
        }
        echo ' </tr>
                        </thead>
                        <tbody>';
        foreach($query as $row) {
            if($lang == 'en') {
                if($row->copy_res == 1)
                    $css_ex = 'font-weight:bold';
                else
                    $css_ex = '';
                if($row->is_adv == 1)
                    $css = 'yellow';
                else
                    $css = '';
                echo '<tr class="'.$css.'">
								<td class="'.$css.'" style="'.$css_ex.'">'.$row->id.'</td>
								<td class="'.$css.'" style="'.$css_ex.'">'.$row->name_en.'</td>
								<td class="'.$css.'" style="'.$css_ex.'">'.$row->owner_name_en.'</td>
								<td class="'.$css.'" style="'.$css_ex.'">'.$row->district_en.'</td>
								<td class="'.$css.'" style="'.$css_ex.'">'.$row->area_en.'</td>
								<td class="'.$css.'" style="'.$css_ex.'">'.$row->street_en.'</td>
								<td class="'.$css.'" style="'.$css_ex.'">'.$row->phone.'</td>
								<td class="'.$css.'" style="'.$css_ex.'">'.$row->whatsapp.'</td>
								<td class="'.$css.'" style="'.$css_ex.'">'.$row->fax.'</td>
								<td class="'.$css.'" style="'.$css_ex.'">'.$row->pobox_en.'</td>
								<td class="'.$css.'" style="'.$css_ex.'">'.$row->email.'</td>
							</tr>';
            }
            else {
                if($row->copy_res == 1)
                    $css_ex = 'font-weight:bold';
                else
                    $css_ex = '';
                if($row->is_adv == 1)
                    $css = 'yellow';
                else
                    $css = '';
                echo '<tr class="'.$css.'">
									<td style="text-align:right; '.$css_ex.'">'.$row->email.'</td>
									<td style="direction:rtl !important; text-align:right !important; '.$css_ex.'">'.$row->pobox_ar.'</td>
									<td style="text-align:right; '.$css_ex.'">'.$row->fax.'</td>
									<td style="text-align:right; '.$css_ex.'">'.$row->phone.'</td>
									<td style="text-align:right; '.$css_ex.'">'.$row->whatsapp.'</td>
									<td style="direction:rtl !important; text-align:right !important; '.$css_ex.'">'.$row->street_ar.'</td>
									<td class="'.$css.'" style="text-align:right; '.$css_ex.'">'.$row->area_ar.'</td>
									<td class="'.$css.'" style="text-align:right; '.$css_ex.'">'.$row->district_ar.'</td>
									<td class="'.$css.'" style="text-align:right; '.$css_ex.'">'.$row->owner_name.'</td>
									<td class="'.$css.'" style="direction:rtl !important; text-align:right !important; '.$css_ex.'">'.$row->name_ar.'</td>
									<td class="'.$css.'" style="direction:rtl !important; text-align:right !important; '.$css_ex.'">'.$row->id.'</td>
                                   </tr>';
            }
        }
        echo '</tbody>';

        echo '</table>';

        //return $filename;
        //	exit;
    }

}
?>