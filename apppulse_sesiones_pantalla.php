
<?php
header("Content-Type: application/json; charset=UTF-8");
//header('Content-Type: text/html; charset= ISO-8859-1');

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');


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
					 t1.PantallaReconocida as PantallaReconocida,
					 t1.AccionReconocida as AccionReconocida,
					 sum(convert(numeric,t2.averageHits)) as averageHits,
					 sum(convert(numeric,t2.avgAffectedUsersCrashes)) as avgAffectedUsersCrashes
				from 
					Pantalla_Accion t1
				inner join
					usage_usageActionsList_usageActionUIBeanList t2
				on t1.originalContext = t2.originalContextName and t1.originalAction = t2.originalActionName
				where 
					t2.appId in ('".$appsids."') and
					t2.timestamp>='".$startdate->format('Y-m-d')."' and
					t2.timestamp<'".$finishdate->format('Y-m-d')."' and
					t2.actionGesture = 'Tap' and
					t1.PantallaReconocida is not null and
					t1.AccionReconocida is not null and
					t1.PantallaReconocida != '' and
					t1.AccionReconocida != ''					
				group by t2.originalContextName,t2.originalActionName,t1.AccionReconocida, t1.PantallaReconocida
				order by
					t2.originalContextName asc";

				
	//print $query_global."</br>";

$SqlIDultimo=sqlsrv_query( $conn, $query_global);
//$objultimo = sqlsrv_fetch_object($SqlIDultimo);
$arreglodatos=array();
$arreglopadre=array();
while($objgraf = sqlsrv_fetch_array($SqlIDultimo)){
	
	$arreglodatos["PantallaReconocida"]= utf8_encode($objgraf["PantallaReconocida"]);
	$arreglodatos["AccionReconocida"]= utf8_encode($objgraf["AccionReconocida"]);
	$arreglodatos["averageHits"]= intval($objgraf["averageHits"]);
	$arreglodatos["avgAffectedUsersCrashes"]= intval($objgraf["avgAffectedUsersCrashes"]);
	array_push($arreglopadre,$arreglodatos);
}	 
$datos["data"] = $arreglopadre;	 
array_push($todo,$datos);
//}
print json_encode($todo);


?>
