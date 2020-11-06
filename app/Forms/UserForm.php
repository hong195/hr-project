<?php
namespace App\Forms;

use App\Http\Resources\PharmacyResource;
use App\Http\Resources\RoleResource;
use App\Models\Pharmacy;
use Saodat\FormBase;
use Spatie\Permission\Models\Role;

class UserForm extends FormBase\FormBase
{
    public function buildForm()
    {
        /**
         * addField(type, name, label, options, validationRule, value, placeholder)
         */
        $options = ["Мужской", "Женский"];
        $attributes = ['outlined'=>true, "cols"=>6, 'class'=> 'my-class'];

        return $this
            ->addField('select', 'pharmacy_id', 'Аптека', $this->getPharmacies(), $attributes)
            ->addField('text', 'first_name', 'Имя', $attributes)
            ->addField('text', 'last_name', 'Фамилия', $attributes)
            ->addField('text', 'patronymic', 'Отчество', $attributes)
            ->addField('email', 'email', 'Электронная почта', $attributes)
            ->addField('password', 'password', 'Пароль', $attributes)
            ->addField('select', 'role', 'Роль', $this->getUserRoles(), $attributes)
            ->addField('select', 'meta.gender', 'Пол', $options, $attributes)
            ->addField('date', 'meta.birthday', 'День рождения', $options, $attributes);
    }

    public function getPharmacies()
    {
        $data = Pharmacy::all();
        $data = $data->map(function ($item) {
            return ['id' => $item->id, 'name' => $item->name];
        })->toArray();
        return $data;
    }

    public function getUserRoles()
    {
        $roles = Role::all();
        $roles = $roles->map(function ($role) {
            return ['id' => $role->id, 'name' => $role->name];
        })->toArray();
       return $roles;
    }

}
