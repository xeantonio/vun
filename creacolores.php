<?php
/*creando colores */
if ($objsondacanal->TRMAX<=8){
	$colormax='success';
}elseif($objsondacanal->TRMAX>8 && $objsondacanal->TRMAX<=29){
	$colormax='warning';
}elseif($objsondacanal->TRMAX>29){
	$colormax='danger';
}


if($objsondacanal->FAILPERF==0){
	$colorperftabla2='success';
}else{
	$colorperftabla2='danger';
}

if($objsondacanal->FAILDISPO==0){
	$colordispotabla2='green';
}else{
	$colordispotabla2='red';
}


if(number_format($objsondacanal->TOTALPERF,2)>=number_format($arreglodtmeta[$i],2)){
	$colorperftabla="success";
	$colorperftablaname="green"; 
	$iconperf="<i class='fa fa-check txt-color-green'></i>";
}elseif(number_format($objsondacanal->TOTALPERF,2)<number_format($arreglodtmeta[$i],2) && number_format($objsondacanal->TOTALPERF,2)>=number_format($arreglodtmeta[$i],2)-0.21){
	$colorperftabla="warning";
	$colorperftablaname="orange";
	$iconperf="<i class='fa fa-warning txt-color-orange'></i>";
}elseif(number_format($objsondacanal->TOTALPERF,2)<number_format($arreglodtmeta[$i],2) && number_format($objsondacanal->TOTALPERF,2)>=1){
	$colorperftabla="danger";
	$colorperftablaname="red";
	$iconperf="<i class='fa fa-flash txt-color-red'></i>";
}elseif(number_format($objsondacanal->TOTALPERF,2)<1){
	$colorperftabla="info";
	$colorperftablaname="blue";
	$iconperf="<i class='fa  fa-question txt-color-'blue'></i>";
}




if(number_format($objsondacanal->TOTALDISPO,2)>=number_format($arreglodtmeta[$i],2)){
	$colordispotabla="success";
	$colordispotablaname="green"; 
	$icondispo="<i class='fa fa-check txt-color-green'></i>";
}elseif(number_format($objsondacanal->TOTALDISPO,2)<number_format($arreglodtmeta[$i],2) && number_format($objsondacanal->TOTALDISPO,2)>=number_format($arreglodtmeta[$i],2)-0.21){
	$colordispotabla="warning";
	$colordispotablaname="orange";
	$icondispo="<i class='fa fa-warning txt-color-orange'></i>";
}elseif(number_format($objsondacanal->TOTALDISPO,2)<number_format($arreglodtmeta[$i],2) && number_format($objsondacanal->TOTALDISPO,2)>=1){
	$colordispotabla="danger";
	$colordispotablaname="red";
	$icondispo="<i class='fa fa-flash txt-color-red'></i>";
}elseif(number_format($objsondacanal->TOTALDISPO,2)<1){
	$colordispotabla="info";
	$colordispotablaname="blue";
	$icondispo="<i class='fa  fa-question txt-color-'blue'></i>";
}



if(number_format($objsondacanal->GLOBAL,2)>=number_format($arreglodtmeta[$i],2)){
	$colorglobtabla="success";
	$colorglobtablaname="green"; 
	$iconglob="<i class='fa fa-check txt-color-green'></i>";
}elseif(number_format($objsondacanal->GLOBAL,2)<number_format($arreglodtmeta[$i],2) && number_format($objsondacanal->GLOBAL,2)>=number_format($arreglodtmeta[$i],2)-0.21){
	$colorglobtabla="warning";
	$colorglobtablaname="orange";
	$iconglob="<i class='fa fa-warning txt-color-orange'></i>";
}elseif(number_format($objsondacanal->GLOBAL,2)<number_format($arreglodtmeta[$i],2) && number_format($objsondacanal->GLOBAL,2)>=1){
	$colorglobtabla="danger";
	$colorglobtablaname="red";
	$iconglob="<i class='fa fa-flash txt-color-red'></i>";
}elseif(number_format($objsondacanal->GLOBAL,2)<1){
	$colorglobtabla="info";
	$colorglobtablaname="blue";
	$iconglob="<i class='fa  fa-question txt-color-'blue'></i>";
}



?>