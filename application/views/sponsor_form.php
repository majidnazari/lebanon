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
                </div>  
                <div class="block-fluid"> 
                 <div class="row-form clearfix">
               <div class="span4"><img src="<?=base_url()?>img/silver-sponsor.jpg" style="width:100%" /></div>
               <div class="span4">
               <table cellpadding="0" cellspacing="0" width="100%" class="table">
                 <?php 
               $query_ar=$this->Sponsor->GetSponsors('online','ar');
               foreach($query_ar as $row_ar)
               {
                   if($row_ar->section=='external'){
                        $url= $row_ar->website;
                }
                else{
                   if(@$row_ar->section_id=='')
                    {
                       $url='#'; 
                    }
                    else{
                    switch (@$row_ar->section) {
                        case "bank":
                            $link='http://lebanon-industry.com/bank-details/';
                            break;
                        case "company":
                            $link='http://lebanon-industry.com/industrial-details/';
                            break;
                        case "insurance":
                            $link='http://lebanon-industry.com/insurance-details/';
                            break;
                        case "importer":
                            $link='http://lebanon-industry.com/importer-details/';
                            break;
                        case "transportation":
                            $link='http://lebanon-industry.com/transportation-details/';
                            break;        
                        }
                        $url=$link.@$row_ar->section_id;
                    }
                }
                   echo '<tr><td>'.$row_ar->title_en.'</td><td>A'.$row_ar->position.'</td><td><a href="'.$url.'" target="_blank">'.$url.'</a></td><td>'._show_edit('sponsors/edit/'.$row_ar->id,TRUE).'</td></tr>';
               }
               ?>  
               </table>
               </div>
               <div class="span4">
               <table cellpadding="0" cellspacing="0" width="100%" class="table">
                 <?php 
               $query_en=$this->Sponsor->GetSponsors('online','en');
               foreach($query_en as $row_en)
               {
                   if($row_en->section=='external'){
                        $url= $row_en->website;
                }
                else{
                   if(@$row_en->section_id=='')
                    {
                       $url='#'; 
                    }
                    else{
                    switch (@$row_en->section) {
                        case "bank":
                            $link='http://lebanon-industry.com/bank-details/';
                            break;
                        case "company":
                            $link='http://lebanon-industry.com/industrial-details/';
                            break;
                        case "insurance":
                            $link='http://lebanon-industry.com/insurance-details/';
                            break;
                        case "importer":
                            $link='http://lebanon-industry.com/importer-details/';
                            break;
                        case "transportation":
                            $link='http://lebanon-industry.com/transportation-details/';
                            break;        
                        }
                        $url=$link.@$row_en->section_id;
                    }
                }
                   echo '<tr><td>'.$row_en->title_en.'</td><td>E'.$row_en->position.'</td><td><a href="'.$url.'" target="_blank">'.$url.'</a></td><td>'._show_edit('sponsors/edit/'.$row_ar->id,TRUE).'</td></tr>';
               }
               ?>  
               </table>
               </div>
               </div>
               </div>
            </div>                                
        </div>            
        <div class="dr"><span></span></div>
        <div class="row-fluid">
            <div class="span12">
                 <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1><?=$subtitle?></h1>
                </div>
                <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'validation'));
					  echo form_hidden('s_id',$s_id);
					  echo form_hidden('logo',$logo);
					   ?> 
                <div class="block-fluid">                        
					
                    <div class="row-form clearfix">
                        <div class="span3">Name in english:</div>
                        <div class="span4"><?php echo form_input($title_en); ?>
                        <font color="#FF0000"><?php echo form_error('title_en'); ?></font>
                        </div>
                    </div> 
                    
                    <div class="row-form clearfix">
                        <div class="span3">Website:</div>
                        <div class="span4"><?php echo form_input($website); ?>
                        <font color="#FF0000"><?php echo form_error('website'); ?></font>
                        </div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span3">Logo:</div>
                        <div class="span4"><input type="file" name="userfile" />
                        <?php if($logo!=''){ ?>
                        		<img src="http://www.lebanon-industry.com/<?=$logo?>" />
                          <?php } ?>      
                        </div>
                    </div>    
                    
                    <div class="row-form clearfix">
                        <div class="span3">Section:</div>
                        <div class="span4"><?php 
                        $array_sections=array('bank'=>'Bank','company'=>'Company','importer'=>'Importer','inurance'=>'Inurance','transportation'=>'Transportation','external'=>'External');
                        echo form_dropdown('section',$array_sections,@$section);
							?></div>
                    </div> 
                    <div class="row-form clearfix">
                        <div class="span3">ID#:</div>
                        <div class="span4"><?php 
                        echo form_input(array('name'=>'section_id','value'=>@$section_id));
							?></div>
                    </div> 
                    <div class="row-form clearfix">
                        <div class="span3">Category:</div>
                        <div class="span4"><?php 
                        $array_categories=array('silver'=>'Silver','gold'=>'Gold');
                        echo form_dropdown('category',$array_categories,@$category);
							?></div>
                    </div> 
                    <div class="row-form clearfix">
                        <div class="span3">Language:</div>
                        <div class="span4"><?php $array_language=array('ar'=>'Ar','en'=>'En');
												echo form_dropdown('language',$array_language,@$language);
							?></div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span3">Position:</div>
                        <div class="span4"><?php 
                        $array_positions=array();
                        for($i=1;$i<=30;$i++)
                        {
                            $array_positions[$i]=$i;
                        }
                        
												echo form_dropdown('position',$array_positions,$position);
							?></div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span3">Status:</div>
                        <div class="span4"><?php $array_status=array('online'=>'Online','offline'=>'Offline');
												echo form_dropdown('status',$array_status,$status);
							?></div>
                    </div>                        
                                        
                    <div class="footer tar">
                    	<center><input type="submit" name="save" value="Save" class="btn"></center>
                    </div>                            
                </div>
				<?=form_close()?>
            </div>
        </div>
    </div>
</div>