@php
    function getStatus($code) {
        $statuses = [
            'pending' => 'На проверке',
            'approved' => 'Выплачено',
            'cancelled' => 'Отменено',
        ];
        return $statuses[$code];
    }
@endphp
<div>
    @if ($withdrawals->count())
        {{-- The best athlete wants his opponent at his best. --}}
        <table class="border-separate border table-fixed w-full mb-2 rounded-lg">
            <thead class="bg-blue-100">
                <tr>
                    <th class="border-b p-2 rounded-tl-lg">USER ID</th>
                    <th class="border-b ">Имя</th>
                    <th class="border-b ">Почта</th>
                    <th class="border-b ">Telegram ID</th>
                    <th class="border-b ">R$</th>
                    <th class="border-b ">Создана</th>
                    <th class="border-b ">Коммент</th>
                    <th class="border-b ">Статус</th>
                    <th class="border-b rounded-tr-lg">Действия</th>

                </tr>
            </thead>
            <tbody class="border-collapse">

                @foreach ($withdrawals as $wd)
                    <tr class="group">
                        <td class="p-1 border-b group-last:border-none">{{ $wd->user_id }}</td>
                        <td class="text-center border-b group-last:border-none">{{ $wd->getUser()->name }}</td>
                        <td class="text-center border-b group-last:border-none">{{ $wd->getUser()->email }}</td>
                        <td class="text-center border-b group-last:border-none">
                            @if (!empty($wd->getUser()->oauth_provider->value) && $wd->getUser()->oauth_provider->value === 'telegram')
                                {{ $wd->getUser()->oauth_id }}
                            @endif
                        </td>
                        <td class="text-center border-b group-last:border-none">{{ $wd->amount }}</td>
                        <td class="text-center border-b group-last:border-none">{{ $wd->created_at }}</td>
                        <td class="text-center border-b group-last:border-none">{{ $wd->comment }}</td>
                        <td class="text-center border-b group-last:border-none">{{ getStatus($wd->status) }}</td>
                        <td class="text-center border-b group-last:border-none">
                            <a data-withdrawal-id="{{ $wd->id }}" id="approve_withdrawal_btn" href="#"><i
                                    class="fa-solid fa-circle-check px-4  text-xl text-green-600"></i></a>
                            <a data-withdrawal-id="{{ $wd->id }}" id="cancel_withdrawal_btn" href="#"><i
                                    class="fa-solid fa-circle-minus text-xl text-red-600"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $withdrawals->links() }}
    @else
        <p>Нет заявок</p>
    @endif

</div>
