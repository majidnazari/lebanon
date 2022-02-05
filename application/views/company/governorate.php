<link href="<?=base_url()?>css/select22.css" rel="stylesheet"/>
    <script src="<?=base_url()?>js/select2.js"></script>
    <script>
        $(document).ready(function() {
           // $(".select2").select2();   
        });
    </script>
<style type="text/css">
.select2{
	width:100% !important;
}
</style>    
<div class="content">
	<?=$this->load->view("includes/_bread")?>
    <div class="workplace">
        <div class="page-header">
            <h1><?=$subtitle?></h1>
        </div> 
        <div class="row-fluid">
            <div class="span12">
               <div class="head clearfix">
                    <div class="isw-grid"></div>
                    <h1><?=$subtitle?></h1>
                   <?=anchor('companies/governorate_export','<h2 style="float: right !important">Export To Excel</h2>')?>
                </div>
                <div class="block-fluid table-sorting clearfix">
                <table cellpadding="0" cellspacing="0" width="100%" class="table" id="tSortable">
                                <thead>
                                    <tr>
                                        
                                        <th width="30%">محافظة</th>
                                        <th width="30%">Mohafaz</th>
                                        <th width="20%">Company Number</th>
                                        <th width="20%">Percentage</th>
                                        <th width="20%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                 <?php
                                 $total=0;
                                 foreach($query as $row){
                                     $total+=$row->company_count;

                                 }
                                 foreach($query as $row){
                                     $percentage=round((($row->company_count*100)/$total),2);
                                     ?>
                                <tr>
                                    <td><?=$row->governorate_ar?></td>
                                    <td><?=$row->governorate_en?></td>
                                    <td><?=$row->company_count?></td>
                                    <td><?=$percentage?> %</td>
                                    <td><?=anchor('companies?id=&ministry_id=&name=&activity=&phone=&gov='.$row->governorate_id.'&district_id=&area_id=&status=all&search=Search','View Companies',array('target'=>'_blank'))?></td>
                                </tr>
                                  <?php  } ?>
                                </tbody>
                            </table>
                    
                </div>
                <?php echo form_close();?>
            </div>                                
        </div>            
        <div class="dr"><span></span></div>            
    </div>
</div>
