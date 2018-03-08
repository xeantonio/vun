<?php
date_default_timezone_set('America/Mexico_City');
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
$x=2;
print "===================================================== START =====================================================";
print "\n".date('Y-m-d H:i:s')."\n";
while ($x<=14){
	$qryconexmngtbsm="SELECT mc.*, c.NombreCanalBac, c.NombreCanal  FROM vunweb_mapaconexbsm as mc, canales as c WHERE mc.canal_idcanal=c.idcanal and mc.canal_idcanal=".$x;	
	//$qryconexmngtbsm="SELECT mc.*, c.NombreCanalBac, c.NombreCanal  FROM vunweb_mapaconexbsm as mc, canales as c WHERE mc.canal_idcanal=c.idcanal and mc.canal_idcanal=3";	
	$SqlIDconexmngtbsm=sqlsrv_query( $conn, $qryconexmngtbsm,array(), array( "Scrollable" => 'static' ));
	
	$objconexmngtbsm = sqlsrv_fetch_object($SqlIDconexmngtbsm);
	$serverName=$objconexmngtbsm->urlserver;
	$uid=$objconexmngtbsm->usuario;
	$pwd=$objconexmngtbsm->contrasena;
	$connectionInfo3 = array( "UID"=>$uid,"PWD"=>$pwd,"Database"=>$objconexmngtbsm->bd);
	$cone3 = sqlsrv_connect( $serverName, $connectionInfo3);
	if( $cone3 === false )
	{
		echo "Unable to connect to ErrorsDatabase".$objconexmngtbsm->bd.".</br>";
		die( print_r( sqlsrv_errors(), true));
	}else{
		echo "it's connected to.....".$objconexmngtbsm->bd."\n";
		$fechafinal=new DateTime();
		date_add($fechafinal, date_interval_create_from_date_string('-15 minutes'));

		/*
		--- ------------------------------------------------------------------------------------------------------------ ---
		--- EXTRAYENDO DATOS DE LA SNAPSHOT 
		--- ------------------------------------------------------------------------------------------------------------ ---
		*/
		$queryextraesnap="
			select TUID,DBDATE,INTERNAL_TRANSACTION_ID, substring(convert(varchar,dbdate,126),12,5) as HORA
			FROM BPM_TRANS_ERR_SNAP_10000 AS sn
			WHERE sn.dbdate >= '".date_format($fechafinal, 'Y-m-d H:i:s')."'
			AND internal_transaction_id IN(
				SELECT DISTINCT INTERNAL_TRANSACTION_ID FROM (
					SELECT  ER.TUID, er.dbdate, substring(convert(varchar,er.dbdate,126),12,5) as hora, er.EME_EM_ERR_TYPE_ID, er.INTERNAL_TRANSACTION_ID, er.SCRIPT_ID, er.BPM_AGENT_ID, 
					er.SERVER_IP, er.SERVER_NAME, er.EME_ERR_TEXT, AG.BPM_AGENT_NAME,IL.LOCATION_NAME, t.TRANSACTION_NAME, t.APPLICATION_NAME 
					FROM BPM_TRANS_ERRS_10000 as ER LEFT JOIN LOCATIONS_DIM as IL
					ON ER.INTERNAL_LOCATION_ID = IL.INTERNAL_LOCATION_ID,BPM_AGENTS_DIM AS AG, TRANSACTIONS_DIM as T 
					where ER.BPM_AGENT_ID=AG.BPM_AGENT_ID 
					and ER.dbdate>='".date_format($fechafinal, 'Y-m-d H:i:s')."'
					--AND T.APPLICATION_NAME='".$objconexmngtbsm->NombreCanalBac."'
					and er.INTERNAL_TRANSACTION_ID=t.INTERNAL_TRANSACTION_ID AND EME_EM_ERR_TYPE_ID NOT IN (6) 
					group by ER.TUID, er.dbdate, er.EME_EM_ERR_TYPE_ID, er.INTERNAL_TRANSACTION_ID, er.SCRIPT_ID, er.BPM_AGENT_ID, er.SERVER_IP,
					er.SERVER_NAME, er.EME_ERR_TEXT, AG.BPM_AGENT_NAME, t.TRANSACTION_NAME, t.APPLICATION_NAME,IL.LOCATION_NAME 		
				) AS Q
			) 
			ORDER BY DBDATE 	
		";
						
		//print $queryextraesnap."\n\n\n";
		//exit;
		echo "====================Extrayendo informacion de SNAPSHOT====================\n";
		$SqlIDimportsnap=sqlsrv_query( $cone3, $queryextraesnap,array(), array( "Scrollable" => 'static' ));
		if (sqlsrv_num_rows($SqlIDimportsnap)>=1){
			print "Se encontraron ".sqlsrv_num_rows($SqlIDimportsnap)." SNAPSHOTS\n";
			$arrsnap=array();
			$arrsnap[0]="|";
			$arrsnap[1]="/";
			$arrsnap[2]="-";
			$arrsnap[3]="\\";
			$y=0;
			while($objimportsnap=sqlsrv_fetch_object($SqlIDimportsnap)){
				print "Procesando Snapshots...".$arrsnap[$y]."\r";
				if ($y<3){
					$y++;
				}else{
					$y=0;
				}
				$fechasnap=date_format($objimportsnap->DBDATE, 'Y-m-d H:i:s');
				$qryinsertsnpa="INSERT INTO vunweb_snapd VALUES('".$objimportsnap->TUID."','".$fechasnap."',".$objimportsnap->INTERNAL_TRANSACTION_ID.",'".$objimportsnap->HORA."','".$objconexmngtbsm->NombreCanalBac."')";
				//print $qryinsertsnpa."\n";
				$SqlIDinsertasnap=sqlsrv_query( $conn, $qryinsertsnpa,array(), array( "Scrollable" => 'static' ));	
			}
			print "\n";
		}else{
			print "No se encontraron resultados\n";
			
		}		
		$x++;
		//print $x;					
		sqlsrv_close($cone3);
	}// SI HAY CONEXCION(IF)
	
} //WHILE CONTROLA RECORRDIO DE CANALES

print "===================================================== END =====================================================";
print "\n".date('Y-m-d H:i:s')."\n";
?>

