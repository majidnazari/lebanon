<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
	<title>jQuery Calculation Plug-in</title>

	<!---// load jQuery v1.3.1 from the GoogleAPIs CDN //--->
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>

	<!--// load jQuery Plug-ins //-->
	<script type="text/javascript" src="<?=base_url()?>js/jquery.field.js"></script>
	<script type="text/javascript" src="<?=base_url()?>js/jquery.calculation.js"></script>

	<script type="text/javascript">
	var bIsFirebugReady = (!!window.console && !!window.console.log);

	$(document).ready(
		function (){
			// update the plug-in version
			$("#idPluginVersion").text($.Calculation.version);

/*			
			$.Calculation.setDefaults({
				onParseError: function(){
					this.css("backgroundColor", "#cc0000")
				}
				, onParseClear: function (){
					this.css("backgroundColor", "");
				}
			});
*/
			
			// bind the recalc function to the quantity fields
			$("input[name^=qty_item_]").bind("keyup", recalc);
			// run the calculation function now
			recalc();

			// automatically update the "#totalSum" field every time
			// the values are changes via the keyup event
			$("input[name^=sum]").sum("keyup", "#totalSum");
			
			// automatically update the "#totalAvg" field every time
			// the values are changes via the keyup event

			// this calculates the sum for some text nodes
			$("#idTotalTextSum").click(
				function (){
					// get the sum of the elements
					var sum = $(".textSum").sum();

					// update the total
					$("#totalTextSum").text("$" + sum.toString());
				}
			);

			// this calculates the average for some text nodes

		}
	);
	
	function recalc(){
		$("[id^=total_item]").calc(
			// the equation to use for the calculation

			// define the formatting callback, the results of the calculation are passed to this function

			// define the finish callback, this runs after the calculation has been complete
			function ($this){
				// sum the total of the $("[id^=total_item]") selector
				var sum = $this.sum();
				
				$("#grandTotal").text(
					// round the results to 2 digits
					"$" + sum.toFixed(2)
				);
			}
		);
	}
	</script>

	<style type="text/css">
		#testForm {
			width: 800px;
		}

		code {
			background-color: #e0e0e0;
		}

		#formContent p {
			clear: both;
			min-height: 20px;
		}

		#idCheckboxMsg{
			color: red;
			font-weight: bold;
		}

		#totalTextSum,
		.textSum,
		#totalTextAvg,
		.textAvg {
			border: 1px solid black;
			padding: 2px;
		}
	</style>

</head>
<body>


		<legend>Calculation Examples</legend>
		<div id="formContent">



				Numbers:
				<input type="text" name="sum1" value="3" size="2" />
				<input type="text" name="sum2" value="6" size="2" />
				<input type="text" name="sum3" value="1" size="2" />
				<input type="text" name="sum4" value="4" size="2" />
				&nbsp;&nbsp;
				Sum:
				<input type="text" name="totalSum" id="totalSum" value="" size="2" readonly />
				(Change the values for dynamic calculations.)
		

			
		</div>
	


</body>
</html>