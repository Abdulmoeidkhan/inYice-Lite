<?php

namespace App\Livewire\Ui;

use Livewire\Component;
use Livewire\Attributes\On;

class AlertComponent extends Component
{

    public ?string $message = null;
    public string $type = 'info'; // success, danger, warning, info

    protected $listeners = ['alert' => 'show'];

    public function show(string $message, string $type = 'info')
    {
        $this->message = $message;
        $this->type = $type;

        // Start auto-dismiss timer
        $this->dispatch('start-bootstrap-alert-timer');
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
