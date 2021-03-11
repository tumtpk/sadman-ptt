<?
            require '../../Credis/Client.php'; 
            //if(!$redis) $redis = new Credis_Client($_SERVER['REMOTE_ADDR'],6379);
            if(!$redis) $redis = new Credis_Client('172.26.0.1',6379); 
            //if(!$redis) $redis = new Credis_Client('127.0.0.1',6379);

            
            $redis->set('name', 'วิทยา พันดวง');
            echo $redis->get('name');

            echo '<br>[name exit ? '.$redis->EXISTS('name').']';
            echo '<br>['.$redis->EXISTS('lastname').']<br>';

            $redis->DEL('name');
            echo '<br>['.$redis->EXISTS('name').']<br>';

            if($redis->EXISTS('blognone_content')==0){ 
                    $html = file_get_contents('https://www.blognone.com/node/117395'); 
                    $redis->set('blognone_content', $html);  
            }
            
            echo $redis->get('blognone_content');    
            // 


           

?>