
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
    $finishdate = date_create(date("Y-m-d"));
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
	$query_global = "select sq1.timestamp, sq1.fundex,sq2.actionPenalty,sq2.launchPenalty,sq3.batteryPenalty,sq3.networkPenalty,sq4.crashPenalty,sq4.errorsPenalty 
						from 
				    (select  convert(varchar(10),timestamp,120) as timestamp, avg(convert(numeric,fundex)) as fundex 
					 from fundex_fundexOverTime_fundexOverTimeList 
					 where timestamp >='".$startdate->format('Y-m-d')."' and timestamp <'".$finishdate->format('Y-m-d')."' and appId='".$key['id']."' 
					 group by convert(varchar(10),timestamp,120)) as sq1
						inner join 
					(select  convert(varchar(10),timestamp,120) as timestamp, avg(convert(numeric,actionPenalty)) as actionPenalty, avg(convert(numeric,launchPenalty)) as launchPenalty 
					 from fundex_fundexSummary_performancePenalty 
					 where timestamp >='".$startdate->format('Y-m-d')."' and timestamp <'".$finishdate->format('Y-m-d')."' and appId='".$key['id']."' 
					 group by convert(varchar(10),timestamp,120)) as sq2
					 on sq1.timestamp =sq2.timestamp
						inner join
					(select  convert(varchar(10),timestamp,120) as timestamp, avg(convert(numeric,batteryPenalty)) as batteryPenalty, avg(convert(numeric,networkPenalty)) as networkPenalty 
					 from fundex_fundexSummary_resourcesPenalty 
					 where timestamp >='".$startdate->format('Y-m-d')."' and timestamp <'".$finishdate->format('Y-m-d')."' and appId='".$key['id']."' 
					 group by convert(varchar(10),timestamp,120)) as sq3
					on sq1.timestamp=sq3.timestamp 
						inner join 
					(select  convert(varchar(10),timestamp,120) as timestamp, avg(convert(numeric,crashPenalty)) as crashPenalty, avg(convert(numeric,errorsPenalty)) as errorsPenalty 
					 from fundex_fundexSummary_stabilityPenalty 
					 where timestamp >='".$startdate->format('Y-m-d')."' and timestamp <'".$finishdate->format('Y-m-d')."' and appId='".$key['id']."' 
					 group by convert(varchar(10),timestamp,120))as sq4
					on sq1.timestamp=sq4.timestamp
					order by timestamp asc
					";
					
	//print $query_global."</br>";

	$SqlIDultimo=sqlsrv_query( $conn, $query_global);
	//$objultimo = sqlsrv_fetch_object($SqlIDultimo);
	$arreglodatos=array();
	$arreglopadre=array();
	while($objgraf = sqlsrv_fetch_array($SqlIDultimo)){
		//$arreglodatos["ts"]= strtotime(date_format($objgraf["timestamp"],'Y-m-d H:i:s')) * 1000;
		//$arreglodatos["timestamp"]= date_format($objgraf["timestamp"],'Y-m-d H:i:s');
		//print $objgraf["timestamp"]."</br>";
		$arreglodatos["ts"]= strtotime($objgraf["timestamp"]) * 1000;
		$arreglodatos["timestamp"]= $objgraf["timestamp"];
		$arreglodatos["fundex"]= round(floatval($objgraf["fundex"]));
		$arreglodatos["actionPenalty"]= round(floatval($objgraf["actionPenalty"]));
		$arreglodatos["launchPenalty"]= round(floatval($objgraf["launchPenalty"]));
		$arreglodatos["batteryPenalty"]= round(floatval($objgraf["batteryPenalty"]));
		$arreglodatos["networkPenalty"]= round(floatval($objgraf["networkPenalty"]));
		$arreglodatos["crashPenalty"]= round(floatval($objgraf["crashPenalty"]));
		$arreglodatos["errorsPenalty"]= round(floatval($objgraf["errorsPenalty"]));
		$arreglodatos["perdido"]= round(floatval($objgraf["actionPenalty"]) + floatval($objgraf["launchPenalty"]) + floatval($objgraf["batteryPenalty"]) + floatval($objgraf["networkPenalty"]) + floatval($objgraf["crashPenalty"]) + floatval($objgraf["errorsPenalty"])); ;
		array_push($arreglopadre,$arreglodatos);
	}	 
	$datos["data"] = $arreglopadre;	 
	array_push($todo,$datos);
}
print json_encode($todo);

?>
