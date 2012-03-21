/*
 * Navigation v.1
 * Sam Mateosian | sam@bigroomstudios.com
 * Max Felker | max@bigroomstudios.com
 * AJAX navigation for admin  
*/

var Navigation = Class.create({

	initialize: function(config) {
		
		var $this = this;
		
		this.supports_history = ( window.history && history.pushState ? true : false ); 
		
		this.container = $("#"+config.container);
		this.view_container = $('#'+config.view_container);
		this.items = this.container.find('a');
		
		if(this.supports_history){
			
			$('a').live('click', function (event) {
				
				//event.preventDefault();
				
				var route = $(this).data('route');
				
				if(route){
					
					event.preventDefault();
					
					var nav_id = 'nav_' + route;
					
					if($(nav_id)){
				
						event.preventDefault();			
						
						$this.go(route, this.href);
						
						return false;
					}
				}
			});
			
			window.onpopstate = function(event) {  
					
				var nav_id = 'nav_' + event.state.route;
				
				if($(nav_id)){
					
					$this.set_selected(nav_id);
					
					$this.show_view(document.location); 
				}
			}; 
		}
		
		this.update_height();
	},
	
	go: function(route, href){
		
		var nav_id = 'nav_' + route;
		
		history.pushState({route: route}, "", href);
						
		this.set_selected(nav_id);
						
		this.show_view(href);
	},
	
	show_view: function(href) {
		
		console.log(href);
		
		var $this = this;
		
		this.view_container.addClass('hide');

		$.getJSON(  
		    href,  
		    {ajax: 1},  
		    function(json) {
		    	
		        var result = json.view;
		        
		        $this.view_container.html(result);
		        $this.view_container.removeClass('hide'); 
		    }  
		);
		
	},
	
	set_selected: function(id) {
		
		$a = $('#'+id);
	
		var $li = $a.closest('li');
		
		var $ul = $a.closest('ul');
		
		var $sub_ul = $li.find('ul').first();
		
		$ul.find('a.selected').removeClass('selected');
		
		$ul.find('li.hidden').hide();
		
		$ul.find('.indicator').hide();
		
		$a.addClass('selected');
		
		$a.parents('li').show();
		
		$a.find('.indicator').show();
		
		$ul.find('ul').removeClass('selected');
		
		if($sub_ul){
			
			$sub_ul.addClass('selected');
			
			$sub_ul.find('li').first().addClass('selected');
			
			$sub_a = $sub_ul.find('li a').first();
			
			$sub_a.addClass('selected');
				
			$sub_a.find('.indicator').show();
		}
		
		this.update_height();
		
		
	},
	
	update_height: function() {
		
		var maxHeight = 0;
		
		var $this = this;
		
		this.container.find('ul').each(function () {
			
		    var tmpHeight = $(this).height() + $(this).position().top;
		
		    if (tmpHeight > maxHeight) {
		        maxHeight = tmpHeight;
		        $this.container.height(maxHeight);
		    }
		});
		
	}
	
	
});

$(document).ready(function() {
	$j.nav = new Navigation({
		container:'nav',
		view_container:'view'
	});
	
	
	
});