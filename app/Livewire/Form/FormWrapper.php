<?php

namespace App\Livewire\Form;

use Livewire\Component;
use Livewire\WithFileUploads;

class FormWrapper extends Component
{
    use WithFileUploads;

    public array $fields = [];
    public array $data = [];
    public string $submitLabel = 'Submit';
    public $className = '';
    public array $additionalFunctions = [];
    public $additionalFunctionValue = '';


    public function mount(array $fields, string $submitLabel = 'Submit', $className)
    {
        $this->fields = $fields;
        $this->submitLabel = $submitLabel;
        $this->className = $className;

        foreach ($fields as $field) {
            $this->data[$field['name']] = $field['value'] ?? ($field['type'] === 'file' ? null : '');
        }
    }

    public function submit()
    {
        // Example validation
        $rules = [];
        foreach ($this->fields as $field) {
            $rules["data.{$field['name']}"] = $field['rules'] ?? 'nullable';
        }
        $this->validate($rules);

        // Handle your form submission logic
        $model = new $this->className;
        $createdResource = $model::create($this->data);
        if (isset($this->additionalFunctions['afterSaveFunction'])) {
            $functionName = $this->additionalFunctions['afterSaveFunction'];
            if (method_exists($model, $functionName)) {
                // dd($this->additionalFunctionValue, $functionName);
                $createdResource->$functionName($this->additionalFunctionValue);
            }
        }
        // dd($this->data);
    }

    public function render()
    {
        return view('livewire.form.form-wrapper');
    }
}
