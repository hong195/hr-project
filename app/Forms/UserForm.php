<?php

namespace App\Forms;

use App\Models\Pharmacy;
use App\Models\User;
use Saodat\FormBase\Contracts\FormBuilderInterface;
use Spatie\Permission\Models\Role;

class UserForm extends AbstractForm
{
    /**
     * @var string[]
     */
    private $genderOptions = ["Мужской", "Женский"];

    /**
     * @var array
     */
    protected $defaultFieldsAttributes = ['outlined' => true, "cols" => 6];

    public function __construct(FormBuilderInterface $formBuilder)
    {
        $formBuilder->setDefaultsFieldsAttributes($this->defaultFieldsAttributes);
        parent::__construct($formBuilder);
    }

    protected $fieldsDefinitions = [];

    protected function buildForm()
    {
        $this->formBuilder
            ->add('select', 'pharmacy_id', 'Аптека',
                [
                    'attributes' => ['outlined' => true, "cols" => 12],
                    'validationRule' => 'required',
                    'options' => $this->getPharmacies(),
                ]
            );

        $this->formBuilder
            ->add('text', 'first_name', 'Имя',
                [
                    'attributes' => ['outlined' => true, "cols" => 4],
                    'validationRule' => 'required',
                ]);

        $this->formBuilder
            ->add('text', 'last_name', 'Фамилия',
                [
                    'attributes' => ['outlined' => true, "cols" => 4],
                    'validationRule' => 'required',
                ]
            );

        $this->formBuilder
            ->add('text', 'patronymic', 'Отчество',
                [
                    'attributes' => ['outlined' => true, "cols" => 4],
                    'validationRule' => 'required',
                ]
            );

        $this->formBuilder
            ->add('email', 'email', 'Электронная почта',
                [
                    'validationRule' => 'required|email',
                ]
            );

        $this->formBuilder
            ->add('password', 'password', 'Пароль',
                [
                    'validationRule' => 'required|min:6',
                ]
            );

        $this->formBuilder
            ->add('select', 'role', 'Роль',
                [
                    'options' => $this->getUserRoles(),
                    'validationRule' => 'required',
                ]);

        $this->formBuilder
            ->add('select', 'meta.gender', 'Пол', ['options' => $this->genderOptions]);

        $this->formBuilder
            ->add('date', 'meta.birthday', 'День рождения');
    }

    protected function getPharmacies()
    {
        $data = Pharmacy::all();
        $data = $data->map(function ($item) {
            return ['id' => $item->id, 'name' => $item->name];
        })->toArray();

        return $data;
    }

    protected function getUserRoles()
    {
        $roles = Role::all();
        $roles = $roles->map(function ($role) {
            return ['id' => $role->id, 'name' => $role->name];
        })->toArray();

        return $roles;
    }

    public function fill(User $user)
    {
        $user = $user->load(['meta', 'pharmacy', 'roles']);

        foreach ($this->formBuilder->getFields() as $field) {
            $value = null;
            $meta = $user->meta;

            //Todo make custom fill
            if ($field->getName() === 'role') {
                $value = $user->roles->first()->id;
            } else if ($field->getName() === 'pharmacy_id') {
                $value = $user->pharmacy->id;
            } else if ($field->getName() === 'password') {
                $value = $user->getAuthPassword();
            } else if ($field->getName() === 'meta.gender') {
                $key = array_search('gender', array_column( $meta->toArray(), 'name'));
                $value = $key ? $meta[$key]->value : '';
            } else if ($field->getName() === 'meta.birthday') {
                $key = array_search('birthday', array_column( $meta->toArray(), 'name'));
                $value = $key ? $meta[$key]->value : '';
            } else if ($field->getName() === 'first_name') {
                $value = $user->first_name;
            } else if ($field->getName() === 'last_name') {
                $value = $user->last_name;
            } else if ($field->getName() === 'patronymic') {
                $value = $user->patronymic;
            } else if ($field->getName() === 'email') {
                $value = $user->email;
            }

            $field->setValue($value);
        }

        return $this->formBuilder;
    }
}
