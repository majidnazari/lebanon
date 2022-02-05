<style>
    .text_orientation{
        writing-mode:tb-rl;
        transform: rotate(270deg);
        white-space:nowrap;
        display:block;
        bottom:0;
        width:20px;
		height:150px;
		clear:both;
        
    }
	.r1{
		width:100%;
		border-top:1px solid #000;
	}
</style>

<script>
$(document).ready(function(){
	if($("#chart-22").length > 0){
        
        var data = [];
        	        
	//for( var i = 0; i < 5; i++)	
	<?php 
	$i=0;
	foreach($districts as $district){
			$nbr=0;
			foreach($query as $row)
			{
				if($row->districtID==$district->id)
				{ $nbr=$nbr+$row->company_nbr; }
			}
	?>
		data[<?=$i?>] = { label: "<?=$district->label_en?>", data: Math.floor(<?=$nbr?>*100)+1 };
	<?php 
		$i++;
	} ?>

        $.plot($("#chart-22"), data, 
	{
            series: {
                pie: { show: true }
            },
            legend: { show: false }
	});

    }
if($("#chart-33").length > 0){
        
        var data = [];
        	        
	//for( var i = 0; i < 5; i++)	
	<?php 
	$i=0;
	foreach($sectors as $sector){ 
			$nbr=0;
			foreach($query as $row)
			{
				if($row->sectorID==$sector->id)
				{ $nbr=$nbr+$row->company_nbr; }
			}
			if($nbr>0){
	?>
		data[<?=$i?>] = { label: "<?=$sector->label_en?>", data: Math.floor(<?=$nbr?>*100)+1 };
	<?php 
		$i++;
		}	
		
	} ?>

        $.plot($("#chart-33"), data, 
	{
            series: {
                pie: { show: true }
            },
            legend: { show: false }
	});

    }
	});
</script>
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
                        <div class="span3">المحافظات<br /><?php 
								$array_gov[0]='All ';
								foreach($governorates as $gover)
								{
									if($gover->id!=0)
									$array_gov[$gover->id]=$gover->label_en;	
								}
											
								echo form_dropdown('gov',$array_gov,$gov);
							?>
                        </div>
                         <div class="span3"><br /><input type="submit" name="search" value="Search" class="btn">
                        <?=anchor('reports/sectors/en','Clear',array('class'=>'btn'))?>
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
				echo anchor('reports/geosectors/?lang=ar&gov='.$gov.'&search=Search','<h3 style="float:right !important; color:#FFF !important"> - Arabic  </h3>');
			   echo anchor('reports/ExportGeoSectors/'.$gov.'/en','<h3 style="float:right !important; color:#FFF !important">Export All To Excel</h3>');
			   
        ?>                                  
                </div>  
                <div class="block-fluid table-sorting clearfix">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                            	<th></th>
                            	<?php foreach($sectors as $sector){?>
                            	<th><?=$sector->label_en?></th>
                              	<?php } ?>
                             </tr>
                        </thead>
                        <tbody>
                        <?php
						
						foreach($districts as $district){
							$total=0;
						echo '<tr><td nowrap="nowrap">'.$district->label_en.'</td>';	
						
								foreach($query as $row)
								{
									if($row->districtID==$district->id )
									{
									$total=$total+$row->company_nbr;
									}
								}
							
							
							foreach($sectors as $sector){
								
								$cell='<td>0<div class="r1">0 %</div></td>';	
								foreach($query as $row)
								{
									
									if($row->districtID==$district->id and $row->sectorID==$sector->id)
									{
										$cell='<td>'.$row->company_nbr.'<div class="r1">'.round(($row->company_nbr*100)/$total,2).' %</div></td>';
									}	
								}
								echo $cell;	
							}
						
						echo '</tr>';
						}
						
						?>    
                        </tbody>
                        <tfoot>
                        	
                        </tfoot>
                    </table>
                    
                </div>
                <?php echo form_close();?>
            </div>                                
        </div>            
        <div class="dr"><span></span></div> 
        <div class="row-fluid">
          <div class="span12">
            <div class="head clearfix">
                <div class="isw-right_circle"></div>
                <h1>By Geo</h1>
            </div>
            <div class="block"><div id="chart-22" style="height: 700px;"></div></div>
        </div>
       </div> 
       <div class="row-fluid">
        <div class="span12">
         <div class="head clearfix">
                <div class="isw-right_circle"></div>
                <h1>By Sectors</h1>
            </div>
            <div class="block">
            <div id="chart-33" style="height: 700px;">

            </div>
        </div>	
    </div>                         
</div>           
    </div>
</div>
