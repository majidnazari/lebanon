<?php
$a_name = array(
	'name'	=> 'name',
	'id'	=> 'name',
	'class'	=> 'required text fl-space2',
	'value' => $name,
	'required' =>'required',
); 

?>
<style type="text/css">
.ul1{
	display:inline-block;
	margin:10px !important;
	vertical-align:top !important;
}
</style>
<div class="content">
	<?=$this->load->view("includes/_bread")?>
            <div class="workplace">
                
                <div class="page-header">
                    <h1><small>Create Group</small></h1>
                </div>  
                
                <div class="row-fluid">

                    <div class="span12">
                        <div class="head clearfix">
                            <div class="isw-documents"></div>
                            <h1>Group</h1>
                        </div>
                        <div class="block-fluid">                        
						<?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'validation'));?>
                            <div class="row-form clearfix">
                                <div class="span3">Group Title:</div>
                                <div class="span9"><?=form_input($a_name)?></div>
                            </div> 
                            <?php
							/* 
					 $array=array();
					 echo '<pre>';
					 var_dump($groups);
					 echo '</pre>';
					 
					 echo '<pre><font color="#FF0000">';
					 var_dump($groups[4]);
					 echo '</font></pre>';
					 */
					 foreach($permissions as $item){
						 $i=0;
							if($item->parent_id==0 and $item->actions==''){
								$i++;
						 ?>
                            <div class="row-form clearfix">
                                <div class="span2"><?=$item->label?>:</div>
                                <div class="span10">
                                <ul>
                              <?php for($i=0;$i<count($permissions);$i++){
										if($permissions[$i]->parent_id==$item->id){
								 ?>
								
								<li class="ul1"><?=$permissions[$i]->label ?>
                               
                                <?php								
								$action_array=json_decode($permissions[$i]->actions,TRUE);
								if(count($action_array)>0){
								echo '<ul>';	
								foreach($action_array as $key=>$value){
									//echo '<font color="#00FF00">'.$key.'</font>';
									//echo '<font color="#FF00FF">'.$value.'</font>';
									$checked=FALSE;
									if(array_key_exists($permissions[$i]->id,$groups)){
									if(in_array($key,$groups[$permissions[$i]->id]))
									{
										$checked=TRUE;
										}
									}
								$check = array(
									'name'        => 'permissions['.$permissions[$i]->id.'][]',
									'id'          => $permissions[$i]->id.'-'.$key,
									'value'       => $key,
									'class'       => 'checkbox',
									'checked'       => $checked,
   									 );
										echo '<li>'.form_checkbox($check).' '.$value.'</li>';
									}
									echo '</ul>';
									 } 
									 echo '</li>';
									 ?>
                                    
								<?php
								} }
								?>
                               </ul> 
							</div>
                            </div>	
							<?php }
					
					  		elseif($item->parent_id==0 and $item->actions!=''){ ?>
                            <div class="row-form clearfix">
                                <div class="span2"><?=$item->label?>:</div>
                                <div class="span10">
                           
								<?php
								$action_array=json_decode($item->actions,TRUE);
								foreach($action_array as $key=>$value){
									$checked=FALSE;
									if(array_key_exists($item->id,$groups)){
									if(in_array($key,$groups[$item->id]))
									{
										$checked=TRUE;
										}
									}	
								$check1 = array(
									'name'        => 'permissions['.$item->id.'][]',
									'id'          => $item->id.'-'.$key,
									'value'       => $key,
									'class'       => 'checkbox fl-space',
									'checked'       => $checked,
									'rel'=>"checkboxhorizont"
   									 );
										echo '<label class="checkbox inline">'.form_checkbox($check1).' '.$value.'</label>';
									} 
								?>
								</div>                            
                            </div> 

                                <?php 
								
									
					 }
					 }
					 ?>
                                
                            <div class="footer tar">
                                <button class="btn">Submit</button>
                            </div>  
                            <?=form_close()?>                          
                        </div>

                    </div>

                </div>

                <div class="dr"><span></span></div>
            </div>