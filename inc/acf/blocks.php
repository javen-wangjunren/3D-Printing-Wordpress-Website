<?php
/**
 * ACF Blocks 注册文件
 * 负责注册所有自定义的ACF Block
 */

// 确保函数在ACF可用时才执行
if ( function_exists( 'acf_register_block_type' ) ) 
{
    // 注册Hero Banner Block
    function _3dp_register_hero_block() 
    {
        acf_register_block_type( array(
            'name'              => 'hero-banner',
            'title'             => __( 'Hero Banner', '3d-printing' ),
            'description'       => __( '3D打印服务的Hero Banner模块', '3d-printing' ),
            'render_template'   => 'blocks/global/hero-banner/render.php',
            'category'          => 'layout',
            'icon'              => 'cover-image',
            'keywords'          => array( 'hero', 'banner', '3d printing', 'header' ),
            'mode'              => 'preview',
            'align'             => 'full',
            'supports'          => array(
                'align'     => array( 'full' ),
                'mode'      => true,
                'jsx'       => true,
            ),
        ) );
    }
    add_action( 'acf/init', '_3dp_register_hero_block' );
    
    // 注册Trusted By Block
    function _3dp_register_trusted_by_block() 
    {
        acf_register_block_type( array(
            'name'              => 'trusted-by',
            'title'             => __( 'Trusted By', '3d-printing' ),
            'description'       => __( '展示合作伙伴或客户Logo的区块', '3d-printing' ),
            'render_template'   => 'blocks/global/trusted-by/render.php',
            'category'          => 'layout',
            'icon'              => 'groups',
            'keywords'          => array( 'trusted by', 'clients', 'partners', 'logos' ),
            'mode'              => 'preview',
            'align'             => 'full',
            'supports'          => array(
                'align'     => array( 'full' ),
                'mode'      => true,
                'jsx'       => true,
            ),
        ) );
    }
    add_action( 'acf/init', '_3dp_register_trusted_by_block' );
    
    // 注册Feature Grid Block
    function _3dp_register_feature_grid_block() 
    {
        acf_register_block_type( array(
            'name'              => 'feature-grid',
            'title'             => __( 'Feature Grid', '3d-printing' ),
            'description'       => __( '展示3D打印工艺的功能网格模块', '3d-printing' ),
            'render_template'   => 'blocks/global/feature-grid/render.php',
            'category'          => 'layout',
            'icon'              => 'grid-view',
            'keywords'          => array( 'feature', 'grid', '3d printing', 'processes' ),
            'mode'              => 'preview',
            'align'             => 'full',
            'supports'          => array(
                'align'     => array( 'full' ),
                'mode'      => true,
                'jsx'       => true,
            ),
        ) );
    }
    add_action( 'acf/init', '_3dp_register_feature_grid_block' );
}
