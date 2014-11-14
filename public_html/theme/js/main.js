var car_tooltip_allow = true;

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
		active_info,
		auto_time = 4000,
		canvas_circles_stop = false,
		next_slide_timeout = false,
		close_slide_timeout = false,
		auto_timeout;


	/*** CANVAS CIRCLES ***/

	var canvas, context, x, y, radius, endPercent, curPerc, counterClockwise, circ, quart;

	function canvas_dest(id) {
		var block = $('.slider-dots .dot-cont').eq(id);
		block.html('<i class="dot closed"></i>');
		setTimeout(function(){
			block.find('.dot.closed').removeClass('closed');
		}, 5);
	}

	function canvas_init(id) {
		var block = $('.slider-dots .dot-cont').eq(id);
		block.find('.dot').remove();
		block.html('<canvas id="canvas-dot" width="20px" height="20px"></canvas>');
		setTimeout(function(){
			block.find('#canvas-dot').addClass('loaded');
		}, 50);
		canvas = document.getElementById('canvas-dot');
		context = canvas.getContext('2d');
		x = canvas.width / 2;
		y = canvas.height / 2;
		radius = 6;
		endPercent = 101;
		curPerc = 0;
		counterClockwise = false;
		circ = Math.PI * 2;
		quart = Math.PI / 2;

		animate(101, 0, id);
	}

	function animate(loaded, current, id) {
		context.clearRect(0, 0, canvas.width, canvas.height);

		context.strokeStyle = 'rgba(255, 255, 255, .35)';
		context.lineWidth = 3;
		context.beginPath();
		context.arc(x, y, radius, -(quart), ((circ) * 101) - quart, false);
		context.stroke();

		context.lineWidth = 3;
		context.strokeStyle = '#ccc';
		context.beginPath();
		context.arc(x, y, radius, -(quart), ((circ) * current) - quart, false);
		context.stroke();

		curPerc = curPerc + 0.25;
		if(canvas_circles_stop) {
			clearTimeout(next_slide_timeout);
			canvas_circles_stop = false;
			curPerc = 0;
			return;
		}
		if (curPerc < loaded) {
			requestAnimationFrame(function () {
				animate(loaded, curPerc / 100, id)
			});
		} else {
			next_slide_timeout = setTimeout(function(){
				if(slide_length == active_id + 1) {
					var toshow = 0;
				} else {
					var toshow = active_id + 1;
				}
				show(toshow);
			}, 500);
		}
	}

	/*** END OF CANVAS CIRCLES ***/



	var get_thumb = function(id, thumb, img) {
		return '<li class="thumb" data-id="' + id + '" style="background-image: url(' + thumb + ')" data-img="' + img + '">';
	}

	var init = function() {
		var j = 0;

		slider.find('.js-slider-nav i').each(function(){
			$(this).attr('data-id', j);
			img[j] = $(this).attr('data-img');
			thumb[j] = $(this).attr('data-thumb');
			$('body').append('<img src="' + img[j] + '" alt="" style="display: none;">');
			$('.slider-dots').append('<div class="dot-cont"><i class="dot"></i></div>');
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
		$('.slide-info').show();
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

		$(function(){
			canvas_init(0);
			setTimeout(function(){
				$('.slider-dots').removeClass('closed');
			}, 1000);
			setTimeout(function(){
				$('.slider-img').removeClass('toload');
				$('.slide-info').removeClass('toload');
			}, 100);
		});
	}

	var show = function(id) {
		if(id == active_id || !slider_allow) return;
		clearTimeout(close_slide_timeout);
		canvas_dest(active_id);
		canvas_init(id);

		var dif = Math.abs(slider.find('.thumb[data-id=' + id + ']').index() - active_thumb.index());

		active_info = slider.find('.slide-info[data-id=' + id + ']');
		var info_rm = slider.find('.slide-info.active');
		active_info.addClass('active');
		info_rm.addClass('fadeout');
		setTimeout(function(){
			info_rm.removeClass('fadeout').removeClass('active');
		}, 500);

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

	$(document).on('click', '.slider-dots .dot', function(){
		canvas_circles_stop = true;
		show($(this).parent().index());
		return false;
	});

	init();
}

var Popup = (function(){

	allow = true;
	opened = false;
	var show = function(data_popup, model) {
		if(!allow) return;
		var popup = $('.pop-window[data-popup="' + data_popup + '"]');
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

jQuery.fn.galleryAnim = function() {

	var cont = $(this);
		block = $(this).find('.gallery-block'),
		slides_length = block.length,
		allow_scroll = 'top',
		fade_allow = true,
		anim_allow = false,
		fade_time = 1000;

	block.eq(0).addClass('active').siblings().addClass('fadeOut');
	setTimeout(function(){
		block.addClass('transition');
	}, 5);

	if(slides_length == 1 || $('html').hasClass('touch')) return;
	
	$(window).scrollTop(0);

	function set_scroll() {
		$(window).scrollTop($('.gallery').offset().top);
		$('html').addClass('scroll-blocked');
		anim_allow = false;
		setTimeout(function(){
			anim_allow = true;
		}, 1000);
	}

	$(window).on('scroll', function(){
		if(allow_scroll != 'bottom' && $(window).scrollTop() > $('.gallery').offset().top) {
			set_scroll();
		}

		if(allow_scroll == 'bottom' && $(window).scrollTop() + $(window).height() < $('.gallery').offset().top + $('.gallery').height()) {
			set_scroll();
		}

		if($('html').hasClass('scroll-blocked')) {
			$(window).scrollTop($('.gallery').offset().top);
			return false;
		}
	});

	function gettop() {
		if(!anim_allow) return;
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
	}

	function getdown() {
		if(!anim_allow) return;
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

	$(document).on('click', '.gal-down', getdown);

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
				gettop();
			} else

			if(delta < 0) {
				getdown();
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
	var show_timeout = false;
	var timeout_trans = false;
	var opened = false;
	var pos_y = $('.main-header').height();

	$(document).on('mouseover', '.js-tooltip, .js-tooltip-block', function(){
		if(!car_tooltip_allow) return;
		show($(this).attr('data-tooltip'));
	});
	$(document).on('mouseout', '.js-tooltip, .js-tooltip-block', function(){
		close($(this).attr('data-tooltip'));
	});

	function init() {
		setTimeout(function(){
			$('.car-tooltip').each(function(){
				var lblock = $(this).find('.left-block li');
				var mblock = $(this).find('.main-block');
				if(lblock.length != 0) {
					var w = mblock.eq(0).outerWidth(true) - lblock.outerWidth(true);
					mblock.css('width', w);
				}
			});
		}, 500);
	}

	function show(id) {
		var this_tool = $('.js-tooltip[data-tooltip="' + id + '"]');
		var cont = $('.js-tooltip-block[data-tooltip="' + id + '"]');
		if(opened) {
			cont.show().siblings().hide();
			var time = 0;
		} else {
			var time = 150;
		}
		cont.css({
			'top': pos_y,
			'right': $(window).width() - 840 - $('.header-cont').offset().left * 1/1.5 /*$(window).width() - $('.header-cont').offset().left - $('.header-cont').offset().left * 1.5*/
		});
		show_timeout = setTimeout(function(){
			cont.css('z-index', 999);
			cont.addClass('active').show();
			cont.css({
				'display': 'inline-block',
			});

			var tr_x = this_tool.offset().left - cont.offset().left + this_tool.width()/2 - 15/2;
			cont.find('.tool-triangle').css('left', tr_x);
			opened = true;
			clearTimeout(timeout);
		}, time);
	}

	function close(id) {
		var cont = $('.js-tooltip-block[data-tooltip="' + id + '"]');
		cont.css('z-index', 6);
		timeout = setTimeout(function(){
			cont.removeClass('active').fadeOut(100);				
			opened = false;
		}, 500);
		clearTimeout(show_timeout);
	}

	init();

})();

var smart_tabs = (function() {
	if($('.js-smartabs').length != 0) {
		$('.js-smartabs').each(function(){
			$(this).find('li').eq(0).addClass('active');
			var parent = $(this).parent().parent();
			parent.find('.main-block').eq(0).siblings().hide();
		});
	}

	$(document).on('mouseover touchstart', '.js-smartabs li', function(){
		$(this).addClass('active').siblings().removeClass('active');
		var parent = $(this).parent().parent().parent();
		parent.find('.main-block').eq($(this).index()).show().siblings().hide();
	});
})();

var color = (function(){
	$(document).on('click', '.colorView', function(){
		$('.slider-window').addClass('window-tocolor');
		$('.color-container').addClass('active');
		return false;
	});
	$(document).on('click', '.color-close', function(){
		$('.slider-window').removeClass('window-tocolor');
		$('.color-container').removeClass('active');
		return false;
	});
})();

var model_load = (function(){
	$(window).on('load', function(){
		if($('.model-fotorama').length != 0) $('.model-fotorama').addClass('loaded');
		if($('.color-container').length != 0) setTimeout(function(){ $('.color-container').addClass('loaded'); }, 500);
	});
})();

var menu_level = (function(){
	var close_timeout = false;
	var show_timeout = false;

	$(document).on('mouseover', '.main-nav .option', function(){
		var option = $(this).attr('data-option');
		if(option != '') {
			car_tooltip_allow = false;
			clearTimeout(close_timeout);
			clearTimeout(show_timeout);
			$('.header-main-menu').addClass('closed');
			$('.header-menu[data-option="' + option + '"]').addClass('active').siblings().removeClass('active');
			show(option, 0);
		}
	});
	$(document).on('mouseout', '.main-nav .option', function(){
		var option = $(this).attr('data-option');
		if(option != '') {
			close(option);
		}
	});

	$(document).on('mouseover', '.header-menu', function(){
		clearTimeout(close_timeout);
	});
	$(document).on('mouseout', '.header-menu', function(){
		var option = $(this).attr('data-option');
		close(option);
	});

	$(document).on('click', '.header-menu', function(){
		if(!$(this).hasClass('active')) {
			return false;
		}
	});

	function show(option, i) {
		show_timeout = setTimeout(function(){
			var blocks = $('.header-menu[data-option="' + option + '"] .option');
			blocks.eq(i).addClass('active');
			i++;
			if(blocks.length == i) {
				$('.header-menu .option').addClass('active');
				return;
			}
			show(option, i);
		}, 50);
	}

	function close(option) {
		close_timeout = setTimeout(function(){
			clearTimeout(show_timeout);
			$('.header-main-menu').removeClass('closed');
			$('.header-menu[data-option="' + option + '"]').removeClass('active');
			$('.header-menu .option').removeClass('active');
			car_tooltip_allow = true;
		}, 1000);
	}
})();

$('.cars-tooltip').carsHover();
$("ul#tabs").tabs("#tabContent");
$('.testSelect').SumoSelect();

