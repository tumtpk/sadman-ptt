<!doctype html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" 
	integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

	<title>TextX : Elasticsearch</title>
	<style>
	.spannum{margin-top: 3px;font-size: 12px;color: #6c757dc7;float: right;}
	.label-checkbox{
		margin-left: 0.5em;
	}
        pre {padding: 5px; margin: 5px; color: #343a40d1 !important; /*outline: 1px solid #ccc;*/}
        .string { color: green; }
        .number { color: blue; }
        .boolean { color: firebrick; }
        .null { color: magenta; }
        .key {     color: #343a40d1;
	font-weight: 600; }
	.saveupdate{
		display: none;
	}
	.filemarker_latlong{
		display: none;
	}
	.change-padding-left{
		padding-left: 0px !important;
	}
	@media screen and (max-width: 600px) {
		.change-padding-left{
			padding-left: 15px !important;
		}
	}
	.highlight {
		color: #212529;
		background-color: #ffc107;
		border-radius: 5px;
		padding: 0em;
		font-weight: bold;
		font-size: 16px;
	}
</style>
</head>
<body>


	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<a class="navbar-brand" href="#">TextX : Elasticsearch</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">				
			</ul>
			
		</div>
	</nav>

	<div class="container-fluid">
		<div class="row mt-5">
			<div class="col-md-11">
				<input class="form-control" id="txt" type="search" placeholder="Search" aria-label="Search"> 
				<!-- onChange="searchText(this.value);" -->
			</div>
			<div class="col-md-1 change-padding-left">
				<button class="btn btn-primary btn-block" type="button" onClick="searchText(txt.value);">ค้นหา</button>
			</div>
		</div>

		<div class="row">
			<div class="col-md-3">
				<small>
					<dt>
						<label for="sel1" class="mt-3">SORT BY</label>
					</dt>
				</small>
				<!-- <select class="form-control">
					<option>Relevance</option>
					<option>Title</option>
				</select> -->
				<!-- Gender -->
					<small>
						<dt>
							<label for="sel1" class="mt-3">เพศ</label>
						</dt>
					</small>
					<div class="custom-checkbox mt-1">
						<ul class="list-inline">
									<!-- <li>
										<input type="radio" id="all" name="checkdatainput" class="checkdatainput" value="">
										<label for="all" class="label-checkbox">All</label>
										<span class="spannum">1</span>
									</li> -->
									<li><input type="checkbox" id="Male" name="checkdatainput" class="checkdatainput" value="ชาย">
										<label for="Male" class="label-checkbox">ชาย</label>
										<span class="spannum">3</span>
									</li>
									<li>
										<input type="checkbox" id="Female" name="checkdatainput" class="selectcheckbox checkdatainput" value="หญิง">
										<label for="Female" class="label-checkbox">หญิง</label>
										<span class="spannum">2</span>
									</li>
						</ul>
					</div>

					<!--  Type -->
					<small>
						<dt>
							<label for="sel1" class="mt-3">ประเภทข้อมูล</label>
						</dt>
					</small>
					<div class="custom-checkbox mt-1">
						<ul class="list-inline">
									<? $data = array("news"=>"กระดานข่าว" , "inquire_report"=>"รายงานซักถาม","suspect_object"=>"วัตถุต้องสงสัย" , "suspect_person"=>"บุคคลต้องสงสัย" , "surveillance_person"=>"บุคคลเฝ้าระวังเป็นพิเศษ" , "deceased"=>"บุคคลเสียชีวิต" , "urgent"=>"เหตุด่วนอื่นๆ" , "equiptment"=>"บันทึกข้อมูลอุปกรณ์" , "undercover"=>"บันทึกข้อมูลสายข่าว");
									?>

									<li><input type="checkbox" id="Male" name="checkdatainput" class="checkdatainput" value="ชาย">
										<label for="Male" class="label-checkbox">ข่าวด่วน</label>
										<span class="spannum">3</span>
									</li>

									<li>
										<input type="checkbox" id="Female" name="checkdatainput" class="selectcheckbox checkdatainput" value="หญิง">
										<label for="Female" class="label-checkbox">บุคคลเสียชีวิต</label>
										<span class="spannum">2</span>
									</li>
						</ul>
					</div>
					<!-- Type  -->

				</div>
				<div class="col-md-9">
					<div class="row mt-3">
						<div class="col-md-10">
							<div id="show_result_text" class="mt-3"></div>
						</div>
						<div class="col-md-2 text-right">
							<small style="display: inline-block;">Show : </small>
							<select class="form-control changelimitdata" style="width: 85px;display: inline-block;">
								<option value="50">50</option>
								<option value="100">100</option>
								<option value="500">500</option>
								<option value="1000">1000</option>
							</select>
						</div>
					</div>

					<div id="showdata" class="mt-3"></div>
					<div class="mt-4 show-pagination">
						<nav aria-label="Page navigation example">
							<ul class="pagination">

							</ul>
						</nav>
					</div>
				</div>

			</div>
		</div>

		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script language="javascript">
			//var url = "http://119.59.113.234:9200/persondead/_search";
			var url = "http://192.168.1.37:9200/textxdb/_search";
			var attive_page = 1;
			var limit = 50;
			var from_start = 0;
			var from_end = limit;
			var checkdatainput = '';

			$(document).ready(function(){
				notsearch();
			});

			$(document).on('click', '.checkdatainput', function(){
				checkdatainput = $("input[type='radio'].checkdatainput:checked").val();
				var txt = $("#txt").val();
				if (txt==='') {
					notsearch();
				}else{
					searchText(txt);
				}
			});

			$(document).on('change', '.changelimitdata', function(){
				var newlimit = $(this).val();
				limit = newlimit;
				from_end = limit;
				from_start = 0;
				attive_page = 1;
				var txt = $("#txt").val();
				if (txt==='') {
					notsearch();

				}else{
					searchText(txt);
				}
			});

			function notsearch(){
				var showdata = [];
				if (checkdatainput!='') {
					var newData = {
						"query": {
							"bool": {
								"must": [
								{
									"match": {
										"gender": checkdatainput
									}
								}
								]
							}
						},
						"size": limit,
						"from": 0,
						"highlight": {
							"fields" : {
								"name" : {}
							}
						}
					};
					var match = {
						source: JSON.stringify(newData),
						source_content_type: "application/json"  
					};
				}else{
					var match = { size:limit };
				}
				$.ajax({
					method: "GET",
					url: url,
					crossDomain: true,
					data: match

				})
				.done(function( msg ) {
					var data = msg.hits.hits;
					for (i = 0; i < data.length; i++) {
						var showjson = JSON.stringify(data[i]._source, undefined, 4);
						showdata.push(`<div class="card mt-4">
							<div class="card-body">
							<pre>${syntaxHighlight(showjson)}</pre>
							</div>
							</div>
							`);
					}

					$("#showdata").html(showdata.join(""));

					checktotal_data('');
				});
			}



			function syntaxHighlight(json) {
				json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
				return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function (match) {
					var cls = 'number';
					if (/^"/.test(match)) {
						if (/:$/.test(match)) {
							cls = 'key';
						} else {
							cls = 'string';
						}
					} else if (/true|false/.test(match)) {
						cls = 'boolean';
					} else if (/null/.test(match)) {
						cls = 'null';
					}
					return '<span class="' + cls + '">' + match + '</span>';
				});
			}

			function highlight(key,text) {
				var innerHTML = text.toLowerCase();
				var innerHTML_nolow = text;
				var index = innerHTML.indexOf(key.toLowerCase());
				if (index >= 0) { 
					innerHTML_nolow = innerHTML_nolow.substring(0,index) + "<span class='highlight'>" + innerHTML_nolow.substring(index,index+key.length) + "</span>" + innerHTML_nolow.substring(index + key.length);
				}
				return innerHTML_nolow;
			}


			var txt = document.getElementById("txt");
			txt.addEventListener("keydown", function (e) {
				if (e.keyCode === 13) {
					searchText(txt.value);
				}
			});

			function searchText(v){
				from_start = 0;
				if (v==='') {
					$(".pagination").html('');
					$("#showdata").html(` <div class="alert alert-danger alert-dismissible fade show">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>Danger!</strong> Please enter a search term.
						</div>`);
				}else{
					var showdata = [];

					if (checkdatainput!='') {
						var match = [
						{
							"multi_match": {
								"query" : v,
							}
						},
						{
							"match": {
								"gender": checkdatainput
							}
						}
						];
					}else{
						var match = [
						{
							"multi_match": {
								"query" : v,
							}
						}
						];
					}
					var newData = {
						"query": {
							"bool": {
								"must": match
							}
						},
						"size": limit,
						"from": 0,
						"highlight": {
							"fields" : {
								"name" : {}
							}
						}
					};


					var dataJson = JSON.stringify(newData);
					$.ajax({
						method: "GET",
						url: url,
						crossDomain: true,

						data: {
							source: JSON.stringify(newData),
							source_content_type: "application/json"  
						},
						error: function(e) {
							console.log(e);
						},
						dataType: "json",
						contentType: "application/json"

					})
					.done(function( msg ) {
						var data = msg.hits.hits;
						var len = data.length;
						for (i = 0; i < len; i++) {
							var showjson = JSON.stringify(data[i]._source, undefined, 4);
							var show = highlight(v,'<pre>'+syntaxHighlight(showjson)+'</pre>');
							showdata.push(`<div class="card mt-4">
								<div class="card-body">
								${show}
								</div>
								</div>
								`);
						}
						var result_text = 'Result of "<font color="blue">'+ v +'</font>" is '+len + ' record(s)';
						$("#showdata").html(showdata.join(""));
						checktotal_data(v);
						attive_page = 1;
					});
				}
			}

			function checktotal_data(q){
				if (q==='') {
					if (checkdatainput!='') {
						var newData = {
							"query": {
								"bool": {
									"must": [
									{
										"match": {
											"gender": checkdatainput
										}
									}
									]
								}
							},
							"size": limit,
							"from": 0,
							"highlight": {
								"fields" : {
									"name" : {}
								}
							}
						};
						var match = {
							source: JSON.stringify(newData),
							source_content_type: "application/json"  
						};
					}else{
						var match = null;
					}
					var data = match;
				}else{
					if (checkdatainput!='') {
						var match = [
						{
							"multi_match": {
								"query" : q,
							}
						},
						{
							"match": {
								"gender": checkdatainput
							}
						}
						];
					}else{
						var match = [
						{
							"multi_match": {
								"query" : q,
							}
						}
						];
					}
					var newData = {
						"query": {
							"bool": {
								"must": match
							}
						},
						"size": limit,
						"from": 0,
						"highlight": {
							"fields" : {
								"name" : {}
							}
						}
					};
					var data = {
						source: JSON.stringify(newData),
						source_content_type: "application/json"  
					};
				}
				$.ajax({
					method: "GET",
					url: url,
					data: data
				})
				.done(function( msg ) {
					pagiantion_data(msg.hits.total.value);
					result_text(msg.hits.total.value,q)
				});
			}


			function result_text(total,q){
				if (q==='') {
					var data = `<small>Showing <b>${parseInt(from_start+1)} - ${from_end}</b> out of <b>${total}</b></small>`;
				}else{
					var end_record = from_end;
					if (total<from_end) {
						end_record = total;
					}
					var data = `
					Result of <b>"<span style="color:#0062cc;font-weight:bold;">${q}</span>"</b> is ${total} record(s)
					<br>
					<small>Showing <b>${parseInt(from_start+1)} - ${end_record}</b> out of <b>${total}</b></small>
					`;
				}
				$("#show_result_text").html(data);
			}

			function pagiantion_data(total){
				if (total>limit) {
					var pageattive = '';
					var Previous = 0;
					var Next = 0;
					var pagenum = parseInt(total)/parseInt(limit);
					var page = pagenum.toFixed();
					if (parseInt(attive_page)-1<=0) {
						Previous = 1;
					}else{
						Previous = attive_page-1;
					}

					if (parseInt(attive_page)+1>pagenum) {
						Next = attive_page;
					}else{
						Next = attive_page+1;
					}
					var show_pagination = `<li class="page-item changenewpage" data-pagenum="${Previous}">
					<a class="page-link" href="#" aria-label="Previous">
					<span aria-hidden="true">&laquo;</span>
					<span class="sr-only">Previous</span>
					</a>
					</li>`;

					for (i = 1; i <= page; i++) {
						if (i==attive_page) {
							pageattive = 'active';
						}else{
							pageattive = '';
						}
						if (attive_page == i) {
							show_pagination += `<li class="page-item ${pageattive} changenewpage" data-pagenum="${i}"><a class="page-link" href="#">${i}</a></li>`;
						} else {
							if (i == parseInt(attive_page) - 1 || i == parseInt(attive_page) - 9)
								show_pagination += `<li class="page-item ${pageattive} changenewpage" data-pagenum="${i}"><a class="page-link" href="#">${i}</a></li>`;
							else if (i == parseInt(attive_page) + 1 || i == parseInt(attive_page) + 9)
								show_pagination += `<li class="page-item ${pageattive} changenewpage" data-pagenum="${i}"><a class="page-link" href="#">${i}</a></li>`;
							else if (i > parseInt(limit) - 9)
								show_pagination += `<li class="page-item ${pageattive} changenewpage" data-pagenum="${i}"><a class="page-link" href="#">${i}</a></li>`;
							else if (i < (9))
								show_pagination += `<li class="page-item ${pageattive} changenewpage" data-pagenum="${i}"><a class="page-link" href="#">${i}</a></li>`;
						}
					}

					show_pagination += `<li class="page-item changenewpage" data-pagenum="${Next}">
					<a class="page-link" href="#" aria-label="Next">
					<span aria-hidden="true">&raquo;</span>
					<span class="sr-only">Next</span>
					</a>
					</li>`;


					$(".pagination").html(show_pagination);
				}else{
					$(".pagination").html('');
				}
			}




			$(document).on('click', '.changenewpage', function(){
				var showdata = [];
				var pagenew = $(this).data('pagenum');

				var txt = $("#txt").val();
				var from_1 = parseInt(limit)*parseInt(pagenew);
				var from = parseInt(from_1)-parseInt(limit);
				var result_text = '';
				from_start = from;
				from_end = parseInt(from)+parseInt(limit);


				if (txt==='') {
					if (checkdatainput!='') {
						var newData = {
							"query": {
								"bool": {
									"must": [
									{
										"match": {
											"gender": checkdatainput
										}
									}
									]
								}
							},
							"size": limit,
							"from": from,
							"highlight": {
								"fields" : {
									"name" : {}
								}
							}
						};
						var match = {
							source: JSON.stringify(newData),
							source_content_type: "application/json"  
						};
					}else{
						var match = null;
					}
					var data = match;
				}else{
					if (checkdatainput!='') {
						var match = [
						{
							"multi_match": {
								"query" : txt,
							}
						},
						{
							"match": {
								"gender": checkdatainput
							}
						}
						];
					}else{
						var match = [
						{
							"multi_match": {
								"query" : txt,
							}
						}
						];
					}
					var newData = {
						"query": {
							"bool": {
								"must": match
							}
						},
						"size": limit,
						"from": from,
						"highlight": {
							"fields" : {
								"name" : {}
							}
						}
					};
					var data = {
						source: JSON.stringify(newData),
						source_content_type: "application/json"  
					};
				}
				$.ajax({
					method: "GET",
					url: url,
					data: data
				})
				.done(function( msg ) {
					var data = msg.hits.hits;
					for (i = 0; i < data.length; i++) {
						var showjson = JSON.stringify(data[i]._source, undefined, 4);
						var show = highlight(txt,'<pre>'+syntaxHighlight(showjson)+'</pre>');
						showdata.push(`<div class="card mt-4">
							<div class="card-body">
							${show}
							</div>
							</div>
							`);
					}

					$("#showdata").html(showdata.join(""));
					checktotal_data(txt);
					attive_page = pagenew;
				});
			});



		</script>

		<!-- Optional JavaScript -->
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" ></script>  <!-- New one -->
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
	</body>
	</html>

<!--
        <div class="section-body mt-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Search here...">
                                </div>                            
                                <p class="mb-0">Search Result For "Bootstrap 4 admin"</p>
                                <strong class="font-12"> About 16,853 result ( 0.13 seconds)</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-body">
            <div class="container-fluid">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#All" aria-expanded="true">All</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Images" aria-expanded="true">Images</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Video" aria-expanded="false">Video</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#News" aria-expanded="false">News</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#More" aria-expanded="false">More</a></li>
                </ul>
                <div class="tab-content mt-3">
                    <div role="tabpanel" class="tab-pane vivify fadeIn active" id="All" aria-expanded="false">
                        <div class="table-responsive">
                            <table class="table table-hover card-table table_custom">
                                <tbody>
                                    <tr class="" >
                                        <td>
                                            <h6><a target="_blank" href="javascript:void(0);">Bootstrap 4 Light &amp; Dark Admin with Free VueJs</a></h6>
                                            <span class="text-green font-13">https://themeforest.net/user/puffintheme</span>
                                            <p class="mt-10 mb-0 text-muted">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
                                        </td>
                                        <td>
                                            <span class="badge badge-success"><i class="fa fa-eye"></i> 1501</span>
                                        </td>
                                    </tr>
                                    <tr class="">
                                        <td>
                                            <h6><a target="_blank" href="javascript:void(0);">Bootstrap 4 Admin Dashboard Template</a></h6>
                                            <span class="text-green font-13">https://themeforest.net/user/puffintheme</span>
                                            <p class="mt-10 mb-0 text-muted">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour</p>
                                        </td>
                                        <td>
                                            <span class="badge badge-success"><i class="fa fa-eye"></i> 1894</span>
                                        </td>
                                    </tr>
                                    <tr class="">
                                        <td>
                                            <h6><a target="_blank" href="javascript:void(0);">The ultimate Bootstrap 4 Admin Dashboard</a></h6>
                                            <span class="text-green font-13">https://themeforest.net/user/puffintheme</span>
                                            <p class="mt-10 mb-0 text-muted">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.</p>
                                        </td>
                                        <td>
                                            <span class="badge badge-success"><i class="fa fa-eye"></i> 1205</span>
                                        </td>
                                    </tr>
                                    <tr class="">
                                        <td>
                                            <h6><a target="_blank" href="javascript:void(0);">Bootstrap 4 Admin Dashboard Template</a></h6>
                                            <span class="text-green font-13">https://themeforest.net/user/puffintheme</span>
                                            <p class="mt-10 mb-0 text-muted">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                                        </td>
                                        <td>
                                            <span class="badge badge-success"><i class="fa fa-eye"></i> 985</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane vivify fadeIn" id="Images" aria-expanded="true">
                        <div class="card">
                            <div class="card-body text-center py-5">
                                <img src="assets/images/search.svg" class="width360 mb-3" />
                                <h4>No Images Found</h4>
                                <span>Choose a different filter to view test results to you</span>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane vivify fadeIn" id="Video" aria-expanded="true">
                        <div class="card">
                            <div class="card-body text-center py-5">
                                <img src="assets/images/search.svg" class="width360  mb-3" />
                                <h4>No Video Found</h4>
                                <span>Choose a different filter to view test results to you</span>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane vivify fadeIn" id="News" aria-expanded="true">
                        <div class="card">
                            <div class="card-body">
                                <article class="media">
                                    <div class="mr-3">
                                        <img class="w150" src="../assets/images/gallery/1.jpg" alt="">
                                    </div>
                                    <div class="media-body">
                                        <div class="content">
                                            <p class="h5">John Smith <small>@johnsmith</small> <small class="float-right text-muted">31 minutes ago</small></p>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean efficitur sit amet massa fringilla egestas. Nullam condimentum luctus turpis.</p>
                                        </div>
                                        <nav class="d-flex text-muted">
                                            <a href="#" class="icon mr-3"><i class="fe fe-repeat"></i></a>
                                            <a href="#" class="icon mr-3"><i class="fe fe-twitter"></i> 24</a>
                                            <a href="#" class="icon mr-3"><i class="fe fe-heart"></i> 43</a>
                                            <a href="" class="text-muted ml-auto">5 notes</a>
                                        </nav>
                                    </div>
                                </article>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <article class="media">
                                    <div class="mr-3">
                                        <img class="w150" src="../assets/images/gallery/2.jpg" alt="">
                                    </div>
                                    <div class="media-body">
                                        <div class="content">
                                            <p class="h5">John Smith <small>@johnsmith</small> <small class="float-right text-muted">31 minutes ago</small></p>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean efficitur sit amet massa fringilla egestas. Nullam condimentum luctus turpis.</p>
                                        </div>
                                        <nav class="d-flex text-muted">
                                            <a href="#" class="icon mr-3"><i class="fe fe-repeat"></i></a>
                                            <a href="#" class="icon mr-3"><i class="fe fe-twitter"></i> 24</a>
                                            <a href="#" class="icon mr-3"><i class="fe fe-heart"></i> 43</a>
                                            <a href="" class="text-muted ml-auto">5 notes</a>
                                        </nav>
                                    </div>
                                </article>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <article class="media">
                                    <div class="mr-3">
                                        <img class="w150" src="../assets/images/gallery/3.jpg" alt="">
                                    </div>
                                    <div class="media-body">
                                        <div class="content">
                                            <p class="h5">John Smith <small>@johnsmith</small> <small class="float-right text-muted">31 minutes ago</small></p>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean efficitur sit amet massa fringilla egestas. Nullam condimentum luctus turpis.</p>
                                        </div>
                                        <nav class="d-flex text-muted">
                                            <a href="#" class="icon mr-3"><i class="fe fe-repeat"></i></a>
                                            <a href="#" class="icon mr-3"><i class="fe fe-twitter"></i> 24</a>
                                            <a href="#" class="icon mr-3"><i class="fe fe-heart"></i> 43</a>
                                            <a href="" class="text-muted ml-auto">5 notes</a>
                                        </nav>
                                    </div>
                                </article>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <article class="media">
                                    <div class="mr-3">
                                        <img class="w150" src="../assets/images/gallery/4.jpg" alt="">
                                    </div>
                                    <div class="media-body">
                                        <div class="content">
                                            <p class="h5">John Smith <small>@johnsmith</small> <small class="float-right text-muted">31 minutes ago</small></p>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean efficitur sit amet massa fringilla egestas. Nullam condimentum luctus turpis.</p>
                                        </div>
                                        <nav class="d-flex text-muted">
                                            <a href="#" class="icon mr-3"><i class="fe fe-repeat"></i></a>
                                            <a href="#" class="icon mr-3"><i class="fe fe-twitter"></i> 24</a>
                                            <a href="#" class="icon mr-3"><i class="fe fe-heart"></i> 43</a>
                                            <a href="" class="text-muted ml-auto">5 notes</a>
                                        </nav>
                                    </div>
                                </article>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <article class="media">
                                    <div class="mr-3">
                                        <img class="w150" src="../assets/images/gallery/5.jpg" alt="">
                                    </div>
                                    <div class="media-body">
                                        <div class="content">
                                            <p class="h5">John Smith <small>@johnsmith</small> <small class="float-right text-muted">31 minutes ago</small></p>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean efficitur sit amet massa fringilla egestas. Nullam condimentum luctus turpis.</p>
                                        </div>
                                        <nav class="d-flex text-muted">
                                            <a href="#" class="icon mr-3"><i class="fe fe-repeat"></i></a>
                                            <a href="#" class="icon mr-3"><i class="fe fe-twitter"></i> 24</a>
                                            <a href="#" class="icon mr-3"><i class="fe fe-heart"></i> 43</a>
                                            <a href="" class="text-muted ml-auto">5 notes</a>
                                        </nav>
                                    </div>
                                </article>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
-->        