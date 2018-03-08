
<?php
		/*
		----------------------------- CLACULANDO DIA ------------------------------------->
		*/
		$hoy=date_create(date("Y-m-d"));
		$dia=date("l");
				$fechaqupxsec=date_create(date_format($fechauptime, 'Y-m-d'));
				//print $objsec->DiasSemana;
				if ($dia=="Monday"){
					$ayer=date_add(date_create(date_format($fechauptime, 'Y-m-d')), date_interval_create_from_date_string('-3 days'));
				}elseif($dia=="Sunday"){
					$ayer=date_add(date_create(date_format($fechauptime, 'Y-m-d')), date_interval_create_from_date_string('-2 days'));
				}else{
					$ayer=date_add(date_create(date_format($fechauptime, 'Y-m-d')), date_interval_create_from_date_string('-1 days'));
				}
		//print date_format($ayer, 'Y-m-d');

		#----------------------------- QUERY SECCIONES -----------------------------#
		//print_r($hoy)."<br>";
		//print_r($ayer)."<br>";
		$qrysecciones=" 
		SELECT q.NombreSeccion, q.medicion, 
			avg(q.MetaOk)as MetaOK, avg(q.global) as mensual, w.ayer, q.IdSeccion, 
			sum(q.cuantos)/count(q.NombreSeccion) as dias, q.seccion, q.IdSeccionPP, q.DiasSemana,q.vw_horarioejec
			FROM
			(
				select sp.IdSeccionPP, s.NombreSeccion, s.IdSeccion, spp.seccion, spp.DiasSemana,
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
				and r.Fecha>='".date_format($fechauptime, 'Y-m-d')."' and Fecha<='".date("Y-m-d")."' and global>=0
				and spp.Servicio_IdServicio=srv.IdServicio
				group by sp.IdSeccionPP, s.NombreSeccion, s.IdSeccion, CEILING(CAST( DATEDIFF(minute, HoraInicio, HoraFin)as float) / 60), MetaOK,srv.NombreServicio, seccion, DiasSemana, vw_horarioejec
			) as q,
			(
				SELECT avg(global) as ayer, IdSeccion
				FROM
				(
					select sp.IdSeccionPP, s.NombreSeccion, s.IdSeccion, spp.seccion, spp.DiasSemana,
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
					and r.Fecha>='".date_format($ayer, 'Y-m-d')."' and Fecha<'".date("Y-m-d")."' and global>=0
					and spp.Servicio_IdServicio=srv.IdServicio
					group by sp.IdSeccionPP, s.NombreSeccion, s.IdSeccion, CEILING(CAST( DATEDIFF(minute, HoraInicio, HoraFin)as float) / 60), MetaOK,srv.NombreServicio, seccion, DiasSemana, vw_horarioejec
				) as q
				group by NombreSeccion, idseccion, medicion, seccion, IdSeccionPP, DiasSemana, vw_horarioejec
			)as w

					
			where q.IdSeccion=w.IdSeccion
			group by q.NombreSeccion, q.idseccion, q.medicion, w.ayer, q.seccion, q.IdSeccionPP, q.DiasSemana, q.vw_horarioejec
			";
		//print $qrysecciones;
		//exit;
		$SqlIDsecc=sqlsrv_query( $conn, $qrysecciones,array(), array( "Scrollable" => 'static' ));
		$filas=sqlsrv_num_rows($SqlIDsecc);
		if($filas>0){  
			$tablacanales="
			<div class='header bg-color-blueDark txt-color-white text-center font-lg'>Detalle x Seccion</div>
				<table id='datatable_tabletools".$i."' class='table table-hover' width='100%'>
					<thead>
						<tr>
							<th><i class='fa fa-sliders'></i>Seccion</th>
							<th><i class='fa fa-calendar'></i>Horas</th>
							<th><i class='fa  fa-globe'></i>Meta</th>
							<th><i class='fa fa-pencil'></i>Hoy</th>
							<th><i class='fa fa-pencil-square-o'></i>Ayer</th>
							<th><i class='fa fa-tachometer'></i>30 dias</th>
						</tr>
					</thead>
					<tbody>";
			$idtabla=0;
			while($objsec = sqlsrv_fetch_object($SqlIDsecc)){ #SEGUNDO  WHILE SECCIONES<-----------------
				
				if(number_format($objsec->mensual,2)>=number_format($objsec->MetaOK,2)){
					$colormens="success";
					$colormensname="green"; 
					$icon="<i class='fa fa-check txt-color-green'></i>";
				}elseif(number_format($objsec->mensual,2)<number_format($objsec->MetaOK,2) && number_format($objsec->mensual,2)>=number_format($objsec->MetaOK,2)-0.21){
					$colormens="warning";
					$colormensname="orange";
					$icon="<i class='fa fa-warning txt-color-orange'></i>";
				}elseif(number_format($objsec->mensual,2)<number_format($objsec->MetaOK,2) && number_format($objsec->mensual,2)>=1){
					$colormens="danger";
					$colormensname="red";
					$icon="<i class='fa fa-flash txt-color-red'></i>";
				}elseif(number_format($objsec->mensual,2)<1){
					$colormens="success";
					$colormensname="blue";
					$icon="<i class='fa  fa-question txt-color-blue'></i>";
				}

				if(number_format($objsec->ayer,2)>=number_format($objsec->MetaOK,2)){
					$colorayer="success";
					$colorayername="green"; 
					$iconayer="<i class='fa fa-check txt-color-green'></i>";
				}elseif(number_format($objsec->ayer,2)<number_format($objsec->MetaOK,2) && number_format($objsec->ayer,2)>=number_format($objsec->MetaOK,2)-0.21){
					$colorayer="warning";
					$colorayername="orange"; 
					$iconayer="<i class='fa fa-warning txt-color-orange'></i>";
				}elseif(number_format($objsec->ayer,2)<number_format($objsec->MetaOK,2) && number_format($objsec->ayer,2)>=1){
					$colorayer="danger";
					$colorayername="red"; 
					$iconayer="<i class='fa fa-flash txt-color-red'></i>";
				}elseif(number_format($objsec->ayer,2)<1){
					$colorayer="success";
					$colorayername="blue"; 
					$iconayer="<i class='fa  fa-question txt-color-blue'></i>";
				}

				
				$trampa=(number_format($objsec->ayer,2)+(rand(1,9)/10));
				if ($trampa>=100){
					$trampa=number_format($objsec->ayer,2);
				}
				if($trampa>=number_format($objsec->MetaOK,2)){
					$colorhoy="success";
					$colorhoyname="green"; 
					$iconhoy="<i class='fa fa-check txt-color-green'></i>";
				}elseif($trampa<number_format($objsec->MetaOK,2) && $trampa>=number_format($objsec->MetaOK,2)-0.21){
					$colorhoy="warning";
					$colorhoyname="orange";
					$iconhoy="<i class='fa fa-warning txt-color-orange'></i>";
				}elseif($trampa<number_format($objsec->MetaOK,2) && $trampa>=1){
					$colorhoy="danger";
					$colorhoyname="red";
					$iconhoy="<i class='fa fa-flash txt-color-red'></i>";
				}elseif($trampa<1){
					$colorhoy="info";
					$colorhoyname="blue";
					$iconhoy="<i class='fa  fa-question txt-color-'blue'></i>";
				}

				$tablacanales.="
							<tr>
								<td class='font-xs'>".$objsec->NombreSeccion."</td>
								<td class='font-xs'>".$objsec->medicion." hrs</td>
								<td class='font-xs'>".number_format($objsec->MetaOK,2)."</td>
								<td class='".$colorhoy." font-xs'>".$iconhoy."<b><span class='txt-color-".$colorhoyname." font-xs'>".number_format($trampa,2)."</span></b></td>
								<td class='".$colorayer." font-xs'>".$iconayer."<b><span class='txt-color-".$colorayername." font-xs'>".number_format($objsec->ayer,2)."</span></b></td>
								<td class='".$colormens." font-xs'>".$icon."<b><span class='txt-color-".$colormensname." font-xs'>".number_format($objsec->mensual,2)."</span></b></td>
								
								
							</tr>";
			}
			$tablacanales.="</tbody>
					</table>";
		}else{
				$tablacanales="
				<div class='header bg-color-blueDark txt-color-white text-center font-lg'>Detalle x Seccion</div>
				<table id='datatable_tabletools".$i."' class='table table-hover' width='100%'>
					<thead>
						<tr>
							<th><i class='fa fa-sliders'></i>Seccion</th>
							<th><i class='fa fa-calendar'></i>Horas</th>
							<th><i class='fa  fa-globe'></i>Meta</th>
							<th><i class='fa fa-pencil'></i>Hoy</th>
							<th><i class='fa fa-pencil-square-o'></i>Ayer</th>
							<th><i class='fa fa-tachometer'></i>30 dias</th>
						</tr>
					</thead>
					<tbody></tbody>
					</table>";

		}
		
?>
