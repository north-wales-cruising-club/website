<?php
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
    return '<script language="javascript" src="//nwcc.us12.list-manage.com/generate-js/?u=48300ed9f14f69f4cf12bcc9b&fid=3269&show=10" type="text/javascript"></script>';
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
    $lat = false;
    $long = false;

    $zoom = 'true';
    $units = 'true';
    $scale = 'true';
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

        if (array_key_exists('zoom', $attrs) && $attrs['zoom'] == 'false') {
            $zoom = 'false';
        }

        if (array_key_exists('units', $attrs) && $attrs['units'] == 'false') {
            $units = 'false';
        }

        if (array_key_exists('scale', $attrs) && $attrs['scale'] == 'false') {
            $scale = 'false';
        }
    }


    if ($lat && $long) {
        $result = "
        <div id='nautical-map-container'></div>
        <script>
            var webapi = new JNC.Views.BoatingNavionicsMap({
                tagId: '#nautical-map-container',
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
            webapi.showDistanceUnitControl(" . $units . ");
        </script>";
    } else {
        $result = "
        <div id='nautical-map-container'></div>
        <script>
            var webapi = new JNC.Views.BoatingNavionicsMap({
                tagId: '#nautical-map-container',
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
