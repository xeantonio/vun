<?php
$querygrafica="
select 
sc.sondacanal_nombrevun, rh.vunweb_reshoySonda, sc.sondacanal_zona,

min((rh.vunweb_reshoyTR/1000)) as TRMIN, max((rh.vunweb_reshoyTR/1000)) as TRMAX, 
SUM(CASE WHEN (rh.vunweb_reshoyTR/1000)>=30 AND vunweb_reshoyStatus<>'NO_DATA' THEN 1 ELSE 0 END) AS FAILPERF,
SUM(CASE WHEN (rh.vunweb_reshoyTR/1000)>=30 AND vunweb_reshoyStatus<>'NO_DATA' THEN 0 ELSE 1 END) AS PASSPERF,
100-((convert(decimal(10,5),SUM(CASE WHEN (rh.vunweb_reshoyTR/1000)>=30 AND vunweb_reshoyStatus<>'NO_DATA' THEN 1 ELSE 0 END))/(SUM(CASE WHEN vunweb_reshoyStatus<>'NO_DATA' THEN 1 ELSE 0 END)))*100) AS TOTALPERF,

SUM(CASE WHEN vunweb_reshoyStatus='FAIL' THEN 1 ELSE 0 END) AS FAILDISPO,
SUM(CASE WHEN vunweb_reshoyStatus='PASS' THEN 1 ELSE 0 END) AS PASSDISPO,
100-(((SUM(CASE WHEN vunweb_reshoyStatus='FAIL' THEN 1 ELSE 0 END)*100)/convert(decimal(10,5),SUM(CASE WHEN vunweb_reshoyStatus<>'NO_DATA' THEN 1 ELSE 0 END)))) AS TOTALDISPO,

100-(((SUM(CASE WHEN (rh.vunweb_reshoyTR/1000)>=30 AND vunweb_reshoyStatus<>'NO_DATA' THEN 1 ELSE 0 END)+SUM(CASE WHEN vunweb_reshoyStatus='FAIL' THEN 1 ELSE 0 END))/(convert(decimal(10,5),SUM(CASE WHEN vunweb_reshoyStatus<>'NO_DATA' THEN 1 ELSE 0 END))*2))*100) AS GLOBAL,

sum(CASE WHEN vunweb_reshoyStatus IN ('PASS','FAIL') THEN 1 ELSE 0 END) AS TOTALMETRICAS


from vunweb_resultadoshoy as rh, canales as c, VUNWEB_SONDACANAL AS sc
where c.NombreCanalBac='".$arreglonombresbac[$i]."'
AND vunweb_reshoyStatus<>'NO_DATA'

and c.NombreCanalBac = rh.vunweb_reshoyCanal 
and sc.sondacanal_idcanal=".$arregloidcanal[$i]."
and vunweb_reshoyFecha>='".date_format($fechauptime, 'Y-m-d')."' 
and vunweb_reshoySonda=sc.sondacanal_nombresonda
group by sc.sondacanal_nombrevun,rh.vunweb_reshoySonda, sondacanal_zona
";
//print $querygrafica."<br><br>";
$SqlIDinfocanalessonda=sqlsrv_query( $conn, $querygrafica);
 if( ($errors = sqlsrv_errors() ) != null) {
        foreach( $errors as $error ) {
            echo "SQLSTATE: ".$error[ 'SQLSTATE']."<br />";
            echo "code: ".$error[ 'code']."<br />";
            echo "message: ".$error[ 'message']."<br />";
        }
    }
//print $querygrafica."<br><br><br>";

$tablasondas="
<div class='header bg-color-blueDark txt-color-white text-center font-lg'>Detalle x Sonda Tiempo Real</div>
<table class='table table-hover table-striped' id='dt_basic".$i."'>
	<thead>
		<tr>
			<th><i class='fa fa-calendar font-sm'></i>Sonda</th>
			<th><i class='fa fa-globe font-sm'></i>Ciudad</th>
			<th><i class='fa fa-level-down font-sm'></i>Min</th>
			<th><i class='fa fa-level-up font-sm'></i>Max</th>
			<th><i class='fa fa-warning font-sm'></i>Perf FAIL</th>
			<th><i class='fa fa-check font-sm'></i>Perf PASS</th>
			<th><i class='fa fa-dashboard font-sm'></i>% Perf</th>
			<th><i class='fa fa-warning font-sm'></i>Dispo FAIL</th>
			<th><i class='fa fa-check font-sm'></i>Dispo PASS</th>
			<th><i class='fa fa-dashboard font-sm'></i>% Dispo</th>
			<th><i class='fa fa-dashboard font-sm'></i>Global</th>
		</tr>
	</thead>
	<tbody>";

while($objsondacanal = sqlsrv_fetch_object($SqlIDinfocanalessonda)){
	include "creacolores.php";
	$tablasondas.="	
		<tr>
			<td class='font-sm'>".$objsondacanal->sondacanal_nombrevun."</td>
			<td class='font-sm'>".$objsondacanal->sondacanal_zona."</td>
			<td class='font-sm'>".$objsondacanal->TRMIN."</td>
			<td class='font-sm ".$colormax."'>".$objsondacanal->TRMAX."</td>
			<td class='font-sm ".$colorperftabla2."'>".$objsondacanal->FAILPERF."</td>
			<td class='font-sm'>".$objsondacanal->PASSPERF."</td>
			<td class='".$colorperftabla."'>".$iconperf."<b><span class='txt-color-".$colorperftablaname."'>".number_format($objsondacanal->TOTALPERF,2)."</span></b></td>
			<td class='font-sm ".$colordispotabla2."'>".$objsondacanal->FAILDISPO."</td>
			<td class='font-sm'>".$objsondacanal->PASSDISPO."</td>
			<td class='".$colordispotabla."'>".$icondispo."<b><span class='txt-color-".$colordispotablaname."'>".number_format($objsondacanal->TOTALDISPO,2)."</span></b></td>
			<td class='".$colorglobtabla."'>".$iconglob."<b><span class='txt-color-".$colorglobtablaname."'>".number_format($objsondacanal->GLOBAL,2)."</span></b></td>
		</tr>";
}
$tablasondas.="</tbody></table>"
?>
