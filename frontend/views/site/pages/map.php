<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
   integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
   crossorigin=""/>

        <!-- Make sure you put this AFTER Leaflet's CSS -->
        <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
        integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
        crossorigin=""></script>   
        
                      
                   
        <div class="section-body mt-3">
            <div class="container-fluid">
                <div class="row clearfix">
                    <div class="col-lg-12">
                    <div class="row clearfix">
                            <div class="col-lg-3 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                    <h6>ข้อมูลทั้งหมด </h6>
                                    <h3 class="pt-3"><span class="counter">18,960</span></h3>
                                    <span><span class="text-danger mr-2"><i class="fa fa-long-arrow-down"></i> 5.27%</span> Since last month</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                    <h6>ข้อมูลที่นำมาแสดงบนแผนที่ได้</h6>
                                    <h3 class="pt-3"><span class="counter">11,783</span></h3>
                                    <span><span class="text-success mr-2"><i class="fa fa-long-arrow-up"></i> 11.38%</span> Since last month</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                    <h6>ข้อมูลที่ไม่มีพิกัดบนแผนที่</h6>
                                    <h3 class="pt-3"><span class="counter">2,254</span></h3>
                                    <span><span class="text-success mr-2"><i class="fa fa-long-arrow-up"></i> 9.61%</span> Since last month</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                    <h6>ข้อมูลอื่น</h6>
                                    <h3 class="pt-3"><span class="counter">8,751</span></h3>
                                    <span><span class="text-danger mr-2"><i class="fa fa-long-arrow-down"></i> 2.27%</span> Since last month</span>
                                        
                                </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Recently Accessed Files</h3>
                                
                            </div>
                            <div class="card-body">
                                <div class="file_folder">
                                        <!--  -->
        <div id="mapid" style="width: 100%; height: 800px;"></div>    
        <script>

        var mymap = L.map('mapid').setView([8.55665, 99.6767776], 13);

        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
            maxZoom: 9,
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1
        }).addTo(mymap);

        L.marker([8.75665, 99.4767779]).addTo(mymap)
            .bindPopup("<b>Hello world!</b><br />I am a popup.").openPopup();

        L.circle([8.55665, 99.6767776], 9000, {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5
        }).addTo(mymap).bindPopup("I am a circle.");

        L.polygon([
            [8.446858, 99.936786],
            [8.292650, 99.741092],
            [8.353118, 100.171275],
        ]).addTo(mymap).bindPopup("I am a polygon.");


        var popup = L.popup();

        function onMapClick(e) {
            popup
                .setLatLng(e.latlng)
                .setContent("You clicked the map at " + e.latlng.toString())
                .openOn(mymap);
        }

        mymap.on('click', onMapClick);

        </script>

                                        <!--  -->
                                        
                                </div>
                            </div>
                        </div>
                        <div class="card bg-none b-none">
                            <div class="card-body pt-0">
                                <div class="table-responsive">
                                    <table class="table table-hover table-vcenter table_custom text-nowrap spacing5 text-nowrap mb-0">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Name</th>
                                                <th>Share With</th>
                                                <th>Owner</th>
                                                <th>Last Update</th>
                                                <th>File Size</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="width45">
                                                    <i class="fa fa-folder"></i>
                                                </td>
                                                <td>
                                                    <span class="folder-name">Work</span>
                                                </td>
                                                <td>
                                                    <div class="avatar-list avatar-list-stacked">
                                                        <img class="avatar avatar-sm" src="../assets/images/xs/avatar1.jpg" data-toggle="tooltip" title="Avatar"/>
                                                        <img class="avatar avatar-sm" src="../assets/images/xs/avatar2.jpg" data-toggle="tooltip" title="Avatar"/>
                                                        <img class="avatar avatar-sm" src="../assets/images/xs/avatar3.jpg" data-toggle="tooltip" title="Avatar"/>
                                                    </div>
                                                </td>
                                                <td class="width100">
                                                    <span>Me</span>
                                                </td>
                                                <td class="width100">
                                                    <span>Oct 7, 2018</span>
                                                </td>
                                                <td class="width100 text-center">
                                                    <span class="size"> - </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="width45">
                                                    <i class="fa fa-folder"></i>
                                                </td>
                                                <td>
                                                    <span class="folder-name">Family</span>
                                                </td>
                                                <td>
                                                    -
                                                </td>
                                                <td class="width100">
                                                    <span>Me</span>
                                                </td>
                                                <td class="width100">
                                                    <span>Oct 17, 2018</span>
                                                </td>
                                                <td class="width100 text-center">
                                                    <span class="size"> - </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="width45">
                                                    <i class="fa fa-folder text-danger"></i>
                                                </td>
                                                <td>
                                                    <span class="folder-name">Holidays</span>
                                                </td>
                                                <td>
                                                    -
                                                </td>
                                                <td class="width100">
                                                    <span>John</span>
                                                </td>
                                                <td class="width100">
                                                    <span>Oct 18, 2018</span>
                                                </td>
                                                <td class="width100 text-center">
                                                    <span class="size"> 50MB </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="width45">
                                                    <i class="fa fa-folder"></i>
                                                </td>
                                                <td>
                                                    <span class="folder-name">Mobile Work </span>
                                                </td>
                                                <td>
                                                    -
                                                </td>
                                                <td class="width100">
                                                    <span>Me</span>
                                                </td>
                                                <td class="width100">
                                                    <span>April 7, 2019</span>
                                                </td>
                                                <td class="width100 text-center">
                                                    <span class="size"> 1GB </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="width45">
                                                    <i class="fa fa-folder"></i>
                                                </td>
                                                <td>
                                                    <span class="folder-name">Photoshop Data</span>
                                                </td>
                                                <td>
                                                    <div class="avatar-list avatar-list-stacked">
                                                        <img class="avatar avatar-sm" src="../assets/images/xs/avatar1.jpg" data-toggle="tooltip" title="Avatar"/>
                                                        <img class="avatar avatar-sm" src="../assets/images/xs/avatar2.jpg" data-toggle="tooltip" title="Avatar"/>
                                                    </div>
                                                </td>
                                                <td class="width100">
                                                    <span>Andrew</span>
                                                </td>
                                                <td class="width100">
                                                    <span>Nov 23, 2019</span>
                                                </td>
                                                <td class="width100 text-center">
                                                    <span class="size"> - </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="width45">
                                                    <i class="fa fa-folder text-danger"></i>
                                                </td>
                                                <td>
                                                    <span class="folder-name">Holidays</span>
                                                </td>
                                                <td>
                                                    <div class="avatar-list avatar-list-stacked">
                                                        <img class="avatar avatar-sm" src="../assets/images/xs/avatar5.jpg" data-toggle="tooltip" title="Avatar"/>
                                                        <img class="avatar avatar-sm" src="../assets/images/xs/avatar6.jpg" data-toggle="tooltip" title="Avatar"/>
                                                        <img class="avatar avatar-sm" src="../assets/images/xs/avatar1.jpg" data-toggle="tooltip" title="Avatar"/>
                                                        <img class="avatar avatar-sm" src="../assets/images/xs/avatar4.jpg" data-toggle="tooltip" title="Avatar"/>
                                                    </div>
                                                </td>
                                                <td class="width100">
                                                    <span>Me</span>
                                                </td>
                                                <td class="width100">
                                                    <span>Dec 5, 2018</span>
                                                </td>
                                                <td class="width100 text-center">
                                                    <span class="size"> 100MB </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="width45">
                                                    <i class="fa fa-file-excel-o text-success"></i>
                                                </td>
                                                <td>
                                                    <span class="folder-name">new timesheet.xlsx</span>
                                                </td>
                                                <td>
                                                    -
                                                </td>
                                                <td class="width100">
                                                    <span>Me</span>
                                                </td>
                                                <td class="width100">
                                                    <span>Dec 5, 2018</span>
                                                </td>
                                                <td class="width100 text-center">
                                                    <span class="size"> 52KB </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="width45">
                                                    <i class="fa fa-file-word-o text-warning"></i>
                                                </td>
                                                <td>
                                                    <span class="folder-name">new project.doc</span>
                                                </td>
                                                <td>
                                                    -
                                                </td>
                                                <td class="width100">
                                                    <span>Me</span>
                                                </td>
                                                <td class="width100">
                                                    <span>May 5, 2019</span>
                                                </td>
                                                <td class="width100 text-center">
                                                    <span class="size"> 152KB </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="width45">
                                                    <i class="fa fa-file-pdf-o text-warning"></i>
                                                </td>
                                                <td>
                                                    <span class="folder-name">report.pdf</span>
                                                </td>
                                                <td>
                                                    -
                                                </td>
                                                <td class="width100">
                                                    <span>Me</span>
                                                </td>
                                                <td class="width100">
                                                    <span>May 2, 2019</span>
                                                </td>
                                                <td class="width100 text-center">
                                                    <span class="size"> 841KB </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="width45">
                                                    <i class="fa fa-file-pdf-o text-warning"></i>
                                                </td>
                                                <td>
                                                    <span class="folder-name">report-2018.pdf</span>
                                                </td>
                                                <td>
                                                    -
                                                </td>
                                                <td class="width100">
                                                    <span>Me</span>
                                                </td>
                                                <td class="width100">
                                                    <span>Oct 16, 2018</span>
                                                </td>
                                                <td class="width100 text-center">
                                                    <span class="size"> 541KB </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
<script src="../assets/bundles/lib.vendor.bundle.js"></script>

<script src="../assets/js/core.js"></script>
