<form wire:submit.prevent="submit" enctype="multipart/form-data">
    <div class="row g-3">
        @foreach($fields as $field)
        <livewire:form.input-field
            wire:model="data.{{ $field['name'] }}"
            :name="$field['name']"
            :label="$field['label']"
            :type="$field['type']"
            :value="$data[$field['name']]"
            :options="$field['options'] ?? []"
            :input-attributes="$field['attributes'] ?? []"
            wire:key="field-{{ $field['name'] }}" />
        @endforeach
    </div>
    <button class="btn btn-primary">{{ $submitLabel }}</button>
</form>