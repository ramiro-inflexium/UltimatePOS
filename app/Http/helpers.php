<?php

/**
 * boots pos.
 */
function pos_boot($ul, $pt, $lc, $em, $un, $type = 1, $pid = null)
{

}

if (! function_exists('humanFilesize')) {
    function humanFilesize($size, $precision = 2)
    {
        $units = ['B','kB','MB','GB','TB','PB','EB','ZB','YB'];
        $step = 1024;
        $i = 0;

        while (($size / $step) > 0.9) {
            $size = $size / $step;
            $i++;
        }
        
        return round($size, $precision).$units[$i];
    }
}

/**
 * Checks if the uploaded document is an image
 */
if (! function_exists('isFileImage')) {
    function isFileImage($filename)
    {
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $array = ['png', 'PNG', 'jpg', 'JPG', 'jpeg', 'JPEG', 'gif', 'GIF'];
        $output = in_array($ext, $array) ? true : false;

        return $output;
    }
}

function isAppInstalled()
{
    $envPath = base_path('.env');
    return file_exists($envPath);
}

/**
 * Checks if pusher has credential or not
 *
 * and return boolean
 */
function isPusherEnabled()
{
    $is_pusher_enabled = false;

    if (!empty(config('broadcasting.connections.pusher.key')) && !empty(config('broadcasting.connections.pusher.secret')) && !empty(config('broadcasting.connections.pusher.app_id')) && !empty(config('broadcasting.connections.pusher.options.cluster')) && (config('broadcasting.connections.pusher.driver') == 'pusher')) {
        $is_pusher_enabled = true;
    }

    return $is_pusher_enabled;
}
