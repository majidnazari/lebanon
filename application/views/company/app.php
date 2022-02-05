<style type="text/css">
.title{
	width:200px !important;
}
.text1{
	margin-left:200px !important;
}
</style>

<div class="content">
	<?=$this->load->view("includes/_bread")?>
    
            <div class="workplace">      
                <div class="page-header">
                    <h2><?=$query['name_en'].'/&nbsp;'.$query['name_ar']?></h2>
                </div>  

		                   
        <div class="row-fluid">
            <div class="span9">
            
                 <div class="row-fluid">

                    <div class="span12">                    
                        <div class="head clearfix">
                            <div class="isw-grid"></div>
                            <h1>Applications 
                            	URL : system.lebanon-industry.com/posting/companies/<?=$id?>
                            </h1> 
                        </div>
                        <div class="block-fluid">
                            <table cellpadding="0" cellspacing="0" width="100%" class="table">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" name="checkall"/></th>                                        
                                        <th>Date</th>
                                        <th>Company Arabic Name </th>
                                        <th>Company Name </th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if(count($items)){
										foreach($items as $item){ ?>
                                    <tr>
                                        <td><input type="checkbox" name="checkbox"/></td>   
                                        <td><?=$item->create_time?></td>                                     
                                        <td><?=anchor('companies/app-details/'.$item->id,$item->name_ar)?></td>                                     
                                        <td><?=anchor('companies/app-details/'.$item->id,$item->name_en)?></td>                                     
                                        <td nowrap="nowrap"><?php echo _show_delete('companies/delete/id/'.$item->id.'/cid/'.$query['id'].'/p/app',$p_delete);
										?></td>
                                    </tr>
                                  <?php }
								  
								}
								else{
								?> 
                                    <tr>
                                        <td colspan="5" align="center"><h3>No Application Found</h3></td>
                                    </tr> 
                                   <?php } ?>                                                                
                                </tbody>
                            </table>
                        </div>
                    </div>                                
                </div>
             </div>
             <?=$this->load->view('company/_navigation')?> 
        </div>
   <div class="dr"><span></span></div>           
 </div>
</div>

