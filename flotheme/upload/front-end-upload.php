<?php

global $feu_destination_dir;
global $feu_destination_url;
global $front_end_upload;

// constant definition
if( !defined( 'IS_ADMIN' ) )
    define( 'IS_ADMIN', is_admin() );

define( 'FEU_PREFIX',   '_iti_feu_' );
define( 'FEU_DIR',      WP_PLUGIN_DIR . '/' . basename( dirname( __FILE__ ) ) );
define( 'FEU_URL',      rtrim( plugin_dir_url( __FILE__ ), '/' ) );

// randomize the destination for security
if( !$salt = get_option( '_feufilesalt' ) )
    $salt = update_option( '_feufilesalt', 'feu_' . md5( uniqid( 'feu_uploads_' ) ) );

$feu_destination_dir = WP_CONTENT_DIR . '/uploads/' . $salt;
$feu_destination_url = WP_CONTENT_URL . '/uploads/' . $salt;

define( 'FEU_DESTINATION_DIR', $feu_destination_dir );
define( 'FEU_DESTINATION_URL', $feu_destination_url );

// cleanup potential unwanted dir (added version 0.5.4)
$unwanted = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'FEU_DESTINATION_DIR';
if( file_exists( $unwanted ) )
{
    rename( $unwanted, uniqid( $unwanted ) );
}


add_action( 'get_footer',           array( 'FrontEndUpload', 'init_plupload' ) );

// we also need to do some maintenance
add_action( 'wp_scheduled_delete',      array( 'FrontEndUpload', 'cleanup_transients' ) );
add_action( 'init',                     array( 'FrontEndUpload', 'register_storage' ) );
add_action( 'parse_request',            array( 'FrontEndUpload', 'process_download' ) );


/**
 * Front End Upload
 *
 * @package WordPress
 * @author Jonathan Christopher
 **/
class FrontEndUpload
{
    public $settings    = array(
        'version'   => FLOTHEME_VERSION,
    );


    /**
     * Constructor
     * Sets default options, initializes localization and shortcodes
     *
     * @return void
     * @author Jonathan Christopher
     */
    function __construct()
    {
        $settings = get_option( FEU_PREFIX . 'settings' );
        if( !$settings )
        {
            // first run
            self::first_run();
            add_option( FEU_PREFIX . 'settings', $this->settings, '', 'yes' );
        }
        else
        {
            $this->settings = $settings;
        }

        // localization
        self::l10n();

        // shortcode init
        if( !IS_ADMIN )
        {
            self::init_shortcodes();
        }
    }


    function hash_location( $filename, $hash )
    {
        $salt = get_option( '_feufilesalt' );

        if( empty( $salt ) || empty( $filename ) || empty( $hash ) )
            die();

        $recordid = md5( $filename . $hash . $salt );
        update_option( $recordid, $filename );

        return $recordid;
    }



    function mkdir_recursive( $path )
    {
        if ( empty( $path ) )
            return;

        is_dir( dirname( $path ) ) || self::mkdir_recursive( dirname( $path ) );

        if ( is_dir( $path ) === TRUE ) {
            return TRUE;
        } else {
            return @mkdir( $path );
        }
    }

    /**
     * Initialize appropriate shortcod
     *
     * @return void
     * @author Jonathan Christopher
     */
    function init_shortcodes() {
        add_shortcode( 'front-end-upload', array( 'FrontEndUpload', 'shortcode' ) );
    }


    /**
     * Shortcode handler that outputs the form, Plupload, and any feedback messages
     *
     * @return string $output Formatted HTML to be used in the theme
     * @author Jonathan Christopher
     */
    function shortcode( $atts ) {
        // grab FEU's settings
        $settings   = get_option( FEU_PREFIX . 'settings' );

        $output     =  '<div class="front-end-upload-parent">';

        $nonce = isset( $_POST['_wpnonce'] ) ? $_POST['_wpnonce'] : '';

        // do we need to show the form?
        if( ( isset( $_POST['_wpnonce'] ) && wp_verify_nonce( $nonce, 'feuaccess' ) ) )
        {
            // verified upload submission, let's send the email

            // grab our filenames
            $files      = isset( $_POST['feu_file_ids'] ) ? $_POST['feu_file_ids'] : array();

            $file_list  = '';
            if( is_array( $files ) )
                foreach( $files as $filehash )
                    $file_list .= get_bloginfo( 'url' ) . '?feu=1&feuid=' . $filehash . "\n";

            // lastly we'll output our success message
            $success_message = isset( $settings['success_message'] ) ? $settings['success_message'] : '<strong>Your files have been received.</strong>';
            $output .= '<div class="front-end-upload-success">';
            $output .= wpautop( $success_message );
            $output .= '</div>';
        }
        else
        {
            $passcode    = isset( $_POST['feu_passcode'] ) ? $_POST['feu_passcode'] : '';

            $output     .= '<form action="" method="post" class="front-end-upload-flags">';

            // we're going to check to see if a passcode has been set and no passcode has been submitted (yet)
            // OR that a passcode has been set and the submitted passcode passes validation
            if( ( isset( $settings['passcode'] ) && !empty( $settings['passcode'] ) )           // passcode was set
                && empty( $passcode )                                                           // passcode was not submitted
                || ( ( !empty( $passcode ) && ( $passcode != $settings['passcode'] ) )          // invalid passcode submitted
                    && ( isset( $_POST['_wpnonce'] ) && wp_verify_nonce( $nonce, 'feunonce' ) ) // but only if valid submission
                    )
            )
            {
                $output     .= '<input type="hidden" name="_wpnonce" id="_wpnonce" value="' . wp_create_nonce( 'feunonce' ) . '" />';

                $output     .= '<div class="front-end-upload-passcode">';
                if( !empty( $passcode ) )
                {
                    $output .= '<div class="front-end-upload-error passcode-error">';
                    $output .= __( 'Invalid passcode', 'frontendupload' );
                    $output .= '</div>';
                }
                $output     .= '<label for="feu_passcode">' . __( 'Passcode', 'frontendupload' ) . '</label>';
                $output     .= '<input type="text" name="feu_passcode" id="feu_passcode" value="' . $passcode . '" />';
                $output     .= '</div>';
            }
            else
            {
                // we can go ahead and show the form

                // Plupload container
                $output     .= '<div class="front-end-upload"><p>' . __( "There is a conflict with the active theme or one of the active plugins. Please view your console to determine the issue.", 'frontendupload' ) . '</p></div>';

                // Email
                $output     .= '<div class="front-end-upload-email">';
                $output     .= '<label for="feu_email">' . __( 'Your Email Address', 'frontendupload' ) . '</label>';
                $output     .= '<input type="text" name="feu_email" class="required email" id="feu_email" value="" />';
                $output     .= '</div>';

                // Message
                $output     .= '<div class="front-end-upload-message">';
                $output     .= '<label for="feu_message">' . __( 'Message', 'frontendupload' ) . '</label>';
                $output     .= '<textarea name="feu_message" id="feu_message"></textarea>';
                $output     .= '</div>';

                // we're going to flag the fact that we've got a valid submission
                $output     .= '<input type="hidden" name="_wpnonce" id="_wpnonce" value="' . wp_create_nonce( 'feuaccess' ) . '" />';
            }

            $output         .= '<div class="front-end-upload-submit"><button type="submit" />' . __( 'Submit', 'frontendupload' ) . '</button></div>';
            $output         .= '</form>';
        }

        $output .= '</div>';

        return $output;

    }


    /**
     * Initializes Plupload on the front end
     *
     * @return void
     * @author Jonathan Christopher
     */
    function init_plupload()
    {
        // define our first hash
        $hash = uniqid( 'feuhash_' );
        set_transient( $hash, 1, 60*60*18 );

        // grab our salt
        $salt       = get_option( '_feufilesalt' );    // unique to each install
        $uploadflag = uniqid( 'feuupload_' );
        $uniqueflag = sha1( $salt . $uploadflag . $_SERVER['REMOTE_ADDR'] );
        set_transient( 'feuupload_' . $uploadflag, $uniqueflag, 60*60*18 );

        // handle our on-server location
        $url = 'http';
        if (isset($_SERVER['HTTPS']) && 'off' != $_SERVER['HTTPS'] && 0 != $_SERVER['HTTPS'])
            $url = 'https';
        $url .= '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        set_transient( 'feu_referer_' . md5( $url . $hash . $salt ), 1, 60*60*18 );

        // prep our max file size
        $settings = get_option( FEU_PREFIX . 'settings' );
        if( !empty( $settings ) && isset( $settings['max_file_size'] ) )
        {
            $max_file_size = intval( $settings['max_file_size'] );
        }
        else
        {
            $max_file_size = '10';
        }
        ?>
    <script type="text/javascript">
        var FEU_VARS = {
            destpath: '<?php echo FEU_URL; ?>',
            hash: '<?php echo $hash; ?>',
            uploadflag: '<?php echo $uploadflag; ?>',
            maxfilesize: '<?php echo $max_file_size; ?>',
            customext: <?php if( isset( $settings['custom_file_extensions'] ) && !empty( $settings['custom_file_extensions'] ) ) { ?>
                {title : "Other", extensions : "<?php echo $settings['custom_file_extensions']; ?>"}
                <?php } else { echo "null"; } ?>
        };
        var FEU_LANG = {
            email: '<?php _e( "You must enter a valid email address.", "frontendupload" ); ?>',
            min: '<?php _e( "You must queue at least one file.", "frontendupload" ); ?>'
        };
    </script>
    <?php
        wp_enqueue_script(
            'feu-env'
            ,FEU_URL . '/feu.js'
            ,'jquery'
            ,FLOTHEME_VERSION
            ,TRUE
        );
    }


    /**
     * Transients are used quite heavily to generate hashes, this function will essentially garbage collect them
     */
    function cleanup_transients() {
        global $wpdb, $_wp_using_ext_object_cache;

        if( $_wp_using_ext_object_cache )
            return;

        $time = isset ( $_SERVER['REQUEST_TIME'] ) ? (int) $_SERVER['REQUEST_TIME'] : time();
        $sql = "SELECT option_name FROM {$wpdb->options} WHERE ( option_name LIKE '_transient_timeout_feu_referer_%' AND option_value < {$time} ) OR ( option_name LIKE '_transient_timeout_feuhash_%' AND option_value < {$time} ) OR ( option_name LIKE '_transient_timeout_feuupload_feuupload_%' AND option_value < {$time} );";
        $expired = $wpdb->get_col( $sql );

        foreach( $expired as $transient ) {
            $key = str_replace( '_transient_timeout_', '', $transient );
            delete_transient( $key );
        }
    }

}

$front_end_upload = new FrontEndUpload();
