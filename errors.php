f<?php
session_start();
if (isset($_SESSION["nombrecompleto"])){

 header('Content-Type: text/html; charset= ISO-8859-1'); 
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

/*---------------- PHP Custom Scripts ---------

YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
E.G. $page_title = "Custom Title" */

$page_title = "VUN";
$canal=$_REQUEST["dato"];
$cachaidcanal=$_REQUEST["canal"];
$fechainicial=date_create(date("Y-m-d"));
$fechafinal=date_create(date("Y-m-d"));
date_add($fechainicial, date_interval_create_from_date_string('-60 days'));

/*
-- ------------------------------------------------------------------------------------------ --
-- query para obtener fechas de los ultimos 60n dias
-- ------------------------------------------------------------------------------------------ --
*/

$queryfechas = "
			SELECT  (DATEADD(DAY, nbr - 1, '".date_format($fechainicial, 'Y-m-d')."')) as fechareal
			FROM    ( SELECT    ROW_NUMBER() OVER ( ORDER BY c.object_id ) AS Nbr
			          FROM      sys.columns c
			        ) nbrs
			WHERE   nbr - 1 <= DATEDIFF(DAY, '".date_format($fechainicial, 'Y-m-d')."', '".date_format($fechafinal, 'Y-m-d')."');

";

$SqlIDFechas=sqlsrv_query( $conn, $queryfechas,array(), array( "Scrollable" => 'static' ));	
$arrayfechasreales=array();
while($objfechasreales = sqlsrv_fetch_object($SqlIDFechas)){
	array_push($arrayfechasreales,date_format($objfechasreales->fechareal,'Y-m-d'));
	//$arrayfechasreales[date_format($objfechasreales->fechareal,'Y-m-d')]=date_format($objfechasreales->fechareal,'Y-m-d');
}
//print_r($arrayfechasreales);

/*
-- ------------------------------------------------------------------------------------------ --
-- query para obtener los datos de resultados del canal
-- ------------------------------------------------------------------------------------------ --
*/

$queryeventos="
				select CONVERT(VARCHAR(10),c.Fecha,120) AS Fecha, 
				SUM(CASE WHEN c.Disponible=0 THEN 1 ELSE 0 END) as cdispofail,
				SUM(CASE WHEN c.Disponible=1 THEN 1 ELSE 0 END) as cdispook, 
				SUM(CASE WHEN c.performance=0 THEN 1 ELSE 0 END) as cperffail,
				SUM(CASE WHEN c.performance=1 THEN 1 ELSE 0 END) as cperfok,
				count(c.disponible) as todos,
				max(TiempoRespuesta) as MAXTR,
				min(TiempoRespuesta) as MINTR,
				avg(TiempoRespuesta) as AVGTR,
				spp.MetaOK
				from SeccionesParaPlantilla as sp, 
					 Secciones as s,
					 ServiciosParaPlantilla as spp,
					 ciclos as c,
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
					and c.IdCanal =".$cachaidcanal."
				) 
				and sp.Seccion_IdSeccion=s.IdSeccion
				and spp.SeccionParaPlantilla_IdSeccionPP=sp.IdSeccionPP
				and spp.IdServicioParaPlantilla=c.ServicioParaPlantilla_IdServicioParaPlantilla
				and c.activo=1
				and c.Fecha>='".date_format($fechainicial, 'Y-m-d')."' 
				and Fecha<='".date_format($fechafinal, 'Y-m-d')."'
				and spp.Servicio_IdServicio=srv.IdServicio
				group by CONVERT(VARCHAR(10),c.Fecha,120),MetaOK
			
";

$SqlIDinfoerrores=sqlsrv_query( $conn, $queryeventos,array(), array( "Scrollable" => 'static' ));	


$events="";
$verifreg=0;
$numreg=sqlsrv_num_rows($SqlIDinfoerrores);

$arregloresultadosfechas=array();
while($objfechasresultados = sqlsrv_fetch_ARRAY($SqlIDinfoerrores)){
	array_push($arregloresultadosfechas, $objfechasresultados["Fecha"]);
}

$SqlIDinfoerrores=sqlsrv_query( $conn, $queryeventos,array(), array( "Scrollable" => 'static' ));	
while($objevents = sqlsrv_fetch_ARRAY($SqlIDinfoerrores)){
	$resdispo=number_format(100-(($objevents["cdispofail"]/$objevents["todos"])*100),2);

	if($resdispo>=$objevents["MetaOK"]){
		$colorevento="bg-color-green";
	}elseif($resdispo<$objevents["MetaOK"] && $resdispo>=($objevents["MetaOK"]-0.21)){
		$colorevento="bg-color-orange";
	}elseif($resdispo<$objevents["MetaOK"] && $objevents["MetaOK"]>=1){
		$colorevento="bg-color-red";
	}else{
		$colorevento="bg-color-blue";
	}
	
	$events.="{
				title: 'Disponibilidad:',
	            start: '".$objevents["Fecha"]."',
	            end: '".$objevents["Fecha"]."',
	            description: '".$objevents["cdispofail"]." de ".$objevents["todos"]."| ".$resdispo."%',
	            allDay: true,
	            className: ['task', '".$colorevento."']
		},";

	if(!array_search($arrayfechasreales[$verifreg], $arregloresultadosfechas)){
		$events.="{
				title: 'Dia inhabil',
	            start: '".$arrayfechasreales[$verifreg]."',
	            description: '',
	            allDay: true,
	            className: ['task', 'bg-color-blueDark']
		},";
	}
	

	$resperf=number_format(100-(($objevents["cperffail"]/$objevents["todos"])*100),2);

	if($resperf>=$objevents["MetaOK"]){
		$colorevento="bg-color-green";
	}elseif($resperf<$objevents["MetaOK"] && $resperf>=($objevents["MetaOK"]-0.21)){
		$colorevento="bg-color-orange";
	}elseif($resperf<$objevents["MetaOK"] && $objevents["MetaOK"]>=1){
		$colorevento="bg-color-red";
	}else{
		$colorevento="bg-color-blue";
	}
	
	$events.="{
				title: 'Performance:',
	            start: '".$objevents["Fecha"]."',
	            end: '".$objevents["Fecha"]."',
	            description: '".$objevents["cperffail"]." de ".$objevents["todos"]."| ".$resperf."%',
	            allDay: true,
	            className: ['task', '".$colorevento."']
	}";
	
	$verifreg++;
	if($verifreg<$numreg){
		$events.=",";
	}

}
//include "generatablaerrores.php";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["blank"]["active"] = true;
include("inc/nav.php");

?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
	<?php
		//configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
		//$breadcrumbs["New Crumb"] => "http://url.com"
		include("inc/ribbon.php");
	?>

	<!-- MAIN CONTENT -->
	<div id="content">
		<div class="row">
			<div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
				<h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-home"></i>VUN <span>> Vista de Errores de Monitoreo</span></h1>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-12 no-padding">
					<!-- new widget -->
					<div class="jarviswidget jarviswidget-color-blueDark">
			
						<!-- widget options:
						usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">
			
						data-widget-colorbutton="false"
						data-widget-editbutton="false"
						data-widget-togglebutton="false"
						data-widget-deletebutton="false"
						data-widget-fullscreenbutton="false"
						data-widget-custombutton="false"
						data-widget-collapsed="true"
						data-widget-sortable="false"
			
						-->
						<header>
							<span class="widget-icon"> <i class="fa fa-calendar"></i> </span>
							<h2> Bitacora del Canal <?php print $arreglocanalesprincipal[$canal]; ?> </h2>
							<div class="widget-toolbar">
							<!-- add: non-hidden - to disable auto hide -->
							<div class="btn-group">
								<button class="btn dropdown-toggle btn-xs btn-default" data-toggle="dropdown">
									Showing <i class="fa fa-caret-down"></i>
								</button>
								<ul class="dropdown-menu js-status-update pull-right">
									<li>
										<a href="javascript:void(0);" id="mt">Month</a>
									</li>
									<li>
										<a href="javascript:void(0);" id="ag">Agenda</a>
									</li>
									<li>
										<a href="javascript:void(0);" id="td">Today</a>
									</li>
								</ul>
							</div>
						</div>

						</header>
			
						<!-- widget div-->
						<div>
			
							<div class="widget-body no-padding">
								<!-- content goes here -->
								<div class="widget-body-toolbar">
									
									<div id="calendar-buttons">
			
										<div class="btn-group">
											<a href="javascript:void(0)" class="btn btn-default btn-xs" id="btn-prev"><i class="fa fa-chevron-left"></i></a>
											<a href="javascript:void(0)" class="btn btn-default btn-xs" id="btn-next"><i class="fa fa-chevron-right"></i></a>
										</div>
									</div>
								</div>
								<div id="calendar"></div>
			
								<!-- end content -->
							</div>
			
						</div>
						<!-- end widget div -->
					</div>
					<!-- end widget -->
			
			</div>
			<!-- - - - - - - - - - - - - Tabla con los errores - - - - - - - - - - - - -->
			<div class="col-sm-6 col-md-6 col-lg-12 no-padding">
					<!-- new widget -->
					<div class="jarviswidget jarviswidget-color-blueDark">
						<header>
							<span class="widget-icon"> <i class="fa fa-gears"></i> </span>
							<h2> Detalle de Errores del Canal <?php print $arreglocanalesprincipal[$canal]; ?> </h2>
						</header>
						<!-- widget div-->
						<div class="custom-scroll table-responsive" style="height:550px; overflow-y: scroll;">
			
							<div >
								<!-- content goes here -->
								<?php //print $tablaerrores; ?>
								<!-- end content -->
							</div>
			
						</div>
						<!-- end widget div -->
					</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6 col-md-6 col-lg-12">
					<!-- new widget -->
					<div class="jarviswidget jarviswidget-color-blueDark">
						<header>
							<span class="widget-icon"> <i class="fa fa-gears"></i> </span>
							<h2> KPI global del canal <?php print $arreglocanalesprincipal[$canal]; ?> a 30 dias </h2>
						</header>
						<!-- widget div-->
							<div>
								<!-- content goes here -->
								<!-- - - - - - - - - - - - - - - - - - - TABLA CON GRAFICA - - - - - - - - - -  -->
								<?php include "tablaresultadosbyseccion.php"; ?>

								<!-- end content -->
							</div>
			
						
						<!-- end widget div -->
					</div>
			</div>

		</div>

	</div>
	<!-- END MAIN CONTENT -->

</div>
<!-- END MAIN PANEL -->

<!-- ==========================CONTENT ENDS HERE ========================== -->

<!-- PAGE FOOTER -->
<?php
	include("inc/footer.php");
?>
<!-- END PAGE FOOTER -->

<?php 
	//include required scripts
	include("inc/scripts.php");
?>

<!-- PAGE RELATED PLUGIN(S) 
<script src="..."></script>-->
<!-- PAGE RELATED PLUGIN(S) -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.colVis.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.tableTools.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>

<script src="<?php echo ASSETS_URL; ?>/js/plugin/moment/moment.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/fullcalendar/jquery.fullcalendar.min.js"></script>


<script src="<?php echo ASSETS_URL; ?>/js/plugin/highChartCore/highcharts-custom.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/highchartTable/jquery.highchartTable.min.js"></script>


<script>
$(document).ready(function() {


	/*
	--------------------------- TABLE -----------------------------------
	*/

	var responsiveHelper_datatable_tabletools = undefined;
	var responsiveHelper_dt_basic = undefined;

	var breakpointDefinition = {
		tablet : 1024,
		phone : 480
	};


	$('#datatable_tabletools').dataTable({
		
		// Tabletools options: 
		//   https://datatables.net/extensions/tabletools/button_options
		"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'T>r>"+
				"t"+
				"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
        "oTableTools": {
        	 "aButtons": [
             "copy",
             "csv",
             "xls",
                {
                    "sExtends": "pdf",
                    "sTitle": "SmartAdmin_PDF",
                    "sPdfMessage": "SmartAdmin PDF Export",
                    "sPdfSize": "letter"
                },
             	{
                	"sExtends": "print",
                	"sMessage": "Generated by SmartAdmin <i>(press Esc to close)</i>"
            	}
             ],
            "sSwfPath": "js/plugin/datatables/swf/copy_csv_xls_pdf.swf"
        },
		"autoWidth" : true,
		"preDrawCallback" : function() {
			// Initialize the responsive datatables helper once.
			if (!responsiveHelper_datatable_tabletools) {
				responsiveHelper_datatable_tabletools = new ResponsiveDatatablesHelper($('#datatable_tabletools'), breakpointDefinition);
			}
		},
		"rowCallback" : function(nRow) {
			responsiveHelper_datatable_tabletools.createExpandIcon(nRow);
		},
		"drawCallback" : function(oSettings) {
			responsiveHelper_datatable_tabletools.respond();
		}
	});
	




	/*
	----------------------------- CALENDAR --------------------------------
	*/

	
	
	    var date = new Date();
	    var d = date.getDate();
	    var m = date.getMonth();
	    var y = date.getFullYear();
	
	    var hdr = {
	        left: 'title',
	        center: 'month,agendaWeek,agendaDay',
	        right: 'prev,today,next'
	    };
	
	
	
	$('#calendar').fullCalendar({
	
	        header: hdr,
	        editable: false,
	        droppable: false, // this allows things to be dropped onto the calendar !!!
	
	        drop: function (date, allDay) { // this function is called when something is dropped
	
	            // retrieve the dropped element's stored Event Object
	            var originalEventObject = $(this).data('eventObject');
	
	            // we need to copy it, so that multiple events don't have a reference to the same object
	            var copiedEventObject = $.extend({}, originalEventObject);
	
	            // assign it the date that was reported
	            copiedEventObject.start = date;
	            copiedEventObject.allDay = allDay;
	
	            // render the event on the calendar
	            // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
	            $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
	
	            // is the "remove after drop" checkbox checked?
	            if ($('#drop-remove').is(':checked')) {
	                // if so, remove the element from the "Draggable Events" list
	                $(this).remove();
	            }
	
	        },
	
	        select: function (start, end, allDay) {
	            var title = prompt('Event Title:');
	            if (title) {
	                calendar.fullCalendar('renderEvent', {
	                        title: title,
	                        start: start,
	                        end: end,
	                        allDay: allDay
	                    }, true // make the event "stick"
	                );
	            }
	            calendar.fullCalendar('unselect');
	        },
	
	        events: [<?php print $events; ?>],
	
	        eventRender: function (event, element, icon) {
	            if (!event.description == "") {
	                element.find('.fc-title').append("<br/><span class='ultra-light'>" + event.description +
	                    "</span>");
	            }
	            if (!event.icon == "") {
	                element.find('.fc-title').append("<i class='air air-top-right fa " + event.icon +
	                    " '></i>");
	            }
	        },
	
	        windowResize: function (event, ui) {
	            $('#calendar').fullCalendar('render');
	        }
	    });
	
	    /* hide default buttons */
	    $('.fc-right, .fc-center').hide();

	
		$('#calendar-buttons #btn-prev').click(function () {
		    $('.fc-prev-button').click();
		    return false;
		});
		
		$('#calendar-buttons #btn-next').click(function () {
		    $('.fc-next-button').click();
		    return false;
		});
		
		$('#calendar-buttons #btn-today').click(function () {
		    $('.fc-today-button').click();
		    return false;
		});
		
		$('#mt').click(function () {
		    $('#calendar').fullCalendar('changeView', 'month');
		});
		
		$('#ag').click(function () {
		    $('#calendar').fullCalendar('changeView', 'agendaWeek');
		});
		
		$('#td').click(function () {
		    $('#calendar').fullCalendar('changeView', 'agendaDay');
		});			

	pageSetUp();
	$('table.highchart').highchartTable();


})


</script>

<?php 
}else{
	header("Location: login.php");
}
?>