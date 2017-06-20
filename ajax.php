<?php 
//error_reporting(E_ALL);

include('db.php');

$task=(isset($_POST['task'])?$_POST['task']:null);


 switch ($task)
{
//search customer
case 'find_cust':
if (isset($_POST["query"])) {$query=$_POST["query"];} else {$query=null;}
if ($query==null){echo 'Please enter something in textbox.';}else {
$rows=$db->select('vehicle_data',"customer_number LIKE '%$query%' OR customer_name LIKE '%$query%' OR chassis LIKE '%$query%' OR registration_number LIKE '%$query%'",'customer_name,registration_number,chassis,customer_number,id');
 echo json_encode($rows);
}
break;


//add customer
case 'add_cust':
if (strlen(trim($_POST['chassis']))<5) {die('Enter correct chassis number!');}
$data['chassis']=$_POST['chassis'];
$data['customer_name']=$_POST['customer_name'];
$data['customer_number']=$_POST['customer_number'];
if ($_POST['registration_number']!=''){$data['registration_number']=$_POST['registration_number'];}
if ($_POST['model']!=''){$data['model']=$_POST['model'];}
if ($_POST['cc']!=''){$data['cc']=$_POST['cc'];}
if ($_POST['hpa']!=''){$data['hpa']=$_POST['hpa'];}
if ($_POST['mfg']!=''){$data['mfg']=$_POST['mfg'];}
$vehicle_result = $db->insert('vehicle_data',$data);
if ($vehicle_result) {
	
	if (isset($_POST['add_policy']))
{
$policy_data['chassis']=$_POST['chassis'];
$policy_data['policy_number']=$_POST['policy_number'];
$policy_data['covernote']=$_POST['covernote'];
$policy_data['company']=$_POST['company'];
if ($_POST['od']!=''){$policy_data['od']=$_POST['od'];}
if ($_POST['tp']!=''){$policy_data['tp']=$_POST['tp'];}
if ($_POST['premium']!=''){$policy_data['premium']=$_POST['premium'];}
if ($_POST['idv']!=''){$policy_data['idv']=$_POST['idv'];}
if ($_POST['ncb']!=''){$policy_data['ncb']=$_POST['ncb'];}
if ($_POST['discount']!=''){$policy_data['discount']=$_POST['discount'];}
if ($_POST['policy_type']!=''){$policy_data['policy_type']=$_POST['policy_type'];}
if ($_POST['business_type']!=''){$policy_data['business_type']=$_POST['business_type'];}
if ($_POST['expiry_date']!=''){$policy_data['expiry_date']=$_POST['expiry_date'];}
echo $db->insert('insurance_data',$policy_data);
}
else {echo $vehicle_result;}
}
else {echo $vehicle_result;}
break;
 
//add policy
case 'add_policy':
if (strlen(trim($_POST['chassis']))<5) {die('Chassis Number cannot be blank!');}
$data['chassis']=$_POST['chassis'];
if ($_POST['covernote']!=''){$data['covernote']=$_POST['covernote'];}
$data['policy_number']=$_POST['policy_number'];
$data['company']=$_POST['company'];
if ($_POST['expiry_date']!=''){$data['expiry_date']=$_POST['expiry_date'];}
if ($_POST['policy_type']!=''){$data['policy_type']=$_POST['policy_type'];}
if ($_POST['business_type']!=''){$data['business_type']=$_POST['business_type'];}
if ($_POST['idv']!=''){$data['idv']=$_POST['idv'];}
if ($_POST['ncb']!=''){$data['ncb']=$_POST['ncb'];}
if ($_POST['discount']!=''){$data['discount']=$_POST['discount'];}
if ($_POST['od']!=''){$data['od']=$_POST['od'];}
if ($_POST['tp']!=''){$data['tp']=$_POST['tp'];}
if ($_POST['premium']!=''){$data['premium']=$_POST['premium'];}
echo $db->insert('insurance_data',$data);
break;
	

 //add comment
case 'add_comment':
$policy_number=$_POST['policy_number'];
$data['policy_number']=$_POST['policy_number'];
$data['remark']=$_POST['remark'];
$data['status']=$_POST['status'];
echo $result=$db->insert('followup_data',$data);
break;
 
 
//upload file
case 'upload_file':
$fileName = $_FILES['file']['name'];
$tmpName  = $_FILES['file']['tmp_name'];
$fileSize = $_FILES['file']['size'];
$fileType = $_FILES['file']['type'];
//check if file already exist
$fp      = fopen($tmpName, 'r');
$content = fread($fp, filesize($tmpName));
$content = addslashes($content);
fclose($fp);

if(!get_magic_quotes_gpc())
{
    $fileName = addslashes($fileName);
}

$data['filename']=$fileName;
$data['filesize']=$fileSize;
$data['filetype']=$fileType;
$data['filecontent']=$content;
$data['document_name']=$_POST['document_name'];
$data['document_type']=$_POST['document_type'];


$result = $db->insert('upload',$data);
if($result==1){echo 'File uploaded successfully!';}else{echo $result;}


break;

 	//filter policy
case 'filter_policy':

$y= $_POST['y'];
$m= $_POST['m'];
$rows=$db->select('insurance_data t1',null,'t1.business_type,t1.company,t1.expiry_date,t1.policy_number,t1.id iid,vehicle_data.id vid,vehicle_data.customer_name,vehicle_data.customer_number',null,"INNER JOIN vehicle_data on t1.chassis=vehicle_data.chassis WHERE expiry_date=(select MAX(t2.expiry_date) from insurance_data t2 WHERE t1.chassis=t2.chassis AND MONTH(t2.expiry_date)=$m AND YEAR(t2.expiry_date)<=$y) ORDER BY DAY(t1.expiry_date) ASC");
for ($i=0; $i<count($rows); $i++) {
	$p_n=$rows[$i]['policy_number'];
	$status_row=$db->select('followup_data',"policy_number='$p_n' AND YEAR(create_date)=$y",'status','id DESC',' LIMIT 1');
	if ($status_row)
	{$rows[$i]['status']=$status_row[0]['status'];}
	else {$rows[$i]['status']='';}
}
echo json_encode($rows);
break;

 	//find policy
case 'find_policy':
$policy_number=strlen(trim($_POST['policy_number']));
if ($policy_number!='' OR ($_POST['start_date']!='' AND $_POST['end_date']!='')){
$where="policy_number LIKE '%".$_POST['policy_number']."%'";
$where.=(($_POST['start_date']!='' AND $_POST['end_date']!='')?" AND expiry_date BETWEEN '".$_POST['start_date']."' AND '".$_POST['end_date']."'":null);
$where.=($_POST['business_type']!=''?" AND business_type='".$_POST['business_type']."'":null);
$where.=($_POST['company']!=''?" AND company='".$_POST['company']."'":null);
$rows=$db->select('insurance_data',$where,'*','policy_number ASC');
echo json_encode($rows);
}
else
	echo 'fill policy number';
break;
 
 
  	//find file
case 'find_file':
$rows=array();
if (strlen(trim($_POST['document_name']))!=''){
$document_name=$_POST['document_name'];
$rows=$db->select('upload',"document_name LIKE '%$document_name%'",'id,document_name,filesize');

}
echo json_encode($rows);
break;
 
 
 //add renewed policy
case 'renew_policy':

if (strlen(trim($_POST['chassis']))<5) {die('Chassis Number cannot be blank!');}
$oldpolicy_number=$_POST['policy_number'];
$newpolicy_number=$_POST['new_policy_number'];
$insurance_data['chassis']=$_POST['chassis'];
$insurance_data['policy_number']=$newpolicy_number;
$insurance_data['company']=$_POST['company'];
if ($_POST['premium']!=''){$insurance_data['premium']=$_POST['premium'];}
if ($_POST['od']!=''){$insurance_data['od']=$_POST['od'];}
if ($_POST['tp']!=''){$insurance_data['tp']=$_POST['tp'];}
if ($_POST['idv']!=''){$insurance_data['idv']=$_POST['idv'];}
if ($_POST['ncb']!=''){$insurance_data['ncb']=$_POST['ncb'];}
if ($_POST['discount']!=''){$insurance_data['discount']=$_POST['discount'];}
if ($_POST['policy_type']!=''){$insurance_data['policy_type']=$_POST['policy_type'];}
if ($_POST['business_type']!=''){$insurance_data['business_type']=$_POST['business_type'];}
$insurance_data['business_month']=date("Y-m-d H:i:s");
if ($_POST['expiry_date']!=''){$insurance_data['expiry_date']=$_POST['expiry_date'];}
$result= $db->insert('insurance_data',$insurance_data);
if (!$result) {die($result);}
$newdata['new_policy_number']=$_POST['new_policy_number'];
$newdata['update_date']=date("Y-m-d H:i:s");
$newdata['status']='policy_done';
$result=$db->update('insurance_data',"policy_number='$oldpolicy_number'",$newdata);
if (!$result) {die($result);}
$followup_data['policy_number']=$oldpolicy_number;
$followup_data['remark']='new policy number - '.$newpolicy_number;
$followup_data['status']='policy_done';
$result=$db->insert('followup_data',$followup_data);
if (!$result) {die($result);}
echo 1;
break;
 
 
 case 'edit_value':
 $id=$_POST['pk'];
 $name=$_POST['name'];
$newdata[$name]=$_POST['value'];
$q=$db->update($_POST['table'],"id='$id'",$newdata); 
if ($q==1) {$result['success']=true;}
else {$result['success']=false;$result['msg']=$q;}
echo json_encode($result);
break;
 
}



?>