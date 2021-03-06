
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
		<style>

			.demo-container {
				box-sizing: border-box;
				width: 850px;
				height: 450px;
				padding: 20px 15px 15px 15px;
				margin: 15px auto 30px auto;
				border: 1px solid #ddd;
				background: #fff;
			}

			.demo-placeholder {
				width: 100%;
				height: 100%;
				font-size: 14px;
				line-height: 1.2em;
			}
			
		</style>
		
		
		<div id="content">

				<div class="row">
					<div class="col-xs-12 col-sm-7 col-md-7 col-lg-10">
						<h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-home"></i> VUN <span>> An&aacute;lisis de Recursos</span></h1>
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
									<h2>PROMEDIO DE ACCESO DIARIOS DE USUARIOS</h2>

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
										<table id="dt_basic" ></table>
										<div id="paginador"></div>										
										<br>
																				
										
										<h2 class="alert"><strong>Por tipo de conexi&oacute;n</strong></h2>
										
									
										<div id="pie-chart" class="chart"></div>
										<br>
										
										<h2 class="alert"><strong>Uso Bater&iacute;a</strong></h2>
										<div id="bar-bateria" class="chart"></div>
										
										<h2 class="alert"><strong>Uso Datos</strong></h2>
										<div id="bar-datos" class="chart"></div>										
										
										
										<br>
									

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


					function hslToRgb(h, s, l){
						var r, g, b;

						if(s == 0){
							r = g = b = l; // achromatic
						}else{
							function hue2rgb(p, q, t){
								if(t < 0) t += 1;
								if(t > 1) t -= 1;
								if(t < 1/6) return p + (q - p) * 6 * t;
								if(t < 1/2) return q;
								if(t < 2/3) return p + (q - p) * (2/3 - t) * 6;
								return p;
							}

							var q = l < 0.5 ? l * (1 + s) : l + s - l * s;
							var p = 2 * l - q;
							r = hue2rgb(p, q, h + 1/3);
							g = hue2rgb(p, q, h);
							b = hue2rgb(p, q, h - 1/3);
						}

						return [Math.floor(r * 255), Math.floor(g * 255), Math.floor(b * 255)];
					}

					// convert a number to a color using hsl
					function numberToColorHsl(i) {
						// as the function expects a value between 0 and 1, and red = 0° and green = 120°
						// we convert the input to the appropriate hue value
						var hue = i * 1.2 / 360;
						// we convert hsl to rgb (saturation 100%, lightness 50%)
						var rgb = hslToRgb(hue, 1, .5);
						// we format to css value and return
						return 'rgb(' + rgb[0] + ',' + rgb[1] + ',' + rgb[2] + ')'; 
					}

					// convert a color to a number using hsl
					// based on formula as provided by @KamilT
					function numberToColorRgb(i,max) {
						// we calculate red and green
						var red = Math.floor(255 - (255 * i / 100));
						var green = Math.floor(255 * i / 100);
						// we format to css value and return
						return 'rgb('+red+','+green+',0)'
					}
									
										

					$("#dt_basic").jqGrid({
						colModel: [
							{
								label: 'Dominio',
								name: 'domain',
								width: 50//,
								//formatter: formatTitle
							},
							{
								label: 'Porcentaje',
								name: 'porc',
								width: 40,
								align: 'center',
								search: false,
								sorttype:'float'
								//formatter: formatColor
							}
						],

						viewrecords: true, // show the current page, data rang and total records on the toolbar
						//width: 780,
						autowidth : true,
						//height: 200,
						height: 'auto',
						rowNum: 100,
						datatype: 'local',
						//pgtext : "",
						//pginput : false						
						pager: "#paginador",
						caption: "Dominio"
					});					

					
					jQuery("#dt_basic").jqGrid('filterToolbar', { stringResult: true, searchOnEnter: false, defaultSearch: "cn" });

					var max_averageHits = 0;
					var max_avgAffectedUsersCrashes = 0;

					function fetchGridData(startdate,finishdate,appID, appName) {
						
						var gridArrayData = [];
						// show loading message
						$("#dt_basic")[0].grid.beginReq();
						$.ajax({
							url: "apppulse_recursos_dominios.php?startdate=" + startdate + "&finishdate=" + finishdate + "&appID=" + appID,
							success: function (result) {
								//console.log("result:",result[0].data);
								for (var i = 0; i < result[0].data.length; i++) {
									var item = result[0].data[i];
									//console.log("item:",item);
									gridArrayData.push({
										domain: item.domain,
										porc: item.porc
									});
									/*
									if(item.averageHits>=max_averageHits){
										max_averageHits = item.averageHits; 
									}
									
									if(item.avgAffectedUsersCrashes>=max_avgAffectedUsersCrashes){
										max_avgAffectedUsersCrashes = item.avgAffectedUsersCrashes; 
									}
									*/									
									
								}
								// set the new data
								$("#dt_basic").jqGrid('setGridParam', { data: gridArrayData});
								// hide the show message
								$("#dt_basic")[0].grid.endReq();
								// refresh the grid
								$("#dt_basic").trigger('reloadGrid');
							}
						});
					}					
					
					

					function formatTitle(cellValue, options, rowObject) {
						return cellValue.substring(0, 50) + "...";
					};

					function formatLink(cellValue, options, rowObject) {
						return "<a href='" + cellValue + "'>" + cellValue.substring(0, 25) + "..." + "</a>";
					};					


					function formatColor(cellValue, options, rowObject) {
						//console.log("---------",cellValue, options, rowObject);
						//console.log("max_averageHits:",max_averageHits );
						//return rowObject.averageHits;
						var color = numberToColorRgb(rowObject.averageHits, max_averageHits);
						return rowObject.averageHits +' <i class="fa fa-circle" style="font-size:20px;color:' + color + ';"></i>';
						//return '<span class="cellWithoutBackground" style="background-color:' +  color + ';">' + rowObject.averageHits + '</span>';
					};						

					
					function formatColor2(cellValue, options, rowObject) {
						//console.log("---------",cellValue, options, rowObject);
						//console.log("max_averageHits:",max_averageHits );
						//return rowObject.averageHits;
						var color = numberToColorRgb(max_avgAffectedUsersCrashes - rowObject.avgAffectedUsersCrashes,max_avgAffectedUsersCrashes);
						return rowObject.avgAffectedUsersCrashes +' <i class="fa fa-circle" style="font-size:20px;color:' + color + ';"></i>';
						//return '<span class="cellWithoutBackground" style="background-color:' +  color + ';">' + rowObject.avgAffectedUsersCrashes + '</span>';
					};					
					
					
					function formatBar(cellValue, options, rowObject) {
						//console.log("---------",cellValue, options, rowObject);
						//console.log("---------",rowObject.averageHits, rowObject.avgAffectedUsersCrashes );
						//return "<a href='" + cellValue + "'>" + cellValue.substring(0, 25) + "..." + "</a>";
						//return "<div class='bar-holder'><div class='progress'><div class='progress-bar bg-color-blue' data-transitiongoal='25'></div></div></div>";
						//return "<div class='progress'><div class='progress-bar bg-color-teal' data-transitiongoal='25'></div></div>";
						var maximo_hits = 500;
						var hits_porc = (rowObject.averageHits/maximo_hits)*100;
						var maximo_affected_users = 200;
						var affected_users_porc = (rowObject.avgAffectedUsersCrashes/maximo_affected_users)*100;
						return "<div class='bar-holder'><div class='progress'><div class='progress-bar bg-color-teal' data-transitiongoal='" + hits_porc +"' aria-valuenow='" + rowObject.averageHits +"' style='width: " + hits_porc +"%;'>" + rowObject.averageHits +"</div></div></div> " + 
						       "<div class='bar-holder'><div class='progress'><div class='progress-bar bg-color-redLight' data-transitiongoal='" + affected_users_porc +"' aria-valuenow='" + rowObject.avgAffectedUsersCrashes +"' style='width: " + affected_users_porc +"%;'>" + rowObject.avgAffectedUsersCrashes +"</div></div></div>";
					};	



				

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
			getBarsDispositivo(startdate, finishdate, "-1", appName);
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
	
			getPie(ayer_str,hoy_str, 'd56e9149845747158bd778736c096366',"Santander SmartBank iOS");
			getBarsDispositivo(ayer_str,hoy_str, '-1',"Santander SmartBank iOS");
			fetchGridData(ayer_str,hoy_str, 'd56e9149845747158bd778736c096366',"Santander SmartBank iOS");

			
			/* bar chart */
			
			
			function getPie(startdate,finishdate,appID, appName){
				
				$.ajax({
					data: {"startdate" : startdate, "finishdate" :finishdate, "appID" : appID},
					type: "GET",
					dataType: "json",
					url: "apppulse_recursos_conexion.php",
				})
				.done(function( data, textStatus, jqXHR ) {
					console.log("PIECITO:",data[0].data);
					var series = [];
					var datitos = data[0].data;
					for(i=0;i<datitos.length;i++){
						//series.push(data[i].data);
						//console.log(datitos[i]);
						series.push({"data":datitos[i].value,"label":datitos[i].type});
					}
					//$("#titulo").text(appName);
					//console.log("*******",series);
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
					url: "apppulse_recursos_datos_bateria.php",
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
								radius : 1,

								label : {
									show : true,
									radius : 3 / 4,
									formatter : function(label, series) {
										console.log("_______:",label,series);
										return '<div style="font-size:11px;text-align:center;padding:4px;color:black;">' + label + '<br/>' + Math.round(series.percent) + '%</div>';
									},
									threshold : 0.01					
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
				
				console.log("Series Bar Dispositivo:", series);
				
				var arreglo_padre = new Array();
				for(i=0;i<series.length;i++){
					var aux = series[i].data;
					var dispositivo = [];
					var battery = new Array();
					var cellular = new Array();
					var battery2 = new Array();
					var cellular2 = new Array();
					var ticksdate = new Array();
					var ts;

				
					for(j=0;j<aux.length;j++){

						//fundex.push([aux[j].timestamp,aux[j].fundex]);
						ts = aux[j].timestamp;
						console.log(ts,aux[j].cellularData);
						battery.push([ts,aux[j].batteryUsage]);
						cellular.push([ts,aux[j].cellularData]);
						
						battery2.push([j,aux[j].batteryUsage]);
						cellular2.push([j,aux[j].cellularData]);						
						ticksdate.push([j,ts])
						
					}
					
					
					console.log("cell:",cellular);
					arreglo_padre.push({"battery":battery2, "cellulard":cellular2, "label":series[i].label});
				}
				
				
				console.log("+++++arreglo_padre:",arreglo_padre);
				//console.log("fundex:",fundexxx);
				console.log(arreglo_padre[0].cellulard);
				console.log(arreglo_padre[1].cellulard);
				console.log(arreglo_padre[2].cellulard);				
				/*
				$.plot("#bar-bateria", [{
					data: arreglo_padre[0].battery,
					label: "Santander Mobile Android - Bater&iacute;a",
					bars: {
							show: true,
							barWidth: 0.2,
							align: "right"
						}
					
				},{
					data: arreglo_padre[1].battery,
					label: "Santander SmartBank Android - Bater&iacute;a",
					bars: {
							show: true,
							barWidth: 0.2,
							align: "center"
						}
					
				},{
					data: arreglo_padre[2].battery,
					label: "Santander SmartBank iOS - Bater&iacute;a",
					bars: {
							show: true,
							barWidth: 0.2,
							align: "left"
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
						content : "<b>%s</b> : <span>%y Ah</span>",
						dateFormat : "%d-%m-%y %H:%M",
						defaultTheme : false
					},
					xaxis: {
						mode: "categories",
						tickLength: 0
					},
					grid: { hoverable: true, clickable: true }
				});
				*/


					var ds0 = new Array(); 
					ds0.push({
						data:arreglo_padre[0].battery,
						label: "Santander Mobile Android - Datos",						
						bars:{ 
						    show: true, 
							barWidth: 0.2, 
							order: 1, 
							//lineWidth : 2, 
							color : "#ff0000"
						 }});
					ds0.push({
						data:arreglo_padre[1].battery,
						label: "Santander SmartBank Android - Datos",
						bars: {
							show: true,
							barWidth: 0.2,
							order: 2,
							color : "#00ff00"
						 }});
						 

					
					ds0.push({
						data:arreglo_padre[2].battery,
					    label: "Santander SmartBank iOS - Datos",						
						bars: {
							show: true,
							barWidth: 0.2,
							order: 3,
							color : "#00ff00"
						 }});



					//Display graph
					$.plot($("#bar-bateria"), ds0, {
					  grid:{
					hoverable:true
					  },
					legend : true,
					tooltip : true,
					tooltipOpts : {
						content : "<b>%s</b> : <span>%y Ah</span>",
						dateFormat : "%d-%m-%y %H:%M",
						defaultTheme : false
					},					  
					  xaxis :{
					ticks: ticksdate
					  }
					});

				
				/*
				$.plot("#bar-datos", [{
					data: arreglo_padre[0].cellulard,
					label: "Santander Mobile Android - Datos",
					bars: {
							show: true,
							//order: 1,
							barWidth: 0.1,
							align: "left"
						}
					
				},{
					data: arreglo_padre[1].cellulard,
					label: "Santander SmartBank Android - Datos",
					bars: {
							show: true,
							//order: 2,
							barWidth: 0.1,
							align: "center"
						}
					
				},{
					data: arreglo_padre[2].cellulard,
					label: "Santander SmartBank iOS - Datos",
					bars: {
							show: true,
							//order:3,
							barWidth: 0.1,
							align: "right"
						}
					
				}], {
					series: {
						bars: {
							show: true,
							barWidth: 0.3,
							align: "center"
						}
					},
					legend : true,
					tooltip : true,
					tooltipOpts : {
						content : "<b>%s</b> : <span>%y MBytes</span>",
						dateFormat : "%d-%m-%y %H:%M",
						defaultTheme : false
					},
					xaxis: {
						mode: "categories",
						tickLength: 1
						//ticks: [[0, "Zone0"], [1, "Zone1"], [2, "Zone2"],[3, "Zone3"], [4, "Zone4"]]
					},
					grid: { hoverable: true, clickable: true }
				});				
				*/

				//$(function () {
		 
					var ds = new Array(); 
					ds.push({
						data:arreglo_padre[0].cellulard,
						label: "Santander Mobile Android - Datos",						
						bars:{ 
						    show: true, 
							barWidth: 0.2, 
							order: 1, 
							//lineWidth : 2, 
							color : "#ff0000"
						 }});
					ds.push({
						data:arreglo_padre[1].cellulard,
						label: "Santander SmartBank Android - Datos",
						bars: {
							show: true,
							barWidth: 0.2,
							order: 2,
							color : "#00ff00"
						 }});
						 

					
					ds.push({
						data:arreglo_padre[2].cellulard,
					    label: "Santander SmartBank iOS - Datos",						
						bars: {
							show: true,
							barWidth: 0.2,
							order: 3,
							color : "#00ff00"
						 }});



					//Display graph
					$.plot($("#bar-datos"), ds, {
					  grid:{
					hoverable:true
					  },
					legend : true,
					tooltip : true,
					tooltipOpts : {
						content : "<b>%s</b> : <span>%y MBytes</span>",
						dateFormat : "%d-%m-%y %H:%M",
						defaultTheme : false
					},					  
					  xaxis :{
					ticks: ticksdate
					  }
					});

				  //});				
				
				
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