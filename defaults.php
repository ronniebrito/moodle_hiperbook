<?php // $Id: defaults.php,v 1.14.12.1 2007/11/02 16:19:58 tjhunt Exp $

// This file is generally only included from upgrade_activity_modules()
// It defines default values for any important configuration variables

   $defaults = array (
       'hiperbook_default_template_css =' => "#mod-hiperbook-hotword #page, #mod-hiperbook-popup #page{
	margin-top:0px;
	padding-top:0px;
	background-color:white;
}

#mod-hiperbook-popup #bookname{
	position:absolute;
	top:24px;
	left:15px;
	font-weight:bold;
	font-style:italic;	
	font-size:14px;
	text-align:left;
} 

.mod-hiperbook #navpaths{
	margin-top:10px;
	margin-left:10px;
}

.mod-hiperbook #navpaths #current{
	font-family:Verdana, Arial, Helvetica, sans-serif;	
	font-size:13px;
	color:white;	
	height:22px;
}
.mod-hiperbook #navpaths #current #main{
	background-color:#233E54;	
	display:inline;
	text-align:center;
	padding:2px;
	padding-bottom:3px;
	font-weight:bold;
}

.mod-hiperbook #navpaths #current #start{
	background-image:url(template_hiperbook/navpath_current_start.jpg);
	background-position:center;
	background-repeat:no-repeat;
	display:inline;
	padding:2px;	
	padding-bottom:3px;

}
.mod-hiperbook #navpaths #current #end{
	background-image:url(template_hiperbook/navpath_current_end.jpg);
	background-position:center;
	background-repeat:no-repeat;
	display:inline;
	padding:2px;	
	padding-bottom:3px;

}


	
	
.mod-hiperbook #navpaths #past{

	
}
	
	
.mod-hiperbook #navpaths #past #main{	
	background-image:url(template_hiperbook/navpath_past.jpg);
	background-position:center;
	background-repeat:repeat-x;
	display:inline;
	text-align:center;
	padding:4px;

	
}

.mod-hiperbook #navpaths #past #main a{
	font-family:Verdana, Arial, Helvetica, sans-serif;
	text-decoration:none;
	font-size:13px;
	color:#8FB4DF;		
	background-position:center;	
}

.mod-hiperbook #navpaths #past #start{
	background-image:url(template_hiperbook/navpath_past_start.jpg);
	background-position:center;
	background-repeat:no-repeat;
	display:inline;
	padding:4px;
	padding-right:0px

	
}

.mod-hiperbook #navpaths #past #end{
	background-image:url(template_hiperbook/navpath_past_end.jpg);
	background-position:center;
	background-repeat:no-repeat;
	display:inline;	
	padding:2px;
	padding-left:0px

}

.mod-hiperbook #breadcrumbs{
	height:18px;
	margin-left:10px;
}

.mod-hiperbook #breadcrumbs #current{
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-weight:bold;
	font-size:12px;
}

.mod-hiperbook #breadcrumbs #current #main{
	display:inline;
	text-align:center;

}
.mod-hiperbook #breadcrumbs #current #start{
	display:inline;
	font-weight:normal;	
}
.mod-hiperbook #breadcrumbs #current #end{
	display:inline;
}

.mod-hiperbook #breadcrumbs #past{


}
.mod-hiperbook #breadcrumbs #past a{
	font-family:Verdana, Arial, Helvetica, sans-serif;
	text-decoration:none;
	font-size:12px;
}
	

.mod-hiperbook #breadcrumbs #past #main{	
	display:inline;
	text-align:center;
	background-position:center;
	
}
.mod-hiperbook #breadcrumbs #past #start{
	font-family:Verdana, Arial, Helvetica, sans-serif;
	text-decoration:none;
	font-size:12px;
	display:inline;	
	
}
.mod-hiperbook #breadcrumbs #past #end{
	display:inline;
}



.mod-hiperbook #page_navigation{
	text-align:center;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:12px;
}
.mod-hiperbook #page_navigation img{
	text-align:center;
	color:black;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-weight:bold;
	vertical-align:middle;
}

.mod-hiperbook #toc{
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-weight:bold;
	font-size:12px;
	padding-left:8px;
	color:#00477F;	
	width:150px;
}

.mod-hiperbook #toc #item a{
	text-align:left;
	text-decoration:none;
	font-weight:normal;
}

.mod-hiperbook #toc #item a:visited{
	color:#8FB4DF;
}

.mod-hiperbook #toc #item{	

}

.mod-hiperbook .hiperbook_content{
	width:500px;

}

.mod-hiperbook .hiperbook_content #template_top_left{
	background-image:url(template_hiperbook/top_conteudo_left.gif);
	background-repeat:no-repeat;

}
.mod-hiperbook .hiperbook_content #template_top_right{
	background-image:url(template_hiperbook/top_conteudo_right.gif);
	background-repeat:no-repeat;
	background-position:right;

}

.mod-hiperbook .hiperbook_content #template_main{
	background-color:#efefef;
}
.mod-hiperbook .hiperbook_content #template_bottom_left{
	background-image:url(template_hiperbook/bottom_conteudo_left.gif);
	background-repeat:no-repeat;

}
.mod-hiperbook .hiperbook_content #template_bottom_right{
	background-image:url(template_hiperbook/bottom_conteudo_right.gif);
	background-repeat:no-repeat;
		background-position:right;

}


.hiperbook_content .hotwordslist{
	width:100%;
	border:0px;
	color:#003366;
}

.hiperbook_content .hotwordslist .title a{
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:12px;
	font-weight:bold;
	padding-left:46px;	
}
.hiperbook_content .hotwordslist .title {
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:12px;
	font-weight:bold;
	padding-top:23px;
	padding-bottom:23px;
}

.hiperbook_content .hotwordslist .content{
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:12px;
	padding-left:92px;
	padding-right:46px;
}

.mod-hiperbook #botoesLateral{
	width:250px;
	margin-left:170px;
	margin-top:10px;
}

#mod-hiperbook-popup #botoesLateral{
	width:50px;
	margin-left:10px;
	margin-top:10px;
}

#topo_tips{
	background-image:url(title_comentarios.jpg);
	width:1008px;
	height:110px;
	padding-top:0px;
	
}

#mod-hiperbook-tips #page {
	
	padding-top:0px;
	margin-top:0px;
	
}

.book_chapter_title {
    font-family: Tahoma, Verdana, Arial, Helvetica, sans-serif;
    text-align: left;
    font-size: large;
    font-weight: bold;

    margin-left: 0px;
    margin-bottom: 0px;
}

.book_content {
    text-align: left;
}
.book_toc_none ul {
    margin-left: 0px;
    padding-left: 0px;
}
.book_toc_none ul ul {
    margin-left: 0px;
    padding-left: 0px;
}
.book_toc_none li {
    margin-top: 0px;
    list-style: none;
}
.book_toc_none li li {
    margin-top: 0px;
    list-style: none;
}



#mod-hiperbook-popup #page{
	margin-top:0px;
	padding-top:0px;
	background-color:white;
	padding-top:50px;
}



.mod-hiperbook #bookname{
	font-weight:bold;
	font-style:italic;	
	font-size:14px;
	margin-bottom:15px;
	text-align:right;	
} 
.mod-hiperbook, a{
	color:#00477F;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	border-collapse:collapse;
	border:0px;
}

table {
border-collapse:collapse;
border-spacing:0;
}


",
     

    );

?>
