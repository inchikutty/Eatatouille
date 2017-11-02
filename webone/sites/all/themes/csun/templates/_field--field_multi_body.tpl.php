<?php
/**
 * @file field--fences-details.tpl.php
 * Wrap each field value in the <details> element.
 *
 * @see http://developers.whatwg.org/interactive-elements.html#the-details-element
 */
?>
<div class="accordion">
  <?php if ($element['#label_display'] == 'inline'): ?>
    <span class="field-label"<?php print $title_attributes; ?>>
      <?php print $label; ?>:
    </span>
  <?php elseif ($element['#label_display'] == 'above'): ?>
    <h3 class="field-label"<?php print $title_attributes; ?>>
      <?php print $label; ?>
    </h3>
  <?php endif; ?>

  <?php foreach ($items as $delta => $item): ?>
      <?php print render($item); ?>
  <?php endforeach; ?>
</div>