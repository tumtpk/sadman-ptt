<?
    require '../../Credis/Client.php'; 
    if(!$redis) $redis = new Credis_Client('172.26.0.1',6379); 
?>