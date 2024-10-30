jQuery(document).ready(function() {

    jQuery('#admin-tabs').find('a').click(function() {
        jQuery('#admin-tabs').find('a').removeClass('nav-tab-active');
        jQuery('.hicopy-tab').removeClass('active');

        var id = jQuery(this).attr('id').replace('-tab','');
        jQuery('#' + id).addClass('active');
        jQuery(this).addClass('nav-tab-active');
    });
    
    // manage checkbox on select
    jQuery('#last_name, #email').change(function() {
         var HideValue = jQuery(this).val();
         var HideID = jQuery(this).attr('id');
         if(HideValue === "false"){
             jQuery("#"+HideID+"_required").attr("disabled", true);
             if(jQuery("#"+HideID+"_required").prop("checked") === true){
                jQuery("#"+HideID+"_required"). prop("checked", false);
             }
         }else{
             jQuery("#"+HideID+"_required").removeAttr("disabled");
         }
         
    });
    
    // init
    var active_tab = window.location.hash.replace('#top#','');

    // default to first tab
    if ( active_tab == '' || active_tab == '#_=_') {
        active_tab = jQuery('.hicopy-tab').attr('id');
    }

    jQuery('#' + active_tab).addClass('active');
    jQuery('#' + active_tab + '-tab').addClass('nav-tab-active');
   
});