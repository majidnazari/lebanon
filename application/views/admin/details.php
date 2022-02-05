<style type="text/css">
b{
	color:#3A600B;
}
</style>
<?=$this->load->view("admin/_menu");?>
<div class="display">   
    <h3><?=$query['title']." - ".$query['title_ar'];?></h3>
    <table cellspacing="5">
        <tr><td><b>Location</b></td><td rowspan="13" width="20">&nbsp;</td>
        <td><?=$query['city'].", ".$query['country'];?></td></tr>
        <tr><td><b>Category</b></td><td><?=$query['category'];?></td></tr>
        <tr><td><b>Gender</b></td><td><?=$query['gender'];?></td></tr>
        <tr><td><b>Employee Type</b></td><td><?=$query['employee_type'];?></td></tr>
        <tr><td><b>Job Duration</b></td><td><?=$query['job_duration'];?></td></tr>
        <tr><td><b>Salary</b></td><td><?=$query['salary'];?>$</td></tr>
        <tr><td><b>Job Duration</b></td><td><?=$query['job_duration'];?></td></tr>
        <tr><td><b>Status</b></td><td><?=$query['status'];?></td></tr>
        <tr><td><b>Create Time</b></td><td><?=$query['create_time'];?></td></tr>
        <tr><td><b>Description</b></td><td><?=$query['description'];?></td></tr>
        <tr><td><b>Arabic Description</b></td><td><?=$query['description_ar'];?></td></tr>
        <tr><td><b>Skills</b></td><td><?=$query['skills'];?></td></tr>
        <tr><td><b>Arabic Skills</b></td><td><?=$query['skills_ar'];?></td></tr>
    </table>
</div>