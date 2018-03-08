		<!-- Left panel : Navigation area -->
		<!-- Note: This width of the aside area can be adjusted through LESS variables -->
		<aside id="left-panel">
			<span class="minifyme" data-action="minifyMenu"> <i class="fa fa-arrow-circle-left hit"></i> </span>

			<!-- User info -->
			<div class="login-info">
				<span> <!-- User image size is adjusted inside CSS, it should stay as is --> 
					
					<a href="#">
						<img src="<?php echo ASSETS_URL; ?>/img/avatars/<?php print $_SESSION["avatar"]; ?> " alt="me" class="online" /> 
						<span class="font-sm">
							<?php print $_SESSION["nombrecompleto"];?> 
						</span>
						
					</a> 
					
				</span>
			</div>
			
			<!-- end user info -->

			<!-- NAVIGATION : This navigation is also responsive

			To make this navigation dynamic please make sure to link the node
			(the reference to the nav > ul) after page load. Or the navigation
			will not initialize.
			-->
			<nav>

				<!-- NOTE: Notice the gaps after each icon usage <i></i>..
				Please note that these links work a bit different than
				traditional hre="" links. See documentation for details.
				-->
				<?php
					$ui = new SmartUI();
					$ui->create_nav($page_nav)->print_html();
				?>

			</nav>		
		</aside>
		<!-- END NAVIGATION -->