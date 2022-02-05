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
					  echo form_hidden('lang','en');
					   ?> 
                <div class="block-fluid">                        
                    <div class="row-form clearfix">
                        <div class="span6">Insurance Company<br /><?php echo form_input(array('name'=>'insurance','value'=>$insurance));?></div>
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
				echo anchor('reports/company_insurance/ar','<h3 style="float:right !important; color:#FFF !important"> - English  </h3>');
			   echo anchor('reports/export_cinsurance?insurance='.$insurance.'&lang=en','<h3 style="float:right !important; color:#FFF !important">Export To Excel</h3>');
			   
        ?>                                  
                </div>  
                <div class="block-fluid table-sorting clearfix">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                            	<th>Company</th>
								 <th>Owner</th>
                                 <th>Kazaa</th>
                                 <th>City</th>
                                 <th>Street</th>
								 <!--<th>Phone</th>
								 <th>Fax</th>-->
                                 <th>P.O.BOX</th>
                                <th>Email</th>
                             </tr>
                        </thead>
                        <tbody>
                        <?php	
						foreach($insurances as $item){
							echo $item->id;
							echo '<tr>
                            	<td colspan="6" align="center" style="text-align:center !important; font-size:18px !important; font-weight:bold !important" >'.$item->name_en.'</td>
                            </tr>';
							$query=$this->Report->GetCompanyByInsuranceId($item->id,'en');
						foreach($query as $row){	
                            echo ' <tr>
                                            <td>'.$row->name_en.'</td>
											<td>'.$row->owner_name_en.'</td>
                                            <td>'.$row->district_en.'</td>
                                            <td>'.$row->area_en.'</td>
                                            <td>'.$row->street_en.'</td>
											<td>'.$row->pobox_en.'</td>
                                            <td>'.$row->email.'</td>
                                          
                                        </tr>';
										
									} 
						
						} ?>    
                        </tbody>
                        <tfoot>
                        	<tr><td colspan="6"></td></tr>
                        </tfoot>
                    </table>
                    
                </div>
                <?php echo form_close();?>
            </div>                                
        </div>            
        <div class="dr"><span></span></div>            
    </div>
</div>
