<div class="content">
	<?=$this->load->view("includes/_bread")?>
    <div class="workplace">
        <div class="page-header">
            <h1><?=$subtitle;?></h1>
        </div> 
        <?php if(@$search){ ?>
       <div class="row-fluid">
            <div class="span12">
                 <div class="head clearfix">
                    <div class="isw-zoom"></div>
                    <h1>Search</h1>
                </div>
                <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'validation','method'=>'get'));?>
                  <div class="block-fluid">                        
                    <div class="row-form clearfix">
                        <div class="span2">Sales Men</div>
                        <div class="span2">
                        <?php 
								$array_sales['']='All ';
								foreach($sales as $salesitem)
								{
									$array_sales[$salesitem->id]=$salesitem->fullname;	
								}
											
								echo form_dropdown('sales_man',$array_sales,$this->input->get('sales_man'));
							?>
                        </div>
                        <div class="span1"><input type="submit" name="search" value="Search" class="btn"></div>
                        <div class="span1"><input type="submit" name="clear" value="Clear" class="btn"></div>
                        <div class="span1"><?=anchor('companies/adv_view?sales_man='.$this->input->get('sales_man'),'Print','class="btn" target="_blank"')?></div>
                        <div class="span2"><?=anchor('companies/adv_excel?sales_man='.$this->input->get('sales_man'),'Export To Excel','class="btn"')?></div>
                    </div>                            
                </div>
				<?=form_close()?>
            </div>
        </div> 
        <?php } ?>
        <div class="row-fluid">
            <div class="span12">
                <div class="block-fluid table-sorting clearfix">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th style="width: 150px !important">الشركة</th>
                                <th style="width: 150px !important">المسؤول</th>
                                <th>النشاط</th>
                                <th style="width: 100px !important">المحافظة</th>
                                <th style="width: 100px !important">القضاء</th>
                                <th style="width: 100px !important">المنطقة</th>
                                <th>الشارع</th>
                                <th>هاتف</th>
                                <th>المندوب</th>
                                <th>عدد دليل</th>
                                <th>عدد انترنت</th>
                                <th style="width: 150px !important">صفحات عربي</th>
                                <th style="width: 150px !important">صفحات إنجليزي</th>
                                <th style="width: 350px !important">ملاحظات</th>

                            </tr>
                        </thead>
                        <tbody> 
                        <?php 
						if(count($query)>0){
						foreach($query as $row){
						?>
                           <tr>
                    	        <td><?=$row->id?></td>
                                <td><?=$row->name_ar?></td>
                                <td><?=str_replace('-','<br>',$row->owner_name)?></td>
                                <td><?=$row->activity_ar?></td>
                                <td><?=$row->governorate_ar?></td>
                                <td><?=$row->district_ar?></td>
                                <td><?=$row->area_ar?></td>
                                <td><?=$row->street_ar?></td>
                                <td><?=str_replace('-','<br>',$row->phone)?></td>
                                <td><?=$row->salesman?></td>
                                <td align="center"><?=(($row->CNbr*2)+1)?></td>
                                <td align="center"><?=(($row->CNbr*2)+4)?></td>
                                <td><?=$row->guide_pages_ar?></td>
                                <td><?=$row->guide_pages_en?></td>
                                <td></td>
                    	</tr>
                            
                        <?php } }
						else{
								echo '<tr>
                            	<td colspan="15"><center><strong>No Data Found</strong></center></td>
                            </tr>';
							}
						
						?>    
                        </tbody>
                        <tfoot>
                        	<tr>
                                <td colspan="15">Total : <?=$total_row?><div class="dataTables_paginate paging_full_numbers"><?=$links?></div></td></tr>
                        </tfoot>
                    </table>
                    
                </div>
                <?php echo form_close();?>
            </div>                                
        </div>            
        <div class="dr"><span></span></div>            
    </div>
</div>
