<?php
/**
 * @file field--fences-figure.tpl.php
 * Wrap each field value in the <figure> element.
 *
 * @see http://developers.whatwg.org/grouping-content.html#the-figure-element
 */

echo '<div class="slide-wrapper flexslider-off"><ul class="slides">' . "\n";
foreach ($items as $delta => $item) {
  print '<li class="slide"><figure class="' . $classes . '"' . $attributes . '>';

  $key = key($item['entity']['field_collection_item']);
  print render($item['entity']['field_collection_item'][$key]['field_image']);
  print '<figcaption>' . render($item) . '</figcaption>';

  print '</figure></li>';
}
echo "</ul></div>\n";
