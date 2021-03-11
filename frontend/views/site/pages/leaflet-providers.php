<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
	<title></title> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" />
	<link rel="stylesheet" href="/html/leaflet-providers/leaflet-search/leaflet-search.css" />
	<!-- <link rel="stylesheet" href="style.css" /> -->
	<style>

	#desc {
		float: left;
		margin-bottom: 1em;
		position: relative;
		white-space:nowrap;
		font-size:1em;
	}
	html { height: 100% }
	body { height: 100%; margin: 0; padding: 0;}
	#map { height: 100% }
	ul {
		font-size:.85em;
		margin:0;
		padding:0;
	}
	li {
		margin:0 0 2px 18px;
	}

	#ribbon {
		position: absolute;
		top: 0;
		right: 0;
		border: 0;
		filter: alpha(opacity=80);
		-khtml-opacity: .8;
		-moz-opacity: .8;
		opacity: .8;		
	}
	.contents {
		float:left;
		margin:0 2em 2em 0;
	}
	#comments {
		clear:both;
	}


</style>
</head>

<body>

	<link rel="stylesheet" href="css/gh-fork-ribbon.css" />
	<div class="github-fork-ribbon-wrapper left">
		<div class="github-fork-ribbon">
			<a href="https://www.pd-it-solution.com">PD IT SOLUTION</a>
		</div>
	</div>
	<div id="map"></div>



	<script src="https://unpkg.com/jquery@3.3.1/dist/jquery.js"></script>
	<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
	<script src="/html/leaflet-providers/leaflet-search/leaflet-search.js"></script>
	<script src="/html/leaflet-providers/leaflet-providers.js"></script>
	<script>

	//sample data values for populate map
	/*var data = [
	{"loc":[41.575330,13.102411], "title":"aquamarine","iconurl":"https://i.pinimg.com/originals/25/62/aa/2562aacd1a4c2af60cce9629b1e05cf2.png"},
	{"loc":[41.575730,13.002411], "title":"black","iconurl":"https://icon-library.com/images/map-pin-icon-png/map-pin-icon-png-11.jpg"},
	{"loc":[41.807149,13.162994], "title":"blue","iconurl":"https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/OOjs_UI_icon_mapPin-progressive.svg/1024px-OOjs_UI_icon_mapPin-progressive.svg.png"},
	{"loc":[41.507149,13.172994], "title":"chocolate","iconurl":"https://icon-library.com/images/map-pin-icon-png/map-pin-icon-png-11.jpg"},
	{"loc":[41.847149,14.132994], "title":"coral","iconurl":"https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/OOjs_UI_icon_mapPin-progressive.svg/1024px-OOjs_UI_icon_mapPin-progressive.svg.png"},
	{"loc":[41.219190,13.062145], "title":"cyan","iconurl":"https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/OOjs_UI_icon_mapPin-progressive.svg/1024px-OOjs_UI_icon_mapPin-progressive.svg.png"},
	{"loc":[41.344190,13.242145], "title":"darkblue","iconurl":"https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/OOjs_UI_icon_mapPin-progressive.svg/1024px-OOjs_UI_icon_mapPin-progressive.svg.png"},	
	{"loc":[41.679190,13.122145], "title":"darkred","iconurl":"https://icon-library.com/images/map-pin-icon-png/map-pin-icon-png-11.jpg"},
	{"loc":[41.329190,13.192145], "title":"darkgray","iconurl":"https://icon-library.com/images/map-pin-icon-png/map-pin-icon-png-11.jpg"},
	{"loc":[41.379290,13.122545], "title":"dodgerblue","iconurl":"https://icon-library.com/images/map-pin-icon-png/map-pin-icon-png-11.jpg"},
	{"loc":[41.409190,13.362145], "title":"gray","iconurl":"https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/OOjs_UI_icon_mapPin-progressive.svg/1024px-OOjs_UI_icon_mapPin-progressive.svg.png"},
	{"loc":[41.794008,12.583884], "title":"green","iconurl":"https://i.pinimg.com/originals/25/62/aa/2562aacd1a4c2af60cce9629b1e05cf2.png"},	
	{"loc":[41.805008,12.982884], "title":"greenyellow","iconurl":"https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/OOjs_UI_icon_mapPin-progressive.svg/1024px-OOjs_UI_icon_mapPin-progressive.svg.png"},
	{"loc":[41.536175,13.273590], "title":"red","iconurl":"https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/OOjs_UI_icon_mapPin-progressive.svg/1024px-OOjs_UI_icon_mapPin-progressive.svg.png"},
	{"loc":[41.516175,13.373590], "title":"rosybrown","iconurl":"https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/OOjs_UI_icon_mapPin-progressive.svg/1024px-OOjs_UI_icon_mapPin-progressive.svg.png"},
	{"loc":[41.506175,13.173590], "title":"royalblue","iconurl":"https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/OOjs_UI_icon_mapPin-progressive.svg/1024px-OOjs_UI_icon_mapPin-progressive.svg.png"},
	{"loc":[41.836175,13.673590], "title":"salmon","iconurl":"https://i.pinimg.com/originals/25/62/aa/2562aacd1a4c2af60cce9629b1e05cf2.png"},
	{"loc":[41.796175,13.570590], "title":"seagreen","iconurl":"https://icon-library.com/images/map-pin-icon-png/map-pin-icon-png-11.jpg"},
	{"loc":[41.436175,13.573590], "title":"seashell","iconurl":"https://i.pinimg.com/originals/25/62/aa/2562aacd1a4c2af60cce9629b1e05cf2.png"},
	{"loc":[41.336175,13.973590], "title":"silver","iconurl":"https://i.pinimg.com/originals/25/62/aa/2562aacd1a4c2af60cce9629b1e05cf2.png"},
	{"loc":[41.236175,13.273590], "title":"skyblue","iconurl":"https://i.pinimg.com/originals/25/62/aa/2562aacd1a4c2af60cce9629b1e05cf2.png"},
	{"loc":[41.546175,13.473590], "title":"yellow","iconurl":"https://icon-library.com/images/map-pin-icon-png/map-pin-icon-png-11.jpg"},
	{"loc":[41.239190,13.032145], "title":"white","iconurl":"https://i.pinimg.com/originals/25/62/aa/2562aacd1a4c2af60cce9629b1e05cf2.png"}
	]; */
    var data = [
	{"loc":[8.575330,99.102411], "title":"aquamarine","iconurl":"https://i.pinimg.com/originals/25/62/aa/2562aacd1a4c2af60cce9629b1e05cf2.png"},
	{"loc":[8.575730,99.002411], "title":"black","iconurl":"https://icon-library.com/images/map-pin-icon-png/map-pin-icon-png-11.jpg"},
	{"loc":[8.807149,99.162994], "title":"blue","iconurl":"https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/OOjs_UI_icon_mapPin-progressive.svg/1024px-OOjs_UI_icon_mapPin-progressive.svg.png"},
	{"loc":[8.507149,99.172994], "title":"chocolate","iconurl":"https://icon-library.com/images/map-pin-icon-png/map-pin-icon-png-11.jpg"},
	{"loc":[8.847149,99.132994], "title":"coral","iconurl":"https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/OOjs_UI_icon_mapPin-progressive.svg/1024px-OOjs_UI_icon_mapPin-progressive.svg.png"},
	{"loc":[8.219190,99.062145], "title":"cyan","iconurl":"https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/OOjs_UI_icon_mapPin-progressive.svg/1024px-OOjs_UI_icon_mapPin-progressive.svg.png"},
	{"loc":[8.344190,99.242145], "title":"darkblue","iconurl":"https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/OOjs_UI_icon_mapPin-progressive.svg/1024px-OOjs_UI_icon_mapPin-progressive.svg.png"},	
	{"loc":[8.679190,99.122145], "title":"darkred","iconurl":"https://icon-library.com/images/map-pin-icon-png/map-pin-icon-png-11.jpg"},
	{"loc":[8.329190,99.192145], "title":"darkgray","iconurl":"https://icon-library.com/images/map-pin-icon-png/map-pin-icon-png-11.jpg"},
	{"loc":[8.379290,99.122545], "title":"dodgerblue","iconurl":"https://icon-library.com/images/map-pin-icon-png/map-pin-icon-png-11.jpg"},
	{"loc":[8.409190,99.362145], "title":"gray","iconurl":"https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/OOjs_UI_icon_mapPin-progressive.svg/1024px-OOjs_UI_icon_mapPin-progressive.svg.png"},
	{"loc":[8.794008,99.583884], "title":"green","iconurl":"https://i.pinimg.com/originals/25/62/aa/2562aacd1a4c2af60cce9629b1e05cf2.png"},	
	{"loc":[8.805008,99.982884], "title":"greenyellow","iconurl":"https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/OOjs_UI_icon_mapPin-progressive.svg/1024px-OOjs_UI_icon_mapPin-progressive.svg.png"},
	{"loc":[8.536175,103.273590], "title":"red","iconurl":"https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/OOjs_UI_icon_mapPin-progressive.svg/1024px-OOjs_UI_icon_mapPin-progressive.svg.png"},
	{"loc":[8.516175,99.373590], "title":"rosybrown","iconurl":"https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/OOjs_UI_icon_mapPin-progressive.svg/1024px-OOjs_UI_icon_mapPin-progressive.svg.png"},
	{"loc":[8.506175,99.173590], "title":"royalblue","iconurl":"https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/OOjs_UI_icon_mapPin-progressive.svg/1024px-OOjs_UI_icon_mapPin-progressive.svg.png"},
	{"loc":[8.836175,99.673590], "title":"salmon","iconurl":"https://i.pinimg.com/originals/25/62/aa/2562aacd1a4c2af60cce9629b1e05cf2.png"},
	{"loc":[8.796175,99.570590], "title":"seagreen","iconurl":"https://icon-library.com/images/map-pin-icon-png/map-pin-icon-png-11.jpg"},
	{"loc":[8.436175,99.573590], "title":"seashell","iconurl":"https://i.pinimg.com/originals/25/62/aa/2562aacd1a4c2af60cce9629b1e05cf2.png"},
	{"loc":[8.336175,99.973590], "title":"silver","iconurl":"https://i.pinimg.com/originals/25/62/aa/2562aacd1a4c2af60cce9629b1e05cf2.png"},
	{"loc":[8.236175,99.273590], "title":"skyblue","iconurl":"https://i.pinimg.com/originals/25/62/aa/2562aacd1a4c2af60cce9629b1e05cf2.png"},
	{"loc":[8.546175,99.473590], "title":"yellow","iconurl":"https://icon-library.com/images/map-pin-icon-png/map-pin-icon-png-11.jpg"},
	{"loc":[8.239190,99.032145], "title":"white","iconurl":"https://i.pinimg.com/originals/25/62/aa/2562aacd1a4c2af60cce9629b1e05cf2.png"}
	];

	var map = L.map('map', {
			// center: [48, -3],
			center: new L.latLng(data[0].loc),
			zoom: 9,
			zoomControl: false
		})
		// .setView([13.1287311, 100.4424131], 6);

		var defaultLayer = L.tileLayer.provider('OpenStreetMap.Mapnik').addTo(map);

		var baseLayers = {
			'OpenStreetMap Default': defaultLayer,
			'OpenStreetMap German Style': L.tileLayer.provider('OpenStreetMap.DE'),
			'OpenStreetMap H.O.T.': L.tileLayer.provider('OpenStreetMap.HOT'),
			// 'Thunderforest OpenCycleMap': L.tileLayer.provider('Thunderforest.OpenCycleMap'),
			// 'Thunderforest Transport': L.tileLayer.provider('Thunderforest.Transport'),
			// 'Thunderforest Landscape': L.tileLayer.provider('Thunderforest.Landscape'),
			// 'Hydda Full': L.tileLayer.provider('Hydda.Full'),
			'Stamen Toner': L.tileLayer.provider('Stamen.Toner'),
			'Stamen Terrain': L.tileLayer.provider('Stamen.Terrain'),
			'Stamen Watercolor': L.tileLayer.provider('Stamen.Watercolor'),
			// 'Jawg Streets': L.tileLayer.provider('Jawg.Streets'),
			// 'Jawg Terrain': L.tileLayer.provider('Jawg.Terrain'),
			'Esri WorldStreetMap': L.tileLayer.provider('Esri.WorldStreetMap'),
			'Esri DeLorme': L.tileLayer.provider('Esri.DeLorme'),
			'Esri WorldTopoMap': L.tileLayer.provider('Esri.WorldTopoMap'),
			'Esri WorldImagery': L.tileLayer.provider('Esri.WorldImagery'),
			'Esri WorldTerrain': L.tileLayer.provider('Esri.WorldTerrain'),
			'Esri WorldShadedRelief': L.tileLayer.provider('Esri.WorldShadedRelief'),
			'Esri WorldPhysical': L.tileLayer.provider('Esri.WorldPhysical'),
			'Esri OceanBasemap': L.tileLayer.provider('Esri.OceanBasemap'),
			'Esri NatGeoWorldMap': L.tileLayer.provider('Esri.NatGeoWorldMap'),
			'Esri WorldGrayCanvas': L.tileLayer.provider('Esri.WorldGrayCanvas'),
			'Geoportail France Maps': L.tileLayer.provider('GeoportailFrance'),
			'Geoportail France Orthos': L.tileLayer.provider('GeoportailFrance.orthos'),
			'Geoportail France classic maps': L.tileLayer.provider('GeoportailFrance.ignMaps')
		};

		var overlayLayers = {
			'OpenSeaMap': L.tileLayer.provider('OpenSeaMap'),
			// 'OpenWeatherMap Clouds': L.tileLayer.provider('OpenWeatherMap.Clouds'),
			// 'OpenWeatherMap CloudsClassic': L.tileLayer.provider('OpenWeatherMap.CloudsClassic'),
			// 'OpenWeatherMap Precipitation': L.tileLayer.provider('OpenWeatherMap.Precipitation'),
			// 'OpenWeatherMap PrecipitationClassic': L.tileLayer.provider('OpenWeatherMap.PrecipitationClassic'),
			// 'OpenWeatherMap Rain': L.tileLayer.provider('OpenWeatherMap.Rain'),
			// 'OpenWeatherMap RainClassic': L.tileLayer.provider('OpenWeatherMap.RainClassic'),
			// 'OpenWeatherMap Pressure': L.tileLayer.provider('OpenWeatherMap.Pressure'),
			// 'OpenWeatherMap PressureContour': L.tileLayer.provider('OpenWeatherMap.PressureContour'),
			// 'OpenWeatherMap Wind': L.tileLayer.provider('OpenWeatherMap.Wind'),
			// 'OpenWeatherMap Temperature': L.tileLayer.provider('OpenWeatherMap.Temperature'),
			// 'OpenWeatherMap Snow': L.tileLayer.provider('OpenWeatherMap.Snow'),
			'Geoportail France Parcels': L.tileLayer.provider('GeoportailFrance.parcels')
		};

		L.control.layers(baseLayers, overlayLayers, {collapsed: true}).addTo(map);


	var markersLayer = new L.LayerGroup();	//layer contain searched elements
	map.addLayer(markersLayer);

	var controlSearch = new L.Control.Search({layer: markersLayer,position:'topright',initial: false,zoom: 11});

	controlSearch.on('search:locationfound', function(e) {

		//map.removeLayer(this._markerSearch)

		// e.layer.setStyle({fillColor: '#3f0', color: '#0f0'});
		if(e.layer._popup)
			e.layer.openPopup();

	}).on('search:collapsed', function(e) {

		featuresLayer.eachLayer(function(layer) {	//restore feature color
			featuresLayer.resetStyle(layer);
		});	
	});

	map.addControl( controlSearch );

	////////////populate map with markers from sample data
	for(i in data) {
		var title = data[i].title,	//value searched
		icon = data[i].iconurl,
			loc = data[i].loc,		//position found
			marker = new L.Marker(new L.latLng(loc), {title: title,
				icon: new L.Icon({
					iconSize: [50, 50],
					iconAnchor: [25, 45],
					shadowAnchor: [4, 62],
					iconUrl: icon,
				})
			} );
			marker.bindPopup('title: '+ title );
			markersLayer.addLayer(marker);
		}

		$('#textsearch').on('keyup', function(e) {

			controlSearch.searchText( e.target.value );

		});

	// resize layers control to fit into view.
	function resizeLayerControl () {
		var layerControlHeight = document.body.clientHeight - (10 + 50);
		var layerControl = document.getElementsByClassName('leaflet-control-layers-expanded')[0];

			// layerControl.style.overflowY = 'auto';
			// layerControl.style.maxHeight = layerControlHeight + 'px';
		}
		map.on('resize', resizeLayerControl);
		resizeLayerControl();

	</script>


</body>
</html>
