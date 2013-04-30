<?php
$dbconnection = pg_connect("host=localhost port=5432 dbname=mint_ams user=mint password=mint");
if($dbconnection)
{
        $result=pg_query($dbconnection,"SELECT * FROM users");
        if($result)
        {
                $arr=pg_fetch_all($result);
				$response = json_encode(array("success" => 'true', 'error' => '','result'=>$arr));
				echo $_GET['callback'] . '(' . $response . ')';
				exit;
        }
		else
		{
			$response = json_encode(array("success" => 'false', 'error' => 'No Record found.'));
			echo $_GET['callback'] . '(' . $response . ')';
			exit;
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