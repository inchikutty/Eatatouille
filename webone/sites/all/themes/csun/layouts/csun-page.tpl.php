<?php
/**
 * @file
 * Template for a 1 or 2 sidebar layout based on a flexible grid.
 */
?>
<div class="layout-csun"<?php if (!empty($css_id)) : print ' id="' . $css_id . '"'; endif; ?>>

  <?php if ($content['header']): ?>
  <div class="layout-csun--header">
    <?php print $content['header']; ?>
  </div>
  <?php endif; ?>

  <div class="nav-dropdown">
    <a href="#" class="nav-dropdown__label" title="Menu">&#9776;</a>
  </div>

  <?php if ($content['header_right']): ?>
  <div class="layout-csun--header-right nav-dropdown__container">
    <p class="skip-link">
      <a href="#main-content">Skip to Content</a>
    </p>
    <?php

     if ($_SERVER['REQUEST_URI'] == '/') {
       $regex='/ menu-mlid-1195">/';
       $new='"><a href="javascript:void(0)" onclick="openPortal();" title="" class="menu--link">Skip to Portal</a></li><li class="menu--leaf leaf menu-mlid-1195">';
       $content['header_right'] = preg_replace($regex, $new, $content['header_right']);
/*
       $regex='/ menu-mlid-5141">/';
       $new='"><a href="http://www.csun.edu/atoz" title="" class="menu--link">A to Z</a></li><li class="menu--leaf leaf menu-mlid-5141">';
       $content['header_right'] = preg_replace($regex, $new, $content['header_right']);
*/
     }
     print $content['header_right'];
    ?>
  </div>
  <div class="nav-dropdown__container nav-dropdown__links">
    <ul class="nav-dropdown__constituency-links">
      <li class="menu--expanded"><a href="#" class="menu--link">Other Options</a>
      </li>
    </ul>
  </div>
  <?php endif; ?>

</div>

  <?php if ($content['navbar']): ?>
  <div class="layout-csun--navbar">
    <?php print $content['navbar']; ?>
  </div>
  <?php endif; ?>


<div class="layout-csun">

  <?php if ($content['supplementary']): ?>
  <div class="layout-csun--supplementary">
    <?php print $content['supplementary']; ?>
  </div>
  <?php endif; ?>

  <?php
    // If we're on a node panelizer layout, it has its own wrapping elements.
    // @see custom_preprocess_csun_page()
    if ($panelizer_layout):
      print $content['content'];
    else:
      // Otherwise, print out wrappers for left, content and right columns.
  ?>

    <div class="layout-csun--columns layout-csun--columns-<?php print $sidebars; ?>">

      <div id="content" class="layout-csun--content layout-csun--content-<?php print $sidebars; ?>">
        <a id="main-content"></a>
        <?php print $content['content']; ?>
      </div>

      <?php if ($content['sidebar_left']): ?>
      <div class="layout-csun--sidebar-left sidebar">
        <?php print $content['sidebar_left']; ?>
      </div>
      <?php endif; ?>

      <?php if ($content['sidebar_right']): ?>
      <div class="layout-csun--sidebar-right sidebar">
        <?php print $content['sidebar_right']; ?>
      </div>
      <?php endif; ?>

    </div>

  <?php endif; ?>

  <?php if ($content['footer']): ?>
  <div class="layout-csun--footer">
    <?php print $content['footer']; ?>
  </div>
  <?php endif; ?>
</div>
