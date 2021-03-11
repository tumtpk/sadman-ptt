<?php
$this->title = 'Vis Network | Node Styles | Circular Images';
?>

<style type="text/css">
  body {
    font: 10pt arial;
  }
  #mynetwork {
    width: 100%;
    height: 1000px;
    border: 1px solid lightgray;
    background-color:#333333;
  }
</style>

<?php 
$main = Yii::$app->db->createCommand("SELECT * FROM `setting` WHERE `setting_name` = 'url_elasticsearch'")->queryone();
$sub = Yii::$app->db->createCommand("SELECT * FROM `setting` WHERE `setting_name` = 'index'")->queryone();
?>

<script type="text/javascript" src="https://visjs.github.io/vis-network/standalone/umd/vis-network.min.js"></script>
<script type="text/javascript">
  $( document ).ready(function() {

    var DIR = 'img/soft-scraps-icons/';
    var nodes = null;
    var edges = null;
    var network = null;
    // var stg = <?//=$_GET['jsoncondition']?>;
    var arrayStg = [];
    var arrayEdges = [];

      // console.log(stg);

     //  $.ajax({
     //    method: "GET",
     //    url: '<?=$main['setting_value'].''.$sub['setting_value'];?>/_search',
     //    crossDomain: true,
     //    data: stg,
     //    error: function(e) {
     //      console.log(e);
     //    },
     //    dataType: "json",
     //    contentType: "application/json"        
     //  })
     //  .done(function( msg ) {
     //    var data = msg.hits.hits;
     //    var len = data.length;
     //    // console.log(data);
     //    for (i = 0; i < len; i++) {
     //     var showjson = JSON.stringify(data[i]._source, undefined, 4);
     //     var name = JSON.stringify(data[i]._source.name);
     //     var len_img = data[i]._source.images.length;
     //     arrayStg.push({id: i+1, shape: 'circularImage', image: data[i]._source.images[Math.floor(Math.random() * len_img)], label:name});

     //     //edges
     //     var unit = JSON.stringify(data[i]._source.unit);
     //     var type = JSON.stringify(data[i]._source.type);
     //     var form_version = data[i]._source.form_version;
     //     arrayEdges.push({from: i+1, to: i+2});


     //   }
       
     //   draw(arrayStg,arrayEdges);
     // }); 
    
     arrayStg = [{
  "id": 1,
  "shape": "circularImage",
  "image": "http://dummyimage.com/152x193.jpg/dddddd/000000",
  "label": "Bamity"
}, {
  "id": 2,
  "shape": "circularImage",
  "image": "http://dummyimage.com/176x118.bmp/ff4444/ffffff",
  "label": "Solarbreeze"
}, {
  "id": 3,
  "shape": "circularImage",
  "image": "http://dummyimage.com/205x207.bmp/5fa2dd/ffffff",
  "label": "Bigtax"
}, {
  "id": 4,
  "shape": "circularImage",
  "image": "http://dummyimage.com/131x113.jpg/dddddd/000000",
  "label": "Greenlam"
}, {
  "id": 5,
  "shape": "circularImage",
  "image": "http://dummyimage.com/163x119.jpg/ff4444/ffffff",
  "label": "Keylex"
}, {
  "id": 6,
  "shape": "circularImage",
  "image": "http://dummyimage.com/134x240.jpg/cc0000/ffffff",
  "label": "Lotstring"
}, {
  "id": 7,
  "shape": "circularImage",
  "image": "http://dummyimage.com/115x197.png/ff4444/ffffff",
  "label": "Alphazap"
}, {
  "id": 8,
  "shape": "circularImage",
  "image": "http://dummyimage.com/215x164.bmp/5fa2dd/ffffff",
  "label": "Quo Lux"
}, {
  "id": 9,
  "shape": "circularImage",
  "image": "http://dummyimage.com/231x227.jpg/ff4444/ffffff",
  "label": "Subin"
}, {
  "id": 10,
  "shape": "circularImage",
  "image": "http://dummyimage.com/111x140.bmp/dddddd/000000",
  "label": "Overhold"
}, {
  "id": 11,
  "shape": "circularImage",
  "image": "http://dummyimage.com/100x227.jpg/ff4444/ffffff",
  "label": "Domainer"
}, {
  "id": 12,
  "shape": "circularImage",
  "image": "http://dummyimage.com/135x168.jpg/5fa2dd/ffffff",
  "label": "Konklux"
}, {
  "id": 13,
  "shape": "circularImage",
  "image": "http://dummyimage.com/198x222.jpg/cc0000/ffffff",
  "label": "Latlux"
}, {
  "id": 14,
  "shape": "circularImage",
  "image": "http://dummyimage.com/118x108.jpg/cc0000/ffffff",
  "label": "Lotlux"
}, {
  "id": 15,
  "shape": "circularImage",
  "image": "http://dummyimage.com/191x152.bmp/dddddd/000000",
  "label": "Voltsillam"
}, {
  "id": 16,
  "shape": "circularImage",
  "image": "http://dummyimage.com/210x203.bmp/cc0000/ffffff",
  "label": "Toughjoyfax"
}, {
  "id": 17,
  "shape": "circularImage",
  "image": "http://dummyimage.com/125x153.bmp/cc0000/ffffff",
  "label": "Home Ing"
}, {
  "id": 18,
  "shape": "circularImage",
  "image": "http://dummyimage.com/233x126.jpg/cc0000/ffffff",
  "label": "Flowdesk"
}, {
  "id": 19,
  "shape": "circularImage",
  "image": "http://dummyimage.com/113x126.bmp/ff4444/ffffff",
  "label": "Tres-Zap"
}, {
  "id": 20,
  "shape": "circularImage",
  "image": "http://dummyimage.com/115x167.png/cc0000/ffffff",
  "label": "Trippledex"
}];
    draw(arrayStg,arrayEdges);
    // Called when the Visualization API is loaded.
    function draw(arrayStg,edges) {
      // create people.
      // value corresponds with the age of the person
      var DIR = '../img/indonesia/';
      nodes = arrayStg;

      
      // create connections between people
      // value corresponds with the amount of contact between two people
      // console.log(edges);
      edges5 = [
      {from: 1, to: 2},
      {from: 2, to: 3},
      {from: 2, to: 4},
      {from: 4, to: 5},
      {from: 4, to: 10},
      {from: 4, to: 6},
      {from: 6, to: 7},
      {from: 7, to: 8},
      {from: 8, to: 9},
      {from: 8, to: 10},
      {from: 10, to: 11},
      {from: 11, to: 12},
      {from: 12, to: 13},
      {from: 13, to: 14},
      {from: 9, to: 16}
      ];

      // create a network
      var container = document.getElementById('mynetwork');
      var data = {
        nodes: nodes,
        edges: edges5
      };
      var options = {
        nodes: {
          borderWidth:4,
          size:30,
          color: {
            border: '#222222',
            background: '#666666'
          },
          font:{color:'#eeeeee'}
        },
        edges: {
          color: 'lightgray'
        }
      };
      network = new vis.Network(container, data, options);
    }

  });

</script>

<div id="mynetwork"></div>
