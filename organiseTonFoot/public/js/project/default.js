var matched, browser;
var error_message_suffix = "_error_message";
// Use of jQuery.browser is frowned upon.
// More details: http://api.jquery.com/jQuery.browser
// jQuery.uaMatch maintained for back-compat
jQuery.uaMatch = function (ua) {
    ua = ua.toLowerCase();
    var match = /(chrome)[ \/]([\w.]+)/.exec(ua) ||
        /(webkit)[ \/]([\w.]+)/.exec(ua) ||
        /(opera)(?:.*version|)[ \/]([\w.]+)/.exec(ua) ||
        /(msie) ([\w.]+)/.exec(ua) ||
        ua.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec(ua) ||
        [];

    return {
        browser: match[1] || "",
        version: match[2] || "0"
    };
};

matched = jQuery.uaMatch(navigator.userAgent);
browser = {};
if (matched.browser) {
    browser[matched.browser] = true;
    browser.version = matched.version;
}
// Chrome is Webkit, but Webkit is also Safari.
if (browser.chrome) {
    browser.webkit = true;
} else if (browser.webkit) {
    browser.safari = true;
}
jQuery.browser = browser;

$(document).ready(function () {
    $('iframe').each(function () {/*fix youtube z-index*/
        var ifr_source = $(this).attr('src') || "";
        if (ifr_source.length > 0) {
            var url = $(this).attr("src");
            if (url.indexOf("youtube.com") >= 0) {
                if (url.indexOf("?") >= 0) {
                    $(this).attr("src", url + "&wmode=transparent");
                } else {
                    $(this).attr("src", url + "?wmode=transparent");
                }
            }
        }
    });

    $('.ddmenu li.dropdown').hover(function () {
        if ($.browser.msie && (parseInt($.browser.version, 10) === 8 || parseInt($.browser.version, 10) === 7)) {
            $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn();
            return;
        }
        var width = Math.max($(window).innerWidth(), window.innerWidth);
        if (width > 979) $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn();        
    }, function () {
        if ($.browser.msie && (parseInt($.browser.version, 10) === 8 || parseInt($.browser.version, 10) === 7)) {
            $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut();
            return;
        }
        var width = Math.max($(window).innerWidth(), window.innerWidth);
        if (width > 979) $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut();
    });

    $('.ddmenu li.dropdown').click(function () {
        $('.dropdown-menu').stop(true, true).delay(200).fadeOut();
        var width = Math.max($(window).innerWidth(), window.innerWidth);
        if (width <= 1024) {
            if ($(this).find('.dropdown-menu').css('display') == 'none') {
                $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn();
                return false;
            } else {
                /*dropdown already opened. then goto parent link.*/
            }
        }
    });

    
    $(".history-back").on("click", function(e){
    	var href = $(this).attr("href");

    	//if no location, then history.back()
    	if(href ==  null || href == "" || href == "#")
    	{
    		e.preventDefault();
    		history.back();
    		return false;
    	}
    	
    	//otherwise, redirect to the href location
    	window.location.href = href;
    });
    
    /**
	 * Display an error notification at the top right of the screen
	 */
	$.fn.displayErrorNotification = function(message, autoclose)
	{
		noty({
			layout: 'topRight',
			type: 'error',
			timeout: autoclose,
			text: "<u>Erreur</u><br /><br />" + message,
			closeWith: ['button']
		});
	};
	
	/**
	 * Display an success notification at the top right of the screen
	 */
	$.fn.displaySuccessNotification = function(message, autoclose)
	{
		noty({
			layout: 'topRight',
			type: 'success',
			timeout: autoclose,
			text: "<u>Succes</u><br /><br />" + message,
			closeWith: ['button']
		});
	};
	
	/**
	 * Display an information notification at the top right of the screen
	 */
	$.fn.displayInfoNotification = function(message, autoclose)
	{	    
		noty({
			layout: 'topRight',
			type: 'information',
			timeout: autoclose,
			text: "<u>Info</u><br /><br />" + message,
			closeWith: ['button']
		});
	};
	
	/**
	 * Display an warning notification at the top right of the screen
	 */
	$.fn.displayWarnNotification = function(message, autoclose)
	{	    
		noty({
			layout: 'topRight',
			type: 'warning',
			timeout: autoclose,
			text: "<u>Attention</u><br /><br />" + message,
			closeWith: ['button']
		});
	};
    
    /**
     * Close all notifications
     */
    $.fn.closeAllNotifications = function(){
        $.noty.closeAll();
    };
    
    /**
     * reinit field state of a form
     * @param Form frm
     */
    $.fn.reinitUiState = function(frm)
    {
        var statesArray = new Array("warning-state", "error-state", "success-state");
        
        $(":input", frm).each(function() {
            var field = $(this);            
            for(var i= 0; i < statesArray.length; i++)
            {
                var state = statesArray[i];
                var divParent = field.parent();
                if(divParent.hasClass(state)) {                    
                    divParent.removeClass(state);
                    var id = field.attr('id');                    
                    $("#" + id + error_message_suffix).empty();
                    $("#" + id + error_message_suffix).hide();
                }
            }
        });
    };
    
    /**
     * executeQuery function
     * 
     * send ajax request and treat the result
     * 
     * @param event - the current event
     * @param frm - the html form
     * @param url - url of the service
     * @param onSuccessClbk - function executed on success
     * @param onFailedClbk - function executed on failed
     */
    $.fn.executeQuery = function(event, frm, url, onSuccessClbk, onFailedClbk)
    {
        event.preventDefault();
        $().reinitUiState(frm);
        $().closeAllNotifications();            
    	$.post(url, frm.serialize(), null, "json").always(
    		function(data)
    		{
    			if(!data.success)
    			{
    				if (typeof data.fieldErrors != 'undefined' && data.fieldErrors != null) {
    					if(typeof onFailedClbk === 'function')
                    	{
    						onFailedClbk(data);
                    	}
    					
    					for(var key in data.fieldErrors)
    					{
    						$("#" + key).parent().addClass("error-state");
    						$("#" + key + error_message_suffix).html(data.fieldErrors[key] + "<br />");
    						$("#" + key + error_message_suffix).show();
    					}
    				}
    				else if(data.error != null && data.error.length > 0)
    				{
    					//show an error gritter
    					$().displayErrorNotification(data.error, 10000);
    				}
    			}
    			else
    			{
    				if(data.reloadMenu != null && data.reloadMenu.length > 0)
    				{
    					
    				}
    				
                    if(data.successMessage != null && data.successMessage.length > 0)
    				{
    					//show an success gritter
    					$().displaySuccessNotification(data.successMessage, 10000);
    				}
                    
                    //display html page if given in json data
                    if(data.html != null && data.html.length > 0)
                	{
                    	$(".page-content").html(data.html);
                	}
                    
                    if(typeof onSuccessClbk === 'function')
                	{
                    	onSuccessClbk(data);
                	}
    			}
    		}
    	);
    };
    
    $("#connexionLink").click(
        function(event)
        {
            event.preventDefault();
            var url = $(this).attr("href");
            $.get(url).always(
        		function(html)
        		{
                     $.Dialog({
                        overlay: true,
                        shadow: true,
                        flat: false,
                        title: "<i class='icon-locked fg-yellow on-left'></i>Connexion utilisateur",
                        padding:10,
                        icon:"",
                        width:"450px",
                        height:"240px",                        
                        onShow: function(_dialog){
                            var content = _dialog.children('.content');
                            content.html(html);
                            $.Metro.initInputs();
                        }
                     });
        		}
            );
        }
    );
        
    $("#frm").submit(
        function(event)
        {        	
            $().executeQuery(event, $(this), $(this).attr("action"), function(data){
            	//success function            	
            }, function(data){
            	//failed function
            	$().displayWarnNotification("Veuillez verifier le formulaire de connexion.<br /><br />Certaines donn&eacute;es envoy&eacute;es sont incorrectes, ou non renseign&eacute;es", 10000);
            });
        }
    );
    
    $("#resetLink").click(
        function(event)
        {
            event.preventDefault();
            var frm = $(this).parents('form:first');
            frm[0].reset();
        }
    );
    
    //goto top page link
    $(window).scroll(function() {
	  if($(window).scrollTop() == 0){
	    $('#scrollToTop').fadeOut("fast");
	  } else {
	    if($('#scrollToTop').length == 0){
	      $('body').append('<div id="scrollToTop">'+
	        '<a href="#"><i class="icon-arrow-up-5 fg-darker"></i></a>'+
	        '</div>');
	    }
	    $('#scrollToTop').fadeIn("fast");
	  }
	});
    
    $(document).on('click', '#scrollToTop a', function(event){
    	  event.preventDefault();
    	  $('html,body').animate({scrollTop: 0}, 'slow');
    });
});

