<?php 
$this->title = 'Search';
?>
<!doctype html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	<style>
		.spannum{margin-top: 3px;font-size: 12px;color: #6c757dc7;float: right;}
		.label-checkbox{
			margin-left: 0.5em;
		}
		pre {
			padding: 5px;
			margin: 5px; 
			color: #343a40d1 !important;
			background-color: #ffffff; 
		}
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
			.pagination li{
				padding: 0px;
			}
			.page-item .page-link{
				color: #124660;
			}
			.page-item.active .page-link{
				background-color: #124660;
				border-color: #124660;
			}
			.custom-checkbox{
				background-color: #ffffff;
				padding: 7px;
				border-radius: 5px;
				border: 1px solid rgba(0,0,0,.125);
			}
			.btn.btn-primary.btn-block{
				background-color: #014660;
				border-color: #014660;
				color: #ffffff;
			}
			.section-body{
				border:1px solid #ffffff !important;
			}
		</style>
	</head>
	<body>

		<div class="container-fluid">
			<div class="row mt-5">
				<div class="col-md-12">
					<h4>TITLE</h4>
				</div>
				<div class="col-md-11">
					<input class="form-control" id="txt" type="search" placeholder="กรอกค้นหา" aria-label="Search"> 
					<!-- onChange="searchText(this.value);" -->
				</div>
				<div class="col-md-1 change-padding-left">
					<button class="btn btn-primary btn-block" type="button" onClick="searchText(txt.value);">ค้นหา</button>
				</div>
			</div>

			<div class="row">
				<div class="col-md-3" style="margin-top: 25px;">
					<small>
						<dt>
							<label for="sel1" class="mt-3">แฟ้มข้อมูล</label>
						</dt>
					</small>
					<div class="custom-checkbox mt-1">
						<ul class="list-inline">
							<div id="typelist">
							</div>
							<li>
								<input type="checkbox" id="Female" name="checkdatainput" class="selectcheckbox checkdatainput" value="หญิง">
								<label for="Female" class="label-checkbox">หญิง</label>
								<span class="spannum">2</span>
							</li>
						</ul>
						<ul class="list-inline">
							<li><input type="radio" id="all" name="checkdatainput" class="checkdatainput" value="">
								<label for="all" class="label-checkbox">ทั้งหมด</label>
								<span class="spannum">1</span>
							</li>
							<li><input type="radio" id="Male" name="checkdatainput" class="checkdatainput" value="ชาย">
								<label for="Male" class="label-checkbox">ชาย</label>
								<span class="spannum">3</span></li>
								<li>
									<input type="radio" id="Female" name="checkdatainput" class="selectcheckbox checkdatainput" value="หญิง">
									<label for="Female" class="label-checkbox">หญิง</label>
									<span class="spannum">2</span>
								</li>
							</ul>
						</div>
						<br>
						<button class="btn btn-sm btn-primary btn-block" type="button" onclick="getAllCondition();">Open Vis Network</button>
					</div>
					<!-- Gender -->

				<!-- <small>
					<dt>
						<label for="sel1" class="mt-3">STATES</label>
					</dt>
				</small>
				<input class="form-control" type="search" placeholder="Filter states">
				<div class="custom-checkbox mt-1">
					<ul class="list-inline">
						<li><input type="checkbox" id="California">
							<label for="California" class="label-checkbox">California</label>
							<span class="spannum">3</span></li>
							<li>
								<input type="checkbox" id="Arizona" class="selectcheckbox">
								<label for="Arizona" class="label-checkbox">Arizona</label>
								<span class="spannum">2</span>
							</li>
							<li>
								<input type="checkbox" id="Florida" class="selectcheckbox">
								<label for="Florida" class="label-checkbox">Florida</label>
								<span class="spannum">2</span>
							</li>
							<li>
								<input type="checkbox" id="Nevada">
								<label for="Nevada" class="label-checkbox">Nevada</label>
								<span class="spannum">2</span>
							</li>
						</ul>
					</div>
				</div> -->
				<div class="col-md-9">
					<div class="row mt-3">
						<div class="col-md-9">
							<div id="show_result_text" class="mt-3"></div>
						</div>
						<div class="col-md-3 text-right">
							<small style="display: inline-block;">แสดง : </small>
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
			//var url = "http://45.127.62.51:9200/textxdb/_search";
			var url = 'http://45.127.62.89:7000/textx/frontend/web/index.php?r=site/elastic-getdata'
			var attive_page = 1;
			var limit = 50;
			var from_start = 0;
			var from_end = limit;
			var checkdatainput = '';
			var all_condition = null;
			var showdata = [];
			

			$(document).ready(function(){
				notsearch();
				getType();
				// console.log(all_condition);
			});

			function getType(){
				$.ajax({
					method: "POST",
					url: 'index.php?r=site/elastic-gettype&column=type',
					crossDomain: true,
					//data: match,
					processData: false,
					contentType: false,
					mimeType: "multipart/form-data",
					global: false,
					dataType: "json",
					async: false,
				})
				.done(function( msg ) {
					console.log(msg.aggregations.type.buckets);
					var data = msg.aggregations.type.buckets;
					for (i = 0; i < data.length; i++) {
						var key = JSON.stringify(data[i].key);
						var doc_count = JSON.stringify(data[i].doc_count);

						showdata.push(`<li><input type="checkbox" id="${key}" name="typelist" class="selectcheckbox checkdatainput" value="${key}"><label for="${key}" class="label-checkbox">${key}</label><span class="spannum">${doc_count}</span></li>
							`);
					}
                        //console.log(showdata);
                        $("#typelist").html(showdata.join(""));
                    });
			}

			$(document).on('click', '.checkdatainput', function(){
				checkdatainput = $("input[type='radio'].checkdatainput:checked").val();
				var txt = $("#txt").val();
				if (txt==='') {
					notsearch();
				}else{
					searchText(txt);
				}
				// console.log(all_condition);
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
				console.log(all_condition);
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
				all_condition = match;

				var form_data = new FormData();
				form_data.append("query", ""+JSON.stringify(match)+"");
				console.log(JSON.stringify(match));
				$.ajax({
					method: "POST",
					url: url,
					crossDomain: true,
					data: form_data,
					processData: false,
					contentType: false,
					mimeType: "multipart/form-data",
					global: false,
					dataType: "json",
					async: false,
				})
				.done(function( msg ) {

					var data = msg.hits.hits;
					for (i = 0; i < data.length; i++) {
						var showjson = JSON.stringify(data[i]._source, undefined, 4);
						var name = JSON.stringify(data[i]._source.name);
						var img = JSON.stringify(data[i]._source.urlmarker);

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
					console.log(all_condition);
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
						method: "POST",
						url: url,
                        //url: 'http://45.127.62.51:7000/textx/frontend/web/index.php?r=site/elastic-getdata',
                        crossDomain: true,
                        /*headers: {
                            "Authorization": "Basic " + btoa("elastic:changeme")
                        },*/
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
						var array_msg = jQuery.parseJSON(msg);
						var data = array_msg.hits.hits;
						var len = data.length;
						for (i = 0; i < len; i++) {
							var showjson = JSON.stringify(data[i]._source, undefined, 4);
							var name = JSON.stringify(data[i]._source.name);
							var img = JSON.stringify(data[i]._source.urlmarker);
							var len_img = data[i]._source.images.length;
							var show = highlight(v,'<pre>'+syntaxHighlight(showjson)+'</pre>');
							showdata.push(`<div class="card mt-4">
								<div class="card-body">

								<div class="row">
								<div class="col-8">
								<a href="#detail">${name}</a><br>
								${show} <br>
								<button class="btn btn-outline-secondary">รายละเอียด</button><button class="btn btn-outline-secondary">ดูบนแผนที่</button>
								</div>
								<div class="col-4">
								<img src="${data[i]._source.images[Math.floor(Math.random() * len_img)]}" width="100%;"/> 
								</div>
								</div> 
								</div>
								</div>
								`);
							
						}
						var result_text = 'Result of "<font color="blue">'+ v +'</font>" is '+len + ' record(s)';
						$("#showdata").html(showdata.join(""));
						checktotal_data(v);
						attive_page = 1;
						all_condition = {
							source: JSON.stringify(newData),
							source_content_type: "application/json"  
						};
						console.log(all_condition);
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
				all_condition = data;
				$.ajax({
					method: "GET",
					url: url,
					data: data
				})
				.done(function( msg ) {
                    //console.log(jQuery.parseJSON(msg));
                    var data = jQuery.parseJSON(msg);

                    pagiantion_data(data.hits.total.value);
                    result_text(data.hits.total.value,q);
                });
			}


			function result_text(total,q){
				if (q==='') {
					var data = `<small>แสดง <b>${parseInt(from_start+1)} - ${from_end}</b> จากทั้งหมด <b>${total}</b></small>`;
				}else{
					var end_record = from_end;
					if (total<from_end) {
						end_record = total;
					}
					var data = `
					Result of <b>"<span style="color:#0062cc;font-weight:bold;">${q}</span>"</b> is ${total} record(s)
					<br>
					<small>แสดง <b>${parseInt(from_start+1)} - ${end_record}</b> จากทั้งหมด <b>${total}</b></small>
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
					console.log(data);
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
					//console.log(data);
				}
				all_condition = data;

				$.ajax({
					method: "GET",
					url: url,
					data: data
				})
				.done(function( msg ) {
					var array_msg = jQuery.parseJSON(msg);
					var data = array_msg.hits.hits;
					
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
				//console.log(all_condition);
			});

			function getAllCondition(){
				var getJson = JSON.stringify(all_condition);
				console.log(all_condition);
				//console.log('/textx/frontend/web/index.php?r=site/pages&view=network-link-with-images&jsoncondition='+getJson);
				window.location = '/textx/frontend/web/index.php?r=site/pages&view=network-link-with-images&jsoncondition='+getJson;
			}

		</script>



		<!-- Optional JavaScript -->
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" ></script>  <!-- New one -->



		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
	</body>
	</html>