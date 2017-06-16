<?php $page=''; include('db.php'); include('header.php');
$policy_html='';

$rows=$db->select('insurance_data t1',null,'t1.policy_number,t1.id iid,vehicle_data.id vid,vehicle_data.customer_name',null,"INNER JOIN vehicle_data on t1.chassis=vehicle_data.chassis WHERE expiry_date=CURDATE()");
if (count($rows)>0) {
for ($i=0; $i<count($rows); $i++) {
	
$policy_html.='<a href="view_policy.php?id='.$rows[$i]['iid'].'" class="list-group-item"><b>'.$rows[$i]['customer_name'].'</b> - '.$rows[$i]['policy_number'].'</a>';
}
}



?>

<div class="container-fluid">

<div class="row">



<div class="col-md-9">
<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">INSURANCE EXPIRING TODAY</div>


  <!-- List group -->
  <div class="list-group">
    <?=$policy_html?>
  </div>
</div>
</div>

</div>
</div>


<?php include('footer.php'); ?>