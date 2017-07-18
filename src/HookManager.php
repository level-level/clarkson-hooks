<?php
namespace Clarkson\Hooks;

class HookManager{
  /**
   * Contains timing info for the first instance a hook was called.
   */
  public static $timings = array();

  /**
   * Starttime of profile.
   */
  public static $starttime = null;

  public function __construct(){
    self::$starttime = microtime(true);
    $this->debug = ( defined( 'WP_DEBUG' ) ? WP_DEBUG : false );
    if(!$this->debug){
      $this->classmap = array_keys(require __DIR__ . '/../../../composer/autoload_classmap.php');
    }
  }

  public function loadHook($name){
    $hook = 'Hooks\\'.str_replace('/', '\\',$name);
    if(!isset(self::$timings[$name])){
      self::$timings[$name] = microtime(true);
      if(!$this->debug && !in_array($hook, $this->classmap)){
        return;
      }
      if(class_exists($hook)){
        $hook::register_hooks($name);
      }
    }
  }

  public static function get_timings(){
    $timings = array();
    foreach(self::$timings as $name => $timing){
      $timings[] = array('name'=>$name, 'delta'=>($timing - self::$starttime));
    }
    usort($timings, function($a,$b){
      if($a['delta'] == $b['delta']){
        return 0;
      }
      if($a['delta'] > $b['delta']){
        return 1;
      }
      return -1;
    });
    echo "<table>";
    $last = 0;
    foreach($timings as $timing){
      echo "<tr>";
      echo "<td>{$timing['name']}</td>";
      $display_delta = number_format($timing['delta'], 4);
      echo "<td>{$display_delta} seconds</td>";
      $diff = number_format(($timing['delta'] - $last) * 1000, 0);
      $last = $timing['delta'];
      echo "<td>{$diff} ms</td>";
      echo "</tr>";
    }
    echo "</table>";

  }
}
