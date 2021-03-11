<!doctype html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

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
				<li class="nav-item active">
					<a class="nav-link" href="http://119.59.113.234:8090/textx/frontend/web/index.php">Home <span class="sr-only">(current)</span></a>
				</li>
				
				
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
				<button class="btn btn-primary btn-block" type="button" onClick="searchText(txt.value);">Search</button>
			</div>
		</div>

		<div class="row">
			<div class="col-md-3">
				<small>
					<dt>
						<label for="sel1" class="mt-3">เรียงลำดับตาม</label>
					</dt>
				</small>
				<select class="form-control">
					<option>Name</option>
					<option>Address</option>
				</select>
				<!-- Gender -->

                
				<small>
					<dt>
						<label for="sel1" class="mt-3">เพศ</label>
					</dt>
				</small>
				
				<div class="custom-checkbox mt-1">
					<ul class="list-inline">
						<li><input type="radio" id="all" name="checkdatainput" class="checkdatainput" value="">
							<label for="all" class="label-checkbox">All</label>
							<span class="spannum">1</span></li>
							<li><input type="radio" id="Male" name="checkdatainput" class="checkdatainput" value="Male">
								<label for="Male" class="label-checkbox">Male</label>
								<span class="spannum">3</span></li>
								<li>
									<input type="radio" id="Female" name="checkdatainput" class="selectcheckbox checkdatainput" value="Female">
									<label for="Female" class="label-checkbox">Female</label>
									<span class="spannum">2</span>
								</li>

							</ul>
						</div>
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
			var url = "http://119.59.113.234:9200/textx/_search";
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
                            var name = JSON.stringify(data[i]._source.name);
                            var img = JSON.stringify(data[i]._source.urlmarker);
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
                                            <img src="https://source.unsplash.com/1600x900" width="100%;"/> 
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