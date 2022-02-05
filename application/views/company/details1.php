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
			<!--	<div class="row-fluid"><?=$this->load->view('_company_navigation')?></div>       -->     
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
                                                <li class="heading"> <div class="isw-cloud"></div>Company Info</li>
                                                <li>
                                                    <div class="title title1">Company Name:</div>
                                                    <div class="text text1"><?=$query['name_en'].' <br> '.$query['name_ar']?></div>
                                                </li>
                                                <li>
                                                    <div class="title title1">Owner / Ownersof the Company:</div>
                                                    <div class="text text1"><?=$query['owner_name_en'].'<br>'.$query['owner_name'];?>&nbsp;</div>
                                                </li>
                                                <li>
                                                    <div class="title title1">Name of the Authorized to sign:</div>
                                                    <div class="text text1"><?=$query['auth_person_en'].'<br>'.$query['auth_person_ar']?>&nbsp;</div>
                                                </li>
    											<li>
                                                    <div class="title title1">No. & Place of C.R:</div>
                                                    <div class="text text1"><?=$query['commercial_register_en'].'<br>'.$query['commercial_register_ar']?>&nbsp;</div>
                                                </li>
                                                <li>
                                                    <div class="title title1">Activity:</div>
                                                    <div class="text text1"><?=$query['activity_en'].' <br> '.$query['activity_ar']?>&nbsp;</div>
                                                </li>
												<li>
                                                    <div class="title title1">Company Type:</div>
                                                    <div class="text text1">
													
													<?php
													if(count($company_types)>0)
                                                    echo $company_types['label_en'].' <br> '.$company_types['label_ar']?>&nbsp;</div>
                                                </li>
                                                                                               
                                            </ul>                                                      
                                        </div>
                                                                
                                </div>
                                                 
                        <div class="head clearfix">
                            <div class="isw-grid"></div>
                            <h1>Affiliation to Economical & Technical Associations</h1>                 
                        </div>
                        <div class="block-fluid">
                            <table cellpadding="0" cellspacing="0" width="100%" class="table">
                                
                                <tbody>
                               
                                    <tr>
                                        <td>Associations of Lebanese Industrialists:</td>                                        
                                        <td><?php 
												if($query['ind_association']==1)
													echo 'Yes';
												else
													echo 'No';	
														?></td>
                                    </tr>
                                    <tr>
                                    	<td>Chambre of Commerce & <br />Industry of :</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                    	<td>Assemblies of Economical, Technical or Local Orders (Specify):</td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                    	<td>Industrial Assembly:</td>
                                        <td></td>
                                    </tr>
                                                                                         
                                </tbody>
                            </table>
                        </div>
                    
                                
                            </div> 
							<div class="span6">
                                <div class="block-fluid ucard">
                                        <div class="info">                                                                
                                            <ul class="rows">
                                                <li class="heading"> <div class="isw-cloud"></div>Head Office Address</li>
 
                                                <li>
                                                    <div class="title title1">Mohafaza:</div>
                                                    <div class="text text1"><?=$governorates['label_en'].'<br>'.$governorates['label_ar']?>&nbsp;</div>
                                                </li>
                                                <li>
                                                    <div class="title title1">Kazaa:</div>
                                                    <div class="text text1"><?=$districts['label_en'].'<br>'.$districts['label_ar']?>&nbsp;</div>
                                                </li>                                                
                                                <li>
                                                    <div class="title title1">City:</div>
                                                    <div class="text text1"><?=$area['label_en'].'<br>'.$area['label_ar']?>&nbsp;</div>
                                                </li>                                                

                                                <li>
                                                    <div class="title title1">Street:</div>
                                                    <div class="text text1"><?=$query['street_en'].'<br>'.$query['street_ar']?>&nbsp;</div>
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
                                                    <div class="text text1"><?=$query['website']?>&nbsp;</div>
                                                </li>
                                                <li>
                                                    <div class="title title1">Email:</div>
                                                    <div class="text text1"><?=$query['email']?>&nbsp;</div>
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