<div>

    <form wire:submit.prevent="update" enctype="multipart/form-data">
        <div class="row g-3">
            @foreach($fields as $field)
            @if($field['type'] !== 'textarray')
            <livewire:form.input-field
                wire:model="data.{{ $field['name'] }}"
                :name="$field['name']"
                :defaultValue="$field['defaultValue'] ?? ''"
                :label="$field['label']"
                :type="$field['type']"
                :options="$field['options'] ?? []"
                :input-attributes="$field['attributes'] ?? []"
                wire:key="field-{{ $field['name'] }}" />
            @else
            @foreach($field['dataKeys'] as $dataKey)
            <livewire:form.input-field
                wire:model="data.{{ $field['name'] }}.{{ $dataKey }}"
                :name="$field['name']"
                :defaultValue="$field['defaultValue'] ?? ''"
                :label="$dataKey"
                :type="$field['type']"
                :options="$field['options'] ?? []"
                :input-attributes="$field['attributes'] ?? []"
                wire:key="field-{{ $field['name'] }}-{{ $dataKey }}" />
            @endforeach
            @endif
            @endforeach
        </div>
        <button class="btn btn-primary" type="submit" wire:loading.attr="disabled"
            wire:target="update"> <span wire:loading.remove wire:target="update">
                {{ $submitLabel }}
            </span>

            {{-- Spinner when loading --}}
            <span wire:loading wire:target="update">
                Processing...
            </span></button>
        <br />
        <br />
    </form>
</div>