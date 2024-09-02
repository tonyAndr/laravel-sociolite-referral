<!-- Layout -->
@php
    // dd($users);
@endphp

<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Панель администратора') }}
        </h2>
        <div class="flex flex-row gap-6 text-xl pt-4 text-green-600">
            <a href="{{route('admin.index')}}" class="{{$page === 'index' ? 'font-bold underline' : ''}}"># Задачи</a>
            <a href="{{route('admin.withdrawals')}}" class="{{$page === 'withdrawals' ? 'font-bold  underline' : ''}}"># Заявки на вывод</a>
            <a href="{{route('admin.users')}}" class="{{$page === 'users' ? 'font-bold underline' : ''}}"># Юзеры</a>
            <a href="{{route('admin.giveaways')}}" class="{{$page === 'giveaways' ? 'font-bold underline' : ''}}"># Розыгрыши</a>
            <a href="{{route('admin.stats')}}" class="{{$page === 'stats' ? 'font-bold underline' : ''}}"># Статистика</a>
        </div>
    </x-slot>

    <!-- Withdrawals table -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($page === 'index')
                <div class="max-w-full mx-auto sm:px-6 lg:px-8">
                    <h3 class="py-2">Новые задачи</h3>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <livewire:task-review-admin-table />
                        </div>
                    </div>
                </div>
                <div class="max-w-full mx-auto pt-6 sm:px-6 lg:px-8">
                    <h3 class="py-2">История задач</h3>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <livewire:task-history-admin-table />
                        </div>
                    </div>
                </div>
            @endif

            @if ($page === 'users')
                <!-- Users table -->
                <div class="pt-6">
                    <div class="max-w-full mx-auto sm:px-6 lg:px-8">
                        <h3 class="py-2">Пользователи</h3>
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 bg-white border-b border-gray-200">
                                <livewire:users-table />
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.Users table -->
            @endif
            @if ($page === 'withdrawals')
                <div class="max-w-full mx-auto pt-6 sm:px-6 lg:px-8">
                    <h3 class="py-2">Заявки на вывод</h3>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <livewire:withdrawals-admin-table />
                        </div>
                    </div>
                </div>

                <div class="pt-6">
                    <div class="max-w-full mx-auto sm:px-6 lg:px-8">
                        <h3 class="py-2">Подарочные коды</h3>
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 bg-white border-b border-gray-200">
                                <livewire:textarea-withdrawal-codes />
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if ($page === 'giveaways')
                <div class="max-w-full mx-auto pt-6 sm:px-6 lg:px-8">
                    <h3 class="py-2">История розыгрышей</h3>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <livewire:giveaways-history-table />
                        </div>
                    </div>
                </div>
            @endif

            @if ($page === 'stats')
                <div class="max-w-full mx-auto pt-6 sm:px-6 lg:px-8">
                    <h3 class="py-2">Статистика</h3>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <livewire:admin-stats />
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <!-- /.Withdrawals table -->


    {{-- <!-- Users table -->
    <div class="pb-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <h3 class="py-2">Пользователи</h3>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <livewire:users-table />
                </div>
            </div>
        </div>
    </div>
    <!-- /.Users table --> --}}


</x-app-layout>
<!-- /.Layout -->
