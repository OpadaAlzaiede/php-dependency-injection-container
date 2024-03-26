<?php

function basePath($path) {

    return BASE_PATH . $path;
}


function abort($message, $code = 404) {

    http_response_code($code);
    echo $message;
    exit();
}

function dataGet($arr, $key) {

    if (!is_array($arr) || empty($key)) {
        return null;
    }

    $keysArr = explode(".", $key);
    $searchedKey = $keysArr[count($keysArr) - 1];

    $i = 0;

    if(array_key_exists($keysArr[$i], $arr)) {

        $nextArr = $arr[$keysArr[$i]];

        while($i < count($keysArr)) {

            $i++;

            if(!array_key_exists($keysArr[$i], $nextArr)) break;

            if($keysArr[$i] === $searchedKey) return $nextArr[$keysArr[$i]];

            $nextArr = $nextArr[$keysArr[$i]];
        }
    }

    return null;
}
