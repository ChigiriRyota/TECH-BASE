
<!-- mission1-23.php foreach変数 -->
<?php
    $items = array("Ken","Alice","Judy","BOSS","Bob");
    // foreach(配列 as 変数)
    foreach($items as $item){
        if($item == "BOSS"){
            echo "Goodmorning $item!<br>";
        }else{
            echo "Hi! $item<br>";;
        }
    }
?>