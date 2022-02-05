<?php
if(!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends Application {
    public function ipinfo($ip = NULL, $browser = NULL, $page = NULL, $purpose = "location", $deep_detect = TRUE) {

        $output = NULL;

        if(filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
            $ip = $_SERVER["REMOTE_ADDR"];
            if($deep_detect) {
                if(filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                if(filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
        }
        $purpose = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
        $support = array("country", "countrycode", "state", "region", "city", "location", "address");
        $continents = array(
                "AF" => "Africa",
                "AN" => "Antarctica",
                "AS" => "Asia",
                "EU" => "Europe",
                "OC" => "Australia (Oceania)",
                "NA" => "North America",
                "SA" => "South America"
        );
        if(filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
            $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));
            if(@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
                switch($purpose) {
                    case "location":
                        $output = array(
                                "city" => @$ipdat->geoplugin_city,
                                "state" => @$ipdat->geoplugin_regionName,
                                "country" => @$ipdat->geoplugin_countryName,
                                "country_code" => @$ipdat->geoplugin_countryCode,
                                "continent" => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                                "continent_code" => @$ipdat->geoplugin_continentCode,
                                "hostaddress" => gethostbyaddr($ip),
                                "browser" => $browser,
                                "referred" => @$_SERVER['HTTP_REFERER'],
                                "ip" => $ip,
                                "create_time" => $this->datetime,
                        );
                        break;
                    case "address":
                        $address = array($ipdat->geoplugin_countryName);
                        if(@strlen($ipdat->geoplugin_regionName) >= 1)
                            $address[] = $ipdat->geoplugin_regionName;
                        if(@strlen($ipdat->geoplugin_city) >= 1)
                            $address[] = $ipdat->geoplugin_city;
                        $output = implode(", ", array_reverse($address));
                        break;
                    case "city":
                        $output = @$ipdat->geoplugin_city;
                        break;
                    case "state":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "region":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "country":
                        $output = @$ipdat->geoplugin_countryName;
                        break;
                    case "countrycode":
                        $output = @$ipdat->geoplugin_countryCode;
                        break;
                }
            }
        }
        $id = $this->General->save('states_users', $output);
        $this->General->save('states_pages', array('states_id' => $id, 'page' => $page, 'create_time' => $this->datetime));
        $output['id'] = $id;
        return json_encode($output);
    }

    public function index($ip = '') {
        if($ip == '') {
            $ip = $this->input->post('ip');
            $browser = $this->input->post('browser');
            $page = $this->input->post('page');
        }
        else {

            $ip = $ip;
            $browser = '';
            $page = '';
        }
        //$ip = $_SERVER['REMOTE_ADDR'];
        $array = $this->ipinfo($ip, $browser, $page);
        echo $array;
        //var_dump($array);
    }

    public function edit() {
        $id = $this->input->post('id');
        $page = $this->input->post('page');
        if($id != '') {
            $this->General->save('states_pages', array('states_id' => $id, 'page' => $page, 'create_time' => $this->datetime));
            echo $page;
        }
    }

    public function mapp() {
        $this->load->view('mapp');
    }

}