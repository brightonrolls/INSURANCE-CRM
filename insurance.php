<?php $page='insurance';  include('db.php'); include('header.php');?>

	<div class="container-fluid">
<p>
<form class="form-inline" name="policy_form" onsubmit="get_policy(this); return false;">
<input type="hidden" name="task" value="find_policy" />
<div class="form-group">
<label for="start_date">FROM</label>
<input class="form-control" type="date" id="start_date" name="start_date" />
</div>
<div class="form-group">
<label for="end_date">TO</label>
<input class="form-control" type="date" id="end_date" name="end_date" />
</div>
<div class="form-group">
<div class="input-group">
<input class="form-control" type="text" id="policy_number" placeholder="Policy Number" name="policy_number" />
<span class="input-group-btn">
 <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> FIND</button>
 </span>
</div>
</div>
<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#more_filters">
 MORE FILTERS
</button>
</p>
  <div class="collapse" id="more_filters">
  <div class="well well-sm">
  <div class="form-group form-group-sm">
  <select class="form-control" name="business_type" >
  <option value="">BUSINESS TYPE</option>
  <option value="new">NEW</option>
  <option value="renew">RENEWAL</option>
  <option value="rollover">ROLLOVER</option>
  <option value="other">OTHER</option>
  </select>
  </div>
    <div class="form-group form-group-sm">
  <select class="form-control" name="company" >
  <option value="">SELECT COMPANY</option>
  <option value="bajaj">BAJAJ ALLIANZE</option>
  <option value="bharti">BHARTI AXA</option>
  <option value="new_india">NEW INDIA</option>
  <option value="national">NATIONAL</option>
  <option value="united">UNITED</option>
  <option value="icici">ICICI LOMBARD</option>
  <option value="kotak">KOTAK</option>
  <option value="oriental">ORIENTAL</option>
  <option value="other">OTHER</option>
  </select>
  </div>
  </div>
</div>
</form>



<div class="panel panel-default">
<table class="table table-hover table-condensed">
<thead><tr>
<th>POLICY NUMBER</th>
<th>POLICY TYPE</th>
<th>BUSINESS TYPE</th>
<th>COMPANY</th>
<th>PREMIUM</th>
<th>EXPIRY DATE</th>
</thead>
<tbody id="policy_list">

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
	  function get_policy(e) {		
          $.ajax({
            type: 'post',
            url: 'ajax.php',
			dataType:'JSON',
            data: $(e).serialize(),
            success: function (result) {
				html='';
				result_table=document.getElementById('policy_list');
				if (result.length==0)
				{}
					else
					{
					
				for (i in result) {
				html=html+'<tr><td><a href="view_policy.php?id='+result[i].id+'">'+result[i].policy_number+'</a></td><td>'+result[i].policy_type+'</td><td>'+result[i].business_type+'</td><td>'+result[i].company+'</td><td>'+result[i].premium+'</td><td>'+formatDate(result[i].expiry_date)+'</td><td></tr>';
			 }
			 
			 
				}
				
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