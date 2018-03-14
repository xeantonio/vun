<?php
	session_start();
	$serverName="192.168.4.21";
	$uid="sa";
	$pwd="tsoft";
	$connectionInfo = array( "UID"=>$uid,"PWD"=>$pwd,"Database"=>"vun_mexico");
	$conn = sqlsrv_connect( $serverName, $connectionInfo);
	if(isset($_REQUEST["logout"])){
		session_destroy();
	}


	if(isset($_REQUEST["email"]) && isset($_REQUEST["password"]) ){
	
		$qryusuario="select * from vunweb_Usuarios
					where vw_Contrasena='".md5($_REQUEST["password"])."'
							and vw_NombreUsuario='".$_REQUEST["email"]."'";
		$SqlIdUsuario=sqlsrv_query( $conn, $qryusuario,array(), array( "Scrollable" => 'static' ));
		if (sqlsrv_num_rows($SqlIdUsuario)>=1){
			$objusuario = sqlsrv_fetch_object($SqlIdUsuario);
			$_SESSION["nombrecompleto"] = $objusuario ->vw_NombreCompleto;
			$_SESSION["avatar"] = $objusuario ->vw_avatar;
			$_SESSION["canales"] = $objusuario ->vw_canales;
			$_SESSION["rol"] = $objusuario ->vw_rol;
			//if ($_SESSION["rol"]==1 || $_SESSION["rol"]==4 ){
			if ($_SESSION["rol"]==1 || $_SESSION["rol"]==4 ){				
				echo "<script>window.location='index.php'</script>";
			}elseif($_SESSION["rol"]==2){
				echo "<script>window.location='fundex1.php'</script>";
			}elseif($_SESSION["rol"]==3){
				echo "<script>window.location='fundex_tec1.php'</script>";
			}
			
		}else{
			$message=true;
		}
	}


//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

/*---------------- PHP Custom Scripts ---------

YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
E.G. $page_title = "Custom Title" */

$page_title = "Login";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
$no_main_header = true;
$page_html_prop = array("id"=>"extr-page", "class"=>"animated fadeInDown");
include("inc/header.php");

?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- possible classes: minified, no-right-panel, fixed-ribbon, fixed-header, fixed-width-->
<header id="header">
	<!--<span id="logo"></span>-->

	<div id="logo-group">
		<span id="logo"> <img src="<?php echo ASSETS_URL; ?>/img/logo.png" alt="SmartAdmin"> </span>

		<!-- END AJAX-DROPDOWN -->
	</div>

	<span id="extr-page-header-space"> 

</header>

<div id="main" role="main">

	<!-- MAIN CONTENT -->
	<div id="content" class="container">

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-7 col-lg-8 hidden-xs hidden-sm">
				<h1 class="txt-color-red login-header-big">Visor &Uacute;nico de Negocios</h1>
				<div class="hero">

					<div class="pull-left login-desc-box-l">
						<h4 class="paragraph-header">Por favor introduzca sus credenciales para acceder al visor</h4>
						
					</div>
					
					<img src="<?php echo ASSETS_URL; ?>/img/demo/sa-demo.png" class="pull-right display-image" alt="" style="width:210px">

				</div>

			</div>
			<div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">
				<div class="well no-padding">
					<form action="<?php echo APP_URL."/login.php"; ?>" id="login-form" class="smart-form client-form">
						<header>
							Autenticación
						</header>

						<fieldset>
							
							<section>
								<label class="label">Usuario</label>
								<label class="input"> <i class="icon-append fa fa-user"></i>
									<input type="email" name="email">
									<b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> Please enter username</b></label>
							</section>

							<section>
								<label class="label ">Contrase&ntilde;a</label>
								<label class="input"> <i class="icon-append fa fa-lock"></i>
									<input type="password" name="password">
									<b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> Enter your password</b> </label>
								
							</section>
							<?php 
								if(isset($message)){
							?>
							<section>
									<div class="alert alert-danger fade in">
										<button class="close" data-dismiss="alert">
											×
										</button>
										<i class="fa-fw fa fa-times"></i>
										<strong>Error!</strong> Usuario o Password incorrectos.
									</div>
							</section>
							<?php }?>
							
						</fieldset>
						<footer>
							<button type="submit" class="btn btn-primary">
								Acceder
							</button>
						</footer>
					</form>

				</div>

			</div>
		</div>
	</div>

</div>
<!-- END MAIN PANEL -->
<!-- ==========================CONTENT ENDS HERE ========================== -->

<?php 
	//include required scripts
	include("inc/scripts.php"); 
?>

<!-- PAGE RELATED PLUGIN(S) 
<script src="..."></script>-->

<script type="text/javascript">
	runAllForms();

	$(function() {
		// Validation
		$("#login-form").validate({
			// Rules for form validation
			rules : {
				email : {
					required : true,
					email : false
				},
				password : {
					required : false,
					minlength : 3,
					maxlength : 20
				}
			},

			// Messages for form validation
			messages : {
				email : {
					required : 'Please enter your email address',
					email : 'Please enter a VALID email address'
				},
				password : {
					required : 'Please enter your password'
				}
			},

			// Do not change code below
			errorPlacement : function(error, element) {
				error.insertAfter(element.parent());
			}
		});
	});
</script>

<?php 
	//include footer
	include("inc/google-analytics.php"); 
?>