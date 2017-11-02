<?php
/**
 * @file field--fences-no-wrapper.tpl.php
 * Render each field value with no wrapper element.
 */

foreach ($items as $delta => $item) {
  print render($item);
}
