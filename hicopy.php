<?php
add_filter('extra_plugin_headers', 'hicopy_add_extra_headers');

function hicopy_add_extra_headers(){
return array('Author2');
}
add_filter('plugin_row_meta', 'hicopy_filter_authors_row_meta', 1, 4);

function hicopy_filter_authors_row_meta($plugin_meta, $plugin_file, $plugin_data, $status ){

if(empty($plugin_data['Author'])){
    return $plugin_meta;
}


if ( !empty( $plugin_data['Author2'] ) ) {
    $plugin_meta[1] = $plugin_meta[1] . ' | ' . $plugin_data['Author2'];
}


return $plugin_meta;
}
/*
Plugin Name: Hicopy
Description: A Copy & Paste Marketing Tool. Add Your Customized Message When Users Copy Your Content.
Author: <a href="https://www.hicopy.co">Hicopy.co</a>
Author2: <a href="https://twitter.com/hicopyapp">@HicopyApp</a>
Version: 1.1
Author URI: https://twitter.com/hicopyapp
Text Domain: Hicopy
Copyright 2020 Hicopy
*/

if (!defined('ABSPATH')){
    die();
}

define('HICOPY_VERSION', '1.1');
define('HICOPY_PLUGIN_DIR', untrailingslashit( dirname(__FILE__)));
define('HICOPY_ADMIN_SLUG', 'hicopy');
define('HICOPY_DIR_NAME', plugin_basename(dirname(__FILE__)));
define('HICOPY_BASE_URL', plugins_url() . '/' . HICOPY_DIR_NAME);
define('HICOPY_BASE_PATH', plugin_dir_path( __FILE__ ));
define('HICOPY_DEFAULT_CONTENT', 'What do you want to tell your audience? Hicopy.co');

require_once( HICOPY_PLUGIN_DIR. '/inc/hicopy-functions.php');

add_action('plugins_loaded', 'HicopyStart');
register_activation_hook(__FILE__, 'HicopyActivate');

function HicopyStart() {
    if(is_admin()){
        add_action('admin_menu', 'HicopyAdminMenu');
        add_action('admin_enqueue_scripts','HicopyLoadAdminScripts');
    }else{
        add_action('wp_footer',  'HicopyAddContent');
        }
}
function HicopyLoadAdminScripts() {

    wp_enqueue_style( 'hicopy-admin-settings',HICOPY_BASE_URL.'/inc/admin/assets/css/hicopy-admin-settings.css', array(),HICOPY_VERSION,'all' );
    wp_enqueue_script('hicopy-admin-settings', HICOPY_BASE_URL . '/inc/admin/assets/js/hicopy-admin-settings.js', array(),HICOPY_VERSION);

   }

function HicopyAddContent() {


$options = get_option('hicopy_options');
$val = array_map( 'stripslashes_deep', $options );

if(strcmp($val['hicopy_enable_disable'], 'true') == 0){
    ?>

<script>

var ok = 0;

function CopyToClipboard( val ){
    var hiddenClipboard = jQuery('#_hiddenClipboard_');
    if(!hiddenClipboard.length){
        jQuery('body').append('<textarea style="position:absolute;top: -9999px;" id="_hiddenClipboard_"></textarea>');
        hiddenClipboard = jQuery('#_hiddenClipboard_');
    }
    hiddenClipboard.html(val);
    hiddenClipboard.select();
    document.execCommand('copy');
    document.getSelection().removeAllRanges();
    hiddenClipboard.remove();
       setTimeout(
        function()
        {
            ok =0;
        }, 300);
}

function CopyToClipboardMouse( val ){
    var hiddenClipboard = jQuery('#_hiddenClipboard_');
    if(!hiddenClipboard.length){
        jQuery('body').append('<textarea style="position:absolute;top: -9999px;" id="_hiddenClipboard_"></textarea>');
        hiddenClipboard = jQuery('#_hiddenClipboard_');
    }
    hiddenClipboard.html(val);
    hiddenClipboard.select();
    document.execCommand('copy');
    document.getSelection().removeAllRanges();
    hiddenClipboard.remove();
}

function AddContentToCopyToClipboard( e ){
   e = e || window.event;
    var key = e.which || e.keyCode; // keyCode detection
    var ctrl = (e.ctrlKey || e.metaKey) ? (e.ctrlKey || e.metaKey) : ((key === 17 || key == 91) ? true : false); // ctrl detection
    if ( key == 67 && ctrl) {
        //console.log("Ctrl + C Pressed !");
        {
        if (window.getSelection){ // all modern browsers and IE9+
        var selection = window.getSelection();
        selectedText = window.getSelection().toString();
        var CopyText = selectedText+" --- <?php echo $val['hicopy_content']; ?>";
        CopyToClipboard(CopyText); // Sending Merge data to clipboard
        //console.log(selectedText+" --- <?php echo $val['hicopy_content']; ?>");
        }
    }
    }
}
function AddContentToCopyToClipboardMouse( e )
{
  var selection = window.getSelection();
        selectedText = window.getSelection().toString();
        var CopyText = selectedText+" --- <?php echo $val['hicopy_content']; ?>";
            CopyToClipboardMouse(CopyText);
}

var index = 0;

jQuery(document.body).bind({

    keydown: function(e) {
        if((e.ctrlKey || e.metaKey) || ((e.which || e.keyCode) == 67))
        {ok = 1;
        AddContentToCopyToClipboard(e);

       }
    },
    copy: function(e){
        if(index == 0 &&  ok != 1)
        {

            ++index;
            AddContentToCopyToClipboardMouse(e);
            ok = 0;
        }
        index = 0;
    }
});



//jQuery(document).on('contextmenu').bind({ copy: function(e) { alert("mouse copy");}});


//jQuery(document).contextmenu().bind({ copy: function(e) { alert("mouse copy2");}});

</script>
<?php
        }
  }

function HicopyActivate(){

    $options = get_option('hicopy_options');
    $options = HicopySetDefaultOptions($options);
    update_option('hicopy_options', $options);
    update_option('hicopy_version', HICOPY_VERSION);
    update_option('hicopy_installed_version', 'Free');

}

function HicopyDeactive(){
           // run when deactivate the plugin
        delete_option('hicopy_installed_version');
        delete_option('hicopy_version');
}

function HicopyAdminMenu() {

    include (HICOPY_BASE_PATH . '/inc/admin/hicopy-options.php');
    add_management_page('Hicopy', 'Hicopy', 'manage_options', HICOPY_ADMIN_SLUG, 'HicopyOptionPage');

}

add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'HicopyActionlinks' );
function HicopyActionlinks( $links ) {
   $links[] = '<a href="'. esc_url( get_admin_url(null, 'tools.php?page='.HICOPY_ADMIN_SLUG) ) .'">Settings</a>';
   $links[] = '<a href="https://www.hicopy.co/hicopypro" target="_blank">Upgrade To Hicopy Pro</a>';
   return $links;
}

function HicopySetDefaultOptions($options){

    if (!isset($options['hicopy_content']))
        $options['hicopy_content'] = HICOPY_DEFAULT_CONTENT;
    if (!isset($options['hicopy_enable_disable']))
        $options['hicopy_enable_disable'] = 'enable';
     return $options;
}
