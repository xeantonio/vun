<?php
$queryseccionesbycanal="
	select s.IdSeccion,s.NombreSeccion
	from SeccionesParaPlantilla as sp, 
		 Secciones as s,
		 ServiciosParaPlantilla as spp,
		 resultados as r,
		 servicios as srv
	where sp.CanalParaPlantilla_Id in( 
		select cp.Id as canalparaplantillaId 
		from dbo.CanalesParaPlantilla as cp, canales as c 
		where versionplantilla_idversplantilla in 
		( 
			select idversplantilla 
			from dbo.VersionesPlantilla 
			where activo=1 
			and Plantilla_IdPlantilla IN (1) 
		) 
		and c.idcanal=cp.Canal_IdCanal 
		and c.IdCanal =".$arreglocanalesprincipalID[$canal]."
	) 
	
	and sp.Seccion_IdSeccion=s.IdSeccion
	and spp.SeccionParaPlantilla_IdSeccionPP=sp.IdSeccionPP
	and spp.IdServicioParaPlantilla=r.ServicioParaPlantilla_IdServicioParaPlantilla
	and spp.Servicio_IdServicio=srv.IdServicio
	group by s.IdSeccion,s.NombreSeccion
";
//print $queryseccionesbycanal;
//exit;
$SqlIDSeccbyCanal=sqlsrv_query( $conn, $queryseccionesbycanal,array(), array( "Scrollable" => 'static' ));	
$fechainicial=date_create(date("Y-m-d"));
date_add($fechainicial, date_interval_create_from_date_string('-10 days'));
$tablagrafica="
	<div class='col-sm-12'>
		<table class='highchart table table-hover table-bordered' data-graph-container='.. .. .highchart-container' data-graph-type='bar'>
			<thead>
			<tr>
				<th class='font-xs'>Fecha</th>
";


$arreglosecciones=array();
while($objSeccbyCanal = sqlsrv_fetch_object($SqlIDSeccbyCanal)){
	$tablagrafica.="<th class='font-xs'>".$objSeccbyCanal->NombreSeccion."</th>";
	array_push($arreglosecciones,$objSeccbyCanal->IdSeccion);
}
$tablagrafica.="
			</tr>
		</thead>
		<tbody>";


$arreglofechassecc=array();
$queryranfofechassecc="
	SELECT convert(varchar(10),DATEADD(DAY,number+0,'".date_format($fechainicial, 'Y-m-d')."'),120) as Fechita
	FROM master..spt_values 
	WHERE type = 'P'
	AND DATEADD(DAY,number+0,'".date_format($fechainicial, 'Y-m-d')."') < '".date("Y-m-d")."'";
$SqlIDrangofechassecc=sqlsrv_query( $conn, $queryranfofechassecc,array(), array( "Scrollable" => 'static' ));	
while($objfechaSeccbyCanal = sqlsrv_fetch_object($SqlIDrangofechassecc)){
	$arreglofechassecc[$objfechaSeccbyCanal->Fechita]=$objfechaSeccbyCanal->Fechita;
	$tablagrafica.="<tr><td>".$objfechaSeccbyCanal->Fechita."</td>";
	for($o=0;$o<count($arreglosecciones);$o++){ //POR CADA UNO DE LOS DIAS, CONSULTO LOS RESULTADOS DE CADA CANAL
		$querydisposeccdia="
				select r.Global as dispo
				from SeccionesParaPlantilla as sp, 
					 Secciones as s,
					 ServiciosParaPlantilla as spp,
					 resultados as r,
					 servicios as srv
				where sp.CanalParaPlantilla_Id in( 
					select cp.Id as canalparaplantillaId 
					from dbo.CanalesParaPlantilla as cp, canales as c 
					where versionplantilla_idversplantilla in 
					( 
						select idversplantilla 
						from dbo.VersionesPlantilla 
						where activo=1 
						and Plantilla_IdPlantilla IN (1) 
					) 
					and c.idcanal=cp.Canal_IdCanal 
					and c.IdCanal =".$arreglocanalesprincipalID[$canal]."
				
				) 
				and s.IdSeccion=".$arreglosecciones[$o]."
				
				and sp.Seccion_IdSeccion=s.IdSeccion
				and spp.SeccionParaPlantilla_IdSeccionPP=sp.IdSeccionPP
				and spp.IdServicioParaPlantilla=r.ServicioParaPlantilla_IdServicioParaPlantilla
				
				and CONVERT(VARCHAR(10),r.Fecha,120)='".$objfechaSeccbyCanal->Fechita."'
				
				and global>=0
				and spp.Servicio_IdServicio=srv.IdServicio";
				
				$SqlIDdisposeccdia=sqlsrv_query( $conn, $querydisposeccdia,array(), array( "Scrollable" => 'static' ));		
				$objdisposeccdia = sqlsrv_fetch_object($SqlIDdisposeccdia);
				if(sqlsrv_num_rows($SqlIDdisposeccdia)>0){
					$tablagrafica.="<td>".number_format($objdisposeccdia->dispo,2)."</td>";			
				}else{
					$tablagrafica.="<td></td>";			
				}
		
	}

	$tablagrafica.="
			</tr>";
}

$tablagrafica.="              		</tbody>
					            	</table>
				    ";
//print_r($arreglofechassecc);

print $tablagrafica;


?>
<br>
				            	<div class="col-sm-12">
									<div class="highchart-container"></div>
								</div>

