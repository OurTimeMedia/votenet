// JavaScript Document

/**
 * This is the callback function which receives notification
 * about the state of the next button.
 */
function mycarousel_buttonNextCallback(carousel, button, enabled) {
    display('Next button is now ' + (enabled ? 'enabled' : 'disabled'));
	if(enabled)
	{
		button.style.display='block';	
	}
	else
	{
		button.style.display='none';
	}
};

/**
 * This is the callback function which receives notification
 * about the state of the prev button.
 */
function mycarousel_buttonPrevCallback(carousel, button, enabled) {
    display('Prev button is now ' + (enabled ? 'enabled' : 'disabled'));
if(enabled)
	{
		button.style.display='block';	
	}
	else
	{		
		button.style.display='none';
	}
};

/**
 * This is the callback function which receives notification
 * right after initialisation of the carousel
 */
function mycarousel_initCallback(carousel, state) {
    if (state == 'init')
        display('Carousel initialised');
    else if (state == 'reset')
        display('Carousel reseted');
};

/**
 * This is the callback function which receives notification
 * right after reloading of the carousel
 */
function mycarousel_reloadCallback(carousel) {
    display('Carousel reloaded');
};

/**
 * This is the callback function which receives notification
 * when an item becomes the first one in the visible range.
 */
function mycarousel_itemFirstInCallback(carousel, item, idx, state) {
    display('Item #' + idx + ' is now the first item');
};

/**
 * This is the callback function which receives notification
 * when an item is no longer the first one in the visible range.
 */
function mycarousel_itemFirstOutCallback(carousel, item, idx, state) {
    display('Item #' + idx + ' is no longer the first item');
};

/**
 * This is the callback function which receives notification
 * when an item becomes the first one in the visible range.
 */
function mycarousel_itemLastInCallback(carousel, item, idx, state) {
    display('Item #' + idx + ' is now the last item');
};

/**
 * This is the callback function which receives notification
 * when an item is no longer the first one in the visible range.
 */
function mycarousel_itemLastOutCallback(carousel, item, idx, state) {
    display('Item #' + idx + ' is no longer the last item');
};

/**
 * This is the callback function which receives notification
 * when an item becomes the first one in the visible range.
 * Triggered before animation.
 */
function mycarousel_itemVisibleInCallbackBeforeAnimation(carousel, item, idx, state) {
    // No animation on first load of the carousel
    if (state == 'init')
        return;

    jQuery('img', item).fadeIn('slow');
};

/**
 * This is the callback function which receives notification
 * when an item becomes the first one in the visible range.
 * Triggered after animation.
 */
function mycarousel_itemVisibleInCallbackAfterAnimation(carousel, item, idx, state) {
    display('Item #' + idx + ' is now visible');
};

/**
 * This is the callback function which receives notification
 * when an item is no longer the first one in the visible range.
 * Triggered before animation.
 */
function mycarousel_itemVisibleOutCallbackBeforeAnimation(carousel, item, idx, state) {
    jQuery('img', item).fadeOut('slow');
};

/**
 * This is the callback function which receives notification
 * when an item is no longer the first one in the visible range.
 * Triggered after animation.
 */
function mycarousel_itemVisibleOutCallbackAfterAnimation(carousel, item, idx, state) {
    display('Item #' + idx + ' is no longer visible');
};

/**
 * Helper function for printing out debug messages.
 * Not needed for jCarousel.
 */
var row = 1;
function display(s) {
    // Log to Firebug (getfirebug.com) if available
    //if (window.console != undefined && typeof window.console.log == 'function')
      //  console.log(s);

    if (row >= 1000)
        var r = row;
    else if (row >= 100)
        var r = '&nbsp;' + row;
    else if (row >= 10)
        var r = '&nbsp;&nbsp;' + row;
    else
        var r = '&nbsp;&nbsp;&nbsp;' + row;

    //jQuery('#display').html(jQuery('#display').html() + r + ': ' + s + '<br />').get(0).scrollTop += 10000;

    row++;
};

jQuery(document).ready(function() {
    jQuery('#mycarousel').jcarousel({
        scroll: 2,
		//visible: 5,
		
        initCallback:   mycarousel_initCallback,
        reloadCallback: mycarousel_reloadCallback,

        buttonNextCallback:   mycarousel_buttonNextCallback,
        buttonPrevCallback:   mycarousel_buttonPrevCallback,

        itemFirstInCallback:  mycarousel_itemFirstInCallback,
        itemFirstOutCallback: mycarousel_itemFirstOutCallback,
        itemLastInCallback:   mycarousel_itemLastInCallback,
        itemLastOutCallback:  mycarousel_itemLastOutCallback,
        itemVisibleInCallback: {
            onBeforeAnimation: mycarousel_itemVisibleInCallbackBeforeAnimation,
            onAfterAnimation:  mycarousel_itemVisibleInCallbackAfterAnimation
        },
        itemVisibleOutCallback: {
            /*onBeforeAnimation: mycarousel_itemVisibleOutCallbackBeforeAnimation,
            onAfterAnimation:  mycarousel_itemVisibleOutCallbackAfterAnimation*/
        }
    });
});
