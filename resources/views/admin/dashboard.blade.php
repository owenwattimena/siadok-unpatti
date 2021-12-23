@extends('admin.templates.template')

@section('style')
<!-- Leaflet -->
{{-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script> --}}
<link rel="stylesheet" href="https://d19vzq90twjlae.cloudfront.net/leaflet/v0.7.7/leaflet.css" />
<link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css' rel='stylesheet' />

<style>
    #map { height: 650px; }
    .leaflet-popup-content-wrapper{
        border-radius: 0;
    }
    .leaflet-popup-content{
        margin: 0;
    }
    .box-widget{
        width: 300px;
    }
    .leaflet-popup-content .widget-user-2{
        margin-bottom: 0px!important;
    }
    .widget-user-desc, .widget-user-username{
        margin-left: 0!important;
    }
</style>
@endsection

@section('body')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Peta Penempatan Alumni
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li class="active"><i class="fa fa-map"></i> Map</li>
        </ol>
    </section>
    
    <!-- Main content -->
    <section class="content container-fluid">
        
        <div id="map" class="map">

            <div class="modal fade" id="modal-dialog">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">Default Modal</h4>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped">
                            <tr>
                              <th style="width: 10px">#</th>
                              <th>Nama</th>
                              <th>Tempat Kerja</th>
                            </tr>
                            <tbody id="tbody"></tbody>
                          </table>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Kembali</button>
                    </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
              <!-- /.modal -->
        </div>
        
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('script')
<script src="https://d3js.org/d3.v3.min.js"></script>
<script src="https://d19vzq90twjlae.cloudfront.net/leaflet/v0.7.7/leaflet.js"></script>
<script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js'></script>
<script>
    (function() {

        var icon = L.icon({
            iconUrl: `{{ asset('assets/dist/img/pin-star.png') }}`,

            iconSize:     [20, 20], // size of the icon
            // shadowSize:   [50, 64], // size of the shadow
            // iconAnchor:   [22, 94], // point of the icon which will correspond to marker's location
            // shadowAnchor: [4, 62],  // the same for the shadow
            // popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
        });

        var lokasi = @json($lokasi);
        var base_layer, map, mbAttr, mbUrl;
        
        mbAttr = 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community';
        
        mbUrl = 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}';
        
        base_layer = L.tileLayer(mbUrl, {
            id: 'mapbox.streets',
            attribution: mbAttr,
            minZoom: 6,
        });
        
        map = L.map('map', {
            center: [30, 0],
            zoom: 7,
            layers: [base_layer],
        }).setView([-6.0251815, 131.1685883]);
        map.addControl(new L.Control.Fullscreen())

        
        
        for(var key in lokasi){
            var data = lokasi[key];
            let latitude = data.latitude;
            let longitude = data.longitude;
            // map.panBy([0, 3500]);
            L.marker([latitude, longitude], {icon:icon})
                .bindPopup(card(data.lokasi, data.angkatan))
                .addTo(map);
            
        }

    }).call(this);

    function card(lokasi, angkatan)
    {
        var divBoxWidget = document.createElement('div')
        var divWidgetUserHeader = document.createElement('div')
        var divBoxFooter = document.createElement('div')
        var ulNav = document.createElement('ul')
        divBoxWidget.className = 'box box-widget widget-user-2'
        divWidgetUserHeader.className = 'widget-user-header bg-yellow'
        divBoxFooter.className = 'box-footer no-padding'
        ulNav.className = 'nav nav-stacked'

        divWidgetUserHeader.innerHTML = `<h3 class="widget-user-username">${lokasi}</h3>`
        divBoxWidget.appendChild(divWidgetUserHeader)
        divBoxWidget.appendChild(divBoxFooter)
        divBoxFooter.appendChild(ulNav)

        if(Object.keys(angkatan).length > 0){
            for(var key in angkatan){
                if (Object.hasOwnProperty.call(angkatan, key)) {
                var data = JSON.stringify(angkatan[key]);
                var li = document.createElement('li')
                li.dataset.lokasi = lokasi
                li.dataset.angkatan = key 
                li.dataset.alumni = data 
                li.dataset.toggle = 'modal'
                li.dataset.target = '#modal-dialog'
                li.innerHTML = `<a href="#">${key} <span class="pull-right badge bg-blue">${angkatan[key].length} Orang</span></a>`;
                // card += el;
                li.onclick=function(){
                    showDetail(this.dataset.lokasi, this.dataset.alumni, this.dataset.angkatan)
                }

                ulNav.appendChild(li)
                }
            }
        }else{
            var li = document.createElement('li')
            li.style.textAlign = 'center'
            li.style.padding = "50px 15px"
            li.innerHTML = `Oopss...Belum ada alumni di ${lokasi}`;
            ulNav.appendChild(li)
        }


        return divBoxWidget
        // var card = `<div class="box box-widget widget-user-2" style="margin:0;">
        //     <!-- Add the bg color to the header using any of the bg-* classes -->
        //     <div class="widget-user-header bg-yellow">
        //       <h3 class="widget-user-username">${lokasi}</h3>
        //     </div>
        //     <div class="box-footer no-padding">
        //       <ul class="nav nav-stacked">`; 
        //         if(Object.keys(angkatan).length > 0){
        //             for(var key in angkatan){
        //                 var data = angkatan[key];
        //                 var el = document.createElement('li')
        //                 el.innerHTML = `<a href="#">${key} <span class="pull-right badge bg-blue">${angkatan[key].length} Orang</span></a>`;
        //                 card += `<li class="angkatan" data-lokasi='${lokasi}' onclick='` + showDetail(lokasi, data) + `' data-toggle="modal" data-target="#modal-dialog" style="padding-top:` + ((angkatan[key].length < 5) ? '3px' : '8px') + `; padding-bottom:` + ((angkatan[key].length < 5) ? '3px' : '8px') + `;"><a href="#">${key} <span class="pull-right badge bg-blue">${angkatan[key].length} Orang</span></a></li>`;
        //                 // card += el;
        //                 el.onclick=function(){
        //                     console.log(el)
        //                 }
        //             }
        //         }else{
        //             card += `<li style="text-align:center; padding:50px 15px; ">Oopss...Belum ada alumni di ${lokasi}</li>`;
        //         }
        //         card += `</ul>
        //     </div>
        //   </div>`;
        //   return el;
    }
    function _click(e)
    {
        console.log(e);
    }


    function showDetail(lokasi, alumni, angkatan)
    {
        var tbody = '';
        alumni = JSON.parse(alumni)
        for (key in alumni) {
            if (Object.hasOwnProperty.call(alumni, key)) {
                console.log(alumni)
                const element = alumni[key];
                tbody += 
                `<tr>
                    <td>${++key}</td>
                    <td>${element.nama}</td>
                    <td>${element.tempat_kerja}</td>
                </tr>`; 
            }
        }
        $('#tbody').html(tbody); 
        $('.modal-title').text(lokasi + ' - Angkatan ' + angkatan);
    }
</script>
@endsection