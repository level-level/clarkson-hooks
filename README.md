# Clarkson Hooks

Solution for 'Just in time' WordPress Hooks.

Clarkson-hooks combines the `all` action and composer autoloading to only include the filters you are actually going to use.

# Setup

## 1. Define clarkson-hooks as a dependency.
`composer require level-level/clarkson-hooks`

It will load automatically.

## 2. Point Composer towards a directory to find your `Hooks` namespace.

```
"autoload": {
    "psr-4":{
        "Hooks\\": "app/Hooks"
    }
}
```

## 3. Define a hook

Example minimal init.php (put this in `app/Hooks/init.php` when using path specified in composer above.

```
<?php
namespace Hooks;

use Clarkson\Hooks\iHook;

class init implements iHook {
    public static function register_hooks( $name ){
        add_action('init', function(){
            wp_die('Hello world');
        });
    }
}
```

Note: the `\Clarkson\Hooks\iHook` interface makes sure you correctly define your `Hook` object.

For a real live example, check out the [init hook in Clarkson Theme](https://github.com/level-level/Clarkson-Theme/blob/021fcfe463b52f399d713b5bd867b01c19b4dead/app/Hooks/init.php).

# What happens in the background

1. An `apply_filters` or `do_action` is called from WordPress.
2. Just before the actual hook is triggered, the `do_action('all')` is caught by Clarkson-hooks.
3. Clarkson-hooks checks for the existence of `\Hooks\{hook-tag}` (Composer handles loading any corresponding file).
4. The correspondig class gets the static method `register_hooks` called. The actual `add_filter` or `add_action` is done in this file.
5. WordPress continues as expected.

# Tips

Be sure to use the `--optimize-autoloader` composer flag on production to have the loading process moving smoothly. Otherwise the class_exists function creates a lot of overhead.

All hooks initialize only once.
