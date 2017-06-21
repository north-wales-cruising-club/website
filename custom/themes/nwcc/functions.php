<?php

// 28/4/2017 Really bad hack to get around problems with JustHost Varnish cache server caching logged out pages.
// JustHost refused to provide technical assistance and information about their Varnish cache to allow a more nuanced
// solution
add_action( 'init', 'nocache_headers' );

/**
 * Create a shortcode to create a link to PM a user
 *
 * @return string The content to be injected
 */
function bp_private_message_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        'to' => ''
    ), $atts));

    if( is_user_logged_in() ) {
        return '<a href="' . wp_nonce_url( bp_loggedin_user_domain() . bp_get_messages_slug() . '/compose/?r=' . $to ) . '" title="Create private message">' . $content . '</a>';
    } else {
        return '<span style="opacity: 0.5">[Please </span><span style="opacity: 1.0"><a href="' . wp_login_url() . '">log in</a></span><span style="opacity: 0.5"> to access this link]</span>';
    }
}
add_shortcode( 'bp_privatemessage', 'bp_private_message_shortcode' );

/**
 * Shortcode for inserting Mailchimp archive
 *
 * @param type $atts The shortcode attributes
 * @param type $content The content to inject
 */
function nwcc_mailchimp_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        'mode' => 'signup'
    ), $atts));

    switch ($mode) {
        case 'signup':
            return '<!-- Begin MailChimp Signup Form -->
<link href="//cdn-images.mailchimp.com/embedcode/classic-10_7.css" rel="stylesheet" type="text/css">
<div id="mc_embed_signup">
<form action="//nwcc.us12.list-manage.com/subscribe/post?u=48300ed9f14f69f4cf12bcc9b&amp;id=31ee33acfc" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
    <div id="mc_embed_signup_scroll">
<div class="indicates-required"><span class="asterisk">*</span> indicates required</div>
<div class="mc-field-group">
	<label for="mce-EMAIL">Email Address  <span class="asterisk">*</span>
</label>
	<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
</div>
<div class="mc-field-group">
	<label for="mce-FNAME">First Name </label>
	<input type="text" value="" name="FNAME" class="" id="mce-FNAME">
</div>
<div class="mc-field-group">
	<label for="mce-LNAME">Last Name </label>
	<input type="text" value="" name="LNAME" class="" id="mce-LNAME">
</div>
<div class="mc-field-group input-group">
    <strong>Interests </strong>
    <ul><li><input type="checkbox" value="2048" name="group[6169][2048]" id="mce-group[6169]-6169-0"><label for="mce-group[6169]-6169-0">On the water events</label></li>
<li><input type="checkbox" value="4096" name="group[6169][4096]" id="mce-group[6169]-6169-1"><label for="mce-group[6169]-6169-1">Social events</label></li>
<li><input type="checkbox" value="8192" name="group[6169][8192]" id="mce-group[6169]-6169-2"><label for="mce-group[6169]-6169-2">Newsletters</label></li>
</ul>
</div>
	<div id="mce-responses" class="clear">
		<div class="response" id="mce-error-response" style="display:none"></div>
		<div class="response" id="mce-success-response" style="display:none"></div>
	</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
    <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_48300ed9f14f69f4cf12bcc9b_31ee33acfc" tabindex="-1" value=""></div>
    <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
    </div>
</form>
</div>

<!--End mc_embed_signup-->';

        case 'archive':
            return '<script language="javascript" src="//nwcc.us12.list-manage.com/generate-js/?u=48300ed9f14f69f4cf12bcc9b&fid=3269&show=100" type="text/javascript"></script>';
    }
}
add_shortcode( 'nwcc_mailchimp', 'nwcc_mailchimp_shortcode' );

/**
 * Shortcode for displaying a Navionics Map.
 *
 * @example <code>[navionics]</code> produces a simple Navionics map
 * @example <code>[navionics lat="53.1" long="-4.4"]</code> produces a Navionics map centred on given lat and long
 *
 * @param array $attrs The shortcode attributes.  Supported attributes:
 *                      lat - Set to the latitude of the centre of the map.  If lat or long are not specified, map will be centred on (0,0)
 *                      long - Set to the longitude of the centre of the map.  If lat or long are not specified, map will be centred on (0,0)
 *                      zoom - Show zoom controls (default true)
 *                      units - Show units (default true)
 *                      scale - Show scale (default true)
 *
 * @return string The content to inject
 */
function nwcc_navionicsMapShortcode($attrs)
{
    global $post;
    $id = $post->ID;
    $lat = false;
    $long = false;

    $zoom = 'true';
    $units = 'true';
    $scale = 'true';
    $pinTitle = null;
    $pinBody = '';
    $zoomLevel = 0;

    if (is_array($attrs)) {
        if (array_key_exists('lat', $attrs)) {
            $lat = $attrs['lat'];
        }

        if (array_key_exists('long', $attrs)) {
            $long = $attrs['long'];
        }

        if (array_key_exists('zoomlevel', $attrs)) {
            $zoomLevel = (int)$attrs['zoomlevel'];
        }

        if (array_key_exists('id', $attrs)) {
            $id = (int)$attrs['id'];
        }

        if (array_key_exists('zoom', $attrs) && $attrs['zoom'] == 'false') {
            $zoom = 'false';
        }

        if (array_key_exists('units', $attrs) && $attrs['units'] == 'false') {
            $units = 'false';
        }

        if (array_key_exists('scale', $attrs) && $attrs['scale'] == 'false') {
            $scale = 'false';
        }

        if (array_key_exists('pintitle', $attrs)) {
            $pinTitle = $attrs['pintitle'];
        }

        if (array_key_exists('pinbody', $attrs)) {
            $pinBody = $attrs['pinbody'];
        }
    }


    if ($lat && $long) {
        $result = "
        <div id='nautical-map-container-" . $id . "'></div>
        <script>
            var webapi = new JNC.Views.BoatingNavionicsMap({
                tagId: '#nautical-map-container-" . $id . "',
                center: [" . $long . "," . $lat . "],
                zoom: " . $zoomLevel . ",
                ZoomControl: " . $zoom . ",
                DistanceControl: false,
                SonarControl: false,
                LayerControl: false,
                navKey: 'Navionics_webapi_02819'
            });
            webapi.showScaleLineControl(" . $scale . ");
            webapi.showDepthUnitControl(" . $units . ");
            webapi.showDistanceUnitControl(" . $units . ");";

        if ($pinTitle !== null) {
            $result .= "
            function openBalloon(title, body, position) {
                var content = {
                    title: title,
                    content: body,
                    coordinates: ol.proj.transform(position, 'EPSG:4326', 'EPSG:3857'),
                }
                webapi.showBalloon(content);
            }

            openBalloon('$pinTitle', '$pinBody', [$long, $lat]);";
        }

        $result .= "</script>";
    } else {
        $result = "
        <div id='nautical-map-container-" . $id . "'></div>
        <script>
            var webapi = new JNC.Views.BoatingNavionicsMap({
                tagId: '#nautical-map-container-" . $id . "',
                center: [12.0, 46.0],
                zoom: " . $zoomLevel . ",
                ZoomControl: " . $zoom . ",
                DistanceControl: false,
                SonarControl: false,
                LayerControl: false,
                navKey: 'Navionics_webapi_02819'
            });
            webapi.showScaleLineControl(" . $scale . ");
            webapi.showDepthUnitControl(" . $units . ");
            webapi.showDistanceUnitControl(" . $units . ");
        </script>";
    }

    return $result;
}

/**
 * Enqueue scripts and styles
 */
function nwcc_enqueueScripts() {
    wp_register_script('navionics', '//webapiv2.navionics.com/dist/webapi/webapi.min.no-dep.js', array(), false, false);
    wp_register_style('navionics', '//webapiv2.navionics.com/dist/webapi/webapi.min.css', array(), false, 'all');

    wp_enqueue_script('navionics');
    wp_enqueue_style('navionics');
}

add_action('wp_enqueue_scripts', 'nwcc_enqueueScripts');
add_shortcode( 'nwcc_navionics', 'nwcc_navionicsMapShortcode' );

/**
 * Initialisation action
 **/
function nwcc_init() {
    // add_post_type_support( 'event', 'publicize' );
}

add_action('init', 'nwcc_init');
