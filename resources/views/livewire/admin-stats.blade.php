<div>
    <select id="admin_stats_date_select" class="select select-bordered w-full max-w-xs">
        <option selected value="month">Месяц</option>
        <option value="week">Неделя</option>
        <option value="day">День</option>
    </select>

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
        const select = document.querySelector('#admin_stats_date_select')
        select.addEventListener('change', function (e) {
            let new_interval = select.value
            $wire.dispatch('dateIntervalChange', { new_interval });
        })
    </script>
@endscript