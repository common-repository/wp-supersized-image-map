<?php
//  Add Columns to Portfolio Edit Screen
add_filter("manage_edit-portfolio_columns", "portfolio_edit_columns");
add_action("manage_posts_custom_column",  "portfolio_columns_display", 10, 2);
add_theme_support( 'post-thumbnails', array( 'portfolio' ) );
function portfolio_edit_columns($portfolio_columns){
    $portfolio_columns = array(
        "cb" => "<input type=\"\&quot;checkbox\&quot;\" />",
        "title" => _x('Title', 'column name'),
        "thumbnail" => __('Thumbnail'),
        "portfolio-tags" => __('Tags'),
        "author" => __('Author'),
        "comments" => __('Comments'),
        "date" => __('Date'),
    );
    $portfolio_columns['comments'] = '</pre>
<div class="vers"><img src="' . esc_url( admin_url( 'images/comment-grey-bubble.png' ) ) . '" alt="Comments" /></div>
<pre>
';
    return $portfolio_columns;
}
function portfolio_columns_display($portfolio_columns, $post_id){
    switch ($portfolio_columns)
    {
        // Code from: http://wpengineer.com/display-post-thumbnail-post-page-overview
        case "thumbnail":
            $width = (int) 35;
            $height = (int) 35;
                $thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );
                // image from gallery
                $attachments = get_children( array('post_parent' => $post_id, 'post_type' => 'attachment', 'post_mime_type' => 'image') );
                if ($thumbnail_id)
                    $thumb = wp_get_attachment_image( $thumbnail_id, array($width, $height), true );
                elseif ($attachments) {
                    foreach ( $attachments as $attachment_id => $attachment ) {
                        $thumb = wp_get_attachment_image( $attachment_id, array($width, $height), true );
                    }
                }
                    if ( isset($thumb) && $thumb ) {
                        echo $thumb;
                    } else {
                        echo __('None');
                    }
            break;
        case "portfolio-tags":
            if ($tag_list = get_the_term_list( $post->ID, 'portfolio-tags', '', ', ', '' ) ) {
                echo $tag_list;
            } else {
                    echo __('None');
                }
            break;
    }
}
?>