<?

?>

<script>
function getData(){

            var queryBody = {
                            "query": {
                                "query_string": {
                                "fields": [ "content", "name" , "gender" ],
                                "query": "ชาย"
                                }
                            }
                            };

            $.ajax({
                url: 'http://localhost:9200/textxdb/_search',
                type: 'POST',
                contentType: 'application/json; charset=UTF-8',
                crossDomain: true,
                dataType: 'json',
               // username: "elastic", 
               // password: "changeme",
                data: JSON.stringify(queryBody),
                success: function(response) {
                        console.log(response.hits.hits)

                        var data = response.hits.hits;
                        var titleArray = [];
                        //alert(data.length);
                       /* if (data.length > 0) {
                        
                        if (data.length > 5)
                            data.length=5;
                        */
                        /*
                        for (var i = 0; i < data.length; i++) {              
                                if(data[i].fields.Title[0].indexOf(settings.fieldValue) > -1)
                                                {
                                                    titleArray.push(data[i].fields.DocumentID[0]+":"+data[i].fields.Title[0]);
                                                }
                                            }
                        responseS(titleArray);
                        titleArray=[];
                        } else {    }  */
                },
                error: function(jqXHR, textStatus, errorThrown) {
                            var jso = jQuery.parseJSON(jqXHR.responseText);
                            console.log('section', 'error', '(' + jqXHR.status + ') ' + errorThrown + ' --<br />' + jso.error);
                    }
            });

}

</script>
<br><br><br>
<button onClick="getData()" class="btn btn-success">GetData</button>
<button onClick="getData2()" class="btn btn-success">อยู่ในระยะ 1,200 KM</button>


<script>
        function getData2(){
            var data = {
                    "query": {
                        "bool": {
                            "must": {
                                "match_all": {}
                            },
                            "filter": {
                                "geo_distance": {
                                    "distance": "1200km",
                                    "coor": {
                                        "lat": 8.78564763,
                                        "lon": 99.67673645
                                    }
                                }
                            }
                        }
                    }
                    };

            $.ajax({
                method: "POST",
                url: "http://localhost:9200/textxdb/_search?pretty=true",
                crossDomain: true,  
                async: false,
                data: JSON.stringify(data),
                dataType : 'json',
                contentType: 'application/json',
                })
                .done(function( data ) {
                    console.log(data);
                })
                .fail(function( data ) {
                    console.log(data);
                });

        }
</script>