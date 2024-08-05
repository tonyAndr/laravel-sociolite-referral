<div>
    @if ($new_tasks->count())
        {{-- The best athlete wants his opponent at his best. --}}
        <table class="border-separate border table-fixed w-full mb-2 rounded-lg">
            <thead class="bg-blue-100">
                <tr>
                    <th class="border-b ">Telegram ID</th>
                    <th class="border-b ">Product ID</th>
                    <th class="border-b ">Рефералов</th>
                    <th class="border-b ">Цена</th>
                    <th class="border-b ">Реф. Ссылка</th>
                    <th class="border-b rounded-tr-lg">Действия</th>

                </tr>
            </thead>
            <tbody class="border-collapse">

                @foreach ($new_tasks as $nt)
                    <tr class="group">
                        <td class="p-1 border-b group-last:border-none">{{ $nt->buyer_id }}</td>
                        <td class="text-center border-b group-last:border-none">{{ $nt->product->service }}</td>
                        <td class="text-center border-b group-last:border-none">{{ $nt->requested }}</td>
                        <td class="text-center border-b group-last:border-none">{{ $nt->price }}</td>
                        <td class="text-center border-b group-last:border-none">{{ $nt->ref_url }}</td>
                        <td class="text-center border-b group-last:border-none">
                                <button wire:click="$dispatch('openModal', { component: 'edit-master-task', arguments: { task: {{ $nt->id }} }})"><i
                                    class="fa-solid fa-circle-check px-4  text-xl text-green-600"></i></button>
                                <button wire:click="cancel({{ $nt->id }})nt->id }} }})"><i
                                        class="fa-solid fa-circle-minus text-xl text-red-600"></i></button>
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
