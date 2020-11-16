<?php


namespace App\Forms;


use App\Models\Check;
use App\Models\User;
use App\Repositories\Contracts\CheckAttributeRepositoryContract;
use Saodat\FormBase\Contracts\FormBuilderInterface;

class CheckForm extends AbstractForm
{
    private $checkAttributes;

    protected $defaultFieldsAttributes = ['outlined' => true];


    public function __construct(FormBuilderInterface $formBuilder,
                                CheckAttributeRepositoryContract $checkAttributeRepository)
    {
        $formBuilder->setDefaultsFieldsAttributes($this->defaultFieldsAttributes);
        $this->checkAttributes = $checkAttributeRepository->all();
        parent::__construct($formBuilder);
    }

    protected function buildForm()
    {
        $this->formBuilder->add('text', 'name', 'Наименование', [
            'validationRule' => 'required'
        ]);

        $this->formBuilder
            ->add('select', 'user_id', 'Сотрудник',
                [
                    'options' => $this->getUsers(),
                    'validationRule' => 'required',
                ]);

        $this->formBuilder->add('date', 'created_at', 'Дата проверки',[
            'validationRule' => 'required',
            'attributes' => ['min' => '2020-01-01', 'max'=> date("Y-m-d", strtotime("-1 days"))]
        ]);

        $this->checkAttributes->each(function($attribute) {
            if ($attribute->type === 'radio') {
                $this->formBuilder->add($attribute->type, "meta.$attribute->name", $attribute->label, [
                    'options' => $attribute->options->map(function($option) {
                        return [
                            'id' => $option->id,
                            'name' => $option->label
                        ];
                    }),
                ]);
            }

            if (!$attribute->use_in_rating && $attribute->type === 'textarea') {
                $this->formBuilder->add($attribute->type, "meta.$attribute->name", $attribute->label);
            }

        });
    }

    protected function getUsers()
    {
        $users = User::all();
        $users = $users->map(function ($user) {
            return ['id' => $user->id, 'name' => $user->first_name.' '.$user->last_name];
        })->toArray();

        return $users;
    }

    public function fill(Check $check)
    {
        $criterias = $check->criteria;

        collect($this->formBuilder->getFields())->each(function($field) use ($criterias){
            collect($criterias)->each(function($criteria) use ($field){
                if ($field->getName() === "meta.$criteria->name") {
                    $value = null;
                    if ($criteria->options) {
                        foreach ($criteria->options as $option) {
                            if (!$option->selected) {
                                continue;
                            }
                            $value = $option->id;
                        }
                    }

                    if (property_exists($criteria, 'value')) {
                        $value = $criteria->value;
                    }

                    $field->setValue($value);
                }
            });
        });

        return $this;
    }
}
