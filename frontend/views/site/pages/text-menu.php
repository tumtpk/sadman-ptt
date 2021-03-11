<style type="text/css">
.active {
    color:red;
    font-weight:bold;
}
</style>
<?php

$server = $_SERVER['REQUEST_URI'];
$server = str_replace("/textx/textx/frontend/web/",'',$server);

$menu_main = Yii::$app->db->createCommand("SELECT * FROM `menu_sub`,`menu_main` WHERE menu_sub.menu_id = menu_main.id AND menu_sub.submenu_link = '".$server."'")->queryOne();
// echo $menu_main['id'];
echo "<br>";

$array_menu_main = Yii::$app->db->createCommand("SELECT * FROM `menu_main` WHERE m_status = 'Y' $where_main_id ORDER BY m_sort ASC")->queryAll();
foreach ($array_menu_main as $val_menu_main){
	// echo $val_menu_main['id'];
	?>
	<li class="<?php if($val_menu_main['id'] == $menu_main['id']){echo 'active'; }else { echo ''; } ?>">
		<a href="<?=$val_menu_main['m_link']?>">
			<i class="<?=$val_menu_main['m_icon'];?>"></i>
			<span><?=$val_menu_main['m_name'];?></span>
		</a>
		 <ul>
                <?php  $array_menu_sub = Yii::$app->db->createCommand("SELECT * FROM `menu_sub` WHERE submenu_active = 'Y' AND menu_id = '".$val_menu_main['id']."' ORDER BY submenu_sort ASC")->queryAll();
                foreach ($array_menu_sub as $val_menu_sub){
                    ?>  
                    <li>
                        <a href="<?=$val_menu_sub['submenu_link'];?>">
                            <span><?=$val_menu_sub['submenu_name'];?></span>
                        </a>
                    </li>
                <?php } ?>
            </ul>
	</li>
	<?
}
?>


 