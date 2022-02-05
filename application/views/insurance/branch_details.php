<style type="text/css">
select{
	direction:rtl !important;
	}
.label-ar{
	text-align:right !important;
	font-size:15px;
	font-weight:bold;
}	
.txt-ar{
	text-align:right !important;
	font-size:15px;
}	
.row-form {
	padding:5px 10px !important;
}
</style>

<div class="content">
   <?=$this->load->view("includes/_bread")?>  

    <div class="workplace">
        <div class="page-header">
            <h1><?=$subtitle?></h1>
        </div> 
		               
        <div class="row-fluid">
        <div class="span9">
                 <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1>Branch Info</h1>
                    <h1 style="float:right; margin-right:10px"> عنوان الفرع</h1>
                </div>            
				<div class="block-fluid">
                    <div class="row-form clearfix">    
                    	<div class="span1">Name : </div>
                        <div class="span5"><?php echo $row['name_en']; ?></div>
                        <div class="span5 txt-ar"><?php echo $row['name_ar']; ?></div>
                        <div class="span1 label-ar"> :   الاسم</div>
                    </div>
                    <div class="row-form clearfix">
                        <div class="span3 txt-ar"><?=$row['area_ar']?></div>
                        <div class="span1 label-ar">البلدة</div>
                        <div class="span3 txt-ar"><?=$row['district_ar']?></div>
                        <div class="span1 label-ar">  القضاء</div>
                        <div class="span3 txt-ar"><?php echo $row['governorate_ar']; ?></div>
                        <div class="span1 label-ar"> المحافظة</div>
                    </div>  
                     <div class="row-form clearfix">    
                    	<div class="span1">Street : </div>
                        <div class="span5"><?php echo $row['street_en']; ?></div>
                        <div class="span5 txt-ar"><?php echo $row['street_ar']; ?></div>
                        <div class="span1 label-ar"> :   شارع</div>
                    </div>
                    <div class="row-form clearfix">    
                    	<div class="span1">Beside : </div>
                        <div class="span5"><?php echo $row['beside_en']; ?></div>
                        <div class="span5 txt-ar"><?php echo $row['beside_ar']; ?></div>
                        <div class="span1 label-ar"> :   بالقرب</div>
                    </div>
                    <div class="row-form clearfix">    
                    	<div class="span1">Building: </div>
                        <div class="span5"><?php echo $row['bldg_en']; ?></div>
                        <div class="span5 txt-ar"><?php echo $row['bldg_ar']; ?></div>
                        <div class="span1 label-ar"> : ملك </div>
                    </div>      
					<div class="row-form clearfix">  
                    	<div class="span6"></div>                       
                        <div class="span5 txt-ar"><?php echo $row['phone']; ?></div>
                        <div class="span1 label-ar">: هاتف</div>
                    </div>             
					<div class="row-form clearfix">   
                    	<div class="span6"></div>                           
                        <div class="span5 txt-ar"><?php echo $row['fax']; ?></div>
                        <div class="span1 label-ar">: فاكس </div>
                    </div>
                    <div class="row-form clearfix">    
                    	<div class="span2" >P.O. Box : </div>
                        <div class="span4"><?php echo $row['pobox_en']; ?></div>
                        <div class="span4 txt-ar"><?php echo $row['pobox_ar']; ?></div>
                        <div class="span2 label-ar"> : صندوق بريد </div>
                    </div> 
					<div class="row-form clearfix">    
                    	<div class="span6"></div>                    
                        <div class="span4 txt-ar"><?php echo $row['email']; ?></div>
                        <div class="span2 label-ar">: البريد الالكتروني </div>
                    </div>
 					<div class="row-form clearfix"> 
                    	<div class="span6"></div>                        
                        <div class="span4 txt-ar"><?php echo $row['website']; ?></div>    
                        <div class="span2 label-ar">: الموقع الالكتروني</div>
                    </div> 
					  
                                                           
                    </div>            
                  
            </div>
            <?=$this->load->view('insurance/_navigation')?>
    </div>
</div>