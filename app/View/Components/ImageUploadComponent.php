<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;

class ImageUploadComponent extends Component
{
    /**
     * Create a new component instance.
     */

    public string $name;
    public string $path;
    public string $alt;
    public string $disk;
    public string $uuid;

    public function __construct($name = '', $path = '', $disk = 'public', $alt = 'Image')
    {
        $this->name = $name;
        $this->path = $path;
        $this->disk = $disk;
        $this->alt = $alt;
        $this->uuid = rand();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.image-upload-component');
    }
}
