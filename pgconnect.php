<?php
$dbconnection = pg_connect("host=localhost port=5432 dbname=mint_ams user=mint password=mint");
if($dbconnection)
{
	if(isset($_REQUEST['mint_id'])){
		if($_REQUEST['mint_id']==''){
			$username = explode('@',$_REQUEST['email']);
			$data=array(
				'login'=>$username[0],
				'first_name'=>$_REQUEST['first_name'],
				'last_name'=>$_REQUEST['last_name'],
				'email'=>$_REQUEST['email'],
				'md5_password'=>md5($username[0]),
				'organization_id'=>1,
				'account_created'=>date('Y-m-d'),
				'active_account'=>'t',
				'rights'=>4
			);
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