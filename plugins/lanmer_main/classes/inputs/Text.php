<?php

namespace inputs;

class Text extends Input_General
{
    public function __construct($id, $title, $wrapper, $desc, $attr)
    {
        parent::__construct($id, $title, $wrapper, $desc, $attr);
    }

    public function render($entire = true)
    {
        $size = isset($this->attributes['size']) ? $this->attributes['size'] : '30';
        $this->beforeRender($entire);

        echo '<input type="text" name="'.$this->id.'" id="'.$this->id.'" value="'.$this->value.'" size="' . $size . '" />
                <br /><span class="description">'.$this->desc.'</span>';

        $this->afterRender($entire);
    }
}
