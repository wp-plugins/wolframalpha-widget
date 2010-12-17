<?php
/*
 Plugin Name: Wolfram|Alpha Widget
 Plugin URI: http://developer.wolframalpha.com/widgets
 Description: Embed live, interactive computational knowledge into your WordPress site with the Wolfram|Alpha Widget plugin.
 Author: Wolfram|Alpha
 Author URI: http://developer.wolframalpha.com
 Version: 1.0
*/

function widget_wolframalpha_init() {
  if ( !function_exists('register_sidebar_widget') ){
    return;
  }
}


function widget_wolframalpha() {
  //get global options
  if ($args){
    extract($args);
  }

  //get widget options
  $options = get_option('wolframalpha');
  $id = $options['id'];
  $num = $options['num'];

  echo $before_widget; //. $before_title . $title . $after_title;

  $script = "<script type=\"text/javascript\" id=\"WolframAlphaScript$num\" src=\"http://developer.wolframalpha.com/widgetbuilder/output/widget.jsp?id=".$id."\"></script>";

  echo $script;

  //sidebar width fixer
  echo '<script type="text/javascript">jQuery(function(){jQuery("#WolframAlphaWidget$num").width( jQuery("#widget$num table").eq(0).width()+32 );});</script>';

  echo $after_widget;
}


function widget_wolframalpha_control() {
  $options = get_option('wolframalpha');

  if ( !is_array($options) ){
    //maybe display a default gallery widget?
    //$options['id'] = 'DEFAULT_WIDGET_ID';
  }

  if ( $_POST['widget-control-submit'] ) {
    $options['id']  = strip_tags(stripslashes($_POST['wolframalphaid']));
    $options['num'] = strip_tags(stripslashes($_POST['wolframalphanum']));
    update_option('wolframalpha', $options);
  }

  $id  = htmlspecialchars($options['id'],  ENT_QUOTES);
  $num = htmlspecialchars($options['num'], ENT_QUOTES);

  // This will be embedded into the existing settings form.
  echo '<p style="text-align:right;">';
  echo '<label for="wolframalphaid" style="width: 40px;">' . __('Id:') . '<input style="width: 140px; id="wolframalphaid" name="wolframalphaid" type="text" value="'.$id.'" /></label><br/>';
  echo '<label for="wolframalphanum" style="width: 40px;">'. __('Num:'). '<input style="width: 140px; id="wolframalphanum" name="wolframalphanum" type="text" value="'.$num.'" /></label>';
  echo '</p>';

  echo '<input type="hidden" id="widget-control-submit" name="widget-control-submit" value="1" />';
}


register_sidebar_widget(array('Wolfram Alpha', 'widgets'), 'widget_wolframalpha');
register_widget_control(array('Wolfram Alpha', 'widgets'), 'widget_wolframalpha_control');

add_action('widgets_init', 'widget_wolframalpha_init');

?>