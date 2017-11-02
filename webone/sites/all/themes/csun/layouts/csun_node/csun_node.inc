<?php
// Plugin definition
$plugin = array(
  'title'         => t('CSUN node layout'),
  'icon'          => 'csun-node.png',
  'category'      => t('CSUN'),

  'theme'         => 'csun_node',
  // We're adding this stylesheet from the theme side.
  //'css'         => '../../css/layouts/csun-layout.css',

  'admin theme' => 'csun_node_admin',
  'admin css'     => '../../css/layouts/csun-layout-admin.css',

  'regions'       => array(
    'content'           => t('Content'),
    'supplementary'     => t('Supplementary header'),
    'sidebar_featured'  => t('Featured sidebar'),
    'sidebar_left'      => t('Left sidebar'),
    'sidebar_right'     => t('Right sidebar'),
  ),
);
