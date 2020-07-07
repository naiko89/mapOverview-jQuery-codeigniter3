<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<html>
    <head>
<!--        
        <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
        
        <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>-->
<!--        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css"
        integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
        crossorigin=""/>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.2.0/dist/leaflet.css" />-->
<!--        <script src="https://unpkg.com/leaflet@1.2.0/dist/leaflet.js"></script> -->
        <script src="https://cdn.jsdelivr.net/npm/graphhopper-js-api-client/dist/graphhopper-client.js"></script>
    </head>
    
    <style>
        /*#mapId {height: 180px;}*/
    </style>
<body>

  
<div class="container-fluid text-center">    
    <div class="row content">
            <div class="col-sm-2 sidenav">
            <ul class="nav nav-list" id="LfSidebar">
            </ul>
            </div>
        <div class="col-sm-10 text-left">
          <p id="map"></p>
<!--          <hr>
          <h3>Test</h3>
          <input type="text" id="startDirec" value=""/>
          <p>Blocco 2</p>-->
        </div>
    </div>
</div>

<footer class="container-fluid text-center">
  <p>Footer Text</p>
</footer>
    
    
    
</body>
<script>
$.gestPanelLf = function(options){    
        var gP={options : $.extend({
                    map_set: {zoom: 12,
                             center: ''},
                    thisMap: '',
                    tileLayers: {'base': ''},
                    markers: {geolocation: '',routing: {start: '',end: ''}},
                    polyline: ''},options),
                index : function (){ 
                    gP.options.thisMap=L.map('map',{fullscreenControl: true, zoomDelta: 0.25}).setView([45.665661, 12.245400], 14);;
                    gP.options.map_set=L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                zoomDelta: 0.25,
                                zoomSnap: 0,
                                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                        }).addTo(gP.options.thisMap);   

                    this.sideGrow();
                    },
                growLeaFletSidebar : function(){//--->grow sidebar and routing services
                    
                    var evResPos = $('<ul>',{class : "list-group-item list-group-item-success buttSidebar", style: "list-style: none"})
                                    .append($('<h5>',{id : "prova"}).html('Direction').click(function(){
                                            $('.fild').remove();
                                            $($(this).parent()).append('<li class="list-group-item list-group-item-light fild"><input type="text" id="startDirec" value="Treviso">\n\
                                                            <li class="list-group-item list-group-item-light fild"><input type="text" id="endDirect" value="Milano"></li>\n\
                                                            <li class="list-group-item list-group-item-light fild"><button class="subSidebar" id="subDirec">Ok</button></li>');
                                            $('#subDirec').on('click', function(){
                                                            gP.routingService();  
                                                    });
                                    })
                                            );
                    var evResNav = $('<ul>',{class : "list-group-item list-group-item-info buttSidebar", style: "list-style: none"})
                                    .append($('<h5>',{id : 'prova2'}).html('Geocoding').click(function(){
                                            $('.fild').remove();
                                            $($(this).parent()).append('<li class="list-group-item list-group-item-light fild"><input type="text" id="indrGeo" value="Venezia"/></li>\n\
                                                            <li class="list-group-item list-group-item-light fild"><button class="subSidebar" id="subGeocod">Ok</button></li>');
                                            $('#subGeocod').on('click', function(){
                                                            gP.geocodingService();         
                                                    });
                                          
                                    })
                                        );
                    $('#LfSidebar').append(evResPos).append(evResNav);
                },
                routingService : function(){
                
                    var endsCity=[$('#startDirec').val(),$('#endDirect').val()];
                    var endsObj={start:'',end:''};
                    $.ajax({
                        url: "https://graphhopper.com/api/1/geocode?q="+endsCity[0]+"&locale=it&debug=true&key=0f9e8ada-ae21-4ae5-a770-92f0677e1897",
                            beforeSend: function(xhrObj){
                                    xhrObj.setRequestHeader("Content-Type","application/json");
                                    xhrObj.setRequestHeader("Accept","application/json");
                            }, 
                            success: function(data){
                                    endsObj.start=data.hits[0];
                                $.ajax({
                                    url: "https://graphhopper.com/api/1/geocode?q="+endsCity[1]+"&locale=it&debug=true&key=0f9e8ada-ae21-4ae5-a770-92f0677e1897",
                                        beforeSend: function(xhrObj){
                                                xhrObj.setRequestHeader("Content-Type","application/json");
                                                xhrObj.setRequestHeader("Accept","application/json");}, 
                                        success: function(data){
                                                endsObj.end=data.hits[0];
                                                var ghRouting = new GraphHopper.Routing({
                                                          key: "0f9e8ada-ae21-4ae5-a770-92f0677e1897",
                                                          vehicle: "car",
                                                          elevation: false
                                                    });
                                                    ghRouting.addPoint(endsObj.start.point);
                                                    ghRouting.addPoint(endsObj.end.point);
                                                    ghRouting.doRequest()
                                                          .then(function(json) {gP.printRouting(json.paths[0]);})
                                                          .catch(function(err) {console.log(err.message);});
                                        }
                                });
                            }
                        });
                    
                
                
                },
                geocodingService : function(){
                    var city=$('#indrGeo').val();
                    $.ajax({
                        url: "https://graphhopper.com/api/1/geocode?q="+city+"&locale=it&debug=true&key=0f9e8ada-ae21-4ae5-a770-92f0677e1897",
                            beforeSend: function(xhrObj){
                                    xhrObj.setRequestHeader("Content-Type","application/json");
                                    xhrObj.setRequestHeader("Accept","application/json");
                            }, 
                            success: function(data){
                                    gP.printGeocoding(data);
                                }
                        });     
                    
                    
                },
                printRouting : function(routeObj)
                {
                    
                    function recalibratePoly(route){
                        var ret=[];
                         $.each(route, function (n_part, part) {
                             ret.push([part[1],part[0]]);
                            });
                        return ret;
                    };
                    var extreme=[routeObj.points.coordinates[0], routeObj.points.coordinates[routeObj.points.coordinates.length-1]];
                    this.clearMap();
                    gP.options.markers.routing.start=L.marker([extreme[0][1], extreme[0][0]]).addTo(gP.options.thisMap);
                    gP.options.markers.routing.end=L.marker([extreme[1][1], extreme[1][0]]).addTo(gP.options.thisMap);
                    console.log(routeObj.points.coordinates);
                    var polyVar=L.polyline(recalibratePoly(routeObj.points.coordinates), {color: 'red'}).addTo(gP.options.thisMap); 
                    gP.options.thisMap.fitBounds(polyVar.getBounds());
                    //console.log(routeObj.paths);
                    //console.log('-------------routing');
                },
                printGeocoding : function (geocodObj)
                {
                    this.clearMap();
                    gP.options.markers.geolocation=L.marker([geocodObj.hits[0].point.lat, geocodObj.hits[0].point.lng]).addTo(gP.options.thisMap);
                },
                
                clearMap : function() {
                        for(i in gP.options.thisMap._layers) {
                            if(gP.options.thisMap._layers[i]._path !== undefined) {
                                try {
                                    gP.options.thisMap.removeLayer(gP.options.thisMap._layers[i]);
                                }
                                catch(e) {
                                    console.log("problem with " + e + gP.options.thisMap._layers[i]);
                                }
                            }
                        }
                        
                        if(gP.options.markers.routing.start!=='')
                        {gP.options.thisMap.removeLayer(gP.options.markers.routing.start);
                         gP.options.thisMap.removeLayer(gP.options.markers.routing.end);
                         gP.options.markers.routing.start='';gP.options.markers.routing.end='';
                        }
                        
                        if(gP.options.markers.geolocation!=='')
                        {
                            gP.options.thisMap.removeLayer(gP.options.markers.geolocation);
                            gP.options.markers.geolocation='';
                        }
                }
                
                
                
                
                };           
        return {mapGrw : gP.index,
                sideGrow : gP.growLeaFletSidebar
                };      
        };
      
      
      
      
      
      
      
      
$(document).ready(function(){
    
    var panel=$.gestPanelLf();
    panel.mapGrw();
       
    
});
   


</script>
</html>    

