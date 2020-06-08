<?php

namespace App\View;

class View
{

    public static function render($components, $data = '')
    {
        ob_start();
        require "../app/src/view/layout/LayoutStart.php";
        if (is_array($components)) {
            foreach ($components as $component) {
                require "../app/src/view/components/" . $component . ".php";
            }
        } else {
            require "../app/src/view/components/" . $components . ".php";
        }
        require "../app/src/view/layout/LayoutEnd.php";
        $markup = ob_get_contents();
        ob_end_clean();
        echo $markup;
    }
}
