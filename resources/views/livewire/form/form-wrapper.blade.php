<form wire:submit.prevent="@if($isNew) create @else update @endif" enctype="multipart/form-data">
    <div class="row g-3">
        @foreach($fields as $field)
        <livewire:form.input-field
            wire:model="data.{{ $field['name'] }}"
            :name="$field['name']"
            :label="$field['label']"
            :type="$field['type']"
            :options="$field['options'] ?? []"
            :input-attributes="$field['attributes'] ?? []"
            wire:key="field-{{ $field['name'] }}" />
        @endforeach
    </div>
    <button class="btn btn-primary">{{ $submitLabel }}</button>
</form>
