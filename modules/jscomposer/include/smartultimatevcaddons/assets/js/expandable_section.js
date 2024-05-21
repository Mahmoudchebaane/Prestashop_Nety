jQuery(document).ready(function() {
  jQuery(".ult_exp_content").hide();
  /* toggle the componenet with class msg_body */
  jQuery(".ult_exp_section").click(function()
  {
    var effect = jQuery(this).data('effect');
    

    jQuery(this).toggleClass("ult_active_section");

    jQuery(this).next(".ult_exp_content").toggleClass("ult_active_section");
    if(effect=='slideToggle'){
      jQuery(this).next(".ult_exp_content").slideToggle(500);
    }
   if(effect=='fadeToggle'){
      /* jQuery(this).next(".ult_exp_content").fadeToggle(500); */
        var child= jQuery(this).next(".ult_exp_content");
        if(child.is(":visible")) {
                child.fadeTo(500, 0.0, function() {
                    child.slideUp();
                });
               
            } 
        else {

                child.slideDown(function() {
                    child.fadeTo(500, 1.0);                        
                });
             
            }
   }
  /* bind trigger on click event*/
    jQuery(this).trigger("select");
   
  });

jQuery(".ult_exp_section").select(function(){
      
       var title=jQuery(this).data('title');
       var title1=jQuery(this).data('newtitle');
       var icn=jQuery(this).data('icon');
       var icn1=jQuery(this).data('newicon');
       var img=jQuery(this).data('img');
       var img1=jQuery(this).data('newimg');

       var activetitle=jQuery(this).data('activetitle');
       var activebg=jQuery(this).data('activebg');
       var acticon = jQuery(this).data('activeicon');   
       var actiocnbg = jQuery(this).data('activeiconbg');
       var activeborder = jQuery(this).data('activeborder');

       
       jQuery(this).css({"color":activetitle});
       jQuery(this).parent().find('.ult_exp_section').css({"background":activebg});
       jQuery( this ).find('.ult_expsection_icon').css({"color":acticon});
       jQuery( this ).find('.ult_expsection_icon').css({"background":actiocnbg});
       jQuery( this ).find('.ult_expsection_icon').css({"border-color":activeborder});
       if(title!=title1){
       jQuery(this).find('.ult_expheader').stop().css('opacity', '0.1').html(function (_, oldText) {
                return oldText == title1 ? title : title1;
                
              
            }).animate({
                opacity: 1
            }, 300);
        }
      /*----icon replace---------*/
      if(jQuery(this).hasClass("ult_active_section")){
       
       if(icn!==icn1){
        jQuery(this).find('.ult_ex_icon').removeClass(icn);
        jQuery(this).find('.ult_ex_icon').fadeOut(100).switchClass( icn, icn1, 1500, "easeInOutQuad" ).fadeIn(300);
        }
       
      if(img!==img1){
         jQuery(this).find('.ult_exp_img').fadeOut(200).attr('src', img1).fadeIn(500);
       }
       
       }
    else{
      if(icn!==icn1){
        jQuery(this).find('.ult_ex_icon').removeClass(icn1);
      jQuery(this).find('.ult_ex_icon').fadeOut(100).switchClass( icn1, icn, 1500, "easeInOutQuad" ).fadeIn(300);
      
       }
      
      if(img!==img1){
       jQuery(this).find('.ult_exp_img').fadeOut(200).attr('src', img).fadeIn(500);
      }

    }
      
    });

});


  jQuery(document).ready(function(){
  

   jQuery('.ult_exp_section').hover(function() {
    var texthover = jQuery(this).data('texthover');   
    var ihover = jQuery(this).data('ihover');   
    var cnthvrbg = jQuery(this).data('cnthvrbg');   
    var headerhover = jQuery(this).data('headerhover');   
    var icnhvrbg = jQuery(this).data('icnhvrbg');   
    var icnhvrborder = jQuery(this).data('icnhvrborder');
    if(jQuery(this).hasClass("ult_active_section")){

    }else{
    jQuery( this ).css({"color":texthover,"background":headerhover});
    jQuery( this ).find('.ult_expsection_icon').css({"color":ihover});
    jQuery( this ).find('.ult_expsection_icon').css({"background":icnhvrbg});
    jQuery( this ).find('.ult_expsection_icon').css({"border-color":icnhvrborder});
   
    }

  },
    function() {
      var textcolor = jQuery(this).data('textcolor');
      var icncolor = jQuery(this).data('icncolor');
      var cntbg = jQuery(this).data('cntbg');
      var headerbg = jQuery(this).data('headerbg');
      var icnbg = jQuery(this).data('icnbg');
      var icnborder = jQuery(this).data('icnborder');

     if(jQuery(this).hasClass("ult_active_section")){

    }else{
    jQuery( this ).css({"color":textcolor,"background":headerbg});
     
     jQuery( this ).find('.ult_expsection_icon').css({"color":icncolor});
     jQuery( this ).find('.ult_expsection_icon').css({"background":icnbg});
     jQuery( this ).find('.ult_expsection_icon').css({"border-color":icnborder});
    
    }
     
    }
  );

jQuery('.ult_exp_content').hover(function() {
    var bg = jQuery(this).parent().find('.ult_exp_section').data('cnthvrbg');   
  

  },
    function() {
       
     var bg1 = jQuery(this).parent().find('.ult_exp_section').data('cntbg');   
    
    }
  );
 

  function resize_ult_section()
  {

    jQuery('.ult_exp_section_layer').each(function(i,element){

     
      jQuery(element).css({'margin-left' : 0 });
      var override = jQuery(element).find('.ult_exp_section').data('override');
     
      if(override != 0)
      {
        var is_relative = 'true';
        if(jQuery(element).parents('.wpb_row').length > 0)
          var ancenstor = jQuery(element).parents('.wpb_column');
        else if(jQuery(element).parents('.wpb_column').length > 0)
          var ancenstor = jQuery(element).parents('.wpb_row');
        else{
          var ancenstor = jQuery(element).parent();
        }
        var parent = ancenstor;
        if(override=='full'){
          ancenstor= jQuery('body');
          is_relative = 'false';
        }
        if(override=='ex-full'){
          ancenstor= jQuery('html');
          is_relative = 'false';
        }
        if( ! isNaN(override)){
         
          for(var i=1;i<override;i++){
            if(ancenstor.prop('tagName')!='HTML'){
              ancenstor = ancenstor.parent();
            }else{
              break;
            }
          }
        }
        if(is_relative == 'false'){
          
          var w = ancenstor.outerWidth();
        }
        else{
         
          var w = ancenstor.width();
        }
       
        var a_left = ancenstor.offset().left;
        var left = jQuery(element).offset().left;
        var calculate_left = a_left - left;
        
      

         if(is_relative =='false'){
         
         jQuery(element).css({'width':w, 'margin-left' : calculate_left });
         }
        else {
          
          jQuery(element).css({'width':w });
        }
        /* jQuery(element).css({'width':w, 'margin-left' : calculate_left }); */
      }
    });
  }

 jQuery( window ).resize(function() {
  
 resize_ult_section();

});
  resize_ult_section();

  });

jQuery(document).ready(function(){
      jQuery(".ult_exp_section").select(function(){

     /* console.log("jo"); */
     var ht=jQuery(this).data("height");
     
     if(ht!=0 ){
     var top = jQuery(this).offset().top;
     var ntop = parseInt(top) - ht;
      jQuery("html, body").animate({scrollTop : ntop}, 1200);
  }
    });
});