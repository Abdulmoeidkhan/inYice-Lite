<div
    x-data="{ visible: false }"
    x-init="
        $wire.on('start-bootstrap-alert-timer', () => {
            visible = true;
            setTimeout(() => { visible = false; $wire.close(); }, 5000);
        });
    "
    x-show="visible"
    x-transition
    style="position: fixed; top: 20px; right: 20px; z-index: 1050; width: auto; min-width: 300px;">
    <div class="alert alert-{{ $type }} alert-dismissible fade mb-0" :class="visible?'show':''" role="alert">
        {{ $message }}
        <button :class="visible?'':'visually-hidden'" type="button" class="btn-close" @click="visible = false; $wire.close()" aria-label="Close"></button>
    </div>
</div>