<div>
    @if($users->count())
    {{-- The best athlete wants his opponent at his best. --}}
    <table class="border-separate border table-fixed w-full mb-2 rounded-lg">
        <thead class="bg-blue-100">
            <tr>
                <th class="border-b p-2 rounded-tl-lg">Имя</th>
                <th class="border-b ">TG ID</th>
                <th class="border-b ">Тип Реги</th>
                <th class="border-b rounded-tr-lg">R$</th>
            </tr>
        </thead>
        <tbody class="border-collapse">

            @foreach ($users as $user)
                <tr class="group">
                    <td class="p-1 border-b group-last:border-none">{{ $user->name }}</td>
                    <td class="text-center border-b group-last:border-none">{{ $user->oauth_id }}</td>
                    <td class="text-center border-b group-last:border-none">{{ $user->oauth_provider }}</td>
                    <td class="text-center border-b group-last:border-none">{{ $user->robux }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
    @else
    <p>Пользователей нет</p>
    @endif

</div>
