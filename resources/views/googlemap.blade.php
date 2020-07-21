<!-- Google Map -->
<script type="text/javascript">

    var latitude = [];
    var longtitude = [];
    var markers = [];
    var area = [];
    var data_map = <?php echo $map ?>;
    var map_type = "<?php echo $map_type ?>";
    var map;
    var info = [];
    var init_map = [{lat: 10.273242, lng: 99.917012}];
    var stack_marker = [];
    var stack_info = [];
    var stack_polygon = [];
    var color_fill = ['#FF0000','#0000ff','#00cc00','#ff3399','#000000','#006699','#cc00cc','#ff9900','#00ffff','#999966'];
    var count = 0;
    var icons = ["{{url('assets/images/icon_map_marker/red_pin_1.png')}}","{{url('assets/images/icon_map_marker/red_pin_2.png')}}","{{url('assets/images/icon_map_marker/red_pin_3.png')}}","{{url('assets/images/icon_map_marker/red_pin_4.png')}}","{{url('assets/images/icon_map_marker/red_pin_5.png')}}","{{url('assets/images/icon_map_marker/red_pin_6.png')}}","{{url('assets/images/icon_map_marker/red_pin_7.png')}}","{{url('assets/images/icon_map_marker/red_pin_8.png')}}","{{url('assets/images/icon_map_marker/red_pin_9.png')}}","{{url('assets/images/icon_map_marker/red_pin_10.png')}}","{{url('assets/images/icon_map_marker/red_pin_11.png')}}","{{url('assets/images/icon_map_marker/red_pin_12.png')}}","{{url('assets/images/icon_map_marker/red_pin_13.png')}}","{{url('assets/images/icon_map_marker/red_pin_14.png')}}","{{url('assets/images/icon_map_marker/red_pin_15.png')}}","{{url('assets/images/icon_map_marker/red_pin_16.png')}}","{{url('assets/images/icon_map_marker/red_pin_17.png')}}","{{url('assets/images/icon_map_marker/red_pin_18.png')}}","{{url('assets/images/icon_map_marker/red_pin_19.png')}}","{{url('assets/images/icon_map_marker/red_pin_20.png')}}"];
    
    
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          zoom: 6,
          center: init_map[0],
          mapTypeId: google.maps.MapTypeId.roadmap
        });

        //request 4 if marker more than 20 show text
        if(data_map!== null && data_map.length > 20){
          $('#map').before('It is complicate to display, plase scaledown your searching') 
        } 

    }
    
    
    
    $.each(data_map, function(i, data_map){
        if(i < 20){
            if(data_map['related_catalog_item'] != null){
                var id_related = data_map['related_catalog_item'];
            }else if(data_map['related_reference_item'] != null){
                var id_related = data_map['related_reference_item'];
            }
            info[i] = id_related;
            if(data_map['latitude'] && data_map['longitude']){
                markers[count] = {
                    "position": {"lat": Number(data_map['latitude']), "lng": Number(data_map['longitude']) },
                    "icon": icons[i%20]
                };
                
                
                
            }
            if( Number(data_map['start_latitude']) != "" && Number(data_map['start_longitude']) != "" && Number(data_map['end_latitude']) != "" && Number(data_map['end_longitude']) ){
                area[count] = [
                            {lat: Number(data_map['start_latitude']), lng: Number(data_map['start_longitude'])},
                            {lat: Number(data_map['start_latitude']), lng: Number(data_map['end_longitude'])},
                            {lat: Number(data_map['end_latitude']), lng: Number(data_map['end_longitude'])},
                            {lat: Number(data_map['end_latitude']), lng: Number(data_map['start_longitude'])}
                        ];
            }else{
                area[count] = null;
            }
       }
       count++;
    });

    setTimeout( function(){
        if(map_type == "point"){
            clearMarkers();
            clearPolygon();
            plotMarker();
        }else if(map_type == "area"){
            clearMarkers();
            clearPolygon();
            plotPolygon();
        }
    }, 5000);

    //---------------- Marker -------------------
    function plotMarker(){
        for(var i = 0; i < markers.length; i++){
            if(markers[i]){
            addMarkers(markers[i].position, i,markers[i].icon);
            }
        }
        markers = [];
    }

    function addMarkers(latlng, i,icon){
        var marker = new google.maps.Marker({
          map: map,
          animation: google.maps.Animation.DROP,
          position: latlng,
          icon: icon
        });

        var infowindow = new google.maps.InfoWindow;

        setInfo(map, marker, infowindow, info[i]);

        stack_marker.push(marker);
    }

    function clearMarkers() {
        for (var i = 0; i < stack_marker.length; i++) {
            stack_marker[i].setMap(null);
        }
        stack_marker = [];
    }
    //---------------- Marker [Point] -------------------

    //---------------- Polygon [Area] -------------------

    function plotPolygon(){
        for(var i = 0; i < area.length; i++){
            if(area[i] != null){
                addPolygon(area[i], color_fill[i], i);
            }
        }
        area = [];
    }

    function addPolygon(area, color, i){
        var area_record = new google.maps.Polygon({
            paths: area,
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: color,
            fillOpacity: 0.35
        });

        var infowindow = new google.maps.InfoWindow;

        setInfo_area(area, area_record, infowindow, info[i]);

        stack_polygon.push(area_record);
        area_record.setMap(map);
    }

    function clearPolygon(){
        for (var i = 0; i < stack_polygon.length; i++) {
            stack_polygon[i].setMap(null);
        }
        stack_polygon = [];
    }

    //---------------- Polygon [Area] -------------------

    //---------------- Info ------------------//
    function setInfo(map, marker, infoWindow, info){
        marker.addListener('click', function() {
            for (var j=0;j<stack_info.length;j++) {
                stack_info[j].close();
            }
            infoWindow.setContent(info);
            infoWindow.open(map, marker);
            stack_info.push(infoWindow);
        });
    }

    function setInfo_area(area, area_record, infoWindow, info){
        area_record.addListener('click', function(event) {
            for (var j=0;j<stack_info.length;j++) {
                stack_info[j].close();
            }
            infoWindow.setContent(info);
            infoWindow.setPosition(event.latLng);
            infoWindow.open(map);
            stack_info.push(infoWindow);
        });
    }
</script>
