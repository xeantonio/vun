
<?php
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

	/* ---------------- END PHP Custom Scripts ------------- */

	//include header
	//you can add your custom css in $page_css array.
	//Note: all css files are inside css/ folder
	$page_css[] = "your_style.css";
	include("inc/header.php");

	//include left panel (navigation)
	//follow the tree in inc/config.ui.php
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
					<h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-home"></i>VUN <span>> Fundex </span></h1>
				</div>
				<div class="col-xs-12 col-sm-7 col-md-7 col-lg-2">
					<div class='label bg-color-blueDark txt-color-white'><i class='fa fa-clock-o'></i><?php include "ultimo.php"; ?>Ultima Actualizacion <?php print $objultimo->ultimo; ?></div>
				</div>

			</div>
			
			<!-- MAIN CONTENT -->
			<div id="content">

				<!-- widget grid -->
				<section id="widget-grid" class="">

					<!-- row -->
					<div class="row">
						<article class="col-sm-12">
							<!-- new widget -->
							<div class="jarviswidget" id="wid-id-0" data-widget-togglebutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
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
									<span class="widget-icon"> <i class="glyphicon glyphicon-stats txt-color-darken"></i> </span>
									<h2>Fundex Tiempo Real </h2>
								</header>

								<!-- widget div-->
								<div class="no-padding">
									<!-- widget edit box -->
									<div class="jarviswidget-editbox">

										test
									</div>
									<!-- end widget edit box -->
									<div class="widget-body">
										<!-- content -->
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
												<br>
												
												<h4 id="titulo1" class="bg-color-darken txt-color-white"></h4>												
												
												<div class="no-padding col-xs-1"></div>
												<div class="no-padding col-xs-10">
													<div id="statsChart" class="chart-large has-legend-unique"></div>
												</div>
												
												<div id="legend-container">
												</div>


										<!-- end content -->
									</div>

								</div>
								<!-- end widget div -->
							</div>
							<!-- end widget -->

						</article>
					</div>
					<!-- end row -->


					
					<!-- row -->
					<div class="row">
				
						<!-- NEW WIDGET START -->
						<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				
							<!-- Widget ID (each widget will need unique ID)-->
							<div class="jarviswidget jarviswidget-color-darken" id="wid-id-1" data-widget-editbutton="false" data-widget-colorbutton="false">
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
									<span class="widget-icon"> <i class="fa fa-table"></i> </span>
									<h2>Fundex</h2>
				
								</header>
				
								<!-- widget div-->
								<div>
				
									<!-- widget edit box -->
									<div class="jarviswidget-editbox">
										<!-- This area used as dropdown edit box -->
				
									</div>
									<!-- end widget edit box -->
				
									<!-- widget content -->
									<div class="widget-body no-padding">
									
												<div class="widget-body-toolbar bg-color-white">
													<form id="form2" class="smart-form" role="form">
														<div class="form-group">
															<!--
															<label class="sr-only" for="s123">Show From</label>
															<input type="email" class="form-control input-sm" id="s123" placeholder="Show From">
															-->
															<section class="col col-3">
																<label class="input"> <i class="icon-append fa fa-calendar"></i>
																	<input type="text" name="startdate_form2" id="startdate_form2" placeholder="Fecha Inicio">
																</label>
															</section>
														</div>
														<div class="form-group">
															<section class="col col-3">
																<label class="input"> <i class="icon-append fa fa-calendar"></i>
																	<input type="text" name="finishdate_form2" id="finishdate_form2" placeholder="Fecha Inicio">
																</label>
															</section>
														</div>
														<div class="form-group">
															<section class="col col-3">
																<label class="select">
																	<select name="applicationID_form2" id="applicationID_form2">
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
												<br>
												<div id="dt_basic_wrapper">
													<h5 id="titulo_dt_basic" class="bg-color-darken txt-color-white"></h5>	
													<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
													</table>
												</div>
												
												<div id="dt_basic2_wrapper">
													<h5 id="titulo_dt_basic2" class="bg-color-darken txt-color-white"></h5>	
													<table id="dt_basic2" class="table table-striped table-bordered table-hover" width="100%">
													</table>
												</div>												

												<div id="dt_basic3_wrapper">
													<h5 id="titulo_dt_basic3" class="bg-color-darken txt-color-white"></h5>	
													<table id="dt_basic3" class="table table-striped table-bordered table-hover" width="100%">
													</table>
												</div>	
												
												
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
								<header>
									<span class="widget-icon"> <i class="fa fa-bar-chart-o"></i> </span>
									<h2>MEJORA TU FUNDEX (IMPROVE YOUR FUNDEX)</h2>

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
										<form id="form3" class="smart-form" role="form">
											<div class="form-group">
												<!--
												<label class="sr-only" for="s123">Show From</label>
												<input type="email" class="form-control input-sm" id="s123" placeholder="Show From">
												-->
											
												<section class="col col-3">
													<label class="input"> <i class="icon-append fa fa-calendar"></i>
														<input type="text" name="startdate_form3" id="startdate_form3" placeholder="Fecha Inicio">
													</label>
												</section>															
																		
											</div>
											<div class="form-group">
												<section class="col col-3">
													<label class="input"> <i class="icon-append fa fa-calendar"></i>
														<input type="text" name="finishdate_form3" id="finishdate_form3" placeholder="Fecha Fin">
													</label>
												</section>
											</div>
											<div class="form-group">
												<section class="col col-3">
													<label class="select">
														<select name="applicationID_form3" id="applicationID_form3">
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
									
										<div id="improve_wrapper1">
											<br>
											<h4 id="titulo_improve1" class="bg-color-darken txt-color-white">  </h4>
											
											<h6 class="bg-color-darken txt-color-white padding-10"><strong>PERFORMANCE</strong></h6>
											<div id="bar-performance_improve1" class="chart"></div>
											<br>
											<h6 class="bg-color-darken txt-color-white padding-10"><strong>RECURSOS</strong></h6>
											<div id="bar-chart2_improve1" class="chart"></div>
											<br>
											<h6 class="bg-color-darken txt-color-white padding-10"><strong>ESTABILIDAD</strong></h6>
											<div id="bar-chart3_improve1" class="chart"></div>
										</div>

										
										
										<div id="improve_wrapper2">
											<br>
											<h4 id="titulo_improve2" class="bg-color-darken txt-color-white">  </h4>
											
											<h6 class="bg-color-darken txt-color-white padding-10"><strong>PERFORMANCE</strong></h6>
											<div id="bar-performance_improve2" class="chart"></div>
											<br>
											<h6 class="bg-color-darken txt-color-white padding-10"><strong>RECURSOS</strong></h6>
											<div id="bar-chart2_improve2" class="chart"></div>
											<br>
											<h6 class="bg-color-darken txt-color-white padding-10"><strong>ESTABILIDAD</strong></h6>
											<div id="bar-chart3_improve2" class="chart"></div>
										</div>										


										<div id="improve_wrapper3">
											<br>
											<h4 id="titulo_improve3" class="bg-color-darken txt-color-white">  </h4>
											
											<h6 class="bg-color-darken txt-color-white padding-10"><strong>PERFORMANCE</strong></h6>
											<div id="bar-performance_improve3" class="chart"></div>
											<br>
											<h6 class="bg-color-darken txt-color-white padding-10"><strong>RECURSOS</strong></h6>
											<div id="bar-chart2_improve3" class="chart"></div>
											<br>
											<h6 class="bg-color-darken txt-color-white padding-10"><strong>ESTABILIDAD</strong></h6>
											<div id="bar-chart3_improve3" class="chart"></div>
										</div>



										
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
				pageSetUp();

				
				/* BASIC ;*/
					var responsiveHelper_dt_basic = undefined;
					var responsiveHelper_datatable_fixed_column = undefined;
					var responsiveHelper_datatable_col_reorder = undefined;
					var responsiveHelper_datatable_tabletools = undefined;
					
					var breakpointDefinition = {
						tablet : 1024,
						phone : 480
					};
					
					function getTable(startdate,finishdate,appID, appName){
						
						$.ajax({
							data: {"startdate" : startdate, "finishdate" :finishdate, "appID" : appID},
							type: "GET",
							dataType: "json",
							url: "apppulse_fundex_table.php",
						})
						 .done(function( data, textStatus, jqXHR ) {
							 //console.log("Tabla mis datos:",data);
							 console.log("appName:", appName);
							 //console.log("data:",data);

							 //console.log(data[0]);
							 //console.log(data[1]);
							 //console.log(data[2]);
							 if(typeof data[0] !== 'undefined'){
								 
								 if(appId = '-1' && appName!="[Todas]"){
									 etiqueta = appName;
								 }else{
								 	var etiqueta = data[0].label;
								 }
								 $("#titulo_dt_basic").text(etiqueta);
								 $("#dt_basic_wrapper").show();
								 var table = $('#dt_basic').DataTable();
								 table.clear().draw();
								 table.rows.add(data[0].data).draw();									 
							 }
							 else{
								 $("#dt_basic_wrapper").hide();
							 }
						 

							 if(typeof data[1] !== 'undefined'){
								 $("#titulo_dt_basic2").text(data[1].label);
								 $("#dt_basic2_wrapper").show();
								 var table = $('#dt_basic2').DataTable();
								 table.clear().draw();
								 table.rows.add(data[1].data).draw();									 
							 }
							 else{
								 $("#dt_basic2_wrapper").hide();								 
								 
							 }
						 
							 if(typeof data[2] !== 'undefined'){
								 $("#titulo_dt_basic3").text(data[2].label);
								 $("#dt_basic3_wrapper").show();
								 var table = $('#dt_basic3').DataTable();
								 table.clear().draw();
								 table.rows.add(data[2].data).draw();									 
							 }
							 else{
								 $("#dt_basic3_wrapper").hide();
							 }
						 
						 

						 })
						 .fail(function( jqXHR, textStatus, errorThrown ) {
							 if ( console && console.log ) {
								 console.log( "La solicitud a fallado: " +  textStatus);
							 }
						});

					}					

					var statusIcon = function ( data, type, row ) {
						/*
						if ( type === 'display' ) {
							return data + ' <i class="fa fa-pencil"/>';
						}
						*/
						if(data<=50){
							return ' <i class="fa fa-circle txt-color-red"></i>'
						}
						else if(data>50 && data <=85){
							return  '<i class="fa fa-circle txt-color-yellow"></i>'
						}
						else{
							return '<i class="fa fa-circle txt-color-green"></i>'
						}
						//console.log(data);
						
						//return data;
					};
					
					//getTable("2017-04-01","2017-05-01","-1","");	
					
					//http://jsfiddle.net/q8Qdb/341/
					
					
					
				   $('#dt_basic').dataTable({
						"bFilter": false,
						"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'T>r>"+
								"t"+
								"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",						
						"oTableTools": {
							 "aButtons": [
							 "xls"
							 ],
							"sSwfPath": "js/plugin/datatables/swf/copy_csv_xls_pdf.swf"
						},						
						"data": [],
							"columns": [{
								"title": "Fecha y Hora",
								'data': 'timestamp'
							}, 
							{
								"title": "Fundex Global",
								'data': 'fundex'//,
								 //'render': statusIcon
							},
							{
								"title": "Fundex Perdido",
								'data': 'perdido'//,
								//'render': statusIcon
							},
							{
								"title": "Status",
								'data': 'fundex',
								'render': statusIcon
							}  							
						]
					});					


				   $('#dt_basic2').dataTable({
						"bFilter": false,
						"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'T>r>"+
								"t"+
								"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",						
						"oTableTools": {
							 "aButtons": [
							 "xls"
							 ],
							"sSwfPath": "js/plugin/datatables/swf/copy_csv_xls_pdf.swf"
						},					
						"data": [],
							"columns": [{
								"title": "Fecha y Hora",
								'data': 'timestamp'
							}, 
							{
								"title": "Fundex Global",
								'data': 'fundex'//,
								 //'render': statusIcon
							},
							{
								"title": "Fundex Perdido",
								'data': 'perdido'//,
								//'render': statusIcon
							},
							{
								"title": "Status",
								'data': 'fundex',
								'render': statusIcon
							}  							
						]
					});					

					
				   $('#dt_basic3').dataTable({
						"bFilter": false,
						"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'T>r>"+
								"t"+
								"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",						
						"oTableTools": {
							 "aButtons": [
							 "xls"
							 ],
							"sSwfPath": "js/plugin/datatables/swf/copy_csv_xls_pdf.swf"
						},						
						"data": [],
							"columns": [{
								"title": "Fecha y Hora",
								'data': 'timestamp'
							}, 
							{
								"title": "Fundex Global",
								'data': 'fundex'//,
								 //'render': statusIcon
							},
							{
								"title": "Fundex Perdido",
								'data': 'perdido'//,
								//'render': statusIcon
							},
							{
								"title": "Status",
								'data': 'fundex',
								'render': statusIcon
							}  							
						]
					});					
					
					
					
					
					$("#form2").submit(function( event ) {
					  event.preventDefault();
					  var startdate = $("input[name=startdate_form2]").val();
					  var finishdate = $("input[name=finishdate_form2]").val();
					  var appID = $("select[name=applicationID_form2]").val();
					  var appName = $("#applicationID_form2 option:selected").text();
					  //console.log("app:", $("#applicationID_form2 option:selected").text());
					  
					  var series = [];
					 //http://jsfiddle.net/larsenmtl/zCuQ5/1/
					
					getTable(startdate, finishdate, appID, appName);
					  
					});					
					
			var errorClass = 'invalid';
			var errorElement = 'em';		
	
			function getDatos(startdate,finishdate,appID, appName){
				
				$.ajax({
					data: {"startdate" : startdate, "finishdate" :finishdate, "appID" : appID},
					type: "GET",
					dataType: "json",
					url: "apppulse_fundex_chart.php",
				})
				.done(function( data, textStatus, jqXHR ) {
					//console.log("mis datos:",data);
					if(data.length > 1){
						var series = [];
						for(i=0;i<data.length;i++){
							//series.push(data[i].data);
							series.push({"data":data[i].data,"label":data[i].label});
						}
						$("#titulo1").text("Todos los servicios");
						onDataReceived(series);					 
					}
					else{
						$("#titulo1").text(appName);
						onDataReceived([{"data":data[0].data,"label": appName}]);
					}
	
				})
				.fail(function( jqXHR, textStatus, errorThrown ) {
					if ( console && console.log ) {
						console.log( "La solicitud a fallado: " +  textStatus);
					}
				});
	
			}
			
			function onDataReceived(series) {
			
				data = [ series ];
				var datitos = [];
				
				arreglo_padre = []
				for(i=0;i<series.length;i++){
					var aux = series[i].data;
					var arreglo = [];
					for(j=0;j<aux.length;j++){
						arreglo.push([aux[j].ts,aux[j].fundex]);
					}
					arreglo_padre.push({"data":arreglo,"label":series[i].label});
				}
				
				//console.log("arreglillo:", arreglo_padre);
	
				var options = {
					lines: {
						show: true
					},
					grid : {
						hoverable : true
					},
					//colors : ["#568A89", "#3276B1"],
					tooltip : true,
					legend: { 
						show :true,
						container: $('#legend-container')
					},
				
					tooltipOpts : {
						content : "%s </br>Hora: <b>%x</b></br>Valor: <span>%y</span>",
						//xDateFormat : "%d/%m/%y %H:%M",
						dateFormat : "%d-%m-%y %H:%M",
						defaultTheme : false
					},
					
	
					xaxis: { 
						mode: "time", 
						timeformat: "%d/%m/%y %H:%M",
						ticksize: [1, 'hour'],
						timezone : "browser"
					}
				};
	
				//console.log("data:",arreglo_padre);
				$.plot($("#statsChart"), arreglo_padre, options);
				
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
			
			
			$('#startdate_form2').datepicker({
				dateFormat : 'yy-mm-dd',
				prevText : '<i class="fa fa-chevron-left"></i>',
				nextText : '<i class="fa fa-chevron-right"></i>',
				onSelect : function(selectedDate) {
					$('#finishdate_form2').datepicker('option', 'minDate', selectedDate);
				}
			});
			
			$('#startdate_form3').datepicker({
				dateFormat : 'yy-mm-dd',
				prevText : '<i class="fa fa-chevron-left"></i>',
				nextText : '<i class="fa fa-chevron-right"></i>',
				onSelect : function(selectedDate) {
					$('#finishdate_form3').datepicker('option', 'minDate', selectedDate);
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
			
			$('#finishdate_form2').datepicker({
				dateFormat : 'yy-mm-dd',
				prevText : '<i class="fa fa-chevron-left"></i>',
				nextText : '<i class="fa fa-chevron-right"></i>',
				onSelect : function(selectedDate) {
					$('#startdate_form2').datepicker('option', 'maxDate', selectedDate);
				}
			});

			$('#finishdate_form3').datepicker({
				dateFormat : 'yy-mm-dd',
				prevText : '<i class="fa fa-chevron-left"></i>',
				nextText : '<i class="fa fa-chevron-right"></i>',
				onSelect : function(selectedDate) {
					$('#startdate_form3').datepicker('option', 'maxDate', selectedDate);
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
			
			getDatos(startdate, finishdate, appID, appName);
			
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
			
			today.setDate(dd - 1);		
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
			
			
			/* bar chart */
		
	
			getDatos(ayer_str,hoy_str, '-1', "");
			getTable(ayer_str,hoy_str,'d56e9149845747158bd778736c096366',"Santander SmartBank iOS");
			getBars(ayer_str,hoy_str, 'd56e9149845747158bd778736c096366',"Santander SmartBank iOS");
			
			//$("improve_wrapper1").hide();
			$("#improve_wrapper2").hide();
			//$("improve_wrapper3").hide();	
			
			
			function getBars(startdate,finishdate,appID, appName){
				
				$.ajax({
					data: {"startdate" : startdate, "finishdate" :finishdate, "appID" : appID},
					type: "GET",
					dataType: "json",
					url: "apppulse_fundex_bars.php",
				})
				.done(function( data, textStatus, jqXHR ) {
					console.log("mis datos:",data);
					if(data.length > 1){
						var series = [];
						for(i=0;i<data.length;i++){
							//series.push(data[i].data);
							series.push({"data":data[i].data,"label":data[i].label});
						}
						$("#improve_wrapper2").show();
						$("#improve_wrapper3").show();						
						
						$("#titulo_improve1").text(data[0].label);
						onDataReceivedBars(series, "improve1");

						$("#titulo_improve2").text(data[1].label);
						onDataReceivedBars(series, "improve2");	
						
						$("#titulo_improve3").text(data[2].label);
						onDataReceivedBars(series, "improve3");							
						
						
					}
					else{
						$("#improve_wrapper2").hide();
						$("#improve_wrapper3").hide();
						$("#titulo_improve1").text(appName);
						onDataReceivedBars([{"data":data[0].data,"label": appName}], "improve1");
					}
	
				})
				.fail(function( jqXHR, textStatus, errorThrown ) {
					if ( console && console.log ) {
						console.log( "La solicitud a fallado: " +  textStatus);
					}
				});
	
			}


			function onDataReceivedBars(series, label) {
			
				data = [ series ];
				var datitos = [];
				console.log("label:", label);
				console.log("Series Bar:", series);
				
				arreglo_padre = []
				//for(i=0;i<series.length;i++){
					var aux = series[0].data;
					var arreglo = [];
					var fundex = [];
					var actionPenalty = [];
					var launchPenalty = [];
					
					var batteryPenalty = [];
					var networkPenalty = [];
					
					var crashPenalty = [];
					var errorsPenalty = [];

					
					for(j=0;j<aux.length;j++){
						arreglo.push([aux[j].timestamp,aux[j].fundex]);
						fundex.push([aux[j].timestamp,aux[j].fundex]);
						actionPenalty.push([aux[j].timestamp,aux[j].actionPenalty]);
						launchPenalty.push([aux[j].timestamp,aux[j].launchPenalty]);
						
						batteryPenalty.push([aux[j].timestamp,aux[j].batteryPenalty]);
						networkPenalty.push([aux[j].timestamp,aux[j].networkPenalty]);
						
						crashPenalty.push([aux[j].timestamp,aux[j].crashPenalty]);
						errorsPenalty.push([aux[j].timestamp,aux[j].errorsPenalty]);						
					}
					//arreglo_padre.push({"data":arreglo,"label":series[i].label});
				//}
				
				
	
				// ver esto : http://jsfiddle.net/mihaisdm/sxuJe/

				$.plot("#bar-performance_" + label, [{
					data: actionPenalty,
					label: "actionPenalty",
					bars: {
							show: true,
							barWidth: 0.4,
							align: "left"
						}
					
				}, {
					data: launchPenalty,
					label: "launchPenalty",
					bars: {
							show: true,
							barWidth: 0.4,
							align: "right"
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
						content : "<b>%s</b> = <span>%y</span>",
						dateFormat : "%d-%m-%y %H:%M",
						defaultTheme : false
					},
					xaxis: {
						mode: "categories",
						tickLength: 0
					},
					grid: { hoverable: true, clickable: true }
				});


				$.plot("#bar-chart2_" + label, [{
					data: batteryPenalty,
					label: "batteryPenalty",
					bars: {
							show: true,
							barWidth: 0.4,
							align: "left"
						}
					
				}, {
					data: networkPenalty,
					label: "networkPenalty",
					bars: {
							show: true,
							barWidth: 0.4,
							align: "right"
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
						content : "<b>%s</b> = <span>%y</span>",
						dateFormat : "%d-%m-%y %H:%M",
						defaultTheme : false
					},
					xaxis: {
						mode: "categories",
						tickLength: 0
					},
					grid: { hoverable: true, clickable: true }
				});				


				$.plot("#bar-chart3_" + label, [{
					data: crashPenalty,
					label: "crashPenalty",
					bars: {
							show: true,
							barWidth: 0.4,
							align: "left"
						}
					
				}, {
					data: errorsPenalty,
					label: "errorsPenalty",
					bars: {
							show: true,
							barWidth: 0.4,
							align: "right"
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
						content : "<b>%s</b> = <span>%y</span>",
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


			$("#form3").submit(function( event ) {
			event.preventDefault();
			var startdate = $("input[name=startdate_form3]").val();
			var finishdate = $("input[name=finishdate_form3]").val();
			var appID = $("select[name=applicationID_form3]").val();
			var appName = $("#applicationID_form3 option:selected").text();
			console.log("-----------------form3-------------------");
			console.log("startdate:", startdate);
			console.log("finishdate:", finishdate);
			console.log("appID:", appID);
			console.log("appName:", appName);
			
			var series = [];
	
			
			//http://jsfiddle.net/larsenmtl/zCuQ5/1/
			
			//getDatos(startdate, finishdate, appID, appName);
			getBars(startdate,finishdate, appID, appName);
			
			});
			
			//getBars(ayer_str,hoy_str, 'd56e9149845747158bd778736c096366', "");
			
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