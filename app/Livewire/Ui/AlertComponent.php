<?php

namespace App\Livewire\Ui;

use App\Livewire\Ui\ListComponent;
use Livewire\Component;
use Livewire\Attributes\On;

class AlertComponent extends Component
{

    public ?string $message = null;
    public string $type = 'info'; // success, danger, warning, info


    #[On('alert')]
    public function show(string $message, string $type = 'info'): void
    {
        $this->message = $message;
        $this->type = $type;

        // Start auto-dismiss timer
        $this->dispatch('start-bootstrap-alert-timer');
        if ($this->type == 'success') {
            $this->dispatch('update-component')->to(ListComponent::class);;
        }
    }

    public function close()
    {
        $this->message = null;
    }

    public function render()
    {
        return view('livewire.ui.alert-component');
    }
}
