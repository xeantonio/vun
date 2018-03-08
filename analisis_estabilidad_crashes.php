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
						<h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-home"></i> VUN <span>> An&aacute;lisis de estabilidad por crashes</span></h1>
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
									<h2>An&aacute;lisis de usuarios con crashes</h2>

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
										<h4 id="titulo" class="bg-color-darken txt-color-white">  </h4>
										<br>
										<h2 class="bg-color-darken txt-color-white"><strong>Por Versi&oacute;n</strong></h2>
										<div id="pie-chart" class="chart"></div>
										<br>
										<h2 class="bg-color-darken txt-color-white"><strong>Total por Dispositivo</strong></h2>
										<div id="bar-dispositivo" class="chart"></div>
										<br>
										<h2 class="bg-color-darken txt-color-white"><strong>Resumen de Errores</strong></h2>
										<table id="dt_basic" ></table>
										<div id="paginador"></div>									

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
		
		
		<script src="js/plugin/jqgrid/jquery.jqGrid.min.js"></script>
		<script src="js/plugin/jqgrid/grid.locale-en.min.js"></script>		

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

			$("#dt_basic").jqGrid({
				colModel: [
					{
						label: 'Fecha',
						name: 'timestamp',
						width: 40//,
						//formatter: formatTitle
					},
					{
						label: 'Acciones Totales',
						name: 'actions',
						width: 40

					},
					{
						label: 'Errores de aplicaci&oacute;n',
						name: 'appActionsWithErrors',
						width: 35,
						sorttype:'integer',
						//formatter: 'number',
						align: 'right'
					},
					{
						label: 'Errores por cliente',
						name: 'clientActionsWithErrors',
						width: 35,
						sorttype:'integer',
						//formatter: 'number',
						align: 'right'
					},
					{
						label: 'Errores por red',
						name: 'networkActionsWithErrors',
						width: 35,
						sorttype:'integer',
						//formatter: 'number',
						align: 'right'
					},
					{
						label: 'Errores por SDK',
						name: 'sdkActionsWithErrors',
						width: 35,
						sorttype:'integer',
						//formatter: 'number',
						align: 'right'
					}					
				],
				
				/*

				grouping:true,
				groupingView : {
					groupField : ['timestamp'],
					groupCollapse: true,
					groupColumnShow : [false],
					groupDataSorted: true,
					//groupText : ['<b>{0} - {1} Item(s)</b>']
					groupText : ['Fecha: <b>{0} </b>']
					
				},
				*/

				viewrecords: true, // show the current page, data rang and total records on the toolbar
				//width: 780,
				autowidth : true,
				//height: 200,
				height: 'auto',
				rowNum: 100,
				datatype: 'local',
				//pgtext : "",
				//pginput : false						
				pager: "#paginador"//,
				//caption: "Load live data from stackoverflow"
			});

				
			function fetchGridData(startdate,finishdate,appID, appName) {
				
				var gridArrayData = [];
				// show loading message
				$("#dt_basic")[0].grid.beginReq();
				$.ajax({
					url: "apppulse_estabilidad_crashes_tabla.php?startdate=" + startdate + "&finishdate=" + finishdate + "&appID=" + appID,
					success: function (result) {
						console.log("result:",result[0].data);
						for (var i = 0; i < result[0].data.length; i++) {
							var item = result[0].data[i];
							
							

							gridArrayData.push({
								timestamp: item.timestamp,
								actions: item.actions,
								appActionsWithErrors: item.appActionsWithErrors,
								clientActionsWithErrors: item.clientActionsWithErrors,
								networkActionsWithErrors: item.networkActionsWithErrors,
								sdkActionsWithErrors: item.sdkActionsWithErrors

							});                            
						}
						// set the new data
						//console.log("griddata:",gridArrayData);
						$("#dt_basic").jqGrid('clearGridData');
						$("#dt_basic").jqGrid('setGridParam', { data: gridArrayData});
						// hide the show message
						$("#dt_basic")[0].grid.endReq();
						// refresh the grid
						$("#dt_basic").trigger('reloadGrid');
					}
				});
			}		

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
			
			getPie(startdate, finishdate, appID, appName);
			getBarsDispositivo(startdate, finishdate, appID, appName);
			fetchGridData(startdate, finishdate, appID, appName);
			
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
			
			today.setDate(dd - 30);		
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
	
			//getPie(ayer_str,hoy_str, 'd56e9149845747158bd778736c096366',"Santander SmartBank iOS");
			getPie(ayer_str,hoy_str, '867574fd34df4e97b2d34826597f4453',"Santander Mobile Android");
			getBarsDispositivo(ayer_str,hoy_str, '867574fd34df4e97b2d34826597f4453',"Santander Mobile Android");
			fetchGridData(ayer_str,hoy_str,'867574fd34df4e97b2d34826597f4453',"Santander Mobile Android");
			
			/* bar chart */

					

			function myformatter(cellvalue, options, rowObject ){
				//console.log("myformatter",cellvalue, options, rowObject );
				return rowObject.pais;
			}					

			$("#dt_basic").jqGrid('filterToolbar',{
			  autosearch: true,
			  stringResult: true,
			  searchOnEnter: true,
			  defaultSearch: "cn"
			});					
			
	
			
			function getPie(startdate,finishdate,appID, appName){

				console.log("akiiiii");
				
				$.ajax({
					data: {"startdate" : startdate, "finishdate" :finishdate, "appID" : appID},
					type: "GET",
					dataType: "json",
					url: "apppulse_estabilidad_crashes_versiones.php",
				})
				.done(function( data, textStatus, jqXHR ) {
					console.log("DATITO:",data);
					console.log("PIECITO:",data[0].data);
					var series = [];
					var datitos = data[0].data;
					for(i=0;i<datitos.length;i++){
						//series.push(data[i].data);
						//console.log(datitos[i]);
						series.push({"data":datitos[i].affectedUsersRatio,"label":datitos[i].appVersion});
					}
					//$("#titulo").text(appName);
					console.log("*******",series);
					onDataReceivedPie(series);					 

	
				})
				.fail(function( jqXHR, textStatus, errorThrown ) {
					if ( console && console.log ) {
						console.log( "La solicitud a fallado: " +  textStatus);
					}
				});
	
			}

			function getBarsDispositivo(startdate,finishdate,appID, appName){
				
				$.ajax({
					data: {"startdate" : startdate, "finishdate" :finishdate, "appID" : appID},
					type: "GET",
					dataType: "json",
					url: "apppulse_estabilidad_crashes_dispositivos.php",
				})
				.done(function( data, textStatus, jqXHR ) {
					console.log(" +++++++++++++++++++ :",data);
					if(data.length > 1){
						var series = [];
						for(i=0;i<data.length;i++){
							//series.push(data[i].data);
							series.push({"data":data[i].data,"label":data[i].label});
						}
						$("#titulo").text(appName);
						onDataReceivedBarsDispositivo(series);					 
					}
					else{
						$("#titulo").text(appName);
						onDataReceivedBarsDispositivo([{"data":data[0].data,"label": appName}]);
					}
	
				})
				.fail(function( jqXHR, textStatus, errorThrown ) {
					if ( console && console.log ) {
						console.log( "La solicitud a fallado: " +  textStatus);
					}
				});
	
			}			

			
			function onDataReceivedPie(series) {
			
				data = [ series ];
				var datitos = [];
				
				//console.log("Series Pie:", series)
				
				arreglo_padre = []
				for(i=0;i<series.length;i++){
					console.log(">>>>>",series[i]);
					arreglo_padre.push({"data":series[i].data,"label":series[i].label});
				}
				console.log("AP:",arreglo_padre);
				
				//console.log("d:",d);
				//console.log("fundex:",fundexxx);

				
				/* pie chart */

				if ($('#pie-chart').length) {

					var data_pie = [];
					var series = Math.floor(Math.random() * 10) + 1;
					for (var i = 0; i < series; i++) {
						data_pie[i] = {
							label : "Series" + (i + 1),
							data : Math.floor(Math.random() * 100) + 1
						}
					}

					console.log("Pie:", data_pie);
					$.plot($("#pie-chart"), arreglo_padre, {
						series : {
							pie : {
								show : true,
								innerRadius : 0.5,
								radius : 1,
								label : {
									show : true,
									radius : 2 / 3,
									formatter : function(label, series) {
										return '<div style="font-size:11px;text-align:center;padding:4px;color:white;">' + label + '<br/>' + Math.round(series.percent) + '%</div>';
									},
									threshold : 0.1
								}
							}
						},
						legend : {
							show : true,
							noColumns : 1, // number of colums in legend table
							labelFormatter : null, // fn: string -> string
							labelBoxBorderColor : "#000", // border color for the little label boxes
							container : null, // container (as jQuery object) to put legend in, null means default on top of graph
							position : "ne", // position of default legend container within plot
							margin : [5, 10], // distance from grid edge to default legend container within plot
							backgroundColor : "#efefef", // null means auto-detect
							backgroundOpacity : 1 // set to 0 to avoid background
						},
						grid : {
							hoverable : true,
							clickable : true
						},
					});

				}
				
			


				
			}				

			function onDataReceivedBarsDispositivo(series) {
			
				data = [ series ];
				var datitos = [];
				

				
				arreglo_padre = []
				for(i=0;i<series.length;i++){
					var aux = series[i].data;
					var dispositivo = [];
					var battery = [];
					var cellular = [];

				
					for(j=0;j<aux.length;j++){

						//fundex.push([aux[j].timestamp,aux[j].fundex]);
							var labelpaso= aux[j].deviceModel;
							var labelpaso2 = labelpaso.replace(" ","<br>");
							var labelpaso3= labelpaso2.toLowerCase().replace(" ","<br>");
							labelpaso3=labelpaso3.charAt(0).toUpperCase() + labelpaso3.slice(1)


						battery.push([labelpaso3,aux[j].affectedUsers]);
						//cellular.push([aux[j].timestamp,aux[j].cellularData]);
						
					}
					//arreglo_padre.push({"battery":battery, "cellular":cellular, "label":series[i].label});
				}
				
				
				console.log("+++++arreglo_padre:",arreglo_padre);
				//console.log("fundex:",fundexxx);


				$.plot("#bar-dispositivo", [{
					data: battery,
					label: "Usuarios afectados",
					bars: {
							show: true,
							barWidth: 0.2,
							align: "center"
						}
					
				}], {
					series: {
						bars: {
							show: true//,
							//barWidth: 1.5,
							//align: "center"
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