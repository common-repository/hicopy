<?php

    $rows = array();
    $status = "";
    $msg = "";
    
    $chatOptions = get_option( 'hicopy_options' );
    
    $rows[] = array(
        'id'      => 'hicopy_enable_disable',
        'label'   => __('Global On/Off','hicopy'),
        'content' => HicopySelect( 'hicopy_enable_disable', array(
            'false' => __('Off', 'hicopy'),
            'true'  => __('On', 'hicopy'),
        ),
        false, $status, $msg,'hicopy_options'
        )
    );
     
    $rows[] = array(
        'id'      => 'hicopy_content',
        'label'   => __('Message','hicopy'),
        'content' => HicopyTextArea( 'hicopy_content','6','36','hicopy_options')
    );    
  
    $save_button = '<div class="submitbutton"><input type="submit" class="button-primary" name="submit" value="'.__('Save Hicopy','hicopy'). '" /></div><br class="clear"/>';
    HicopyPostbox( 'hicopy_form_options', __( 'Global Hicopy Message', 'hicopy' ), FormTable( $rows ) . $save_button);