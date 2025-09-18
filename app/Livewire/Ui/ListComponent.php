<?php

namespace App\Livewire\UI;

use Livewire\Component;

class ListComponent extends Component
{
    public ?string $title = null;
    public ?string $searchPlaceholder = null;
    public array $searchTerm = [];
    public string $className;
    public array $filters = [];
    public array $relations = [];
    public array $data = [];
    public array $columns = [];

    public function mount($title = null, $searchPlaceholder = 'Search...', string $className, $filters = [], $relations = [] ,$columns = [] )
    {
        $this->title = $title;
        $this->className = $className;
        $this->searchPlaceholder = $searchPlaceholder;
        $this->filters = $filters;
        $this->relations = $relations;
        $this->columns = $columns;

        $model = new $className;
        if (empty($this->relations)) {
            $dataRetrieve = $model::where($this->filters)->get();
        } else {
            $dataRetrieve = $model::where($this->filters)->with($this->relations)->get();
        }

        $this->data = $dataRetrieve ? $dataRetrieve->toArray() : [];
    }

    public function render()
    {
        return view('livewire.ui.list-component', [
            'data' => $this->data,
        ]);
    }
}
