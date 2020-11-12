<?php


namespace App\Forms;


use App\Models\CheckAttributeOption;
use App\Repositories\Contracts\CheckAttributeRepositoryContract;
use Saodat\FormBase\Contracts\FormBuilderInterface;

class CheckAttributeOptionForm extends AbstractForm
{

    /**
     * @var CheckAttributeRepositoryContract
     */
    private $attributes;

    public function __construct(FormBuilderInterface $formBuilder, CheckAttributeRepositoryContract $checkAttributeRepository)
    {
        $this->attributes = $checkAttributeRepository;
        parent::__construct($formBuilder);
    }

    protected function buildForm()
    {
        $this->formBuilder->add('select', 'check_attribute_id', 'Атрибут', [
            'options' => $this->getInUsedAttributes()->map(function($attribute) {
                return [
                    'id' => $attribute->id,
                    'name' => $attribute->label
                ];
            }),
            'validationRule' => 'required'
        ]);
        $this->formBuilder->add('text', 'name', 'Слаг', ['validationRule' => 'required|alpha']);
        $this->formBuilder->add('text', 'label', 'Название', ['validationRule' => 'required|alpha']);
        $this->formBuilder->add('number', 'value', 'Значение');
    }

    public function fill(CheckAttributeOption $option)
    {
        foreach ($this->formBuilder->getFields() as $field){
            if ($option->{$field->getName()}) {
                $field->setValue($option->{$field->getName()});
            }
        }

        return $this;
    }

    private function getInUsedAttributes()
    {
        return $this->attributes->getUsedInRating();
    }
}
