<?php
include('../../conn_sql/conn.php');
$protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === 0 ? 'https://' : 'http://';
$PHP_SELF = explode("/", $_SERVER['PHP_SELF']);
$_URL = $protocol.$_SERVER['HTTP_HOST']."/".$PHP_SELF[1]."/textx";
$key_images = '2020-06-30_091048';
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<link rel="stylesheet" type="text/css" href="<?=$_URL;?>/icofont/icofont.min.css">
<link rel="stylesheet" href="<?=$_URL;?>/html-version/assets/plugins/dropify/css/dropify.min.css">
<script src="<?=$_URL;?>/html-version/assets/plugins/dropify/js/dropify.min.js"></script>
<style>

.drag_n_drop{
	width: 100%;
	height: 270px;
	background: #e9ecef;
	border: 4px dashed #6c757d55;
}
.drag_n_drop p{
	margin-top:5em;
	width: 100%;
	height: 100%;
	text-align: center;
	/*line-height: 170px;*/
	color: #545b62;
	font-family: Arial;
}
.drag_n_drop input{
	position: absolute;
	margin: 0;
	padding: 0;
	width: 100%;
	height: 100%;
	outline: none;
	opacity: 0;
}
.drag_n_drop button{
	margin: 0;
	color: #fff;
	background: #16a085;
	border: none;
	width: 508px;
	height: 35px;
	margin-top: -20px;
	margin-left: -4px;
	border-radius: 4px;
	border-bottom: 4px solid #117A60;
	transition: all .2s ease;
	outline: none;
}
.drag_n_drop button:hover{
	background: #149174;
	color: #0C5645;
}
.drag_n_drop button:active{
	border:0;
}
.list-design{
	height: 195px; overflow-y: scroll;
	overflow-x: hidden;
}
.img-thumbnail {
	margin-top: 1em;
	width: 100%;
	height: 100px;
	object-fit: cover;
}
.bb-fix{
	font-size: 0.6rem;
}
.dropify-wrapper{
	height: 277px;
}

</style>
<div class="container">
	<div class="row">
		<div class="col-md-6">

			<div class="dropify-wrapper"><div class="dropify-message"><span class="file-icon"></span> <p>Drag and drop a file here or click</p><p class="dropify-error">Ooops, something wrong appended.</p></div><div class="dropify-loader"></div><div class="dropify-errors-container"><ul></ul></div><input type="file" class="dropify" name="multiple_files" id="multiple_files" multiple="multiple" required="required"><button type="button" class="dropify-clear">Remove</button><div class="dropify-preview"><span class="dropify-render"></span><div class="dropify-infos"><div class="dropify-infos-inner"><p class="dropify-filename"><span class="file-icon"></span> <span class="dropify-filename-inner"></span></p><p class="dropify-infos-message">Drag and drop or click to replace</p></div></div></div></div>

			<input type="hidden" value="<?=$key_images;?>" id="key_images" name="key_images">
			<input type="hidden" value="<?=date("Y-m-d");?>" id="date_create" name="date_create">
			<div id="status_error"></div>
		</div>
		<div class="col-md-6">
			<div class="card" style="margin-top: 0px;">
				<div class="card-body">
					<h4 class="card-title">ประมวลผล</h4>
					<div class="list-design">
						<ul class="list-group list-show-process" id="status_show">
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<hr>
	<div class="row text-center text-lg-left" id="main_show">
	</div>
	<div id="status"></div>
</div>


<script>

	function convertDate(date){
		var date_auth =
		date.getFullYear() + "" +
		("00" + (date.getMonth() + 1)).slice(-2) + "" +
		("00" + (date.getDate()+ 1)).slice(-2) + "" +
		("00" + date.getHours()).slice(-2) + "" +
		("00" + date.getMinutes()).slice(-2) + "" +
		("00" + date.getSeconds()).slice(-2);

		return date_auth;
	}

	$(document).ready(function(){

		$('#multiple_files').change(function(){
			upload();
		});

		function upload() {

			var files = document.querySelector("#multiple_files").files;
			for (var i = 0; i < files.length; i++) {
				var oFReader = new FileReader();
				oFReader.readAsDataURL(document.getElementById("multiple_files").files[i]);
				var f = document.getElementById("multiple_files").files[i];
				var fsize = f.size||f.fileSize;
				// if(fsize > 5000000)
				// {
				// 	$("#status_error").append(`<div class="alert alert-danger">
				// 		<strong>Error!</strong> ไฟล์มีขนาดใหญ่เกิน 5MB</a>.
				// 		</div>`);
				// }else{
					var file = files[i];
					var name = files[i].name;
					var ext = name.split('.').pop().toLowerCase();
					var namefile = convertDate(new Date()) +'-' +Date.now()+ '.'+ext;
					$(".list-show-process").append('<li class="list-group-item text-primary">'+name+' : กำลังอัพโหลด...</li>');
					retrieveNewURL(ext,namefile ,file, (file, url) => {
						uploadFile(file, url);
					});
				// }
			}

		}


		function retrieveNewURL(ext,namefile, file, cb) {

			fetch(`http://117.121.213.103:3100/uploadminio?name=${file.name}&bucket=webboardtextx&namefile=${namefile}`).then((response) => {
				response.text().then((url) => {
					cb(file, url);
				});
				insertDatabase(namefile,ext);
			}).catch((e) => {
				// console.error(e);
				console.log(e);
			});
		}

		function uploadFile(file, url) {
			if (document.querySelector('#status').innerHTML === 'No uploads') {
				document.querySelector('#status').innerHTML = '';
			}
			fetch(url, {
				method: 'PUT',
				body: file
			}).then(() => {
				document.querySelector('#status_show').innerHTML += `<li class="list-group-item text-success">${file.name} : อัพโหลดสำเร็จ</li>`;
			}).catch((e) => {
				document.querySelector('#status_show').innerHTML += `<li class="list-group-item text-danger">${file.name} : ไฟล์อัพโหลดไม่สำเร็จ กรุณาตรวจสอบ</li>`;

				console.error(e);
			});
		}

		function insertDatabase(namefile,ext){
			alert(namefile);
		}



	});


</script>

<link rel='stylesheet' href='<?=$_URL?>/magnific-popup/magnific-popup.css'>
<script src='<?=$_URL?>/magnific-popup/jquery.magnific-popup.min.js'></script>

<script>

	(function($) {
		$('.with-caption').magnificPopup({
			type: 'image',
			closeBtnInside: false,
			mainClass: 'mfp-with-zoom mfp-img-mobile',

			image: {
				verticalFit: true,
				titleSrc: function (item) {

					var caption = item.el.attr('title');

					return caption;
				} },

				gallery: {
					enabled: true },
				});
	})(jQuery);
</script>
