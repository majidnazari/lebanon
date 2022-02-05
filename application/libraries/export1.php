<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
* Excel library for Code Igniter applications
*/
class Export{
    
    function to_excel($array, $filename) {
        header('Content-type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8');
        header('Content-Disposition: attachment; filename='.$filename.'.xls');
		//header('Content-Type: text/xml,  charset=UTF-8; encoding=UTF-8');

        // Filter all keys, they'll be table headers
        $h = array();
		echo '<table>';
		for($i=0;$i<count($array);$i++){
			echo "<tr>";
			for($j=0;$j<4;$j++){
			if($i==0){
					echo '<th>'.ucwords($array[$i][$j]).'</th>';	
					}
				else{
					echo '<td>'.ucwords($array[$i][$j]).'</td>';
					}		
				}
			echo '</tr>';		
			}
		echo '</table>';
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