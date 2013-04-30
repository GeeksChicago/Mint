<?php
$dbconnection = pg_connect("host=localhost port=5432 dbname=mint_ams user=mint password=mint");
if($dbconnection)
{
	if(isset($_REQUEST['mint_id'])){
		if($_REQUEST['mint_id']==''){
			$username = explode('@',$_REQUEST['username']);
			$random=rand(1,99);
			$data=array(
				'login'=>$username[0].'_'.$random,
				'first_name'=>$_REQUEST['first_name'],
				'last_name'=>$_REQUEST['last_name'],
				'email'=>$_REQUEST['username'],
				'md5_password'=>md5($username[0]),
				'organization_id'=>1,
				'account_created'=>date('Y-m-d'),
				'active_account'=>'t',
				'rights'=>4
			);
			$data="$username[0].'_'.$random,$_REQUEST['first_name'],$_REQUEST['last_name'],$_REQUEST['username'],md5($username[0]),1,date('Y-m-d'),'t',4";
			$result = pg_query($dbconnection, "INSERT INTO users ('login','first_name','last_name','email','md5_password','organization_id','account_created','active_account','rights') VALUES ($data)");
			$result = pg_insert($dbconnection, 'users', $data);
			$response = json_encode(array("success" => 'true', 'error' => '','result'=>$result));
			echo $_GET['callback'] . '(' . $response . ')';
			exit;
			
		}
		else{
			$user_id=$_REQUEST['mint_id'];
	        $result=pg_query($dbconnection,"SELECT * FROM users WHERE users_id = $user_id");
	        if($result)
	        {
	                $user_info=pg_fetch_all($result);
					$response = json_encode(array("success" => 'true', 'error' => '','result'=>$user_info));
					echo $_GET['callback'] . '(' . $response . ')';
					exit;
	        }
			
		}
		
	}
       
}
else
{
	$response = json_encode(array("success" => 'false', 'error' => 'Connection with pg failed.'));
	echo $_GET['callback'] . '(' . $response . ')';
	exit;
}


?>
~