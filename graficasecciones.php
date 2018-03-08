<?php
$fechagrap=date_create(date_format($fechauptime, 'Y-m-d'));
date_add($fechagrap, date_interval_create_from_date_string('-30 days'));
$querygrafica="
SELECT q.fecha, avg(q.global) as global, avg(q.dispo) as dispo,
			avg(q.perf) as perf
			FROM
			(
				select R.FECHA,sp.IdSeccionPP, s.NombreSeccion, s.IdSeccion, spp.seccion, spp.DiasSemana,
				CEILING(CAST( DATEDIFF(minute, HoraInicio, HoraFin)as float) / 60) as medicion, spp.MetaOK,
				avg(r.global) as global,
				avg(r.Disponibilidad) as dispo,
				avg(r.performance) as perf,
				count(r.performance) as cuantos,
				srv.NombreServicio,
				s.vw_horarioejec
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
					and c.IdCanal =".$arregloidcanal[$i]."
				) 
				and IdSeccionPP not in(1696, 1697)
				and sp.Seccion_IdSeccion=s.IdSeccion
				and spp.SeccionParaPlantilla_IdSeccionPP=sp.IdSeccionPP
				and spp.IdServicioParaPlantilla=r.ServicioParaPlantilla_IdServicioParaPlantilla
				and r.Fecha>='".date_format($fechagrap, 'Y-m-d')."' and Fecha<='".date_format($fechauptime, 'Y-m-d')."'
				and global>=0
				and spp.Servicio_IdServicio=srv.IdServicio
				group by R.FECHA,sp.IdSeccionPP, s.NombreSeccion, s.IdSeccion, CEILING(CAST( DATEDIFF(minute, HoraInicio, HoraFin)as float) / 60), MetaOK,srv.NombreServicio, seccion, DiasSemana, vw_horarioejec
			) AS Q

group by q.fecha
order by 1
";

$SqlIDinfogra=sqlsrv_query( $conn, $querygrafica);
$arrglobal=array();
$arrdispo=array();
$arrperf=array();
$arraymeta=array();
$arrayfechas=array();
while($objgraf = sqlsrv_fetch_object($SqlIDinfogra)){
	array_push($arrglobal,number_format($objgraf->global,0));
	array_push($arrdispo,number_format($objgraf->dispo,0));
	array_push($arrperf,number_format($objgraf->perf,0));
	array_push($arraymeta,99.8);
	array_push($arrayfechas,date_format($objgraf->fecha,'Y-m-d'));
}
$strglobal = implode (", ", $arrglobal);
$strdispo = implode (", ", $arrdispo);
$strperf = implode (", ", $arrperf);


?>
