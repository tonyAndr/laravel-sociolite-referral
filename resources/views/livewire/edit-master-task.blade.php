<x-modal-wire form-action="{{ $edit_action }}">
    <x-slot name="title">
        <h3>{{$edit_action === 'review' ? 'Создание задания' : 'Редактирование задания'}}</h3>
        <p>Teleram id покупателя: {{ $telegram_id }}</p>
        <p>Имя продукта: {{ $product_description }}</p>
        <p>Заплачено: {{ $price }}</p>
    </x-slot>

    <x-slot name="content">
        <div class="flex flex-col">
            {{-- Depending on selected action show or hide status field --}}
            @if ($edit_action === 'edit')
            <x-input-label for="status" value="Status" />
                <select id="status" wire:model="form.status" class="select select-bordered w-full max-w-xs mb-6" {{$edit_action === 'review' ? 'hidden' : ''}}>
                    <option value="cancelled">Cancelled</option>
                    <option value="active">Active</option>
                    <option value="pre-review">PreReview</option>
                    <option value="rejected">Rejected</option>
                    <option value="pre-refund">PreRefund</option>
                    <option value="refunded">Refunded</option>
                    <option value="unpaid">Unpaid</option>
                    <option value="finished">Finished</option>
                </select>
            @endif
            @if($edit_action === 'review')
            <input id="status" type="text" wire:model="form.status" class="input input-bordered w-full max-w-xs mb-6" hidden>
            @endif
            <x-input-label for="title" value="Title" />
            <input id="title" type="text" wire:model="form.title" class="input input-bordered w-full max-w-xs mb-6" >
            <x-input-label for="description" value="Дополнительная инфа" />
            <textarea id="description" type="text" wire:model="form.description" class="textarea textarea-bordered mb-6"></textarea>
            <x-input-label for="ref_url" value="Ref. Url" />
            <input id="ref_url" type="text" wire:model="form.ref_url" class="input input-bordered w-full max-w-xs mb-6">
            <x-input-label for="requested" value="Рефералов куплено" />
            <input id="requested" type="number" wire:model="form.requested" class="input input-bordered w-full max-w-xs mb-6">
            <x-input-label for="fullfilled" value="Рефералов получено" />
            <input id="fullfilled" type="number" wire:model="form.fullfilled" class="input input-bordered w-full max-w-xs mb-6">
            <x-input-label for="proof_type" value="Пруф" />
            <select id="proof_type" wire:model="form.proof_type" class="select select-bordered w-full max-w-xs mb-6">
                <option value="screenshot_nickname">Screenshot + Nickname</option>
                <option value="screenshot">Screenshot</option>
                <option value="text">Text</option>
                <option value="none">none</option>
            </select>
            <x-input-label for="user_reward" value="Награда юзеру" />
            <input id="user_reward" type="number" wire:model="form.user_reward" class="input input-bordered w-full max-w-xs mb-6">
        </div>
    </x-slot>

    <x-slot name="buttons">
        <button  type="submit"class="btn btn-success">{{$edit_action === 'review' ? 'Создать' : 'Сохранить'}}</button>
    </x-slot>
</x-modal>