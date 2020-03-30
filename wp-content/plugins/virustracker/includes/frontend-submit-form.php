<?PHP

function vt_render_form()
{
$options_r = get_option('virustracker_plugin_options');
//print_r($options_r);
    if(get_user_role() === "administrator" || get_user_role() === "um_verificators")  {
        return ($_GET['error']=='server'?'<h3 style="color:red">Server is not accepting the result</h3><br />':'').'<form action="/?page_id='.$options_r['submit_page'].'" method="post">
        <label for="vt_verification">Code '.($_GET['error']=='empty'?'<span style="color:red">is required</span>':'').'</label><input type="text"  id="vt_verification" name="vt_verification" />
     <!--   <label for="vt_result">Result</label><select id="vt_result" name="vt_result">
            <option value="POSITIVE">Positive</option>
            <option value="NEGATIVE">Negative</option>
        </select>
        <input type="submit"  id="vt_submit" name="vt_submit" value="Send" />   -->
        <button style="width:49%;background-color:green" name="vt_result" value="POSITIVE" type="submit">POSITIVE </button>
        <button style="width:49%;background-color:red" name="vt_result" value="NEGATIVE" type="submit">NEGATIVE </button>
        </form>'; 
    }
}
add_shortcode( 'vt_render_form', 'vt_render_form' );

function get_user_role(){
    $user_id = get_current_user_id();
    $user_info = get_userdata( $user_id );
    $user_roles = $user_info->roles[0];
    return $user_roles;
}
