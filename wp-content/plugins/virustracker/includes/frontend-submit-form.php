<?PHP

function vt_render_form()
{
    $options_r = get_option('virustracker_plugin_options');
    if (get_user_role() === "administrator" || get_user_role() === "um_verificators") {
        return (strlen($_GET['VTerror']) > 0 ? '<span style="color:red">Wrong Code</span><br />' : '') . '<form action="/?page_id=' . $options_r['submit_page'] . '" method="post">
        <label for="vt_verification">Code</label><input type="text"  id="vt_verification" name="vt_verification" />
        <button style="width:49%;background-color:green" name="vt_result" value="POSITIVE" type="submit">POSITIVE </button>
        <button style="width:49%;background-color:red" name="vt_result" value="NEGATIVE" type="submit">NEGATIVE </button>
        </form>';
    }
}
add_shortcode('vt_render_form', 'vt_render_form');
/**
 * Is used by submit-test.php too
 */
function get_user_role()
{
    $user_id    = get_current_user_id();
    $user_info  = get_userdata($user_id);
    $user_roles = $user_info->roles[0];
    return $user_roles;
}