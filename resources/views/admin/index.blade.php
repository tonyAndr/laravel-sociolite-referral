<!-- Layout -->
@php
    // dd($users);
@endphp

<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Панель администратора') }}
        </h2>
    </x-slot>

    <!-- Withdrawals table -->
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <h3 class="py-2">Заявки на вывод</h3>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <livewire:withdrawals-admin-table />
                </div>
            </div>
        </div>
    </div>
    <!-- /.Withdrawals table -->

    <!-- Users table -->
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
    <!-- /.Users table -->


</x-app-layout>
<!-- /.Layout -->
