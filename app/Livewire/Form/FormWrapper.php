<?php

namespace App\Livewire\Form;

use Illuminate\Support\Arr;
use Livewire\Component;

class FormWrapper extends Component
{

    public array $fields;
    public array $data;
    public array $additionalFunctions;
    public string $isNew;
    public string $submitLabel;
    public string $additionalFunctionValue;
    public string $className;
    public string $uuid;



    public function mount(
        array $fields,
        bool $isNew = true,
        string $className,
        string $uuid = '',
        string $submitLabel = 'Update',
        array $additionalFunctions = [],
        string $additionalFunctionValue = '',
        $data = []
    ) {

        $this->fields = $fields;
        $this->isNew = $isNew;
        $this->className = $className;
        $this->uuid = $uuid;
        $this->data = $data;
        $this->submitLabel = $submitLabel;
        $this->additionalFunctions = $additionalFunctions;

        foreach ($fields as $field) {
            $field['value'] = $this->data[$field['name']] ?? null;
        }

        if (strlen($uuid) > 1) {
            $isNew = false;
            $model = new $className;
            $dataRetrieve = $model::where('uuid', $uuid)->first();
            $this->data = $dataRetrieve ? $dataRetrieve->toArray() : [];
        }
    }

    public function create()
    {
        $rules = [];
        foreach ($this->fields as $field) {
            $rules["data.{$field['name']}"] = $field['rules'] ?? 'nullable';
        }

        $this->validate($rules);
        try {
            $model = new $this->className;
            // dd($this->data);
            $createdResource = $model::create($this->data);

            // Run after-save function if defined
            if (isset($this->additionalFunctions['afterSaveFunction'])) {
                $functionName = $this->additionalFunctions['afterSaveFunction'];
                if (method_exists($createdResource, $functionName)) {
                    $createdResource->$functionName($this->additionalFunctionValue);
                }
            }
        } catch (\Exception $e) {
            $this->addError('general', 'Failed to create: ' . $e->getMessage());
        }
    }

    public function update()
    {
        $rules = [];
        foreach ($this->fields as $field) {
            $rules["data.{$field['name']}"] = $field['rules'] ?? 'nullable';
        }

        try {
            $this->validate($rules);
            $model = new $this->className;
            $resource = $model::where('uuid', $this->uuid)->first();
            
            if (!$resource) {
                $this->addError('general', 'Resource not found.');
                return;
            }
            $resource->update($this->data);
            return $this->data;
        } catch (\Exception $e) {
            return $e->getMessage();
            $this->addError('general', 'Update failed: ' . $e->getMessage());
        }
    }


    public function render()
    {
        return view('livewire.form.form-wrapper');
    }
}
