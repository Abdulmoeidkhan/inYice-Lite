<div class="mb-3 col-12 col-lg-4 col-md-6">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>

    @switch($type)
    @case('select')
    <select id="{{ $name }}" wire:model="value" class="form-select"
        @foreach($inputAttributes as $k=>$v) {{ $k }}="{{ $v }}" @endforeach>
        <option value="">Select {{ $label }}</option>
        @foreach($options as $key => $option)
        <option value="{{ $key }}">{{ $option }}</option>
        @endforeach
    </select>
    @break

    @case('textarea')
    <textarea id="{{ $name }}" wire:model="value" class="form-control"
        @foreach($inputAttributes as $k=>$v) {{ $k }}="{{ $v }}" @endforeach>{{ $value }}</textarea>
    @break

    @case('file')
    <input type="file" id="{{ $name }}" wire:model="value" class="form-control"
        @foreach($inputAttributes as $k=>$v) {{ $k }}="{{ $v }}" @endforeach>
    @if($value && is_object($value))
    <div class="mt-2 text-muted">File selected: {{ $value->getClientOriginalName() }}</div>
    @endif
    @break

    @default
    <input type="{{ $type }}" id="{{ $name }}" wire:model="value" class="form-control"
        value="{{ $value }}"
        @foreach($inputAttributes as $k=>$v) {{ $k }}="{{ $v }}" @endforeach>
    @endswitch

    @error('value')
    <div class="text-danger small">{{ $message }}</div>
    @enderror
</div>