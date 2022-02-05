<!DOCTYPE html>
<html lang="en">
<?=$this->load->view("admin/includes/_head");?>

<body>
<div class="wrapper">
	<?=$this->load->view("admin/includes/_header");?>
    <?=$this->load->view("admin/includes/_left");?>
    <?=$contents ?>
    <?=$this->load->view("admin/includes/_footer");?> 
</div>
</body>
</html>