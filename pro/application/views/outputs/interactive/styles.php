<?php if($action!='download' && $action!="download2")

{?>

<link rel="shortcut icon" href="/favicon.ico" />

<link href="<?php echo base_url();?>css/jeditable_style.css?<?php echo time();?>" rel="stylesheet" type="text/css" />

<?php } ?>

<style>

body {font-size:13px;font-family: Arial, Helvetica, sans-serif;color:#000;}

ul {margin-bottom:0;}

#content {margin:0 auto;width:990px;overflow:hidden;}

#content, table.output, table.output table {font-size:16px;font-weight: normal !important;line-height: 1.85px;}

table.output tr th {font-weight: bold;font-size:13px;}

table.output tr td span {}

table.output tr td.border {border-top:1px solid #000;}

table.output tr td.border-bottom {border-bottom:0px solid #000;}
table.output td.border-bottom {border-bottom: none !important;height: 20px;border-top:0px solid #000;}
.hrline {background: #000000; height: 1px;border: none;}
.td-pad-b {vertical-align: top;}
.td-pad-bobm {vertical-align: top;padding-top: 10px;}

.questions .output td.border-bottom {border-bottom: none !important;height: 20px;border-top: 0px solid #000;}



h1 {font-size:16px;}

p.topTxt {font-size: 13px; text-align: center; font-weight:bold;}

span.red, span.red-area, .red-area {color:red;}

#content.questions li{line-height: 30px;}
#content.questions .isbox li{line-height: 23px;}
#content.questions .introduction div{line-height: 20px;}
#content.questions .introduction div h4{margin:10px 0px;}
#content.questions p{line-height: 30px;}

<?php if($action!='download' && $action!="download2"){?>

.qfQuest{list-style-type: none;}

.qfQuest .qfsublist{display:inline-block;text-decoration:none;font-size: 16px;color: #ff0000;margin-left: -18px;padding-right: 9px;}

.qfQuest ul{display:none;}

<?php } else {?>

.qfsublist{display:none;}

<?php } ?>

<?php if($button == True):?>

table, caption, tbody, tfoot, thead, tr, th, td { margin: 0; padding: 0; border: 0; outline: 0; vertical-align: baseline; }

body, #content, table.output, table.output table {line-height: 18px;}

span.edit_area:hover {background: #F2F0A5;}

.td-pad-b {padding-bottom:17px;}

.btnDownload {background:url("<?php echo $img_dir; ?>btn-download.jpg");width:108px;height:69px;display:block;}

.btnDownload:hover {background-position:0 -69px;}

</style>

<script type="text/javascript" src="<?php echo base_url();?>js/jquery.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>js/jeditable.js?<?php echo time();?>"></script>

<script type="text/javascript">

<?php if(!isset($eLusrNotBS)){//if this is defined then Lite user cant access for dynamic editings on HTML page?>

$(document).ready(function() {



    $('.edit_area').editable('<?php echo base_url();?>product/dy_cam_up_entry', { 

    	   name       : 'value',

           id         : 'id',

    	   type : 'textarea',

    	   submit   : 'Update',

    	   width      : '400px',

           height     : '100px',

           tooltip : "Click to edit...",

           style : "",

           requireProductTxt : "[Requires another product to be added]",

           clsName				: 'edit_area',

           callback : function(value, settings) {

           }

    });



});

<?php }?>

</script>

<style>

<?php endif; 

if($partid)

{

?>

.sub-nav-sf a.buttonL {

    padding: 5px 18px;

    margin-top: -10px;

}

div.a a {

    height: 26px;

	text-align: center;

    margin: 0 auto;

    display: block;

    overflow: hidden;

	/*width:inherit;*/

}

.navas

{

	background:url("<?php echo $img_dir; ?>icons/sfstop.png?n");

	height: 55px;

	width: 55px;

	text-align: center;

	margin: 0 auto;

	display:block;

}

.navas:hover

{

	background:url("<?php echo $img_dir; ?>icons/sfstop-hover.png?n");



}

.navas.active

{

	background:url("<?php echo $img_dir; ?>icons/sfstop-hover.png?n");



}

.navab

{

	background:url("<?php echo $img_dir; ?>icons/sfback.png?n");

	width: 45px;

	text-align: center;

	margin: 0 auto;

	display:block;

}

.navab:hover

{

	background:url("<?php echo $img_dir; ?>icons/sfback-hover.png?n");

}

.navab.active

{

	background:url("<?php echo $img_dir; ?>icons/sfback-hover.png?n");

}

.navaq

{

	background:url("<?php echo $img_dir; ?>icons/sfquestion.png?n");

	width: 150px;

	text-align: center;

	margin: 0 auto;

	display:block;

}

.navaq:hover

{

	background:url("<?php echo $img_dir; ?>icons/sfquestion-hover.png?n");

}

.navaq.active

{

	background:url("<?php echo $img_dir; ?>icons/sfquestion-hover.png?n");

}

.navaf

{

	background:url("<?php echo $img_dir; ?>icons/sfforward.png?n");

	width: 45px;

	text-align: center;

	margin: 0 auto;

	display:block;

}

.navaf:hover

{

	background:url("<?php echo $img_dir; ?>icons/sfforward-hover.png?n");

}

.navaf.active

{

	background:url("<?php echo $img_dir; ?>icons/sfforward-hover.png?n");

}

.navas2

{

	background:url("<?php echo $img_dir; ?>icons/sfstar.png?n");

	width: 150px;

	text-align: center;

	margin: 0 auto;

	display:block;

}

.navas2:hover

{

	background:url("<?php echo $img_dir; ?>icons/sfstar-hover.png?n");

}

.navas2.active

{

	background:url("<?php echo $img_dir; ?>icons/sfstar-hover.png?n");

}

.navap

{

	background:url("<?php echo $img_dir; ?>icons/sfprob.png?n");

	width: 150px;

	text-align: center;

	margin: 0 auto;

	display:block;

}

.navap:hover

{

	background:url("<?php echo $img_dir; ?>icons/sfprob-hover.png?n");



}

.navap.active

{

	background:url("<?php echo $img_dir; ?>icons/sfprob-hover.png?n");



}

.navaa

{

	background:url("<?php echo $img_dir; ?>icons/sfinfo.png?n") no-repeat;

	width: 150px;

	text-align: center;

	margin: 0 auto;

	display:block;

}

.navaa:hover

{

	background:url("<?php echo $img_dir; ?>icons/sfinfo-hover.png?n") no-repeat;

}

.navaa.active

{

	background:url("<?php echo $img_dir; ?>icons/sfinfo-hover.png?n");

}

.leftheader_is {

	border-bottom: 8px solid #757575;

}

.is_footer {

    background: #d9d9d9;

    padding: 1px;

}

.is_footer .sub-navigation1{text-align:center;}

.sub-navigation1 .a

{

	text-align: center;

	padding: 0px 2px;

	display: inline-block;

}

/*Styles for new layout - Started*/

#content

{

	width: 100%;

	border: 10px solid #757575;

	/*border-radius: 10px;*/

	border-top: 0px;

	background: #d9d9d9;

	box-sizing: border-box;

	-moz-box-sizing:border-box;

    -webkit-box-sizing:border-box;

}

body

{

	background: rgba(194, 194, 195, 1);

}

.main_content_sf

{

	float:left;

	width: 60%;

	border-right: 8px solid #757575;

	box-sizing: border-box;

	background: #ffffff;

}

.main_content_sf .scroll-bar_sf

{

	/*border-right: 8px solid #757575;

	border-left: 8px solid #757575;*/

	padding: 0px 10px 0; 

	padding-top:20px;

	padding-bottom:11px;

	min-height: 300px;

	height: 60%;

	border-bottom: 8px solid #757575;

	overflow-y: scroll;

}

.objection_content_sf .sub-dev-head

{

	/*border-right: 8px solid #757575;*/

	line-height: 30px;

	margin: 0 ;

	padding: 10px;

	padding-top: 20px;

	border-left: 8px solid #757575;

}



.main_content_sf .sub-dev-head

{

	/*border-right: 8px solid #757575;

	border-left: 8px solid #757575;*/

	line-height: 20px;

	margin: 0 ;

	padding: 10px;

	/*padding-top: 20px;*/

}

.main_content_sf h1.sub-dev-head{display:none;}

.main_content_sf .sub-dev-head-sub1

{

	margin:0;

}

.main_content_sf .sub-dev-cont

{

	margin-top: 0px;

	width: 95%;

	margin-left: 0%;

}

.main_content_sf .sub-nav-sf-wr

{

	padding-top: 10px;

}

.objection_content_sf

{

	float:left;

	width:25%;

	

}

.objection_content_sf .objection_content_logo h1

{

	/*height: 22px;

	text-align: right;

	margin: 0;

	padding: 4.5px;

	background: #757575;*/

	height: 22px;

	text-align: right;

	margin: 0;

	padding: 0px;

	/*border-bottom: 10px solid #757575; */

	background: #757575;

}

.objection_content_sf .objection_content_logo h1 img

{

	height: 22px;

}

.questions .objection_content_sf ul

{

	margin: 0px 0 0px 0px;

	padding: 10px 10px 0px 0px;

	min-height: 300px;

	height: 60%;

	/*border-bottom: 8px solid #757575;*/

	overflow-y: scroll;

	/*border-left: 8px solid #757575;*/

}

#content .objection_content_sf ul li

{

	padding-left: 10px;

}

.objection_content_sf .sub-dev-head-sub1

{

	width: 100%;

	text-align: center;

}

.objection_content_sf .sub-nav-sf

{

	margin: 35px auto;

}



/*.objection_content_sf h1

{

	text-align: left;

	padding-left: 0px;

}*/

.sub-navigation1

{

	margin-left: 0%;

}

#objection_content_sf ul li

{	

	text-align:left;

	/*font-size:12px !important;*/

}

.objection_content_sf ul li a

{	

	display: block;

	line-height: 14px;

	text-decoration:none;

	color:#fff;

	font-size:14px;

	font-weight:bold;

	text-align:center;

	background: #757575;

	cursor: pointer;

	padding: 10px;

	margin-bottom: 5px;

}

.objection_content_sf ul li a:hover, .objection_content_sf ul li a.active

{	

	background: rgba(220, 0, 0, 1);

	text-decoration: none;

}

.leftheader_is p a

{

  background: #757575;

  color: #fff;

  text-decoration: none;

  margin: 0 0px 0 8px;

  padding: 0px;

  text-align: center;

  width: 23.8%;

  float: left;

  font-size: 11px;

  /*line-height: 14px;*/

  overflow: hidden;

  height: 95%;

}

.leftheader_is p a.active{

	background:rgba(220, 0, 0, 1);

}

.leftheader_is p

{

	/*padding: 5.5px;

	height: 20px;

	margin: 0px;

	color: #fff;

	font-weight: bold;

	padding-top: 1px;*/

	height: 21px;

	margin: 0px;

	color: #fff;

	font-weight: bold;

	/*border-bottom: 4px solid #757575;*/

	box-sizing: border-box;

	-moz-box-sizing: border-box;

	-webkit-box-sizing: border-box;
	line-height: 23px !important;
}



/*Styles for new layout - Completed*/

.sub-navigation

{

	width:100%;

	

}

.sub-navigation .a

{

	width: 16.66%;

	text-align: center;

	float: left;

}



.sub-dev-cont

{

	margin-top: 25px;

	width: 100%;

	height: 60px;

	border:1px solid black;

	/*background: beige;*/

	font-size: 16px;

	padding: 10px;

}

.sub-dev-desc

{

	/*font-size : 25px;*/

	line-height: 30px;

}

.sub-dev-desc-ul, .sub-dev-desc-p, .sub-dev-desc p, .sub-dev-desc ul, p, ul

{

	line-height: 20px;

}

#content p

{

	width:100%;

	font-size:16px;

	font-family:Arial, Helvetica, sans-serif;

}

#content ul li

{

	font-family:Arial, Helvetica, sans-serif;

	font-size:16px;

}



.sub-dev-head

{

	font-size : 18px;

	font-weight:bold;

	font-family:Arial, Helvetica, sans-serif;

	text-align:center;

	padding:20px;

	display:block;

}

.sub-dev-head-sub1

{

	font-size : 16px;

	font-weight:bold;

	font-family:Arial, Helvetica, sans-serif;

	text-align:justify;

	display:block;

	padding:20px 0px 10px;

}

.sub-dev-head-sub2

{

	font-size : 14px;

	font-weight:bold;

	font-family:Arial, Helvetica, sans-serif;

	text-align:justify;

	display:block;

	padding:5px;

	padding-left:0px;

	padding-top:20px;

}



.objection-responses-dev li

{

	list-style:none;

	text-align:center;

	line-height:25px;

}



.questions ul

{

	margin:10px 0 15px 0;

}

.questions ul.q-resp

{

	margin: 0px 0px 0px 0px;

	line-height: 30px;

}

.sub-nav-sf-wr

{

	width:100%;

	overflow:hidden;

	padding-top: 40px;

}

.sub-nav-sf	

{

	width:315px;

	margin:0 auto;

	text-align:center;

}

/*

.sub-nav-sf a	 

{

	line-height:25px;

	display:inline-block;

	background:#000;

	color:#fff;

	border:1px solid #fff;

	text-decoration:none;

	padding:5px;

	width:100px;

	text-align:center;

}*/

.bBlue {

border: 1px solid #3e76af;

box-shadow: 0 1px 2px 0 #66b2d2 inset;

-webkit-box-shadow: 0 1px 2px 0 #66b2d2 inset;

-moz-box-shadow: 0 1px 2px 0 #66b2d2 inset;

background: #5ba5cb;

background: -moz-linear-gradient(top, #5ba5cb 0%, #3a70ab 100%);

background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#5ba5cb), color-stop(100%,#3a70ab));

background: -webkit-linear-gradient(top, #5ba5cb 0%,#3a70ab 100%);

background: -o-linear-gradient(top, #5ba5cb 0%,#3a70ab 100%);

background: -ms-linear-gradient(top, #5ba5cb 0%,#3a70ab 100%);

background: linear-gradient(top, #5ba5cb 0%,#3a70ab 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#5ba5cb', endColorstr='#3a70ab',GradientType=0 );

}

.bBlue:hover{

	background: #3a70ab;

}

.bBlue:active{

	background: -moz-linear-gradient(top, #5ba5cb 0%, #3a70ab 100%);

	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#5ba5cb), color-stop(100%,#3a70ab));

	background: -webkit-linear-gradient(top, #5ba5cb 0%,#3a70ab 100%);

	background: -o-linear-gradient(top, #5ba5cb 0%,#3a70ab 100%);

	background: -ms-linear-gradient(top, #5ba5cb 0%,#3a70ab 100%);

	background: linear-gradient(top, #5ba5cb 0%,#3a70ab 100%);

	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#5ba5cb', endColorstr='#3a70ab',GradientType=0 );

}

.bGreen {

border: 1px solid #68a341;

box-shadow: 0 1px 2px 0 #a4ca6c inset;

-webkit-box-shadow: 0 1px 2px 0 #a4ca6c inset;

-moz-box-shadow: 0 1px 2px 0 #a4ca6c inset;

padding: 7px 26px;

background: #96c161;

background: -moz-linear-gradient(top, #96c161 0%, #609c3d 100%);

background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#96c161), color-stop(100%,#609c3d));

background: -webkit-linear-gradient(top, #96c161 0%,#609c3d 100%);

background: -o-linear-gradient(top, #96c161 0%,#609c3d 100%);

background: -ms-linear-gradient(top, #96c161 0%,#609c3d 100%);

background: linear-gradient(top, #96c161 0%,#609c3d 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#96c161', endColorstr='#609c3d',GradientType=0 );

}

.bGreen:hover{

	background: #96c161;

}

.bGreen:active{

	background: #96c161;

	background: -moz-linear-gradient(top, #96c161 0%, #609c3d 100%);

	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#96c161), color-stop(100%,#609c3d));

	background: -webkit-linear-gradient(top, #96c161 0%,#609c3d 100%);

	background: -o-linear-gradient(top, #96c161 0%,#609c3d 100%);

	background: -ms-linear-gradient(top, #96c161 0%,#609c3d 100%);

	background: linear-gradient(top, #96c161 0%,#609c3d 100%);

	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#96c161', endColorstr='#609c3d',GradientType=0 );

}

.buttonL {

text-decoration:none;

padding: 8px 18px;

font-size: 12px;

color: #fff;

font-weight: bold;

text-shadow: 0 -1px #6f6f6f;

display: inline-block;

line-height: 14px;

border-radius: 2px;

-webkit-border-radius: 2px;

-moz-border-radius: 2px;

width:100px;

}

.resp_data_val_class

{

	background:#DDDDDD;

	min-height:100px;

	padding:10px;

}

.resp_data_val_class .empty

{

	background:#DDDDDD;

	min-height:100px;

}

.resp_data_val_class .cont

{

	background:#DDDDDD;

	min-height:100px;

	padding:10px;

}

.section_sf.scnd

{

  width: 30%;

  padding: 5px;

  padding-top:0px;

  padding-bottom:0px;

  margin-right: 8px;

  line-height: 15px;

  min-height: 40px;

}

.section_sf.scnd h3

{

	margin-top:6px;

	margin-bottom:0px;

}

.section_sf.scnd.active

{

	color: #fff;

	background: rgba(220, 0, 0, 1);

}

.section_sf

{

	width: 49%;

	float:left;

	display: inline-block;

	background: #757575;

	color: white;

	text-indent: 10px;

	border-bottom:2px solid white;

	cursor:pointer;

	text-align: center;

}

.section_sf.active

{

	color: #fff;

	/*height: 60px;*/

	background: rgba(220, 0, 0, 1);

	/*border: 1px solid #757575;

	box-sizing: border-box;*/

}

.section_sf h3

{

	/*display:inline-block;*/

	width:96%;

}

.content_sec

{

	display:none;

}

.tab_content

{

	padding:10px;

}

.section_tabs

{

	width:100%;

}

/*#hiddenForm99

{

	height: 0px !important;

	width: 0px;

	position: absolute;

}*/

.section_tabs.big

{

	height: 24px;

}

.section_sf.frst

{

	/*margin-left: 20px;*/

 	margin-right: 10px;

}

.content_sec.active

{

	display:block;

}

.left_navigation_is

{

	float: left;

	width: 15%;

}

.left_navigation_is .content_navigation_is

{

	min-height: 300px;

	height: 60%;

	overflow-y: scroll;

	border-bottom: 8px solid #757575;

	border-right: 8px solid #757575;

	padding: 10px 10px 0px;

}

.left_navigation_is .sub-nav-sf

{

	margin: 20px auto;

}

.left_navigation_is .header_left_navigation_is

{

	background: #757575;

	padding-top: 1px;

	height: 21px;

	margin: 0px;

	color: #fff;

	font-weight: bold;

}

.left_navigation_is .sub-dev-head

{

	border-right: 8px solid #757575;

	line-height: 30px;

	margin: 0;

	padding: 10px;

	padding-top: 20px;

}

.left_navigation_is .navigation_link a

{

	display: block;

	line-height: 14px;

	text-decoration:none;

	color:#fff;

	font-size:11px;

	font-weight:bold;

	text-align:center;

	background: #757575;

	cursor: pointer;

	padding: 10px;

	margin-bottom: 5px;

}

.left_navigation_is .navigation_link.selected_left a, .left_navigation_is .navigation_link a:hover

{

	text-decoration:none;

	background: rgba(220, 0, 0, 1);

}

/*New Layout 2*/

.left_navigation_is .sub-nav-sf{display:none;}

#main_content_sf .is_footer{display:none;}

.left_navigation_is .content_navigation_is {

	 border-bottom: none; 

}

.leftheader_is {

	border-bottom: none;

}

/*New Layout 2*/

/*OBJECTION MAP*/
.objectionmap .main_content_sf
{
	width: 75%;
	padding-bottom: 22px;
}
.objectionmap .leftheader_is{display: none;}
#content.sales-templates .main_content_sf {padding-bottom: 22px;}
#content.sales-templates .leftheader_is{display: none;}
/*end of OBJECTION MAP*/

<?php

}

?>

</style>