<style type="text/css">
.img-polaroid{
	height:80px !important;
}
</style>
<div class="content">
	<?=$this->load->view("includes/_bread")?>
    
            <div class="workplace">
			<div class="row-fluid">
                <?=$this->load->view('_company_navigation')?>
                </div>   
                         
                <div class="page-header">
                    <h2><?=$query['name_en'].'/&nbsp;'.$query['name_ar']?></h2>
                </div>  
                <div class="row-fluid">

                    <div class="span12">                    
                        <div class="head clearfix">
                            <div class="isw-grid"></div>
                            <h1>Sponsors &nbsp;&nbsp; 
                            	<div style="float:right !important; margin-right:10px;">الشركات الراعية</div>
                            </h1> 
                            <?php //_show_add('companies/production-create/'.$query['id'],'Add New',TRUE)?>                
                        </div>
                       
                            <div class="block gallery clearfix">
                <?php foreach($items as $item){ ?>
                <a class="fancybox" rel="group" href="<?=base_url().$item->logo?>">
                    <img src="<?=base_url().$item->logo?>" class="img-polaroid"/></a>
                    <?php } ?>
         
                        </div>
                    </div>                                
                </div>
                            
           <div class="dr"><span></span></div>           
         </div>
        </div>
