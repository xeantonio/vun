
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
	$queryultimo="SELECT [timestamp] ,[fundex],[fundexStatus]  FROM [".$database. "].[dbo].[fundex_fundexOverTime_fundexOverTimeList] WHERE timestamp >= '".$startdate->format('Y-m-d H:i:s')."' and timestamp <= '".$finishdate->format('Y-m-d H:i:s'). "' and appId = '".$key['id']."' order by timestamp asc";
	$SqlIDultimo=sqlsrv_query( $conn, $queryultimo);
	$objultimo = sqlsrv_fetch_object($SqlIDultimo);
	$arreglodatos=array();
	$arreglopadre=array();
	while($objgraf = sqlsrv_fetch_array($SqlIDultimo)){
		$arreglodatos["ts"]= strtotime(date_format($objgraf["timestamp"],'Y-m-d H:i:s')) * 1000;
		$arreglodatos["timestamp"]= date_format($objgraf["timestamp"],'Y-m-d H:i:s');
		$arreglodatos["fundex"]= intval($objgraf["fundex"]);
		array_push($arreglopadre,$arreglodatos);
	}	 
	$datos["data"] = $arreglopadre;	 
	array_push($todo,$datos);
}
print json_encode($todo);

	
/*
	$queryultimo="SELECT [timestamp] ,[fundex],[fundexStatus]  FROM [".$database. "].[dbo].[fundex_fundexOverTime_fundexOverTimeList] WHERE timestamp >= '".$startdate->format('Y-m-d H:i:s')."' and timestamp <= '".$finishdate->format('Y-m-d H:i:s'). "' and appId = '".$appID."' order by timestamp asc";
	$SqlIDultimo=sqlsrv_query( $conn, $queryultimo);
	$objultimo = sqlsrv_fetch_object($SqlIDultimo);

	$arreglodatos=array();
	$arreglopadre=array();
	while($objgraf = sqlsrv_fetch_array($SqlIDultimo)){
		$arreglodatos["ts"]= strtotime(date_format($objgraf["timestamp"],'Y-m-d H:i:s')) * 1000;
		$arreglodatos["timestamp"]= date_format($objgraf["timestamp"],'Y-m-d H:i:s');
		$arreglodatos["fundex"]= intval($objgraf["fundex"]);
		array_push($arreglopadre,$arreglodatos);
	}

	print json_encode($arreglopadre);
		
*/




//print_r(array_values($arreglopadre));
//




//header('Content-Type: text/html; charset= ISO-8859-1'); 

//initilize the page
//require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
//require_once("inc/config.ui.php");

/*---------------- PHP Custom Scripts ---------

YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
E.G. $page_title = "Custom Title" */

//$page_title = "VUN";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
//$page_css[] = "your_style.css";
//include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
//$page_nav["blank"]["active"] = true;
//include("inc/nav.php");

?>
