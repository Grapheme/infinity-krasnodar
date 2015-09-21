if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
	$('.slider-container').addClass('mobile-slider-fix');
}

var grphm_slider = (function(){
	$.fn.slider = function(option) {
		var img = [],
			thumb = [],
			photo_cont = $(this).find('.slider-img'),
			slider_nav = $(this).find('.slider-nav'),
			slider = $(this),
			max = 4,
			slide_length = $(this).find('.js-slider-nav i').length,
			active_thumb,
			active_id = 0,
			slider_allow = true,
			active_info;

		var get_thumb = function(id, thumb, img) {
			return '<li class="thumb" data-id="' + id + '" style="background-image: url(' + thumb + ')" data-img="' + img + '">';
		}

		var init = function() {
			var j = 0;
			
			slider.find('.js-slider-nav i').each(function(){
				$(this).attr('data-id', j);
				img[j] = $(this).attr('data-img');
				thumb[j] = $(this).attr('data-thumb');
				j++;
			});
			j = 0;
			slider.find('.slide-info').each(function(){
				$(this).attr('data-id', j);
				j++;	
			});
			for(var i = 0; i < 3; i++) {
				slider_nav.append(get_thumb(i, thumb[i], img[i]));
			}
			for(i = slide_length - 1; i > slide_length - 3; i--) {
				slider_nav.prepend(get_thumb(i, thumb[i], img[i]));
			}
			slider.addClass('js-slider');
			active_thumb = slider_nav.find('.thumb[data-id=0]');
			active_thumb.addClass('active');
			active_info = slider.find('.slide-info[data-id=0]');
			active_info.addClass('active');
			photo_cont.html('<div class="slider-photo" style="background-image: url(' + active_thumb.attr('data-img') + ');"></div>');
			if(option) {
				slider.find('.slider-nav-win').css('width', slider_nav.find('.thumb').outerWidth(true) * (max + 1));
			} else {
				//slider.find('.slider-nav').css('width', slider_nav.find('.thumb').outerWidth(true) * (max + 1));
			}
		}

		init();

		var thumb_rm = function(del, out, i) {
			slider_allow = false;
			var block = slider.find('.slider-nav .thumb[data-id=' + del + ']').first();
			var time;
			if(out) {
				block.css({
					'position': 'absolute',
					'left': -(i+1) * block.outerWidth(true)
				});
				setTimeout(function(){
					block.remove();
					slider_allow = true;
				}, 500);
			} else {
				setTimeout(function(){
					block.remove();
					slider_allow = true;
				}, 500);
			}
		}

		var thumb_show = function(id, type) {
			var pre_str = get_thumb(id, thumb[id], img[id]);
			if(type == 'prepend') {
				slider.find('.slider-nav').prepend(pre_str);
			} else {
				slider.find('.slider-nav').append(pre_str);
			}
		}

		var nav_change = function(dif, direction) {
			if(direction == 'prepend') {
				var x = - slider.find('.thumb').outerWidth(true) * dif;
				slider_nav.attr('style', '-webkit-transform: translateX('+ x +'px);');
				setTimeout(function(){
					slider_nav.addClass('transition');
					slider_nav.removeAttr('style');
					setTimeout(function(){
						slider_nav.removeClass('transition');
					}, 500);
				}, 1);
			}
			if(direction == 'append') {
				var x = slider.find('.thumb').outerWidth(true) * dif;
				slider_nav.attr('style', '-webkit-transform: translateX('+ x +'px);');
				setTimeout(function(){
					slider_nav.addClass('transition');
					slider_nav.removeAttr('style');
					setTimeout(function(){
						slider_nav.removeClass('transition');
					}, 500);
				}, 1);
				
				
			}

		}

		var show = function(id) {
			if(id == active_id || !slider_allow) return;

			var dif = Math.abs(slider.find('.thumb[data-id=' + id + ']').index() - active_thumb.index());

			active_info = slider.find('.slide-info[data-id=' + id + ']');
			var info_rm = slider.find('.slide-info.active');
			active_info.addClass('active');
			info_rm.addClass('fadeout');
			setTimeout(function(){
				info_rm.removeClass('fadeout').removeClass('active');
			}, 500);

			if(slider.find('.thumb[data-id=' + id + ']').index() < active_thumb.index()) {
				var del_id = parseInt(slider.find('.thumb').last().attr('data-id'));
				var add_id = parseInt(slider.find('.thumb').first().attr('data-id')) - 1;

				for(var i = 0; i < dif; i++) {
					del = del_id - i;
					add = add_id - i;
					
					if(add < 0) {
						add = slide_length - Math.abs(add);
					}
					if(del < 0) {
						del = slide_length - Math.abs(del);
					}

					thumb_rm(del);
					thumb_show(add, 'prepend');
					nav_change(dif, 'prepend');
				}

			} else {
				var del_id = parseInt(slider.find('.thumb').first().attr('data-id'));
				var add_id = parseInt(slider.find('.thumb').last().attr('data-id')) + 1;

				for(var i = 0; i < dif; i++) {
					del = del_id + (dif - 1 - i);
					add = add_id + i;

					if(add > slide_length - 1) {
						add = add - slide_length;
					}
					if(del > slide_length - 1) {
						del = del - slide_length;
					}

					thumb_rm(del, true, i);
					thumb_show(add, 'append');
					nav_change(dif, 'append');
				}
			}

			active_thumb = slider.find('.thumb[data-id=' + id + ']');
			active_id = id;
			active_thumb.addClass('active').siblings().removeClass('active');
			
			var old_slide = photo_cont.find('.slider-photo');
			var new_slide = $('<div class="slider-photo closed" style="background-image: url(' + img[id] + ');"></div>');
			
			old_slide.addClass('to-remove');
			photo_cont.append(new_slide);

			setTimeout(function(){
				new_slide.removeClass('closed');
			}, 1);

			setTimeout(function(){
				$(old_slide).remove();
			}, 1000);
		}

		$(document).on('click', '.slider-nav .thumb', function(){
			show($(this).attr('data-id'));
			return false;
		});
	}
})();

$('.slider-container').slider(true);
$('.auto-slider').slider();

var Popup = (function(){

	allow = true;
	opened = false;
	var show = function(popup, model) {
		if(!allow) return;
		var popup = $('.pop-window[data-popup="' + popup + '"]');
		$('.overlay').addClass('active').css('z-index', 1000);
		popup.removeClass('closed');
		$('html').css('overflow', 'hidden');
		if(model) {
			$(popup.find('.hidden-model').val(model));
		}
		opened = popup;
	}

	var close = function(popup) {
		allow = false;
		$('.overlay').removeClass('active');
		$('html').removeAttr('style');
		setTimeout(function(){
			$('.overlay').css('z-index', -1);
			popup.addClass('closed');
			allow = true;
			opened = false;
		}, 500);
	}

	$(document).on('click', '.js-pop-close', function(){
		if(opened) {
			close(opened);
		}
		return false;
	});

	$(document).on('click', '.js-pop-show', function(){
		if(!opened) {
			show($(this).attr('data-popup'), $(this).attr('data-model'));
		}
		return false;
	});

	$(document).on('click', '.overlay', function(){
		if(opened) {
			close(opened);
		}
	});

	$(document).on('click', '.pop-window', function(e){
		//e.preventDefault();
		e.stopPropagation();
	});

	// if(window.location.hash != '') {
	// 	show(window.location.hash.substr(1));
	// }

	return { show: show, close: close };
})();

jQuery.fn.tabs = function(control) {
	var element = $(this);
	control = $(control);

	element.delegate('li', 'click', function(){
		//Извлечение имени вкладки
		var tabName = $(this).data('tab');

		//Запуск пользовательского события при щелчке на вкладке
		element.trigger("change.tabs", tabName);
	});

	//Привязка к пользовательскому событию
	element.bind('change.tabs', function(e, tabName){
		element.find('li').removeClass('active');
		element.find('>[data-tab="' + tabName + '"]').addClass('active');
	});

	element.bind('change.tabs', function(e, tabName) {
		control.find('>[data-tab]').removeClass("active");
		control.find('>[data-tab="' + tabName + '"]').addClass("active");
	});

	$('#tabs').bind('change.tabs', function(e, tabName) {
		window.location.hash = tabName;
	});

	$(window).bind('hashchange', function(){
		var tabName = window.location.hash.slice(1);
		$('#tabs').trigger('change.tabs', tabName);
	});

	//Активация первой вкладки
	var garant = window.location.hash.slice(1) || element.find('li:first').attr('data-tab');
	element.trigger('change.tabs', garant);

	return this;
};

jQuery.fn.colorChange = function(colorNames) {
	var element = $(this);

	element.delegate('li', 'click', function(){
		var colorNum = $(this).data('color');
		element.trigger("change.color", colorNum);
	});

	element.bind('change.color', function(e, colorNum) {
		element.parent().attr('data-color', colorNum);
		element.prev().html(colorNames[--colorNum]);
	});

	element.prev().html(colorNames[0]);
	element.parent().attr('data-color', 1);
};

jQuery.fn.galleryAnim = function() {

	var cont = $(this);
		block = $(this).find('.gallery-block'),
		slides_length = block.length,
		allow_scroll = 'top',
		fade_allow = true,
		fade_time = 1000;

	block.eq(0).addClass('active').siblings().addClass('fadeOut');
	setTimeout(function(){
		block.addClass('transition');
	}, 5);

	if(slides_length == 1 || $('html').hasClass('touch')) return;
	
	$(window).scrollTop(0);

	$(window).on('scroll', function(){
		if(allow_scroll != 'bottom' && $(window).scrollTop() > $('.gallery').offset().top) {
			$(window).scrollTop($('.gallery').offset().top);
			$('html').addClass('scroll-blocked');
		}

		if(allow_scroll == 'bottom' && $(window).scrollTop() + $(window).height() < $('.gallery').offset().top + $('.gallery').height()) {
			$(window).scrollTop($('.gallery').offset().top);
			$('html').addClass('scroll-blocked');
		}

		if($('html').hasClass('scroll-blocked')) {
			$(window).scrollTop($('.gallery').offset().top);
			return false;
		}
	});

	$(document).bind('mousewheel DOMMouseScroll', function(event) {
		var delta;

		if (event.type == 'mousewheel') {
			delta = event.originalEvent.wheelDelta;
		} else

		if (event.type == 'DOMMouseScroll') {
			delta = -1 * event.originalEvent.detail;
		}

		if(delta > 0 && allow_scroll == 'top') {
			$('html').removeClass('scroll-blocked');
		} else

		if(delta < 0 && allow_scroll == 'bottom') {
			$('html').removeClass('scroll-blocked');
		}

		if($('html').hasClass('scroll-blocked') && fade_allow) {
			if(delta > 0) {
				var active = cont.find('.gallery-block.active');
				if(active.index() == 0) {
					allow_scroll = 'top';
					return ;
				}
				fade_allow = false;
				allow_scroll = false;
				active.removeClass('active').addClass('fadeOut');
				block.eq(active.index() - 1).addClass('active');
				setTimeout(function(){
					fade_allow = true;
				}, fade_time);
			} else

			if(delta < 0) {
				var active = cont.find('.gallery-block.active');
				if(active.index() + 1 == slides_length) {
					allow_scroll = 'bottom';
					return ;
				}
				fade_allow = false;
				allow_scroll = false;
				active.removeClass('active');
				block.eq(active.index() + 1).removeClass('fadeOut').addClass('active');
				setTimeout(function(){
					fade_allow = true;
				}, fade_time);
			}
		}
	});
};

jQuery.fn.carsHover = function(){
	var cont = $(this);

	$(document).on('mouseover', '.cars-ul li', function(){
		cont.find('.cars-ul li').addClass('fadeOut');
		$(this).removeClass('fadeOut');
	});
};

var tooltips = (function(){
	$('.js-tooltip-block').hide();
	var timeout = false;
	var timeout_trans = false;
	var pos_y = $('.main-header').height();

	$(document).on('mouseover', '.js-tooltip, .js-tooltip-block', function(){
		show($('.js-tooltip-block[data-tooltip="' + $(this).attr('data-tooltip') + '"]'));
	});
	$(document).on('mouseover', '.js-tooltip', function(){
		if($(this).attr('data-tooltip') != $('.js-tooltip-block.fadeIn').attr('data-tooltip')) {
			$('.js-tooltip-block.fadeIn').hide().removeClass('fadeIn');
		}
	});
	$(document).on('mouseout', '.js-tooltip, .js-tooltip-block', function(){
		close($('.js-tooltip-block[data-tooltip="' + $(this).attr('data-tooltip') + '"]'));
	});

	function show(cont) {
		cont.css('z-index', 999);
		var this_tool = $('.js-tooltip[data-tooltip="' + cont.attr('data-tooltip') + '"]');
		cont.css({
			'top': pos_y
		});
		cont.show();
		var tr_x = this_tool.offset().left - cont.offset().left + this_tool.width()/2 - 15/2;
		cont.find('.tool-triangle').css('left', tr_x);
		setTimeout(function(){
			cont.addClass('fadeIn');
		}, 1);
		clearTimeout(timeout);
		clearTimeout(timeout_trans);
	}

	function close(cont) {
		cont.css('z-index', 5);
		timeout = setTimeout(function(){
			cont.removeClass('fadeIn');
			timeout_trans = setTimeout(function(){
				cont.hide();
				//cont.find('.cars-ul li').removeClass('fadeOut');
			}, 500);
		}, 2000);
	}

})();

var smart_tabs = (function() {
	if($('.js-smartabs').length != 0) {
		$('.js-smartabs').each(function(){
			$(this).find('li').eq(0).addClass('active');
			var parent = $(this).parent().parent();
			parent.find('.main-block').eq(0).siblings().hide();
		});
	}

	$(document).on('mouseover', '.js-smartabs li', function(){
		$(this).addClass('active').siblings().removeClass('active');
		var parent = $(this).parent().parent().parent();
		parent.find('.main-block').eq($(this).index()).show().siblings().hide();
	});
})();

//$('.testSelect').SumoSelect();
$('.cars-tooltip').carsHover();

//Click events
$('.colorView').click( function() {
	$('.colorWrapper').addClass('active');
});
$('.color-close').click( function() {
	$('.colorWrapper').removeClass('active');
});

var colorNames = ['цвет1','цвет2','цвет3','цвет4','цвет5','цвет6','цвет7','цвет8','цвет9','цвет10'];

$("ul#tabs").tabs("#tabContent");
$(".colors-list").colorChange(colorNames);