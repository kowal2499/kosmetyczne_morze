<?php

namespace inputs;

class Number extends Input_General
{
    public function __construct($id, $title, $wrapper, $desc, $attr)
    {
        parent::__construct($id, $title, $wrapper, $desc, $attr);
    }

    public function render($entire = true)
    {
        $size = isset($this->attributes['size']) ? $this->attributes['size'] : '30';
        $min = isset($this->attributes['min']) ? $this->attributes['min'] : null;
        $max = isset($this->attributes['max']) ? $this->attributes['max'] : null;

        $this->beforeRender($entire);

        echo '<input type="number"'.
            ' name="'.$this->id.'"'.
            ' id="'.$this->id.'"'.
            ' value="'.$this->value.'"'.
            ' size="'.$size.'"' .
            (is_null($min) ? '' : ' min="'.intval($min).'"').
            (is_null($max) ? '' : ' max="'.intval($max).'"').
            '><br /><span class="description">'.$this->desc.'</span>';

        $this->afterRender($entire);
    }
}
