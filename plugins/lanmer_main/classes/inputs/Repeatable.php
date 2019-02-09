<?php

namespace inputs;

class Repeatable extends Input_General
{
    public function __construct($id, $title, $wrapper, $desc)
    {
        parent::__construct($id, $title, $wrapper, $desc);

        $this->templates = [];
    }

    public function addElement($element)
    {
        // pozbywamy się przedrostka z nazwy i id elementu
        $originalId = $element->getWpId();

        $newId = $this->id . '[%index%]' . '[' . $originalId . ']';
        $element->setId($newId);

        // dodajemy element do wzorców
        $this->templates[] = $element;
    }

    public function render($entire = true)
    {
        $this->beforeRender($entire);

        // wygeneruj szablon wiersza (będzie z niego korzystał JS)
        ob_start();
        if (!empty($this->templates)) {
            echo '<tr>';
        }
        foreach ($this->templates as $element) {
            echo '<td>';
            echo '<label for="'.$element->id.'"><strong>'.$element->title.'</strong></label><br><br>';
            $element->render(false);
            echo '</td>';
        }
        if (!empty($this->templates)) {
            // config row
            echo '<td class="row-config">';
            echo '<input type="button" class="button deleteRow" value="Usuń element">';
            echo '<input type="button" class="button upRow" value="Do góry">';
            echo '<input type="button" class="button downRow" value="W dół">';
            echo '</td>';
            echo '</tr>';
        }
        $output = ob_get_clean();

        echo '<div class="rptContainer">';
        echo '<input type="hidden" disabled="disabled" class="rowTemplate" value="'.htmlspecialchars($output).'">';
        echo '<input type="button" class="button addRow" value="Dodaj element">';
        
        echo '<table class="form-table" data-inner-id="' . $this->getWpId() . '">';
        if ($this->value) {
            foreach ($this->value as $rowId => $row) {
                echo '<tr>';
                foreach ($this->templates as $element) {
                    $element->setId($this->id . '[' . $rowId . '][' . $element->wpId . ']');
                    $element->setValue($row[$element->wpId]);
                    echo '<td>';
                    echo '<label for="'.$element->id.'"><strong>'.$element->title.'</strong></label><br><br>';
                    $element->render(false);
                    echo '</td>';
                }
                echo '<td class="row-config">';
                echo '<input type="button" class="button deleteRow" value="Usuń element">';
                echo '<input type="button" class="button upRow" value="Do góry">';
                echo '<input type="button" class="button downRow" value="W dół">';
                echo '</td>';
                echo '</tr>';
            }
        }

        echo '</table>';
        echo '</div>';
        echo '<!-- test -->';

        $this->afterRender($entire);
    }

    public function getTransleatable()
    {
        return array_map(function($record) {
            return $record['txtDesc01'] ?? null;
        }, get_option($this->wpId));
        // var_dump(get_option($this->wpId));
        // die();
    }
}
