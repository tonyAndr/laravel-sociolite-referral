<div>
    @if ($new_tasks->count())
        {{-- The best athlete wants his opponent at his best. --}}
        <table class="border-separate border table-fixed w-full mb-2 rounded-lg">
            <thead class="bg-blue-100">
                <tr>
                    <th class="border-b w-10">ID</th>
                    <th class="border-b ">Telegram ID</th>
                    <th class="border-b ">Сервис</th>
                    <th class="border-b ">Рефералов куплено</th>
                    <th class="border-b w-12">Цена</th>
                    <th class="border-b rounded-tr-lg w-24">Действия</th>

                </tr>
            </thead>
            <tbody class="border-collapse">

                @foreach ($new_tasks as $nt)
                    <tr class="group">
                        <td class="p-1 border-b group-last:border-none">{{ $nt->id }}</td>
                        <td class="text-center p-1 border-b group-last:border-none">{{ $nt->buyer_id }}</td>
                        <td class="text-center border-b group-last:border-none">{{ $nt->product->description }}</td>
                        <td class="text-center border-b group-last:border-none">{{ $nt->requested }}</td>
                        <td class="text-center border-b group-last:border-none">{{ $nt->price }}</td>
                        <td class="flex flex-row gap-4 justify-center border-b group-last:border-none">
                                <button wire:click="$dispatch('openModal', { component: 'edit-master-task', arguments: { task: {{ $nt->id }}, edit_action: 'review' }})"><i
                                    class="fa-solid fa-circle-check px-1  text-xl text-green-600"></i></button>
                                <button wire:click="$dispatch('openModal', { component: 'cancel-master-task', arguments: { task: {{ $nt->id }}, edit_action: 'cancel'  }})"><i
                                        class="fa-solid fa-circle-minus px-1 text-xl text-red-600"></i></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $new_tasks->links() }}
    @else
        <p>Нет заявок</p>
    @endif

</div>
