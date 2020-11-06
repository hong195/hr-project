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

//        'pharmacy_id' => ['exists:pharmacies,id'],
//        'first_name' => ['required', 'alpha'],
//        'last_name' => ['required', 'alpha'],
//        'patronymic' => ['required', 'alpha'],
//        'email' => ['required', 'email', 'unique:users,email'],
//        'password' => ['required', 'min:6', 'alpha_dash'],
//        'role' => ['required', 'exists:roles,id'],
//        'meta.gender' => ['nullable'],
//        'meta.birthday' => ['date', 'nullable'],

        return $this
            ->addField('select', 'pharmacy_id', 'Аптека', $options, $attributes)
            ->addField('text', 'first_name', 'Имя', $attributes)
            ->addField('text', 'last_name', 'Фамилия', $attributes)
            ->addField('text', 'patronymic', 'Отчество', $attributes)
            ->addField('email', 'email', 'Электронная почта', $attributes)
            ->addField('password', 'password', 'Пароль', $attributes)
            ->addField('select', 'role', 'Роль', $options, $attributes)
            ->addField('select', 'gender', 'Пол', $options, $attributes)
            ->addField('date', 'birthday', 'День рождения', $options, $attributes);
    }
}
