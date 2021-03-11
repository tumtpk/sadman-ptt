<script type="text/javascript">
	// (function($) {
		$(document).ready(function(){

			var data_json = [];
			var sort = 0;
			load_data_eform_template();
			function load_data_eform_template(){
				var show_data_eform_template = [];
				$.ajax({
					url:"index.php?r=site/json_report_design_many_sources",
					method:"GET",
					dataType:"json",
					data:{ type: "show_eform_templete",auth:"Authenticator=>2ffa459adcc37176dbf93a82addf61dc<?=date("Ymd");?>"},
					contentType: "application/json; charset=utf-8",
					success:function(data){
						$.each(data, function(i) {
							show_data_eform_template.push(`<li class="list-group-item clickmodal" data-toggle="modal" data-target=".shownew" data-form_id="${data[i].form_id}" data-form_name="${data[i].form_name}">
								${data[i].form_name}
								<div class="float-right">
								<b>(${data[i].count})</b>
								</div>
								</li>`);
						});
						$('#show_eform_templete').html(show_data_eform_template.join(""));
					}
				});
			}

			$(document).on('click', '.clickmodal', function(){
				var form_id = $(this).data('form_id');
				var form_name = $(this).data('form_name');
				$("#form_id_check").val(form_id);
				$(".modal-title").html(form_name);
				show_eform_data_today(form_id);
			});

			$(document).on('click', '#btn_search', function(){
				var search_news = $("#search_news").val();
				var date_search = $(".get_val_datetime").val();
				var form_id = $("#form_id_check").val();

				if (date_search!='') {
					$.ajax({
						url:"index.php?r=site/json_report_design_many_sources",
						method:"GET",
						dataType:"json",
						data:{ type: "search_value",auth:"Authenticator=>2ffa459adcc37176dbf93a82addf61dc<?=date("Ymd");?>",form_id:form_id,date_search: date_search,text_search:search_news},
						contentType: "application/json; charset=utf-8",
					})
					.done(function(data){
						if(data.length>0){
							show_content(data,'shownews');
						}else{
							$("#shownews").html('<div class="text-center mt-4"><b>ไม่พบข้อมูล</b></div>');
						}
					});

				}else{
					alert('กรุณาเลือกวันที่บันทึก');
				}

			});


			function show_eform_data_today(form_id){
				$.ajax({
					url:"index.php?r=site/json_report_design_many_sources",
					method:"GET",
					dataType:"json",
					data:{ type: "today",auth:"Authenticator=>2ffa459adcc37176dbf93a82addf61dc<?=date("Ymd");?>",form_id:form_id},
					contentType: "application/json; charset=utf-8",
					success:function (data) {
						if(data.length>0){
							show_content(data,'shownews');
						}else{
							$("#shownews").html('<div class="text-center mt-4"><b>ไม่มีข้อมูลของวันนี้</b></div>');
						}
					}
				})
			}


			$(document).on('click', 'input[name="select-news"]', function(){
				var id = $(this).val();
				var name = $(this).data("name");
				var key = $(this).data("key");
				sort = sort+1;
				if ($(this).is(':checked')) {
					$("#modal-true").css("display", "block");
					data_json.push({
						sort:sort,
						id_news:id,
						type:1,
					});
				}else{
					var index = data_json.map(x => {
						return x.id_news;
					}).indexOf(id);
					if (index!=-1) {
						data_json.splice(index, 1);
					}
				}

				show_preview_design();

			});

			function show_preview_design(){
				
				var data = data_json;
				var show_preview_design = [];
				$.each(data, function(i) {
					var $data_show = ``;
					if (data[i].type==1) {
						var data_news = get_data_news_byid(data[i].id_news);
						$data_show = `<div class="col-md-12" data-id_news="${data[i].id_news}" data-sort="${data[i].sort}" data-type="${data[i].type}">${data_news[0].show_all_class}</div>`;
					}

					if (data[i].type==2) {
						$data_show = `<div class="focusin_save_data" data-sort="${data[i].sort}"><textarea class="form-control col-md-12" id="textarea_${data[i].sort}" rows="7" data-type="${data[i].type}" data-sort="${data[i].sort}">${data[i].data_textarea}</textarea></div>`;
					}

					show_preview_design.push(`
						<div class="text_body ui-state-default" data-sort="${data[i].sort}">
						<div class="text_data card-move card card-report"><button type="button" class="btn btn-danger remove_eform btn-sm" style="position: absolute;z-index: 1;right: 8px;" data-sort="${data[i].sort}"><i class="fa fa-trash" aria-hidden="true"></i></button>${$data_show}
						</div></div>
						`);
				});
				$("#show-preview").html(show_preview_design.join(""));
			}


			function show_content(data_array,name_div){
				var data = data_array;
				var myarray = [];
				for (i = 0; i < data.length; i++) {
					var id = data[i]['id'];
					var topic = data[i]['data'];
					var date = data[i]['date_record'];

					var _news_checked = '';
					if(data_json.find(x => x.id_news === id)){
						_news_checked = 'checked';
					}

					myarray.push(`<div class="card card-mb-not"><div class="card-body"><label class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input getval_check" name="select-news" value="${id}" data-topic="${topic}" ${_news_checked}><span class="custom-control-label"> ${topic} <b>วันที่บันทึก :</b> ${date}</span></label></div></div>`);

				}
				$("#"+name_div).html(myarray.join(""));
			}

			function get_data_news_byid(id){
				var data = null;
				var data = $.ajax({
					url:"index.php?r=site/json_report_design_many_sources",
					method:"GET",
					data:{ type: "byid",auth:"Authenticator=>2ffa459adcc37176dbf93a82addf61dc<?=date("Ymd");?>",id_news:id},
					contentType: "application/json; charset=utf-8",
					global: false,
					dataType: "json",
					async:false,
					success: function(msg){
						return msg.data;
					}
				}
				).responseJSON;

				return data;
			}

			var text_bodydivst = $('#show-preview');
			text_bodydivst.sortable({
				placeholder: "ui-state-highlight",
				handle: '.text_data', 
				update: function() {
					$('.text_body', text_bodydivst).each(function(index, elem) {
						var $divstItem = $(elem),
						newIndex = $divstItem.index();
					});
					savesort();
				},
				start: function (event, ui) {
					$(".ui-state-highlight")
					.css('width', $(ui.item).css('width'));
					$(".ui-state-highlight")
					.css('height', $(ui.item).css('height'));
				},

			});


			function savesort(){
				var index_sort = new Array();
				$('div#show-preview div.text_body').each(function() {
					var old_sort = $(this).data("sort");
					var objIndex = data_json.map(x => x.sort).indexOf(old_sort);

					index_sort.push(objIndex);
				});

				change_sort(index_sort);
			}

			function change_sort(index_sort){
				for (var i = 0; i < index_sort.length; i++) {
					var index_key = index_sort[i];
					data_json[index_key].sort = (i+1);
				}
				var objdata = data_json.sort( function( left, right ) {
					return left.sort - right.sort;
				});
				data_json = objdata;
				show_preview_design();
			}

			$(document).on('click', '.remove_eform', function(){
				if(confirm('ต้องการยกเลิกข้อมูลรายการนี้ใช่หรือไม่')){
					var id_sort = $(this).data("sort");
					$.each(data_json, function(i, el){
						if (this.sort == id_sort){
							data_json.splice(i, 1);
						}
					});
					data_json = data_json;
					show_preview_design();
				}
			});

			$(document).on('click', '.add_textarea_detail', function(){
				sort = sort + 1;
				data_json.push({
					sort:sort,
					data_textarea:"",
					type:2,
				});
				show_preview_design();
			});
			
			$(document).on('focusin', '.focusin_save_data', function(){
				var sort = $(this).data("sort");
				var keyword = `<div class="btn-group">
				<button type="button" class="btn btn-light save_data_textarea" data-sort="${sort}"><i class="fa fa-check text-success" aria-hidden="true"></i> <b class="text-success"> บันทึกรายละเอียด</b></button>
				<button type="button" class="btn btn-light clear_data_textarea" data-sort="${sort}"><i class="fa fa-times" style="color: #dc3545 !important;" aria-hidden="true"></i> <b style="color: #dc3545 !important;"> ล้างค่า</b></button>
				</div>`;
				var html_div = $(this).html();
				var pattern = new RegExp(keyword, 'gi');
				if(!html_div.match(pattern)){
					$(this).html(html_div+keyword);
				}
			});


			$(document).on('click', '.clear_data_textarea', function(){
				var sort = $(this).data("sort");
				var objIndex = data_json.map(x => x.sort).indexOf(sort);
				$("#textarea_"+sort).val('');
				data_json[objIndex].data_textarea = "";
				show_preview_design();
			});

			$(document).on('click', '.save_data_textarea', function(){
				var sort = $(this).data("sort");
				var objIndex = data_json.map(x => x.sort).indexOf(sort);
				var val_text = $("#textarea_"+sort).val();
				data_json[objIndex].data_textarea = val_text;
				show_preview_design();
			});


			[].forEach.call(document.getElementsByTagName("textarea"), function(textarea) {
				textarea.addEventListener("input", function() {
					textarea.value = textarea.value.replace(/\n/g, "<br>").replace(/ /g, " ");
				});
			});

			$(document).on('change','textarea', function () {
				if (this.value.match(/[^a-zA-Z0-9 ก-๏ +-/ ()@#$%&<>]/g)) {
					// this.value = this.value.replace(/[^a-zA-Z0-9 ก-๏ +-/ ()@#$%&<>]/g, '');
					this.value = this.value.replace(/\"/g, "").replace(/ /g, " ");
					this.value = this.value.replace(/\'/g, "").replace(/ /g, " ");
					this.value = this.value.replace(/\n/g, "<br>").replace(/ /g, " ");
				}
			});



		});
	// });
</script>

<script src="../../html-version/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>