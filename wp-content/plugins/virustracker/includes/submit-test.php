<?php
/**
 * Main function to process data from submit form.
 */
function vt_test_submit()
{
    $VT_lab_id                  = 1; //FOR TEST ONLY
    $VT_lab_key                 = "wubwub"; //FOR TEST ONLY
    $VT_options_r               = get_option('virustracker_plugin_options');
    $VT_serverURL               = $VT_options_r['server_url'];
    $VT_attestation_hash_prefix = base64_decode($_POST['vt_verification']);
    $VT_result                  = $_POST['vt_result'];
    $VT_attestestion            = hash_hmac("sha256", $VT_attestation_hash_prefix . $VT_result, $VT_lab_key, true);
    
    if (get_user_role() === "administrator" || get_user_role() === "um_verificators") {
        vt_checkVars($_POST);
        
        
        $certification = array(
            "result" => $_POST['vt_result'],
            "attestation" => base64_encode($VT_attestestion),
            "lab_id" => $VT_lab_id
        );
        $body          = $certification;
        
        $VT_result = CurlPut($VT_serverURL . base64EncodeURL($VT_attestation_hash_prefix), $body);
    }
}

// Add Shortcode for wordpress to execute function
add_shortcode('vt_test_submit', 'vt_test_submit');
/**
 * Check incoming vars for errors
 */
function vt_checkVars($vars)
{
    if (strlen($_POST['vt_verification']) <= 0) {
        vt_redirect(getFormPageID(), "empty");
    }
}

/**
 * Get the ID of the Formula page from the options
 */
function getFormPageID()
{
    $VT_options_r = get_option('virustracker_plugin_options');
    return $VT_options_r['form_page'];
}

/**
 * Redirect User because of errors
 */
function vt_redirect($pageID, $error)
{
    wp_redirect("/?page_id=" . $pageID . "&VTerror=" . $error);
    die;
}
/**
 * Base64 encode and strip some chars for URL (same as python does)
 */
function base64EncodeURL($binary)
{
    return rtrim(strtr(base64_encode($binary), '+/', '-_'), '=');
}
/**
 * Send the Object to the server
 */
function CurlPut($sURL, $sMessage = "")
{
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_URL, $sURL);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($sMessage));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen(json_encode($sMessage))
    ));
    
    $sResult = curl_exec($ch);
    
    if (curl_errno($ch)) {
        // Fehlerausgabe
        print curl_error($ch);
    } else {
        // Kein Fehler, Ergebnis zurückliefern:
        $curlInfo  = curl_getinfo($ch);
        $VT_result = $curlInfo['http_code'];
        checkResult($VT_result);
        curl_close($ch);
        
        return $VT_result;
    }
}
/**
 * Check server answer for error codes
 */
function checkResult($VT_resultCode)
{
    if ($VT_resultCode == 200) {
        return true;
    } elseif ($VT_resultCode == 400) {
        vt_redirect(getFormPageID(), $VT_resultCode);
    } else {
        vt_redirect(getFormPageID(), $VT_resultCode);
    }
}