<?php

namespace App\Forms;

use App\Models\Department;
use App\Models\User;
use Saodat\FormBase\Contracts\FormBuilderInterface;

class UserForm extends AbstractForm
{
    private const SUBSCRIBER_ROLE_ID = 2;
    /**
     * @var string[]
     */
    private $genderOptions = ["Мужской", "Женский"];

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
            ->add('select', 'department_id', 'Департамент',
                [
                    'attributes' => ['outlined' => true, "cols" => 12],
                    'validationRule' => 'required',
                    'options' => $this->getDepartments()
                ]);

        $this->formBuilder
            ->add('text', 'name', 'Имя',
                [
                    'attributes' => ['outlined' => true, "cols" => 4],
                    'validationRule' => 'required',
                ]
            );

        $this->formBuilder
            ->add('text', 'surname', 'Фамилия',
                [
                    'attributes' => ['outlined' => true, "cols" => 4],
                    'validationRule' => 'required',
                ]
            );

        $this->formBuilder
            ->add('text', 'nickname', 'nickname',
                [
                    'attributes' => ['outlined' => true, "cols" => 4],
                    'validationRule' => 'required',
                ]
            );

        $this->formBuilder
            ->add('email', 'email', 'Электронная почта',
                [
                    'validationRule' => 'required|email',
                ]
            );

        $this->formBuilder
            ->add('tel', 'phone', 'Номер телефона',
                [
                    'validationRule' => 'required',
                ]
            );

    }
    protected function getDepartments()
    {
        $data = Department::all();
        $data = $data->map(function ($item) {
            return ['id' => $item->id, 'name' => $item->name];
        })->toArray();

        return $data;
    }

    public function fill(User $user)
    {
        $user = $user->load(['meta', 'pharmacy', 'roles']);

        foreach ($this->formBuilder->getFields() as $field) {
            $value = null;
            $userMeta = $user->meta->toArray();



            if ($user->{$field->getName()} && $field->getName() !== 'password') {
                $value = $user->{$field->getName()};
            }


            $field->setValue($value);
        }

        return $this;
    }
}
