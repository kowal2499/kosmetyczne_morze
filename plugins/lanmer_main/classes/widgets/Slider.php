<?php

namespace Widgets;

class Slider
{
    public function __construct($params)
    {
        $this->params = $params;
    }

    public function render() : string
    {
        if (!$this->params) {
            return '';
        }

        $ret = '';
        $ret .= '<h4>Slider</h4>';
        foreach ((array) $this->params as $param) {
            $ret .= $param['background'] . '<br>';
            $ret .= $param['txtDesc01'] . '<br>';
            $ret .= '<br>' . '##############' . '<br>';
        }

        return $ret;
    }
}