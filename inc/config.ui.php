<?php

//CONFIGURATION for SmartAdmin UI

//ribbon breadcrumbs config
//array("Display Name" => "URL");
$breadcrumbs = array(
	"Home" => APP_URL
);

/*navigation array config

ex:
"dashboard" => array(
	"title" => "Display Title",
	"url" => "http://yoururl.com",
	"url_target" => "_self",
	"icon" => "fa-home",
	"label_htm" => "<span>Add your custom label/badge html here</span>",
	"sub" => array() //contains array of sub items with the same format as the parent
)

*/

$arregloiconos=array();
$arregloiconos[0]="fa-tasks";
$arregloiconos[1]="fa-cube";
$arregloiconos[2]="fa-codepen";
$arregloiconos[3]="fa-sliders";
$arregloiconos[4]="fa-building";
$arregloiconos[5]="fa-cog";
$arregloiconos[6]="fa-code";
$arregloiconos[7]="fa-laptop";
$arregloiconos[8]="fa-bank";
$arregloiconos[9]="fa-cloud";
$arregloiconos[10]="fa-dashboard";
$arregloiconos[11]="fa-signal";
$arregloiconos[12]="fa-tasks";
$arregloiconos[13]="fa-sign-in";
$arregloiconos[14]="fa-sort-amount-asc";
$arregloiconos[15]="fa-signal";



$serverName="192.168.4.21";
$uid="sa";
$pwd="tsoft";
$connectionInfo = array( "UID"=>$uid,"PWD"=>$pwd,"Database"=>"vun_mexico");

$conn = sqlsrv_connect( $serverName, $connectionInfo);
if( $conn === false )
{
     echo "Unable to connect.</br>";
     die( print_r( sqlsrv_errors(), true));
}
date_default_timezone_set('America/Mexico_City');

//crear clase para los parametros necesarios.

$page_nav = array();
//print ".......................................".$_SESSION["canales"];
if (!isset($_SESSION["canales"])){
	$canales=0;
}else{

	$canales=$_SESSION["canales"];
	//if($_SESSION["rol"]==1 || $_SESSION["rol"]==4 ){
	if($_SESSION["rol"]==1 || $_SESSION["rol"]==7 ){
		$page_nav["blank"]=array(
			"title" => "Visor Unico de Negocios",
			"url"=>"#",
			"icon" => "fa-bar-chart-o",
			"sub"=>array(
				"home" => array(
						"title" => "Vista Principal",
						"icon" => "fa-home",
						"url" => APP_URL."/index.php"
					)
			)
		);
		$page_nav["blank"]["active"] = true;

		$qrycanales="select  * from canales where IdCanal in(".$canales.") and IdCanal>1";
		$SqlID=sqlsrv_query( $conn, $qrycanales);
		$i=0;
		$arreglocanalesprincipal=array();
		$arreglocanalesprincipalID=array();
		$arreglosubs=array();
		while($obj = sqlsrv_fetch_object($SqlID)){ #PRIMER WHILE CANALES<--------
			$nombremenu=str_replace(' ', '',$obj->NombreCanalBac);
			$paso= array("title" => ucfirst(strtolower($obj->NombreCanal)),
				"url" =>"errors.php?dato=".$obj->NombreCanalBac."&canal=".$obj->IdCanal,
				"icon" => $arregloiconos[$i]);
			

			array_push($page_nav["blank"]["sub"], $paso);


			$i++;
			$arreglocanalesprincipal[$obj->NombreCanalBac]=$obj->NombreCanal;
			$arreglocanalesprincipalID[$obj->NombreCanalBac]=$obj->IdCanal;
		}

	}
	if($_SESSION["rol"]==1 || $_SESSION["rol"]==2 ){
		$page_nav["apppulse_negocio"]=array(
			"title" => "AppPulse Negocio",
			"url" =>"#",
			"icon" => "".$arregloiconos[15]."",
			"sub" => array(
				"fundex" => array(
					"title" => "Fundex",
					"icon" => "fa-gear",
					"url" => APP_URL."/fundex1.php"
				),
			    "numeros_semanal" => array(
			        "title" => "Numeros Generales Semanal",
			        "icon" => "fa-ge",
			        "url" => APP_URL."/nros_grales.php"
			    ),
			    "geolocalizacion" => array(
			        "title" => "Geolocalizacion",
			        "icon" => "fa-globe",
			        "url" => APP_URL."/geolocalizacion.php"
			    ),
			    "topaises" => array(
			        "title" => "Top 10 paises",
			        "icon" => "fa-th",
			        "url" => APP_URL."/top_10.php"
			    ),
			    "accesos" => array(
			        "title" => "Accesos totales",
			        "icon" => "fa-group",
			        "url" => APP_URL."/accesos_totales.php"
			    ),
			    "dispositivo" => array(
			        "title" => "Desempe&ntilde;o por dispositivo",
			        "icon" => "fa-tablet",
			        "url" => APP_URL."/desempeno.php"
			    ),
			    "sesiones" => array(
			        "title" => "Sesiones por pantalla",
			        "icon" => "fa-laptop",
			        "url" => APP_URL."/sesiones_pantalla.php"
			    ),
			    "recursos" => array(
			        "title" => "An&aacute;lisis de recursos",
			        "icon" => "fa-barcode",
			        //"url" => APP_URL."/consumo_recursos.php"
					"url" => APP_URL."/analisis_consumo_recursos_tec.php"
			    ),
			    "estabilidad" => array(
			        "title" => "An&aacute;lisis Estabilidad/Por Acciones",
			        "icon" => "fa-qrcode",
			        "url" => APP_URL."/nalisis_estabilidad_acciones.php"
			    )
			)
		);
		if($_SESSION["rol"]==2){
			$page_nav["apppulse_negocio"]["active"] = true;
		}

	}
	if($_SESSION["rol"]==1 || $_SESSION["rol"]==3){
		$page_nav["apppulse_tecnologia"]=array
		(
			"title" => "AppPulse Tecnolog&iacute;a",
			"url" =>"#",
			"icon" => "".$arregloiconos[14]."",
			"sub" => array(
				"fundex" => array(
					"title" => "Fundex",
					"icon" => "fa-gear",
					"url" => APP_URL."/fundex_tec1.php"
				),
				"analisis_crashes" => array(
					"title" => "An&aacute;lisis Estabilidad/Crashes",
					"icon" => "fa-qrcode",
					"url" => APP_URL."/analisis_estabilidad_crashes.php"
				),
				"analisis_acciones" => array(
					"title" => "An&aacute;lisis Estabilidad/Acciones",
					"icon" => "fa-barcode",
					"url" => APP_URL."/analisis_estabilidad_acciones.php"
				),
				"analisis_recursos" => array(
					"title" => "An&aacute;lisis de recursos",
					"icon" => "fa-ge",
					"url" => APP_URL."/analisis_consumo_recursos_tec.php"
				)
			)
		);
		if($_SESSION["rol"]==3){
			$page_nav["apppulse_tecnologia"]["active"] = true;
		}
	}

}


if(isset($_SESSION["rol"])){
	if($_SESSION["rol"]==1){
		$page_nav["users"]=array(
			"title" => "Usuarios",
			"url" =>"#",
			"icon" => "fa-users"

		);
	}
}


if(isset($_SESSION["rol"])){
	if($_SESSION["rol"]==1 || $_SESSION["rol"]==2 || $_SESSION["rol"]==3){
		$page_nav["reportes"]=array(
			"title" => "Reporte App Pulse",
			"url" => APP_URL."/apppulse_reportes.php",
			"icon" => "fa-book"

		);
	}
}


$page_nav["salir"]= array(
	"title" => "Salir",
	"url" =>"login.php?logout=true",
	"icon" => "fa-undo"
);




//configuration variables
$page_title = "Visor Unico de Negocios";
$page_css = array();
$no_main_header = false; //set true for lock.php and login.php
$page_body_prop = array(); //optional properties for <body>
$page_html_prop = array(); //optional properties for <html>
?>