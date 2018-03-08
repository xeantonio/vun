<?php
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

/*borrar resultados del dia anterior */
$qryborraanteriores="delete from vunweb_resultadoshoy where vunweb_reshoyFecha<'".date("Y-m-d")."'";
$SqlID=sqlsrv_query( $conn, $qryborraanteriores,array(), array( "Scrollable" => 'static' ));
//print sqlsrv_num_rows($SqlID);

//crear clase para los parametros necesarios.
$qrycanales="select  * from canales where IdCanal >1 ";
$SqlID=sqlsrv_query( $conn, $qrycanales);

$cliente = new SoapClient("http://190.210.215.9:8081/topaz/gdeopenapi/services/GdeWsOpenAPI?wsdl");


$fechainicio=new DateTime();
//$fechainicio->setTime(00, 00, 01);
date_add($fechainicio, date_interval_create_from_date_string('-15 minutes'));
$fechafin = new DateTime();

while($obj = sqlsrv_fetch_object($SqlID)){ #PRIMER WHILE CANALES<--------
     print "----------------------------------------------- ".$obj->NombreCanalBac." ------------------------------------------------------<br><br><br>";
    //inicio cliente SOAP
    
    print_r($fechainicio);
    print "<br>\n";
    print_r($fechafin);
    print "<br>\n";


    $usuario="admin";
    $contrasena="t50ft123";
    /*
    -- ESTOS SON LOS CAMPOS QUE SE EXTRAEN DE LA CONSULTA:
        1   time_stamp FECHA Y HORA DE LA METRICA
        2   dResponseTime TIEMPO DE RESPUESTA DE LA TRANSACCION
        3   u_iStatus PASS, FAIL, ETC DISPONIBILIDAD
        4   szLocationName, NOMBRE DEL BPM
        5   szTransactionName, NOMBRE DEL SERVICIO}
        6   application_name, NOMBRE EN BSM DEL CANAL
        7   szBTFName, NOMBRE EN BSM DE LA SECCION
        8   ErrorCount, NUMERO DE ERRORES REPORTADOS NO SE USA
    */
    $consulta="select time_stamp, dResponseTime, u_iStatus,szLocationName, szTransactionName, application_name, szBTFName, ErrorCount from trans_t where time_stamp>=".$fechainicio->getTimeStamp()." and time_stamp <=".$fechafin->getTimeStamp()." and application_name='".$obj->NombreCanalBac."' order by 5,1";
    print "Ejecutando...... [".$obj->NombreCanalBac."] ".$consulta."<br>\n<br>\n"; 

    
    $consultaerrores="select time_stamp, application_name, TUID, szBTFName, szLocationName, szStrMsg, szTransactionName  from trans_err_t where time_stamp>=".$fechainicio->getTimeStamp()." and time_stamp <=".$fechafin->getTimeStamp()." and application_name='".$obj->NombreCanalBac."' order by 1,2";
    print "Ejecutando...... [".$obj->NombreCanalBac."] ".$consultaerrores."<br>\n<br>\n"; 

    //hago la llamada pasando por parámetro un objeto como el que se define arriba
    $respuesta = $cliente->getDataWebService($usuario,$contrasena,$consulta);
    $respuestaerrores = $cliente->getDataWebService($usuario,$contrasena,$consultaerrores);
    //print_r($respuesta["retval"]);
    //exit;

    $str = explode (",\n", $respuesta["retval"]);
    $strerrores = explode (",\n", $respuestaerrores["retval"]);
    //print count($str)."<br>\n";
    //print $respuesta["origRowCount"]."<br>\n";
    for ($i=1;$i<=count($strerrores)-2;$i++){
        $strerrores2 = explode (",",$strerrores[$i]);
        for ($j=0;$j<=count($strerrores2)-1;$j++){
            if ($j==0){
                $strerrores2[$j]=$strerrores2[$j]+0;   
            }
        }
        //print_r($strerrores);
        //print "<br><br><br>";
        $cadenainserta="insert into vunweb_ImportedErrorWS values('".date('m/d/Y H:i:s', $strerrores2[0])."','".$strerrores2[1]."','".$strerrores2[2]."','".$strerrores2[3]."','".$strerrores2[4]."','".$strerrores2[5]."');";
        //print $cadenainserta."<br>\n";
        $SqlIDsecc=sqlsrv_query( $conn, $cadenainserta,array(), array( "Scrollable" => 'static' ));
    }

   
    for ($i=1;$i<=count($str)-2;$i++){
        print "[".$i."]";
        $str2 = explode (",", $str[$i]);
        for ($j=0;$j<=count($str2)-1;$j++){
            if ($j==0){
                $str2[$j]=$str2[$j]+0;   
            }
            
            if ($j==2){
                if($str2[$j]==0){
                    $str2[$j]="PASS";
                }elseif($str2[$j]==1){
                    $str2[$j]="FAIL";
                }elseif($str2[$j]==2){
                    $str2[$j]="NO_DATA";
                }elseif($str2[$j]==6){
                    $str2[$j]="NO_DATA";
                }else{
                    $str2[$j]="NO_DATA";
                }
            }
        }
        $cadenainserta="insert into vunweb_resultadoshoy values('".date('m/d/Y H:i:s', $str2[0])."',".intval($str2[1]).",'".$str2[2]."','".$str2[3]."','".$str2[4]."','".$str2[5]."','".$str2[6]."',".$str2[7].");";
        print $cadenainserta."<br>\n";
        $SqlIDsecc=sqlsrv_query( $conn, $cadenainserta,array(), array( "Scrollable" => 'static' ));
    }
    print "ya termine<br>\n<br>\n";
}
?>