<?php
namespace Clarkson\Hooks;

class HookManager{
  public function loadHook($name){
    $hook = '\\Hooks\\'.str_replace('/', '\\',$name);
    if(class_exists($hook)){
      $hook::register_hooks($name);
    }
  }
}