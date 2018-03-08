<?php
$querydh="

select min((rh.vunweb_reshoyTR/1000)) as TRMIN, max((rh.vunweb_reshoyTR/1000)) as TRMAX, 
SUM(CASE WHEN (rh.vunweb_reshoyTR/1000)>=30 AND vunweb_reshoyStatus<>'NO_DATA' THEN 1 ELSE 0 END) AS FAILPERF,
SUM(CASE WHEN (rh.vunweb_reshoyTR/1000)>=30 AND vunweb_reshoyStatus<>'NO_DATA' THEN 0 ELSE 1 END) AS PASSPERF,
100-(((SUM(CASE WHEN (rh.vunweb_reshoyTR/1000)>=30 AND vunweb_reshoyStatus<>'NO_DATA' THEN 1 ELSE 0 END))/convert(decimal(10,5),SUM(CASE WHEN vunweb_reshoyStatus<>'NO_DATA' THEN 1 ELSE 0 END)))) AS TOTALPERF,

SUM(CASE WHEN vunweb_reshoyStatus='FAIL' THEN 1 ELSE 0 END) AS FAILDISPO,
SUM(CASE WHEN vunweb_reshoyStatus='PASS' THEN 1 ELSE 0 END) AS PASSDISPO,
100-(((SUM(CASE WHEN vunweb_reshoyStatus='FAIL' THEN 1 ELSE 0 END)*100)/convert(decimal(10,5),SUM(CASE WHEN vunweb_reshoyStatus<>'NO_DATA' THEN 1 ELSE 0 END)))) AS TOTALDISPO,

100-(((SUM(CASE WHEN (rh.vunweb_reshoyTR/1000)>=30 AND vunweb_reshoyStatus<>'NO_DATA' THEN 1 ELSE 0 END)+SUM(CASE WHEN vunweb_reshoyStatus='FAIL' THEN 1 ELSE 0 END))/(convert(decimal(10,5),SUM(CASE WHEN vunweb_reshoyStatus<>'NO_DATA' THEN 1 ELSE 0 END))*2))*100) AS GLOBAL,

(sum(CASE WHEN vunweb_reshoyStatus IN ('PASS','FAIL') THEN 1 ELSE 0 END)*2) AS TOTALMETRICAS

from vunweb_resultadoshoy as rh, 
canales as c 
where c.NombreCanalBac='".$arreglonombresbac[$i]."'
and c.NombreCanalBac = rh.vunweb_reshoyCanal 
and vunweb_reshoyFecha>='".date_format($fechauptime, 'Y-m-d')."' 
AND vunweb_reshoyStatus<>'NO_DATA'

";
//print $querydh."<br><br><br>";
$SqlIDdatoshoy=sqlsrv_query( $conn, $querydh,array(), array( "Scrollable" => 'static' ));
if ($SqlIDdatoshoy){
	$objdh = sqlsrv_fetch_object($SqlIDdatoshoy);

	/*.CONTRUYENDO GRAFICO DE MONITOREO EN TIEMPO REAL PARA GLOBAL*/
	if(number_format($objdh->GLOBAL,2)>=number_format($arreglodtmeta[$i],2)){
		$colorglobalhoy="green";
		$infoglobalhoy="<div class='txt-color-".$colorglobalhoy."' ><i class='glyphicon glyphicon-check'></i>".number_format($objdh->GLOBAL,2)."</div>";
	}elseif(number_format($objdh->GLOBAL,2)<number_format($arreglodtmeta[$i],2) && number_format($objdh->GLOBAL,2)>=number_format($arreglodtmeta[$i],2)-0.21){
		$colorglobalhoy="orange";
		$infoglobalhoy="<div class='txt-color-".$colorglobalhoy."'><i class='glyphicon glyphicon-info-sign'></i>".number_format($objdh->GLOBAL,2)."</div>";
	}elseif(number_format($objdh->GLOBAL,2)<number_format($arreglodtmeta[$i],2) && number_format($objdh->GLOBAL,2)>=1){
		$colorglobalhoy="red";
		$infoglobalhoy="<div class='txt-color-".$colorglobalhoy."'><i class='glyphicon glyphicon-remove-circle'></i>".number_format($objdh->GLOBAL,2)."</div>";
	}elseif(number_format($objdh->GLOBAL,2)<1){
		$colorglobalhoy="blue";
		$infoglobalhoy="<div class='txt-color-".$colorglobalhoy."'><i class='glyphicon glyphicon-minus-sign'></i>".number_format($objdh->GLOBAL,2)."</div>";
		
	}

	$dhglobal="
		<div class='label bg-color-blueDark txt-color-white font-sm'>Monitoreo en Tiempo Real: </div><br><br>
		<div class='font-xl'>".$infoglobalhoy."</div>
		<table class='table no-bordered'>
		<tbody>
		<tr>
			<td>Metricas</td>
			<td align='right'><div class='badge bg-color-".$colorglobalhoy." txt-color-white'>".$objdh->TOTALMETRICAS."</div><td>
		</tr>
		<tr>
			<td>PASS</td>
			<td align='right'><div class='badge bg-color-".$colorglobalhoy." txt-color-white'>".($objdh->PASSDISPO+$objdh->PASSPERF)."</div><td>
		</tr>
		<tr>
			<td>FAIL</td>
			<td align='right'><div class='badge bg-color-".$colorglobalhoy." txt-color-white'>".($objdh->FAILPERF+$objdh->FAILDISPO)."</div><td>
		</tr>
		</tbody>
		</table>";




	/*.CONTRUYENDO GRAFICO DE MONITOREO EN TIEMPO REAL PARA DISPO*/
	if(number_format($objdh->TOTALDISPO,2)>=number_format($arreglodtmeta[$i],2)){
		$colorTOTALDISPOhoy="green";
		$infoTOTALDISPOhoy="<div class='txt-color-".$colorTOTALDISPOhoy."' ><i class='glyphicon glyphicon-check'></i>".number_format($objdh->TOTALDISPO,2)."</div>";
	}elseif(number_format($objdh->TOTALDISPO,2)<number_format($arreglodtmeta[$i],2) && number_format($objdh->TOTALDISPO,2)>=number_format($arreglodtmeta[$i],2)-0.21){
		$colorTOTALDISPOhoy="orange";
		$infoTOTALDISPOhoy="<div class='txt-color-".$colorTOTALDISPOhoy."'><i class='glyphicon glyphicon-info-sign'></i>".number_format($objdh->TOTALDISPO,2)."</div>";
	}elseif(number_format($objdh->TOTALDISPO,2)<number_format($arreglodtmeta[$i],2) && number_format($objdh->TOTALDISPO,2)>=1){
		$colorTOTALDISPOhoy="red";
		$infoTOTALDISPOhoy="<div class='txt-color-".$colorTOTALDISPOhoy."'><i class='glyphicon glyphicon-remove-circle'></i>".number_format($objdh->TOTALDISPO,2)."</div>";
	}elseif(number_format($objdh->TOTALDISPO,2)<1){
		$colorTOTALDISPOhoy="blue";
		$infoTOTALDISPOhoy="<div class='txt-color-".$colorTOTALDISPOhoy."'><i class='glyphicon glyphicon-minus-sign'></i>".number_format($objdh->TOTALDISPO,2)."</div>";
		
	}

	$dhTOTALDISPO="
		<div class='label bg-color-blueDark txt-color-white font-sm'>Monitoreo en Tiempo Real: </div><br><br>
		<div class='font-xl'>".$infoTOTALDISPOhoy."</div>
		<table class='table no-bordered'>
		<tbody>
		<tr>
			<td>Metricas</td>
			<td align='right'><div class='badge bg-color-".$colorTOTALDISPOhoy." txt-color-white'>".($objdh->FAILDISPO+$objdh->PASSDISPO)."</div><td>
		</tr>
		<tr>
			<td>PASS</td>
			<td align='right'><div class='badge bg-color-".$colorTOTALDISPOhoy." txt-color-white'>".$objdh->PASSDISPO."</div><td>
		</tr>
		<tr>
			<td>FAIL</td>
			<td align='right'><div class='badge bg-color-".$colorTOTALDISPOhoy." txt-color-white'>".$objdh->FAILDISPO."</div><td>
		</tr>
		</tbody>
		</table>";



/*.CONTRUYENDO GRAFICO DE MONITOREO EN TIEMPO REAL PARA PERF*/
	if(number_format($objdh->TOTALPERF,2)>=number_format($arreglodtmeta[$i],2)){
		$colorTOTALPERFhoy="green";
		$infoTOTALPERFhoy="<div class='txt-color-".$colorTOTALPERFhoy."' ><i class='glyphicon glyphicon-check'></i>".number_format($objdh->TOTALPERF,2)."</div>";
	}elseif(number_format($objdh->TOTALPERF,2)<number_format($arreglodtmeta[$i],2) && number_format($objdh->TOTALPERF,2)>=number_format($arreglodtmeta[$i],2)-0.21){
		$colorTOTALPERFhoy="orange";
		$infoTOTALPERFhoy="<div class='txt-color-".$colorTOTALPERFhoy."'><i class='glyphicon glyphicon-info-sign'></i>".number_format($objdh->TOTALPERF,2)."</div>";
	}elseif(number_format($objdh->TOTALPERF,2)<number_format($arreglodtmeta[$i],2) && number_format($objdh->TOTALPERF,2)>=1){
		$colorTOTALPERFhoy="red";
		$infoTOTALPERFhoy="<div class='txt-color-".$colorTOTALPERFhoy."'><i class='glyphicon glyphicon-remove-circle'></i>".number_format($objdh->TOTALPERF,2)."</div>";
	}elseif(number_format($objdh->TOTALPERF,2)<1){
		$colorTOTALPERFhoy="blue";
		$infoTOTALPERFhoy="<div class='txt-color-".$colorTOTALPERFhoy."'><i class='glyphicon glyphicon-minus-sign'></i>".number_format($objdh->TOTALPERF,2)."</div>";
		
	}
 
	$dhTOTALPERF="
		<div class='label bg-color-blueDark txt-color-white font-sm'>Monitoreo en Tiempo Real: </div><br><br>
		<div class='font-xl'>".$infoTOTALPERFhoy."</div>
		<table class='table no-bordered'>
		<tbody>
		<tr>
			<td>Metricas</td>
			<td align='right'><div class='badge bg-color-".$colorTOTALPERFhoy." txt-color-white'>".($objdh->FAILPERF+$objdh->PASSPERF)."</div><td>
		</tr>
		<tr>
			<td>PASS</td>
			<td align='right'><div class='badge bg-color-".$colorTOTALPERFhoy." txt-color-white'>".$objdh->PASSPERF."</div><td>
		</tr>
		<tr>
			<td>FAIL</td>
			<td align='right'><div class='badge bg-color-".$colorTOTALPERFhoy." txt-color-white'>".$objdh->FAILPERF."</div><td>
		</tr>
		</tbody>
		</table>";
		
}

/*
------------------------------------------------------------------------------------------------------ --
-- DATOS DE ERRORES
-- --------------------------------------------------------------------------------------------------- --
*/

$querydh="

select convert(varchar(16),rh.vunweb_reshoyFecha,121)as fecha , (rh.vunweb_reshoyTR/1000) as TR, 
rh.vunweb_reshoyStatus as estado, 
sc.sondacanal_nombrevun,
convert(varchar(2),rh.vunweb_reshoyFecha,108) as horaerror
from vunweb_resultadoshoy as rh, canales as c, VUNWEB_SONDACANAL AS sc
where c.NombreCanalBac='".$arreglonombresbac[$i]."'
and c.NombreCanalBac = rh.vunweb_reshoyCanal and vunweb_reshoyFecha>='".date_format($fechauptime, 'Y-m-d')."' 
and vunweb_reshoyStatus='FAIL' 
and vunweb_reshoySonda=sc.sondacanal_nombresonda
group by convert(varchar(16),rh.vunweb_reshoyFecha,121), (rh.vunweb_reshoyTR/1000), vunweb_reshoyStatus, sc.sondacanal_nombrevun,
convert(varchar(2),rh.vunweb_reshoyFecha,108)

UNION ALL

select convert(varchar(16),rh.vunweb_reshoyFecha,121)as fecha , (rh.vunweb_reshoyTR/1000) as TR, 
rh.vunweb_reshoyStatus as estado, 
sc.sondacanal_nombrevun,
convert(varchar(2),rh.vunweb_reshoyFecha,108)
from vunweb_resultadoshoy as rh, canales as c, VUNWEB_SONDACANAL AS sc 
where c.NombreCanalBac='".$arreglonombresbac[$i]."'
and c.NombreCanalBac = rh.vunweb_reshoyCanal and vunweb_reshoyFecha>='".date_format($fechauptime, 'Y-m-d')."' 
and (rh.vunweb_reshoyTR/1000)>30
and vunweb_reshoySonda=sc.sondacanal_nombresonda
group by convert(varchar(16),rh.vunweb_reshoyFecha,121), (rh.vunweb_reshoyTR/1000), vunweb_reshoyStatus, sc.sondacanal_nombrevun,
convert(varchar(2),rh.vunweb_reshoyFecha,108)
";
//print $querydh."<br><br>;
$SqlIDdatoshoy=sqlsrv_query( $conn, $querydh,array(), array( "Scrollable" => 'static' ));

$querytuids="select sn.vw_snaptuid, convert(varchar(2),sn.vw_snapdbdate,108) as hora
from vunweb_snapd as sn where sn.vw_snapdbdate>='".date("Y-m-d")."' and sn.vw_canal='".$arreglonombres[$i]."' order by 2";
$SqlIDtuids=sqlsrv_query( $conn, $querytuids,array(), array( "Scrollable" => 'static' ));
$arreglotuids=array();
while($objtuid = sqlsrv_fetch_object($SqlIDtuids)){
	$arreglotuids[$objtuid->vw_snaptuid]=$objtuid->hora;
	//$arreglotuids[]=$tuidxhora;
}
$tablaerrores="
<div class='header bg-color-blueDark txt-color-white text-center font-lg'>Resumen de Errores Tiempo Real</div>
	<table class='table no-bordered' id='terrores".$i."'>
		<thead>
		<tr>
			<th>#</th>			
			<th><i class='fa fa-calendar'></i>Fecha y Hora</th>			
			<th><i class='fa fa-hdd-o'></i>TR</th>
			<th><i class='fa fa-keyboard-o'></i>Status</th>
			<th><i class='fa fa-desktop'></i>Sonda</th>
			<th><i class='fa fa-file'></i>Link</th>
		</tr>
		</thead>
		<tbody>";
$cuenta=1;
while($objerrores = sqlsrv_fetch_object($SqlIDdatoshoy)){
	$carperta="";
	$valorestuids=array_keys($arreglotuids,$objerrores->horaerror);

	if($arreglonombres[$i]=="CARGA PORTALES"){
		$carpeta="ENLACE";
	}else{
		$carpeta=$arreglonombres[$i];
	}
	$aux = "../../snapshots/".$carpeta."/".date("Y")."-".date("m")."-".date("d")."/";
	$links="";
	$tablaerrores.="	
		<tr>
			<td class='font-xs'>".$cuenta."</td>
			<td class='font-xs'>".$objerrores->fecha."</td>
			<td class='font-xs'>".$objerrores->TR."</td>
			<td class='font-xs'>".$objerrores->estado."</td>
			<td class='font-xs'>".$objerrores->sondacanal_nombrevun."</td>";
	foreach($valorestuids as $tuid){
		$links .= "<a href='".$aux.$tuid.".zip'><img src='../_img/zip.png'></a>&nbsp;";
	}
	$tablaerrores.="
			<td class='font-xs'>".$links."</td>
		</tr>";
		$cuenta++;
}
$tablaerrores.="</tbody>
				</table>"

?>