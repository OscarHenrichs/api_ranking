<?php
namespace Api\Tools\SanitizeParameters;


class SanitizeParameters
{

    /**
     * @param array $params
     * @return array 
     */
    public static function sanitizeParameters($params = [])
    {
        if (empty($params)) {
            return [];
        }

        foreach ($params as $key => $value) {
            if (is_array($value)) {
                self::sanitizeParameters($value);
            } else {
                $params[$key] = SanitizeParameters::sanitizeParam($value);
            }
        }


        return $params;
    }

    /**
     * @param dynamic $param
     * @return dynamic
     */
    private static function sanitizeParam($param)
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

