<?php

add_action('wp_ajax_hicopy_dismiss_message', 'HicopyDismissMessage' );
function HicopyDismissMessage(){
    check_ajax_referer( 'hicopy_security_ajax', 'security');
    update_option('hicopy_dismiss_message',HICOPY_VERSION);
    die();
}

add_action( 'admin_notices', 'HicopyAdminNotice');
function HicopyAdminNotice(){
    $security = wp_create_nonce( "hicopy_security_ajax" );
    $current_user = wp_get_current_user();

    if(get_option('hicopy_dismiss_message') != HICOPY_VERSION) {
        echo '<div class="hicopy-notice info notice-info notice">';
        echo '<div class="hicopy-logo"></div><div>';
        echo '<p style="color:black!important">' . __('<b>Thanks For Downloading Hicopy</b> ', 'hicopy');
        echo '<p style="color:black!important">' . __('<span style="font-weight: bold;"> You Have Access To One Global Hicopy Message.</span>  Do More With Hicopy Pro. Receive Unlimited Hicopys, Mobile Users Can See Your Message, Post Seperate Hicopys To Any Post and or Page. Pay Once. Upgrade Today!', 'hicopy');
        echo '</p><p>';
        echo '<a type="button" class="hicopy-settings-button button button-primary" href="'.esc_url( get_admin_url(null, 'tools.php?page='.HICOPY_ADMIN_SLUG) ).'">'. __('Dashboard', 'hicopy').'</a> ';
        echo '<a type="button" class="hicopy-addons-button button button-primary" target="_blank" href="https://hicopy.co/hicopypro/">'. __('Upgrade To Hicopy Pro', 'hicopy').'</a>';
        echo '</p>';
        echo '<button type="button" class="hicopy-dismiss-notice notice-dismiss"><span class="screen-reader-text">'. __('Dismiss this notice.', 'hicopy').'</span></button>';
        echo '</div>';
        echo '</div>';

        echo '  <script>
                    jQuery(function(){
                        jQuery(".hicopy-dismiss-notice").on("click", function(){
                            jQuery(".hicopy-notice").fadeOut();

                            jQuery.ajax({
                                type: "post",
                                url: "'.admin_url( 'admin-ajax.php' ).'",
                                data: {action: "hicopy_dismiss_message", security: "'.$security.'"}
                            })

                        })
                    })
                </script>';
     }
    echo '
    <style>

            .hicopy-logo{ float: left; padding: 10px;}
            .hicopy-notice{
                background-color: #d1e8ff;
                background-size: cover;
                color: #FFF;
                min-height: 48px;
            }
            .hicopy-settings-button{background: #F39C8C!important;}

            .notice-info{
                    border-left-color: #26A1EC;
            }

            .hicopy-settings-button:before{
                background: 0 0;
                color: #fff;
                content: "\f111";
                display: block;
                font: 400 16px/20px dashicons;
                speak: none;
                height: 29px;
                text-align: center;
                width: 16px;
                float: left;
                margin-top: 3px;
                margin-right: 4px;
            }

            .hicopy-addons-button:before{
                background: 0 0;
                color: #fff;
                content: "\f106";
                display: block;
                font: 400 16px/20px dashicons;
                speak: none;
                height: 29px;
                text-align: center;
                width: 16px;
                float: left;
                margin-top: 3px;
                margin-right: 4px;
            }
            .hicopy-addons-button, .hicopy-addons-button:visited,.hicopy-addons-button:active{
                background: #2BB3E7 !important;
                border-color: #2BB3E7 !important;
                color: #fff !important;
                text-decoration: none !important;
                text-shadow: none!important;
                box-shadow: none !important;
            }

            .hicopy-addons-button:hover{
                background:#2BB3E7 !important;
                border-color: #2BB3E7 !important;
            }


            .hicopy-dismiss-notice{
                top:5px
            }
            .hicopy-dismiss-notice:hover:before, .hicopy-dismiss-notice:focus:before, .hicopy-dismiss-notice:visited:before{
                color:#26A1EC !important;
            }

            .hicopy-notice{
                position:relative
            }
            .hicopy-notice a{ color: #26A1EC; font-weight: bold; }
    </style>';

}
/**
* Create a Text input field
*/
function HicopyTextArea($id,$r,$c,$optionname) {
   $options = get_option( $optionname );
   $val = '';
   if ( isset( $options[$id] ) )
       $val = $options[$id];
   return '<textarea class="textarea" id="'.$id.'" name="'.$id.'" rows="'.$r.'" cols="'.$c.'">'.$val.'</textarea>';
}

/**
 * Create a dropdown field
 */
function HicopySelect($id, $options, $multiple = false, $state = "", $msg = "",$optionname) {
    $opt = get_option($optionname);
    $output = '<select class="select" name="'.$id.'" id="'.$id.'" '.$state.'>';
    foreach ($options as $val => $name) {
        $sel = '';
        if ($opt[$id] == $val)
            $sel = ' selected="selected"';
        if ($name == '')
            $name = $val;
        $output .= '<option value="'.$val.'"'.$sel.'>'.$name.'</option>';
    }
    $output .= '</select><label><i>'.$msg.'</i></label>';
    return $output;
}

/**
 * Create a potbox widget
 */
function HicopyPostbox($id, $title, $content) {
?>
    <div id="<?php echo $id; ?>">
        <h3 class="hndle"><span><?php echo $title; ?></span></h3>
        <div class="inside">
            <?php echo $content; ?>
        </div>
    </div>
<?php
}


/**
 * Create a form table from an array of rows
 */
function FormTable($rows) {
    $content = '<table class="form-table">';
    $i = 1;
    foreach ($rows as $row) {
        $class = '';
        if ($i > 1) {
            $class .= 'yst_row';
        }
        if ($i % 2 == 0) {
            $class .= ' even';
        }
        $content .= '<tr id="'.$row['id'].'_row" class="'.$class.'"><th valign="top" scrope="row">';
        if (isset($row['id']) && $row['id'] != '')
            $content .= '<label for="'.$row['id'].'">'.$row['label'].':</label>';
        else
            $content .= '<h2>'.$row['label'].'</h2>';
        $content .= '</th><td valign="top" ';
                if ( !isset($row['content2']) && empty($row['content2']) ) {
             $content .= "colspan=2";
                }
        $content .= '>';
        $content .= $row['content'];
        $content .= '</td>';
        if ( isset($row['content2']) && !empty($row['content2']) ) {
            $content .= '<td>'.$row['content2'].'</td>';
        }
            $content .= '</tr>';
        if ( isset($row['desc']) && !empty($row['desc']) ) {
            $content .= '<tr class="'.$class.'"><td colspan="2" class="yst_desc"><small>'.$row['desc'].'</small></td></tr>';
        }

        $i++;
    }
    $content .= '</table>';
    return $content;
}
