<?php

namespace App\Livewire\Form;

use Livewire\Component;
use Livewire\Attributes\Modelable;

class InputField extends Component
{
    #[Modelable] // ✅ makes $value bindable from parent via wire:model
    public $value = null;

    public string $defaultValue;
    public string $type = 'text';
    public string $name;
    public string $label;
    public array $options = [];
    public array $inputAttributes = []; // ✅ renamed (avoid $attributes conflict)

    public function mount(
        string $name,
        string $label,
        string $type,
        string $defaultValue,
        $value = null,
        array $options = [],
        array $inputAttributes = []
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->type = $type;
        $this->value = $value ?? $defaultValue;
        $this->defaultValue = $defaultValue;
        $this->options = $options;
        $this->inputAttributes = $inputAttributes;
    }

    public function render()
    {
        return view('livewire.form.input-field');
    }
}
