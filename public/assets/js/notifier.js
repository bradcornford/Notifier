/** Notifier.js - v1.1.0 - 2015/11/26
 * https://github.com/bradcornford/Notifier
 * Copyright (c) 2015 Bradley Cornford - MIT
 */
(function ($) {

    $.notify.addStyle('bootstrap',{html:'<div class="alert" role="alert">\n<span data-notify-text></span>\n</div>',classes:{base:{padding:'15px','margin-bottom':'20px',border:'1px solid transparent','border-radius':'4px',color:'#545454','background-color':'#e8e8e8','border-color':'#d1d1d1'},error:{color:'#a94442','background-color':'#f2dede','border-color':'#ebccd1'},success:{color:'#3c763d','background-color':'#dff0d8','border-color':'#d6e9c6'},info:{color:'#31708f','background-color':'#d9edf7','border-color':'#bce8f1'},warn:{color:'#8a6d3b','background-color':'#fcf8e3','border-color':'#faebcc'}}});

    var notifierUrl, notifierLoad, notifierSettings;

    $.fn.notifier = function(options) {
        var settings = $.extend({
            enabled: true,
            pageLoad: true,
            ajaxLoad: true,
            clickToHide: true,
            autoHide: true,
            autoHideDelay: 5000,
            globalPosition: 'top right',
            style: 'bootstrap',
            className: 'error',
            showAnimation: 'slideDown',
            showDuration: 1000,
            hideAnimation: 'slideUp',
            hideDuration: 200,
            gap: 1,
            urlExceptions: ["/notifier/notifications"]
        }, options);

        settings.urlExceptions.push("/notifier/notifications");

        if ($(location).attr('href').indexOf('public') > -1) {
            notifierUrl = $(location).attr('href').split('public')[0] + 'public/notifier/notifications';
        } else {
            notifierUrl = $(location).attr('protocol') + '//' + $(location).attr('hostname') + '/notifier/notifications';
        }

        notifierDisplay = function (settings) {
            var display = false;
            var url = settings.url;

            if (notifierSettings.enabled && notifierSettings.ajaxLoad && url != notifierUrl) {
                display = true;

                notifierSettings.urlExceptions.forEach(function(item) {
                    if (url.indexOf(item) > -1) {
                        display = false;
                    }
                });
            } else {
                display = false;
            }

            if (display) {
                notifierLoad();
            }
        }

        notifierLoad = function () {
            $.getJSON(notifierUrl,
                function(data) {
                    $.each(data.notifications,
                        function(key, item)  {
                            $.notify(item.message, item.type, $.extend(settings, item.options));
                        }
                    );
                }
            );
        }

        if (settings.enabled && settings.pageLoad) {
            notifierLoad();
        }

        notifierSettings = settings;

        $(document).ajaxComplete(function(evt, xhr, settings) {
            notifierDisplay(settings);
        });

        $(document).on(
            'bootstrap-ajax:success bootstrap-ajax:error',
            function (e)
            {
                notifierDisplay(settings);
            }
        );

        return this;
    };

}( jQuery ));