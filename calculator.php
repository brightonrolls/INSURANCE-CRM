<?php $page="calculator"; include('db.php'); include('header.php');?>

<div class="container-fluid">
<div class="row">
<div class="col-md-5">

<div class="panel panel-default">
  <div class="panel-heading">NEW INDIA CALCULATER</div>
  <div class="panel-body">

<form  onsubmit="cal_premium(this); return false;">
<div class="form-group"><label for="idv">IDV</label><input class="form-control" type="text" placeholder="idv" name="idv"/></div>
<div class="row">
<div class="col-md-6">
<div class="form-group"><label for="cc">cc</label><select class="form-control" name="cc">
<option value="">select</option>
<option value="1498">1000-1500</option>
<option value="1598">above 1500</option>
</select></div>
</div><div class="col-md-6">
<div class="form-group"><label for="y">MFG YEAR</label><select class="form-control" name="y">
<option value="">select</option>
<option value="1">1st</option>
<option value="2">2nd</option>
<option value="3">3rd</option>
<option value="4">4th</option>
<option value="5">5th</option>
<option value="6">6th</option>
<option value="7">7th</option>
</select></div>
</div></div>
<div class="row">
<div class="col-md-6">
<div class="form-group"><label for="d">Discount</label><input class="form-control" type="text" placeholder="discount" name="d"/></div>
</div><div class="col-md-6">
<div class="form-group"><label for="n">NCB</label><select class="form-control" name="n">
<option value="">select</option>
<option value="20">20%</option>
<option value="25">25%</option>
<option value="35">35%</option>
<option value="45">45%</option>
<option value="55">55%</option>
</select></div>
</div></div>
<div class="form-group"><button class="btn btn-default" type="submit">CALCULATE</button></div>
</form>

</div>
<div class="panel-footer"><b>0DAP - </b><span id="0dap"></span> , <b>NORMAL - </b><span id="normal"></span></div>
</div>	


</div>

<div class="col-md-7">

</div>
</div>
</div>

<script>
	  
	  
	  function cal_premium(e) {
		  idv=e.idv.value;
		  cc=e.cc.value;
		  y=e.y.value;
		  d=e.d.value;
		  n=e.n.value;
		  document.getElementById('0dap').innerHTML=premium(idv,cc,y,d,n,'0dap');
		  document.getElementById('normal').innerHTML=premium(idv,cc,y,d,n,'normal');
		  
	  
	  }

</script>
<?php include('footer.php'); ?>