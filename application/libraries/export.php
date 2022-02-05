<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
* Excel library for Code Igniter applications
*/
class Export{
    
    function to_excel($array, $filename,$lenght) {
        header('Content-type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8');
        header('Content-Disposition: attachment; filename='.$filename.'.xls');
		header('Pragma: no-cache');
		header('Expires: 0');
		//header('Content-Type: text/xml,  charset=UTF-8; encoding=UTF-8');

        // Filter all keys, they'll be table headers
        $h = array();
		echo '<table  style="border:1px solid #000; border-collapse:collapse">';
		for($i=0;$i<count($array);$i++){
			echo '<tr  style="border:1px solid #000; border-collapse:collapse">';
			for($j=0;$j<$lenght;$j++){
			if($i==0){
					echo '<th  style="border:1px solid #000; border-collapse:collapse" >'.ucwords($array[$i][$j]).'</th>';	
					}
				else{
					echo '<td  style="border:1px solid #000; border-collapse:collapse">'.ucwords($array[$i][$j]).'</td>';
					}		
				}
			echo '</tr>';		
			}
		echo '</table>';
	}
	 function cleanData(&$str)
	 { 
		$str = preg_replace("/\t/", "\\t", $str);
		$str = preg_replace("/\r?\n/", "\\n", $str);
		if(strstr($str, '"'))
		$str = '"' . str_replace('"', '""', $str) . '"';
	} 
	 function Excel($data,$name)
	 { 
		// filename for download
		$filename =  $name. ".xls";
		header("Content-Disposition: attachment; filename=\"$filename\"");
		header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
		header('Content-type: text/plain; charset=UTF-8');  
		$flag = false;
		foreach($data as $row) {
				if(!$flag) { // display field/column names as first row
					echo implode("\t", array_keys($row)) . "\r\n";
					$flag = true;
				}
				//array_walk($row, 'cleanData');
				
				echo implode("\t", array_values($row)) . "\r\n";
			}
			//return $filename;
			exit;
	 }
       /*
	    foreach($array->result_array() as $row){
            foreach($row as $key=>$val){
                if(!in_array($key, $h)){
                 $h[] = $key;   
                }
                }
                }
                //echo the entire table headers
                echo '<table><tr>';
                foreach($h as $key) {
                    $key = ucwords($key);
                    echo '<th>'.$key.'</th>';
                }
                echo '</tr>';
                
                foreach($array->result_array() as $row){
                     echo '<tr>';
                    foreach($row as $val)
                         $this->writeRow($val);   
                }
                echo '</tr>';
                echo '</table>';
                
            
        }
    function writeRow($val) {
                echo '<td>'.utf8_decode($val).'</td>';              
    }
	*/

}
?>