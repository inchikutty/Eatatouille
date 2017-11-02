<?php
/**
 * @file field--fences-h2.tpl.php
 * Wrap each field value in the <h2> element.
 *
 * @see http://developers.whatwg.org/sections.html#the-h1,-h2,-h3,-h4,-h5,-and-h6-elements
 */

$wordmarks = array();
foreach ($items as $delta => $item) {
  $wordmark = $item['entity']['field_collection_item'][key($item['entity']['field_collection_item'])];

  // Grab the wordmark text.
  $text = trim($wordmark['field_wordmark_text'][0]['#markup']);

  if ($text) {
    // Determine the wordmark url.
    if (!empty($wordmark['field_wordmark_url'][0]['#markup'])) {
      $url = $wordmark['field_wordmark_url'][0]['#markup'];
      // If this is a Drupal path, convert the url.
      if (strpos($url, 'http') !== 0 && strpos($url, '/') !== 0) {
        $url = url($url);
      }
    }
    else {
      // If the url isn't specified, use the group node's URL.
      $url = url('node/' . $element['#object']->nid);
    }

    // Render the wordmark link.
    $wordmarks[] = '<a href="' . $url . '" class="wordmark"><span class="wordmark--offset">' . $text . '</span></a>';
  }
}

?>

<?php if (!empty($wordmarks[0])) : ?>
  <h2 class="wordmark-secondary<?php if (!empty($wordmarks[1])) { print ' two-wordmarks'; } ?>"<?php print $attributes; ?>><?php print $wordmarks[0]; ?></h2>
<?php endif; ?>

<?php if (!empty($wordmarks[1])) : ?>
  <h3 class="wordmark-tertiary"<?php print $attributes; ?>><?php print $wordmarks[1]; ?></h3>
<?php endif; ?>
