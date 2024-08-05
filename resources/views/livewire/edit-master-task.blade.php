<x-modal-wire form-action="review">
    <x-slot name="title">
        <p>Teleram id покупателя: {{ $telegram_id }}</p>
            <p>Заплачено: {{ $price }}</p>
                <p>Имя продукта: {{ $product }}</p>
    </x-slot>

    <x-slot name="content">
        <div class="flex flex-col">
            <x-input-label for="title" value="Title" />
            <input id="title" type="text" wire:model="form.title" class="input input-bordered w-full max-w-xs mb-6">
            <x-input-label for="description" value="Description" />
            <textarea id="description" type="text" wire:model="form.description" class="textarea textarea-bordered mb-6"></textarea>
            <x-input-label for="ref_url" value="Ref. Url" />
            <input id="ref_url" type="text" wire:model="form.ref_url" class="input input-bordered w-full max-w-xs mb-6">
            <x-input-label for="requested" value="Рефералов" />
            <input id="requested" type="number" wire:model="form.requested" class="input input-bordered w-full max-w-xs mb-6">
            <x-input-label for="proof_type" value="Пруф" />
            <select id="proof_type" wire:model="form.proof_type" class="select select-bordered w-full max-w-xs mb-6">
                <option value="none">none</option>
                <option value="text">Text</option>
                <option value="screenshot">Screenshot</option>
            </select>
            <x-input-label for="user_reward" value="Награда юзеру" />
            <input id="user_reward" type="number" value="10" wire:model="form.user_reward" class="input input-bordered w-full max-w-xs mb-6">
        </div>

    </x-slot>

    <x-slot name="buttons">
        <button type="submit">Save</button>
        <button class="btn btn-success">Success</button>
        <button class="btn btn-warning">Warning</button>
    </x-slot>
</x-modal>