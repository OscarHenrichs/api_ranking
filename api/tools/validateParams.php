<?php
namespace Api\Tools\ValidateParameters;
class ValidateParameters
{

    /**
     * @param array $params
     * @return array 
     */
    public static function sanitizeParams($params = [])
    {
        if (empty($params)) {
            return [];
        }

        foreach ($params as $key => $value) {
            if (is_array($value)) {
                self::sanitizeParams($value);
            } else {
                $params[$key] = htmlspecialchars(strip_tags(trim($value)));

            }
        }


        return $params;
    }

    /**
     * @param dynamic $param
     * @return dynamic
     */
    public static function sanitizeParam($param)
    {

        if (empty($param)) {
            return;
        }

        $param = htmlspecialchars($param);
        if (preg_match('/(SELECT|INSERT|UPDATE|DELETE|DROP|CREATE|ALTER|TRUNCATE)/i', $param)) {
            return;
        }
        if (preg_match('/[^a-zA-Z0-9_.@#,\s]/', $param)) {
            return;
        }


        return $param;
    }
}

