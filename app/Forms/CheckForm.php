<?php


namespace App\Forms;


use App\Models\Check;
use App\Repositories\Contracts\CheckAttributeRepositoryContract;
use Saodat\FormBase\Contracts\FormBuilderInterface;

class CheckForm extends AbstractForm
{
    private $checkAttributes;

    protected $defaultFieldsAttributes = ['outlined' => true, "cols" => 6];


    public function __construct(FormBuilderInterface $formBuilder,
                                CheckAttributeRepositoryContract $checkAttributeRepository)
    {
        $this->checkAttributes = $checkAttributeRepository->all();
        parent::__construct($formBuilder);
    }

    protected function buildForm()
    {
        $this->formBuilder->add('text', 'name', 'Наименование', [
            'validationRule' => 'required'
        ]);

        $this->formBuilder->add('date', 'created_at', 'Дата проверки',[
            'validationRule' => 'required',
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
