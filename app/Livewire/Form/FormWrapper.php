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
    public string $submitLabel;
    public string $additionalFunctionValue;
    public array $pullValues;
    public string $className;
    public string $uuid;
    public string $id;



    public function mount(
        array $fields,
        string $className,
        string $uuid = '',
        string $key = '',
        string $submitLabel = 'Update',
        array $additionalFunctions = [],
        array $dataKeys = [],
        string $additionalFunctionValue = '',
        array $pullValues = [],
        $data = [],
        string $id = ''
    ) {
        $this->fields = $fields;
        $this->className = $className;
        $this->uuid = $uuid;
        $this->data = $data;
        $this->submitLabel = $submitLabel;
        $this->additionalFunctions = $additionalFunctions;
        $this->additionalFunctionValue = $additionalFunctionValue;
        $this->pullValues = $pullValues;
        $this->dataKeys = $dataKeys;
        $this->id = $id;
        
        foreach ($fields as $field) {
            $field['value'] = $this->data[$field['name']] ?? null;
            if (isset($field['defaultValue'])) {
                $this->data[$field['name']] = $field['defaultValue'];
            }
        }

        if (strlen($uuid) > 1) {
            $model = new $className;
            $dataRetrieve = $model::where('uuid', $uuid)->first();
            $this->data = $dataRetrieve ? $dataRetrieve->toArray() : [];
            foreach ($this->data as $key => $value) {
                if (is_string($value) && ($decoded = json_decode($value, true)) !== null && json_last_error() === JSON_ERROR_NONE) {
                    $this->data[$key] = $decoded;
                }
            }
            // Handle specific fields that need decoding
            if (isset($this->data['social_links']) && is_array($this->data['social_links'])) {
                $this->data['social_links'] = $this->data['social_links'];
            } else {
                $this->data['social_links'] = [];
            }
        }

        // dd($this->data);
    }

    #[On('{id}')]
    public function updateComponent($updateUuid = null)
    {
        if ($updateUuid) {
            $this->uuid = $updateUuid;
        }
        if (strlen($this->uuid) > 1) {
            $model = new $this->className;
            $dataRetrieve = $model::where('uuid', $this->uuid)->first();
            $this->data = $dataRetrieve ? $dataRetrieve->toArray() : [];
            foreach ($this->data as $key => $value) {
                if (is_string($value) && ($decoded = json_decode($value, true)) !== null && json_last_error() === JSON_ERROR_NONE) {
                    $this->data[$key] = $decoded;
                }
            }
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
            if (strlen($this->uuid) > 1) {
                foreach ($this->fields as $field) {
                    $name = $field['name'];
                    if (isset($field['cast']) && $field['cast'] === 'array' && isset($this->data[$name])) {
                        // Ensure array is stored properly
                        $this->data[$name] = (array) $this->data[$name];
                    }
                }
                $resource = $model::where('uuid', $this->uuid)->first();

                if (!$resource) {
                    $this->addError('general', 'Resource not found.');
                    return 'Resource not found.';
                }
                $resource->update($this->data);
            } else {
                $createdResource = $model::create($this->data);

                // Run after-save function if defined
                if (isset($this->additionalFunctions['afterSaveFunction'])) {
                    $functionName = $this->additionalFunctions['afterSaveFunction'];
                    if (method_exists($createdResource, $functionName)) {
                        $createdResource->$functionName($this->additionalFunctionValue);
                    }
                }
            }

            $this->dispatch(
                'alert',
                type: 'success',
                message: strlen($this->uuid) > 1 ? 'Update successful!' : 'Creation successful!'
            );

            if (!empty($this->pullValues)) {
                foreach ($this->pullValues as $fieldName) {
                    if (array_key_exists($fieldName, $this->data)) {
                        unset($this->data[$fieldName]);
                    }
                }
            }


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
