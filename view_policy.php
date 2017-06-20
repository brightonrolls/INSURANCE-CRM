<?php include('db.php'); include('header.php'); ?>
<?php


//get policy data
if (isset($_GET["id"])) {$id=$_GET["id"];} else {die('id not set');}
$rows=$db->select('insurance_data',"id = '$id'");
if (count($rows)) {
$policy=$rows[0];
}
else {die('policy not found');}


//new expiry date
$new_expiry_date=$policy['expiry_date'];

//renew policy btn
if ($policy['new_policy_number']==null) {
$renew_policy='<button class="btn btn-link btn-xs" id="renew_policy_btn" data-toggle="modal" data-target="#renew_policy_modal">ADD</button>';
} else {
$new_policy_number=$policy['new_policy_number'];
$rows=$db->select('insurance_data',"policy_number = '$new_policy_number' LIMIT 1");
if (count($rows)) {
$renew_policy='<a href="view_policy.php?id='.$rows[0]['id'].'">'.$rows[0]['policy_number'].'</a>';
}
else {
$renew_policy=$new_policy_number;
}
}

//check for files
$d_policy='';
$q=$policy['policy_number'];
$rows=$db->select('upload',"document_name='$q'");
if (count($rows)) {$d_policy='<a href="download.php?id='.$rows[0]['id'].'&download=1"><span class="glyphicon glyphicon-download"></span></a>';}

//get vehicle data
$chassis=$policy['chassis'];
$rows=$db->select('vehicle_data',"chassis = '$chassis'");
if (count($rows)) {
$vehicle=$rows[0];
}
else {die('vehicle not found');}


// get comment list
$label_class=array("followup"=>"label-warning", "policy_done"=>"label-success", "policy_pending"=>"label-info", "lost"=>"label-danger", null=>null);
$comment_list_html='';
$policy_number=$policy['policy_number'];
$rows=$db->select('followup_data',"policy_number = '$policy_number' ORDER BY id DESC");
for ($i = 0; $i <count($rows); $i++) {
$date = date( 'd-m-Y', strtotime($rows[$i]['create_date']) );
$comment_list_html.='<li class="list-group-item "><span class="label '.$label_class[$rows[$i]['status']].'">'.$rows[$i]['status'].'</span><p class="list-group-item-text">'.$rows[$i]['remark'].'</p><p><small class="pull-right">'.$date.'</small></p></li>';
}
?>


<div class="container-fluid">

<div class="row">
<div class="col-md-1">

<p>
<a href="javascript:window.history.back();" class="btn btn-default">BACK</a>
</p></div>
<div class="col-md-7">
<div class="panel panel-default">
  <div class="panel-heading">INSURANCE DETAILS <span class="pull-right"><button type="button" onclick="disable_but();" class="btn btn-default btn-xs" data-toggle="button" aria-pressed="false" autocomplete="off"><span class="glyphicon glyphicon-edit"></span> EDIT</button></span></div>
  <div class="panel-body">

<div class="table-responsive">
 <table class="table table-bordered">
 <tr>
  <th>POLICY NUMBER</th>
   <th>POLICY TYPE</th>
    <th>COMPANY</th>
 <th>EXPIRY DATE</th>
 </tr>
 <tr>
 <td><span class="editable" id="policy_number" data-type="text" data-pk="<?=$policy['id']?>" data-url="ajax.php"><?=$policy['policy_number']?></span> <?=$d_policy?></td>
   <td><?=$policy['policy_type']?></td>
    <td><?=$policy['company']?></td>	
  <td><?=date( 'd-m-Y', strtotime($policy['expiry_date']))?></td>
</tr>

 </table>
 
</div>

<div class="row">
 
 <div class="col-md-6">
 <table class="table table-bordered">
  <thead><tr><th colspan="2">PREMIUM DETAILS</th></tr></thead>
 <tbody>
  <tr>
  <td>IDV</td><td>Rs.<span class="editable" id="idv" data-type="text" data-pk="<?=$policy['id']?>" data-url="ajax.php"><?=$policy['idv']?></span></td>
  </tr>
  <tr>
  <td>NCB</td><td><span class="editable" id="ncb" data-type="text" data-pk="<?=$policy['id']?>" data-url="ajax.php"><?=$policy['ncb']?></span>%</td>
  </tr>
  <tr>
  <td>DISCOUNT</td><td><span class="editable" id="discount" data-type="text" data-pk="<?=$policy['id']?>" data-url="ajax.php"><?=$policy['discount']?>%</span></td>
  </tr>
  <tr>
  <td>OD PREMIUM</td><td>Rs.<span class="editable" id="od" data-type="text" data-pk="<?=$policy['id']?>" data-url="ajax.php"><?=$policy['od']?></span></td>
  </tr>
  <tr>
  <td>TP PREMIUM</td><td>Rs.<span class="editable" id="tp" data-type="text" data-pk="<?=$policy['id']?>" data-url="ajax.php"><?=$policy['tp']?></span></td>
  </tr>
  <tr>
  <td>SERVICE TAX</td><td><span class="editable" id="st" data-type="text" data-pk="<?=$policy['id']?>" data-url="ajax.php"><?=$policy['st']?></span>%</td>
  </tr>
  <tr>
  <td>NET PREMIUM</td><td>Rs.<span class="editable" id="premium" data-type="text" data-pk="<?=$policy['id']?>" data-url="ajax.php"><?=$policy['premium']?></span></td>
  </tr>
  </tbody>
 </table>
</div>

<div class="col-md-6">
<table class="table table-bordered">
 <thead><tr><th colspan="2">CONTACT DETAILS</th></tr></thead>
 <tbody>
 <tr><td>REGISTRATION NO.</td><td><a data-toggle="modal" href="#vehicle_detail_modal"><?=$vehicle['registration_number']?></a></td></tr>
<tr><td>CUSTOMER NAME</td><td><?=$vehicle['customer_name']?></td></tr>
<tr><td>CUSTOMER NUMBER</td><td><?=$vehicle['customer_number']?></td></tr>
</tbody>
</table>

<table class="table table-bordered">
 <thead><tr><th colspan="2">BUSINESS DETAILS</th></tr></thead>
 <tbody>
 <tr><td>TYPE</td> <td><?=$policy['business_type']?></td></tr>
<tr><td>MONTH</td>
<td><span class="editable" data-viewformat="dd-mm-yyyy" id="business_month" data-type="date" data-pk="<?=$policy['id']?>" data-url="ajax.php">
<?=(strtotime($policy['business_month']))?date( 'd-m-Y', strtotime($policy['business_month'])):null?>
</span></td></tr>
<tr><td>RENEWED POLICY</td><td><?=$renew_policy?></td></tr>
</tbody>
</table>


 </div>
 
</div>

</div>
</div>
</div>
 
 <!--NEW INDIA PREMIUM CALCULATOR-->
 
<div class="col-md-4">
<form name="calculator_form" onsubmit="cal_premium(this); return false;">
<div class="panel panel-default">
  <div role="button" class="panel-heading" data-toggle="collapse" href="#calculator_panel">
  NEW INDIA PREMIUM CALCULATOR
  </div>
  <div id="calculator_panel" class="panel-collapse collapse" role="tabpanel">
  <div class="panel-body">
  
<div class="row">
<div class="col-md-5"> 
<div class="form-group form-group-sm">
<label for="calculator_idv">IDV</label>
<input id="calculator_idv" class="form-control" type="text" name="idv" value="<?=$policy['idv']?>" />
</div>
</div>
<div class="col-md-3">
<div class="form-group form-group-sm">
<label for="calculator_discount">DISCOUNT</label>
<input id="calculator_discount" class="form-control" type="text" name="discount" value="" />
</div>
</div>
<div class="col-md-4">
<div class="form-group form-group-sm">
<label for="calculator_ncb">NCB</label>
<select id="calculator_ncb" class="form-control" name="ncb">
<option value=''>SELECT</option>
<option value='20'>20%</option>
<option value='25'>25%</option>
<option value='35'>35%</option>
<option value='45'>45%</option>
<option value='50'>50%</option>
</select>
</div>
</div>
</div>
<div class="form-group form-group-sm">
  <button class="btn btn-default" type="submit">CALCULATE</button>
</div>
</div>
<div class="panel-footer">
<div class="input-group input-group-sm">
  <span class="input-group-btn">
  </span>
  <label class="input-group-addon" for="premium_normal">NORMAL</label>
  <input type="text" id="premium_normal" class="form-control" disabled>

  <label class="input-group-addon">0 DAP</label>
  <input id="premium_0dap" type="text" id="premium_0dap" class="form-control" disabled>

</div>


</form>
</div>
</div>

</div>



<!-- add comment form-->
<div class="panel panel-default">
  <div class="panel-heading">
  REMARKS
  </div>
  <div class="panel-body">
  
<form id="comment_form" name="comment_form" onsubmit="add_comment(this); return false;">
<input type="hidden" name="task" value="add_comment"/>
<input type="hidden" name="policy_number" value="<?=$policy['policy_number']?>"/>
<div class="form-group">
<textarea name="remark" class="form-control" required></textarea>
</div>

<div class="row">

<div class="col-md-5">
<div class="form-group">
<select name="status" class="form-control" required>
<option value="">Select Status</option>
<option value="followup">FOLLOW UP</option>
<option value="policy_pending">POLICY PENDING</option>
<option value="policy_done">POLICY DONE</option>
<option value="lost">LOST</option>
</select></div></div>
<div class="col-md-7">
<div class="form-group">
<button class="btn btn-primary form-control">COMMENT</button>
</div></div>

</form>

</div>

<!-- comment list-->

<ul id="comment_list" class="list-group">
<?=$comment_list_html?>
</ul>

</div>
</div>


</div>
</div>



  <!--add renewed insurance policy form modal-->
  <div id="renew_policy_modal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
	<form name="add_policy_form" onsubmit="policy_done(this); return false;">
      <div class="modal-header">
        <h4 class="modal-title">ADD RENEWED POLICY</h4>
      </div>
      <div class="modal-body">
	  
    <input type="hidden" name="task" value="renew_policy" />
	<input type="hidden" name="policy_number" value="<?=$policy['policy_number']?>" />
	<input type="hidden" name="chassis" value="<?=$policy['chassis']?>" />
	
	<div class="form-horizontal">
	<div class="form-group form-group-sm">
    <label for="chassis" class="col-sm-3 control-label">CHASSIS NUMBER</label>
	<div class="col-sm-5">
	<input type="text" class="form-control" value="<?=$vehicle['chassis'];?>" disabled/>
	</div>
  </div>
  
    <div class="form-group form-group-sm">
    <label for="new_policy_number" class="col-sm-3 control-label">NEW POLICY NO.</label>
	<div class="col-sm-5">
	<input type="text" class="form-control" name="new_policy_number" id="new_policy_number" placeholder="OG-17-XXX, 340104311XXX" required/>
	</div>
  </div>
  
  <div class="form-group form-group-sm">
  <label for="policy_type" class="col-sm-3 control-label">POLICY TYPE</label>
  <div class="col-sm-3">
  <select class="form-control" name="policy_type" id="policy_type" >
  <option value="">SELECT</option>
  <option value="normal">NORMAL</option>
  <option value="0 dap">0 DAP</option>
  </select>
  </div>
  </div>
  
  <div class="form-group form-group-sm">
  <label for="company" class="col-sm-3 control-label">COMPANY</label>
  <div class="col-sm-3">
  <select class="form-control" name="company" id="company" >
  <option value="">SELECT</option>
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
  
    <div class="form-group form-group-sm">
  <label for="expiry_date" class="col-sm-3 control-label">EXPIRY DATE</label>
  <div class="col-sm-4">
  <input type="date" class="form-control" id="expiry_date" value="<?=$new_expiry_date?>" name="expiry_date" required/>
  </div>
  </div>

	
  <div class="form-group form-group-sm">
  <label for="idv" class="col-sm-3 control-label">IDV (Rs.)</label>
  <div class="col-sm-3">
  <input type="text" class="form-control" name="idv" id="idv" placeholder="700000" />
  </div>
  </div>
  
  <div class="form-group form-group-sm">
  <label for="ncb" class="col-sm-3 control-label">NCB (%)</label>
  <div class="col-sm-3">
  <select class="form-control" name="ncb" id="ncb" >
  <option value="">SELECT</option>
  <option value="NEW">NEW</option>
  <option value="0">0%</option>
  <option value="20">20%</option>
  <option value="25">25%</option>
  <option value="35">35%</option>
  <option value="45">45%</option>
  <option value="50">50%</option>
  </select>
  </div>
  </div>
  
  <div class="form-group form-group-sm">
  <label for="discount" class="col-sm-3 control-label">DISCOUNT (%)</label>
  <div class="col-sm-3">
  <input type="text" class="form-control" name="discount" id="discount" placeholder="70" />
  </div>
  </div>

  <div class="form-group form-group-sm">
  <label for="premium" class="col-sm-3 control-label">PREMIUM (Rs)</label>
      <div class="col-sm-3">
  <input type="text" class="form-control" name="premium" id="premium" placeholder="NET PAYBLE" />
  </div>
  <div class="col-sm-3">
  <input type="text" class="form-control" name="od" id="od" placeholder="OD" />
  </div>
    <div class="col-sm-3">
  <input type="text" class="form-control" name="tp" id="tp" placeholder="TP" />
  </div>
  </div>


  <div class="form-group form-group-sm">
  <label for="business_type" class="col-sm-3 control-label">BUSINESS TYPE</label>
  <div class="col-sm-3">
  <select class="form-control" name="business_type" id="business_type" required>
  <option value="">SELECT</option>
  <option value="renew">RENEWAL</option>
  <option value="rollover">ROLLOVER</option>
  <option value="other">OTHER</option>
  </select>
  </div>
  </div>

  </div>
</div>
<div class="modal-footer">
<button type="submit" class="btn btn-primary btn-default">SUBMIT</button>
<button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
</div>
</form>
</div></div></div>


  <!--vehicle details-->
  <div id="vehicle_detail_modal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="submit" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">VEHICLE INFORMATION</h4>
      </div>
      <div class="modal-body">
 <table class="table table-bordered">
<tr><td>REGISTRATION NO.</td><td><?=$vehicle['registration_number']?></td></tr>
<tr><td>CHASSIS NUMBER</td><td><?=$vehicle['chassis']?></td></tr>
<tr><td>MODEL</td><td><?=$vehicle['model']?></td></tr>
<tr><td>CUBIC CAPACITY</td><td><?=$vehicle['cc']?></td></tr>
<tr><td>MFG YEAR</td><td><?=$vehicle['mfg']?></td></tr>
<tr><td>HYPOTHECATION</td><td><?=$vehicle['hpa']?></td></tr>
</table>
</div>
</div>
</div>
</div>

<script>

function formatAMPM(date) {
  var hours = date.getHours();
  var minutes = date.getMinutes();
  var ampm = hours >= 12 ? 'PM' : 'AM';
  hours = hours % 12;
  hours = hours ? hours : 12; // the hour '0' should be '12'
  minutes = minutes < 10 ? '0'+minutes : minutes;
  var strTime = hours + ':' + minutes + ' ' + ampm;
  return strTime;
}


	  //add comment function
	  function add_comment(e) {
		  var today = new Date();
		  var m=(today.getMonth()+1) <10 ? '0'+(today.getMonth()+1) : (today.getMonth()+1);
		  var dateTime = today.getDate()+'-'+m+'-'+today.getFullYear()+' ('+formatAMPM(today)+')';

		  
		  data=$(e).serialize();
		  formdata=$(e).serializeArray();
          $.ajax({
            type: 'post',
            url: 'ajax.php',
            data: data,
            success: function 	(result) {
				if (result==1) {
				comment_html='<li class="list-group-item"><p class="list-group-item-text">'+comment_form.remark.value+'<br/><span class="badge">'+comment_form.status.value+'</span> - <small>'+dateTime+'</small></p></li>';
				$("#comment_list").prepend(comment_html);
				e.reset();
				}
              else
			  {alert(result);}
            }
          });
	  }
	  
	  
	  	  //policy done function
	  function policy_done(e) {
		  var today = new Date();
		  var m=(today.getMonth()+1) <10 ? '0'+(today.getMonth()+1) : (today.getMonth()+1);
		  var dateTime = today.getDate()+'-'+m+'-'+today.getFullYear()+' ('+formatAMPM(today)+')';
		  
		        $.ajax({
            type: 'post',
            url: 'ajax.php',
            data: $(e).serialize(),
            success: function (result) {
				if (result==1) {
					$( "#renew_policy_btn" ).replaceWith( '<span>'+document.add_policy_form.new_policy_number.value+'</span>');
					comment_html='<li class="list-group-item"><p class="list-group-item-text">new policy number - '+document.add_policy_form.new_policy_number.value+'<br/><span class="badge">policy_done</span> - <small>'+dateTime+'</small></p></li>';
				$("#comment_list").prepend(comment_html);
					$(e)[0].reset();$('#renew_policy_modal').modal('hide')}
              else
			  {alert(result);}
            }
          });
	  }
	  	 

	  function cal_premium(e) {
		  var idv=e.calculator_idv.value;
		  cc=<?=$vehicle['cc']?>;
		  y=new Date().getFullYear()-<?=$vehicle['mfg']-1?>;
		  d=e.calculator_discount.value;
		  n=e.calculator_ncb.value;
		  document.getElementById('premium_0dap').value=premium(idv,cc,y,d,n,'0dap');
		  document.getElementById('premium_normal').value=premium(idv,cc,y,d,n,'normal');
		  
	  
	  }	

	  
	  function disable_but() {
			$('.editable').editable('toggleDisabled');
			
		}

	$(document).ready(function() {
	
		
    $('.editable').editable({
		ajaxOptions: {
    dataType: 'json'
},
		params: function(params) {
    //originally params contain pk, name and value
    params.task = 'edit_value';
	params.table = 'insurance_data';
    return params;
},
    success: function(response, newValue) {
		if (!response.success)
        alert(response.msg);
    },
	disabled:true
	
});



});	  
	  
</script>

<?php include('footer.php'); ?>