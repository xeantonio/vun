<?php
$cadenamapas="";
for ($iniciocadenasondas=0;$iniciocadenasondas<=(count($arregloidcanal)-1);$iniciocadenasondas++){
    $querysondasestados="
        SELECT sondacanal_estadoid,count(sondacanal_zona) as numsondas 
        FROM VUNWEB_SONDACANAL WHERE SONDACANAL_IDCANAL in (1,2,3,4,5,6,7,8,9,10,11,12)
        group by sondacanal_estadoid";

    $SqlIDsondasestados=sqlsrv_query( $conn, $querysondasestados);
    $cadenamapas.="data_array = { ";
    while($objsondaestados = sqlsrv_fetch_object($SqlIDsondasestados)){
        $cadenamapas.="\"".$objsondaestados->sondacanal_estadoid."\" : ".$objsondaestados->numsondas.",";
    }

	$cadenamapas.="
        \"0\" : 0
		};";

    $cadenamapas.="

		$('#vector-map".$iniciocadenasondas."').vectorMap({
                map: 'mx_en',
                enableZoom: true,
                zoomButtons: true,
                showTooltip: true,
                backgroundColor: 'transparent',
                borderColor: '#000000',
                borderOpacity: 1,
                borderWidth: 1,
                color: '#f4f3f0',
                hoverColor: '#c9dfaf',
                hoverOpacity: null,
                normalizeFunction: 'linear',
                scaleColors: ['#b6d6ff', '#005ace'],
                selectedColor: '#c9dfaf',
                regionsSelectable:false,
                regionStyle:{
                    initial: {
                        fill: '#fff',
                        \"fill-opacity\": 1,
                        stroke: 'black',
                        \"stroke-width\": 2,
                        \"stroke-opacity\": 0.5
                    },
                    hover: {
                        fill: '#FE2E2E',
                        \"fill-opacity\": 1,
                        cursor: 'pointer'
                    },
                    selected: {
                        fill: '#B40404'
                    },
                    selectedHover: {
                    }
                },
                regionLabelStyle:{
                    initial: {
                        'font-family': 'Verdana',
                        'font-size': '12',
                        'font-weight': 'bold',
                        cursor: 'default',
                        fill: 'black'
                    },
                    hover: {
                        cursor: 'pointer'
                    }
                },series : {
					regions : [{
						values : data_array,
						scale : ['#C8EEFF', '#0071A4'],
						normalizeFunction : 'polynomial'
					}]
				}
    });




				";
}
?>