<?php
/**
 * ACF Field Group: Thank You Page (提交成功页)
 * ==========================================================================
 * 文件存放路径: inc/acf/pages/page-thank-you.php
 * 
 * 视觉契约声明 (Define):
 * - thank_you_title (text): 成功状态主标题
 * - thank_you_desc (textarea): 确认文案描述
 * - thank_you_cta_group (group): 引导按钮组
 *   - primary_button (link): 主操作按钮 (Return Home)
 *   - secondary_button (link): 次操作按钮 (Explore Materials)
 * - thank_you_support_group (group): 底部支持信息
 *   - support_label (text): 支持区域小标题
 *   - support_email (email): 支持邮箱
 *   - support_hours (text): 服务时间
 * ==========================================================================
 */

if ( function_exists( 'acf_add_local_field_group' ) ) :

    acf_add_local_field_group( array(
        'key'                   => 'group_page_thank_you',
        'title'                 => 'Thank You Page Settings',
        'fields'                => array(
            // I. 核心文案 Tab
            array(
                'key'   => 'field_thank_you_tab_content',
                'label' => 'Content Settings',
                'type'  => 'tab',
            ),
            array(
                'key'           => 'field_thank_you_title',
                'label'         => 'Success Title',
                'name'          => 'thank_you_title',
                'type'          => 'text',
                'default_value' => 'Submission Successful',
                'required'      => 1,
            ),
            array(
                'key'           => 'field_thank_you_desc',
                'label'         => 'Success Description',
                'name'          => 'thank_you_desc',
                'type'          => 'textarea',
                'rows'          => 3,
                'default_value' => 'Thank you for reaching out to us. Your inquiry has been received and logged into our system. One of our technical experts will review your requirements and get back to you within 24 HOURS (business days).',
                'instructions'  => 'Use simple HTML for highlighting, e.g., <span class="font-mono font-bold text-[#0047AB]">24 HOURS</span>',
            ),

            // II. 引导操作 Tab
            array(
                'key'   => 'field_thank_you_tab_cta',
                'label' => 'CTA Actions',
                'type'  => 'tab',
            ),
            array(
                'key'        => 'field_thank_you_cta_primary',
                'label'      => 'Primary Button',
                'name'       => 'thank_you_cta_primary',
                'type'       => 'link',
                'wrapper'    => array( 'width' => '50' ),
            ),
            array(
                'key'        => 'field_thank_you_cta_secondary',
                'label'      => 'Secondary Button',
                'name'       => 'thank_you_cta_secondary',
                'type'       => 'link',
                'wrapper'    => array( 'width' => '50' ),
            ),

            // III. 支持信息 Tab
            array(
                'key'   => 'field_thank_you_tab_support',
                'label' => 'Support Info',
                'type'  => 'tab',
            ),
            array(
                'key'           => 'field_thank_you_support_label',
                'label'         => 'Support Label',
                'name'          => 'thank_you_support_label',
                'type'          => 'text',
                'default_value' => 'Need Immediate Assistance?',
            ),
            array(
                'key'           => 'field_thank_you_support_email',
                'label'         => 'Support Email',
                'name'          => 'thank_you_support_email',
                'type'          => 'email',
                'default_value' => 'support@example.com',
                'wrapper'       => array( 'width' => '50' ),
            ),
            array(
                'key'           => 'field_thank_you_support_hours',
                'label'         => 'Service Hours',
                'name'          => 'thank_you_support_hours',
                'type'          => 'text',
                'default_value' => 'Mon - Fri: 9:00 - 18:00',
                'wrapper'       => array( 'width' => '50' ),
            ),
        ),
        'location'              => array(
            array(
                array(
                    'param'    => 'page_template',
                    'operator' => '==',
                    'value'    => 'templates/page-thank-you.php',
                ),
            ),
        ),
        'menu_order'            => 0,
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen'        => array( 'the_content' ),
        'active'                => true,
    ) );

endif;
