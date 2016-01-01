<?php

if(!function_exists('breadcrumbs')) {
    function breadcrumbs($lists) {
        return \App\Repositories\Utilities::breadcrumbs($lists);
    }
}
