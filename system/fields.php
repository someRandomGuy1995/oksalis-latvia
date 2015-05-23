<?php

class fields
{
    public function fieldToHTML($array)
    {
        $output = array();
        foreach ($array as $arr)
        {
            $type = $arr['type'];
            if (file_exists('../system/tpl/'.$type.'.tpl')) {
                $html = file_get_contents('../system/tpl/' . $type . '.tpl');


                foreach ($arr as $key => $value) {
                    $html = str_replace('{' . $key . '}', $value, $html);

                }

                $output[] = $html;
            }
        }
        return $output;
    }
}

