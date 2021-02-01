<?php

namespace App\Forms;

use App\Models\Company;
use App\Models\Department;
use Saodat\FormBase\Contracts\FormBuilderInterface;

class DepartmentForm extends AbstractForm
{
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
            ->add('select', 'company_id', 'Компания',
                [
                    'attributes' => ['outlined' => true, "cols" => 12],
                    'validationRule' => 'required',
                    'options' => $this->getCompanies()
                ]);

        $this->formBuilder
            ->add('text', 'name', 'Название',
                [
                    'attributes' => ['outlined' => true, "cols" => 12],
                    'validationRule' => 'required',
                ]
            );

    }
    protected function getCompanies()
    {
        $data = Company::all();
        $data = $data->map(function ($item) {
            return ['id' => $item->id, 'name' => $item->name];
        })->toArray();

        return $data;
    }

    public function fill(Department $department)
    {

        foreach ($this->formBuilder->getFields() as $field) {
            $value = null;
            if ($department->{$field->getName()}) {
                $value = $department->{$field->getName()};
            }
            $field->setValue($value);
        }

        return $this;
    }
}
