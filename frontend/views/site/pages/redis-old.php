<?
            require '../../Credis/Client.php';
            if(!$redis) $redis = new Credis_Client($_SERVER['REMOTE_ADDR'],6379);
            $redis->set('name', 'วิทยา พันดวง');
            echo $redis->get('name');

            echo '<br>['.$redis->EXISTS('name').']';
            echo '<br>['.$redis->EXISTS('lastname').']<br>';

            $redis->DEL('name');
            echo '<br>['.$redis->EXISTS('name').']<br>';

            //echo sprintf('Is Credis awesome? %s.\n', $redis->get('name')); 
            //echo $_SERVER['REMOTE_ADDR'];
?>