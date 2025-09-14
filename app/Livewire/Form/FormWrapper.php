<?php

namespace App\Livewire\Form;

use Livewire\Component;
use Livewire\Attributes\On;


class FormWrapper extends Component
{

    public array $fields;
    public array $data;
    public array $additionalFunctions;
    public array $dataKeys;
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
        array $dataKeys = [],
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
        $this->dataKeys = $dataKeys;

        foreach ($fields as $field) {
            $field['value'] = $this->data[$field['name']] ?? null;
        }

        if (strlen($uuid) > 1) {
            $isNew = false;
            $model = new $className;
            $dataRetrieve = $model::where('uuid', $uuid)->first();
            $this->data = $dataRetrieve ? $dataRetrieve->toArray() : [];
            foreach ($this->data as $key => $value) {
                if (is_string($value) && ($decoded = json_decode($value, true)) !== null && json_last_error() === JSON_ERROR_NONE) {
                    $this->data[$key] = $decoded;
                }
            }
            // dd($this->data);
            // Handle specific fields that need decoding
            // if (isset($this->data['social_links']) && is_array(json_decode($this->data['social_links'], true))) {
            //     $this->data['social_links'] = json_decode($this->data['social_links'], true);
            // } else {
            //     $this->data['social_links'] = [];
            // }
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
            $createdResource = $model::create($this->data);

            // Run after-save function if defined
            if (isset($this->additionalFunctions['afterSaveFunction'])) {
                $functionName = $this->additionalFunctions['afterSaveFunction'];
                if (method_exists($createdResource, $functionName)) {
                    $createdResource->$functionName($this->additionalFunctionValue);
                }
            }
            $this->dispatch(
    'alert',
    type: 'success',
    message: 'Updated successfully!'
);
        } catch (\Exception $e) {
            $this->addError('general', 'Failed to create: ' . $e->getMessage());
            $this->dispatch(
    'alert',
    type: 'danger',
    message: 'Update failed: ' . $e->getMessage()
);
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
            // if (isset($this->data['social_links'])) {
            //     $this->data['social_links'] = json_encode($this->data['social_links']);
            // }

            foreach ($this->fields as $field) {
                $name = $field['name'];
                if (isset($field['cast']) && $field['cast'] === 'array' && isset($this->data[$name])) {
                    // Ensure array is stored properly
                    $this->data[$name] = (array) $this->data[$name];
                }
            }

            $model = new $this->className;
            $resource = $model::where('uuid', $this->uuid)->first();

            if (!$resource) {
                $this->addError('general', 'Resource not found.');
                return;
            }
            $resource->update($this->data);
            $this->dispatch(
    'alert',
    type: 'success',
    message: 'Updated successfully!'
);
            return $this->data;
        } catch (\Exception $e) {
            // return $e->getMessage();
            $this->addError('general', 'Update failed: ' . $e->getMessage());
            $this->dispatch(
    'alert',
    type: 'danger',
    message: 'Update failed: ' . $e->getMessage()
);
        }
    }

    public function render()
    {
        return view('livewire.form.form-wrapper');
    }
}
