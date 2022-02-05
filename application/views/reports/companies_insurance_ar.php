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
				echo anchor('reports/company_insurance/en','<h3 style="float:right !important; color:#FFF !important"> - English  </h3>');
			   echo anchor('reports/export_cinsurance?insurance='.$insurance.'&lang=ar','<h3 style="float:right !important; color:#FFF !important">Export To Excel</h3>');
			   
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
						foreach($insurances as $item){
							echo '<tr>
                            	<td colspan="6" align="center" style="text-align:center !important; font-size:18px !important; font-weight:bold !important" dir="rtl">'.$item->name_ar.'</td>
                            </tr>';
							$query=$this->Report->GetCompanyByInsuranceId($item->id,'ar');
						foreach($query as $row){	?>
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
						<?php } 
						
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
