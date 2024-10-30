<?php

function hicopyOptionPage() {

    $options = get_option('hicopy_options');
  $_POST = array_map( 'stripslashes_deep', $_POST );
    if (isset($_POST['form_submit'])) {

        if (array_key_exists('hicopy_content', $_POST) && filter_var($_POST['hicopy_content'], FILTER_SANITIZE_STRING)) {
             $options['hicopy_content'] = sanitize_text_field( $_POST['hicopy_content']);
        }else{
             $options['hicopy_content'] = HICOPY_DEFAULT_CONTENT;
        }

        if (array_key_exists('hicopy_enable_disable', $_POST) && filter_var($_POST['hicopy_enable_disable'], FILTER_SANITIZE_STRING)) {
             $options['hicopy_enable_disable'] = sanitize_text_field( $_POST['hicopy_enable_disable']);
        }else{
             $options['hicopy_enable_disable'] = 'true';
        }


        update_option('hicopy_options', $options);

        /*Message*/
        echo '<div class="updated fade"><p>' . __('Settings Saved', 'hicopy') . '</p></div>';
    }

  if(get_option('hicopy_installed_version')!=""){
     $installed_version = get_option('hicopy_installed_version');
   }else{
    $installed_version = 'Settings';
   }

?>
  <div class="wrap options-hicopy">
        <div class="wrap">

       <div class="hicopy-container hicopy-navbar" id="postbox-container-1"> <h1 style="font-weight:bold;margin-top: -10px;font-size: 45px;color:#444;margin-left:18px;">
             Hicopy!
           </h1>
           <p style="margin-left:18px;">
               Thank you for downloading Hicopy. Consider upgrading to <a href="http://hicopy.co/hicopypro">Hicopy Pro</a> for more features towards website growth. Follow Hicopy on Twitter & Facebook for updates <a href="https://twitter.com/hicopyapp">@HicopyApp</a> & <a href="https://www.facebook.com/Hicopy-102263268041612/">Hicopy On Facebook</a>
           </p>
       </div>

      <div class="hicopy-container" id="postbox-container-2" >
        <div  class="meta-box-sortables ui-sortable">

          <form id="form_data" name="form" method="post">
                                            <input type="hidden" name="form_submit" value="true" />
                                            <h2 class="nav-tab-wrapper" id="admin-tabs">
                                                <a class="nav-tab" id="general-tab" href="#top#general"><?php _e( 'Dashboard');?></a>
                                                <a class="nav-tab" id="troubleshooting-tab" href="#top#troubleshooting"><?php _e( 'Support');?></a>
                                            </h2>
                                            <div class="tabwrapper">
                                                <div id="general" class="hicopy-tab">
                                                   <?php include(HICOPY_BASE_PATH.'/inc/admin/tabs/hicopy-general-settings.php'); ?>
                                                </div>
                                                <div id="troubleshooting" class="hicopy-tab">
                                                    <?php include(HICOPY_BASE_PATH.'/inc/admin/tabs/hicopy-troubleshooting.php'); ?>
                                                </div>
                                            </div>
          </form>
        </div>
      </div>
       <div class="hicopy-container" id="postbox-container-1" style="width:100%;text-align: center; background: #333; border-top: 3px solid; float:left;margin-top:-1%;height:14%">
                            <div id="side-sortables" class="meta-box-sortables ui-sortable">
              <h3 class="hndle"><span><strong style="color:white" class="blue"><?php _e( 'Upgrade To Hicopy Pro For Unlimited Hicopy’s And More!', 'hicopy' )?></strong></span></h3>


                <ul>
                	<a class="hicopy-pro-button" target="_blank" href="https://wordpress.org/plugins/hicopy">
                                    <?php _e( 'Rate Hicopy 5⭐', 'hicopy' )?>
                                 </a>
                  <a class="hicopy-pro-button" target="_blank" href="https://hicopy.co/hicopypro">
                                    <?php _e( 'Upgrade To Hicopy Pro', 'hicopy' )?>
                                </a>
                  <a class="hicopy-pro-button" target="_blank" href="mailto:hi@hicopy.co">
                                    <?php _e( 'Support', 'hicopy' )?>
                                </a>
                                </ul>

                            </div>
                            <br/>
                        </div>

    </div>

<?php
}
