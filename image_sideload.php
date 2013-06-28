<?php 
				function wp_tempnam($filename = '', $dir = '') {
				        if ( empty($dir) )
				                $dir = get_temp_dir();
				        $filename = basename($filename);
				        if ( empty($filename) )
				                $filename = time();
				
				        $filename = preg_replace('|\..*$|', '.tmp', $filename);
				        $filename = $dir . wp_unique_filename($dir, $filename);
				        touch($filename);
				        return $filename;
				}

				function wp_handle_sideload( &$file, $overrides = false ) {
				        // The default error handler.
				        if (! function_exists( 'wp_handle_upload_error' ) ) {
				                function wp_handle_upload_error( &$file, $message ) {
				                        return array( 'error'=>$message );
				                }
				        }


				        // You may define your own function and pass the name in $overrides['upload_error_handler']
				        $upload_error_handler = 'wp_handle_upload_error';

				        // You may define your own function and pass the name in $overrides['unique_filename_callback']
				        $unique_filename_callback = null;

				        // $_POST['action'] must be set and its value must equal $overrides['action'] or this:
				        $action = 'wp_handle_sideload';

				        // Courtesy of php.net, the strings that describe the error indicated in $_FILES[{form field}]['error'].
				        $upload_error_strings = array( false,
				                __( "The uploaded file exceeds the <code>upload_max_filesize</code> directive in <code>php.ini</code>." ),
				                __( "The uploaded file exceeds the <em>MAX_FILE_SIZE</em> directive that was specified in the HTML form." ),
				                __( "The uploaded file was only partially uploaded." ),
				                __( "No file was uploaded." ),
				                '',
				                __( "Missing a temporary folder." ),
				                __( "Failed to write file to disk." ),
				                __( "File upload stopped by extension." ));

				        // All tests are on by default. Most can be turned off by $overrides[{test_name}] = false;
				        $test_form = true;
				        $test_size = true;

				        // If you override this, you must provide $ext and $type!!!!
				        $test_type = true;
				        $mimes = false;


				        // Install user overrides. Did we mention that this voids your warranty?
				        if ( is_array( $overrides ) )
				                extract( $overrides, EXTR_OVERWRITE );

				        // A correct form post will pass this test.
				        if ( $test_form && (!isset( $_POST['action'] ) || ($_POST['action'] != $action ) ) )
				                return $upload_error_handler( $file, __( 'Invalid form submission.' ));

				        // A successful upload will pass this test. It makes no sense to override this one.
				        if ( ! empty( $file['error'] ) )
				                return $upload_error_handler( $file, $upload_error_strings[$file['error']] );

				        // A non-empty file will pass this test.
				        if ( $test_size && !(filesize($file['tmp_name']) > 0 ) )
				                return $upload_error_handler( $file, __( 'File is empty. Please upload something more substantial. This error could also be caused by uploads being disabled in your php.ini.' ));

				        // A properly uploaded file will pass this test. There should be no reason to override this one.
				        if (! @ is_file( $file['tmp_name'] ) )
				                return $upload_error_handler( $file, __( 'Specified file does not exist.' ));

				        // A correct MIME type will pass this test. Override $mimes or use the upload_mimes filter.
				        if ( $test_type ) {
				                $wp_filetype = wp_check_filetype_and_ext( $file['tmp_name'], $file['name'], $mimes );

				                extract( $wp_filetype );

				                // Check to see if wp_check_filetype_and_ext() determined the filename was incorrect
				                if ( $proper_filename )
				                        $file['name'] = $proper_filename;

				                if ( ( !$type || !$ext ) && !current_user_can( 'unfiltered_upload' ) )
				                        return $upload_error_handler( $file, __( 'Sorry, this file type is not permitted for security reasons.' ));

				                if ( !$ext )
				                        $ext = ltrim(strrchr($file['name'], '.'), '.');

				                if ( !$type )
				                        $type = $file['type'];
				        }

				        // A writable uploads dir will pass this test. Again, there's no point overriding this one.
				        if ( ! ( ( $uploads = wp_upload_dir() ) && false === $uploads['error'] ) )
				                return $upload_error_handler( $file, $uploads['error'] );

				        $filename = wp_unique_filename( $uploads['path'], $file['name'], $unique_filename_callback );

				        // Strip the query strings.
				        $filename = str_replace('?','-', $filename);
				        $filename = str_replace('&','-', $filename);

				        // Move the file to the uploads dir
				        $new_file = $uploads['path'] . "/$filename";
				        if ( false === @ rename( $file['tmp_name'], $new_file ) ) {
				                return $upload_error_handler( $file, sprintf( __('The uploaded file could not be moved to %s.' ), $uploads['path'] ) );
				        }

				        // Set correct file permissions
				        $stat = stat( dirname( $new_file ));
				        $perms = $stat['mode'] & 0000666;
				        @ chmod( $new_file, $perms );

				        // Compute the URL
				        $url = $uploads['url'] . "/$filename";

				        $return = apply_filters( 'wp_handle_upload', array( 'file' => $new_file, 'url' => $url, 'type' => $type ), 'sideload' );

				        return $return;
				}				
				
				function download_url( $url, $timeout = 300 ) {
				        //WARNING: The file is not automatically deleted, The script must unlink() the file.
				        if ( ! $url )
				                return new WP_Error('http_no_url', __('Invalid URL Provided.'));
				
				        $tmpfname = wp_tempnam($url);
				        if ( ! $tmpfname )
				                return new WP_Error('http_no_file', __('Could not create Temporary file.'));
				
				        $response = wp_remote_get( $url, array( 'timeout' => $timeout, 'stream' => true, 'filename' => $tmpfname ) );
				
				        if ( is_wp_error( $response ) ) {
				                unlink( $tmpfname );
				                return $response;
				        }
				
				        if ( 200 != wp_remote_retrieve_response_code( $response ) ){
				                unlink( $tmpfname );
				                return new WP_Error( 'http_404', trim( wp_remote_retrieve_response_message( $response ) ) );
				        }
				
				        return $tmpfname;
				}

				function wp_exif_frac2dec($str) {
				        @list( $n, $d ) = explode( '/', $str );
				        if ( !empty($d) )
				                return $n / $d;
				        return $str;
				}				

				function wp_exif_date2ts($str) {
				        @list( $date, $time ) = explode( ' ', trim($str) );
				        @list( $y, $m, $d ) = explode( ':', $date );
				
				        return strtotime( "{$y}-{$m}-{$d} {$time}" );
				}				

				function wp_read_image_metadata( $file ) {
				        if ( ! file_exists( $file ) )
				                return false;

				        list( , , $sourceImageType ) = getimagesize( $file );

				        // exif contains a bunch of data we'll probably never need formatted in ways
				        // that are difficult to use. We'll normalize it and just extract the fields
				        // that are likely to be useful. Fractions and numbers are converted to
				        // floats, dates to unix timestamps, and everything else to strings.
				        $meta = array(
				                'aperture' => 0,
				                'credit' => '',
				                'camera' => '',
				                'caption' => '',
				                'created_timestamp' => 0,
				                'copyright' => '',
				                'focal_length' => 0,
				                'iso' => 0,
				                'shutter_speed' => 0,
				                'title' => '',
				        );

				        // read iptc first, since it might contain data not available in exif such
				        // as caption, description etc
				        if ( is_callable( 'iptcparse' ) ) {
				                getimagesize( $file, $info );

				                if ( ! empty( $info['APP13'] ) ) {
				                        $iptc = iptcparse( $info['APP13'] );

				                        // headline, "A brief synopsis of the caption."
				                        if ( ! empty( $iptc['2#105'][0] ) )
				                                $meta['title'] = utf8_encode( trim( $iptc['2#105'][0] ) );
				                        // title, "Many use the Title field to store the filename of the image, though the field may be used in many ways."
				                        elseif ( ! empty( $iptc['2#005'][0] ) )
				                                $meta['title'] = utf8_encode( trim( $iptc['2#005'][0] ) );

				                        if ( ! empty( $iptc['2#120'][0] ) ) { // description / legacy caption
				                                $caption = utf8_encode( trim( $iptc['2#120'][0] ) );
				                                if ( empty( $meta['title'] ) ) {
				                                        // Assume the title is stored in 2:120 if it's short.
				                                        if ( strlen( $caption ) < 80 )
				                                                $meta['title'] = $caption;
				                                        else
				                                                $meta['caption'] = $caption;
				                                } elseif ( $caption != $meta['title'] ) {
				                                        $meta['caption'] = $caption;
				                                }
				                        }

				                        if ( ! empty( $iptc['2#110'][0] ) ) // credit
				                                $meta['credit'] = utf8_encode(trim($iptc['2#110'][0]));
				                        elseif ( ! empty( $iptc['2#080'][0] ) ) // creator / legacy byline
				                                $meta['credit'] = utf8_encode(trim($iptc['2#080'][0]));

				                        if ( ! empty( $iptc['2#055'][0] ) and ! empty( $iptc['2#060'][0] ) ) // created date and time
				                                $meta['created_timestamp'] = strtotime( $iptc['2#055'][0] . ' ' . $iptc['2#060'][0] );

				                        if ( ! empty( $iptc['2#116'][0] ) ) // copyright
				                                $meta['copyright'] = utf8_encode( trim( $iptc['2#116'][0] ) );
				                 }
				        }

				        // fetch additional info from exif if available
				        if ( is_callable( 'exif_read_data' ) && in_array( $sourceImageType, apply_filters( 'wp_read_image_metadata_types', array( IMAGETYPE_JPEG, IMAGETYPE_TIFF_II, IMAGETYPE_TIFF_MM ) ) ) ) {
				                $exif = @exif_read_data( $file );

				                if ( !empty( $exif['Title'] ) )
				                        $meta['title'] = utf8_encode( trim( $exif['Title'] ) );

				                if ( ! empty( $exif['ImageDescription'] ) ) {
				                        if ( empty( $meta['title'] ) && strlen( $exif['ImageDescription'] ) < 80 ) {
				                                // Assume the title is stored in ImageDescription
				                                $meta['title'] = utf8_encode( trim( $exif['ImageDescription'] ) );
				                                if ( ! empty( $exif['COMPUTED']['UserComment'] ) && trim( $exif['COMPUTED']['UserComment'] ) != $meta['title'] )
				                                        $meta['caption'] = utf8_encode( trim( $exif['COMPUTED']['UserComment'] ) );
				                        } elseif ( trim( $exif['ImageDescription'] ) != $meta['title'] ) {
				                                $meta['caption'] = utf8_encode( trim( $exif['ImageDescription'] ) );
				                        }
				                } elseif ( ! empty( $exif['Comments'] ) && trim( $exif['Comments'] ) != $meta['title'] ) {
				                        $meta['caption'] = utf8_encode( trim( $exif['Comments'] ) );
				                }

				                if ( ! empty( $exif['Artist'] ) )
				                        $meta['credit'] = utf8_encode( trim( $exif['Artist'] ) );
				                elseif ( ! empty($exif['Author'] ) )
				                        $meta['credit'] = utf8_encode( trim( $exif['Author'] ) );

				                if ( ! empty( $exif['Copyright'] ) )
				                        $meta['copyright'] = utf8_encode( trim( $exif['Copyright'] ) );
				                if ( ! empty($exif['FNumber'] ) )
				                        $meta['aperture'] = round( wp_exif_frac2dec( $exif['FNumber'] ), 2 );
				                if ( ! empty($exif['Model'] ) )
				                        $meta['camera'] = utf8_encode( trim( $exif['Model'] ) );
				                if ( ! empty($exif['DateTimeDigitized'] ) )
				                        $meta['created_timestamp'] = wp_exif_date2ts($exif['DateTimeDigitized'] );
				                if ( ! empty($exif['FocalLength'] ) )
				                        $meta['focal_length'] = wp_exif_frac2dec( $exif['FocalLength'] );
				                if ( ! empty($exif['ISOSpeedRatings'] ) ) {
				                        $meta['iso'] = is_array( $exif['ISOSpeedRatings'] ) ? reset( $exif['ISOSpeedRatings'] ) : $exif['ISOSpeedRatings'];
				                        $meta['iso'] = utf8_encode( trim( $meta['iso'] ) );
				                }
				                if ( ! empty($exif['ExposureTime'] ) )
				                        $meta['shutter_speed'] = wp_exif_frac2dec( $exif['ExposureTime'] );
				        }

				        return apply_filters( 'wp_read_image_metadata', $meta, $file, $sourceImageType );
				}				

				function media_handle_sideload($file_array, $post_id, $desc = null, $post_data = array()) {
				        $overrides = array('test_form'=>false);
				
				        $file = wp_handle_sideload($file_array, $overrides);
				        if ( isset($file['error']) )
				                return new WP_Error( 'upload_error', $file['error'] );
				
				        $url = $file['url'];
				        $type = $file['type'];
				        $file = $file['file'];
				        $title = preg_replace('/\.[^.]+$/', '', basename($file));
				        $content = '';

				
				        // use image exif/iptc data for title and caption defaults if possible
				        if ( $image_meta = wp_read_image_metadata($file) ) {
				                if ( trim( $image_meta['title'] ) && ! is_numeric( sanitize_title( $image_meta['title'] ) ) )
				                        $title = $image_meta['title'];
				                if ( trim( $image_meta['caption'] ) )
				                        $content = $image_meta['caption'];
				        }

				
				        if ( isset( $desc ) )
				                $title = $desc;
				
				        // Construct the attachment array
				        $attachment = array_merge( array(
				                'post_mime_type' => $type,
				                'guid' => $url,
				                'post_parent' => $post_id,
				                'post_title' => $title,
				                'post_content' => $content,
				        ), $post_data );				        
				
				        // This should never be set as it would then overwrite an existing attachment.
				        if ( isset( $attachment['ID'] ) )
				                unset( $attachment['ID'] );
				
				        // Save the attachment metadata
				        $id = wp_insert_attachment($attachment, $file, $post_id);
				        if ( !is_wp_error($id) )
				                wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $file ) );
				
				        return $id;
				}				

				function wp_generate_attachment_metadata( $attachment_id, $file ) {
				        $attachment = get_post( $attachment_id );

				        $metadata = array();
				        if ( preg_match('!^image/!', get_post_mime_type( $attachment )) && file_is_displayable_image($file) ) {
				                $imagesize = getimagesize( $file );
				                $metadata['width'] = $imagesize[0];
				                $metadata['height'] = $imagesize[1];
				                list($uwidth, $uheight) = wp_constrain_dimensions($metadata['width'], $metadata['height'], 128, 96);
				                $metadata['hwstring_small'] = "height='$uheight' width='$uwidth'";

				                // Make the file path relative to the upload dir
				                $metadata['file'] = _wp_relative_upload_path($file);

				                // make thumbnails and other intermediate sizes
				                global $_wp_additional_image_sizes;

				                foreach ( get_intermediate_image_sizes() as $s ) {
				                        $sizes[$s] = array( 'width' => '', 'height' => '', 'crop' => false );
				                        if ( isset( $_wp_additional_image_sizes[$s]['width'] ) )
				                                $sizes[$s]['width'] = intval( $_wp_additional_image_sizes[$s]['width'] ); // For theme-added sizes
				                        else
				                                $sizes[$s]['width'] = get_option( "{$s}_size_w" ); // For default sizes set in options
				                        if ( isset( $_wp_additional_image_sizes[$s]['height'] ) )
				                                $sizes[$s]['height'] = intval( $_wp_additional_image_sizes[$s]['height'] ); // For theme-added sizes
				                        else
				                                $sizes[$s]['height'] = get_option( "{$s}_size_h" ); // For default sizes set in options
				                        if ( isset( $_wp_additional_image_sizes[$s]['crop'] ) )
				                                $sizes[$s]['crop'] = intval( $_wp_additional_image_sizes[$s]['crop'] ); // For theme-added sizes
				                        else
				                                $sizes[$s]['crop'] = get_option( "{$s}_crop" ); // For default sizes set in options
				                }

				                $sizes = apply_filters( 'intermediate_image_sizes_advanced', $sizes );

				                foreach ($sizes as $size => $size_data ) {
				                        $resized = image_make_intermediate_size( $file, $size_data['width'], $size_data['height'], $size_data['crop'] );
				                        if ( $resized )
				                                $metadata['sizes'][$size] = $resized;
				                }

				                // fetch additional metadata from exif/iptc
				                $image_meta = wp_read_image_metadata( $file );
				                if ( $image_meta )
				                        $metadata['image_meta'] = $image_meta;

				        }

				        return apply_filters( 'wp_generate_attachment_metadata', $metadata, $attachment_id );
				}

				function file_is_displayable_image($path) {
				        $info = @getimagesize($path);
				        if ( empty($info) )
				                $result = false;
				        elseif ( !in_array($info[2], array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG)) )     // only gif, jpeg and png images can reliably be displayed
				                $result = false;
				        else
				                $result = true;

				        return apply_filters('file_is_displayable_image', $result, $path);
				}

				function media_sideload_image($file, $post_id, $desc = null) {
				        if ( ! empty($file) ) {
				                // Download file to temp location
				                $tmp = download_url( $file );

				                // Set variables for storage
				                // fix file filename for query strings
				                preg_match('/[^\?]+\.(jpg|JPG|jpe|JPE|jpeg|JPEG|gif|GIF|png|PNG)/', $file, $matches);
				                $file_array['name'] = basename($matches[0]);
				                $file_array['tmp_name'] = $tmp;

				                // If error storing temporarily, unlink
				                if ( is_wp_error( $tmp ) ) {
				                        @unlink($file_array['tmp_name']);
				                        $file_array['tmp_name'] = '';
				                }

				                // do the validation and storage stuff
				                $id = media_handle_sideload( $file_array, $post_id, $desc );
				                // If error storing permanently, unlink
				                if ( is_wp_error($id) ) {
				                        @unlink($file_array['tmp_name']);
				                        return $id;
				                }

				                $src = wp_get_attachment_url( $id );
				        }

				        // Finally check to make sure the file has been saved, then return the html
				        if ( ! empty($src) ) {
				                $alt = isset($desc) ? esc_attr($desc) : '';
				                $html = "<img src='$src' alt='$alt' />";
				                return $html;
				        }
				}