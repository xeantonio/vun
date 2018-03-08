<?php
$cadenatablasondas="";
$cadenatabla="";
$cadenatablaerrores="";
for ($iniciocadena=0;$iniciocadena<=$i-1;$iniciocadena++){
	$cadenatabla.="
			$('#datatable_tabletools".$iniciocadena."').dataTable({
					
					// Tabletools options: 
					//   https://datatables.net/extensions/tabletools/button_options
					\"sDom\": \"<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'T>r>\"+
							\"t\"+
							\"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>\",
			        \"oTableTools\": {
			        	 \"aButtons\": [
			             \"copy\",
			             \"csv\",
			             \"xls\",
			                {
			                    \"sExtends\": \"pdf\",
			                    \"sTitle\": \"Visor Unico de Negocios\",
			                    \"sPdfMessage\": \"VUN Export PDF\",
			                    \"sPdfSize\": \"letter\"
			                },
			             	{
			                	\"sExtends\": \"print\",
			                	\"sMessage\": \"Visor Unico de Negocios <i>(presione Esc para regresar)</i>\"
			            	}
			             ],
			            \"sSwfPath\": \"js/plugin/datatables/swf/copy_csv_xls_pdf.swf\"
			        },
					\"autoWidth\" : true,
					\"preDrawCallback\" : function() {
						// Initialize the responsive datatables helper once.
						if (!responsiveHelper_datatable_tabletools) {
							responsiveHelper_datatable_tabletools = new ResponsiveDatatablesHelper($('#datatable_tabletools".$iniciocadena."'), breakpointDefinition);
						}
					}/*,

					\"rowCallback\" : function(nRow) {
						responsiveHelper_datatable_tabletools.createExpandIcon(nRow);
					},
					\"drawCallback\" : function(oSettings) {
						responsiveHelper_datatable_tabletools.respond();
					}*/
				});

				";

	$cadenatablasondas.="
		$('#dt_basic".$iniciocadena."').dataTable({
			\"sDom\": \"<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'T>r>\"+
					\"t\"+
					\"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>\",
	        \"oTableTools\": {
	        	 \"aButtons\": [
	             \"copy\",
	             \"csv\",
	             \"xls\",
	                {
	                    \"sExtends\": \"pdf\",
	                    \"sTitle\": \"Visor Unico de Negocios\",
	                    \"sPdfMessage\": \"VUN Export PDF\",
	                    \"sPdfSize\": \"letter\"
	                },
	             	{
	                	\"sExtends\": \"print\",
	                	\"sMessage\": \"Visor Unico de Negocios <i>(presione Esc para regresar)</i>\"
	            	}
	             ],
	            \"sSwfPath\": \"js/plugin/datatables/swf/copy_csv_xls_pdf.swf\"
	        },
			\"autoWidth\" : true,
			\"preDrawCallback\" : function() {
				// Initialize the responsive datatables helper once.
				if (!responsiveHelper_dt_basic) {
					responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic".$iniciocadena."'), breakpointDefinition);
				}
			}/*,
			\"rowCallback\" : function(nRow) {
				responsiveHelper_dt_basic.createExpandIcon(nRow);
			},
			\"drawCallback\" : function(oSettings) {
				responsiveHelper_dt_basic.respond();
			}*/
		});


	";

		$cadenatablaerrores.="
		$('#terrores".$iniciocadena."').dataTable({
			\"sDom\": \"<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'T>r>\"+
					\"t\"+
					\"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>\",
	        \"oTableTools\": {
	        	 \"aButtons\": [
	             \"copy\",
	             \"csv\",
	             \"xls\",
	                {
	                    \"sExtends\": \"pdf\",
	                    \"sTitle\": \"Visor Unico de Negocios\",
	                    \"sPdfMessage\": \"VUN Export PDF\",
	                    \"sPdfSize\": \"letter\"
	                },
	             	{
	                	\"sExtends\": \"print\",
	                	\"sMessage\": \"Visor Unico de Negocios <i>(presione Esc para regresar)</i>\"
	            	}
	             ],
	            \"sSwfPath\": \"js/plugin/datatables/swf/copy_csv_xls_pdf.swf\"
	        },
			\"autoWidth\" : true,
			\"preDrawCallback\" : function() {
				// Initialize the responsive datatables helper once.
				if (!responsiveHelper_dt_basic) {
					responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic".$iniciocadena."'), breakpointDefinition);
				}
			}/*,
			\"rowCallback\" : function(nRow) {
				responsiveHelper_dt_basic.createExpandIcon(nRow);
			},
			\"drawCallback\" : function(oSettings) {
				responsiveHelper_dt_basic.respond();
			}*/
		});


	";


}
?>