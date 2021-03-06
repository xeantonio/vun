
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
						<h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-home"></i> VUN <span>> Top 10 Pa&iacute;s / Estado</span></h1>
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
							<div class="jarviswidget jarviswidget-color-darken" id="wid-id-1" data-widget-editbutton="true" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-collapsed="false" >
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
									<h2>Top 10</h2>
				
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
													<form id="form" class="smart-form" role="form">
														<div class="form-group">
															<!--
															<label class="sr-only" for="s123">Show From</label>
															<input type="email" class="form-control input-sm" id="s123" placeholder="Show From">
															-->
															<section class="col col-2">
																<label class="input"> <i class="icon-append fa fa-calendar"></i>
																	<input type="text" name="startdate" id="startdate" placeholder="Fecha Inicio">
																</label>
															</section>
														</div>
														<div class="form-group">
															<section class="col col-2">
																<label class="input"> <i class="icon-append fa fa-calendar"></i>
																	<input type="text" name="finishdate" id="finishdate" placeholder="Fecha Inicio">
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
																<label class="select">
																	<select name="paises" id="paises">
																		<option value="0" selected="" disabled="">[Paises]</option>
																		<option value="1">1</option>
																		<option value="2">2</option>
																		<option value="3">3</option>
																		<option value="4">4</option>
																		<option value="5">5</option>
																		<option value="6">6</option>
																		<option value="7">7</option>
																		<option value="8">8</option>
																		<option value="9">9</option>
																		<option value="10">10</option>
																		<option value="11">11</option>
																		<option value="12">12</option>
																		<option value="13">13</option>
																		<option value="14">14</option>
																		<option value="15">15</option>
																		<option value="16">16</option>
																		<option value="17">17</option>
																		<option value="18">18</option>
																		<option value="19">19</option>
																		<option value="20">20</option>
																		<option value="21">21</option>
																		<option value="22">22</option>
																		<option value="23">23</option>
																		<option value="24">24</option>
																		<option value="25">25</option>
																		<option value="26">26</option>
																		<option value="27">27</option>
																		<option value="28">28</option>
																		<option value="29">29</option>
																		<option value="30">30</option>
																		<option value="31">31</option>
																		<option value="32">32</option>
																		<option value="33">33</option>
																		<option value="34">34</option>
																		<option value="35">35</option>
																		<option value="36">36</option>
																		<option value="37">37</option>
																		<option value="38">38</option>
																		<option value="39">39</option>
																		<option value="40">40</option>
																		<option value="41">41</option>
																		<option value="42">42</option>
																		<option value="43">43</option>
																		<option value="44">44</option>
																		<option value="45">45</option>
																		<option value="46">46</option>
																		<option value="47">47</option>
																		<option value="48">48</option>
																		<option value="49">49</option>
																		<option value="50">50</option>																			
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
												<div>
												<h4 id="titulo"class="alert alert-info"></h4>	
												<!--
												<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
												
												</table>
												-->
												
												
												<table id="dt_basic" ></table>
												<div id="paginador"></div>
												<button  class="btn btn-primary" id="export">Exportar a Excel</button>	
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
		<script src="js/plugin/datatables/FixedColumns.js"></script>
		
		<script src="js/plugin/jqgrid/jquery.jqGrid.js"></script>
		<script src="js/plugin/jqgrid/grid.locale-en.min.js"></script>
	    <script type="text/javascript" language="javascript" src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>					

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
							url: "apppulse_top10.php",
						})
						 .done(function( data, textStatus, jqXHR ) {
							 //console.log("Tabla mis datos:",data);
							 //console.log(data[0].data);
							 $("#titulo").text(appName);
							 var table = $('#dt_basic').DataTable();
							 table.clear().draw();
							 table.rows.add(data[0].data).draw();							 
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
							return data + '  <i class="fa fa-circle txt-color-red"></i>'
						}
						else if(data>50 && data <=85){
							return data + '  <i class="fa fa-circle txt-color-yellow"></i>'
						}
						else{
							return data + '  <i class="fa fa-circle txt-color-green"></i>'
						}
						//console.log(data);
						
						//return data;
					};
					
					//getTable("2017-04-01","2017-05-01","-1","");	
					
					//http://jsfiddle.net/q8Qdb/341/
					
					/*
					
				   var oTable = $('#dt_basic').dataTable({
						"bFilter": false,
						"data": [],
							"columns": [{
								"title": "Fecha y Hora",
								'data': 'timestamp'
							}, 
							{
								"title": "Pais",
								'data': 'countryCode'//,
								// 'render': statusIcon
							},
							{
								"title": "Sesiones",
								'data': 'totalLaunches',
								'render': statusIcon
							} 							
						]
					
					});	
					
					*/
				
					//http://www.guriddo.net/demo/guriddojs/loading_data/json_web/index.html


			
					
					

					$("#dt_basic").jqGrid({
						colModel: [
							{
								label: 'Fecha',
								name: 'timestamp',
								width: 150
								//formatter: formatTitle
							},
							{
								label: 'Pais',
								name: 'pais',
								width: 80,
								formatter: myformatter
							},
							{
								label: 'Launches',
								name: 'launches',
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
							groupCollapse: false,
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

					function myformatter(cellvalue, options, rowObject ){
						//console.log("myformatter",cellvalue, options, rowObject );
						return rowObject.pais;
					}					

					$("#dt_basic").jqGrid('filterToolbar',
									   {
					  autosearch: true,
					  stringResult: true,
					  searchOnEnter: true,
					  defaultSearch: "cn",
					  
					  
					});					
					
					//fetchGridData(startdate,finishdate,appID, appName);

					
					
					function fetchGridData(startdate,finishdate,appID, appName, paises) {
						
						var gridArrayData = [];
						// show loading message
						$("#titulo").text(appName);
						$("#dt_basic")[0].grid.beginReq();
						$.ajax({
							url: "apppulse_top10.php?startdate=" + startdate + "&finishdate=" + finishdate + "&appID=" + appID + "&paises=" + paises,
							success: function (result) {
								//console.log("successss!!");
								//console.log("result:",result[0].data);
								gridArrayData = [];
								for (var i = 0; i < result[0].data.length; i++) {
									var item = result[0].data[i];
									gridArrayData.push({
										timestamp: item.timestamp,
										pais: item.countryCode,
										launches: item.totalLaunches
									});                            
								}
								// set the new data
								$("#dt_basic").jqGrid('clearGridData');
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
					
					
					$("#form").submit(function( event ) {
					  event.preventDefault();
					  var startdate = $("input[name=startdate]").val();
					  var finishdate = $("input[name=finishdate]").val();
					  var appID = $("select[name=applicationID]").val();
					  var appName = $("#applicationID option:selected").text();
					  var paises = $("select[name=paises]").val();;
					  //console.log("app:", $("#applicationID_form2 option:selected").text());
					  
					  var series = [];
					 //http://jsfiddle.net/larsenmtl/zCuQ5/1/
 					  //getTable(startdate, finishdate, appID, appName);
					  fetchGridData(startdate, finishdate, appID, appName, paises);
					  
					});					



				$("#export").on("click", function(){
					$("#dt_basic").jqGrid("exportToExcel",{
						includeLabels : true,
						includeGroupHeader : true,
						includeFooter: true,
						fileName : "top_10.xlsx",
						maxlength : 40 // maxlength for visible string data 
					})
				})			
								
	
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
	
			//getDatos(ayer_str,hoy_str, '-1', "");
			//getTable(ayer_str,hoy_str,'d56e9149845747158bd778736c096366',"Santander SmartBank iOS");
			fetchGridData(ayer_str,hoy_str,'d56e9149845747158bd778736c096366',"Santander SmartBank iOS", 10);
			//getBars(ayer_str,hoy_str, 'd56e9149845747158bd778736c096366',"Santander SmartBank iOS");
			
			/* bar chart */
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