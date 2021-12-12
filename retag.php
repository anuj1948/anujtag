<?php
include 'lib.php';


function untag($post_id,$Cookie,$ua){
    $url= 'media/'.$post_id.'/edit_media/';
    $data =hook('{"usertags":"{\"removed\":[\"3999276825\"]}"}');
    $action = request(1,$ua,$url,$Cookie,$data) ;
    return $action[1];

}

function position(){
    $position =array("[0.1,0.1]","[0.1,0.8]", "[0.8,0.1]", "[0.8,0.8]", "[0.5,0.1]","[0.1,0.5]");
    return $position[array_rand($position)];
}

function tags(){
    $tags =array("2302078745" );
    return $tags[array_rand($tags)];
}


function tag($post_id,$Cookie,$ua){

    $sendt= tags() ;
    $url= 'media/'.$post_id.'/edit_media/';
    $data= hook('{"usertags":"{\"in\":[{\"position\":'.position().',\"user_id\":\"'.$sendt.'\"}]}"}');
    $action = request(1,$ua,$url,$Cookie,$data) ;
    return $action[1];
}

echo "
 *  INSTAGRAM  Retager [v 3.01]
 *  STATUS @BETA
 *  RECOMMENDED SLEEP 300s
  
    •••••••••••••••••••••••••••••••••••••••••
    
 * Use tools at your own risk.
 * Make sure termux runs always on background.
 * Use this Tool for personal use, not for sale.
 * Make sure your account has been verified (Email & Telp).
 
".PHP_EOL;

echo PHP_EOL.'•••••••••••••••••••••••••••••••••••••••••' . PHP_EOL;
//
echo "[>] Username: ";
$username = read();
echo "[>] Password: ";
$password = read();
echo "[>] Sleep in Seconds ( RECOMMENDED 220 ) : ";
$sleep = read();
echo "\n";

//
//$username = "shibanashiq";


$login = json_decode(instagram_login($username,$password));


if ($login->result){
    echo PHP_EOL." login successfully ".PHP_EOL;
    $Cookie = $login->cookies;
    $ua = $login->useragent;
    $id = $login->id;


    while (true):

    $info = request(1,$ua,'feed/user/'.$id.'/',$Cookie) ;
    $items = json_decode($info[1]);
    $post = $items->items[0];
    if ($post != null){
        $post_id = $post->id;

        echo PHP_EOL."Post Id --> ".$post_id.PHP_EOL;
        $untag = json_decode(untag($post_id,$Cookie,$ua));
        if ($untag->status == "ok"){

            echo PHP_EOL." Untag -> ok  ".PHP_EOL;

        }else{

            echo PHP_EOL." Untag -> fail  ".PHP_EOL;
        }

        sleep(5);

        $tag = json_decode(tag($post_id,$Cookie,$ua));
        if ($tag->status == "ok"){

            echo PHP_EOL." tag -> ok  ".PHP_EOL;

        }else{

            echo PHP_EOL." tag -> fail  ".PHP_EOL;
        }


    }else{

        echo PHP_EOL." No Posts  ".PHP_EOL;

    }

        echo PHP_EOL.'•••••••••••••••••••••••••••••••••••••••••' . PHP_EOL;
        echo PHP_EOL."Sleep  Time $sleep".PHP_EOL;
    sleep($sleep);
    endwhile;






}else{
    die(PHP_EOL.$login->msg.PHP_EOL);

}








