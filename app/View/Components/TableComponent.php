<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class TableComponent extends Component
{
    /**
     * Create a new component instance.
     */

    public string $requestUrl;
    public array $columns = [];
    public array $subColumns = [];

    public function __construct($requestUrl = '', $columns = [], $subColumns = [])
    {
        $this->subColumns = $subColumns;
        $this->columns = $columns;
        $this->requestUrl = $requestUrl;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table-component');
    }
}
