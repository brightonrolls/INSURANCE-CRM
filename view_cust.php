<?php include('db.php'); include('header.php'); ?>
<?php
if (isset($_GET["id"])) {$id=$_GET["id"];} else {die('id not set');}

$rows=$db->select('vehicle_data',"id = '$id'");

if (count($rows)) {
$vehicle=$rows[0];
}
else {die('vehicle not found');}

//check for files
$reg_num=$vehicle['registration_number'];
$rows=$db->select('upload',"document_name='$reg_num'");
if (count($rows)) {$registration_number='<a href="download.php?id='.$rows[0]['id'].'&download=1">'.$reg_num.'</a>';}
else {$registration_number=$reg_num;}

//get insurace policy list
$policy_html="";
$chassis=$vehicle['chassis'];
$rows=$db->select('insurance_data',"chassis = '$chassis' ORDER BY expiry_date ASC");
for ($i = 0; $i <count($rows); $i++) {
    $policy_html.='<tr><td><a href="view_policy.php?id='.$rows[$i]['id'].'">'.$rows[$i]['policy_number'].'</a></td><td>'.$rows[$i]['company'].'</td><td>'.$rows[$i]['policy_type'].'</td><td>'.$rows[$i]['business_type'].'</td><td>'.$rows[$i]['expiry_date'].'</td></tr>';
}


?>


<div class="container-fluid">
<div class="row">
<div class="col-md-1"><p>
<a href="javascript:window.history.back();" class="btn btn-default"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
</p></div>

<div class="col-md-4">
<table class="table table-bordered">
 <thead><tr><th colspan="2">CONTACT INFORMATION <span class="pull-right"><button type="button" onclick="disable_but();" class="btn btn-default btn-xs" data-toggle="button" aria-pressed="false" autocomplete="off"><span class="glyphicon glyphicon-edit"></span> EDIT</button></span></th></tr></thead>
 <tbody>
<tr><td>CUSTOMER NAME</td><td><span class="editable" id="customer_name" data-type="text" data-pk="<?=$vehicle['id']?>" data-url="ajax.php"><?=$vehicle['customer_name']?></span></td></tr>
<tr><td>CUSTOMER NUMBER</td><td><span class="editable" id="customer_number" data-type="text" data-pk="<?=$vehicle['id']?>" data-url="ajax.php"><?=$vehicle['customer_number']?></span></td></tr>
</tbody>
</table>
 <table class="table table-bordered">
 <thead><tr><th colspan="2">VEHICLE INFORMATION</th></tr></thead>
 <tbody>
<tr><td>REGISTRATION NUMBER</td><td><span class="editable" id="registration_number" data-type="text" data-pk="<?=$vehicle['id']?>" data-url="ajax.php"><?=$registration_number?></span></td></tr>
<tr><td>CHASSIS NUMBER</td><td><span class="editable" id="chassis" data-type="text" data-pk="<?=$vehicle['id']?>" data-url="ajax.php"><?=$vehicle['chassis']?></span></td></tr>
<tr><td>MODEL</td><td><?=$vehicle['model']?></td></tr>
<tr><td>CUBIC CAPACITY</td><td><?=$vehicle['cc']?></td></tr>
<tr><td>MFG YEAR</td><td><?=$vehicle['mfg']?></td></tr>
<tr><td>HYPOTHECATION</td><td><span class="editable" id="hpa" data-type="text" data-pk="<?=$vehicle['id']?>" data-url="ajax.php"><?=$vehicle['hpa']?></span></td></tr>
</tbody>
</table>


</div>
 
<div class="col-md-7"> 
<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">INSURANCE POLICY LIST	</div>
  <div class="panel-body">
<button class="btn btn-primary" data-toggle="modal" data-target="#add_policy_modal"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> ADD POLICY</button>
</div>
<div class="table-responsive">
<table class="table">
<thead>
<tr><th>POLICY NUMBER</th><th>COMPANY</th><th>POLICY TYPE</th><th>BUSINESS</th><th>EXPIRY DATE</th></tr>
</thead>
<tbody>
<?=$policy_html?>
</tbody>
</table>
</div>
</div>
</div>

</div>
</div>







  <!--add insurance policy form modal-->
  <div id="add_policy_modal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
	<form name="add_policy_form" onsubmit="add_policy(this); return false;">
      <div class="modal-header">
        <button type="submit" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">ADD INSURANCE POLICY</h4>
      </div>
      <div class="modal-body">
    <input type="hidden" name="task" value="add_policy" />
	<input type="hidden" value="<?=$vehicle['chassis'];?>" name="chassis" />
	
	<div class="form-horizontal">
   	    <div class="form-group form-group-sm">
    <label for="chassis" class="col-sm-3 control-label">CHASSIS NUMBER</label>
	<div class="col-sm-5">
	<input type="text" class="form-control" value="<?=$vehicle['chassis'];?>" disabled/>
	</div>
  </div>
  <div class="form-group form-group-sm">
    <label for="policy_number" class="col-sm-3 control-label">POLICY NO.</label>
	<div class="col-sm-5">
	<input type="text" class="form-control" name="policy_number" id="policy_number" placeholder="OG-17-XXX, 340104311XXX" />
	</div>
	<div class="col-sm-4">
  <input type="text" class="form-control" name="covernote" id="covernote" placeholder="COVER NOTE" />
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
  <input type="date" class="form-control" id="expiry_date" name="expiry_date" required/>
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
  <option value="new">NEW</option>
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
</div>
</div>
  </div>



<script>
		
		function disable_but() {
			$('.editable').editable('toggleDisabled');
			
		}
		
      //add new policy
	  function add_policy(e) {
          $.ajax({
            type: 'post',
            url: 'ajax.php',
            data: $(e).serialize(),
            success: function (result) {
				if (result==1) {$(e)[0].reset();$('#add_policy_modal').modal('hide')}
              else
			  {alert(result);}
            }
          });

        }
  	
	$(document).ready(function() {
		
		
		
    $('.editable').editable({
		ajaxOptions: {
    dataType: 'json'
},
		params: function(params) {
    //originally params contain pk, name and value
    params.task = 'edit_value';
	params.table = 'vehicle_data';
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