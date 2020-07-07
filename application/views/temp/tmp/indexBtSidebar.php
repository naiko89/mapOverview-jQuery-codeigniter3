<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>


<html>
<script src="https://maps.googleapis.com/maps/api/js?sensor=true&language=it&libraries=drawing&libraries=geometry&key=AIzaSyDt075ORLMjOZ7VkadVUvrWkHdydV3kyzw"async defer></script>
<style>
    /*globalset*/
    input{
        width: 100%;
    }
    /* Remove the navbar's default margin-bottom and rounded borders */ 
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }
    
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 100%}
    
    /* Set gray background color and 100% height */
    .sidenav {
      padding-top: 20px;
      background-color: #f1f1f1;
      min-height: 360px;
      height: auto;
    }
    
    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height:auto;} 
    }
    /*sidebar*/
    .subSidebar{
        width: auto;
    }
    
    
    /*Map style*/
    #map{height: 800px;}
  </style>
</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#" action='#'>Logo</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav" id="indx_men">
        <li class="active"><a href="#" id="glMap">GL</a></li>
        <li><a href="#" id="lfMap">LF</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#"><span class="glyphicon glyphicon-log-in"></span></a></li>
      </ul>
    </div>
  </div>
</nav>


    <div id="center_grow_temp" style="background-color: lightgreen;"></div>









    
<script type="text/javascript">
    $(document).ready(function(){

          $('#indx_men>li>a').on('click', function(eve){

            var attr=$(this).attr('id');

            switch (attr) { 
                case 'glMap': 
                    $('#center_grow_temp').load('gl_idx', function (cb_cl) {

                        });
                        break;
                case 'lfMap': 
                    $('#center_grow_temp').load('lf_idx', function (cb_ms) {

                        });
                        break;
            }
            eve.preventDefault();

          });
    });
</script>    
</body>
</html>
    
    