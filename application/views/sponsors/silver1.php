
<style type="text/css">
.silver-sponsor{
    background: url("<?=base_url()?>img/intro-ar.jpg");
    height:854px;
    width:670px;
}    
.col1{
           margin-top: 32%;
           margin-right: 5%;
           width: 20%;
           height: 65%;
           float: right;
       }
        .col1-en{
           margin-top: 32%;
           margin-left: 8%;
           width: 20%;
           height: 65%;
           float: left;
       }
        .row1{
            width: 95%;
            height: 60px;
            background: white;
            clear: both;
            margin: auto;
            margin-bottom: 5px;

        }
        .col2{
            margin-right: 5%;
            margin-top: 28%;
            width: 16%;
            height: 70%;
            float: right;
        }
        .col2-en{
            margin-left: 3%;
            margin-top: 28%;
            width: 16%;
            height: 70%;
            float: left;
        }
        .row2{
            width: 100%;
            height: 50px;
            clear: both;
            margin: auto;
            margin-bottom: 2px;

        }
        .row3{
            width: 100%;
            clear: both;
            margin: auto;
            margin-bottom: 10px;
            text-align:center;
            color:black;
            font-size:15px;
            border-bottom:1px solid #D3D3D3;

        }
        .row3 a{
           
            color:black;
            text-decoration:none;
             font-family: arial,sans-serif;

        }
        .lang-link{
           
            color:black;
            text-decoration:none;
             font-family: arial,sans-serif;
             font-size:20px;
             font-weight:bold;

        }
        .lang-link1{
           
            color:black;
            text-decoration:none;
             font-family: arial,sans-serif;
             font-size:22px;
             font-weight:bold;

        }
        .photo{
            height: 100%;
            width: 100%;
            overflow: hidden;
            border:none !important;
            margin-top:0px !important;
        }
        .element-ar {
            display: inline-block;

            transform: skewY(-20deg);
            font-size: 1px;
            padding: 1px;
            color: white;
            margin-right: 5px;
            margin-left: 5px;
        }
        .element-en {
            display: inline-block;

            transform: skewY(20deg);
            font-size: 1px;
            padding: 1px;
            color: white;
            margin-right: 5px;
            margin-left: 5px;
        }
        .col-right{
            float:right;
            width:42%;
        }
        .col-left{
            float:left;
            width:42%;
        }
        .list-right{
             width: 100%;
            margin: 0px;
            padding: 0px;
            float:right;
        }
        .list-right li{
            width: 29%;
            margin: 1% 1%;
            display: inline-block;
            height: 100px;
            border-radius: 25px;
            background:white;
            overflow: hidden;
        }
        .list-left{
             width: 100%;
            margin: 0px;
            padding: 0px;
        }
        .list-left li{
            width: 29%;
            margin: 1% 1%;
            display: inline-block;
            height: 100px;
            border-radius: 25px;
            background:white;
            overflow: hidden;
        }
</style>
<div class="content">
	<?=$this->load->view("includes/_bread")?>
    <div class="workplace">
        
        <div class="row-fluid">
            <div class="12">
                    <div class="head clearfix">
                        <div class="isw-documents"></div>
                        <h1>Language</h1>
                    </div>
                    <div class="block-fluid">
                       <div class="row-form clearfix">
                            <div class="span3"><?php $array_language=array('ar'=>'Ar','en'=>'En');
            										echo form_dropdown('language',$array_language,@$language);?></div>
            										<div class="span9">
                <div class="silver-sponsor">
                    
                    <div class="col2">
                        
            <?php for($i=1;$i<=9;$i++){
                @$sponsors[$i]->position=$i;
                @$sponsors[$i]->category='silver';
            echo $this->load->view('sponsors/_sponsor_form',@$sponsors[$i]);
                $url='';
                if(@$sponsors[$i]->section=='external'){
                if(strpos($sponsors[$i]->website, 'http://') !== 0) {
                      $url= 'http://' . $sponsors[$i]->website;
                    } else {
                       $url= $sponsors[$i]->website;;
                    }
                }
                else{
                    if(@$sponsors[$i]->section_id=='')
                    {
                       $url='#'; 
                    }
                    else{
                    switch (@$sponsors[$i]->section) {
                        case "bank":
                            $link='bank-details/';
                            break;
                        case "company":
                            $link='industrial-details/';
                            break;
                        case "insurance":
                            $link='insurance-details/';
                            break;
                        case "importer":
                            $link='importer-details/';
                            break;
                        case "transportation":
                            $link='transportation-details/';
                            break;        
                        }
                        $url=base_url().$link.@$sponsors[$i]->section_id;
                    }
                }
                if(@$sponsors[$i]!='')
                {
                    echo '<a href="#SilverModal'.$i.'" data-toggle="modal"><div class="row2 element-ar"><img src="http://www.lebanon-industry.com/'.$sponsors[$i]->logo.'" class="photo" /></div></a>';
                }
                else{
                    echo '<a href="#SilverModal'.$i.'" data-toggle="modal"><div class="row2 element-ar"></div></a>';
                }
                
            }?>

           
        </div>
        <div class="col1">
            <?php for($i=1;$i<=9;$i++){
                $url='';
                if(@$sponsors[$i]->section=='external'){
                if(strpos($sponsors[$i]->website, 'http://') !== 0) {
                      $url= 'http://' . $sponsors[$i]->website;
                    } else {
                       $url= $sponsors[$i]->website;;
                    }
                }
                else{
                    if(@$sponsors[$i]->section_id=='')
                    {
                       $url='#'; 
                    }
                    else{
                    switch (@$sponsors[$i]->section) {
                        case "bank":
                            $link='bank-details/';
                            break;
                        case "company":
                            $link='industrial-details/';
                            break;
                        case "insurance":
                            $link='insurance-details/';
                            break;
                        case "importer":
                            $link='importer-details/';
                            break;
                        case "transportation":
                            $link='transportation-details/';
                            break;        
                        }
                        $url=base_url().$link.@$sponsors[$i]->section_id;
                    }
                }
                if(@$sponsors[$i]!='')
                {
                    echo '<a href="#SilverModal'.$i.'" data-toggle="modal"><div class="row2"><img src="http://www.lebanon-industry.com/'.$sponsors[$i]->logo.'" class="photo" /></div></a>';
                }
                else{
                    echo '<a href="#SilverModal'.$i.'" data-toggle="modal"><div class="row2"></div></a>';
                }
                @$sponsors[$i]->position=$i;
                @$sponsors[$i]->category='silver';
            echo $this->load->view('sponsors/_sponsor_form',@$sponsors[$i]);
            }?>
</div>
        </div>
                    </div>
                        </div>
                      </div>

                </div>
                 <div class="span9">
                <div class="silver-sponsor">
                    
                    <div class="col2">
                        
            <?php for($i=1;$i<=9;$i++){
                @$sponsors[$i]->position=$i;
                @$sponsors[$i]->category='silver';
            echo $this->load->view('sponsors/_sponsor_form',@$sponsors[$i]);
                $url='';
                if(@$sponsors[$i]->section=='external'){
                if(strpos($sponsors[$i]->website, 'http://') !== 0) {
                      $url= 'http://' . $sponsors[$i]->website;
                    } else {
                       $url= $sponsors[$i]->website;;
                    }
                }
                else{
                    if(@$sponsors[$i]->section_id=='')
                    {
                       $url='#'; 
                    }
                    else{
                    switch (@$sponsors[$i]->section) {
                        case "bank":
                            $link='bank-details/';
                            break;
                        case "company":
                            $link='industrial-details/';
                            break;
                        case "insurance":
                            $link='insurance-details/';
                            break;
                        case "importer":
                            $link='importer-details/';
                            break;
                        case "transportation":
                            $link='transportation-details/';
                            break;        
                        }
                        $url=base_url().$link.@$sponsors[$i]->section_id;
                    }
                }
                if(@$sponsors[$i]!='')
                {
                    echo '<a href="#SilverModal'.$i.'" data-toggle="modal"><div class="row2 element-ar"><img src="http://www.lebanon-industry.com/'.$sponsors[$i]->logo.'" class="photo" /></div></a>';
                }
                else{
                    echo '<a href="#SilverModal'.$i.'" data-toggle="modal"><div class="row2 element-ar"></div></a>';
                }
                
            }?>

           
        </div>
        <div class="col1">
            <?php for($i=1;$i<=9;$i++){
                $url='';
                if(@$sponsors[$i]->section=='external'){
                if(strpos($sponsors[$i]->website, 'http://') !== 0) {
                      $url= 'http://' . $sponsors[$i]->website;
                    } else {
                       $url= $sponsors[$i]->website;;
                    }
                }
                else{
                    if(@$sponsors[$i]->section_id=='')
                    {
                       $url='#'; 
                    }
                    else{
                    switch (@$sponsors[$i]->section) {
                        case "bank":
                            $link='bank-details/';
                            break;
                        case "company":
                            $link='industrial-details/';
                            break;
                        case "insurance":
                            $link='insurance-details/';
                            break;
                        case "importer":
                            $link='importer-details/';
                            break;
                        case "transportation":
                            $link='transportation-details/';
                            break;        
                        }
                        $url=base_url().$link.@$sponsors[$i]->section_id;
                    }
                }
                if(@$sponsors[$i]!='')
                {
                    echo '<a href="#SilverModal'.$i.'" data-toggle="modal"><div class="row2"><img src="http://www.lebanon-industry.com/'.$sponsors[$i]->logo.'" class="photo" /></div></a>';
                }
                else{
                    echo '<a href="#SilverModal'.$i.'" data-toggle="modal"><div class="row2"></div></a>';
                }
                @$sponsors[$i]->position=$i;
                @$sponsors[$i]->category='silver';
            echo $this->load->view('sponsors/_sponsor_form',@$sponsors[$i]);
            }?>
</div>
        </div>
                    </div>
                <div class="span9">
                           

            <?php if($msg!=''){ ?>
              	<div class="alert alert-success">               
                    <?php echo $msg;?>
                </div> 
                <?php } ?> 
                <div class="head clearfix">
                    <div class="isw-grid"></div>
                    <h1><?=$subtitle?></h1>
                </div>  
                <div class="block-fluid">   
               
                <div class="span9">
                <div class="silver-sponsor">
                    
                    <div class="col2">
                        
            <?php for($i=1;$i<=9;$i++){
                @$sponsors[$i]->position=$i;
                @$sponsors[$i]->category='silver';
            echo $this->load->view('sponsors/_sponsor_form',@$sponsors[$i]);
                $url='';
                if(@$sponsors[$i]->section=='external'){
                if(strpos($sponsors[$i]->website, 'http://') !== 0) {
                      $url= 'http://' . $sponsors[$i]->website;
                    } else {
                       $url= $sponsors[$i]->website;;
                    }
                }
                else{
                    if(@$sponsors[$i]->section_id=='')
                    {
                       $url='#'; 
                    }
                    else{
                    switch (@$sponsors[$i]->section) {
                        case "bank":
                            $link='bank-details/';
                            break;
                        case "company":
                            $link='industrial-details/';
                            break;
                        case "insurance":
                            $link='insurance-details/';
                            break;
                        case "importer":
                            $link='importer-details/';
                            break;
                        case "transportation":
                            $link='transportation-details/';
                            break;        
                        }
                        $url=base_url().$link.@$sponsors[$i]->section_id;
                    }
                }
                if(@$sponsors[$i]!='')
                {
                    echo '<a href="#SilverModal'.$i.'" data-toggle="modal"><div class="row2 element-ar"><img src="http://www.lebanon-industry.com/'.$sponsors[$i]->logo.'" class="photo" /></div></a>';
                }
                else{
                    echo '<a href="#SilverModal'.$i.'" data-toggle="modal"><div class="row2 element-ar"></div></a>';
                }
                
            }?>

           
        </div>
        <div class="col1">
            <?php for($i=1;$i<=9;$i++){
                $url='';
                if(@$sponsors[$i]->section=='external'){
                if(strpos($sponsors[$i]->website, 'http://') !== 0) {
                      $url= 'http://' . $sponsors[$i]->website;
                    } else {
                       $url= $sponsors[$i]->website;;
                    }
                }
                else{
                    if(@$sponsors[$i]->section_id=='')
                    {
                       $url='#'; 
                    }
                    else{
                    switch (@$sponsors[$i]->section) {
                        case "bank":
                            $link='bank-details/';
                            break;
                        case "company":
                            $link='industrial-details/';
                            break;
                        case "insurance":
                            $link='insurance-details/';
                            break;
                        case "importer":
                            $link='importer-details/';
                            break;
                        case "transportation":
                            $link='transportation-details/';
                            break;        
                        }
                        $url=base_url().$link.@$sponsors[$i]->section_id;
                    }
                }
                if(@$sponsors[$i]!='')
                {
                    echo '<a href="#SilverModal'.$i.'" data-toggle="modal"><div class="row2"><img src="http://www.lebanon-industry.com/'.$sponsors[$i]->logo.'" class="photo" /></div></a>';
                }
                else{
                    echo '<a href="#SilverModal'.$i.'" data-toggle="modal"><div class="row2"></div></a>';
                }
                @$sponsors[$i]->position=$i;
                @$sponsors[$i]->category='silver';
            echo $this->load->view('sponsors/_sponsor_form',@$sponsors[$i]);
            }?>
</div>
        </div>
                    </div>
                
            </div>                                
        </div> 

            </div>
             <div class="span3">
                    <div class="row-fluid">
                        
                </div>
                       
        <div class="dr"><span></span></div>            
    </div>
</div>
</div>
