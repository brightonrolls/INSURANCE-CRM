<?php $page='renewals';  include('db.php'); include('header.php');
$sn=0;
$count['followup']=0;
$count['policy_done']=0;
$count['policy_pending']=0;
$count['lost']=0;
$count[null]=0;
$policy_html='';
$row_class=array("followup"=>"warning", "policy_done"=>"success", "policy_pending"=>"info", "lost"=>"danger", null=>null);

$rows=$db->select('insurance_data t1',null,'t1.business_type,t1.company,t1.expiry_date,t1.policy_number,t1.id iid,vehicle_data.id vid,vehicle_data.customer_name,vehicle_data.customer_number',null,"INNER JOIN vehicle_data on t1.chassis=vehicle_data.chassis WHERE expiry_date=(select MAX(t2.expiry_date) from insurance_data t2 WHERE t1.chassis=t2.chassis AND MONTH(t2.expiry_date)=MONTH(now()) AND YEAR(t2.expiry_date)<=YEAR(now())) ORDER BY DAY(t1.expiry_date) ASC");
for ($i=0; $i<count($rows); $i++) {
	$sn++;
	$p_n=$rows[$i]['policy_number'];
	$status_row=$db->select('followup_data',"policy_number='$p_n' AND YEAR(create_date)=YEAR(now())",'status','id DESC',' LIMIT 1');
	if ($status_row)
	{$status=$status_row[0]['status'];}
	else {$status=null;}
	
	$count[$status]++;
	$date=date_create($rows[$i]['expiry_date']);
	$expiry_date=date_format($date,"d-F-Y");
	$policy_html.='<tr class="'.$row_class[$status].'"><td>'.$sn.'</td><td>'.$expiry_date.'</td><td>'.$status.'</td><td><a href="view_policy.php?id='.$rows[$i]['iid'].'">'.$rows[$i]['policy_number'].'</a></td><td>'.$rows[$i]['company'].'</td><td>'.$rows[$i]['customer_name'].'</td><td>'.$rows[$i]['customer_number'].'</td></tr>';
}

?>

	<div class="container-fluid">
	<div class="row">
	

<div class="col-md-2">
<div class="form-group">
<form name="filter_date_form" id="filter_date_form" class="form-inline">
<input type="hidden" name="task" value="filter_policy"/>
<input type="hidden" name="m" value=""/>
<input type="hidden" name="y" value=""/>

<div class="input-group ">
  <span class="input-group-btn">
   <button type="button" class="btn btn-default" onclick="prev_month();"><span class="glyphicon glyphicon-chevron-left"></span></button>
   <button type="button" class="btn btn-default"  onclick="next_month();"><span class="glyphicon glyphicon-chevron-right"></span></button>
   </span>
   
    <label  class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span> <span id="current_period"><?=date("F Y")?></span></label>
  </div>
  
  </form>
  </div>
</div>

<div class="col-md-10">
  <div class="progress">
  <div id="done_count" class="progress-bar progress-bar-success" style="width:<?=$count['policy_done']*100/count($rows).'%'?>">
   <?=round($count['policy_done']*100/count($rows)).'%'?>
  </div>
    <div id="pending_count" class="progress-bar progress-bar-info" style="width:<?=$count['policy_pending']*100/count($rows).'%'?>">
    <?=round($count['policy_pending']*100/count($rows)).'%'?>
  </div>
  <div id="followup_count" class="progress-bar progress-bar-warning" style="width:<?=$count['followup']*100/count($rows).'%'?>">
   <?=round($count['followup']*100/count($rows)).'%'?>
  </div>
  <div id="lost_count" class="progress-bar progress-bar-danger" style="width:<?=$count['lost']*100/count($rows).'%'?>">
   <?=round($count['lost']*100/count($rows)).'%'?>
  </div>
</div>

</div>

</div>


<div class="panel panel-default">
<table class="table table-hover table-condensed">
<thead><tr><th>#</th><th>EXPIRY DATE</th><th>STATUS</th><th>POLICY NUMBER</th><th>COMPANY</th><th>CUSTOMER NAME</th><th>MOBILE NUMBER</th></thead>
<tbody id="policy_list">
<?=$policy_html?>
</tbody>
</table>
</div>

</div>

	
<script>
function formatDate(date) {
  var monthNames = [
    "January", "February", "March",
    "April", "May", "June", "July",
    "August", "September", "October",
    "November", "December"
  ];
	var d = new Date(date);
  var day = d.getDate();
  if (day<=9) {day='0'+day;}
  var monthIndex = d.getMonth();
  var year = d.getFullYear();

  return day + '-' + monthNames[monthIndex] + '-' + year;
}



      //filter policy
	  result_table=document.getElementById('policy_list');
	  function get_policy(e) {
		row_class={followup:"warning", policy_done:"success", policy_pending:"info", lost:"danger"};
		count={followup:0, policy_done:0, policy_pending:0, lost:0};
		
		
          $.ajax({
            type: 'post',
            url: 'ajax.php',
			dataType:'JSON',
            data: $(e).serialize(),
            success: function (result) {
				sn=0;
				html='';
				var followup_count=0;
				var done_count=0;
				var pending_count=0;
				var 	lost_count=0;
				
				if (result.length==0)
				{}
					else
					{
					
				for (i in result) {
					sn++;
					count[result[i].status]++;
				html=html+'<tr class="'+row_class[result[i].status]+'"><td>'+sn+'</td><td>'+formatDate(result[i].expiry_date)+'</td><td>'+result[i].status+'</td><td><a href="view_policy.php?id='+result[i].iid+'">'+result[i].policy_number+'</a></td><td>'+result[i].company+'</td><td>'+result[i].customer_name+'</td><td>'+result[i].customer_number+'</td><td></tr>';
			 }
			 
			 followup_count=count["followup"]*100/result.length;
			 done_count=count["policy_done"]*100/result.length;
			 pending_count=count["policy_pending"]*100/result.length;
			 lost_count=count["lost"]*100/result.length;
			 
			 
				}
				
				//UPDATE PROGRESS BAR
			 document.getElementById("followup_count").style.width =followup_count+'%';
			 document.getElementById("done_count").style.width = done_count+'%';
			 document.getElementById("pending_count").style.width = pending_count+'%';
			 document.getElementById("lost_count").style.width = lost_count+'%';
			 
			 document.getElementById("followup_count").innerHTML =Math.round(followup_count)+'%';
			 document.getElementById("done_count").innerHTML = Math.round(done_count)+'%';
			 document.getElementById("pending_count").innerHTML = Math.round(pending_count)+'%';
			 document.getElementById("lost_count").innerHTML = Math.round(lost_count)+'%';
				$(result_table).html(html);
            }
          });

        }
		

		
		//previous month policy filter
		var monthNames = ["January", "February", "March", "April", "May", "June",
  "July", "August", "September", "October", "November", "December"
];
		m=<?=date("m")?>;
		mn=m-1;
		y=<?=date("Y")?>;
		function prev_month() {
			m=m-1;
			mn=mn-1;
			if (m==0) {
				m=12;
				mn=11;
				y=y-1;
			}
			
			
		filter_date_form.y.value=y;
		filter_date_form.m.value=m;
		get_policy(filter_date_form);
		document.getElementById("current_period").innerHTML=monthNames[mn]+' '+y;
		
        }
		//next month policy filter
		function next_month() {
			m=m+1;
			mn=mn+1;
			if (m==13) {
				m=1;
				mn=0;
				y=y+1;
			}
		filter_date_form.y.value=y;
		filter_date_form.m.value=m;
		get_policy(filter_date_form);
		document.getElementById("current_period").innerHTML=monthNames[mn]+' '+y;
		}
	  
</script>

<?php include('footer.php'); ?>