<?php

namespace App\Formatters;


class Formatter
{

     /**
     * Converte atributos publicos e protegidos de um objeto
     * para um array
     *
     * @param $data
     *
     * @return array
     */
    public static function fromObjectToArray($data)
    {
        if (is_array($data)) {
            $result = [];

            foreach ($data as $key => $element) {
                $result[$key] = Formatter::fromObjectToArray($element);
            }

            return $result;
        }

        if (is_object($data)) {

            $result = [];
            $array = (array) $data;

            foreach ($array as $key => $element) {
                $formattedKey = str_replace(["*", "\0"],'', $key);
                $result[$formattedKey] = Formatter::fromObjectToArray($element);
            }

            return $result;
        }

        return $data;
    }
}
