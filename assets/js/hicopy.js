jQuery(document).ready(function() {
	
	//for posts
	  $('#hicopy-posts').on('click',function(){
        if(this.checked){
            $('.post_selector').each(function(){
                this.checked = true;
            });
        }else{
             $('.post_selector').each(function(){
                this.checked = false;
            });
        }
    });
    
    $('.post_selector').on('click',function(){
        if($('.post_selector:checked').length == $('.post_selector').length){
            $('#hicopy_posts').prop('checked',true);
        }else{
            $('#hicopy_posts').prop('checked',false);
        }
    });
	
	//for pages
	  $('#hicopy_pages').on('click',function(){
        if(this.checked){
            $('.page_selector').each(function(){
                this.checked = true;
            });
        }else{
             $('.page_selector').each(function(){
                this.checked = false;
            });
        }
    });
    
    $('.page_selector').on('click',function(){
        if($('.page_selector:checked').length == $('.page_selector').length){
            $('#hicopy_pages').prop('checked',true);
        }else{
            $('#hicopy_pages').prop('checked',false);
        }
    });
	
	//for categories
	  $('#categories').on('click',function(){
        if(this.checked){
            $('.category_selector').each(function(){
                this.checked = true;
            });
        }else{
             $('.category_selector').each(function(){
                this.checked = false;
            });
        }
    });
    
    $('.category_selector').on('click',function(){
        if($('.category_selector:checked').length == $('.category_selector').length){
            $('#hicopy_categories').prop('checked',true);
        }else{
            $('#hicopy_categories').prop('checked',false);
        }
    });
});