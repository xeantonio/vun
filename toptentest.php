
<?php

if( $conn === false )
{
     echo "Unable to connect.</br>";
     die( print_r( sqlsrv_errors(), true));
}

	date_default_timezone_set('America/Mexico_City');

	$fechauptime=date_create(date("Y-m-d"));
	date_add($fechauptime, date_interval_create_from_date_string('-365 days'));


		/*
		-- ---------------------------- DETERMINANDO CRITERIO DE DATOS (MEJOR, PROMEDIO O PEOR) ------------------------------- --
		*/

		if (!isset($_REQUEST["criterio"])){
			$criterio="avg";
			$criterioinv="avg";
		}else{
			$criterio=$_REQUEST["criterio"];
		}

		#------------------------------- CANALES ---------------------------#
		if(isset($_SESSION["canales"])){
			//$qrycanales="select  * from canales where IdCanal= 3";
			$qrycanales="select  * from canales where IdCanal in (".$_SESSION["canales"].") and IdCanal>1 and IdCanal<>3";
			//print $qrycanales;
		}else{
			$qrycanales.="select  * from canales where IdCanal=1";
		}

		$qrycanales.="";
		//print $qrycanales;
		$SqlID=sqlsrv_query( $conn, $qrycanales);
		$cuenta=0;
		$arreglonombres=array();
		$arregloidcanal=array();
		$arreglodtdispo=array();
		$arreglodtperf=array();
		$arreglodtmeta=array();
		$arreglonombresbac=array();
		$arreglodtglobal=array();
		$tabla="<ul id='nada' class='nav nav-tabs bordered'>";
		$primera=0;
		while($obj = sqlsrv_fetch_object($SqlID)){ #PRIMER WHILE CANALES<--------

			/*
			-- --------------------------------------------------------------------------------
			-- DATOS DE CADA CANAL
			-- --------------------------------------------------------------------------------
			*/
			
			$querydatoscanal="select ".$criterio."(global) as global, ".$criterio."(dispo) as dispo, ".$criterio."(perf) as perf, MetaOK
								from(
									select spp.MetaOK, avg(r.global) as global, avg(r.Disponibilidad) as dispo,	avg(r.performance) as perf, convert(varchar(11),r.Fecha) as fecha
									from SeccionesParaPlantilla as sp, Secciones as s, ServiciosParaPlantilla as spp, resultados as r, servicios as srv
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
										and c.IdCanal =".$obj->IdCanal."
									) 
									and sp.Seccion_IdSeccion=s.IdSeccion
									and spp.SeccionParaPlantilla_IdSeccionPP=sp.IdSeccionPP
									and spp.IdServicioParaPlantilla=r.ServicioParaPlantilla_IdServicioParaPlantilla
									and r.Fecha>='".date_format($fechauptime, 'Y-m-d')."' and Fecha<='".date("Y-m-d")."' 
									and spp.Servicio_IdServicio=srv.IdServicio
									group by MetaOK, fecha
								)as q
								group by MetaOK";			
			//print $querydatoscanal."<br><br>";					
			//exit;
			$SqlIDinfocanal=sqlsrv_query( $conn, $querydatoscanal,array(), array( "Scrollable" => 'static' ));	
			$objinfocanal = sqlsrv_fetch_object($SqlIDinfocanal);
			$arreglonombres[$cuenta]=strtoupper($obj->NombreCanal);
			$arreglonombresbac[$cuenta]=strtoupper($obj->NombreCanalBac);
			$arregloidcanal[$cuenta]=strtoupper($obj->IdCanal);
			$arreglodtdispo[$cuenta]=number_format($objinfocanal->dispo,2);
			$arreglodtperf[$cuenta]=number_format($objinfocanal->perf,2);
			$arreglodtmeta[$cuenta]=number_format($objinfocanal->MetaOK,2);
			$arreglodtglobal[$cuenta]=number_format($objinfocanal->global,2);
			$cuenta++;
			$tabla.="<li >
						<a href='#".str_replace(' ', '',strtoupper($obj->NombreCanal))."' data-toggle='tab'>".str_replace(' ', '',strtoupper($obj->NombreCanal))."</a>
					</li>";
			
			$primera++;				
				
		} // while canales
		$tabla.="</ul>";
		$tabla.="<div id='myTabContent1' class='tab-content padding-10'>";	
		for($i=0;$i<=$primera-1;$i++){
			
			if(number_format($arreglodtglobal[$i],2)>=number_format($arreglodtmeta[$i],2)){
					$color="green";
					$infoglobal="<div class='txt-color-".$color."' ><i class='glyphicon glyphicon-check'></i>".number_format($arreglodtglobal[$i],2)."%</div>";
			}elseif(number_format($arreglodtglobal[$i],2)<number_format($arreglodtmeta[$i],2) && number_format($arreglodtglobal[$i],2)>=number_format($arreglodtmeta[$i],2)-0.21){
					$color="orange";
					$infoglobal="<div class='txt-color-".$color."' ><i class='glyphicon glyphicon-info-sign'></i>".number_format($arreglodtglobal[$i],2)."%</div>";
					
			}elseif(number_format($arreglodtglobal[$i],2)<number_format($arreglodtmeta[$i],2) && number_format($arreglodtglobal[$i],2)>=1){
					$color="red";
					$infoglobal="<div class='txt-color-".$color."' ><i class='glyphicon glyphicon-remove-circle'></i>".number_format($arreglodtglobal[$i],2)."%</div>";
					
			}elseif(number_format($arreglodtglobal[$i],2)<1){
					$color="blue";
					$infoglobal="<div class='txt-color-".$color."' ><i class='glyphicon glyphicon-minus-sign'></i>".number_format($arreglodtglobal[$i],2)."%</div>";
					
			}

			if(number_format($arreglodtdispo[$i],2)>=number_format($arreglodtmeta[$i],2)){
					$colordispo="green";
					$infodispo="<a class='txt-color-".$colordispo."' ><i class='glyphicon glyphicon-check'></i>".number_format($arreglodtdispo[$i],2)."%</a>";
			}elseif(number_format($arreglodtdispo[$i],2)<number_format($arreglodtmeta[$i],2) && number_format($arreglodtdispo[$i],2)>=number_format($arreglodtmeta[$i],2)-0.21){
					$colordispo="orange";
					$infodispo="<a class='txt-color-".$colordispo."' ><i class='glyphicon glyphicon-info-sign'></i>".number_format($arreglodtdispo[$i],2)."%</a>";
					
			}elseif(number_format($arreglodtdispo[$i],2)<number_format($arreglodtmeta[$i],2) && number_format($arreglodtdispo[$i],2)>=1){
					$colordispo="red";
					$infodispo="<a class='txt-color-".$colordispo."' ><i class='glyphicon glyphicon-remove-circle'></i>".number_format($arreglodtdispo[$i],2)."%</a>";
					
			}elseif(number_format($arreglodtdispo[$i],2)<1){
					$infodispo="<a ><i class='glyphicon glyphicon-minus-sign'></i>".number_format($arreglodtdispo[$i],2)."%</a>";
					$colordispo="blue";
			}


			if(number_format($arreglodtperf[$i],2)>=number_format($arreglodtmeta[$i],2)){
					$colorperf="green";
					$infoperf="<a class='txt-color-".$colorperf."' ><i class='glyphicon glyphicon-check'></i>".number_format($arreglodtperf[$i],2)."%</a>";
			}elseif(number_format($arreglodtperf[$i],2)<number_format($arreglodtmeta[$i],2) && number_format($arreglodtperf[$i],2)>=number_format($arreglodtmeta[$i],2)-0.21){
					$colorperf="orange";
					$infoperf="<a class='txt-color-".$colorperf."' ><i class='glyphicon glyphicon-info-sign'></i>".number_format($arreglodtperf[$i],2)."%</a>";
					
			}elseif(number_format($arreglodtperf[$i],2)<number_format($arreglodtmeta[$i],2) && number_format($arreglodtperf[$i],2)>=1){
					$colorperf="red";
					$infoperf="<a class='txt-color-".$colorperf."' ><i class='glyphicon glyphicon-remove-circle'></i>".number_format($arreglodtperf[$i],2)."%</a>";
					
			}elseif(number_format($arreglodtperf[$i],2)<1){
					$infoperf="<a ><i class='glyphicon glyphicon-minus-sign'></i>".number_format($arreglodtperf[$i],2)."%</a>";
					$colorperf="blue";
			}

			include "infosecciones.php";
			include "graficasecciones.php";
			include "tablasondas.php";
			include "datoshoy.php";

			$tabla.="
			<div class='tab-pane fade in active' id='".str_replace(' ', '',$arreglonombres[$i])."'>
				<div align='center' class='row no-padding'>
					<div class='row no-padding'>
						<div class='bg-color-blueDark txt-color-white col-md-12 font-md'><i class='fa fa-info-circle'></i> ".$arreglonombres[$i]."</div>
					</div>

					<div class='row padding-10'>
							<div class='col-md-2 no-padding'>
								<div class='header bg-color-blueDark txt-color-white font-lg'>Global</div>
								<div class='well well-light'>
									<div class='label bg-color-blueDark txt-color-white font-sm'>Monitoreo 30 dias:</div><br><br>
									<div class='font-xl txt-color-".$color."'>".$infoglobal."</div>
									<div data-sparkline-spotradius='2' data-sparkline-height='45px' data-sparkline-type='line' data-fill-color='transparent' data-sparkline-width='95%' data-sparkline-line-width='2' class='sparkline txt-color-".$color."'>".$strglobal."</div>
									<br>
									<!--- DATOS HOY -->
									".$dhglobal."
								</div>
							</div>
							
							<div class='col-md-2 no-padding'>
								<div class='header bg-color-blueDark txt-color-white font-lg'>Disponibilidad</div>
								<div class='well well-light'>
									<div class='label bg-color-blueDark txt-color-white font-sm'>Monitoreo 30 dias:</div><br><br>
									<div class='font-xl txt-color-".$colordispo."'>".$infodispo."</div>
									<div data-sparkline-spotradius='2' data-sparkline-height='45px' data-sparkline-type='line' data-fill-color='transparent' data-sparkline-width='95%' data-sparkline-line-width='2' class='sparkline txt-color-".$colordispo."'>".$strdispo."</div>
									<br>
									<!--- DATOS HOY -->
									".$dhTOTALDISPO."
								</div>
							</div>
							

							<div class='col-md-2 no-padding'>
								<div class='header bg-color-blueDark txt-color-white font-lg'>Performance</div>
								<div class='well well-light'>
									<div class='label bg-color-blueDark txt-color-white font-sm'>Monitoreo 30 dias:</div><br><br>
									<div class='font-xl txt-color-".$colorperf."'>".$infoperf."</div>
									<div data-sparkline-spotradius='2' data-sparkline-height='45px' data-sparkline-type='line' data-fill-color='transparent' data-sparkline-width='95%' data-sparkline-line-width='2' class='sparkline txt-color-".$colorperf."'>".$strperf."</div>
									<br>
									<!--- DATOS HOY -->
									".$dhTOTALPERF."
								</div>
							</div>

							<div class='col-md-6 no-padding'>
							<div class='header bg-color-blueDark txt-color-white font-lg'>Ubicacion Geografica de Monitoreo</div>
									<!--- mapa -->

									<div id='vector-map".$i."' class='vector-map'></div>
							</div>		
					</div>
				</div>
				<div class='row'>
					<div class='col-md-12 no-padding' well-light>
						".$tablasondas."
					</div>
				</div>
				<div class='row'>
					<div class='col-md-6  no-padding'>
						".$tablaerrores."
					</div>
					<div class='col-md-6  no-padding'>
						".$tablacanales."
					</div>
				</div>
				
			</div>";
		}
		$tabla.="</div>";


print $tabla;

