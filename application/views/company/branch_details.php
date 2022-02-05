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
.row-form{
	padding: 5px 16px !important;
	font-size:15px !important;	
}

</style>

<div class="content">
   <?=$this->load->view("includes/_bread")?>  
    <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'validation')); 
			echo form_hidden('company_id',$id);
	?>             
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
                    	<div class="span2">Name : </div>
                        <div class="span4"><?php echo $name_en; ?></div>
                        <div class="span4 txt-ar"><?php echo $name_ar; ?></div>
                        <div class="span2 label-ar"> :   الاسم</div>

                    </div>
                    <div class="row-form clearfix">
                    <div class="span2 txt-ar"><?=$areas['label_ar'];?></div>
                        <div class="span2 label-ar">: البلدة</div>
                   		<div class="span2 txt-ar"><?=$districts['label_ar']?></div>
                        <div class="span2 label-ar">:   القضاء</div>
					   	<div class="span2 txt-ar"><?=$governorates['label_ar'] ?></div>
                        <div class="span2 label-ar">:  المحافظة</div>
                     </div>  
                     <div class="row-form clearfix">    
                    	<div class="span2">Street : </div>
                        <div class="span4"><?php echo $street_en; ?></div>
                        <div class="span4 txt-ar"><?php echo $street_ar; ?></div>
                        <div class="span2 label-ar"> :   شارع</div>
                    </div>
                    
                    <div class="row-form clearfix">    
                    	<div class="span2">Building: </div>
                        <div class="span4"><?php echo $bldg_en; ?></div>
                        <div class="span4  txt-ar"><?php echo $bldg_ar; ?></div>
                        <div class="span2 label-ar"> : ملك </div>

                    </div>  
                    <div class="row-form clearfix">    
                    	<div class="span2">Manager : </div>
                        <div class="span4"><?php echo $beside_en; ?></div>
                        <div class="span4 txt-ar"><?php echo $beside_ar; ?></div>
                        <div class="span2 label-ar"> :   المدير</div>

                    </div>    
					<div class="row-form clearfix">  
                    	<div class="span4"></div>                       
                        <div class="span6  txt-ar"><?php echo $phone; ?></div>
                        <div class="span2 label-ar">: هاتف</div>
                    </div>             
					<div class="row-form clearfix">   
                    	<div class="span6"></div>                           
                        <div class="span4 txt-ar"><?php echo $fax; ?></div>
                        <div class="span2 label-ar">: فاكس </div>
                    </div>
                    <div class="row-form clearfix">    
                    	<div class="span2" >P.O. Box : </div>
                        <div class="span4"><?php echo $pobox_en; ?></div>
                        <div class="span4 txt-ar"><?php echo $pobox_ar; ?></div>
                        <div class="span2 label-ar"> : صندوق بريد </div>
                    </div> 
					<div class="row-form clearfix">    
                    	<div class="span6"></div>                    
                        <div class="span4"><?php echo $email; ?></div>
                        <div class="span2 label-ar">: البريد الالكتروني </div>
                    </div>
 					<div class="row-form clearfix"> 
                    	<div class="span6"></div>                        
                        <div class="span4 txt-ar"><?php echo $website; ?></div>    
                        <div class="span2 label-ar">: الموقع الالكتروني</div>
                    </div>
                    <?php /*
					 <div class="row-form clearfix">         
                     	<div class="span1">N-Location</div>                 
                        <div class="span4"><?php echo $x_location; ?></div>
                        <div class="span2"></div>
                        <div class="span1">E-Location</div>                 
                        <div class="span4"><?php echo $y_location; ?></div>    
                    </div>
 */?>
                    </div>            
                  
            </div>
           
            <?=$this->load->view('company/_navigation_branch')?>
            <?=$this->load->view('company/_navigation')?>
    </div>
    <?=form_close()?>
</div>