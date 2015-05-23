<?php


class page
{
    public $fields;

    public function setFields($object)
    {
        $mass = array();
        foreach ($object as $choto)
        {
            $mass[$choto->key] = $choto->value;
        }

        $text = (count($mass)) ? $mass['hello'] : '';

        $this->fields[] = array(
            'id' => 'text',
            'type' => 'textarea',
            'value' => $text
        );

    }

    public function getFields()
    {
        return $this->fields;
    }
}