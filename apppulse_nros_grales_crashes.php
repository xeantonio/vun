
<?php
header("Content-Type: application/json; charset=UTF-8");
//header('Content-Type: text/html; charset= ISO-8859-1'); 
date_default_timezone_set("America/Mexico_City");
$serverName="192.168.4.18";
$uid="sa";
$pwd="qwe123.,";
$database = "apppulse2";

	
$connectionInfo = array( "UID"=>$uid,"PWD"=>$pwd,"Database"=> $database);
$conn = sqlsrv_connect( $serverName, $connectionInfo);


if(empty($_GET['appID'])){
    $appID = "";
}else{
    $appID = $_GET['appID'];
	if($appID == -1){
		$apps=array(
			array("label"=>"Santander Mobile Android","id"=>"867574fd34df4e97b2d34826597f4453"),
			array("label"=>"Santander SmartBank Android","id"=>"2ac2d3f7d5f54969a55987908d5600cd"),
			array("label"=>"Santander SmartBank iOS","id"=>"d56e9149845747158bd778736c096366")
		);			
	}
	else{
		$apps = array(array("label"=>"Grafico","id"=>$appID));
	
	}
}

if(empty($_GET['finishdate'])){
    $finishdate = date_create(date("Y-m-d H:i:s"));
}else{
    $finishdate = date_create($_GET['finishdate']);
}

$finishdate =  date_add($finishdate,date_interval_create_from_date_string('1 days')); 
#print "finishdate:".$finishdate->format('Y-m-d H:i:s')."<br>";


if(empty($_GET['startdate'])){
    $startdate =  date_add($finishdate,date_interval_create_from_date_string('-1 days')); // default value
}else{
    $startdate = date_create($_GET['startdate']);
}

$todo = array();
$datos = array();
foreach($apps as $key){
	$datos['label'] = $key['label'];
	$datos['id'] = $key['id'];
	$queryultimo= "select convert(varchar(10),timestamp,120) as timestamp, 	sum(convert(int,uniqueUsers)) as uniqueUsers, sum(convert(int,affectedUsers)) as affectedUsers from stability_stabilityGetAllCrashesActionsData_crashSummary_crashesOverTime where 	appId = '".$key['id']."' and 	timestamp>='".$startdate->format('Y-m-d H:i:s')."' and timestamp<'".$finishdate->format('Y-m-d H:i:s')."' group by convert(varchar(10),timestamp,120) order by timestamp asc";
	//print $queryultimo."<br>";
	$SqlIDultimo=sqlsrv_query( $conn, $queryultimo);
	//$objultimo = sqlsrv_fetch_object($SqlIDultimo);
	$arreglodatos=array();
	$arreglopadre=array();
	while($objgraf = sqlsrv_fetch_array($SqlIDultimo)){
		$arreglodatos["ts"]= strtotime($objgraf["timestamp"]) * 1000;
		$arreglodatos["uniqueUsers"]= intval($objgraf["uniqueUsers"]);
		$arreglodatos["affectedUsers"]= intval($objgraf["affectedUsers"]);
		array_push($arreglopadre,$arreglodatos);
	}	 
	$datos["data"] = $arreglopadre;	 
	array_push($todo,$datos);
}
print json_encode($todo);


?>
