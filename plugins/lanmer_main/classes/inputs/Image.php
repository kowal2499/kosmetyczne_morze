<?php

namespace inputs;

/**
 * Klasa do pobierania obrazów z Biblioteki Mediów.
 * Powiązana z img-uploader.js
 */
class Image extends Input_General
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
        echo '<div class="img-upload">';

        $noimage = true;
        $imagesrc = $noimagesrc = plugin_dir_url(__DIR__) . '../assets/imgs/no-image.jpg';

        // pobierz url obrazka na podstawie id jeśli istnieje
        if (!empty($this->value)) {
            if (is_array(wp_get_attachment_image_src($this->value))) {
                $imagesrc = wp_get_attachment_image_src($this->value)[0];
                $noimage = false;
            }
        }
        // zachowujemy link do no-image by potem js mógł łatwo go użyć
        echo '<img src="' . $imagesrc . '" class="img-preview" data-noimagesrc="'. $noimagesrc .'">';
        echo '<div class="img-buttons">';
        echo '<input type="hidden" class="img-data" name="' . $this->id . '" id="' . $this->id . '" value="' . $this->value . '">';
        echo '<input type="button" class="button uploaderLauncher" value="Wybierz obraz">';
        
        $delImageStyle = 'display: none';
        if (!$noimage) {
            $delImageStyle = 'display: inline-block';
        }
        echo '<input type="button" class="button deleteImage" value="Usuń obraz" style="' . $delImageStyle . '">';
        echo '</div><!-- img-buttons -->';
        echo '</div><!-- img-upload -->';
        echo '<div class="description">'.$this->desc.'</div>';

        $this->afterRender($entire);
    }
}
