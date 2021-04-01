<?php


namespace App\Forms;


use App\Models\CheckAttribute;

class CheckAttributeForm extends AbstractForm
{
    protected function buildForm()
    {
        $this->formBuilder->add('text', 'label', 'Название',
            ['validationRule' => 'required']);

        $this->formBuilder->add('text', 'name', 'Слаг',
            ['validationRule' => 'required']);


        $this->formBuilder->add('number', 'order', 'Порядок', ['value' => 0]);
    }

    public function fill(CheckAttribute $checkAttribute)
    {
        foreach ($this->formBuilder->getFields() as $field) {
            $fieldName = $field->getName();
            if (!$value = $checkAttribute->{$fieldName}) {
                continue;
            }
            $field->setValue($value);
        }

        return $this;
    }
}
