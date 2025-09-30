<div class="mb-3 col-12 col-lg-4 col-md-6">
    @if($type !== 'hidden')
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    @endif

    @switch($type)
    @case('select')
    <select style="text-transform:capitalize;" id="{{ $name }}"
        wire:model="value"
        class="form-select @error('data.'.$name) is-invalid @enderror"
        @foreach($inputAttributes as $k=>$v) {{ $k }}="{{ $v }}" @endforeach>
        <option value="">Select {{ $label }}</option>
        @foreach($options as $key => $option)
        <option value="{{ $key }}">{{ $option }}</option>
        @endforeach
    </select>
    @break

    @case('textarea')
    <textarea id="{{ $name }}"
        wire:model="value"
        class="form-control @error('data.'.$name) is-invalid @enderror"
        @foreach($inputAttributes as $k=>$v) {{ $k }}="{{ $v }}" @endforeach>{{ $value }}</textarea>
    @break


    @case('hidden')
    <input type="hidden" id="{{ $name }}"
        wire:model="value" />
    @break

    @default
    <input type="{{ $type }}" id="{{ $name }}"
        wire:model="value"
        class="form-control @error('data.'.$name) is-invalid @enderror"
        @foreach($inputAttributes as $k=>$v) {{ $k }}="{{ $v }}" @endforeach>
    @endswitch

    {{-- Field-specific error --}}
    @error("data.$name")
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>