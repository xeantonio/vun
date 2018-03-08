<?php

$serverName="192.168.4.18";
	$uid="sa";
	$pwd="qwe123.,";
	$connectionInfo = array( "UID"=>$uid,"PWD"=>$pwd,"Database"=>"apppulse2");
	$conn = sqlsrv_connect( $serverName, $connectionInfo);

		/*
		-- --------------------------------------------------------------------------------------------------------------------------- --
		--  determinar fecha de ultima actualizacion de monitoreo en tiempo real
		-- --------------------------------------------------------------------------------------------------------------------------- --
		*/

		$queryultimo="select convert(varchar(5),max(timestamp),108) as ultimo from fundex_fundexOverTime_fundexOverTimeList";
		$SqlIDultimo=sqlsrv_query( $conn, $queryultimo);
		$objultimo = sqlsrv_fetch_object($SqlIDultimo);

?>