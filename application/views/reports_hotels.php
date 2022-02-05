<?php

$from_array = array(
	'name'	=> 'from',
	'id'	=> 'from',
	'value' => $from,
);
$to_array = array(
	'name'	=> 'to',
	'id'	=> 'to',
	'value' => $to,
);
if($city_id=='')
$city_id=0;
$class_country=' class="validate[required]" id="country_id" onchange="getcity(this.value,'.$city_id.')"';

?>

<script language="javascript">
jQuery(function($){
   $("#from").mask("9999-99-99");
   $("#to").mask("9999-99-99");
});

function getcity(country_id,city_id,hotel_id)
		{
			$("#datacities").html("loading ... ");
			$.ajax({
				url: "<?php echo base_url();?>countries/GetCities",
				type: "post",
				data: "id="+country_id+"&city_id="+city_id+"&hotel_id="+hotel_id,
				success: function(result){
					$("#datacities").html(result);
				}
			});
		}
		
		function gethotels(city_id,hotel_id)
		{
			$("#datahotels").html("loading ... ");
			$.ajax({
				url: "<?php echo base_url();?>countries/GetHotels",
				type: "post",
				data: "id="+city_id+"&hotel_id="+hotel_id,
				success: function(result){
					$("#datahotels").html(result);
				}
			});
		}	

</script>
<script language="javascript">
$(document).ready(function(){
    
     
    
 
    if($("#chart-3").length > 0){
        
        var data = [];
		<?php 
		$i=0;
		$total_schedule=0;
		foreach($counts as $count){ 
		$total_schedule=$total_schedule+$count->schedule_count;
		?>
       	data[<?=$i?>] = { label: "<?=$count->hotel?>", data: Math.floor(<?=$count->schedule_count?>*100)+1 };
		<?php 
		$i++;
		} ?>	        

        $.plot($("#chart-3"), data, 
	{
            series: {
                pie: { show: true }
            },
            legend: { show: false }
	});

    }

 
    function update() {
        plot.setData([ getRandomData() ]);
        // since the axes don't change, we don't need to call plot.setupGrid()
        plot.draw();

        setTimeout(update, updateInterval);
    }

    function getRandomData() {
        if (data.length > 0)
            data = data.slice(1);

        // do a random walk
        while (data.length < totalPoints) {
            var prev = data.length > 0 ? data[data.length - 1] : 50;
            var y = prev + Math.random() * 10 - 5;
            if (y < 0)
                y = 0;
            if (y > 100)
                y = 100;
            data.push(y);
        }

        // zip the generated y values with the x values
        var res = [];
        for (var i = 0; i < data.length; ++i)
            res.push([i, data[i]])
        return res;
    }

    function showTooltip(x, y, contents) {
        $('<div class="ct">' + contents + '</div>').css( {
            position: 'absolute',
            display: 'none',
            top: y,
            left: x + 10,
            border: '2px solid #333',
            padding: '2px',
            'background-color': '#ffffff',
            'border-radius': '2px',
            color: '#333'            
        }).appendTo("body").fadeIn(200);
    }    

    var previousPoint = null;
    
    $("#chart-1").bind("plothover", function (event, pos, item) {
        
        $("#x").text(pos.x.toFixed(2));
        $("#y").text(pos.y.toFixed(2));

        if (item) {
            if (previousPoint != item.dataIndex) {
                previousPoint = item.dataIndex;

                $(".ct").remove();
                var x = item.datapoint[0].toFixed(2),
                    y = item.datapoint[1].toFixed(2);

                showTooltip(item.pageX, item.pageY,
                            item.series.label + " of " + x + " = " + y);
            }
        }else {
            $(".ct").remove();
            previousPoint = null;            
        }

    });

    $(".mChartBar").sparkline('html',{ enableTagOptions: true });    
    
});


</script>
<div class="content">
   <?=$this->load->view("includes/_bread")?>    
<div class="workplace">
   <div class="row-fluid">                
        <div class="span6">
            <div class="head clearfix">
                <div class="isw-brush"></div>
                <h1>Search</h1>
            </div>
            <?=form_open('',array('method'=>'get'));?>
            <div class="block"> 
            <div class="row-form clearfix"> 
            		<div class="span6">Country:<br><?php 
								$array_countries['']='Please Select a Country';
								foreach($countries as $country)
								{
									if($country->id!=0)
									$array_countries[$country->id]=$country->country;	
								}
											
								echo form_dropdown('country_id',$array_countries,$country_id,$class_country);
							?>
                        </div>
                        <div class="span6">City:<br>
                            <div id="datacities">
                                <?php if(count($cities_data)) {
                                    $data_city['']='Please Select a City';
                                    foreach($cities_data as $city_data)
                                    {
                                        if($city_data->id!=0)
                                        $data_city[$city_data->id]=$city_data->city;	
                                    }
                                                
                                    echo form_dropdown('city_id',$data_city,$city_id);
                                    }
                                    else{
                                        $data_city['']='Please Select a Country First';
                                        echo form_dropdown('city_id',$data_city,$city_id);
                                        }
                                ?>
                            </div>
                        </div>    
                       <div class="span12">Hotel-Meeting Room <br>
                            <div id="datahotels">
                            <?php if(count($hotels_data)) {
                                        $data_hotels['']='Please Select a Hotel';
                                        foreach($hotels_data as $hotel_data)
                                        {
                                            if($hotel_data->id!=0)
                                            $data_hotels[$hotel_data->id]=$hotel_data->name;	
                                        }
                                                    
                                        echo form_dropdown('hotel_meeting_id',$data_hotels,$hotel_meeting_id);
                                        }
                                        else{
                                            $data_hotels['']='Please Select a City First';
                                            echo form_dropdown('hotel_meeting_id',$data_hotels,$hotel_meeting_id);
                                            }
                                    ?>
                             </div>
                      </div>      
                    <div class="span5">From:<br /><?php echo form_input($from_array); ?> <span>yyyy-mm-dd</span></div>
                    <div class="span5">To:<br /><?php echo form_input($to_array); ?> <span>yyyy-mm-dd</span></div>
                    <div class="span2"><br />
                        <input type="submit" name="search" value="Search" class="btn">
                    </div>                                                                                                              
              </div>
             </div>
             <?=form_close();?> 
        </div> 
		<div class="span6">
                 <div class="head clearfix">
                <div class="isw-right_circle"></div>
                <h1>Distribution Biding Class Schedules : <?=$total_schedule?> Classe(s) Schedule(s) </h1>
            </div>
            <div class="block">
                <div id="chart-3" style="height: 300px;">

                </div>
            </div>
        </div>                           
	<?php if(count($query)){ ?>
     <div class="row-fluid">

        <div class="span12">
            <div class="head clearfix">
                <div class="isw-grid"></div>
                <h1><?=$search_title;?></h1>
                <div style="float:right;"><?='<h1>'.anchor('reports/export_schedules_to_excel/from/'.$from.'/to/'.$to,'Export To Excel').'</h1>'?></div>
            </div>
			<div class="row-fluid">
                    <div class="span12">                    
                        <div class="block-fluid">
                            <table cellpadding="0" cellspacing="0" width="100%" class="table">
                                <thead>
                                    <tr>                                    
                                        <th width="40%">Class Schedules</th>
                                        <th width="20%">Date</th>
                                        <th width="20%">Location</th>
                                        <th width="10%">Category</th>
                                        <th width="10%">Status</th>                                   
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($query as $row){ 
								if($row->category_id==1){
									$style="style='background:#F00 !important; color:#FFF !important'";
									}
								else{
									$style="";
									}	
								?>
                                    <tr>                                    
                                        <td><?=$row->course?></td>
                                        <td><?=$row->start_date.' to '.$row->end_date?></td>
                                        <td><?=$row->city.' - '.$row->country?></td>
                                        <td><?=$row->category?></td>
                                        <td><?=$row->status?></td>                                   
                                    </tr>
                                 <?php } ?>   
                                </tbody>
                            </table>
                        </div>
                    </div>                                
                </div>            
                        
        </div>

    </div>    
   <?php } ?>         
</div>
</div>