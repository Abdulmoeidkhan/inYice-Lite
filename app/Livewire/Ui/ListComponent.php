<?php

namespace App\Livewire\Ui;

use Livewire\Component;
use Livewire\Attributes\On;

class ListComponent extends Component
{
    public ?string $title = null;
    public ?string $searchPlaceholder = 'Search...';
    public string $className;
    public array $filters = [];
    public array $relations = [];
    public array $columns = [];

    public string $search = '';
    public array $data = [];

    public function mount(
        string $className,
        ?string $title = null,
        ?string $searchPlaceholder = 'Search...',
        array $filters = [],
        array $relations = [],
        array $columns = []
    ): void {
        $this->title = $title;
        $this->searchPlaceholder = $searchPlaceholder;
        $this->className = $className;
        $this->filters = $filters;
        $this->relations = $relations;
        $this->columns = $columns;

        $this->loadData();
    }

    #[On('update-component')]
    public function updateData(): void
    {
        $this->loadData();
    }

    public function loadData()
    {
        $model = new $this->className;
        if (empty($this->relations)) {
            $dataRetrieve = $model::where($this->filters)->get();
        } else {
            $dataRetrieve = $model::where($this->filters)->with($this->relations)->get();
        }
        $this->data = $dataRetrieve ? $dataRetrieve->toArray() : [];

        return $this->data;
    }

    public function getFilteredDataProperty(): array
    {
        if (empty($this->search)) {
            return $this->data;
        }

        $term = strtolower($this->search);

        return array_filter($this->data, function ($item) use ($term) {
            $name = strtolower($item[$this->columns[0]['field']] ?? '');
            $email = strtolower($item[$this->columns[1]['field']] ?? '');

            return str_contains($name, $term) || str_contains($email, $term);
        });
    }

    public function render()
    {
        return view('livewire.ui.list-component', [
            'data' => $this->data,
            'columns' => $this->columns,
        ]);
    }
}
