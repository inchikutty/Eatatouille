<?php
/**
 * @file
 * Returns the HTML for a node.
 *
 * Complete documentation for this file is available online.
 * @see http://drupal.org/node/1728164
 */
?>
<article class="node-<?php print $node->nid; ?> <?php print $classes; ?> clearfix"<?php print $attributes; ?>>

  <?php if ($title_prefix || $title_suffix || $display_submitted || $unpublished || !$page && $title): ?>
    <header>
      <?php print render($title_prefix); ?>
      <?php if (!$page && $title): ?>
        <h2<?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h2>
      <?php endif; ?>
      <?php print render($title_suffix); ?>

      <?php if ($display_submitted): ?>
        <p class="submitted">
          <?php print $user_picture; ?>
          <?php print $submitted; ?>
        </p>
      <?php endif; ?>

      <?php if ($unpublished): ?>
        <mark class="unpublished"><?php print t('Unpublished'); ?></mark>
      <?php endif; ?>
    </header>
  <?php endif; ?>

  <?php
    // We hide the comments and links now so that we can render them later.
    hide($content['comments']);
    hide($content['links']);
    hide($content['field_multi_body']);
    hide($content['field_download']);
    print render($content);

    // Only wrap the multi-body if it contains content.
    $tmp1=array('<h3', '</h3'); $tmp2=array('<h2', '</h2');
    $field_multi_body = str_ireplace($tmp1, $tmp2, render($content['field_multi_body']));
    if ($field_multi_body) :
  ?>
    <div id="accordion">
      <?php print $field_multi_body; ?>
    </div>
  <?php endif; ?>

  <?php print render($content['field_download']) ?>

  <?php print render($content['links']); ?>

  <?php print render($content['comments']); ?>

</article>
