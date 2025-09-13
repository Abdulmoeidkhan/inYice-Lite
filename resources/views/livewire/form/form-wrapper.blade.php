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
            wire:key="field-{{ $field['name'] }}" />
        @endforeach
        @endif
        @endforeach
    </div>
    <button class="btn btn-primary">{{ $submitLabel }}</button>
</form>