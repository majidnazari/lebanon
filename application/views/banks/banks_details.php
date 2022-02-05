<style type="text/css">
.control{
	float:right !important;
	margin-top:10px !important;
	margin-right:10px !important;
	list-style:none !important;
}
.control li{
	float:left !important;
	margin-left:10px !important
}
.control a{
	color:#FFF !important;
}
</style>
<div class="content">
	<?=$this->load->view("includes/_bread")?>
    
            <div class="workplace">
                <div class="page-header">
                    <h1><small><?=$query['bank_name']?></small></h1>
                </div>                  
 <div class="row-fluid">

                    <div class="span12">
						<?php if($msg!=''){ ?>
                        <div class="alert alert-success">               
                            <?php echo $msg;?>
                        </div> 
                        <?php } ?> 
                        <div class="head clearfix">
                            <div class="isw-ok"></div>
                            <h1>Bank Details</h1>
                            <ul class="control">             
                                <li><span class="icon-pencil"></span> <?=anchor('banks/edit/id/'.$query['id'],'Edit')?></li>
                                <li><span class="icon-trash"></span> <?=anchor('banks/delete/id/'.$query['id'],'Delete')?></li>
                             </ul> 
                            
                        </div>
                        <div class="block">

                            <div class="row-form clearfix">
                                <div class="span3">Bank Name:</div>
                                <div class="span9"><?=$query['bank_name']?></div>                            
                            </div>                        
                            <div class="row-form clearfix">
                                <div class="span3">Bank Name in arabic:</div>                            
                                <div class="span9"><?=$query['bank_name_ar']?></div>                            
                            </div>

                            <div class="row-form clearfix">
                                <div class="span3">Bank Address:</div>                            
                                <div class="span9"><?=$query['bank_address']?></div>                            
                            </div> 
                            <div class="row-form clearfix">
                                <div class="span3">Bank Address in arabic:</div>
                                <div class="span9"><?=$query['bank_address_ar']?></div>                            
                            </div>                        
                            <div class="row-form clearfix">
                                <div class="span3">Account Name:</div>                            
                                <div class="span9"><?=$query['account_name']?></div>                            
                            </div>

                            <div class="row-form clearfix">
                                <div class="span3">Account Name in arabic:</div>                            
                                <div class="span9"><?=$query['account_name_ar']?></div>                            
                            </div> 
                            <div class="row-form clearfix">
                                <div class="span3">Account Number:</div>                            
                                <div class="span9"><?=$query['account_number']?></div>                            
                            </div>

                            <div class="row-form clearfix">
                                <div class="span3">Status:</div>                            
                                <div class="span9"><?php if($query['online']==1)
																echo '<span class="label label-success">Online</span>';
															else
																echo '<span class="label">Offline</span>';
													?>
                                </div>                            
                            </div>                                                                               
                            <div class="row-form clearfix">
                                <div class="span3">Create Date:</div>                            
                                <div class="span9"><?=$query['create_time']?></div>                            
                            </div> 
                            <div class="row-form clearfix">
                                <div class="span3">Last Update Date:</div>                            
                                <div class="span9"><?=$query['update_time']?></div>                            
                            </div>
                        </div>
                    </div>                                

                </div>               
                <div class="dr"><span></span></div>           
            </div>
        </div>