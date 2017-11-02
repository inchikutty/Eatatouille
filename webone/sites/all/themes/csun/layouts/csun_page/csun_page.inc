<?php
// Plugin definition
$plugin = array(
  'title'         => t('CSUN page layout'),
  'icon'          => 'csun-page.png',
  'category'      => t('CSUN'),

  'theme'         => 'csun_page',
  // We're adding this stylesheet from the theme side.
  //'css'         => '../../css/layouts/csun-layout.css',

  //'admin theme' => 'csun_page_admin',
  'admin css'     => '../../css/layouts/csun-layout-admin.css',

  'regions'       => array(
    'content'       => t('Content'),
    'header'        => t('Header'),
    'header_right'  => t('Header right'),
    'navbar'        => t('Navigation header'),
    'supplementary' => t('Supplementary header'),
    'sidebar_left'  => t('Left sidebar'),
    'sidebar_right' => t('Right sidebar'),
    'footer'        => t('Footer'),
  ),
);
