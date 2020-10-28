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
           $attribute =  \App\Models\CheckAttribute::create($data);

           if (!$attribute->use_in_rating) {
               return;
           }

            $attribute->options()->create([
               'name' => 'Yes',
                'label' => 'Да',
                'value' => 1,
            ]);

            $attribute->options()->create([
                'name' => 'No',
                'label' => 'Нет',
                'value' => 0,
            ]);
        });
    }

    protected function getAttributeData()
    {
        return collect([
            [
                'name' => 'ethics',
                'type' => 'radio',
                'label' => 'Этика поведения',
                'validation_rule' => 'integer',
                'use_in_rating' => true,
                'order' => 0,
            ],
            [
                'name' => 'consultation',
                'type' => 'radio',
                'label' => 'Консультация',
                'use_in_rating' => true,
                'validation_rule' => 'integer',
                'order' => 0,
            ],
            [
                'name' => 'consultation_product',
                'type' => 'radio',
                'label' => 'Презентация препарата',
                'use_in_rating' => true,
                'validation_rule' => 'integer',
                'order' => 0,
            ],
            [
                'name' => 'desc',
                'type' => 'textarea',
                'label' => 'Краткое примечание',
                'validation_rule' => 'string',
                'order' => 0,
            ],
        ]);
    }
}
