<?php
/**
 * @file field--fences-ul.tpl.php
 * Wrap each field value in the <li> element and all of them in the <ul> element.
 *
 * @see http://developers.whatwg.org/grouping-content.html#the-ul-element
 */
?>
<?php if ($element['#label_display'] == 'inline'): ?>
  <span class="field-label"<?php print $title_attributes; ?>>
    <?php print $label; ?>:
  </span>
<?php elseif ($element['#label_display'] == 'above'): ?>
  <h3 class="field-label"<?php print $title_attributes; ?>>
    <?php print $label; ?>
  </h3>
<?php endif; ?>

<div class="field-wrapper--group-constituency-links">
<ul class="<?php print $classes; ?>"<?php print $attributes; ?>><?php
  foreach ($items as $delta => $item) {
    print '<li' . $item_attributes[$delta] . '>' . render($item) . '</li>';
  }
?></ul>
</div>
