<?php
namespace App\Forms;

use App\Models\Pharmacy;
use Saodat\FormBase\Services\Contracts\FieldManager;
use Spatie\Permission\Models\Role;

class UserForm
{
    /**
     * @var FieldManager
     */
    protected $fieldManager;

    /**
     * PostForm constructor.
     * @param FieldManager $fieldManager
     */
    public function __construct(FieldManager $fieldManager)
    {
        $this->fieldManager = $fieldManager;
    }

    /**
     * @return array
     */
    public function buildForm()
    {
        /**
         * addField(type, name, label, options, validationRule, value, placeholder)
         */
        $options = ["Мужской", "Женский"];
        $attributes = ['outlined'=>true, "cols"=>6, 'class'=> 'my-class'];

        $this->fieldManager
            ->addField('select', 'pharmacy_id', 'Аптека', $this->getPharmacies())
            ->setAttributes($attributes)
            ->setValidationRule('required')->get();

        $this->fieldManager
            ->addField('text', 'first_name', 'Имя')
            ->setAttributes($attributes)
            ->setValidationRule('required')->get();

        $this->fieldManager
            ->addField('text', 'last_name', 'Фамилия')
            ->setAttributes($attributes)
            ->setValidationRule('required')->get();

        $this->fieldManager
            ->addField('text', 'patronymic', 'Отчество')
            ->setAttributes($attributes)
            ->setValidationRule('required')->get();

        $this->fieldManager
            ->addField('email', 'email', 'Электронная почта')
            ->setAttributes($attributes)
            ->setValidationRule('required|email')->get();

        $this->fieldManager
            ->addField('password', 'password', 'Пароль')
            ->setAttributes($attributes)
            ->setValidationRule('required|min:6')->get();

        $this->fieldManager
            ->addField('select', 'role', 'Роль', $this->getUserRoles())
            ->setAttributes($attributes)
            ->setValidationRule('required')->get();

        $this->fieldManager
            ->addField('select', 'meta.gender', 'Пол', $options)
            ->setAttributes($attributes)->get();

        $this->fieldManager->addField('date', 'meta.birthday', 'День рождения')
            ->setAttributes($attributes)->get();

        return  $this->fieldManager->all();
//            ->addField('text', 'last_name', 'Фамилия', $attributes)
//            ->addField('text', 'patronymic', 'Отчество', $attributes)
//            ->addField('email', 'email', 'Электронная почта', $attributes)
//            ->addField('password', 'password', 'Пароль', $attributes)
//            ->addField('select', 'role', 'Роль', $this->getUserRoles(), $attributes)
//            ->addField('select', 'meta.gender', 'Пол', $options, $attributes)
//            ->addField('date', 'meta.birthday', 'День рождения', $attributes);
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
