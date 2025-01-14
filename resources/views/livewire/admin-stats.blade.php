<div>
    {{-- <select id="admin_stats_date_select" class="select select-bordered w-full max-w-xs">
        <option selected value="month">Месяц</option>
        <option value="week">Неделя</option>
        <option value="day">День</option>
    </select> --}}

    <div class="flex flex-row gap-4">
        <div>
            <label for="interval-start">Начало</label>
            <input id="interval-start" type="date" class="input interval-dates input-bordered w-full max-w-xs" value="{{$interval_start->format('Y-m-d')}}">
        </div>
        <div>
            <label for="interval-end">Конец</label>
            <input id="interval-end" type="date" class="input interval-dates input-bordered w-full max-w-xs" value="{{$interval_end->format('Y-m-d')}}">
        </div>
        <div>
            <label for="change-interval-btn" class=" text-white">ЖМяк</label>
            <button id="change-interval-btn" class="btn btn-primary w-full max-w-xs">Применить</button>
        </div>
    </div>

    <h4 class="py-4 font-bold">Выводы робуксов</h4>
    <ul>
        <li>Всего выведено: {{$withdrawals[0]->total_sum ?? '0'}}
    </ul>
    <h4 class="py-4 font-bold">Раздачи</h4>
    <ul>
        <li>Всего разыграно: {{$giveaways[0]->total_sum ?? '0'}}
    </ul>
    <h4 class="py-4 font-bold">Задачи</h4>
    <ul>
        <li>Количество задач выполнено: {{$task_orders[0]->tasks_count ?? '0'}}
        <li>Получено звезд: {{$task_orders[0]->total_sum ?? '0'}}
        <li>Выплачено робуксов: {{$task_orders[0]->total_reward ?? '0'}}
    </ul>
    <h4 class="py-4 font-bold">Новых юзеров</h4>
    <ul>
        <li>Всего: {{$new_users[0]->user_count ?? '0'}}
    </ul>
    <ul>
        <li>По реф. ссылкам: {{$new_refs[0]->ref_count ?? '0'}}
    </ul>
</div>


@script
    <script>
        const btn = document.querySelector('#change-interval-btn')
        
        const interval = { start: document.querySelector('#interval-start').valueAsNumber, end: document.querySelector('#interval-end').valueAsNumber }
        btn.addEventListener('click', function (e) {
            btn.setAttribute('disabled', 'disabled');
            $wire.dispatch('dateIntervalChange', interval);
        })
    </script>
@endscript