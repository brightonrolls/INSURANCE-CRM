<?php
$page='document';
include('header.php');
requirelogin();
?>

<div class="container-fluid">


<div class="row">
<div class="col-md-2">
  <div class="form-group">
  <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#upload_file_modal"><span class="glyphicon glyphicon-upload"></span>  UPLOAD DOCUMENT</button>
  </div>
  </div>
  
<div class="col-md-10">
<form onsubmit="find_files(this); return false;">
		<input type="hidden" name="task" value="find_file" />
<div class="container-fluid">
  <div class="form-group">
<div class="input-group">
<input class="form-control" type="text" id="document_name" placeholder="Document Name - up25xx12345, og-xx-xx-1801-xxxxxx" name="document_name" />
<span class="input-group-btn">
 <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> FIND</button> 
 </span>
</div>
</div>
</div>
  </form>
<table class="table table-hover table-condensed">
  <thead><tr><th>DOCUMENT NAME</th><th>FILE SIZE</th><th>ACTION</th></tr></thead>
  <tbody id="result_tbody"></tbody>
</table> 

</div>

</div>
</div>


  <!--upload file form modal-->
<div id="upload_file_modal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">UPLOAD DOCUMENT</h4>
      </div>
      <div class="modal-body">
        
		<!--upload file form -->
		<form  enctype="multipart/form-data" method="post" action="ajax.php" target="upload_result" id="file_upload_form"  name="file_upload_form">
<input type="hidden" name="task" value="upload_file" />
    <div class="form-group">
  <div class="row">
  <div class="col-md-8">
  <label for="document_name">DOCUMENT NAME</label>
  <input id="document_name"  class="form-control" name="document_name" type="text" required/>
  </div>
  <div class="col-md-4">
    <label for="document_type">DOCUMENT TYPE</label>
  <select class="form-control" name="document_type" id="document_type" required>
  <option value="">SELECT TYPE</option>
  <option value="policy">POLICY</option>
  <option value="rc">RC</option>
  </select>
  </div>
  </div>
  </div>
<div class="form-group">
<input id="file"  class="form-control" name="file" type="file"/>
</div>
<div class="form-group">
  <button type="submit" class="btn btn-primary">UPLOAD</button>
  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</form>

<iframe width="100%" height="100px" class="well" id="upload_result" name="upload_result" ></iframe>

      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<script>

function round(value, decimals) {
  return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
}


      //filter file
	  function find_files(e) {
		
          $.ajax({
            type: 'post',
            url: 'ajax.php',
			dataType:'JSON',
            data: $(e).serialize(),
            success: function (result) {
				if (result.length==0)
				{alert('no record found');}
					else
					{
					html='';
					  result_table=document.getElementById('result_tbody');
				for (i in result) {
					size = (result[i].filesize/1024) < 1000 ? round((result[i].filesize/1024),2)+'KB' : round(((result[i].filesize/1024)/1024),2)+'MB';
				html=html+'<tr><td>'+result[i].document_name+'</td><td>'+size+'</td><td><a href="download.php?id='+result[i].id+'&download=1">DOWNLOAD</a></td></tr>';
			 }
			 $(result_table).html(html);
			 
				}
            }
          });

        }
		
      
	  
</script>

<?php include('footer.php'); ?>