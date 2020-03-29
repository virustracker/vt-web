<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
function vt_test_submit()
{
$options_r = get_option('virustracker_plugin_options');
//print_r($options_r);
    if(get_user_role() === "administrator" || get_user_role() === "verificators")  {
          // Beispielaufruf mit POST-Variablen:
            $certification= array(
                "attestation_hash_prefix" => "12345678==",
                "result" => "NEGATIVE",
                "attestation" => "baffbaff=="
            );
            $body = array(
                "certification" => $certification
            );    
          //CurlPost("https://virustracker.ch/wp-content/plugins/virustracker/api-test.php",$body);
          CurlPost($options_r['server_url'],$body);
          //echo json_encode($body);die;
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
        print_r($sResult);die;
        curl_close($ch);

        return $sResult;
    }    
}



