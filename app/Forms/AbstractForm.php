<?php


namespace App\Forms;


use Saodat\FormBase\Contracts\FormBuilderInterface;

abstract class AbstractForm
{
    /**
     * @var FormBuilderInterface
     */
    protected $formBuilder;
    /**
     * @var FormBuilderInterface
     */
    protected $form;

    /**
     * @var array
     */
    protected $defaultFieldsAttributes = ['outlined' => true, "cols" => 6];

    public function __construct(FormBuilderInterface $formBuilder)
    {
        $this->formBuilder = $formBuilder;
        $this->buildForm();
    }

    abstract protected function buildForm();

    public function get()
    {
        return $this->formBuilder->getSchema();
    }
}
