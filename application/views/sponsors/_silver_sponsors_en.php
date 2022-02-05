
<style type="text/css">
.silver-sponsor{
    background: url("<?=base_url()?>img/back-ar.jpg");
    height:673px;
    width:950px;
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
            background:#FFF;

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
            height: 80px;
            border-radius: 25px;
            background:white;
            overflow: hidden;
        }
        .list-left{
             width: 100%;
            margin: 0px;
            padding: 0px;
            margin-left:5%;
        }
        .list-left li{
            width: 29%;
            margin: 1% 1%;
            display: inline-block;
            height: 80px;
            border-radius: 25px;
            background:white;
            overflow: hidden;
        }
</style>
<div class="silver-sponsor">
    <div class="col-left">
        <ul class="list-left" style="margin-top:30%">
            <?php for($i=1;$i<=15;$i++){
                 @$sponsors[$i]->position=$i;
                @$sponsors[$i]->category='silver';
                @$sponsors[$i]->language=@$lang;
                
                if(@$sponsors[$i]->id!='')
                {
                    echo '<a href="#Modal'.$i.'" data-toggle="modal"><li><img src="http://www.lebanon-industry.com/'.$sponsors[$i]->logo.'" class="photo" /></li></a>';
                }
                else{
                    echo '<a href="#Modal'.$i.'" data-toggle="modal"><li></li></a>';
                }
                $sp['query']=$sponsors[$i];
                echo $this->load->view('sponsors/_sponsor_form',$sp);
                
    
            }?>

        </ul>
    </div>
    <div class="col-right">
        <ul class="list-right" style="margin-top:30%">
            <?php for($j=16;$j<=30;$j++){
                 @$sponsors[$j]->position=$j;
                @$sponsors[$j]->category='silver';
                @$sponsors[$j]->language=@$lang;
                
                 if(@$sponsors[$j]->id!='')
                {
                    echo '<a href="#Modal'.$j.'" data-toggle="modal"><li><img src="http://www.lebanon-industry.com/'.$sponsors[$j]->logo.'" class="photo" /></li></a>';
                }
                else{
                    echo '<a href="#Modal'.$j.'" data-toggle="modal"><li></li></a>';
                }
                $sp['query']=$sponsors[$j];
                echo $this->load->view('sponsors/_sponsor_form',$sp);

            }?>
        </ul>
    </div>
</div>

                
                    