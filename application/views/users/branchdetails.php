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
			<div class="row-fluid">
                <?=$this->load->view('_bank_branch_navigation')?>
                </div>            
                <div class="page-header">
                    <h1><small><?=$query['name_en'].'/&nbsp;'.$query['name_ar']?></small></h1>
                </div>                  
                <div class="row-fluid">
                <div class="span12">   
                <?php if($msg!=''){ ?>
              	<div class="alert alert-success">               
                    <?php echo $msg;?>
                </div> 
                <?php } ?>                   
                        <div class="row-fluid">
                            <div class="span6">
                                <div class="block-fluid ucard">
                                        <div class="info">                                                                
                                            <ul class="rows">
                                                <li class="heading"> <div class="isw-cloud"></div>Bank Info</li>
                                                <li>
                                                    <div class="title title1">Bank Name:</div>
                                                    <div class="text text1"><?=$query['name_en'].' <br> '.$query['name_ar']?></div>
                                                </li>
                                              
                                            </ul>                                                      
                                        </div>
                                                                
                                </div>
                                              
                            </div> 
							<div class="span6">
                                <div class="block-fluid ucard">
                                        <div class="info">                                                                
                                            <ul class="rows">
                                                <li class="heading"> <div class="isw-cloud"></div>Head Office Address</li>
                                                
                                                <li>
                                                    <div class="title title1">Street:</div>
                                                    <div class="text text1"><?=$query['street_en'].'<br>'.$query['street_ar']?>&nbsp;</div>
                                                </li>
                                                 <li>
                                                    <div class="title title1">Beside:</div>
                                                    <div class="text text1"><?=$query['beside_en'].'<br>'.$query['beside_ar']?>&nbsp;</div>
                                                </li>
                                                <li>
                                                    <div class="title">Bldg:</div>
                                                    <div class="text text1"><?=$query['bldg_en'].'<br>'.$query['bldg_ar']?>&nbsp;</div>
                                                </li>
                                                <li>
                                                    <div class="title">Tel:</div>
                                                    <div class="text text1"><?=$query['phone']?>&nbsp;</div>
                                                </li>                                                
                                                <li>
                                                    <div class="title title1">Fax:</div>
                                                    <div class="text text1"><?=$query['fax']?>&nbsp;</div>
                                                </li>        
                                                                                                                                                                            		<li>
                                                    <div class="title title1">P.O.Box:</div>
                                                    <div class="text text1"><?=$query['pobox_en'].'<br>'.$query['pobox_ar']?>&nbsp;</div>
                                                </li>
                                                <li>
                                                    <div class="title title1">Web Site:</div>
                                                    <div class="text text1"><?=$query['web_page']?>&nbsp;</div>
                                                </li>
                                                <li>
                                                    <div class="title title1">Email:</div>
                                                    <div class="text text1"><a href="mailto:<?=$query['email']?>"><?=$query['email']?></a>&nbsp;</div>
                                                </li>
                                                <li>
                                                    <div class="title title1">N Location:</div>
                                                    <div class="text text1"><?=$query['x_location']?>&nbsp;</div>
                                                </li>
                                                <li>
                                                    <div class="title title1">E Location:</div>
                                                    <div class="text text1"><?=$query['y_location']?>&nbsp;</div>
                                                </li>
                                            </ul>                                                      
                                        </div>                        
                                </div>
                            </div>                                                           
                        
						</div>
              </div>
            </div>            
           <div class="dr"><span></span></div>           
         </div>
        </div>