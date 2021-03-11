<div class="row">
    <div class="pp col-lg-8 col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">แผนที่</h3>
                            <div class="card-options"></div>
                        </div>
                        <div class="card-body">
                            <link data-require="leaflet@0.7.3" data-semver="0.7.3" rel="stylesheet" href="../../leaflet-0.7.3/leaflet.css" />
                            <script data-require="leaflet@0.7.3" data-semver="0.7.3" src="../../leaflet-0.7.3/leaflet.js"></script>
                            <div id="mapshow" style="border-radius: 5px;
                        width: 100%;
                        height: 490px;
                        margin-top: 11px;"></div>
                        </div>
                    </div>
    </div>
    <div class="pp col-lg-4 col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">ข้อมูล</h3>
                            <div class="card-options"></div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="card">
                                    <div class="card-body" style="background-color: #77B6EA">
                                        <h5>เคสสะสม</h5>
                                        <h4>35</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="card">
                                    <div class="card-body" style="background-color: #44bf13">
                                        <h5>เคสแก้ไขแล้ว</h5>
                                        <h4>40</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="card">
                                    <div class="card-body" style="background-color: #fff019">
                                        <h5>เคสคงค้าง</h5>
                                        <h4>20</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="card">
                                    <div class="card-body" style="background-color: #ff0505">
                                        <h5>เคสใหม่</h5>
                                        <h4>15</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    </div>
</div>
<script src='https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.js'></script>
<script>
   mapboxgl.accessToken = 'pk.eyJ1Ijoid2ljMDE0NCIsImEiOiJja20zbmY2dzMyNzhlMnNseThpejE4ajA5In0.h5Df-2IwkGWQNMxS-Mgujg';
   var map = new mapboxgl.Map({
      container: 'mapshow',
      style: 'mapbox://styles/wic0144/ckm3qzk7e0sq617q3k2jb4iy7',
      interactive: true,
      attributionControl: false,
      maxZoom:20,
      minZoom:5,
   });
   map.on('style.load', function() {
   map.on('click', function(e) {
   var coordinates = e.lngLat;
   new mapboxgl.Popup()
   .setLngLat(coordinates)
   .setHTML('you clicked here:' + coordinates)
   .addTo(map);
   });
   });
</script>