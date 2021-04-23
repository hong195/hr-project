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
                'attributes' => ['outlined' => true],
                'validationRule' => 'required'
            ]);

        $this->formBuilder
            ->add('text', 'email', 'Email аптеки', [
                'attributes' => ['outlined' => true],
                'validationRule' => 'required'
            ]);

        $this->formBuilder
            ->add('text', 'address', 'Адрес', [
                'attributes' => ['outlined' => true]
            ]);

    }

    public function fill(Pharmacy $pharmacy)
    {
        foreach ($this->formBuilder->getFields() as $field) {
            $field->setValue($pharmacy->{$field->getName()} ?? null);
        }

        return $this->formBuilder;
    }
}
