<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CheckAttribute extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->getAttributeData()->each(function($data) {
            \App\Models\CheckAttribute::create($data);
        });
    }

    protected function getAttributeData()
    {
        return collect([
            [
                'name' => 'ethics',
                'type' => 'radio',
                'options' => [
                    'label' => 'Этика поведения',
                    'options' => ['Да' => 1, 'Нет' => 0],
                    'use_in_rating' => true,
                    'validation_rule' => ''
                ],
                'order' => 0,
            ],
            [
                'name' => 'consultation',
                'type' => 'radio',
                'options' => [
                    'label' => 'Консультация',
                    'options' => ['Да' => 1, 'Нет' => 0],
                    'use_in_rating' => true,
                    'validation_rule' => ''
                ],
                'order' => 0,
            ],
            [
                'name' => 'consultation_product',
                'type' => 'radio',
                'options' => [
                    'label' => 'Презентация препарата',
                    'options' => ['Да' => 1, 'Нет' => 0],
                    'use_in_rating' => true,
                    'validation_rule' => ''
                ],
                'order' => 0,
            ],
            [
                'name' => 'desc',
                'type' => 'textarea',
                'options' => [
                    'label' => 'Краткое примечание',
                    'use_in_rating' => false,
                    'validation_rule' => ''
                ],
                'order' => 0,
            ],
        ]);
    }
}
