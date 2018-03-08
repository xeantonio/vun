
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

$appsids = implode("','", array_map(function ($entry) {
  return $entry['id'];
}, $apps));


$todo = array();
$datos = array();
//foreach($apps as $key){
//	$datos['label'] = $key['label'];
//	$datos['id'] = $key['id'];
	
	
	
$query_global = "select
					convert(varchar(10),q1.timestamp,120) as timestamp,
					sum(convert(int,actions)) as actions,
					sum(convert(int,q1.actionsWithErrors)) as appActionsWithErrors,
					sum(convert(int,q2.actionsWithErrors)) as clientActionsWithErrors,
					sum(convert(int,q3.actionsWithErrors)) as networkActionsWithErrors,
					sum(convert(int,q4.actionsWithErrors)) as sdkActionsWithErrors	  
				from 
					(select 
						sum(convert(int,actions)) as actions,
						convert(varchar(10),timestamp,120) as timestamp,
						sum(convert(int,actionsWithErrors)) as actionsWithErrors 
					 from 
						stability_errors_stabilityGetAllErrorsData_errorsSummary_appsErrors
					 where 
						appId  in ('".$appsids."') and 
						timestamp>='".$startdate->format('Y-m-d')."' and 
						timestamp<'".$finishdate->format('Y-m-d')."'	
					 group by convert(varchar(10),timestamp,120)
					 ) as q1
					 
					inner join
					
					(select 
						convert(varchar(10),timestamp,120) as timestamp,
						sum(convert(int,actionsWithErrors)) as actionsWithErrors 
					 from 
						stability_errors_stabilityGetAllErrorsData_errorsSummary_clientErrors
					 where 
						appId  in ('".$appsids."') and 
						timestamp>='".$startdate->format('Y-m-d')."' and 
						timestamp<'".$finishdate->format('Y-m-d')."' 
					 group by convert(varchar(10),timestamp,120)
					 ) as q2
					on q1.timestamp = q2.timestamp
					
					inner join
					
					(select 
						convert(varchar(10),timestamp,120) as timestamp,
						sum(convert(int,actionsWithErrors)) as actionsWithErrors 
					 from 
						stability_errors_stabilityGetAllErrorsData_errorsSummary_networkErrors
					 where 
						appId  in ('".$appsids."') and 
						timestamp>='".$startdate->format('Y-m-d')."' and 
						timestamp<'".$finishdate->format('Y-m-d')."' 
					 group by convert(varchar(10),timestamp,120)
					 ) as q3
					on q1.timestamp = q3.timestamp
					
					inner join
					
					(select 
						convert(varchar(10),timestamp,120) as timestamp,
						sum(convert(int,actionsWithErrors)) as actionsWithErrors  
					 from stability_errors_stabilityGetAllErrorsData_errorsSummary_sdkErrors
					 where 
						appId  in ('".$appsids."') and 
						timestamp>='".$startdate->format('Y-m-d')."' and 
						timestamp<'".$finishdate->format('Y-m-d')."'  
					 group by convert(varchar(10),timestamp,120)
					 ) as q4
					on q1.timestamp = q4.timestamp
					
				group by convert(varchar(10),q1.timestamp,120)";	

//print $query_global."</br>";

$SqlIDultimo=sqlsrv_query( $conn, $query_global);
//$objultimo = sqlsrv_fetch_object($SqlIDultimo);
$arreglodatos=array();
$arreglopadre=array();
while($objgraf = sqlsrv_fetch_array($SqlIDultimo)){

	$arreglodatos["timestamp"]= $objgraf["timestamp"];
	$arreglodatos["actions"]= intval($objgraf["actions"]);
	$arreglodatos["appActionsWithErrors"]= intval($objgraf["appActionsWithErrors"]);
	$arreglodatos["clientActionsWithErrors"]= intval($objgraf["clientActionsWithErrors"]);		
	$arreglodatos["networkActionsWithErrors"]= intval($objgraf["networkActionsWithErrors"]);
	$arreglodatos["sdkActionsWithErrors"]= intval($objgraf["sdkActionsWithErrors"]);		
	array_push($arreglopadre,$arreglodatos);
}	 
$datos["data"] = $arreglopadre;	 
array_push($todo,$datos);
//}
print json_encode($todo);



?>
