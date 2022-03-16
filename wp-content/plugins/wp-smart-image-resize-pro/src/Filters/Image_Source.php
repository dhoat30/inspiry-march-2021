<?php

namespace WP_Smart_Image_Resize\Filters;

use Exception;

use WP_Smart_Image_Resize\Utilities\Request;
use WP_Smart_Image_Resize\Utilities\Env;
use WP_Smart_Image_Resize\Image_Filters\CreateWebP_Filter;
use WP_Smart_Image_Resize\Image_Manager;
use WP_Smart_Image_Resize\Image_Meta;

class Image_Source extends Base_Filter
{
    public function listen()
    {
        
        add_action('wp_head', [$this, 'serveWebP'], PHP_INT_MAX);
        
    }

    

    function serveWebP()
    {
        if(! apply_filters('wp_sir_serve_webp_images', true ) ){
            return;
        }
        add_filter( 'wp_get_attachment_image_src', [ $this, 'replaceSrcWebpExtension' ], (PHP_INT_MAX-1), 4 );
        add_filter( 'wp_calculate_image_srcset_meta', [ $this, 'replaceWebPExtensionSrcsetMetadata' ], (PHP_INT_MAX-1), 4 );
        add_filter( 'wp_get_attachment_url', [ $this, 'replaceWebPAttachmentUrlEextension' ], (PHP_INT_MAX-1), 2 );
    }

    function replaceWebPAttachmentUrlEextension( $url, $imageId ){

        if(! apply_filters('wp_sir_attachment_url_webp', false) ){
            return $url;
        }
        try{
            if( wp_attachment_is_image( $imageId ) ){
                list( $url ) = $this->replaceSrcWebpExtension([ $url ], $imageId, 'full', false);
                if( ! empty( $url ) ){
                    return $url;
                }
            }

        }catch(Exception $e){}

        return $url;
    }


    /**
     * Match src.
     *
     * @param array $metadata
     * @param array $imageArr
     * @param string $imageSrc
     * @param int $attachmentId
     *
     * @return array
     */
    public function replaceWebPExtensionSrcsetMetadata( $metadata, $imageArr, $imageSrc, $attachmentId )
    {
        try {

            if ( ! $this->shouldServeWebP() ) {
                return $metadata;
            }

            $imageMeta = new Image_Meta( $attachmentId, $metadata );

            if( ! $imageMeta->getMetaItem('_processed_at') ){
                return $metadata;
            }

            foreach ( $imageMeta->getSizeNames() as $name ) {
                $imageMeta->setSizeExtension( $name, 'webp' );
            }

            return $imageMeta->toArray();

        } catch ( Exception $e ) {
            return $metadata;
        }
    }

    /**
     * Use WebP if enabled and supported by the browser.
     * Fallback to standard format.
     *
     * @param array|false $image
     * @param int $attachmentId
     * @param string|array $size
     * @param bool $icon
     *
     * @return array|false
     */
    public function replaceSrcWebpExtension( $image, $attachmentId, $size, $icon )
    {

        if ( $icon || ! is_array( $image ) || ! $this->shouldServeWebP() ) {
            return $image;
        }

        try {

            $imageMeta = new Image_Meta( $attachmentId, wp_get_attachment_metadata( $attachmentId ) );

            if( ! $imageMeta->getMetaItem('_processed_at') ){
                return $image;
            }
            // Get the nearest size name to the given array.
            if ( is_array( $size ) ) {

                $intermediate = image_get_intermediate_size( $attachmentId, $size );

                $size = $imageMeta->findSizeByFile( $intermediate );

                if ( empty( $size ) ) {
                    return $image;
                }
            }

            if ( ! $imageMeta->hasSize( $size ) ) {
                return $image;
            }

            $webpPath = $imageMeta->getSizeFullPath( $size, 'webp' );

            if ( ! file_exists( $webpPath ) && is_readable( $imageMeta->getOriginalFullPath() ) ) {
                ( new Image_Manager( [
                    $imageMeta->getMetaItem( 'width' ),                     $imageMeta->getMetaItem( 'height' )
                ] ) )->make( $imageMeta->getSizeFullPath( $size ) )
                    ->filter( new CreateWebP_Filter( $webpPath ) )
                    ->destroy();
            }

            if ( ! file_exists( $webpPath ) ) {
                return $image;
            }

            $sizeData = $imageMeta->getSizeData( $size, true );

            $imageUrl = $imageMeta->getSizeUrl( $size, 'webp' );

            return [
                $imageUrl,
                $sizeData[ 'width' ],
                $sizeData[ 'height' ],
            ];

        } catch ( Exception $e ) {
        }

        return $image;
    }

    /**
     * Determine whether to load WebP images.
     *
     * @return bool
     */
    public function shouldServeWebP()
    {
        if ( ! wp_sir_get_settings()[ 'enable_webp' ] ) {
            return false;
        }

        if ( ! Env::supports_webp() ) {
            return false;
        }

        if ( ! Request::is_front_end() ) {
            return false;
        }

        return Env::browser_supposts_webp();
    }

    

}
