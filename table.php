<?php
include 'header.php'
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">

</head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="http://fortawesome.github.io/Font-Awesome/assets/font-awesome/css/font-awesome.css">
<script src="http://code.jquery.com/jquery-1.11.1.js"></script>

<body>
<style>@charset "utf-8";
    /* CSS Document */
    @import url('https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i');

    select.form-control.input-sm {
        background: #FF5B5E !important;
        border: 0px  !important;
        border-radius: 0px  !important;
        color: #FFF  !important;
        font-weight: 500 !important;
        font-size: 13px !important;
        font-family: 'Roboto', sans-serif;
        -webkit-box-shadow: 0px 0px 18px 0px rgba(0,0,0,0.18);
        -moz-box-shadow: 0px 0px 18px 0px rgba(0,0,0,0.18);
        box-shadow: 0px 0px 18px 0px rgba(0,0,0,0.18);
    }

    select.form-control.input-sm {
        background: #777777 !important;
        border: 0px  !important;
        border-radius: 0px  !important;
        color: #FFF  !important;
        font-weight: 500 !important;
        font-size: 13px !important;
        font-family: 'Roboto', sans-serif;
        -webkit-box-shadow: 0px 0px 18px 0px rgba(0,0,0,0.18);
        -moz-box-shadow: 0px 0px 18px 0px rgba(0,0,0,0.18);
        box-shadow: 0px 0px 18px 0px rgba(0,0,0,0.18);
    }


    .pagination>li>a, .pagination>li>span{
        background: #777777 !important;
        border: 0px  !important;
        border-radius: 0px  !important;
        color: #FFF  !important;
        font-weight: 500 !important;
        font-size: 13px !important;
        font-family: 'Roboto', sans-serif;
        -webkit-box-shadow: 0px 0px 18px 0px rgba(0,0,0,0.18);
        -moz-box-shadow: 0px 0px 18px 0px rgba(0,0,0,0.18);
        box-shadow: 0px 0px 18px 0px rgba(0,0,0,0.18);
    }

    .table-striped>tbody>tr:nth-of-type(odd) {
        background-color: #EEEEEE!important;
        color: #444444!important;
        font-size: 13px!important;
        font-family: 'Roboto', sans-serif;
        font-weight: 500!important;
    }
    tr.even {
        background: #d6d6d6!important;
        color: #000!important;
        font-size: 13px!important;
        font-weight: 500!important;
        font-family: 'Roboto', sans-serif;
    }

    th.sorting,.sorting_asc {
        font-family: 'Roboto', sans-serif;
        font-weight:500 !important;
        border:1px solid #FFF !important;
        color: #FFF;
        border: 1px solid #93CE37;
        border-bottom: 3px solid #9ED929;
        /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#30b3ff+0,00a1ff+100 */
        /*background: #770000; !* Old browsers *!*/
        /*background: -moz-linear-gradient(top,  #770000) 0%,#981E32 100%); !* FF3.6-15 *!*/
        /*background: -webkit-linear-gradient(top,  #770000 0%,#981E32 100%); !* Chrome10-25,Safari5.1-6 *!*/
        /*background: linear-gradient(to bottom, #770000 0%, #981E32 100%); !* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ *!*/
        background: #777777;
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#FF5B5E', endColorstr='#FF5B5E',GradientType=0 ); /* IE6-9 */

        -webkit-border-top-left-radius: 5px;
        -webkit-border-top-right-radius: 5px;
        -moz-border-radius: 5px 5px 0px 0px;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
    }

    table#example{border:0px !important;}

    input.form-control.input-sm{ background: #777777 !important;
        border: 0px  !important;
        border-radius: 0px  !important;
        color: #FFF  !important;
        font-weight: 500 !important;
        font-size: 13px !important;
        font-family: 'Roboto', sans-serif;
        -webkit-box-shadow: 0px 0px 18px 0px rgba(0,0,0,0.18);
        -moz-box-shadow: 0px 0px 18px 0px rgba(0,0,0,0.18);
        box-shadow: 0px 0px 18px 0px rgba(0,0,0,0.18);}

    .btn-danger{
        background-color:#C84345 ;
    }
</style>

<!--the js-->
<script src="js/bootstrap.js"></script>
<script>
    //    $(document).ready(function(){
    //        $(".dropdown").hover(
    //            function() {
    //                $('.dropdown-menu', this).stop( true, true ).slideDown("fast");
    //                $(this).toggleClass('open');
    //            },
    //            function() {
    //                $('.dropdown-menu', this).stop( true, true ).slideUp("fast");
    //                $(this).toggleClass('open');
    //            }
    //        );
    //    });

    $(document).ready( function() {
        $('#myCarousel').carousel({
            interval:   4000
        });

        var clickEvent = false;
        $('#myCarousel').on('click', '.nav a', function() {
            clickEvent = true;
            $('.nav li').removeClass('active');
            $(this).parent().addClass('active');
        }).on('slid.bs.carousel', function(e) {
            if(!clickEvent) {
                var count = $('.nav').children().length -1;
                var current = $('.nav li.active');
                current.removeClass('active').next().addClass('active');
                var id = parseInt(current.data('slide-to'));
                if(count == id) {
                    $('.nav li').first().addClass('active');
                }
            }
            clickEvent = false;
        });
    });
    $(document).ready(function() {
        $('#example').DataTable();

    } );
</script>