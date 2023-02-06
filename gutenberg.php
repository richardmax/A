<?php

add_action('acf/init', 'my_register_blocks');
function my_register_blocks() {

    // check function exists
    if( function_exists('acf_register_block') ) {

        acf_register_block(array(
            'name'              => 'bio',
            'title'             => __('Bio'),
            'description'       => __('A custom bio block.'),
            'render_template'   => 'blocks/block-bio.php',
            'category'          => 'formatting',
            'icon'              => 'admin-comments',
            'mode'              => 'preview',
            'keywords'          => array( 'bio', 'person', 'employee' ),
        ));

        acf_register_block(array(
            'name'              => 'blog',
            'title'             => __('Blog'),
            'description'       => __('A custom blog block.'),
            'render_template'   => 'blocks/block-blog.php',
            'category'          => 'formatting',
            'icon'              => 'admin-comments',
            'mode'              => 'preview',
            'keywords'          => array( 'blog', 'news', 'posts' ),
        ));

        acf_register_block(array(
            'name'              => 'callout',
            'title'             => __('Callout'),
            'description'       => __('A custom callout block.'),
            'render_template'   => 'blocks/block-callout.php',
            'category'          => 'formatting',
            'icon'              => 'admin-comments',
            'mode'              => 'preview',
            'keywords'          => array( 'callout' ),
        ));

        acf_register_block(array(
            'name'              => 'contacts',
            'title'             => __('Contacts'),
            'description'       => __('A custom contacts block.'),
            'render_template'   => 'blocks/block-contacts.php',
            'category'          => 'formatting',
            'icon'              => 'admin-comments',
            'mode'              => 'preview',
            'keywords'          => array( 'contacts' ),
        ));

        acf_register_block(array(
            'name'              => 'glossary',
            'title'             => __('Glossary'),
            'description'       => __('A custom glossary block.'),
            'render_template'   => 'blocks/block-glossary.php',
            'category'          => 'formatting',
            'icon'              => 'admin-comments',
            'mode'              => 'preview',
            'keywords'          => array( 'glossary' ),
        ));

        acf_register_block(array(
            'name'              => 'form',
            'title'             => __('Form'),
            'description'       => __('A custom form block.'),
            'render_template'   => 'blocks/block-form.php',
            'category'          => 'formatting',
            'icon'              => 'admin-comments',
            'mode'              => 'preview',
            'keywords'          => array( 'form','contact form 7' ),
        ));

        acf_register_block(array(
            'name'              => 'header',
            'title'             => __('Header'),
            'description'       => __('A custom header block.'),
            'render_template'   => 'blocks/block-header.php',
            'category'          => 'formatting',
            'icon'              => 'admin-comments',
            'mode'              => 'preview',
            'keywords'          => array( 'header', 'title' ),
        ));

        acf_register_block(array(
            'name'              => 'hero',
            'title'             => __('Hero'),
            'description'       => __('A custom hero block.'),
            'render_template'   => 'blocks/block-hero.php',
            'category'          => 'formatting',       
            'icon'              => 'admin-comments',
            'mode'              => 'preview',
            'keywords'          => array( 'hero', 'lead' ),
        ));


        acf_register_block(array(
            'name'              => 'journey',
            'title'             => __('Journey'),
            'description'       => __('A custom journey block.'),
            'render_template'   => 'blocks/block-journey.php',
            'category'          => 'formatting',       
            'icon'              => 'admin-comments',
            'mode'              => 'preview',
            'keywords'          => array( 'journey' ),
        ));

        acf_register_block(array(
            'name'              => 'nutshell',
            'title'             => __('Nutshell'),
            'description'       => __('A custom nutshell block.'),
            'render_template'   => 'blocks/block-nutshell.php',
            'category'          => 'formatting',       
            'icon'              => 'admin-comments',
            'mode'              => 'preview',
            'keywords'          => array( 'nutshell' ),
        ));

        acf_register_block(array(
            'name'              => 'popup',
            'title'             => __('Popup'),
            'description'       => __('A custom popup block.'),
            'render_template'   => 'blocks/block-popup.php',
            'category'          => 'formatting',       
            'icon'              => 'admin-comments',
            'mode'              => 'preview',
            'keywords'          => array( 'popup' ),
        ));

        acf_register_block(array(
            'name'              => 'relationships',
            'title'             => __('Relationships'),
            'description'       => __('A custom relationships block.'),
            'render_template'   => 'blocks/block-relationships.php',
            'category'          => 'formatting',       
            'icon'              => 'admin-comments',
            'mode'              => 'preview',
            'keywords'          => array( 'relationship','relationships' ),
        ));

        acf_register_block(array(
            'name'              => 'resources',
            'title'             => __('Resources'),
            'description'       => __('A custom resources block.'),
            'render_template'   => 'blocks/block-resources.php',
            'category'          => 'formatting',       
            'icon'              => 'admin-comments',
            'mode'              => 'preview',
            'keywords'          => array( 'recources' ),
        ));

        acf_register_block(array(
            'name'              => 'tips',
            'title'             => __('Tips'),
            'description'       => __('A custom tips block.'),
            'render_template'   => 'blocks/block-tips.php',
            'category'          => 'formatting',       
            'icon'              => 'admin-comments',
            'mode'              => 'preview',
            'keywords'          => array( 'tips','hints' ),
        ));

        acf_register_block(array(
            'name'              => 'upshot',
            'title'             => __('Upshot'),
            'description'       => __('A custom upshot block.'),
            'render_template'   => 'blocks/block-upshot.php',
            'category'          => 'formatting',       
            'icon'              => 'admin-comments',
            'mode'              => 'preview',
            'keywords'          => array( 'upshot' ),
        ));

        acf_register_block(array(
            'name'              => 'video',
            'title'             => __('Video'),
            'description'       => __('A custom video block.'),
            'render_template'   => 'blocks/block-video.php',
            'category'          => 'formatting',       
            'icon'              => 'admin-comments',
            'mode'              => 'preview',
            'keywords'          => array( 'video' ),
        ));






        
    }
}