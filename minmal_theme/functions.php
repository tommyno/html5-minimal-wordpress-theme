<?

// Common used funtions
// (delete if not used)
// --------------------

// Remove junk from head
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator'); 
remove_action('wp_head', 'wlwmanifest_link');


// Enable post_thumbnails
if ( function_exists( 'add_theme_support' ) ) { 
  add_theme_support( 'post-thumbnails' ); 
}
// add_image_size( 'blog', 751, 350, true ); // true = crop
// add_image_size( 'portrait-col', 223, 260, array( 'center', 'top' )); // crop from center top



/*  Thumbnail upscale / http://alxmedia.se/code/2013/10/thumbnail-upscale-correct-crop-in-wordpress/
/* ------------------------------------ */ 
/*

// REMOVED - DOES NOT WORK WITH ARRAY CROP

function alx_thumbnail_upscale( $default, $orig_w, $orig_h, $new_w, $new_h, $crop ){
    if ( !$crop ) return null; // let the wordpress default function handle this
 
    $aspect_ratio = $orig_w / $orig_h;
    $size_ratio = max($new_w / $orig_w, $new_h / $orig_h);
 
    $crop_w = round($new_w / $size_ratio);
    $crop_h = round($new_h / $size_ratio);
 
    $s_x = floor( ($orig_w - $crop_w) / 2 );
    $s_y = floor( ($orig_h - $crop_h) / 2 );
 
    return array( 0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h );
}
add_filter( 'image_resize_dimensions', 'alx_thumbnail_upscale', 10, 6 );
*/


// Enable custom menu
function register_my_menu() {
  register_nav_menu('custom-menu',__( 'Custom Menu' ));
}
add_action( 'init', 'register_my_menu' );


// Disable SEO yoast columns in backend
// https://wordpress.org/support/topic/plugin-wordpress-seo-by-yoast-option-to-disableenable-columns-in-all-posts
add_filter( 'wpseo_use_page_analysis', '__return_false' );


// Add excerpt to pages
add_action( 'init', 'my_add_excerpts_to_pages' );
function my_add_excerpts_to_pages() {
  add_post_type_support( 'page', 'excerpt' );
}



/**
 * Remove WordPress's default padding on images with captions
 *
 * @param int $width Default WP .wp-caption width (image width + 10px)
 * @return int Updated width to remove 10px padding
 */
function remove_caption_padding( $width ) {
    return $width - 10;
}
add_filter( 'img_caption_shortcode_width', 'remove_caption_padding' );



// Replace special characters on file upload
// http://stackoverflow.com/questions/19444031/browser-could-not-read-filename-which-contains-special-characters
add_filter( 'sanitize_file_name', 't5_sanitize_filename', 10 );

/**
 * Clean up uploaded file names
 * 
 * Sanitization test done with the filename:
 * ÄäÆæÀàÁáÂâÃãÅåªₐāĆćÇçÐđÈèÉéÊêËëₑƒğĞÌìÍíÎîÏïīıÑñⁿÒòÓóÔôÕõØøₒÖöŒœßŠšşŞ™ÙùÚúÛûÜüÝýÿŽž¢€‰№$℃°C℉°F⁰¹²³⁴⁵⁶⁷⁸⁹₀₁₂₃₄₅₆₇₈₉±×₊₌⁼⁻₋–—‑․‥…‧.png
 * @author toscho
 * @url    https://github.com/toscho/Germanix-WordPress-Plugin
 */
function t5_sanitize_filename( $filename )
{
    $filename    = html_entity_decode( $filename, ENT_QUOTES, 'utf-8' );
    $filename    = t5_translit( $filename );
    $filename    = t5_lower_ascii( $filename );
    $filename    = t5_remove_doubles( $filename );
    return $filename;
}

/**
 * Converts uppercase characters to lowercase and removes the rest.
 * https://github.com/toscho/Germanix-WordPress-Plugin
 *
 * @uses   apply_filters( 'germanix_lower_ascii_regex' )
 * @param  string $str Input string
 * @return string
 */
function t5_lower_ascii( $str )
{
    $str     = strtolower( $str );
    $regex   = array(
        'pattern'        => '~([^a-z\d_.-])~'
        , 'replacement'  => ''
    );
    // Leave underscores, otherwise the taxonomy tag cloud in the
    // backend won’t work anymore.
    return preg_replace( $regex['pattern'], $regex['replacement'], $str );
}

/**
 * Reduces repeated meta characters (-=+.) to one.
 * https://github.com/toscho/Germanix-WordPress-Plugin
 *
 * @uses   apply_filters( 'germanix_remove_doubles_regex' )
 * @param  string $str Input string
 * @return string
 */
function t5_remove_doubles( $str )
{
    $regex = apply_filters(
            'germanix_remove_doubles_regex'
            , array(
                'pattern'        => '~([=+.-])\\1+~'
                , 'replacement'  => "\\1"
            )
    );
    return preg_replace( $regex['pattern'], $regex['replacement'], $str );
}    

/**
 * Replaces non ASCII chars.
 * https://github.com/toscho/Germanix-WordPress-Plugin
 *
 * wp-includes/formatting.php#L531 is unfortunately completely inappropriate.
 * Modified version of Heiko Rabe’s code.
 *
 * @author Heiko Rabe http://code-styling.de
 * @link   http://www.code-styling.de/?p=574
 * @param  string $str
 * @return string
 */
function t5_translit( $str )
{
    $utf8 = array(
        'Ä'  => 'Ae'
        , 'ä'    => 'ae'
        , 'Æ'    => 'Ae'
        , 'æ'    => 'ae'
        , 'À'    => 'A'
        , 'à'    => 'a'
        , 'Á'    => 'A'
        , 'á'    => 'a'
        , 'Â'    => 'A'
        , 'â'    => 'a'
        , 'Ã'    => 'A'
        , 'ã'    => 'a'
        , 'Å'    => 'A'
        , 'å'    => 'a'
        , 'ª'    => 'a'
        , 'ₐ'    => 'a'
        , 'ā'    => 'a'
        , 'Ć'    => 'C'
        , 'ć'    => 'c'
        , 'Ç'    => 'C'
        , 'ç'    => 'c'
        , 'Ð'    => 'D'
        , 'đ'    => 'd'
        , 'È'    => 'E'
        , 'è'    => 'e'
        , 'É'    => 'E'
        , 'é'    => 'e'
        , 'Ê'    => 'E'
        , 'ê'    => 'e'
        , 'Ë'    => 'E'
        , 'ë'    => 'e'
        , 'ₑ'    => 'e'
        , 'ƒ'    => 'f'
        , 'ğ'    => 'g'
        , 'Ğ'    => 'G'
        , 'Ì'    => 'I'
        , 'ì'    => 'i'
        , 'Í'    => 'I'
        , 'í'    => 'i'
        , 'Î'    => 'I'
        , 'î'    => 'i'
        , 'Ï'    => 'Ii'
        , 'ï'    => 'ii'
        , 'ī'    => 'i'
        , 'ı'    => 'i'
        , 'I'    => 'I' // turkish, correct?
        , 'Ñ'    => 'N'
        , 'ñ'    => 'n'
        , 'ⁿ'    => 'n'
        , 'Ò'    => 'O'
        , 'ò'    => 'o'
        , 'Ó'    => 'O'
        , 'ó'    => 'o'
        , 'Ô'    => 'O'
        , 'ô'    => 'o'
        , 'Õ'    => 'O'
        , 'õ'    => 'o'
        , 'Ø'    => 'O'
        , 'ø'    => 'o'
        , 'ₒ'    => 'o'
        , 'Ö'    => 'Oe'
        , 'ö'    => 'oe'
        , 'Œ'    => 'Oe'
        , 'œ'    => 'oe'
        , 'ß'    => 'ss'
        , 'Š'    => 'S'
        , 'š'    => 's'
        , 'ş'    => 's'
        , 'Ş'    => 'S'
        , '™'    => 'TM'
        , 'Ù'    => 'U'
        , 'ù'    => 'u'
        , 'Ú'    => 'U'
        , 'ú'    => 'u'
        , 'Û'    => 'U'
        , 'û'    => 'u'
        , 'Ü'    => 'Ue'
        , 'ü'    => 'ue'
        , 'Ý'    => 'Y'
        , 'ý'    => 'y'
        , 'ÿ'    => 'y'
        , 'Ž'    => 'Z'
        , 'ž'    => 'z'
        // misc
        , '¢'    => 'Cent'
        , '€'    => 'Euro'
        , '‰'    => 'promille'
        , '№'    => 'Nr'
        , '$'    => 'Dollar'
        , '℃'    => 'Grad Celsius'
        , '°C' => 'Grad Celsius'
        , '℉'    => 'Grad Fahrenheit'
        , '°F' => 'Grad Fahrenheit'
        // Superscripts
        , '⁰'    => '0'
        , '¹'    => '1'
        , '²'    => '2'
        , '³'    => '3'
        , '⁴'    => '4'
        , '⁵'    => '5'
        , '⁶'    => '6'
        , '⁷'    => '7'
        , '⁸'    => '8'
        , '⁹'    => '9'
        // Subscripts
        , '₀'    => '0'
        , '₁'    => '1'
        , '₂'    => '2'
        , '₃'    => '3'
        , '₄'    => '4'
        , '₅'    => '5'
        , '₆'    => '6'
        , '₇'    => '7'
        , '₈'    => '8'
        , '₉'    => '9'
        // Operators, punctuation
        , '±'    => 'plusminus'
        , '×'    => 'x'
        , '₊'    => 'plus'
        , '₌'    => '='
        , '⁼'    => '='
        , '⁻'    => '-' // sup minus
        , '₋'    => '-' // sub minus
        , '–'    => '-' // ndash
        , '—'    => '-' // mdash
        , '‑'    => '-' // non breaking hyphen
        , '․'    => '.' // one dot leader
        , '‥'    => '..'  // two dot leader
        , '…'    => '...'  // ellipsis
        , '‧'    => '.' // hyphenation point
        , ' '    => '-'   // nobreak space
        , ' '    => '-'   // normal space
    );

    $str = strtr( $str, $utf8 );
    return trim( $str, '-' );
}


?>