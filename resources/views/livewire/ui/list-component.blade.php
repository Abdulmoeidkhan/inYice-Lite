<div>
    @if($title)
    <div class="mb-3">
        <h2>{{ $title }}</h2>
    </div>
    @endif

    <div class="mb-4 mx-auto col-12 col-lg-8 col-md-6">
        <input
            type="text"
            class="form-control"
            wire:model.debounce.300ms="search"
            placeholder="{{ $searchPlaceholder }}">
    </div>

    <div class="mx-auto col-12 col-lg-8 col-md-6">
        @if(count($this->filteredData) > 0)
        <ol class="list-group list-group-numbered">
            @foreach ($this->filteredData as $item)
            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div class="ms-2 me-auto">
                    <div class="fw-bold">{{ $item[$columns[0]['field']] ?? '' }}</div>
                    <span>{{ $item[$columns[1]['field']] ?? '' }}</span>
                </div>

                @if (!empty($item[$columns[2]['field']] ?? ''))
                <span class="badge bg-primary rounded-pill">
                    {{ $item[$columns[2]['field']] }}
                </span>
                @endif
            </li>
            @endforeach
        </ol>
        @else
        <p>No data found.</p>
        @endif
    </div>
</div>