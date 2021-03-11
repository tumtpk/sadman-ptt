<input type="text" id="latitude">
<input type="text" id="longitude">

<div class="col-xl-8 col-lg-12">
	<div class="card">
		<div class="card-header">
			<h3 class="card-title"><dt>แผนที่ระบุพิกัด (ละติจูด , ลองจิจูด)</dt></h3>
			<div class="card-options">
				<a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
				<a href="#" class="card-options-fullscreen" data-toggle="card-fullscreen"><i class="fe fe-maximize"></i></a>
			</div>
		</div>
		<div class="card-body">
			<link
			data-require="leaflet@0.7.3"
			data-semver="0.7.3"
			rel="stylesheet"
			href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.3/leaflet.css"
			/>
			<script
			data-require="leaflet@0.7.3"
			data-semver="0.7.3"
			src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.3/leaflet.js"
			></script>


			<div id="mapid" style="width: 100%; height: 500px;"></div>    
			<script>

				var mymap = L.map('mapid').setView([13.732564, 100.515000], 5);

        //'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw'

        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
        	maxZoom: 19,
        	attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
        	'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
        	'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        	id: 'mapbox/streets-v11',
        	tileSize: 512,
        	zoomOffset: -1
        }).addTo(mymap);



        var popup = L.popup();

        function onMapClick(e) {
        	popup
        	.setLatLng(e.latlng)
        	.setContent("ตำแหน่งที่ตั้ง " + e.latlng.toString())
        	.openOn(mymap);
        	var latlng = e.latlng.toString().replace('LatLng(', "");
        	latlng = latlng.toString().replace(')', "");
        	latlng = latlng.toString().split(",");
        	document.getElementById('latitude').value = latlng[0];
        	document.getElementById('longitude').value = latlng[1];
        }

        mymap.on('click', onMapClick);

    </script>
</div>
</div>
</div>


<div class="col-xl-8 col-lg-12">
	<div class="card">
		<div class="card-header">
			<h3 class="card-title"><dt>แผนที่ระบุพิกัด (ละติจูด , ลองจิจูด)</dt></h3>
			<div class="card-options">
				<a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
				<a href="#" class="card-options-fullscreen" data-toggle="card-fullscreen"><i class="fe fe-maximize"></i></a>
			</div>
		</div>
		<div class="card-body">
			<div id="mapshow" style="width: 100%; height: 500px;"></div>    
        <script>

        var mymap = L.map('mapshow').setView([17.64402,  102.15088], 10);

        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
            maxZoom: 15,
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1
        }).addTo(mymap);

        L.marker([17.64402,  102.15088]).addTo(mymap)
            .bindPopup("<b>55").openPopup();

        // L.circle([17.64402,  102.15088], 20000, {
        //     color: 'red',
        //     fillColor: '#f03',
        //     fillOpacity: 0.5
        // }).addTo(mymap).bindPopup("I am a circle.");

        var popup = L.popup();


        </script>
		</div>
	</div>
</div>

