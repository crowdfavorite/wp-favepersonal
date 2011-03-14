jQuery(document).ready(function($) {

// Show tooltips
// http://www.kriesi.at/archives/create-simple-tooltips-with-css-and-jquery-part-2-smart-tooltips
	function cfcp_tooltip(target_items, name){
		$(target_items).each(function(i){
			$("body").append("<div class='"+name+"' id='"+name+i+"'><p>"+$(this).attr('title')+"</p></div>");
			var my_tooltip = $("#"+name+i);
			
			if($(this).attr("title") != "" && $(this).attr("title") != "undefined" ){

			$(this).removeAttr("title").mouseover(function(){
				my_tooltip.css({opacity:0.8, display:"none"}).fadeIn(200);
			}).mousemove(function(kmouse){
				var border_top = $(window).scrollTop(); 
				var border_right = $(window).width();
				var left_pos;
				var top_pos;
				var offset = 25;
				if(border_right >= my_tooltip.width() + kmouse.pageX){
					left_pos = kmouse.pageX-(my_tooltip.outerWidth()/2);
					} else{
					left_pos = border_right-my_tooltip.outerWidth()-10;
					}
				if(border_top + (offset *2)>= kmouse.pageY - my_tooltip.height()){
					top_pos = border_top+offset;
					} else{
					top_pos = kmouse.pageY-my_tooltip.height()-offset;
					}	
				my_tooltip.css({left:left_pos, top:top_pos});
			}).mouseout(function(){
				my_tooltip.css({left:"-9999px"});
			});
			}
		});
	}
	// Show tooltip for the .bio-box-links
	cfcp_tooltip(".bio-box-links a","tooltip");
	
});

