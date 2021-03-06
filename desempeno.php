<style type="text/css">
	.tickLabel {font-size: 80%}
</style>

<?php
session_start();
if (isset($_SESSION["nombrecompleto"])){
	$serverName="192.168.4.21";
	$uid="sa";
	$pwd="tsoft";
	$connectionInfo = array( "UID"=>$uid,"PWD"=>$pwd,"Database"=>"vun_mexico");
	$conn = sqlsrv_connect( $serverName, $connectionInfo);

		/*
		-- --------------------------------------------------------------------------------------------------------------------------- --
		--  determinar fecha de ultima actualizacion de monitoreo en tiempo real
		-- --------------------------------------------------------------------------------------------------------------------------- --
		*/

		$queryultimo="select convert(varchar(5),max(vunweb_reshoyFecha),108) as ultimo from vunweb_resultadoshoy";
		$SqlIDultimo=sqlsrv_query( $conn, $queryultimo);
		$objultimo = sqlsrv_fetch_object($SqlIDultimo);


	 header('Content-Type: text/html; charset= ISO-8859-1'); 
	//initilize the page
	require_once("inc/init.php");

	//require UI configuration (nav, ribbon, etc.)
	require_once("inc/config.ui.php");

	/*---------------- PHP Custom Scripts ---------

	YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
	E.G. $page_title = "Custom Title" */

	$page_title = "VUN";

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
					<div class="col-xs-12 col-sm-7 col-md-7 col-lg-10">
						<h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-home"></i> VUN <span>> Desempe&ntilde;o General por Dispositivo</span></h1>
					</div>
					<div class="col-xs-12 col-sm-7 col-md-7 col-lg-2">
					<div class='label bg-color-blueDark txt-color-white'><i class='fa fa-clock-o'></i><?php include "ultimo.php"; ?>Ultima Actualizacion <?php print $objultimo->ultimo; ?></div>
				</div>


				</div>
				<!-- widget grid -->
				<section id="widget-grid" class="">

					<!-- row -->
					<div class="row">

						<!-- NEW WIDGET START -->
						<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

							<!-- Widget ID (each widget will need unique ID)-->
							<div class="jarviswidget" id="wid-id-2" data-widget-editbutton="false">
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
								<header class="bg-color-darken txt-color-white">
									<span class="widget-icon"> <i class="fa fa-bar-chart-o"></i> </span>
									<h2>Desempe&ntilde;o general por dispositivo</h2>

								</header>

								<!-- widget div-->
								<div>

									<!-- widget edit box -->
									<div class="jarviswidget-editbox">
										<!-- This area used as dropdown edit box -->

									</div>
									<!-- end widget edit box -->

									<!-- widget content -->
									
									<div class="widget-body-toolbar bg-color-white">
										<form id="form1" class="smart-form" role="form">
											<div class="form-group">
												<!--
												<label class="sr-only" for="s123">Show From</label>
												<input type="email" class="form-control input-sm" id="s123" placeholder="Show From">
												-->
											
												<section class="col col-3">
													<label class="input"> <i class="icon-append fa fa-calendar"></i>
														<input type="text" name="startdate" id="startdate" placeholder="Fecha Inicio">
													</label>
												</section>															
																		
											</div>
											<div class="form-group">
												<section class="col col-3">
													<label class="input"> <i class="icon-append fa fa-calendar"></i>
														<input type="text" name="finishdate" id="finishdate" placeholder="Fecha Fin">
													</label>
												</section>
											</div>
											<div class="form-group">
												<section class="col col-3">
													<label class="select">
														<select name="applicationID" id="applicationID">
															<option value="0" selected="" disabled="">[App]</option>
															<option value="-1">[Todas]</option>																		
															<option value="867574fd34df4e97b2d34826597f4453">Santander Mobile Android</option>
															<option value="2ac2d3f7d5f54969a55987908d5600cd">Santander SmartBank Android</option>
															<option value="d56e9149845747158bd778736c096366">Santander SmartBank iOs</option>
														</select> <i></i> </label>
												</section>														
											</div>

											<div class="form-group">	
												<section class="col col-2">
													<button type="submit" class="btn btn-primary">
														Actualizar
													</button>
												</section>
											</div>

										</form>

									</div>
									<div class="widget-body no-padding">
										<br>
										<h4 id="titulo" class="bg-color-darken txt-color-white padding-10"> Titulo3 </h4>
										<br>
										<div class="row">
											<div class="col-md-4">
												<div style="text-align:center;margin-bottom: -4px;">
													<img src="img/tiempo_respuesta.png"  style="max-width:20px; width:100%;">
												</div>
												<br>
												<div style="text-align:center;">
													<span style="font-family:'Trebuchet MS';font-size:15px;line-height:15px;color:#555555;font-weight:bold;">Tiempo de respuesta promedio global</span>
												</div>

												<div id="promedio-1" style="text-align:center;">
														
												</div>											
											</div>
											<div class="col-md-4">
												<div style="text-align:center;margin-bottom: -10px;">
													<img src="img/crashes.png" alt="" style="max-width:30px; width:100%;">
												</div>
												<br>
												<div style="text-align:center;">
													<span style="font-family:'Trebuchet MS';font-size:15px;line-height:15px;color:#555555;font-weight:bold;">Usuarios con crashes promedio global</span>
												</div>
												<div id="promedio-2" style="text-align:center;">
														
												</div>														
											</div>
											<div class="col-md-4">
												<div style="text-align:center;margin-bottom: -9px;">
													<img src="img/bateria.png" alt="" style="max-width:30px; width:100%;">
												</div>
												<br>
												<div style="text-align:center;">
													<span style="font-family:'Trebuchet MS';font-size:15px;line-height:15px;color:#555555;font-weight:bold;">Gasto total de bateria promedio global</span>
												</div>
												<div id="promedio-3" style="text-align:center;">
														
												</div>														
											</div>
										</div>
										<br>
										<h6 class="bg-color-darken txt-color-white"><strong>Promedio tiempo respuesta en segundos</strong></h6>
										<div id="bar-1" class="chart"></div>
										<br>
										<h6 class="bg-color-darken txt-color-white"><strong>Total usuarios afectados</strong></h6>
										<div id="bar-2" class="chart"></div>
										<br>
										<h6 class="bg-color-darken txt-color-white"><strong>Promedio de uso de bater&iacute;a por minuto</strong></h6>
										<div id="bar-3" class="chart"></div>									

									</div>
									<!-- end widget content -->

								</div>
								<!-- end widget div -->

							</div>
							<!-- end widget -->



						</article>
						<!-- WIDGET END -->

					</div>

					<!-- end row -->					

				</section>
				<!-- end widget grid -->

			</div>
			<!-- END MAIN CONTENT -->

		</div>
		<!-- END MAIN PANEL -->

		<!-- PAGE FOOTER -->
		<?php
			include("inc/footer.php");
		?>
		<!-- END PAGE FOOTER -->


		<!--================================================== -->

		<!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
		<script data-pace-options='{ "restartOnRequestAfter": true }' src="js/plugin/pace/pace.min.js"></script>

		<!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script>
			if (!window.jQuery) {
				document.write('<script src="js/libs/jquery-2.1.1.min.js"><\/script>');
			}
		</script>

		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
		<script>
			if (!window.jQuery.ui) {
				document.write('<script src="js/libs/jquery-ui-1.10.3.min.js"><\/script>');
			}
		</script>

		<!-- IMPORTANT: APP CONFIG -->
		<script src="js/app.config.js"></script>

		<!-- JS TOUCH : include this plugin for mobile drag / drop touch events-->
		<script src="js/plugin/jquery-touch/jquery.ui.touch-punch.min.js"></script> 

		<!-- BOOTSTRAP JS -->
		<script src="js/bootstrap/bootstrap.min.js"></script>

		<!-- CUSTOM NOTIFICATION -->
		<script src="js/notification/SmartNotification.min.js"></script>

		<!-- JARVIS WIDGETS -->
		<script src="js/smartwidgets/jarvis.widget.min.js"></script>

		<!-- EASY PIE CHARTS -->
		<script src="js/plugin/easy-pie-chart/jquery.easy-pie-chart.min.js"></script>

		<!-- SPARKLINES -->
		<script src="js/plugin/sparkline/jquery.sparkline.min.js"></script>

		<!-- JQUERY VALIDATE -->
		<script src="js/plugin/jquery-validate/jquery.validate.min.js"></script>

		<!-- JQUERY MASKED INPUT -->
		<script src="js/plugin/masked-input/jquery.maskedinput.min.js"></script>

		<!-- JQUERY SELECT2 INPUT -->
		<script src="js/plugin/select2/select2.min.js"></script>

		<!-- JQUERY UI + Bootstrap Slider -->
		<script src="js/plugin/bootstrap-slider/bootstrap-slider.min.js"></script>

		<!-- browser msie issue fix -->
		<script src="js/plugin/msie-fix/jquery.mb.browser.min.js"></script>

		<!-- FastClick: For mobile devices -->
		<script src="js/plugin/fastclick/fastclick.min.js"></script>

		<!--[if IE 8]>

		<h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>

		<![endif]-->



		<!-- MAIN APP JS FILE -->
		<script src="js/app.min.js"></script>

		<!-- ENHANCEMENT PLUGINS : NOT A REQUIREMENT -->
		<!-- Voice command : plugin -->
		<script src="js/speech/voicecommand.min.js"></script>

		<!-- SmartChat UI : plugin -->
		<script src="js/smart-chat-ui/smart.chat.ui.min.js"></script>
		<script src="js/smart-chat-ui/smart.chat.manager.min.js"></script>
		<script src="js/smart-chat-ui/smart.chat.manager.min.js"></script>
		
		<!-- PAGE RELATED PLUGIN(S) -->
		
		<!-- Flot Chart Plugin: Flot Engine, Flot Resizer, Flot Tooltip -->
		<script src="js/plugin/flot/jquery.flot.cust.min.js"></script>
		<script src="js/plugin/flot/jquery.flot.resize.min.js"></script>
		<script src="js/plugin/flot/jquery.flot.time.min.js"></script>
		<script src="js/plugin/flot/jquery.flot.tooltip.min.js"></script>
		<script src="js/plugin/flot/jquery.flot.fillbetween.min.js"></script>
		<script src="js/plugin/flot/jquery.flot.orderBar.min.js"></script>
		<script src="js/plugin/flot/jquery.flot.pie.min.js"></script>
	    <script src="js/plugin/flot/jquery.flot.categories.min.js"></script>
	
		
		
		<!-- Vector Maps Plugin: Vectormap engine, Vectormap language -->
		<script src="js/plugin/vectormap/jquery-jvectormap-1.2.2.min.js"></script>
		<script src="js/plugin/vectormap/jquery-jvectormap-world-mill-en.js"></script>
		
		<!-- Full Calendar -->
		<script src="js/plugin/moment/moment.min.js"></script>
		<script src="js/plugin/fullcalendar/jquery.fullcalendar.min.js"></script>
		
		
		<!-- PAGE RELATED PLUGIN(S) -->
		<script src="js/plugin/datatables/jquery.dataTables.min.js"></script>
		<script src="js/plugin/datatables/dataTables.colVis.min.js"></script>
		<script src="js/plugin/datatables/dataTables.tableTools.min.js"></script>
		<script src="js/plugin/datatables/dataTables.bootstrap.min.js"></script>
		<script src="js/plugin/datatable-responsive/datatables.responsive.min.js"></script>


		<script>
		
		
			var $chrt_border_color = "#efefef";
			var $chrt_grid_color = "#DDD"
			var $chrt_main = "#E24913";
			/* red       */
			var $chrt_second = "#6595b4";
			/* blue      */
			var $chrt_third = "#FF9F01";
			/* orange    */
			var $chrt_fourth = "#7e9d3a";
			/* green     */
			var $chrt_fifth = "#BD362F";
			/* dark red  */
			var $chrt_mono = "#000";		
		
			$(document).ready(function() {

				// DO NOT REMOVE : GLOBAL FUNCTIONS!
	

			// START AND FINISH DATE
			$('#startdate').datepicker({
				dateFormat : 'yy-mm-dd',
				prevText : '<i class="fa fa-chevron-left"></i>',
				nextText : '<i class="fa fa-chevron-right"></i>',
				onSelect : function(selectedDate) {
					$('#finishdate').datepicker('option', 'minDate', selectedDate);
				}
			});
			
		
			$('#finishdate').datepicker({
				dateFormat : 'yy-mm-dd',
				prevText : '<i class="fa fa-chevron-left"></i>',
				nextText : '<i class="fa fa-chevron-right"></i>',
				onSelect : function(selectedDate) {
					$('#startdate').datepicker('option', 'maxDate', selectedDate);
				}
			});
			
		
			$("#form1").submit(function( event ) {
			event.preventDefault();
			var startdate = $("input[name=startdate]").val();
			var finishdate = $("input[name=finishdate]").val();
			var appID = $("select[name=applicationID]").val();
			var appName = $("#applicationID option:selected").text();
			//console.log("app:", $("#applicationID option:selected").text());
			
			var series = [];
	
			
			//http://jsfiddle.net/larsenmtl/zCuQ5/1/
			
			getBarsTiempoRespuesta(startdate, finishdate, appID, appName);
			getBarsUsuariosAfectados(startdate, finishdate, appID, appName);
			getBarsBateria(startdate, finishdate, appID, appName);
			
			});
		
			
			var options = {
				lines: {
					show: true
				},
				points: {
					show: true
				},
				xaxis: {
					tickDecimals: 0,
					tickSize: 1
				}
			};
	
			var series = []
			var data = [];
	
			//$.plot("#statsChart", data, options);				
	
			var today = new Date();
			var dd = today.getDate();
			var mm = today.getMonth()+1; 
			var yyyy = today.getFullYear();
	
			if(dd<10) 
			{
				dd='0'+dd;
			} 
	
			if(mm<10) 
			{
				mm='0'+mm;
			} 	
	
		
			//today = mm+'/'+dd+'/'+yyyy;
			hoy_str = yyyy+'-'+mm+'-'+dd;
			//console.log("Hoy:",hoy_str);
			
			today.setDate(dd - 7);		
			var dd_ayer = today.getDate();
			var mm_ayer = today.getMonth()+1; 
			var yyyy_ayer = today.getFullYear();			
			if(dd_ayer<10) 
			{
				dd_ayer='0'+dd_ayer;
			} 
	
			if(mm_ayer<10) 
			{
				mm_ayer='0'+mm_ayer;
			} 
	
			ayer_str = yyyy_ayer+'-'+mm_ayer+'-'+dd_ayer;			
			//console.log("Ayer:",ayer_str);
			//console.log("Hoy:",hoy_str);
	
			getBarsTiempoRespuesta(ayer_str,hoy_str, 'd56e9149845747158bd778736c096366',"Santander SmartBank iOS");
			getBarsUsuariosAfectados(ayer_str,hoy_str, 'd56e9149845747158bd778736c096366',"Santander SmartBank iOS");
			getBarsBateria(ayer_str,hoy_str, 'd56e9149845747158bd778736c096366',"Santander SmartBank iOS");
			
			/* bar chart */
			
			
			function getBarsTiempoRespuesta(startdate,finishdate,appID, appName){
				
				$.ajax({
					data: {"startdate" : startdate, "finishdate" :finishdate, "appID" : appID},
					type: "GET",
					dataType: "json",
					url: "apppulse_desempenho_tiempo.php",
				})
				.done(function( data, textStatus, jqXHR ) {
					console.log("DATOS LEIDOS:",data);
					if(data.length > 1){
						var series = [];
						for(i=0;i<data.length;i++){
							//series.push(data[i].data);
							series.push({"data":data[i].data,"label":data[i].label});
						}
						$("#titulo").text(appName);
						onDataReceivedBarsTiempoRespuesta(series);					 
					}
					else{
						$("#titulo").text(appName);
						onDataReceivedBarsTiempoRespuesta([{"data":data[0].data,"label": appName}]);
					}
	
				})
				.fail(function( jqXHR, textStatus, errorThrown ) {
					if ( console && console.log ) {
						console.log( "La solicitud a fallado: " +  textStatus);
					}
				});
	
			}

			function getBarsUsuariosAfectados(startdate,finishdate,appID, appName){
				
				$.ajax({
					data: {"startdate" : startdate, "finishdate" :finishdate, "appID" : appID},
					type: "GET",
					dataType: "json",
					url: "apppulse_desempenho_usuarios.php",
				})
				.done(function( data, textStatus, jqXHR ) {
					//console.log("mis datos:",data);
					if(data.length > 1){
						var series = [];
						for(i=0;i<data.length;i++){
							//series.push(data[i].data);
							series.push({"data":data[i].data,"label":data[i].label});
						}
						$("#titulo").text(appName);
						onDataReceivedUsuariosAfectados(series);					 
					}
					else{
						$("#titulo").text(appName);
						onDataReceivedUsuariosAfectados([{"data":data[0].data,"label": appName}]);
					}
	
				})
				.fail(function( jqXHR, textStatus, errorThrown ) {
					if ( console && console.log ) {
						console.log( "La solicitud a fallado: " +  textStatus);
					}
				});
	
			}			
			
			function getBarsBateria(startdate,finishdate,appID, appName){
				
				$.ajax({
					data: {"startdate" : startdate, "finishdate" :finishdate, "appID" : appID},
					type: "GET",
					dataType: "json",
					url: "apppulse_desempenho_bateria.php",
				})
				.done(function( data, textStatus, jqXHR ) {
					//console.log("mis datos:",data);
					if(data.length > 1){
						var series = [];
						for(i=0;i<data.length;i++){
							//series.push(data[i].data);
							series.push({"data":data[i].data,"label":data[i].label});
						}
						$("#titulo").text(appName);
						onDataReceivedBateria(series);					 
					}
					else{
						$("#titulo").text(appName);
						onDataReceivedBateria([{"data":data[0].data,"label": appName}]);
					}
	
				})
				.fail(function( jqXHR, textStatus, errorThrown ) {
					if ( console && console.log ) {
						console.log( "La solicitud a fallado: " +  textStatus);
					}
				});
	
			}				
			
			
			function onDataReceivedBarsTiempoRespuesta(series) {
			
				data = [ series ];
				var datitos = [];
				
				console.log("Series Bar:", series)
				
				arreglo_padre = []
				
				for(i=0;i<series.length;i++){
					var aux = series[i].data;
					var version = [];
					var batteryPenalty = [];
					var networkPenalty = [];
					var total = 0;
					for(j=0;j<aux.length;j++){

						//fundex.push([aux[j].timestamp,aux[j].fundex]);
						var labelpaso=aux[j].name
						var labelpaso2=labelpaso.replace(" ","<br>");
						var labelpaso3=labelpaso2.replace(" ","<br>");
						var tr=(aux[j].averageResponseTimeInMS/1000);
						version.push([labelpaso3,parseFloat(tr.toFixed(2))]);
						total += tr
						
					}
					var avg = total/aux.length;
					$("#promedio-1").text(avg.toFixed(4));
					//arreglo_padre.push({"data":arreglo,"label":series[i].label});
				}
				
				
				console.log("version:",version);
				//console.log("fundex:",fundexxx);


				$.plot("#bar-1", [{
					data: version,
					label: "Tiempo respuesta",
					bars: {
							show: true,
							barWidth: 0.4,
							align: "center",
							fillColor: '#0000c0',
							lineWidth: 0
						}
					
				}], {
					series: {
						bars: {
							show: true,
							barWidth: 0.6,
							align: "center"
						}
					},
					legend : true,
					tooltip : true,
					tooltipOpts : {
						content : "<b>%s</b> : <span>%y</span>",
						dateFormat : "%d-%m-%y %H:%M",
						defaultTheme : false
					},
					xaxis: {
						mode: "categories",
						tickLength: 0
					},
					grid: { hoverable: true, clickable: true }
				});


				
			}				

			function onDataReceivedUsuariosAfectados(series) {
			
				data = [ series ];
				var datitos = [];
				
				console.log("Series Bar Dispositivo:", series);
				
				arreglo_padre = []
				for(i=0;i<series.length;i++){
					var aux = series[i].data;
					var dispositivo = [];
					var batteryPenalty = [];
					var networkPenalty = [];

					var total = 0;
					for(j=0;j<aux.length;j++){

						//fundex.push([aux[j].timestamp,aux[j].fundex]);
						var labelpaso=aux[j].name
						var labelpaso2=labelpaso.replace(" ","<br>");
						var labelpaso3=labelpaso2.replace(" ","<br>");
						dispositivo.push([labelpaso3,aux[j].affectedUsers]);
						total += aux[j].affectedUsers;
						
					}
					var avg = Math.round(total/aux.length);
					$("#promedio-2").text(avg);					
					//arreglo_padre.push({"data":arreglo,"label":series[i].label});
				}
				
				
				//console.log("d:",d);
				//console.log("fundex:",fundexxx);


				$.plot("#bar-2", [{
					data: dispositivo,
					label: "Usuarios afectados",
					bars: {
							show: true,
							barWidth: 0.4,
							align: "left",
							fillColor: '#c00000',
							lineWidth: 0
						}
					
				}], {
					series: {
						bars: {
							show: true,
							barWidth: 0.6,
							align: "center"
						}
					},
					legend : true,
					tooltip : true,
					tooltipOpts : {
						content : "<b>%s</b> : <span>%y</span>",
						dateFormat : "%d-%m-%y %H:%M",
						defaultTheme : false
					},
					xaxis: {
						mode: "categories",
						tickLength: 0
					},
					grid: { hoverable: true, clickable: true }
				});


				
			}			

			function onDataReceivedBateria(series) {
			
				data = [ series ];
				var datitos = [];
				
				console.log("Series Bar Dispositivo:", series);
				
				arreglo_padre = []
				for(i=0;i<series.length;i++){
					var aux = series[i].data;
					var dispositivo = [];
					var batteryPenalty = [];
					var networkPenalty = [];

					var total = 0;
					for(j=0;j<aux.length;j++){

						//fundex.push([aux[j].timestamp,aux[j].fundex]);
						var labelpaso=aux[j].name
						var labelpaso2=labelpaso.replace(" ","<br>");
						var labelpaso3=labelpaso2.replace(" ","<br>");
						dispositivo.push([labelpaso3,parseFloat(aux[j].batteryUsagePerMinute.toFixed(2))]);
						total += aux[j].batteryUsagePerMinute
						
					}
					var avg = (total/aux.length);
					$("#promedio-3").text(avg.toFixed(4));							
					//arreglo_padre.push({"data":arreglo,"label":series[i].label});
				}
				
				
				//console.log("d:",d);
				//console.log("fundex:",fundexxx);


				$.plot("#bar-3", [{
					data: dispositivo,
					label: "Bater&iacute;a",
				
					bars: {
							show: true,
							barWidth: 0.4,
							align: "center",
							fillColor: '#00c000',
							lineWidth: 0
						}
					
				}], {
					series: {
						bars: {
							show: true,
							barWidth: 0.6,
							align: "center"
						}
					},
					legend : true,
					tooltip : true,
					tooltipOpts : {
						content : "<b>%s</b> : <span>%y</span>",
						dateFormat : "%d-%m-%y %H:%M",
						defaultTheme : false
					},
					xaxis: {
						mode: "categories",
						tickLength: 0
					},
					grid: { hoverable: true, clickable: true }
				});


				
			}		
			
			/* end bar chart */
		
		})		
		
		</script>
	</body>

</html>
<?php 
	}else{
		header("Location: login.php");  
	}
?>