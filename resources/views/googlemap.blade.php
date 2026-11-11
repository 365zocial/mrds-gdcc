<!-- Google Map -->
<script type="text/javascript">

    var latitude = [];
    var longtitude = [];
    var markers = [];
    var area = [];
    var data_map = <?php echo $map ?>;
    //var data_map = [];
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
    
    
 const provincesLatLng = {
  "Bangkok": { lat: 13.7563, lng: 100.5018 },
  "Krabi": { lat: 8.0863, lng: 98.9063 },
  "Kanchanaburi": { lat: 14.0041, lng: 99.5483 },
  "Kalasin": { lat: 16.4320, lng: 103.5061 },
  "Kamphaeng Phet": { lat: 16.4828, lng: 99.5222 },
  "Khon Kaen": { lat: 16.4419, lng: 102.8357 },
  "Chanthaburi": { lat: 12.6113, lng: 102.1039 },
  "Chachoengsao": { lat: 13.6904, lng: 101.0779 },
  "Chon Buri": { lat: 13.3611, lng: 100.9847 },
  "Chai Nat": { lat: 15.1852, lng: 100.1250 },
  "Chaiyaphum": { lat: 15.8064, lng: 102.0313 },
  "Chumphon": { lat: 10.4930, lng: 99.1800 },
  "Chiang Rai": { lat: 19.9100, lng: 99.8406 },
  "Chiang Mai": { lat: 18.7883, lng: 98.9853 },
  "Trang": { lat: 7.5594, lng: 99.6110 },
  "Trat": { lat: 12.2427, lng: 102.5170 },
  "Tak": { lat: 16.8770, lng: 99.1254 },
  "Nakhon Nayok": { lat: 14.2060, lng: 101.2131 },
  "Nakhon Pathom": { lat: 13.8199, lng: 100.0621 },
  "Nakhon Phanom": { lat: 17.3929, lng: 104.7690 },
  "Nakhon Ratchasima": { lat: 14.9799, lng: 102.0977 },
  "Nakhon Si Thammarat": { lat: 8.4324, lng: 99.9631 },
  "Nakhon Sawan": { lat: 15.7030, lng: 100.1372 },
  "Nonthaburi": { lat: 13.8591, lng: 100.5217 },
  "Narathiwat": { lat: 6.4254, lng: 101.8253 },
  "Nan": { lat: 18.7756, lng: 100.7731 },
  "Bueng Kan": { lat: 18.3609, lng: 103.6540 },
  "Buri Ram": { lat: 15.0000, lng: 103.1000 },
  "Pathum Thani": { lat: 14.0208, lng: 100.5250 },
  "Prachuap Khiri Khan": { lat: 11.8137, lng: 99.7983 },
  "Prachin Buri": { lat: 14.0509, lng: 101.3709 },
  "Pattani": { lat: 6.8698, lng: 101.2501 },
  "พระนครศรีอยุธยา": { lat: 14.3532, lng: 100.5684 },
  "Phang-nga": { lat: 8.4512, lng: 98.5253 },
  "Phatthalung": { lat: 7.6145, lng: 100.0809 },
  "Phichit": { lat: 16.4420, lng: 100.3487 },
  "Phitsanulok": { lat: 16.8211, lng: 100.2659 },
  "Phetchaburi": { lat: 13.1115, lng: 99.9390 },
  "Phetchabun": { lat: 16.4182, lng: 101.1606 },
  "Phrae": { lat: 18.1445, lng: 100.1403 },
  "Phayao": { lat: 19.1637, lng: 99.9995 },
  "Phuket": { lat: 7.8804, lng: 98.3923 },
  "Maha Sarakham": { lat: 16.1809, lng: 103.3007 },
  "Mukdahan": { lat: 16.5440, lng: 104.7235 },
  "Mae Hong Son": { lat: 19.3013, lng: 97.9656 },
  "Yala": { lat: 6.5411, lng: 101.2800 },
  "Yasothon": { lat: 15.7922, lng: 104.1452 },
  "Roi Et": { lat: 16.0538, lng: 103.6520 },
  "Ranong": { lat: 9.9529, lng: 98.6085 },
  "Rayong": { lat: 12.7074, lng: 101.1474 },
  "Ratchaburi": { lat: 13.5283, lng: 99.8134 },
  "Lop Buri": { lat: 14.7995, lng: 100.6534 },
  "Lampang": { lat: 18.2888, lng: 99.4907 },
  "Lamphun": { lat: 18.5731, lng: 99.0087 },
  "Loei": { lat: 17.4860, lng: 101.7223 },
  "Si Sa Ket": { lat: 15.1189, lng: 104.3220 },
  "Sakon Nakhon": { lat: 17.1674, lng: 104.1481 },
  "Songkhla": { lat: 7.1756, lng: 100.6144 },
  "Satun": { lat: 6.6238, lng: 100.0674 },
  "Samut Prakarn": { lat: 13.5991, lng: 100.5991 },
  "Samut Songkhram": { lat: 13.4094, lng: 100.0026 },
  "Samut Sakhon": { lat: 13.5472, lng: 100.2744 },
  "Sa kaeo": { lat: 13.8240, lng: 102.0646 },
  "Saraburi": { lat: 14.5289, lng: 100.9103 },
  "Sing Buri": { lat: 14.8868, lng: 100.4017 },
  "Sukhothai": { lat: 17.0060, lng: 99.8250 },
  "Suphan Buri": { lat: 14.4745, lng: 100.1200 },
  "Surat Thani": { lat: 9.1382, lng: 99.3210 },
  "Surin": { lat: 14.8829, lng: 103.4937 },
  "Nong Khai": { lat: 17.8783, lng: 102.7413 },
  "Nong Bua Lam Phu": { lat: 17.2047, lng: 102.4400 },
  "Ang Thong": { lat: 14.5896, lng: 100.4550 },
  "Amnat Charoen": { lat: 15.8631, lng: 104.6348 },
  "Udon Thani": { lat: 17.4157, lng: 102.7859 },
  "Uttaradit": { lat: 17.6254, lng: 100.0993 },
  "Uthai Thani": { lat: 15.3794, lng: 100.0267 },
  "Ubon Ratchathani": { lat: 15.2447, lng: 104.8473 }
};
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          zoom: 6,
          center: init_map[0],
          mapTypeId: google.maps.MapTypeId.roadmap
        }); 
/*
        new google.maps.Marker({
            position: init_map[0],
            map,
        });
*/

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
/*
            if(data_map['latitude'] && data_map['longitude'] && !isNaN(Number(data_map['latitude'])) && !isNaN(Number(data_map['longitude']))){
                markers[count] = {
                    "position": {"lat": Number(data_map['latitude']), "lng": Number(data_map['longitude']) },
                    "icon": icons[i%20]
                };
            }
*/
            if(data_map['province_en']){
                markers[count] = {
                    "position": getLatLngByProvince(data_map['province_en']),
                    "icon": 'https://img5.pic.in.th/file/secure-sv1/red_pin.png'
                };
            }
            if( Number(data_map['start_latitude']) != "" && !isNaN(Number(data_map['start_longitude'])) && !isNaN(Number(data_map['end_latitude']))&& Number(data_map['end_longitude']) ){
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

    function getLatLngByProvince(provinceName) {
        //console.log(provinceName);
        const latLng = provincesLatLng[provinceName];
        if (latLng) {
            return latLng;
        } else {
            return "จังหวัดไม่ถูกต้อง หรือไม่มีข้อมูล";
        }
    }

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
