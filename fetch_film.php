<?php
    
    if(!isset($_GET["title"])){
           exit;
        }
    $api_key='k_5w9vyeoh';
    $title=$_GET["title"];

    header('Content-Type: application/json');

    $curl = curl_init();
    curl_setopt($curl , CURLOPT_URL,"https://imdb-api.com/en/API/SearchMovie/".$api_key."/".$title);
    curl_setopt($curl , CURLOPT_RETURNTRANSFER,1);
    $result = curl_exec($curl);
    curl_close($curl);

    
    $result_json=json_decode($result,true);
    if($result_json['results']===null){
        print_r("massimo numero di richieste api giornaliere raggiunte");
        exit;
    }

    $final_json=array();
    
    $film_id=$result_json['results'][0]['id'];
    $curl = curl_init();
    curl_setopt($curl , CURLOPT_URL,"https://imdb-api.com/en/API/Ratings/".$api_key."/".$film_id);
    curl_setopt($curl , CURLOPT_RETURNTRANSFER,1);
    $result1 = curl_exec($curl);
    curl_close($curl);

    $result_json1=json_decode($result1,true);


    $final_json[]=array('title'=>$result_json['results'][0]['title']."".$result_json['results'][0]['description'],
    'image'=>$result_json['results'][0]['image'],'rating'=>$result_json1['imDb']);

    echo json_encode($final_json);

    

?>