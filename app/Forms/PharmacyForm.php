<?php
namespace App\Forms;

use App\Models\Pharmacy;

class PharmacyForm extends AbstractForm
{
    protected function buildForm()
    {
        //Todo coordinates fields
        $this->formBuilder
            ->add('text', 'name', 'Название компании', [
                'validationRule' => 'required'
            ]);

        $this->formBuilder
            ->add('text', 'address', 'Адрес');

    }

    public function fill(Pharmacy $pharmacy)
    {
        foreach ($this->formBuilder->getFields() as $field) {
            $value = null;

            if ('name' === $field->getName()) {
                $value = $pharmacy->name;
            }else if('address' === $field->getName()) {
                $value = $pharmacy->address;
            }

            $field->setValue($value);
        }

        return $this->formBuilder;
    }
}
