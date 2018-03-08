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
	include("inc/nav.php");

?>

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
						<h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-home"></i> VUN <span>> Reporte App Pulse</span></h1>
					</div>
					<div class="col-xs-12 col-sm-7 col-md-7 col-lg-2">
					<div class='label bg-color-blueDark txt-color-white'><i class='fa fa-clock-o'></i><?php include "ultimo.php"; ?>Ultima Actualizacion <?php print $objultimo->ultimo; ?></div>
				</div>
		</div>

<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">


<?php

$dir = "Reportes/";

// Open a directory, and read its contents

if (is_dir($dir)){
  if ($dh = opendir($dir)){
	$arr = array();
	$primero = "";
    while (($file = readdir($dh)) !== false){
	  
	  if(pathinfo($dir. $file, PATHINFO_EXTENSION) == 'pdf'){
		   $archivo =  pathinfo($dir. $file, PATHINFO_FILENAME);
		   $porciones = explode("-", $archivo);
		   $fecha =  $porciones[0] .'-'.$porciones[1] .'-'. $porciones[2].'-'. $porciones[3];
		   #$fecha =  $porciones[0] .'-'.$porciones[1] .'-'. $porciones[2];
		   $tipo =  $porciones[4]. '-'. $porciones[5];
		   $tipo = rtrim($tipo,"-");
		   array_push($arr,array('fecha' => $fecha, 'tipo' => $tipo));

	  }

    }

	$array_tipos = array("NEGOCIO-IOS","NEGOCIO-ANDROID","NEGOCIO-MOBILE","TECNOLOGIA-IOS","TECNOLOGIA-ANDROID","TECNOLOGIA-MOBILE","CRASHES-IOS","CRASHES-ANDROID","CRASHES-MOBILE","COMPARATIVO");


	echo '<thead>';
	echo '<tr>';
	echo '<th width="9%">Hora</th>';
	foreach($array_tipos as $i){
		echo '<th>'.$i.'</th>';
	}
	echo '</tr>';
	echo '</thead>';
	

	
	
	
	
	
	echo '<tbody>';

	$grouped = array();
	$end = false;
	foreach($arr as $element) {
		$array_aux = array();
		//echo '-->'.$element['fecha']. '<br>';
		//echo '<td>';
		if(!array_key_exists($element['fecha'], $grouped)){
			//echo '<br>'.$element['fecha'].'//'.$element['tipo'];
			$grouped[$element['fecha']] = $element['fecha'];
		}
	}
	
	foreach($grouped as $item) {

		echo '<tr>';
		$fecha_trimed = explode("-", $item);
		echo '<td>'.$fecha_trimed[0].'-'.$fecha_trimed[1].'-'.$fecha_trimed[2].'</td>';	
		$array2 = array("<td></td>","<td></td>","<td></td>","<td></td>","<td></td>","<td></td>","<td></td>","<td></td>","<td></td>","<td></td>");
	
		foreach ($arr as $key => $val) {
			//echo '<td>';
			if($val['fecha'] == $item){
				$pos = array_search($val['tipo'], $array_tipos);
				//$array2[$pos] = '<td>'.$val['tipo'].'</td>';
				$array2[$pos] = '<td align="center"><a href=Reportes/'.$val['fecha'].'-'.$val['tipo'].'.pdf><img src="img/pdf-icon.png" height="40px"></a></td>';

			}
			
		}
		echo join('', $array2);
		echo '</tr>';
		
	}	

	echo '</tbody>';
	echo '</table>';

    closedir($dh);
  }
}
?>
</div>
		<!-- END MAIN PANEL -->

		<!-- PAGE FOOTER -->
		<div class="page-footer">
			<div class="row">
				<div class="col-xs-12 col-sm-6">
					<span class="txt-color-white">SmartAdmin 1.8.2 <span class="hidden-xs"> - Web Application Framework</span> © 2014-2015</span>
				</div>
			</div>
		</div>
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
		

		
		<!-- Full Calendar -->
		<script src="js/plugin/moment/moment.min.js"></script>
		<script src="js/plugin/fullcalendar/jquery.fullcalendar.min.js"></script>
		
		
		<!-- PAGE RELATED PLUGIN(S) -->
		<script src="js/plugin/datatables/jquery.dataTables.min.js"></script>
		<script src="js/plugin/datatables/dataTables.colVis.min.js"></script>
		<script src="js/plugin/datatables/dataTables.tableTools.min.js"></script>
		<script src="js/plugin/datatables/dataTables.bootstrap.min.js"></script>
		<script src="js/plugin/datatable-responsive/datatables.responsive.min.js"></script>
		

		
		<script type="text/javascript">
		
		// DO NOT REMOVE : GLOBAL FUNCTIONS!
		
		$(document).ready(function() {
			
			pageSetUp();
			
			/* // DOM Position key index //
		
			l - Length changing (dropdown)
			f - Filtering input (search)
			t - The Table! (datatable)
			i - Information (records)
			p - Pagination (paging)
			r - pRocessing 
			< and > - div elements
			<"#id" and > - div with an id
			<"class" and > - div with a class
			<"#id.class" and > - div with an id and class
			
			Also see: http://legacy.datatables.net/usage/features
			*/	
	
			/* BASIC ;*/
				var responsiveHelper_dt_basic = undefined;
				var responsiveHelper_datatable_fixed_column = undefined;
				var responsiveHelper_datatable_col_reorder = undefined;
				var responsiveHelper_datatable_tabletools = undefined;
				
				var breakpointDefinition = {
					tablet : 1024,
					phone : 480
				};
	
				$('#dt_basic').dataTable({
					/*
					"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
						"t"+
						"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
					*/
					"autoWidth" : true,
					/*
			        "oLanguage": {
					    "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
					},
					*/
					"aaSorting": [[ 0, "desc" ]],
					"bFilter": false,
					"preDrawCallback" : function() {
						// Initialize the responsive datatables helper once.
						if (!responsiveHelper_dt_basic) {
							responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic'), breakpointDefinition);
						}
					},
					"rowCallback" : function(nRow) {
						responsiveHelper_dt_basic.createExpandIcon(nRow);
					},
					"drawCallback" : function(oSettings) {
						responsiveHelper_dt_basic.respond();
					}
				});
	
	
			})
			/* END BASIC */
			</script>

	</body>

</html>

<?php 
	}else{
		header("Location: login.php");  
	}
?>