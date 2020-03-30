<?php

function vt_test_submit()
{
$options_r = get_option('virustracker_plugin_options');

    if(get_user_role() === "administrator" || get_user_role() === "um_verificators")  {
    //print_r($_POST);die;
            if(strlen($_POST['vt_verification'])<=0)   {  ?><meta http-equiv="refresh" content="0;url=/?page_id=325&error=empty"><?php die; }
            $attestestion = hash_hmac("sha256", $_POST['vt_verification'].$_POST['vt_result'], $options_r['api_key'], true);
            $certification= array(
                "attestation_hash_prefix" => $_POST['vt_verification'],
                "result" => $_POST['vt_result'],
                "attestation" => base64_encode($attestestion)
            );
            $body = array(
                "certification" => $certification
            );  ;
          $result= CurlPost($options_r['server_url'],$body);
          //echo $result;die;
          if($result!=200){
               ?><meta http-equiv="refresh" content="0;url=/?page_id=325&error=server"><?php
          }
    }
}
add_shortcode( 'vt_test_submit', 'vt_test_submit' );


function CurlPost($sURL,$sMessage = "")
{

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_URL, $sURL);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt ($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($sMessage));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

    $sResult = curl_exec($ch);

    if (curl_errno($ch)) 
    {
        // Fehlerausgabe
        print curl_error($ch); 
    } else 
    {
        // Kein Fehler, Ergebnis zurückliefern:
        $result=curl_getinfo($ch)['http_code'];

        //print_r(curl_getinfo ($ch));     die;
        curl_close($ch);

        return $result;
    }    
}



