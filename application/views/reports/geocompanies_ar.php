<style type="text/css">
.yellow{
		background:#FF0 !important;
	}
</style>
<div class="content">
	<?=$this->load->view("includes/_bread")?>
    <div class="workplace">
        <div class="page-header">
            <h1><?=$subtitle;?></h1>
        </div> 
        <div class="row-fluid">
            <div class="span12">
                 <div class="head clearfix">
                    <div class="isw-zoom"></div>
                    <h1>Search</h1>
                </div>
                <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'validation','method'=>'get'));
					  echo form_hidden('lang','ar');
					   ?> 
                <div class="block-fluid">                        
                    <div class="row-form clearfix">
                        <div class="span6">Mohafaza (المحافظة)<br /><?php 
								$array_gov[0]='All ';
								foreach($governorates as $governorate)
								{
									if($governorate->id!=0)
									$array_gov[$governorate->id]=$governorate->label_ar;	
								}
											
								echo form_dropdown('gov',$array_gov,$gov_id);
							?>
                        </div>
                        <div class="span3"><br /><input type="submit" name="search" value="Search" class="btn">
                        <input type="submit" name="clear" value="Clear" class="btn">
                        </div>
                    </div>                         
                </div>
				<?=form_close()?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <?php echo form_open('',array('id'=>'form_id','name'=>'form1'));?>   
                <div class="head clearfix">
                    <div class="isw-grid"></div>
                    <h1><?=$subtitle?></h1>
					 <?php 
			//	echo anchor('reports/geocompany/en','<h3 style="float:right !important; color:#FFF !important"> - English  </h3>');
			   ///echo anchor('reports/ExportGeoCompanyAr/','<h3 style="float:right !important; color:#FFF !important">Export All To Excel</h3>');
			   if($gov_id !=''){
			    echo anchor('reports/ExportGeoCompanyAr/'.$gov_id,'<h3 style="float:right !important; color:#FFF !important">Export Arabic To Excel</h3>');
			    echo anchor('reports/ExportGeoCompanyEn/'.$gov_id,'<h3 style="float:right !important; color:#FFF !important">Export English To Excel</h3>');
			   }
        ?>                                  
                </div>  
                <div class="block-fluid table-sorting clearfix">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                            	<th>البريد اللكتروني</th>
                                
                               	 <th>هاتف</th>
                                <th>الشارع</th>
                                <th>النشاط</th>
                                <th>الشركة</th>
                             </tr>
                        </thead>
                        <tbody>
                        <?php
						
						
						if($gov_id!='')
						{
							$gov_array=$this->Address->GetGovernorateById($gov_id);
							$districts=$this->Address->GetDistrictByGov('',$gov_array['id']);
							echo '<tr><td colspan="5" align="center"><center><h3 style="margin:0px; padding:0px">'.$gov_array['label_ar'].'</h3></center></td></tr>';
							foreach($districts as $district)
							{
								  echo '<tr><td colspan="5" align="center" style="font-weight:bold"><center>قضاء  : '.$district->label_ar.'</center></td></tr>';
								 $areas=$this->Address->GetAreaByDistrict('',$district->id);
								 foreach($areas as $area)
								 {
									
									
											$companies=$this->Report->GetCompaniesByArea($area->id,'ar');
											if(count($companies)>0){
											 echo '<tr><td colspan="5" align="center" style="font-weight:bold"><center>'.$area->label_ar.'</center></td></tr>';
											foreach($companies as $row){	
											if($row->is_adv==1)
											$css='yellow';
											else
											$css='';
											?>
                                            <tr class="<?=$css?>">
                                            <td class="<?=$css?>" style="text-align:right"><?=$row->email?></td>
                                            <td class="<?=$css?>" style="text-align:right"><?=$row->phone?></td>
                                            <td class="<?=$css?>" style="direction:rtl !important; text-align:right !important"><?=$row->street_ar?></td>
                                            <td class="<?=$css?>" style="text-align:right"><?=$row->activity_ar?></td>
                                            <td class="<?=$css?>" style="direction:rtl !important; text-align:right !important"><?=$row->name_ar?></td>
                                        </tr>
										   <?php 
										
									}
									 }
								}
							}
						}
						else{
						
						foreach($governorates as $governorate)
						{
							$districts=$this->Address->GetDistrictByGov('',$governorate->id);
							echo '<tr><td colspan="5" align="center"><center><h3 style="margin:0px; padding:0px">'.$governorate->label_ar.'</h3></center></td></tr>';
							foreach($districts as $district)
							{
								  echo '<tr><td colspan="5" align="center" style="font-weight:bold"><center>قضاء  : '.$district->label_ar.'</center></td></tr>';
								 $areas=$this->Address->GetAreaByDistrict('',$district->id);
								 foreach($areas as $area)
								 {
									
									
											$companies=$this->Report->GetCompaniesByArea($area->id,'ar');
											if(count($companies)>0){
											echo '<tr><td colspan="5" align="center" style="font-weight:bold"><center>'.$area->label_ar.'</center></td></tr>';
											foreach($companies as $row){	
											if($row->is_adv==1)
											$css='yellow';
											else
											$css='';
											?>
                                            <tr>
                                            <td class="<?=$css?>" style="text-align:right"><?=$row->email?></td>
                                            
                                            <td class="<?=$css?>" style="text-align:right"><?=$row->phone?></td>
                                            <td class="<?=$css?>" style="direction:rtl !important; text-align:right !important"><?=$row->street_ar?></td>
                                            <td class="<?=$css?>" style="text-align:right"><?=$row->activity_ar?></td>
                                            <td class="<?=$css?>" style="direction:rtl !important; text-align:right !important"><?=$row->name_ar?></td>
                                        </tr>
										   <?php 
										
									}
									 }
								}
							}
						}
						}
						
						?>    
                        </tbody>
                        <tfoot>
                        	<tr>
                                <td colspan="7"></td></tr>
                        </tfoot>
                    </table>
                    
                </div>
                <?php echo form_close();?>
            </div>                                
        </div>            
        <div class="dr"><span></span></div>            
    </div>
</div>
