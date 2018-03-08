
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
	include("inc/init.php");

	//require UI configuration (nav, ribbon, etc.)
	include("inc/config.ui.php");

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
					<h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-home"></i>VUN <span>> Vista General de Canal</span></h1>
				</div>
				<div class="col-xs-12 col-sm-7 col-md-7 col-lg-2">
					<div class='label bg-color-blueDark txt-color-white'><i class='fa fa-clock-o'></i> Ultima Actualizacion <?php print $objultimo->ultimo; ?></div>
				</div>

			</div>
			<div class="row">
					<div class="widget-body">
							<?php include "toptentest.php"; ?>
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
		include("jsfuncionestablas.php");
		include("jsmapas.php"); 
	?>

	<!-- PAGE RELATED PLUGIN(S) 
	<script src="..."></script>-->
	<!-- PAGE RELATED PLUGIN(S) -->
	<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/jquery.dataTables.min.js"></script>
	<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.colVis.min.js"></script>
	<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.tableTools.min.js"></script>
	<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
	<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>

	<!-- Vector Maps Plugin: Vectormap engine, Vectormap language -->
	<script src="<?php echo ASSETS_URL; ?>/js/plugin/vectormap/jquery-jvectormap-1.2.2.min.js"></script>
	<!--<script src="<?php echo ASSETS_URL; ?>/js/plugin/vectormap/jquery-jvectormap-world-mill-en.js"></script>-->
	<script src="<?php echo ASSETS_URL; ?>/js/plugin/vectormap/jquery-jvectormap-mexico-mill-en.js"></script>


	<script>
	$(document).ready(function() {

		/* TABLETOOOLS ;*/
			var responsiveHelper_datatable_tabletools = undefined;
			var responsiveHelper_dt_basic = undefined;

			var breakpointDefinition = {
				tablet : 1024,
				phone : 480
			};

		<?php print $cadenatabla; ?>	
		<?php print $cadenatablasondas; ?>
		<?php print $cadenatablaerrores; ?>
		/* END TABLETOOLS */

		/*
			VECTOR MAP
		*/
		<?php print $cadenamapas; ?>	


		
	})




	</script>

<?php 
	}else{
		header("Location: login.php");  
	}
?>