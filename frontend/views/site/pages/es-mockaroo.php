<?php
    use app\models\Setting;

    $url_kibana =  $Setting = Setting::find()->where(['setting_name' => 'url_kibana'])->one()->setting_value;
    $url_elasticsearch =  $Setting = Setting::find()->where(['setting_name' => 'url_elasticsearch'])->one()->setting_value;
    $index =  $Setting = Setting::find()->where(['setting_name' => 'index'])->one()->setting_value;
    
    
    //'deceasedth'=>'https://my.api.mockaroo.com/1_deceased-th.json?key=b39012f0',
    $api = array(
                       'news'=>'https://my.api.mockaroo.com/1_1_news.json?key=b39012f0',
              'inquire-query'=>'https://my.api.mockaroo.com/1_2_inquiry-report.json?key=b39012f0',
                   'deceased'=>'https://my.api.mockaroo.com/1_deceased.json?key=b39012f0',
             'suspect-object'=>'https://my.api.mockaroo.com/2_1_suspect-object.json?key=b39012f0',
             'suspect-person'=>'https://my.api.mockaroo.com/2_2_suspect-person.json?key=b39012f0',
        'person-surveillance'=>'https://my.api.mockaroo.com/2_3_person-surveillance.json?key=b39012f0',
                     'urgent'=>'https://my.api.mockaroo.com/2_5_urgent.json?key=b39012f0',
                  'equipment'=>'https://my.api.mockaroo.com/3_equipment.json?key=b39012f0',
                 'undercover'=>'https://my.api.mockaroo.com/4_undercover.json?key=b39012f0',
                'access_logs'=>'https://my.api.mockaroo.com/5_access_logs.json?key=b39012f0',
                       'unit'=>'https://my.api.mockaroo.com/unit.json?key=b39012f0'
                  //'appsearch'=>'https://my.api.mockaroo.com/appserach.json?key=b39012f0',
                    //'weather'=>'https://my.api.mockaroo.com/weather.json?key=b39012f0',
                    //   'Data'=>'https://my.api.mockaroo.com/data.json?key=b39012f0',
); 

    $index = 'textxdb_v2';
?>
<button Onclick="bulk();" class="btn btn-success">BULK</button> 
<button Onclick="sendAppSearch();" class="btn btn-success">sendAppSearch</button>
<button Onclick="whenF();" class="btn btn-success">WHEN</button> <br><br><br>
<div id="result"></div>

<script>
function sendAppSearch(data){
  $.post("index.php?r=site/appsearch", {data : data} , function(result){
            $("#result").html(result);
    });
}    


function bulk(){
var data = '{ "index":{ "_index": "textxdb"} }\n'+ 
            '{ "name":"john doe","age":25 }\n'+
            '{ "index":{ "_index": "textxdb"} }\n'+ 
            '{ "name":"fido","breed":"xxxxx" }'; 
    $.ajax({
            type: "POST",
            crossDomain: true, 
            async: false,
            url: '<?=$url_elasticsearch?>/<?=$index?>/_bulk', // 119.59.113.234        
            data: (data),
            dataType: "json",
            contentType: "application/json; charset=utf-8",
            success: function (msg) 
                    { 
                        console.log(msg); 
                        //alert('find');
                    },
            error: function (err)
            { 
                console.log('error');    
                //alert('fail');
            }
    });
}    
function whenF(){
    console.log('Start when.....');
    $.when( 
            <?
                foreach($api as $x => $x_value) { 
            ?>
            sendToES('<?=$x_value?>','result1'), 

            <? } ?>
            /*sendToES('https://my.api.mockaroo.com/1_2_inquire-report.json?key=b39012f0','result1'),
            sendToES('https://my.api.mockaroo.com/1_deceased.json?key=b39012f0','result1'),
            sendToES('https://my.api.mockaroo.com/2_1_suspect-object.json?key=b39012f0','result1'),
            sendToES('https://my.api.mockaroo.com/2_2_suspect-person.json?key=b39012f0','result1'),
            sendToES('https://my.api.mockaroo.com/2_3_person-surveillance.json?key=b39012f0','result1'),
            sendToES('https://my.api.mockaroo.com/2_5_urgent.json?key=b39012f0','result1'),
            sendToES('https://my.api.mockaroo.com/3_equipment.json?key=b39012f0','result1'),
            sendToES('https://my.api.mockaroo.com/4_undercover.json?key=b39012f0','result1'),
            sendToES('https://my.api.mockaroo.com/5_access_logs.json?key=b39012f0','result1'),
            sendToES('https://my.api.mockaroo.com/unit.json?key=b39012f0','result1')*/
            
    )
    .then( myFunc, myFailure ); /**/
}
function myFunc(){
    console.log('Finish when.....');
}
function myFailure(){
    alert('Failure');
}
function sendToES(link,type){
        $.get( link, function( data ) {
            data.forEach(myFunction);
        });
}    
function myFunction(item, index) {
    setTimeout(function(){ putToIndex(item); }, 1000);
    
}
function putToIndex(jsondata){
    //console.log(jsondata.id);
    console.log(jsondata);
    //sendAppSearch(jsondata);
    $.ajax({
            type: "POST",
            crossDomain: true, 
            async: false,
            url: '<?=$url_elasticsearch?>/<?=$index?>/_doc/'+Math.floor(Math.random() * 10)+jsondata.id,        
            data: JSON.stringify(jsondata),
            dataType: "json",
            contentType: "application/json; charset=utf-8",
            headers: {
                 "Authorization": "Basic " + btoa("elastic:changeme")
            },
            success: function (msg) 
                    { 
                        console.log(msg); 
                        //alert("the json is "+ msg._index);
                        //$('#stage').html(msg._index );
                        //$('#stage').append(" type : "+msg._type );
                        //$('#stage').append(" id :"+msg._id)
                    },
            error: function (err)
            { 
                //console.log('error');    
                //alert(err.responseText);
            }
    }); 

} 
function deleteDocumentByQuery(type){
    var query = {
        "query": {
            "match": {
            "type": type
            }
        }
    };
    $.ajax({
            type: "POST",
            crossDomain: true, 
            async: false,
            url: '<?=$url_elasticsearch?>/<?=$index?>/_delete_by_query', // 119.59.113.234        
            data: JSON.stringify(query),
            dataType: "json",
            //username: 'elastic',
            //password: 'changeme',
            contentType: "application/json; charset=utf-8",
            headers: {
                 "Authorization": "Basic " + btoa("elastic:changeme")
            },
            success: function (msg) 
                    { 
                        console.log('success');     
                    },
            error: function (err)
            { 
                console.log('error');    
                
            }
    });

}
</script>
<div id="stage"></div>

<div class="col">
            <div class="alert alert-dark" role="alert">
            <h4 class="alert-heading">เพิ่ม ลบ ข้อมูลจาก Mockaroo</h4>
            <p>...</p>
            <hr>
            
                <div class="container">
                <?
                $i = 1;
                foreach($api as $x => $x_value) { ?>
                    <div class="row">
                        <div class="col-sm">
                        <input type="checkbox" id="vehicle2" name="vehicle2" value="Car">
                        <? echo '<button Onclick="sendToES(\''.$x_value.'\',\'result1\');" class="btn btn-success">'.$i.'.'.$x.'</button>'; ?>
                        </div>
                        <div class="col-sm">
                        <? echo '<button Onclick="deleteDocumentByQuery(\''.$x.'\');" class="btn btn-danger">Delete</button>'; ?>
                        </div>
                        <div class="col-sm">
                         
                        </div>
                    </div>
                <?              
                    //echo "<br>";
                    $i++;
                  }
                ?>    
                </div>       
            </div>
</div>
<!--
<button Onclick="sendToES('https://my.api.mockaroo.com/1_deceased-th.json?key=b39012f0','result1');" class="btn btn-success">deceased th</button> <br><br><br>



<button Onclick="sendToES('https://my.api.mockaroo.com/1_1_news.json?key=b39012f0','result1');" class="btn btn-success">news</button> 
<button Onclick="sendToES('https://my.api.mockaroo.com/1_2_inquire-report.json?key=b39012f0','result1');" class="btn btn-success">inquire-report</button> 
<button Onclick="sendToES('https://my.api.mockaroo.com/1_deceased.json?key=b39012f0','result1');" class="btn btn-success">deceased</button> 
<button Onclick="sendToES('https://my.api.mockaroo.com/2_1_suspect-object.json?key=b39012f0','result1');" class="btn btn-success">suspect-object</button> 
<button Onclick="sendToES('https://my.api.mockaroo.com/2_2_suspect-person.json?key=b39012f0','result1');" class="btn btn-success">suspect-person</button> 
<br><br><br>
<button Onclick="sendToES('https://my.api.mockaroo.com/2_3_person-surveillance.json?key=b39012f0','result1');" class="btn btn-success">person-surveillance</button> 
<button Onclick="sendToES('https://my.api.mockaroo.com/2_5_urgent.json?key=b39012f0','result1');" class="btn btn-success">urgent</button>
<button Onclick="sendToES('https://my.api.mockaroo.com/3_equipment.json?key=b39012f0','result1');" class="btn btn-success">equipment</button>
<button Onclick="sendToES('https://my.api.mockaroo.com/4_undercover.json?key=b39012f0','result1');" class="btn btn-success">undercover</button>
<button Onclick="sendToES('https://my.api.mockaroo.com/5_access_logs.json?key=b39012f0','result1');" class="btn btn-success">5_access_logs</button>
-->

<!-- <div class="row">
    <div class="col">
    https://my.api.mockaroo.com/1_1_news.json?key=b39012f0
    </div>
    <div class="col">
      <button Onclick="sendToES('https://my.api.mockaroo.com/1_1_news.json?key=b39012f0','result1');" class="btn btn-success">send</button>
    </div>
    <div class="col">
        <div id="result1"></div>
    </div>
  </div> -->

  <div id="demo"></div>
