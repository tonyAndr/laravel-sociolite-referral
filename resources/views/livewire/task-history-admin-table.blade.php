<div>
    @if ($new_tasks->count())
        {{-- The best athlete wants his opponent at his best. --}}
        <table class="border-separate border table-fixed w-full mb-2 rounded-lg">
            <thead class="bg-blue-100">
                <tr>
                    <th class="border-b w-10">ID</th>
                    <th class="border-b ">Название</th>
                    <th class="border-b ">Прогресс</th>
                    <th class="border-b w-12">Цена</th>
                    <th class="border-b ">Статус</th>
                    <th class="border-b rounded-tr-lg w-24">Действия</th>

                </tr>
            </thead>
            <tbody class="border-collapse">

                @foreach ($new_tasks as $nt)
                    <tr class="group">
                        <td class="border-b group-last:border-none">{{ $nt->id }}</td>
                        <td class="text-center border-b group-last:border-none">{{ $nt->title }}</td>
                        <td class="text-center border-b group-last:border-none">{{ $nt->fullfilled }} из {{ $nt->requested }}</td>
                        <td class="text-center border-b group-last:border-none">{{ $nt->price }}</td>
                        <td class="text-center border-b group-last:border-none">{{ $nt->status }}</td>
                        <td class="text-center border-b group-last:border-none">
                                <button wire:click="$dispatch('openModal', { component: 'edit-master-task', arguments: { task: {{ $nt->id }}, edit_action: 'edit' }})"><i
                                    class="fa-solid fa-pen-to-square px-1  text-xl text-yellow-600"></i></button>
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
