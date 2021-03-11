<?php
use app\models\Setting;
$this->title = 'Virtual Link';
$this->params['breadcrumbs'][] = $this->title;
?>
<link rel="stylesheet" href="../../html-version/assets/css/style_graph.css"/>
<link rel="stylesheet" href="../../draggable/kendo.default-v2.min.css"/>
<script src="../../draggable/jquery-1.12.4.min.js"></script>
<script src="../../draggable/kendo.all.min.js"></script>


<?php
$url_elasticsearch =  $Setting = Setting::find()->where(['setting_name' => 'url_elasticsearch'])->one()->setting_value;
//$index =  $Setting = Setting::find()->where(['setting_name' => 'index'])->one()->setting_value;
$graph_exclude =  $Setting = Setting::find()->where(['setting_name' => 'graph_exclude'])->one()->setting_value;

?>

<style>
.detail_node{
  display: none;
}
.div-scrollbar{
  height: 500px !important;
}

.div-scrollbar-fix{
    max-height: 500px !important;
    min-height: auto !important;
}
</style>

<div id="graph_exclude" style="visibility: hidden;height: 0px;">
	<?=$graph_exclude;?>
</div>

<!-- <div class="row">
<div class="col-lg-3 col-md-6">
    <div class="card">
        <div class="card-body w_sparkline">
            <div class="details">
                <span>Total Employee</span>
                <h3 class="mb-0 counter">614</h3>
            </div>
            <div class="w_chart">
                <span id="mini-bar-chart1" class="mini-bar-chart"></span>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-3 col-md-6">
    <div class="card">
        <div class="card-body w_sparkline">
            <div class="details">
                <span">New Employee</span>
                <h3 class="mb-0 counter">124</h3>
            </div>
            <div class="w_chart">
                <span id="mini-bar-chart2" class="mini-bar-chart"></span>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-3 col-md-6">
    <div class="card">
        <div class="card-body w_sparkline">
            <div class="details">
                <span>Male</span>
                <h3 class="mb-0 counter">504</h3>
            </div>
            <div class="w_chart">
                <span id="mini-bar-chart3" class="mini-bar-chart"></span>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-3 col-md-6">
    <div class="card">
        <div class="card-body w_sparkline">
            <div class="details">
                <span>Female</span>
                <h3 class="mb-0 counter">110</h3>
            </div>
            <div class="w_chart">
                <span id="mini-bar-chart4" class="mini-bar-chart"></span>
            </div>
        </div>
    </div>
</div>
</div>
</div> -->



<div class="row">
   <div class="col-lg-12 col-md-12" >
      <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
         เงื่อนไขในการค้นหา
     </button>
     <div class="form-group">
         <label for="exampleInputEmail1"><strong>ป้อนคำค้น</strong></label>
         <input type="text" class="form-control" id="exampleInputEmail1" style="width:450px;" aria-describedby="emailHelp">
     </div>
     <div class="show_match"></div>
 </div>

 <div class="col-lg-9 col-md-9">
  <div class="card">
     <div class="card-status bg-blue"></div>
     <div class="card-header bline">
        <h3 class="card-title">ลากหัวข้อที่สนใจมาวาง</h3>
    </div>
    <div class="card-body card-body-height" id="mainArea">
        <div id="drop-list"></div>
    </div>
</div>
<div class="card">
 <div class="card-status bg-blue"></div>
 <div class="card-header bline">
    <h3 class="card-title">ความเชื่อมโยงของข้อมูล</h3>
    <div class="card-options">
       <a href="#" class="card-options-fullscreen" data-toggle="card-fullscreen"><i class="fe fe-maximize"></i></a>
   </div>
</div>
<div class="card-body" id="mynetwork">
</div>
</div>
</div>

<div class="col-lg-3 col-md-3">
  <div class="card">
     <div class="card-status bg-blue"></div>
     <div class="card-header bline">
        <h3 class="card-title">เลือกข้อมูล</h3>
        <div class="card-options">
            <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
        </div>
    </div>
    <div class="card-body card-body-height div-scrollbar">
        <div class="form-group">
           <input id="filter" type="text" class="form-control input-sm" placeholder="ค้นหา">
       </div>
       <div id="keyword-list">
       </div>
   </div>
</div>
<div class="card detail_node">
 <div class="card-status"></div>
 <div class="card-header bline">
    <h3 class="card-title head_node">รายละเอียด</h3>
    <div class="card-options">
       <a href="#" class="close-modal"><i class="fe fe-x"></i></a>
   </div>
</div>
<div class="card-body body_node">
    <!-- card-body-height  -->
    XXXX
</div>
</div>
<div id="show-graph-group"></div>
</div>
</div>

<div class="modal fade show" id="modal-true" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
   <div class="modal-dialog" style="z-index: inherit;">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="modal-title-show"></h5>
            <button type="button" id="close-modal" class="close close-modal" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
           </button>
       </div>
       <div class="modal-body">
        <div id="relationship_show"></div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary close-modal" data-dismiss="modal">ปิด</button>
    </div>
</div>
</div>
<div class="modal-backdrop show"></div>
</div> 

<script type="text/javascript" src="https://visjs.github.io/vis-network/standalone/umd/vis-network.min.js"></script>
<script>
   $( document ).ready(function() {
      var graph_exclude = $("#graph_exclude").html();
      var data_graph_exclude =  JSON.parse(graph_exclude);
      $(document).on('keyup', '#filter', function(){
         var filter = $(this).val(),
         count = 0;

         $('.sub').each(function() {

            if ($(this).text().search(new RegExp(filter, "i")) < 0) {
               $(this).hide();  
           } else {
               $(this).show(); 
               count++;
           }

       });

     });

      var text_keywords = [];

      loadDatatext_keywords();
      function loadDatatext_keywords() {
         var settings = {
            "async": false,
            "crossDomain": true,
            "url": "<?=$url_elasticsearch?>/textxdb/_mapping",
            "method": "GET",
            "headers": {
               "Authorization": "Basic " + btoa("elastic:changeme"),
               "content-type": "application/json",
           },
           "global": false,
           "dataType": "json",
       }
       // console.log("<?=$url_elasticsearch?>/textxdb/_mapping");
       // console.log('settings = '+settings);

       var _mapping = null;
       var _mapping = $.ajax(settings).done(function (response) {
        return response;
    }).responseJSON;

       // console.log('_mapping = '+_mapping);


       var data = _mapping.textxdb_v1.mappings.properties;

       var i = 0;
       jQuery.each(data, function(obj, values) {
        if(jQuery.inArray(obj, data_graph_exclude) == -1){

           if (data[obj].properties) {
              var n = 1;
              jQuery.each(data[obj].properties, function(key, values) {
                 if (n==i) {
                    n = parseFloat(n)*2.25;
                }
                var data_array = getdata(obj+"."+key)
                text_keywords.push(
                {
                    "id":n,
                    "name":""+data_array.detail+"",
                    "sort":data_array.id,"field":""+obj+"."+key+"",
                    "urlimage":""+data_array.images+""
                }
                );
                n++;
            });
          }else{
              if (data[obj].fields) {
                 var fields = data[obj].fields;
                 if (fields.keyword.type=='keyword') {
                    var data_array = getdata(obj)
                    text_keywords.push(
                    {
                       "id":i,
                       "name":""+data_array.detail+"",
                       "sort":data_array.id,"field":""+obj+"",
                       "urlimage":""+data_array.images+""
                   }
                   );
                }
            }else{
             if (data[obj].type=='keyword') {
                var data_array = getdata(obj)
                text_keywords.push(
                {
                   "id":i,
                   "name":""+data_array.detail+"",
                   "sort":data_array.id,"field":""+obj+"",
                   "urlimage":""+data_array.images+""
               }
               );
            }
        }

    }
}

i++;
});
   }


   function dynamicSort(property) {
     return function(a, b) {
        return (a[property] < b[property]) ? -1 : (a[property] > b[property]) ? 1 : 0;
    }
}

text_keywords.sort(dynamicSort('id')).sort(dynamicSort('name'));


showTextKeywords(text_keywords);

function showTextKeywords(array) {
    var dataTextKeywords = [];
    $.each(array, function(i) {
     var image = 'none.png';
     var color = 'info';
     var icon = 'plus';
     var textbutton = 'เพิ่มข้อมูล!';
     var page = 'create&key='+array[i].field;
     if (array[i].sort!=null) {
      image = array[i].urlimage;
      color = 'danger';
      icon = 'edit';
      textbutton = 'แก้ไขข้อมูล!';
      page = 'update&id='+array[i].sort;
  }

  dataTextKeywords.push(`
      <div class="sub" data-id="${array[i].id}" data-name="${array[i].name}" data-sort="${array[i].sort}" data-field="${array[i].field}" data-urlimage="${image}">${array[i].name} <a onclick="window.open('index.php?r=description-keywords/${page}');" href="#"><span class="tag tag-${color}" style="cursor: pointer;display: inline-block;font-size: 10px;position: absolute;
      right: 24px;padding: 5px;" data-toggle="tooltip" data-placement="bottom" title="${textbutton}"><i class="fa fa-${icon}" aria-hidden="true"></i></span></a></div>
      `);

});
    $("#keyword-list").html(dataTextKeywords.join(" "));
}


function getdata(val){
    var type_select = '';
    var data = null;
    var data = $.ajax({
     url:"index.php?r=site/json_description_keywords&type=show&key="+val,
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

var sub_id = '';
var sub_name = '';
var sort = '';
var field = '';
var urlimage = '';
var arraymain = [];
for (i = 0; i < text_keywords.length; i++) {
    if (text_keywords[i]['sort'] != null) {
     if (parseInt(text_keywords.length-i)<4) {

      arraymain.push({"id":text_keywords[i]['id'],"name":""+text_keywords[i]['name']+"","sort":text_keywords[i]['id'],"field":""+text_keywords[i]['field']+"","urlimage":""+text_keywords[i]['urlimage']+""});
  }
}

}


var settings_graph_group = {
    "async": false,
    "crossDomain": true,
    "url": "index.php?r=site/json_graph_group",
    "method": "GET",
    "headers": {
        "content-type": "application/json",
    },
    "global": false,
    "dataType": "json",
}

var _data_graph_group = null;
var _data_graph_group = $.ajax(settings_graph_group).done(function (response) {
    return response;
}).responseJSON;


var show_graph_group = [];
var data = _data_graph_group;
for (i = 0; i < data.length; i++) {
    var id = data[i]['id'];
    var name = data[i]['name'];

    var detail = "";
    var array_detail = data[i]['detail'];
    var x = 0;
    $.each( array_detail, function(i) {

        detail += `<div class="sub" data-id="${x+10000000}" data-name="${array_detail[i].label}" data-sort="${array_detail[i].sort}" data-field="${array_detail[i].key}" data-urlimage="none.png" data-role="draggable">${array_detail[i].label}</div>`;
        x++;
    });


    show_graph_group.push(`

        <div class="card card-collapsed">
        <div class="card-status card-status-left bg-blue"></div>
        <div class="card-header bline">
        <h3 class="card-title">${name}</h3>
        <div class="card-options">
        <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
        </div>
        </div>
        <div class="card-body card-body-height div-scrollbar-fix">
        ${detail}
        </div>
        </div>

        `);

}

$("#show-graph-group").html(show_graph_group.join(" "));


$(".sub").kendoDraggable({
    group: "subGroup",
    hint: function(element) {
       sub_id = $(element).attr("data-id");
       sub_name = $(element).attr("data-name");
       sort = $(element).attr("data-sort");
       field = $(element).attr("data-field");
       urlimage = $(element).attr("data-urlimage");
       return element.clone();
   }
});


$("#mainArea").kendoDropTarget({ 
    group: "subGroup",
    drop : function( event, ui ){
       Drop(sub_id,sub_name,sort,field,urlimage);
   }
});


loaddrophere();


for_match();
function for_match(){
    var vertices = [];
    $.each(arraymain, function(index) {
       vertices.push(
       {
          "field": ""+arraymain[index].field+".keyword",
          "size": 10,
          "min_doc_count": 3
      }
      );
   });

    var match = [
    {
       "query": {
          "match_all": {}
      },
      "controls": {
          "use_significance": true,
          "sample_size": 2000,
          "timeout": 5000
      },
      "connections": {
          "vertices": vertices
      },
      "vertices": vertices
  }
  ];

  loadData(match);
}

function loadData(match){
    var DIR = '../../images_keywords/';
    var nodes = null;
    var edges = null;
    var network = null;
    var arrayStg = [];
    var arrayEdges = [];
    var WIDTH_SCALE = 1;

    var settings = {
       "async": true,
       "crossDomain": true,
       "url": "<?=$url_elasticsearch?>//_graph/explore",
       "method": "POST",
       "headers": {
          "Authorization": "Basic " + btoa("elastic:changeme"),
          "content-type": "application/json",
      },
      "processData": false,
      "data": ""+JSON.stringify(match[0])+""
  }

  $.ajax(settings).done(function (response) {
   $(".show_match").val(JSON.stringify(match[0]));

   var connections = response.connections;
   var vertices = response.vertices;

   for (i = 0; i < vertices.length; i++) {
      var field = vertices[i]['field'].replace(".keyword", "");
      var urlimage = arraymain.find(x => x.field === field).urlimage;

      arrayStg.push(
      {
         "id": i,
         "shape": "circularImage",
         "image": DIR+""+urlimage+"",
         "label": ""+vertices[i]['term']+"",
         "field": ""+field+"",
     }
     );
  }


  $.each(connections, function(i) {
      var from = arrayStg[connections[i].source].label;
      var to = arrayStg[connections[i].target].label;
      arrayEdges.push(
      {
         from: connections[i].source, 
         to: connections[i].target,
							// length: 10,
						// value: connections[i].doc_count,
						// value:1,
						// width: WIDTH_SCALE * connections[i].doc_count,
						// label: from+" - "+to,
						font: { align: "middle", size:"11" }
					}
					);
  });


  draw(arrayStg,arrayEdges);

});
}


function Drop(sub_id,sub_name,sort,field,urlimage) {
    var objIndex = arraymain.findIndex((obj => obj.id == sub_id));
    if (objIndex == -1) {
       arraymain.push({id:sub_id,name:sub_name,sort:sort,field:field,urlimage:urlimage});
       loaddrophere();
       for_match();
   }

}

$(document).on('click', '.del-sub', function(){
    myarray = [];
    var id = $(this).data('id');

    $.each(arraymain, function(i, el){
       if (this.id == id){
          arraymain.splice(i, 1);
      }
  });

    loaddrophere();
    for_match();

});

function loaddrophere(){
    myarray = [];
    $.each(arraymain, function(index) {
       myarray.push(`<div class="sub-in-main">${arraymain[index].name} <i class="fe fe-x del-sub" data-id="${arraymain[index].id}" data-sort="${arraymain[index].sort}" data-original-title="fe fe-x"></i></div>`);
   });

    $("#drop-list").html(myarray.join(" "));
				// console.log(arraymain);
			}



			function onDrop(e) {
				e.draggable.destroy();
				e.draggable.element.remove();
			}

			function draw(arrayStg,arrayEdges) {
				nodes = arrayStg;
				edges = arrayEdges;

                var container = document.getElementById('mynetwork');
                var data = {
                 nodes: nodes,
                 edges: edges
             };
             var options = {
                 physics: {
                  hierarchicalRepulsion: {
                   nodeDistance: 200
               },
               solver: 'hierarchicalRepulsion',
               enabled:true,
               barnesHut: {
                   gravitationalConstant: -50000,
                   centralGravity: 0,
                   damping: 0,
                   avoidOverlap: 0,
                   springLength: 0,
               },
               maxVelocity: 0.01,
               minVelocity: 0,
               timestep: 0.01,
               stabilization: true,
           },
           nodes: {
              borderWidth:1,
              size:15,
              labelHighlightBold:true,
              color: {
               border: '#004660',
               background: '#ffffff',
               highlight: {
                border: "#007bff",
                background: "white",
            },
            hover:{
                border: "#000000",
                background: "white",
            }
        },
        font:{color:'#212121',size: 15}
    },
    edges: {
						// color: '#CBD0D9',
						color: {
							color:'#CBD0D9',
							highlight:'#007bff',
							// hover: '#848484',
							inherit: 'from',
							opacity:1.0
						},
						smooth: false,
                        chosen: true,
                        chosen: {
                           label: function (values, id, selected, hovering) {
								// values.size = 15;
								// values.mod = 'bold';
								// values.color = "#212121";
								console.log(values.size);
							}
						}
					},
				};
				network = new vis.Network(container, data, options);
				network.on('click', function(properties) {
					var ids = properties.nodes;
					if (ids.length>0) {
						showdata_graph(ids);
					}
				});
                network.on("selectEdge", function(params) {     
                    if ((params.edges.length == 1) && (params.nodes.length == 0)) {
                        var edgeId = params.edges[0];
                        var nodes_edges = edges.find(x => x.id === ""+edgeId+"");

                        var nodes_form = nodes.find(x => x.id === nodes_edges.from).label;

                        var nodes_to = nodes.find(x => x.id === nodes_edges.to).label;
                        $(".head_node").html('<dt>ข้อมูลที่สัมพันธ์กัน</dt>');
                        $(".detail_node").css("display", "block");
                        $(".body_node").html(`${nodes_form} - ${nodes_to}`); 
                    }
                });

            }


            function showdata_graph(id){
				// $("#modal-title-show").html('<dt>'+nodes[id].label+'</dt>');
				// $("#modal-true").css("display", "block");
				$(".head_node").html('<dt>'+nodes[id].label+'</dt>');
				$(".detail_node").css("display", "block");

				var show_relation = [];

				let form = edges.filter(function(item) {
					return [id[0]].indexOf(item.from) != -1;
				});

				var get_idnode1 = [];
				if (form.length>0) {
					$.each(form, function(i) {
						get_idnode1.push(form[i].to);
					});
				}

				let to = edges.filter(function(item) {
					return [id[0]].indexOf(item.to) != -1;
				});

				var get_idnode2 = [];
				if (to.length>0) {
					$.each(to, function(i) {
						get_idnode2.push(to[i].from);
					});
				}

				var c = get_idnode1.concat(get_idnode2);
				var all_nodes = c.filter((item, pos) => c.indexOf(item) === pos);

				all_nodes.push(id[0]);

				var relationship = [];
				$.each(nodes, function(i) {
					var Index = all_nodes.findIndex((obj => obj == i));
					if (Index != -1) {
						relationship.push(
						{
							"id": i,
							"label": ""+nodes[i]['label']+"",
							"field": ""+nodes[i]['field']+"",
						}
						);

						if (i!=id[0]) {
							var must = {
								field:""+nodes[id[0]]['field']+"",
								label:""+nodes[id[0]]['label']+""
							};

							var should = 
							{
								field:""+nodes[i]['field']+"",
								label:""+nodes[i]['label']+""
							}
							// getsome_data(must,should)
							// var data_search = getsome_data(must,should);
							//
							show_relation.push(
								`- ${nodes[i]['label']}` 
								);
						}
					}
				});

				var match_terms = [];
				var match_must = [];
				$.each(relationship, function(i) {
					if (relationship[i].id!=id[0]) {
						match_terms.push(
							`
							{
								"terms": {
									"${relationship[i].field}": ["${relationship[i].label}"]
								}
							}
							`
							);
					}else{
						match_must.push(
							`
							{
								"match": {
									"${relationship[i].field}": "${relationship[i].label}"
								}
							}
							`
							);
					}
				});
				var res = match_terms.join(",");
				var res_use = res.slice(0, -1);
				var match_query_terms = JSON.parse('['+res_use+']');

				var res2 = match_must.join("");
				var match_query_must = JSON.parse('['+res2+']');

				var match = {
					"query": {
						"bool" : {
							"must": match_query_must,
							"should" : match_query_terms
						}
					}
				};

				//console.log(JSON.stringify(match));

				/* var match2 = { size:50 };

				var form_data = new FormData();
				form_data.append("query", ""+JSON.stringify(match)+"");

				var _dataall;
				_dataall = $.ajax({
					url: "index.php?r=site/elastic-getdata",
					method: "POST",
					processData: false,
					contentType: false,
					mimeType: "multipart/form-data",
					data: form_data,
					global: false,
					dataType: "json",
					async: false,
					crossDomain: true,
					success: function(response){
						return response;
					}
				}).responseJSON;

				// console.log(_dataall);
				*/
				console.log(show_relation);
				var show_data = ''
				if (show_relation.length>0) {
					show_data = `สัมพันธ์กับข้อมูล<hr> ${show_relation.join("<br> ")} <hr>`;
				}

				// $("#relationship_show").html(`${show_data} ทั้งหมด <b>${_dataall.hits.total.value}</b> รายการ`);
				//$(".body_node").html(`${show_data} ทั้งหมด <b>${_dataall.hits.total.value}</b> รายการ`); 
				$(".body_node").html(`${show_data} `); 

			}

			$(document).on('click', '.close-modal', function(){
				$("#modal-true").css("display", "none");
				$("#modal-false").css("display", "none");
				$(".detail_node").css("display", "none");
			});

			function getsome_data(must,should){
				var match_must = `
				{
					"match": {
						"${must.field}": "${must.label}"
					}
				}
				`;
				var query_match_must = JSON.parse('['+match_must+']');

				var match_should = `
				{
					"terms": {
						"${should.field}": ["${should.label}"]
					}
				}
				`;
				var query_match_should = JSON.parse('['+match_should+']');

				var match = {
					"query": {
						"bool" : {
							"must": query_match_must,
							"should" : query_match_should
						}
					}
				};

				var _data;
				_data = $.ajax({
					url: "<?=$url_elasticsearch?>/_search",
					method: "POST",
					headers: {
						"Authorization": "Basic " + btoa("elastic:changeme"),
						"content-type": "application/json",
					},
					processData: false,
					data: ""+JSON.stringify(match)+"",
					global: false,
					dataType: "json",
					async: false,
					crossDomain: true,
					success: function(response){
						return response;
					}
				}).responseJSON;

				return _data.hits;
			}





		});
	</script>

