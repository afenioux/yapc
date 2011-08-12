<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr" xml:lang="en">

	<head>
	  <title>Admin Page</title>
	  <meta http-equiv="content-type"
	        content="text/html; charset=utf-8" />
	  <meta http-equiv="Content-Style-Type"
	        content="text/css" />
	  <meta name="Author"
	        content="Arnaud FENIOUX" />
	
	  <link media="screen"
	        href="css/style.css"
	        type="text/css"
	        rel="stylesheet" />
	 
	 <link media="screen"
	        href="css/fancyupload.css"
	        type="text/css"
	        rel="stylesheet" />
	
	<link media="screen"
                href="css/ReMooz.css"
                type="text/css"
                rel="stylesheet" />

	        
	<script type="text/javascript" src="inc/mootools-1.2-core-nc.js"></script>
	<script type="text/javascript" src="inc/mootools-1.2-more-nc.js"></script>
	<script type="text/javascript" src="inc/Swiff.Uploader.js"></script>
	<script type="text/javascript" src="inc/Fx.ProgressBar.js"></script>
	<script type="text/javascript" src="inc/FancyUpload2.js"></script>
	<script type="text/javascript" src="inc/ReMooz.js"></script>
	<script type="text/javascript">
		/* <![CDATA[ */
window.addEvent('load', function() {
	
	 /**
         * Some options for the large photos.
         *
         * The first argument is the argument for $$ (can be an array of elements or a selector)
         */

        ReMooz.assign('#demo-photos a', {
                'origin': 'img',
                'shadow': 'onOpenEnd', // fx is faster because shadow appears after resize animation
                'resizeFactor': 0.8, // resize to maximum 80% of screen size
                'cutOut': false, // don't hide the original
                'opacityResize': 0.4, // opaque resize
                'dragging': true, // enable dragging
                'centered': true // resize to center of the screen, not relative to the source element
        });

        /**
         * Note on "shadow": value can be true, onOpenEnd (appear after resize) and false, to disable shadow
         * WebKit (Safari 3) uses (great looking) CSS shadows, so it ignores this option.
         */



	var swiffy = new FancyUpload2($('demo-status'), $('demo-list'), {
		'url': $('form-demo').action,
		'data' : $('form-extra'), 
		'fieldName': 'photoupload',
		'path': 'inc/Swiff.Uploader.swf',
		'onLoad': function() {
			$('demo-status').removeClass('hide');
			$('demo-fallback').destroy();
		}
	});
	

	/**
	 * Various interactions
	 */

	$('demo-browse-all').addEvent('click', function() {
		swiffy.browse();
		return false;
	});

	$('demo-browse-images').addEvent('click', function() {
		swiffy.browse({'Images (*.jpg, *.jpeg, *.gif, *.png)': '*.jpg; *.jpeg; *.gif; *.png'});
		return false;
	});

	$('demo-clear').addEvent('click', function() {
		swiffy.removeFile();
		return false;
	});

	$('demo-upload').addEvent('click', function() {
		swiffy.upload();
		return false;
	});

});
		/* ]]> */
	</script>

	        
	        
	</head>
	
	<body>
