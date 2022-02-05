<?php

$from = array(
	'name'	=> 'from',
	'id'	=> 'from',
	'value' => $from,
);
$to = array(
	'name'	=> 'to',
	'id'	=> 'to',
	'value' => $to,
);
if($done_visa!=0){
	$Done_v=($done_visa*100)/($done_visa+$pending_visa);
}
else{
	$Done_v=0;
	}
if($pending_visa!=0){	
	$Pending_v=($pending_visa*100)/($done_visa+$pending_visa);
}
else{
	$Pending_v=0;
	}
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
        	        
	//for( var i = 0; i < 5; i++)	
		data[0] = { label: "Completed Visa", data: Math.floor(<?=$Done_v?>)+1 };
		data[1] = { label: "Pending Visa", data: Math.floor(<?=$Pending_v?>)+1 };
	

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
                    <div class="span3">From:<br /><?php echo form_input($from); ?> <span>yyyy-mm-dd</span></div>
                    <div class="span3">To:<br /><?php echo form_input($to); ?> <span>yyyy-mm-dd</span></div>
                    <div class="span3"><br />
                        <input type="submit" name="search" value="Search" class="btn">
                    </div>                                                                                                              
              </div>
             </div>
             <?=form_close();?> 
        </div> 
       <div class="span6">
                        <div class="head clearfix">
                            <div class="isw-right_circle"></div>
                            <h1>Pending Visa : <?=$pending_visa;?> &nbsp;&nbsp;-&nbsp;Completed Visa :  <?=$done_visa?></h1>
                        </div>
                        <div class="block">
                            <div id="chart-3" style="height: 300px;">

                            </div>
                        </div>
                    </div>                                
                </div>                   
	<?php if(count($query)){ ?>
     <div class="row-fluid">

        <div class="span12">
            <div class="head clearfix">
                <div class="isw-grid"></div>
                <h1><?=$search_title;?></h1>
            </div>
			<div class="row-fluid">
                    <div class="span12">                    
                        <div class="block-fluid">
                            <table cellpadding="0" cellspacing="0" width="100%" class="table">
                                <thead>
                                    <tr>                                    
                                        <th width="80%">Class Schedules</th>
                                        <th width="10%">Date</th>
                                        <th width="10%">Location</th>
                                        <th width="10%">Visa</th>                                   
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($query as $row){ ?>
                                    <tr>                                    
                                        <td><?=$row->course?></td>
                                        <td><?=$row->start_date." to ".$row->end_date?></td>
                                        <td><?=$row->country.' - '.$row->city?></td>
                                        <td><?=$row->visa?></td>                                   
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