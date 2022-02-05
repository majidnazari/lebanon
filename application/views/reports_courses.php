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

?>

<script language="javascript">
jQuery(function($){
   $("#from").mask("9999-99-99");
   $("#to").mask("9999-99-99");
});

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
       	data[<?=$i?>] = { label: "<?=$count->course?>", data: Math.floor(<?=$count->schedule_count?>*100)+1 };
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
            		<div class="span12">Courses:<br><?php 
								
								$array_course_group[0]='Please Select a Course';
								
							foreach($majors as $major){
								$array_courses=array();	
								foreach($courses as $course)
								{
									if($course->major_id==$major->id){
									$array_courses[$course->id]=$course->title;
									}
								}
							if(count($array_courses)){
							$array_course_group[$major->title]=$array_courses;	
							unset($array_courses);
							}
							
							}
											
								echo form_dropdown('course_id',$array_course_group,$course_id);
								
							?>
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