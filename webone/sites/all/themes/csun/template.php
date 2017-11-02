<?php
/**
 * @file
 * Contains the theme's functions to manipulate Drupal's default markup.
 *
 * Complete documentation for this file is available online.
 * @see http://drupal.org/node/1728096
 */


/**
 * Override or insert variables into the maintenance page template.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("maintenance_page" in this case.)
 */
/* -- Delete this line if you want to use this function
function csun_preprocess_maintenance_page(&$variables, $hook) {
  // When a variable is manipulated or added in preprocess_html or
  // preprocess_page, that same work is probably needed for the maintenance page
  // as well, so we can just re-use those functions to do that work here.
  csun_preprocess_html($variables, $hook);
  csun_preprocess_page($variables, $hook);
}
// */

/**
 * Override or insert variables into the html templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("html" in this case.)
 */
function csun_preprocess_html(&$variables, $hook) {
  $variables['path_to_csun'] = drupal_get_path('theme', 'csun');
}

/**
 * Override or insert variables into the csun_page template.
 */
function csun_preprocess_csun_page(&$variables, $hook) {
 drupal_add_library('custom', 'flexslider');
}

/**
 * Override or insert variables into the node templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("node" in this case.)
 */
function csun_preprocess_node(&$variables, $hook) {
  // $variables['sample_variable'] = t('Lorem ipsum.');

  // Optionally, run node-type-specific preprocess functions, like
  // csun_preprocess_node_page() or csun_preprocess_node_story().
  // $function = __FUNCTION__ . '_' . $variables['node']->type;
  // if (function_exists($function)) {
  //   $function($variables, $hook);
  // }

  $variables['theme_hook_suggestions'][] = 'node__' . $variables['node']->type .
    '__' . $variables['view_mode'];

  $type = $variables['node']->type;
  $view_mode = $variables['view_mode'];

  // we want to add the 'read more' link to the end of the lede field for events
  // and news for the teaser and teaser_featured view modes.
  if (($type == 'event' || $type == 'news') && ($view_mode == 'teaser' || $view_mode == 'teaser_featured') && !empty($variables['content']['field_lede'][0]['#markup'])) {

    // Trim so that no trailing white space breaks the logic below.
    $lede = trim($variables['content']['field_lede'][0]['#markup']);
    // @todo, should this be using entity_uri().
    $link = l(t('Read more'), 'node/' . $variables['node']->nid, array('attributes' => array('class' => 'read-more')));

    // Check if a closing p tag is at the end of this string.
    $pos = strrpos($lede, '</p>');
    if (($pos + 4) == strlen($lede)) {
      // If so, insert the link before the closing p tag.
      $new_lede = substr_replace($lede, ' ' . $link, $pos, 0);
    }
    // Default to concatentating the link to the lede.
    else {
      $new_lede = $lede . ' ' . $link;
    }
    // Set the new_lede for output.
    $variables['content']['field_lede'][0]['#markup'] = $new_lede;

    // Hide the existing links field.
    unset($variables['content']['links']);
  }

  if ($type == 'page' && isset($variables['content']['field_multi_body'])) {
    drupal_add_library('system', 'ui.accordion');
  }
}

/**
 * Override or insert variables into the field templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("field" in this case.)
 */
function csun_preprocess_field(&$variables, $hook) {
  $element = $variables['element'];

  $variables['theme_hook_suggestions'][] = 'field__' . $element['#field_type'];

  // We want to change the link text on links to the news listing pages. These
  // links come from a panels pane in panelizer, and are used on News nodes.
  if ($element['#field_name'] == 'field_news_page_ref') {
    $variables['items'][0]['#markup'] = str_replace('>News<', '>View all current news &gt;&gt;<', $variables['items'][0]['#markup']);
  }
  // We want to change the link text on links to the event listing pages. These
  // links come from a panels pane in panelizer, and are used on Event nodes.
  elseif ($element['#field_name'] == 'field_events_page_ref') {
    $variables['items'][0]['#markup'] = str_replace('>Events<', '>View all upcoming events &gt;&gt;<', $variables['items'][0]['#markup']);
  }
  // Make the wordmark fields use the same template.
  elseif ($element['#field_name'] == 'field_wordmark_text' || $element['#field_name'] == 'field_wordmark_url') {
    $variables['theme_hook_suggestions'][] = 'field__field_wordmarks__field';
  }
}

/**
 * Override or insert variables into the comment templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("comment" in this case.)
 */
/* -- Delete this line if you want to use this function
function csun_preprocess_comment(&$variables, $hook) {
  $variables['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the region templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("region" in this case.)
 */
/* -- Delete this line if you want to use this function
function csun_preprocess_region(&$variables, $hook) {
  // Don't use Zen's region--sidebar.tpl.php template for sidebars.
  //if (strpos($variables['region'], 'sidebar_') === 0) {
  //  $variables['theme_hook_suggestions'] = array_diff($variables['theme_hook_suggestions'], array('region__sidebar'));
  //}
}
// */

/**
 * Override or insert variables into the block templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("block" in this case.)
 */
/* -- Delete this line if you want to use this function
function csun_preprocess_block(&$variables, $hook) {
  // Add a count to all the blocks in the region.
  // $variables['classes_array'][] = 'count-' . $variables['block_id'];

  // By default, Zen will use the block--no-wrapper.tpl.php for the main
  // content. This optional bit of code undoes that:
  //if ($variables['block_html_id'] == 'block-system-main') {
  //  $variables['theme_hook_suggestions'] = array_diff($variables['theme_hook_suggestions'], array('block__no_wrapper'));
  //}
}
// */

/**
 * Implements hook_preprocess_panels_pane().
 */
function csun_preprocess_panels_pane(&$variables) {
  static $node_page = FALSE;

  if ($variables['pane']->type == 'node_content') {
    // If the node pane is displayed, remember that this is a node page.
    $node_page = TRUE;
  }
  elseif ($variables['pane']->type == 'views_panes') {

    // For some pane subtypes, there is a need to link the title of the pane
    // to a page node that is referenced in the group node by a specific field.
    $field_to_pane_subtype_mapping = array(
      'featured_node-panel_pane_news' => 'field_news_page_ref',
      'featured_node-panel_pane_events' => 'field_events_page_ref',
    );

    // Check if the current subtype needs it's title linked by checking if it is
    // in the array.
    if (array_key_exists($variables['pane']->subtype, $field_to_pane_subtype_mapping)) {

      // Make sure that the pane has argument that should be a group nid.
      if (!empty($variables['display']->args[0])) {

        // Load the group node.
        $organic_group_nid = $variables['display']->args[0];
        $organic_group = node_load($organic_group_nid);

        $field_name = $field_to_pane_subtype_mapping[$variables['pane']->subtype];
        // Make sure that the group has a value in the appropriate field.
        if (!empty($organic_group->{$field_name}[LANGUAGE_NONE][0]['target_id'])) {
          $referenced_page_node_id = $organic_group->{$field_name}[LANGUAGE_NONE][0]['target_id'];
          // Link the title.
          $variables['title'] = l($variables['title'], 'node/' . $referenced_page_node_id);
        }
      }
    }
  }

  if ($variables['pane']->type == 'page_content') {
    // If the node_content pane is supressed, we need to manually check for the
    // markup of a node layout.
    if (!$node_page && !empty($variables['content']['system_main']['content']['#markup']) && strpos($variables['content']['system_main']['content']['#markup'], 'layout-csun--columns-')) {
      $node_page = TRUE;
    }

    if ($node_page) {
      // The title is displayed in the csun_node layout, so override the template.
      $variables['theme_hook_suggestions'][] = 'panels_pane__node_page_content';
    }
  }
}

/**
 * Returns HTML for a menu link and submenu.
 *
 * This override removes the newline after the li element.
 */
function csun_menu_link(array $variables) {
  $element = $variables['element'];
  $sub_menu = '';

  // Add custom CSS clases as necessary for mobile or desktop display.
  _csun_custom_links($element);

  if ($element['#below']) {
    $sub_menu = drupal_render($element['#below']);
  }
  $output = l($element['#title'], $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . '</li>';
}

/**
 * Implements theme_menu_link().
 *
 * @param $variables
 *   An associative array containing:
 *   - element: Structured array data for a menu link.
 *
 * @return
 *   A themed HTML string.
 *
 * @ingroup themeable
 */
function csun_menu_link__menu_block__custom_primary_links($variables) {
  $element = $variables['element'];
  $sub_menu = '';

  // Add custom CSS clases as necessary for mobile or desktop display.
  _csun_custom_links($element);

  // We only need to act on the top-level of links in the drop down menu.
  if ($element['#below']) {
    // Keep track of which of 6 drop-downs we are working on.
    $drop_down =& drupal_static(__FUNCTION__, 0);
    $drop_down++;

/* MB BEGIN */
    // Count the number of children menu items.
    $num_items = 0;
    $tmp = 0;
    $break_after = array();
    foreach (array_keys($element['#below']) as $key) {
      if ($key[0] != '#') {
        if ($element['#below'][$key]['#title'] == '[menu_break]') {
          unset($element['#below'][$key]);
          $break_after[$tmp] = 1;
        } else {
          $num_items++;
          $tmp = $key;
        }
      }
    }

    // Decide how many columns to use.
    $num_columns = 4;
    if (count($break_after)) {
      $num_columns = count($break_after) + 1;
      $column_height = $num_items;
    } else {
      if ($num_items < 7) {
        $num_columns = 1;
      } elseif ($num_items < 11) {
        $num_columns = 2;
      } elseif ($num_items < 16 ) {
        $num_columns = 3;
      }
      // Determine the column height.
      $column_height = ceil($num_items / $num_columns);
    }
/* MB END */

    $columns = array();
    for ($i = 0; $i < $num_columns; $i++) {
      $columns[] = array(
        '#prefix' => '<li class="mega-menu__column">',
        '#suffix' => '</li>',
      );
    }

    // Move all the properties to each of the new children.
    foreach ($element['#below'] as $key => &$value) {
      if ($key == '#prefix') {
        foreach (array_keys($columns) as $column) {
          $columns[$column][$key] .= $value;
        }
        unset($element['#below'][$key]);
      }
      elseif ($key == '#suffix') {
        foreach (array_keys($columns) as $column) {
          $columns[$column][$key] = $value . $columns[$column][$key];
        }
        unset($element['#below'][$key]);
      }
      elseif ($key[0] == '#') {
        foreach (array_keys($columns) as $column) {
          $columns[$column][$key] = $value;
        }
        unset($element['#below'][$key]);
      }
    }

    // Split the children into the new columns.
    $column = 0;
    $i = 0;
    foreach ($element['#below'] as $key => &$value) {
      $columns[$column][$key] = $value;
      unset($element['#below'][$key]);

      // Update the classes.
      $old_classes = $columns[$column][$key]['#attributes']['class'];
      $columns[$column][$key]['#attributes']['class'] = array();
      foreach ($old_classes as $index => $class) {
        switch ($class) {
          case 'leaf':
            $columns[$column][$key]['#attributes']['class'][] = 'mega-menu__item';
            break;
          case 'active':
            $columns[$column][$key]['#attributes']['class'][] = 'mega-menu__item--active';
            break;
          // We don't need any other classes.
          case 'active-trail':
          case 'expanded':
          case 'collapsed':
          case 'has-children':
          default:
            break;
        }
      }
      if (!empty($columns[$column][$key]['#localized_options']['attributes']['class'])) {
        switch ($class) {
          case 'active':
            $columns[$column][$key]['#localized_options']['attributes']['class'] = array('mega-menu__link--active');
            break;
        }
      }
      $columns[$column][$key]['#localized_options']['attributes']['class'][] = 'mega-menu__link';

      $i++;
      if ($i == $column_height OR isset($break_after[$key])) {
        $column++;
        $i = 0;
      }
    }

    // Theme the column lists specially.
    for ($i = 0; $i < $num_columns; $i++) {
      array_unshift($columns[$i]['#theme_wrappers'][0], 'menu_tree__menu_block__custom_primary_links_column');
    }

    // Put the columns back into the $element.
    $element['#below'] = $columns;
    $element['#below']['#prefix'] = '<div class="mega-menu__wrapper"><ul class="mega-menu">';
    $element['#below']['#suffix'] = '</ul></div>';

    $sub_menu = drupal_render($element['#below']);

    // Add a class to the list item.
    $element['#attributes']['class'][] = 'mega-menu__trigger';
    // Backwards-compatible class for sub-themes.
    $element['#attributes']['class'][] = 'menu--leaf';
  }
  $link = l($element['#title'], $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $link . $sub_menu . "</li>";
}

/**
 * Implements theme_menu_tree().
 */
function csun_menu_tree__menu_block__custom_primary_links_column($variables) {
  return '<ul class="mega-menu__column-list">' . $variables['tree'] . '</ul>';
}

/**
 * Implements theme_menu_link().
 *
 * @param $variables
 *   An associative array containing:
 *   - element: Structured array data for a menu link.
 *
 * @return
 *   A themed HTML string.
 *
 * @ingroup themeable
 */
function csun_menu_link__menu_block__custom_primary_mobile($variables) {
  $element = $variables['element'];
  $sub_menu = '';

  // Add custom CSS clases as necessary for mobile or desktop display.
  _csun_custom_links($element);

  if ($element['#below']) {
    // Make a copy of the main item as its first child.
    $clone = $element;
    $clone['#below'] = array();
    $clone['#title'] .= t(' Main');
    array_unshift($element['#below'], $clone);

    $sub_menu = drupal_render($element['#below']);
  }
  $link = l($element['#title'], $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $link . $sub_menu . "</li>\n";
}

/**
 * Implements hook_preprocess_fieldable_panels_pane().
 */
function csun_preprocess_fieldable_panels_pane(&$variables, $hook){
  // we want to add the 'read more' link to the end of the body field for
  // 'side block' fieldable panel panes.
  if (!empty($variables['content']['field_body'][0]['#markup']) && ($variables['content']['field_body']['#bundle'] == 'side_block') && !empty($variables['content']['field_link'][0]['#markup'])) {

    // Trim so that no trailing white space breaks the logic below.
    $body = trim($variables['content']['field_body'][0]['#markup']);
    // @todo, should this be using entity_uri().
    $link = $variables['content']['field_link'][0]['#markup'];

    // Check if a closing p tag is at the end of this string.
    $pos = strrpos($body, '</p>');
    if (($pos + 4) == strlen($body)) {
      // If so, insert the link before the closing p tag.
      $new_body = substr_replace($body, ' ' . $link, $pos, 0);
    }
    // Default to concatentating the link to the body.
    else {
      $new_body = $body . ' ' . $link;
    }
    // Set the new_body for output.
    $variables['content']['field_body'][0]['#markup'] = $new_body;

    // Hide the existing link field.
    unset($variables['content']['field_link']);
  }
}

/**
 * Panels' "default sytle" render callback, with panel-separator removed.
 */
function csun_panels_default_style_render_region($vars) {
  return implode('<div class="panel-separator"></div>', $vars['panes']);
}

function csun_preprocess_calendar_datebox(&$vars) {
  $date = $vars['date'];
  $view = $vars['view'];
  $day_path = calendar_granularity_path($view, 'day');

  $og_context = og_context();
  $group_type = $og_context['group_type'];
  $gid = $og_context['gid'];
  $cur_url = token_replace('[current-page:url]');

  $is_year = false;
  $is_month = false;
  if (strpos($cur_url, 'year') !== false) {
    $is_year = true;
  }

  if (strpos($cur_url, 'month') !== false) {
    $m_url = str_replace('month', 'day', $cur_url);
    $fields = explode("/", $m_url);
    $month_url = $fields[0] . '/' . $fields[3] . '/' . $fields[4] . '/' . $fields[5];
    $is_month = true;
  }

  if ($view->name=='calendar_events_og') {
    if ($is_year) {
      $year_url = str_replace('year', 'day', $cur_url);
      $vars['url'] = $year_url . '/' . $date;
    }
    elseif ($is_month) {
      $vars['url'] = $month_url . '/' . $date;
    }
    else {
      $vars['url'] = $cur_url . '?month=' . $date;
    }
  }

  //$vars['link'] = !empty($day_path) ? l($vars['day'], $vars['url']) : $vars['day'];
  $dayname = date('l', strtotime($date));
  $link_options = array('attributes' => array('aria-label' => $dayname));
  $vars['link'] = !empty($day_path) ? l($vars['day'], $vars['url'], $link_options) : $vars['day'];

}

/**
 * Preprocess function for Date pager template.
 * EZ added 2014-02-03 
 */
function csun_preprocess_date_views_pager(&$vars) {
  ctools_add_css('date_views', 'date_views');

  $plugin = $vars['plugin'];
  $input = $vars['input'];
  $view = $plugin->view;

  $vars['nav_title'] = '';
  $vars['next_url'] = '';
  $vars['prev_url'] = '';

  if (empty($view->date_info) || empty($view->date_info->min_date)) {
    return;
  }
  $date_info = $view->date_info;
  // Make sure we have some sort of granularity.
  $granularity = !empty($date_info->granularity) ? $date_info->granularity : 'month';
  $pos = $date_info->date_arg_pos;
  if (!empty($input)) {
    $id = $plugin->options['date_id'];
    if (array_key_exists($id, $input) && !empty($input[$id])) {
      $view->args[$pos] = $input[$id];
    }
  }

  $next_args = $view->args;
  $prev_args = $view->args;
  $min_date = $date_info->min_date;
  $max_date = $date_info->max_date;

  // Set up the pager link format. Setting the block identifier
  // will force pager style links.
  if ((isset($date_info->date_pager_format) && $date_info->date_pager_format != 'clean') || !empty($date_info->mini)) {
    if (empty($date_info->block_identifier)) {
      $date_info->block_identifier = $date_info->pager_id;
    }
  }

  if (empty($date_info->hide_nav)) {
    $prev_date = clone($min_date);
    date_modify($prev_date, '-1 ' . $granularity);
    $next_date = clone($min_date);
    date_modify($next_date, '+1 ' . $granularity);
    $format = array('year' => 'Y', 'month' => 'Y-m', 'day' => 'Y-m-d');
    switch ($granularity) {
      case 'week':
        $next_week = date_week(date_format($next_date, 'Y-m-d'));
        $prev_week = date_week(date_format($prev_date, 'Y-m-d'));
        $next_arg = date_format($next_date, 'Y-\W') . date_pad($next_week);
        $prev_arg = date_format($prev_date, 'Y-\W') . date_pad($prev_week);
        break;
      default:
        $next_arg = date_format($next_date, $format[$granularity]);
        $prev_arg = date_format($prev_date, $format[$granularity]);
    }
    $next_path = str_replace($date_info->date_arg, $next_arg, $date_info->url);
    $prev_path = str_replace($date_info->date_arg, $prev_arg, $date_info->url);
    $next_args[$pos] = $next_arg;
    $prev_args[$pos] = $prev_arg;
    $vars['next_url'] = date_pager_url($view, NULL, $next_arg);
    $vars['prev_url'] = date_pager_url($view, NULL, $prev_arg);
    $vars['next_options'] = $vars['prev_options'] = array();
  }
  else {
    $next_path = '';
    $prev_path = '';
    $vars['next_url'] = '';
    $vars['prev_url'] = '';
    $vars['next_options'] = $vars['prev_options'] = array();
  }

  // Check whether navigation links would point to
  // a date outside the allowed range.
  if (!empty($next_date) && !empty($vars['next_url']) && date_format($next_date, 'Y') > $date_info->limit[1]) {
    $vars['next_url'] = '';
  }
  if (!empty($prev_date) && !empty($vars['prev_url']) && date_format($prev_date, 'Y') < $date_info->limit[0]) {
    $vars['prev_url'] = '';
  }
  $vars['prev_options'] += array('attributes' => array());
  $vars['next_options'] += array('attributes' => array());
  $prev_title = '';
  $next_title = '';

  // Build next/prev link titles.
  switch ($granularity) {
    case 'year':
      $prev_title = t('Navigate to previous year');
      $next_title = t('Navigate to next year');
      break;
    case 'month':
      $prev_title = t('Navigate to previous month');
      $next_title = t('Navigate to next month');
      break;
    case 'week':
      $prev_title = t('Navigate to previous week');
      $next_title = t('Navigate to next week');
      break;
    case 'day':
      $prev_title = t('Navigate to previous day');
      $next_title = t('Navigate to next day');
      break;
  }
  $vars['prev_options']['attributes'] += array('title' => $prev_title);
  $vars['next_options']['attributes'] += array('title' => $next_title);
  
  //Nghia (Web-one): 
  $vars['prev_options']['attributes'] += array('aria-label' => $prev_title);
  $vars['next_options']['attributes'] += array('aria-label' => $next_title);
  // end - Nghia

  // Add nofollow for next/prev links.
  $vars['prev_options']['attributes'] += array('rel' => 'nofollow');
  $vars['next_options']['attributes'] += array('rel' => 'nofollow');

  // Need this so we can use '&laquo;' or images in the links.
  $vars['prev_options'] += array('html' => TRUE);
  $vars['next_options'] += array('html' => TRUE);

  $link = FALSE;
  // Month navigation titles are used as links in the block view.
  if (!empty($date_info->mini) && $granularity == 'month') {
    $link = TRUE;
  }
  $params = array(
    'granularity' => $granularity,
    'view' => $view,
    'link' => $link,
  );
  $nav_title = theme('date_nav_title', $params);
  $vars['nav_title'] = $nav_title;
  $vars['mini'] = !empty($date_info->mini);
}

/* 2013-04-26 :  This puts the year in the mini cal */
function csun_date_nav_title($params) {
  $granularity = $params['granularity'];
  $view = $params['view'];
  $date_info = $view->date_info;
  $link = !empty($params['link']) ? $params['link'] : FALSE;
  $format = !empty($params['format']) ? $params['format'] : NULL;

  switch ($granularity) {
    case 'year':
      $title = $date_info->year;
      $date_arg = $date_info->year;
      break;
    case 'month':
      $format = !empty($format) ? $format : (empty($date_info->mini) ? 'F Y' : 'F Y');  // the second Y puts the year in the mini cal
      $title = date_format_date($date_info->min_date, 'custom', $format);
      $date_arg = $date_info->year .'-'. date_pad($date_info->month);
      break;
    case 'day':
      $format = !empty($format) ? $format : (empty($date_info->mini) ? 'l, F j, Y' : 'D, M j, Y');
      $title = date_format_date($date_info->min_date, 'custom', $format);
      $date_arg = $date_info->year .'-'. date_pad($date_info->month) .'-'. date_pad($date_info->day);
      break;
    case 'week':
      $format = !empty($format) ? $format : (empty($date_info->mini) ? 'F j, Y' : 'F j');
      $title = t('Week of @date', array('@date' => date_format_date($date_info->min_date, 'custom', $format)));
      $date_arg = $date_info->year .'-W'. date_pad($date_info->week);
      break;
  }

  if (!empty($date_info->mini) || $link) {
    // Month navigation titles are used as links in the mini view.
    // EZ added aria label 20131213
    $attributes = array('aria-label' => t('calendar sunday through saturday'), 'title' => t('Calendar Sunday through Saturday'));

//    $attributes = array('title' => t('View full page month'));
    $url = date_pager_url($view, $granularity, $date_arg, TRUE);
    return l($title, $url, array('attributes' => $attributes));
  } else {
    return $title;
  }
}

/**
* Default theme function for all RSS rows.
*/
function csun_preprocess_views_view_row_rss(&$vars) {
  $view = &$vars['view'];
  $options = &$vars['options'];
  $item = &$vars['row'];

  // Use the [id] of the returned results to determine the nid in [results]
  $result = &$vars['view']->result;
  $id = &$vars['id'];
  $node = node_load( $result[$id-1]->nid );

  $vars['title'] = check_plain($item->title);
  $vars['link'] = check_url($item->link);
  $vars['description'] = check_plain($item->description);
  //$vars['description'] = check_plain($node->teaser);
  $vars['node'] = $node;
  $vars['item_elements'] = empty($item->elements) ? '' : format_xml_elements($item->elements);
  if (isset($node->field_lede_image['und'][0]['type'])) {
    if ($node->field_lede_image['und'][0]['type'] == 'image') {
      $vars['media'] = '<media:content xmlns:media="http://search.yahoo.com/mrss/" url="' . file_create_url($node->field_lede_image['und'][0]['uri']) . '" width="300" height="225" medium="image" type="' . $node->field_lede_image['und'][0]['filemime']  . '" />';
    }
  }
}

/**
 * _csun_custom_links
 *
 * CSUN needs to be able to show/hide certain menu items based on device viewing
 * the site, so this function will add appropriate CSS classes given a token
 * in the link title.
 *
 * @param type $element
 *   A menu $element from theme_menu_link
 */
function _csun_custom_links(&$element) {
  if (strpos($element['#title'], '[mobile]') !== FALSE) {
    $element['#attributes']['class'][] = 'mobile-only';
    $element['#title'] = trim(str_replace('[mobile]', '', $element['#title']));
  }
  if (strpos($element['#title'], '[desktop]') !== FALSE) {
    $element['#attributes']['class'][] = 'desktop-only';
    $element['#title'] = trim(str_replace('[desktop]', '', $element['#title']));
  }
  if (strpos($element['#title'], '[menu_break]') !== FALSE) {
    $element['#attributes']['class'][] = 'hidden';
  }
}
