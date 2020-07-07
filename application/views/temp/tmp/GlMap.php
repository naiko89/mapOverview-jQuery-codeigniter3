<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<html>
<script src="http://localhost/TirockNavigator/javascript/jQuery-Google-Map-v1.5.1/jquery.googlemap.js"></script>
</head>
<body>

  
<div class="container-fluid text-center">    
  <div class="row content">
      
        <div class="col-sm-2 sidenav">
        <ul class="nav nav-list" id="GglSidebar">
        </ul>
        </div>
    <div class="col-sm-10 text-left">
      <p id="map">
          
      </p>
<!--  <hr>
      <h3>Test</h3>
      <input type="text" id="startDirec" value=""/>
      <p>Blocco 2</p>-->
    </div>
  </div>
</div>

<footer class="container-fluid text-center">
  <p>Footer Text</p>
</footer>

    
    <script>
        
    $.gestPanelGl = function(options){    
        var gP={options : $.extend({
                    map_set:{zoom: 12,
                             center: {lng: 12.245400, lat: 45.665661},
                             mapTypeControl: true,
                             mapTypeControlOptions:{position: google.maps.ControlPosition.TOP_LEFT},
                             zoomControlOptions:{position: google.maps.ControlPosition.TOP_RIGHT},
                             streetViewControlOptions: {position: google.maps.ControlPosition.LEFT_TOP}
                        },
                    thisMap:'',    
                    markers:[],
                    directionDisplay : new google.maps.DirectionsRenderer()//--->questa è di imput devi passare  wp che compongono il perccorso
                },options),
                index : function (){
                    gP.options.thisMap = new google.maps.Map(document.getElementById("map"),gP.options.map_set);
                    this.sideGrow();
                    },
                growGoogleSidebar : function(){//--->grow sidebar and routing services
                    
                    var evResPos = $('<ul>',{class : "list-group-item list-group-item-success buttSidebar", style: "list-style: none"})
                                    .append($('<h5>',{id : "prova"}).html('Direction').click(function(){
                                            $('.fild').remove();
                                            $($(this).parent()).append('<li class="list-group-item list-group-item-light fild"><input type="text" id="startDirec" value="Vittorio Veneto">\n\
                                                            <li class="list-group-item list-group-item-light fild"><input type="text" id="endDirect" value="Fregona"></li>\n\
                                                            <li class="list-group-item list-group-item-light fild"><button class="subSidebar" id="subDirec">Ok</button></li>');
                                            $('#subDirec').on('click', function(){
                                                            gP.routingServices(this);  
                                                    });
                                            })
                                            );
                    var evResNav = $('<ul>',{class : "list-group-item list-group-item-info buttSidebar", style: "list-style: none"})
                                        .append($('<h5>',{id : 'prova2'}).html('Geocoding').click(function(){
                                            $('.fild').remove();
                                            $($(this).parent()).append('<li class="list-group-item list-group-item-light fild"><input type="text" id="indrGeo" value="Fregona"/></li>\n\
                                                            <li class="list-group-item list-group-item-light fild"><button class="subSidebar" id="subGeocod">Ok</button></li>');
                                            $('#subGeocod').on('click', function(){
                                                    gP.routingServices(this);         
                                                    });
                                          
                                        })
                                        );
                    
                    $('#GglSidebar').append(evResPos).append(evResNav);
                    
                },
                routingServices : function(subThis){
                
                    function cleanMapMarkers(){
                        gP.options.directionDisplay.setMap(null);
                        for (var i = 0; i < gP.options.markers.length; i++ ) {
                                    gP.options.markers[i].setMap(null);
                                  }
                                  gP.options.markers.length = 0;
                        
                    };
                    
                    if($(subThis).attr('id')==='subDirec'){
                        var ends=[$('#startDirec').val(),$('#endDirect').val()];
                        var directionsService = new google.maps.DirectionsService;
                            cleanMapMarkers();
                            gP.options.directionDisplay.setMap(gP.options.thisMap);
                            var request = {origin: ends[0],destination: ends[1],travelMode: 'DRIVING'};
                                          directionsService.route(request, function(result, status) {
                                            if (status == 'OK') {
                                              gP.options.directionDisplay.setDirections(result);
                                              console.log(result);
                                            }
                                            else{
                                                cleanMapMarkers();
                                            }
                                          });
                    }
                    else if($(subThis).attr('id')==='subGeocod'){
                        var geocoder = new google.maps.Geocoder();
                        cleanMapMarkers();
                        geocoder.geocode({'address': $('#indrGeo').val()}, function(results, status) {
                          
                            if(status == 'OK')
                            {gP.options.thisMap.setCenter(results[0].geometry.location);
                                var marker = new google.maps.Marker({
                                  map: gP.options.thisMap,
                                  position: results[0].geometry.location
                                });
                                gP.options.markers.push(marker);
                            console.log(results);
                            }
                            else{cleanMapMarkers();}
                             
                         });
                    }
                }
            };           
        return {mapGrw : gP.index,
                sideGrow : gP.growGoogleSidebar,
                subMit: gP.routingServices()};    
        };
    
    $(document).ready(function(){
        var panel=$.gestPanelGl();
        panel.mapGrw();
    });
    </script>    
    
    
</body>



</html>