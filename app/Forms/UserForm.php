<?php

namespace App\Forms;

use App\Models\Pharmacy;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryContract;
use Saodat\FormBase\Contracts\FormBuilderInterface;
use Spatie\Permission\Models\Role;

class UserForm extends AbstractForm
{
    private const SUBSCRIBER_ROLE_ID = 2;
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
                    'validationRule' => 'required|alpha',
                ]
            );

        $this->formBuilder
            ->add('text', 'patronymic', 'Отчество',
                [
                    'attributes' => ['outlined' => true, "cols" => 4],
                    'validationRule' => 'required|alpha',
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
            ->add('date', 'meta.birthday', 'День рождения',
                ['attributes' => ['min' => '1920-01-01', 'max' => date("Y-m-d")]]
            );
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
        $roles = $roles
            ->filter(function ($role) {
                if (auth()->user()->hasRole(['Editor'])) {
                    return $role->id == self::SUBSCRIBER_ROLE_ID;
                }
                return $role;
            })
            ->map(function ($role) {
                return ['id' => $role->id, 'name' => $role->name];
            })
            ->values()
            ->toArray();

        return $roles;
    }

    public function fill(User $user)
    {
        $user = $user->load(['meta', 'pharmacy', 'roles']);

        foreach ($this->formBuilder->getFields() as $field) {
            $value = null;
            $userMeta = $user->meta->toArray();

            //password can be nullable, because laravel has only hashed password
            if ($field->getName() === 'password') {
                $field->setValidationRule('');
            }

            if ($user->{$field->getName()} && $field->getName() !== 'password') {
                $value = $user->{$field->getName()};
            }

            if ($field->getName() === 'role') {
                $value = $user->roles->first()->id;
            }

            foreach ($userMeta as $meta) {
                if ($meta['name'] && $field->getName() !== "meta.{$meta['name']}") {
                    continue;
                }
                $value = $meta['value'];
            }

            $field->setValue($value);
        }

        return $this;
    }
}
