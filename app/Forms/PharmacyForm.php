<?php
namespace App\Forms;

use Saodat\FormBase;

class PharmacyForm extends FormBase\FormBase
{
    public function buildForm()
    {
        /**
         * addField(type, name, label, options, validationRule, value, placeholder)
         */
        $attributes = ['outlined'=>true, "cols"=>6, 'class'=> 'my-class'];
        return $this
            ->addField('text', 'name', 'Название', $attributes)
            ->addField('text', 'address', 'Адрес', $attributes)
            ->addField('text', 'coordinates', 'Локация', $attributes)
            ->addField('number', 'order', 'Номер', $attributes);
    }
}
