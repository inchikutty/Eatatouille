<?php
/**
 * @file panels-pane--node-page-content.tpl.php
 * Main panel pane template
 */

// Panels adds an entire wrapper div just for contextual links (but only when
// the user has permissions. So we conditionaly remove contextual links if they
// are present.
if (!empty($content['system_main']['contextual_links'])) {
  // Remove the contextual links.
  unset($content['system_main']['contextual_links']);
  // Remove the class for contextual links.
  if (($key = array_search('contextual-links-region', $content['system_main']['#attributes']['class'])) !== FALSE) {
    unset($content['system_main']['#attributes']['class'][$key]);
  }
  // Remove the #theme_wrappers for Panel's "container" wrapper.
  if (($key = array_search('container', $content['system_main']['#theme_wrappers'])) !== FALSE) {
    unset($content['system_main']['#theme_wrappers'][$key]);
  }
  $content['system_main'] = $content['system_main']['content'];
}

print render($content);
