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

  <?php
    // We hide the comments and links now so that we can render them later.
    hide($content['comments']);
    hide($content['links']);
    //print render($content);
  ?>
  <div class="person-bio-image">
    <?php print render($content['field_image']);?>
  </div>
  <div class="person-bio-profile">
    <?php 
      print render($content['field_person_position']);
      print render($content['field_person_email']);
      print render($content['field_person_phone']);
      print render($content['field_person_office']);
      print render($content['field_person_website']);
    ?>
  </div>
  <div class="person-bio-body">
    <?php
      print render($content['field_person_biography']);
    ?>
  </div>
    

  <?php print render($content['links']); ?>

  <?php print render($content['comments']); ?>

</article>
