<?php
use app\models\Setting;

$url_kibana =  $Setting = Setting::find()->where(['setting_name' => 'url_kibana'])->one()->setting_value;
$url_elasticsearch =  $Setting = Setting::find()->where(['setting_name' => 'url_elasticsearch'])->one()->setting_value;
$index =  $Setting = Setting::find()->where(['setting_name' => 'index'])->one()->setting_value;
?>
<!DOCTYPE HTML>
<html>
<head>
  <title>Timeline | styling | Templates</title>

  <!-- load handlebars for templating, and create a template -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.5/handlebars.min.js"></script>
  <script id="item-template" type="text/x-handlebars-template">
    <table class="score">
      <tr>
        <td colspan="3" class="description">{{description}}</td>
      </tr>
      <tr>
        <td>{{player1}}</td>
        <th>{{score1}} - {{score2}}</th>
        <td>{{player2}}</td>
      </tr>
      <tr>
        <td><img src="https://flagpedia.net/data/flags/mini/{{abbr1}}.png" width="31" height="20" alt="{{abbr1}}" /></td>
        <th></th>
        <td><img src="https://flagpedia.net/data/flags/mini/{{abbr2}}.png" width="31" height="20" alt="{{abbr2}}" /></td>
      </tr>
    </table>
  </script>

  <script src="https://visjs.github.io/vis-timeline/standalone/umd/vis-timeline-graph2d.min.js"></script>
  <link href="https://visjs.github.io/vis-timeline/styles/vis-timeline-graph2d.min.css" rel="stylesheet" type="text/css" />

  <style type="text/css">
    body, html {
      font-family: sans-serif;
      font-size: 10pt;
    }

    .vis.timeline .item {
      border-color: #acacac;
      background-color: #efefef;
      box-shadow: 5px 5px 10px rgba(128,128,128, 0.3);
    }

    table .description {
      font-style: italic;
    }

    #visualization {
      position: relative;
      overflow: hidden;
    }

    .logo {
      position: absolute;
      right: 10px;
      top: 10px;
    }
    .logo img {
      width: 120px;
    }
  </style>

  
</head>
<body>
  <h1>WK 2014</h1>
  <p style="max-width: 600px;">
    This example demonstrates using templates to format item contents. In this case <a href="https://handlebarsjs.com">handlebars</a> is used as template engine, but you can just use your favorite template engine or manually craft HTML from the data of an item.
  </p>

  <div id="visualization"></div>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script>


    $(document).ready(function(){
      var showdetail = [];
      var match = { size: 10 };
      $.ajax({
        method: "GET",
        url: "<?=$url_elasticsearch?>/<?=$index?>/_search",
        headers: {
         "Authorization": "Basic " + btoa("elastic:changeme"),
         "content-type": "application/json",
       },
       crossDomain: true,
       data: match

     })
      .done(function( msg ) {

        var data = msg.hits.hits;
        
        //console.log(data);
        for (i = 0; i < data.length; i++) {

          var showjson = JSON.stringify(data[i]._source, undefined, 4);
          var name = JSON.stringify(data[i]._source.name);
          var img = JSON.stringify(data[i]._source.urlmarker);
          var date_data = JSON.stringify(data[i]._source.date_data);
          var questioner = JSON.stringify(data[i]._source.questioner);

          // showdata.push(`<div class="card mt-4">
          //   <div class="card-body">
          //   <pre>${syntaxHighlight(showjson)}</pre>
          //   </div>
          //   </div>
          //   `);
          showdetail.push({
            player1: name,
            abbr1: 'br',
            score1: '1 (3)',
            player2: 'Chile',
            abbr2: 'cl',
            score2: '1 (2)',
            description: questioner,
            start: date_data
            });

        }
        showdetail = showdetail;
        console.log(showdetail);
      });
    });

  // create a handlebars template
  var source   = document.getElementById('item-template').innerHTML;
  var template = Handlebars.compile(document.getElementById('item-template').innerHTML);

  // DOM element where the Timeline will be attached
  var container = document.getElementById('visualization');

  // Create a DataSet (allows two way data-binding)
  //var items = new vis.DataSet(showdetail);
  var items = new vis.DataSet([
    // round of 16
    {
      player1: 'Brazil',
      abbr1: 'br',
      score1: '1 (3)',
      player2: 'Chile',
      abbr2: 'cl',
      score2: '1 (2)',
      description: 'round of 16',
      start: '2014-06-28T13:00:00'
    },
    {
      player1: 'Colombia',
      abbr1: 'co',
      score1: 2,
      player2: 'Uruguay',
      abbr2: 'uy',
      score2: 0,
      description: 'round of 16',
      start: '2014-06-28T17:00:00'
    },
    {
      player1: 'Netherlands',
      abbr1: 'nl',
      score1: 2,
      player2: 'Mexico',
      abbr2: 'mx',
      score2: 1,
      description: 'round of 16',
      start: '2014-06-29T13:00:00'
    },
    {
      player1: 'Costa Rica',
      abbr1: 'cr',
      score1: '1 (5)',
      player2: 'Greece',
      abbr2: 'gr',
      score2: '1 (3)',
      description: 'round of 16',
      start: '2014-06-29T17:00:00'
    },
    {
      player1: 'France',
      abbr1: 'fr',
      score1: 2,
      player2: 'Nigeria',
      abbr2: 'ng',
      score2: 0,
      description: 'round of 16',
      start: '2014-06-30T13:00:00'
    },
    {
      player1: 'Germany',
      abbr1: 'de',
      score1: 2,
      player2: 'Algeria',
      abbr2: 'dz',
      score2: 1,
      description: 'round of 16',
      start: '2014-06-30T17:00:00'
    },
    {
      player1: 'Argentina',
      abbr1: 'ar',
      score1: 1,
      player2: 'Switzerland',
      abbr2: 'ch',
      score2: 0,
      description: 'round of 16',
      start: '2014-07-01T13:00:00'
    },
    {
      player1: 'Belgium',
      abbr1: 'be',
      score1: 2,
      player2: 'USA',
      abbr2: 'us',
      score2: 1,
      description: 'round of 16',
      start: '2014-07-01T17:00:00'
    },

    // quarter-finals
    {
      player1: 'France',
      abbr1: 'fr',
      score1: 0,
      player2: 'Germany',
      abbr2: 'de',
      score2: 1,
      description: 'quarter-finals',
      start: '2014-07-04T13:00:00'
    },
    {
      player1: 'Brazil',
      abbr1: 'br',
      score1: 2,
      player2: 'Colombia',
      abbr2: 'co',
      score2: 1,
      description: 'quarter-finals',
      start: '2014-07-04T17:00:00'
    },
    {
      player1: 'Argentina',
      abbr1: 'ar',
      score1: 1,
      player2: 'Belgium',
      abbr2: 'be',
      score2: 0,
      description: 'quarter-finals',
      start: '2014-07-05T13:00:00'
    },
    {
      player1: 'Netherlands',
      abbr1: 'nl',
      score1: '0 (4)',
      player2: 'Costa Rica',
      abbr2: 'cr',
      score2: '0 (3)',
      description: 'quarter-finals',
      start: '2014-07-05T17:00:00'
    },

    // semi-finals
    {
      player1: 'Brazil',
      abbr1: 'br',
      score1: 1,
      player2: 'Germany',
      abbr2: 'de',
      score2: 7,
      description: 'semi-finals',
      start: '2014-07-08T17:00:00'
    },
    {
      player1: 'Netherlands',
      abbr1: 'nl',
      score1: '0 (2)',
      player2: 'Argentina',
      abbr2: 'ar',
      score2: '0 (4)',
      description: 'semi-finals',
      start: '2014-07-09T17:00:00'
    },

    // final
    {
      player1: 'Germany',
      score1: 1,
      abbr1: 'de',
      player2: 'Argentina',
      abbr2: 'ar',
      score2: 0,
      description: 'final',
      start: '2014-07-13T16:00:00'
    }
    ]);

  // Configuration for the Timeline
  var options = {
    // specify a template for the items
    template: template
  };

  // Create a Timeline
  var timeline = new vis.Timeline(container, items, options);
</script>
</body>
</html>
