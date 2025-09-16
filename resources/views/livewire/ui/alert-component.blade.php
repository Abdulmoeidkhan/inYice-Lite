<div
    x-data="{ visible: @entangle('message').defer !== null }"
    x-init="
        $wire.on('start-bootstrap-alert-timer', () => {
            visible = true;
            setTimeout(() => { visible = false; $wire.close(); }, 5000);
        });
    "
    x-show="visible"
    x-transition
    style="position: fixed; top: 20px; right: 20px; z-index: 1050; width: auto; min-width: 300px;">
    <div class="alert alert-{{ $type }} alert-dismissible fade show mb-0" role="alert">
        {{ $message }}
        <button type="button" class="btn-close" @click="visible = false; $wire.close()" aria-label="Close"></button>
    </div>
</div>