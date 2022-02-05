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
                        <div class="span6">Sector (القطاع)<br /><?php 
								$array_sector[0]='All ';
								foreach($sectors as $secitem)
								{
									if($secitem->id!=0)
									$array_sector[$secitem->id]=$secitem->label_ar;	
								}
											
								echo form_dropdown('sector',$array_sector,$sector_id);
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
				echo anchor('reports/company/en','<h3 style="float:right !important; color:#FFF !important"> - English  </h3>');
			   echo anchor('reports/ExportCompaniesAr/','<h3 style="float:right !important; color:#FFF !important">Export All To Excel</h3>');
			   if($sector_id !=''){
			    echo anchor('reports/ExportCompaniesAr/'.$sector_id,'<h3 style="float:right !important; color:#FFF !important">Export Selected To Excel</h3>');
			   }
        ?>                                  
                </div>  
                <div class="block-fluid table-sorting clearfix">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                            	<th>البريد اللكتروني</th>
                                <th>ص.ب</th>
                                 <!--<th>فاكس</th>
                               	 <th>هاتف</th>-->
                                <th>الشارع</th>
                                <th>المدينة</th>
                                <th>قضاء</th>
                                <th>الشركة</th>
                             </tr>
                        </thead>
                        <tbody>
                        <?php
						
						
						if($sector_id!='')
						{
							$sectors_data=$this->Item->GetSectorById($sector_id);
							
							$sections=$this->Item->GetSectionsBySectorId('',$sectors_data['id']);
							echo '<tr><td colspan="6" align="center"><center><h3>'.$sectors_data['label_ar'].'</h3></center></td></tr>';
							foreach($sections as $section)
							{
								 echo '<tr><td colspan="6" align="center" style="font-weight:bold"><center>القسم '.$section->scn_nbr.' : '.$section->label_ar.'</center></td></tr>';
								 $chapters=$this->Item->GetChaptersBySectionId('',$section->id);
								 foreach($chapters as $chapter)
								 {
									
									 $items=$this->Item->GetSubHeadingByChapterId('',$chapter->id);
									 if(count($items)>0)
									 {
										echo '<tr><td colspan="6" align="center" style="font-weight:bold"><center>الفصل '.$chapter->cha_nbr.' : '.$chapter->label_ar.'</center></td></tr>	';
										foreach($items as $item)
										{
											$companies=$this->Report->GetCompaniesSubHeading($item->id,'ar');
											if(count($companies)>0){
											echo '<tr>
                            	<td colspan="6" align="right" style="text-align:right !important; font-weight:bold !important" dir="rtl">البند الجمركي  : '.$item->hs_code.' '.$item->description_ar.'</td></tr>';
											foreach($companies as $row){	
											?>
                                            <tr>
                                            <td style="text-align:right"><?=$row->email?></td>
                                            <td style="direction:rtl !important; text-align:right !important"><?=$row->pobox_ar?></td>
                                          <!--  <td style="text-align:right"><?=$row->fax?></td>
                                            <td style="text-align:right"><?=$row->phone?></td>-->
                                            <td style="direction:rtl !important; text-align:right !important"><?=$row->street_ar?></td>
                                            <td style="text-align:right"><?=$row->area_ar?></td>
                                            <td style="text-align:right"><?=$row->district_ar?></td>
                                            <td style="direction:rtl !important; text-align:right !important"><?=$row->name_ar?></td>
                                        </tr>
										   <?php 
										} }
									}
									 }
								}
							}
						
						}
						else{
							$sectors_data=$sectors;
						
						foreach($sectors_data as $sector)
						{
							$sections=$this->Item->GetSectionsBySectorId('',$sector->id);
							echo '<tr><td colspan="6" align="center"><center><h3>'.$sector->label_ar.'</h3></center></td></tr>';
							foreach($sections as $section)
							{
								  echo '<tr><td colspan="6" align="center" style="font-weight:bold"><center>القسم '.$section->scn_nbr.' : '.$section->label_ar.'</center></td></tr>';
								 $chapters=$this->Item->GetChaptersBySectionId('',$section->id);
								 foreach($chapters as $chapter)
								 {
									
									 $items=$this->Item->GetSubHeadingByChapterId('',$chapter->id);
									 if(count($items)>0)
									 {
										echo '<tr><td colspan="6" align="center" style="font-weight:bold"><center>الفصل '.$chapter->cha_nbr.' : '.$chapter->label_ar.'</center></td></tr>	';
										foreach($items as $item)
										{
											$companies=$this->Report->GetCompaniesSubHeading($item->id,'ar');
											if(count($companies)>0){
											echo '<tr>
                            	<td colspan="6" align="right" style="text-align:right !important; font-weight:bold !important" dir="rtl">البند الجمركي  : '.$item->hs_code.' '.$item->description_ar.'</td></tr>';
											foreach($companies as $row){	
											?>
                                            <tr>
                                            <td style="text-align:right"><?=$row->email?></td>
                                            <td style="direction:rtl !important; text-align:right !important"><?=$row->pobox_ar?></td>
                                          <!--  <td style="text-align:right"><?=$row->fax?></td>
                                            <td style="text-align:right"><?=$row->phone?></td>-->
                                            <td style="direction:rtl !important; text-align:right !important"><?=$row->street_ar?></td>
                                            <td style="text-align:right"><?=$row->area_ar?></td>
                                            <td style="text-align:right"><?=$row->district_ar?></td>
                                            <td style="direction:rtl !important; text-align:right !important"><?=$row->name_ar?></td>
                                        </tr>
										   <?php 
										} }
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
                                <td colspan="6"></td></tr>
                        </tfoot>
                    </table>
                    
                </div>
                <?php echo form_close();?>
            </div>                                
        </div>            
        <div class="dr"><span></span></div>            
    </div>
</div>
