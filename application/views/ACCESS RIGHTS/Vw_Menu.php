<!--//*******************************************FILE DESCRIPTION*********************************************//
//*******************************************MENU*********************************************//
//DONE BY:LALITHA
//VER -FIXED PRELOADER
//VER 0.01-INITIAL VERSION, SD:21/01/2015 ED:21/01/2015
//*********************************************************************************************************//-->
<?php
require_once('application/libraries/EI_HDR.php');
?>
<html>
<head>
    <link rel="stylesheet" href="<?php echo base_url().'menu/CSS/one.css'?>">
    <link rel="stylesheet" href="<?php echo base_url().'menu/CSS/two.css'?>">
    <link rel="stylesheet" href="<?php echo base_url().'menu/CSS/thr.css'?>">
    <link rel="stylesheet" href="<?php echo base_url().'menu/CSS/four.css'?>">
    <link rel="stylesheet" href="<?php echo base_url().'menu/CSS/five.css'?>">
    <link rel="stylesheet" href="<?php echo base_url().'menu/CSS/six.css'?>">


    <script src="<?php echo base_url().'menu/JS/one.js'?>" ></script>
    <script src="<?php echo base_url().'menu/JS/two.js'?>" ></script>
    <script src="<?php echo base_url().'menu/JS/thr.js'?>" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.6/highlight.min.js" defer></script>
    <script src="<?php echo base_url().'menu/JS/four.js'?>" ></script>
    <style>
        .navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .active > a {
            background-image: linear-gradient(to bottom, #498af3 0%, #498af3 100%);
            background-repeat: repeat-x;
            box-shadow: 0px 3px 9px #498af3 inset;
        }
    </style>
    <script>
        function callFuncAfterMenu(){
            'use strict';
            $(function() {
                $('#scroll_top').on('click', function() {
                    this.disabled = true;
                    $('body, html').animate({
                        scrollTop: 0
                    }, 800, function() {
                        this.disabled = false;
                    }.bind(this));
                    this.blur();
                });

                // Dropdown fix
                $('.dropdown > a[tabindex]').on('keydown', function(event) {
                    // 13: Return
                    if (event.keyCode == 13) {
                        $(this).dropdown('toggle');
                    }
                });
                // Предотвращаем закрытие при клике на неактивный элемент списка
                $('.dropdown-menu > .disabled, .dropdown-header').on('click.bs.dropdown.data-api', function(event) {
                    event.stopPropagation();
                });
                $('.dropdown-submenu > a').submenupicker();
                hljs.initHighlighting();
            });
        }
        var userstamp;
        var all_menu_array=[];
        var MenuPage=1;
        var SubPage=2;
        var address='';
        var final_menu_value=[];
        var final_sub_value=[];
        //FUNCTION FOR CLOCK
        function updateClock ( )
        {
            var currentTime = new Date ( );
            $("#clock").html(currentTime);
        }
        $(document).ready(function(){
            $(".preloader").show();
            $('.preloaderimg').attr('src',"<?php echo base_url().'images/Loading.gif'?>");
            var CONFIG_ENTRY_controller_url="<?php echo base_url(); ?>" + '/index.php/ACCESSRIGHTS/Ctrl_Menu/' ;
            setInterval('updateClock()', 1000);
            $('#calendarTitle').hide();
            $("#calendarTitle").text('');
            $("#calendarTitle").html('');
            $("#calendarTitle").empty();
            var Page_url;
            var value_err_array=[];
            // INITIAL DATA LODING
            $.ajax({
                type: "POST",
                'url':CONFIG_ENTRY_controller_url+"Initaildatas",
                data:{"Formname":'Menu',"ErrorList":'456'},
                success: function(data){
                    $("#calendarTitle").text('');
                    value_err_array=JSON.parse(data);
                },
                error: function(data){
                    alert('error in getting'+JSON.stringify(data));
                }
            });
            $(document).on("click",'.btnclass', function (){
                Page_url =$(this).attr('page');
                var attr_id=$(this).attr("id");
                if(attr_id==undefined){
                    attr_id='';
                }
                show_msgbox("MENU CONFIRMATION","Do You Want to Open "+attr_id+" "+$(this).text()+" ?","success",true);
                return false;
            });
            $(document).on('click','.menuconfirm',function(){
                $('.preloaderimg').attr('src',"<?php echo base_url().'images/Loading.gif'?>");
                if(Page_url!='Ctrl_Error_Page'){
                    $(".preloader").show();
                    $('#menu_frame').load("<?php echo site_url(); ?>" + "/"+Page_url+"/index");
                }
                else
                {
                    $(".preloader").show();
                    $('#menu_frame').load("<?php echo site_url(); ?>" + "/"+Page_url+"/index");
                }
            });
            var all_menu_array=[];
            var checkintime;
            var checkouttime;
            var checkinerrormsg=[];
            var LOGO;
            var iframe;
            $.ajax({
                type: "POST",
                'url':CONFIG_ENTRY_controller_url+"fetchdata",
                success: function(data){
                    $(".preloader").hide();
                    var value_array=JSON.parse(data);
                    all_menu_array= value_array;
                    userstamp=all_menu_array[1];
                    LOGO=all_menu_array[6][0];
                    iframe=all_menu_array[6][1];
                    $('img').each(function() {
                        $(this).attr('src', LOGO + $(this).attr('src'));
                    });
                    $('iframe').each(function() {
                        $(this).attr('src', iframe + $(this).attr('src'));
                    });
                    if(all_menu_array[0]!=''){
                        $('#menu_nav').show();
                        $('#RPT').show();
                        $('#AE').show();
                        ACRMENU_getallmenu_result(all_menu_array)
                    }
                    else{
                        var error_msg=value_err_array[0].EMC_DATA;// "NO ACCESS AVAILABLE FOR LOGIN ID : "
                        error_msg=(error_msg).toString().replace('[LOGIN ID]',all_menu_array[5]);
                        $('#ACRMENU_lbl_errormsg').text(error_msg);
                        $('#ACRMENU_lbl_errormsg').show();
                        $(".preloader").hide();
                        $('#menu_nav').hide();
                        $('#RPT').hide();
                        $('#AE').hide();
                    }
                },
                error: function(data){
                    $(".preloader").hide();
                    alert('error in getting'+JSON.stringify(data));
                }
            });
            //SUCCESS FUNCTION FOR MENU
            function ACRMENU_getallmenu_result(all_menu_array)
            {
                var ACRMENU_mainmenu=all_menu_array[0];//['ACCESS RIGHTS','DAILY REPORTS','PROJECT','REPORT']//main menu
                var ARCMENU_first_submenu=all_menu_array[1];
                //[['ACCESS RIGHTS-SEARCH/UPDATE','TERMINATE-SEARCH/UPDATE','USER SEARCH DETAILS'],['ADMIN ','USER '],['PROJECT ENTRY','PROJECT SEARCH/UPDATE'],['ATTENDANCE','REVENUE']]//submenu
                var ARCMENU_second_submenu=[];
                ARCMENU_second_submenu=all_menu_array[2]//[[], [], [], ['REPORT ENTRY', 'SEARCH/UPDATE/DELETE','WEEKLY REPORT ENTRY','WEEKLY SEARCH/UPDATE'], ['REPORT ENTRY', 'SEARCH/UPDATE'],[],[],[],[]];
                var count=0;
                var mainmenuItem="";
                var submenuItem="";
                var filelist=all_menu_array[4];
                var sub_submenuItem="";
                var script_flag=all_menu_array[3];
                for(var i=0;i<ACRMENU_mainmenu.length;i++)//add main menu
                {
                    var main='mainmenu'+i
                    var submen='submenu'+i;
                    var filename=filelist[count]+'.php';
                    if(ARCMENU_first_submenu[i].length==0)
                    {
                        mainmenuItem='<li><a class="btnclass" tabindex="0"  page="'+filename+'" href="#"  id="'+ACRMENU_mainmenu[i]+'">'+ACRMENU_mainmenu[i]+'</a></li>'
                    }
                    else
                    {
                        mainmenuItem='<li class="dropdown"><a tabindex="0" data-toggle="dropdown">'+ACRMENU_mainmenu[i]+'<span class="caret"></span></a><ul class="dropdown-menu '+submen+'" role="menu">'
                    }
                    $("#ACRMENU_ulclass_mainmenu").append(mainmenuItem);
                    for(var j=0;j<ARCMENU_first_submenu.length;j++)
                    {
                        if(i==j)
                        {
                            for(var k=0;k<ARCMENU_first_submenu[j].length;k++)//add submenu1
                            {
                                var sub_submenu='sub_submenu'+j+k;
                                if(ARCMENU_second_submenu[count].length==0)
                                {
                                    if(script_flag[count]!='X'){
                                        var file_name=filelist[count];
                                    }
                                    else{

                                        var file_name='ACCESSRIGHTS/Ctrl_Error_Page';
                                    }
                                    submenuItem='<li><a tabindex="0" page="'+file_name+'" href="#" class="btnclass"  id="'+ACRMENU_mainmenu[i]+'" >'+ARCMENU_first_submenu[j][k]+'</a></li>'
                                }
                                else
                                {

                                    submenuItem='<li class="dropdown-submenu">  <a tabindex="0" data-toggle="dropdown">'+ARCMENU_first_submenu[j][k]+'</a><ul class="dropdown-menu '+sub_submenu+'" >'
                                }
                                $("."+submen).append(submenuItem);
                                for(var m=0;m<ARCMENU_second_submenu[count].length;m++)//add submenu2
                                {
                                    if(script_flag[count][m]!='X'){
                                        var file_name=filelist[count][m];
                                    }
                                    else{

                                        var file_name='ACCESSRIGHTS/Ctrl_Error_Page';
                                    }
                                    sub_submenuItem='<li ><a tabindex="0" page="'+file_name+'" href="#" class="btnclass"  id="'+ARCMENU_first_submenu[j][k]+'" >'+ARCMENU_second_submenu[count][m]+'</a></li>'
                                    $("."+sub_submenu).append(sub_submenuItem);
                                }
                                count++;
                                $("#ACRMENU_ulclass_mainmenu").append('</ul></li>');
                            }
                        }
                    }
                    $("#ACRMENU_ulclass_mainmenu").append('</li>');
                }
                callFuncAfterMenu();
            }
        });
    </script>
    <title>EXPATS INTEGRATED CRM DEV</title>
    <meta charset="utf-8">
</head>
<body>
<div style="background-color: #EEF8Fb;height:20%">
    <table><tr><td><img id="img" src=""/></td>
        </tr></table>
</div>
<div>
    <table>
        <tr>
            <td style="width:1000px";><b><h4><span id="clock" ></span></h4></b></td>
        </tr>
    </table>
</div>
<iframe src="" style="border: 0" width="1350" height="600" frameborder="0" scrolling="no"></iframe>
<div class="wrapper">
    <div class="preloader"><span class="Centerer"></span><img src="<?php echo base_url().'images/Loading.gif'?>" class="preloaderimg"/> </div>
    <nav class="navbar navbar-default" id="menu_nav">
        <div class="navbar-header">
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="menu" >
            <ul class="nav navbar-nav" id="ACRMENU_ulclass_mainmenu">
            </ul>
        </div>
    </nav>

    <br><label id="ACRMENU_lbl_errormsg" class="errormsg" hidden ></label>
    <div id="menu_frame" name="iframe_a" ></div>
    <div style="height:100%" id="spacewidth"></div>
</div>
</div>

</body>
