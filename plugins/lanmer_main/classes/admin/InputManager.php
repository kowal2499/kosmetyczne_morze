<?php

namespace Admin;

/**
 * Zarządza inputami użytymi w panelu administracyjnym
 *
 * @author Roman Kowalski
 */
class InputManager
{
    private $fields;
    private $varWrapper = 'options';

    public function __construct($arg_fields)
    {
        if (is_array($arg_fields)) {
            $this->fields = (array) $arg_fields;
        } else {
            $json = file_get_contents($arg_fields);
            if (!$json) {
                $this->fields = [];
            } else {
                $this->fields = json_decode($json, $assoc = true);
                if ($this->fields === null) {
                    $this->fileds = [];
                }
            }
        }
    }

    /*
     * Zwraca tablicę pól
     */
    public function getFields()
    {
        return $this->fields['inputs'] ?? [];
    }

    /**
     * Zwraca obiekty pól
     */
    public function getFieldsAsObjects() : array
    {
        $objects = [];
        foreach ($this->fields['inputs'] as $id => $fieldDesc) {
            $obj = $this->factory($id, $fieldDesc);
            $val = $obj->getValue();
            $obj->setValue($val);
            $objects[] = $obj;
        }
        return $objects;
    }

    /*
     * Zwraca obiekt konkretnego inputa
     *
     * @input array
     * @return object
     */
    private function factory($id, $input)
    {
        // $input = $this->fields['inputs'][$id];
        $item = null;
        $className = '\\inputs\\' . $input['class'];
        switch ($input['class']) {
            
            case 'Repeatable':
                $item = new $className($id, $input['title'], $this->varWrapper, $input['desc']); // generate the Repeatable object
                // add elements to the object
                foreach ($input['elements'] as $elementId => $elementBody) {
                    $repeatableObject = $this->factory($elementId, $elementBody);
                    $item->addElement($repeatableObject);
                }
                break;

            default:
                $item = new $className($id, $input['title'], $this->varWrapper, $input['desc'], $input['attr'] ?? null); // generate general object
                break;
        }
        return $item;
    }

    public function getVarWrapper()
    {
        return $this->varWrapper;
    }

    /**
     * REFACTORING
     */

    public function getIds() {
        return array_keys($this->fields['inputs'] ?? []);
    }

    /**
     * Zwraca obiekt inputa
     */
    public function getInput($id) {
        $params = $this->fields['inputs'][$id];

        if (!$params) {
            return false;
        }

        // jeśli jest już utworzony obiekt to go zwróć
        if (array_key_exists('object', $params)) {
            return $params['object'];
        }

        // utwórz instancję obiektu, zapisz ją i zwróć referencję

        $object = $this->factory($id, $params);
        if ($object) {
            $this->fields['inputs'][$id]['object'] = $object;
        }
        return $object;
    }

    /**
     * Rejestruje łańcuchy dla plugina Polylang
     */
    public function polylangRegister()
    {
        foreach ($this->fields['inputs'] as $id => $params) {
            if (array_key_exists('translate', $params) && $params['translate'] === true) {
                // var_dump($params);

                $input = $this->getInput($id);

                $to_translate = $input->getTransleatable();

                foreach((array)$to_translate as $translate_me) {
                    pll_register_string(
                        'promet',
                        $translate_me,
                        'z ustawień',
                        'true'
                    );
                }
            }
        }
    }

}
