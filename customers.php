<?php $page='customer'; include('header.php'); ?>


<div class="container-fluid">
<div class="row">
   <div class="col-md-2">
  
  <!-- add customer button -->
  <div class="form-group">
<button class="btn btn-primary" data-toggle="modal" data-target="#add_customer_modal">
<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> NEW CUSTOMER</button>
  </div>
	</div>

    <div class="col-md-6">
	<!--find customer form -->
	<form name="find_customer_form" onsubmit="find_customer(this); return false;">
<input type="hidden" name="task" value="find_cust" />
<div class="form-group">
<div class="input-group">
<input id="query"  class="form-control" placeholder="Customer Name or Number or Chassis" name="query" type="text" required/>
  <span class="input-group-btn">
  <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> FIND</button>
  </span>
</div>
</div>
  </form>

 </div>
 

  </div>

  
    <!--service customer search result table-->
<div class="panel panel-default">
  <table id="customer_result_table" class="table table-hover table-condensed">
  <thead><tr><th>CUSTOMER NAME</th><th>REGISTRATION NUMBER</th><th>CHASSIS NUMBER</th><th>CUSTOMER NUMBER</th><th>ACTION</th></tr></thead>
  <tbody id="result_tbody"></tbody>
</table> 
</div>


</div>


  <!--new customer form modal-->
  <div id="add_customer_modal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="submit" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">ADD NEW CUSTOMER</h4>
      </div>
      <div class="modal-body">

<form enctype="multipart/form-data" name="add_sales_customer_form" onsubmit="add_customer(this); return false;">

    <input type="hidden" name="task" value="add_cust" />
	<input type="hidden" name="registration_number" value="NEW" />
	
	<!--vehicle details-->
	<div class="form-group form-group-sm">
    <label for="chassis">CHASSIS NUMBER</label>
    <input type="text" class="form-control" name="chassis" id="chassis" placeholder="MEXK15605GTXXXXXX" required>
	</div>
	
	  <div class="row">
	   <div class="col-md-6">
    <div class="form-group form-group-sm">
    <label for="registration_number">REGISTRATION NUMBER</label>
    <input type="text" class="form-control" name="registration_number" id="registration_number" placeholder="UP25XX4565" required>
  </div>
  </div>
   <div class="col-md-6">
      <div class="form-group form-group-sm">
  <label for="hpa">HPA</label>
  <input type="text" class="form-control" name="hpa" id="hpa" placeholder="HYPOTHECATION" />
  </div>
  </div>
  </div>
  
  <div class="row">
  <div class="col-md-6">
  <div class="form-group form-group-sm">
    <label for="customer_name">CUSTOMER NAME</label>
    <input type="text" class="form-control" name="customer_name" id="customer_name" placeholder="UTKARSH ANAND" required>
  </div>
  </div>
    <div class="col-md-6">
  <div class="form-group form-group-sm">
    <label for="customer_number">MOBILE NUMBER</label>
    <input type="text" class="form-control" name="customer_number" id="customer_number" placeholder="8937800042" required>
  </div>
  </div>	
  </div>
      
      <div class="row">
  <div class="col-md-4"><div class="form-group form-group-sm">
    <label for="model">MODEL</label>
    <select class="form-control" id="model" name="model" required>
	<option value="">SELECT</option>
  <option value="POLO">POLO</option>
  <option value="VENTO">VENTO</option>
  <option value="AMEO">AMEO</option>
  <option value="ZETTA">JETTA</option>
  <option value="PASAT">PASSAT</option>
</select></div></div>
  <div class="col-md-4"><div class="form-group form-group-sm">
    <label for="mfg">MANUFACTUR YEAR</label>
   <select class="form-control" id="mfg" name="mfg" >
   	<option value="">SELECT</option>
   <?php
   for ($i=2005; $i<=date("Y"); $i++) {
	 echo '<option value="'.$i.'">'.$i.'</option>';  
   }
   ?>
</select>
  </div></div>
  <div class="col-md-4"><div class="form-group form-group-sm" >
    <label for="cc">CUBIC CAPACITY</label>
    <select class="form-control" id="cc" name="cc">
		<option value="">SELECT</option>
  <option value="1198">1198</option>
  <option value="1498">1498</option>
  <option value="1598">1598</option>
  </select>
  </div></div>
  </div>

  <div class="well  well-sm">
  <div class="form-group form-group-sm">
  <div class="checkbox">
  <label>
    <input type="checkbox" value="true" name="add_policy" data-toggle="collapse" data-target="#add_policy_form" aria-expanded="false" aria-controls="add_policy_form">
    ADD INSURANCE DETAILS
  </label>
</div>
</div>


  <!--policy details form-->
  <div class="collapse" id="add_policy_form">
  <div class="form-horizontal">
  <div class="form-group form-group-sm">
    <label for="policy_number" class="col-sm-3 control-label">POLICY NO.</label>
	<div class="col-sm-5">
	<input type="text" class="form-control" name="policy_number" id="policy_number" placeholder="OG-17-XXX, 340104311XXX"/>
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
  <input type="date" class="form-control" id="expiry_date" name="expiry_date" />
  </div>
  </div>

  <div class="form-group form-group-sm">
  <label for="idv" class="col-sm-3 control-label">IDV (Rs)</label>
  <div class="col-sm-3">
  <input type="text" class="form-control" name="idv" id="idv" placeholder="700000"/>
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
  <select class="form-control" name="business_type" id="business_type" >
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
  </div>
  

<div class="form-group form-group-sm">
<button type="submit" class="btn btn-primary btn-default">SUBMIT</button>
<button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
</div>
</div>
</form>

</div>
</div>
</div>




<script>

		
      //add new service entry
	  function add_entry(e) {
          $.ajax({
            type: 'post',
            url: 'ajax.php',
            data: $(e).serialize(),
            success: function (result) {
				if (result==1) {$(e)[0].reset();$('#entry_form_modal').modal('hide')}
              else
			  {alert(result);}
            }
          });

        }

	  	  
	  //entry form modal function
	  function open_entry_modal(e) {
		 	document.add_entry_form.chassis.value = e.value;
			document.add_entry_form.chassis_d.value = e.value;
	  }
	  
	  
	  //add customer function
	  function add_customer(e) {
		  data=$(e).serialize();
          $.ajax({
            type: 'post',
            url: 'ajax.php',
            data: data,
            success: function (result) {
				if (result==1) {alert('success');e.reset();$('#add_policy_form').collapse('hide');}
              else
			  {alert(result);}
            }
          });
	  }
	  
	  //find customer function
	  function find_customer(e) {
		   html='';
			 query=e.query.value ;
	result_table=document.getElementById('result_tbody');
          $.ajax({
			  data:{'task':'find_cust','query':query},
            type: 'post',
            url: 'ajax.php',
			dataType:'JSON',
            success: function (result) {
				if (result.length==0) {alert('no record found');}
              else
			  {
			 for (i in result) {
				html=html+'<tr><td>'+result[i].customer_name+'</td><td>'+result[i].registration_number+'</td><td>'+result[i].chassis+'</td><td>'+result[i].customer_number+'</td><td><a href="view_cust.php?id='+result[i].id+'">VIEW</a></td></tr>';
			 }
			 $(result_table).html(html);
			  }
            }	
          });
		  
	  }
	  
</script>

<?php include('footer.php'); ?>