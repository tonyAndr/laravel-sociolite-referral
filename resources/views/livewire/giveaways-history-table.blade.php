<div>
    @if($giveaways->count())
    {{-- The best athlete wants his opponent at his best. --}}
    <div class="overflow-x-auto">
        <table class="border-separate border table-fixed md:w-full mb-2 rounded-lg">
            <thead class="bg-blue-100">
                <tr>
                    {{-- <th class="border-b">USER ID</th> --}}
                    <th class="border-b p-2 rounded-tl-lg ">ID</th>
                    <th class="border-b ">Дата розыгрыша</th>
                    <th class="border-b ">ID Победителя</th>
                    <th class="border-b ">Награда</th>
                    <th class="border-b ">Количество участников</th>
                    <th class="border-b rounded-tr-lg">Статус</th>
                </tr>
            </thead>
            <tbody class="border-collapse">

                @foreach ($giveaways as $ga)
                    <tr class="group">
                        <td class="p-1 border-b group-last:border-none">{{ $ga->id }}</td>
                        <td class="text-center border-b group-last:border-none">{{ $ga->finalization_date }}</td>
                        <td class="text-center border-b group-last:border-none">{{ $ga->winner_id }}</td>
                        <td class="text-center border-b group-last:border-none">{{ $ga->reward }}</td>
                        <td class="text-center border-b group-last:border-none">{{ $ga->participants_count }}</td>
                        <td class="text-center border-b group-last:border-none">{{ $ga->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $giveaways->links() }}
    @else
    <p>Нет раздач</p>
    @endif

</div>
