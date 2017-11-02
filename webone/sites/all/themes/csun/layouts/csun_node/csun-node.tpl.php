<?php
/**
 * @file
 * Template for a 1 or 2 sidebar layout based on a flexible grid.
 */
?>
<?php if ($content['supplementary']): ?>
<div class="layout-csun--supplementary">
  <?php print $content['supplementary']; ?>
</div>
<?php endif; ?>

<div class="layout-csun--columns layout-csun--columns-<?php print $sidebars; ?>">

  <?php if ($content['sidebar_featured']): ?>
  <div class="layout-csun--sidebar-featured sidebar">
    <h2 class="pane-title pane-title--featured">Featured</h2>
    <?php print $content['sidebar_featured']; ?>
    <?php if ($content['sidebar_left']): ?>
      <div class="panel-separator"></div>
    <?php endif; ?>
  </div>
  <?php endif; ?>

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
