<?php

namespace SlimSkeleton\Lib;

trait ArrayHelper
{
    public function getValueByKey(string $key, array $data, string $default = null)
    {
        if(empty($data) || !count($data)) {
            return $default;
        }

        if(strpos($key, ".") !== false) {
            $keys = explode(".", $key);

            foreach($keys as $innerKey) {
                if(!array_key_exists($innerKey, $data)) {
                    return $default;
                }

                $data = $data[$innerKey];
            }

            return $data;
        }

        return array_key_exists($key, $data) ? $data[$key] : $default;
    }
}