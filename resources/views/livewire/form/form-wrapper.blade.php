<div>
<div 
    x-data="{ show: false, message: '', type: '' }"
    x-on:alert.window="
        type = $event.detail.type;
        message = $event.detail.message;
        show = true;
        setTimeout(() => show = false, 3000);
    "
    x-show="show"
    x-transition
    class="alert mt-2"
    :class="'alert-' + type"
    role="alert"
>
    <span x-text="message"></span>
</div>
<form wire:submit.prevent="@if($isNew) create @else update @endif" enctype="multipart/form-data">
    <div class="row g-3">
        @foreach($fields as $field)
        @if($field['type'] !== 'textarray')
        <livewire:form.input-field
            wire:model="data.{{ $field['name'] }}"
            :name="$field['name']"
            :label="$field['label']"
            :type="$field['type']"
            :options="$field['options'] ?? []"
            :dataKeys="$field['dataKeys'] ?? []"
            :input-attributes="$field['attributes'] ?? []"
            wire:key="field-{{ $field['name'] }}" />
        @else
        @foreach($field['dataKeys'] as $dataKey)
        <livewire:form.input-field
            wire:model="data.{{ $field['name'] }}.{{ $dataKey }}"
            :name="$field['name']"
            :label="$dataKey"
            :type="$field['type']"
            :options="$field['options'] ?? []"
            :dataKeys="$field['dataKeys'] ?? []"
            :input-attributes="$field['attributes'] ?? []"
            wire:key="field-{{ $field['name'] }}-{{ $dataKey }}" />
        @endforeach
        @endif
        @endforeach
    </div>
    <button class="btn btn-primary"     wire:click="{{ $isNew ? 'create' : 'update' }}"
    wire:loading.attr="disabled" 
    wire:target="{{ $isNew ? 'create' : 'update' }}">    <span wire:loading.remove wire:target="{{ $isNew ? 'create' : 'update' }}">
        {{ $submitLabel }}
    </span>

    {{-- Spinner when loading --}}
    <span wire:loading wire:target="{{ $isNew ? 'create' : 'update' }}">
        Processing...
    </span></button>
</form>
</div>