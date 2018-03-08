<?php
$fechainicial=date_create(date("Y-m-d"));
$fechafinal=date_create(date("Y-m-d"));
date_add($fechainicial, date_interval_create_from_date_string('-30 days'));

$querytablaerrores="
select  convert(varchar(10),ie.FechaErr,120) as fecha,
ie.ServerIP, ie.ServerName,
ie.TipoErrorId,
convert(varchar(2000),ie.TextoError) as texto,
sc.sondacanal_nombrevun, 
ie.HoraErr,
InternalTransaccionID
from  vunweb_ImportedErrors as ie, VUNWEB_SONDACANAL as sc
where FechaErr >='".date_format($fechainicial, 'Y-m-d')."' 
and FechaErr <='".date_format($fechafinal, 'Y-m-d')."' 
and TipoErrorId not in (6,404,10060)
and NombreCanalBac='".$canal."'
and ie.NombreBPM=sc.sondacanal_nombresonda
group by convert(varchar(10),ie.FechaErr,120),ie.ServerIP, ie.ServerName,
ie.TipoErrorId,
convert(varchar(2000),ie.TextoError),
sc.sondacanal_nombrevun, 
ie.HoraErr,
InternalTransaccionID
order by HoraErr";

$SqlIDtablaerrores=sqlsrv_query( $conn, $querytablaerrores,array(), array( "Scrollable" => 'static' ));	
$tablaerrores="
<table class='table table-hover table-striped' id='datatable_tabletools'>
	<thead>
		<tr>
			<th><i class='fa fa-calendar'></i>Fecha</th>
			<th><i class='fa fa-clock-o'></i>Hora</th>
			<th><i class='fa fa-exclamation-triangle'></i>Mensaje Error</th>
			<th><i class='fa fa-road'></i>Sonda</th>
		</tr>
	</thead>
	<tbody>";

while($objtablaerrores = sqlsrv_fetch_object($SqlIDtablaerrores)){
	$texto=preg_replace('#vuser_init.c\(\d\d\d\): Error -\d\d\d\d\d: #', '', $objtablaerrores->texto);
		
	$tablaerrores.="
		<tr>
			<td class='font-xs'>".$objtablaerrores->fecha."</td>
			<td class='font-xs'>".$objtablaerrores->HoraErr."</td>
			<td class='font-xs'>".$texto."</td>
			<td class='font-xs'>".$objtablaerrores->sondacanal_nombrevun."</td>
		</tr>";
}
$tablaerrores.="</tbody></table>";

?>