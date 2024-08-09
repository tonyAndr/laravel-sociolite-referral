<x-modal-wire form-action="cancel">
    <x-slot name="title">
        <h3>Подтвердить возврат</h3>
    </x-slot>

    <x-slot name="content">
        <div class="flex flex-col">
            <x-input-label for="reason" value="reason" />
            <textarea id="reason" type="text" wire:model="reason" class="textarea textarea-bordered mb-6"></textarea>
        </div>
    </x-slot>

    <x-slot name="buttons">
        <button  type="submit"class="btn btn-success">Отправить</button>
    </x-slot>
</x-modal>