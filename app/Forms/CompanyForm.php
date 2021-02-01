<?php

namespace App\Forms;

use App\Models\Company;
use App\Models\Department;
use Saodat\FormBase\Contracts\FormBuilderInterface;

class CompanyForm extends AbstractForm
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
            ->add('text', 'name', 'Название',
                [
                    'attributes' => ['outlined' => true, "cols" => 12],
                    'validationRule' => 'required',
                ]
            );

    }

    public function fill(Company $company)
    {

        foreach ($this->formBuilder->getFields() as $field) {
            $value = null;
            if ($company->{$field->getName()}) {
                $value = $company->{$field->getName()};
            }
            $field->setValue($value);
        }

        return $this;
    }
}
