<?php
/**
 * @file
 * Template for a 1 or 2 sidebar layout based on a flexible grid.
 */
?>
<div class="layout-csun"<?php if (!empty($css_id)) : print ' id="' . $css_id . '"'; endif; ?>>

<?php if ($content['supplementary']): ?>
<div class="layout-csun--supplementary">
  <?php print $content['supplementary']; ?>
</div>
<?php endif; ?>

<div class="layout-csun--columns-both">

  <div class="layout-csun--sidebar-featured sidebar">
    <?php print $content['sidebar_featured']; ?>
  </div>

  <div id="content" class="layout-csun--content-both">
    <?php print $content['content']; ?>
  </div>

  <div class="layout-csun--sidebar-left sidebar">
    <?php print $content['sidebar_left']; ?>
  </div>

  <?php if ($content['sidebar_right']): ?>
  <div class="layout-csun--sidebar-right sidebar">
    <?php print $content['sidebar_right']; ?>
  </div>
  <?php endif; ?>

</div>

</div>
