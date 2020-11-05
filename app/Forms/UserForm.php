<?php
namespace App\Forms;

use Saodat\FormBase;

class UserForm extends FormBase\FormBase
{
    public function buildForm()
    {
        /**
         * addField(type, name, label, options, validationRule, value, placeholder)
         */
        $options = [1 => 'a', 2 => 'b', 3 => 'c'];
        $attributes = ['outlined'=>true, "cols"=>6, 'class'=> 'my-class'];
        return $this
            ->addField('text', 'first_name', 'Имя', $attributes)
            ->addField('text', 'last_name', 'Фамиля', $attributes)
            ->addField('email', 'email', 'Почта', $attributes)
            ->addField('select', 'name', 'select-label', $options, $attributes);
    }
}
