<?php


namespace App\Forms;


use App\Models\CheckAttribute;

class CheckAttributeForm extends AbstractForm
{
    protected function buildForm()
    {
        $this->formBuilder->add('text', 'name', 'Название',
            ['validationRule' => 'required']);

        $this->formBuilder->add('select', 'type', 'Тип', [
            'options' => [
                [
                    'id' => 'radio',
                    'name' => 'Радио кнопка'
                ],
                [
                    'id' => 'textarea',
                    'name' => 'Текстовое поле'
                ]
            ],
            'value' => 'radio'
        ]);

        $this->formBuilder->add('radio', 'use_in_rating', 'Учитывать ли при создании рейтинга', [
            'options' => [
                [
                    'value' => 1,
                    'label' => 'Да'
                ],
                [
                    'value' => 0,
                    'label' => 'Нет'
                ],
            ],
            'value' => 0
        ]);

        $this->formBuilder->add('number', 'order', 'Порядок', ['value' => 0]);
    }

    public function fill(CheckAttribute $checkAttribute)
    {
        // Todo fill method logic
        return $this;
    }
}
