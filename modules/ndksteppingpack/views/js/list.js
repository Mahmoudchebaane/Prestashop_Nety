/**
*  Tous droits réservés NDKDESIGN
*
*  @author    Hendrik Masson <postmaster@ndk-design.fr>
*  @copyright Copyright 2013 - 2017 Hendrik Masson
*  @license   Tous droits réservés
*/

$(document).ready(function(){
	setTimeout(function(){
		equalheight('.image-block');
		equalheight('.pack_desc');
		equalheight('.pack_name');
	}, 2000);
	 
});
	
	

equalheight = function(container){
	var currentTallest = 0,
	     currentRowStart = 0,
	     rowDivs = new Array(),
	     $el,
	     topPosition = 0;
	 $(container).each(function() {
	   $el = $(this);
	   //$el.height('auto');
	   topPostion = $el.position().top;
	     rowDivs.push($el);
	     currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
	   for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
	     rowDivs[currentDiv].height(currentTallest);
	   }
	 });
}

