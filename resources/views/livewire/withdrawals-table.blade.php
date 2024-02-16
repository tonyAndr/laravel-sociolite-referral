<div>
    @if($withdrawals->count())
    {{-- The best athlete wants his opponent at his best. --}}
    <table class="border-separate border table-fixed w-full mb-2 rounded-lg">
        <thead class="bg-blue-100">
            <tr>
                <th class="border-b p-2 rounded-tl-lg">USER ID</th>
                <th class="border-b ">Имя</th>
                <th class="border-b rounded-tr-lg">R$</th>
                <th class="border-b rounded-tr-lg">Статус</th>
            </tr>
        </thead>
        <tbody class="border-collapse">

            @foreach ($withdrawals as $wd)
                <tr class="group">
                    <td class="p-1 border-b group-last:border-none">{{ $wd->user_id }}</td>
                    <td class="text-center border-b group-last:border-none">{{ $wd->getUser()->name }}</td>
                    <td class="text-center border-b group-last:border-none">{{ $wd->amount }}</td>
                    <td class="text-center border-b group-last:border-none">{{ $wd->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $withdrawals->links() }}
    @else
    <p>Нет заявок</p>
    @endif

</div>