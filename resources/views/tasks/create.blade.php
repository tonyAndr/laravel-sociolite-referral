<!-- Layout -->
<x-app-layout>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Задания') }}
        </h2>
    </x-slot>
    
    <!-- Referral form widget -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex items-center justify-center h-screen w-screen">
                        <button x-data
                            @click="$dispatch('notice', {type: 'success', text: '🔥 Success!'})"
                            class="m-4 bg-green-500 text-lg font-bold p-6 py-2 text-white shadow-md rounded">
                            Success
                        </button>
                        <button x-data
                            @click="$dispatch('notice', {type: 'info', text: 'ᕦ(ò_óˇ)ᕤ'})"
                            class="m-4 bg-blue-500 text-lg font-bold p-6 py-2 text-white shadow-md rounded">
                            Info
                        </button>
                        <button x-data
                            @click="$dispatch('notice', {type: 'warning', text: '⚡ Warning'})"
                            class="m-4 bg-orange-500 text-lg font-bold p-6 py-2 text-white shadow-md rounded">
                            Warning
                        </button>
                        <button x-data
                            x-on:click="$dispatch('notice', {type: 'error', text: '😵 Error!'})"
                            class="m-4 bg-red-500 text-lg font-bold p-6 py-2 text-white shadow-md rounded">
                            Error
                        </button>
                    </div>
                    
                    
                    
                </div>
            </div>
        </div>
    </div>
    <!-- /.Referral form widget -->
    
</x-app-layout>
<!-- /.Layout -->
