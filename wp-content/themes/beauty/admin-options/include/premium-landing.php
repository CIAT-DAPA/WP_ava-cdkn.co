<?php 
$landing = 'http://yithemes.com/themes/wordpress/beauty-clean-minimal-wordpress-theme/';
$live = 'http://demo.yithemes.com/beauty/';
?><style type="text/css">
#landing { width:800px; }
#landing p { text-align:center; background:#fff; margin:0; }</style>

<div id="landing">
    <p>
        <a href="<?php echo $landing; ?>" target="_blank">
            <img src="<?php echo get_template_directory_uri() ?>/admin-options/include/landing/header.jpg" alt="Beauty & Clean - <?php _e( 'Why do you have to upgrade to the premium version?', 'yiw' ) ?>" />
        </a>
    </p>
    
    <p>
        <a href="<?php echo $landing; ?>" target="_blank">
            <img src="<?php echo get_template_directory_uri() ?>/admin-options/include/landing/buy-now.jpg" style="float:left;" alt="Beauty & Clean - <?php _e( 'Why do you have to upgrade to the premium version?', 'yiw' ) ?>" />
        </a>
        <a href="<?php echo $live; ?>" target="_blank">
            <img src="<?php echo get_template_directory_uri() ?>/admin-options/include/landing/live-preview.jpg" style="float:left;" alt="Beauty & Clean - <?php _e( 'Why do you have to upgrade to the premium version?', 'yiw' ) ?>" />
        </a>
    </p>
    
    <p>
        <a href="<?php echo $landing; ?>" target="_blank">
            <img src="<?php echo get_template_directory_uri() ?>/admin-options/include/landing/body.jpg" alt="Beauty & Clean - <?php _e( 'Why do you have to upgrade to the premium version?', 'yiw' ) ?>" />
        </a>
    </p>
</div>