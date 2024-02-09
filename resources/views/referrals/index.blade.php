<!-- Layout -->
<x-app-layout>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Referral list') }}
        </h2>
    </x-slot>

    <!-- Referral list widget -->   
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <p>
                        Пригласи друзей и получай % от каждого заработанного ими робукса! {{ Auth::user()->id }} 
                    </p>
                    <!--
                    Heads up! 👋

                    Plugins:
                        - @tailwindcss/forms
                    -->

                    <div>
                        <label for="OrderNotes" class="sr-only">Order notes</label>
                    
                        <div
                        class="overflow-hidden rounded-lg border border-gray-200 shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600"
                        >
                        <textarea
                            id="OrderNotes"
                            class="w-full resize-none border-none align-top focus:ring-0 sm:text-sm"
                            rows="1"
                            placeholder="Enter any additional order notes..."
                            disabled
                        >{!! route('register').'?referral='.Auth::user()->id !!}</textarea>
                    
                        <div class="flex items-center justify-end gap-2 bg-white p-3">
                            <button
                            type="button"
                            class="rounded bg-indigo-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-indigo-700"
                            >
                            Копировать
                            </button>
                        </div>
                        </div>
                    </div>

                    {!! ShareButtons::page('https://site.com', 'Присоединяйся и получай робуксы!', [
                        'title' => 'Присоединяйся и получай робуксы!',
                        'rel' => 'nofollow noopener noreferrer',
                    ])
                    ->telegram()
                    ->whatsapp()
                    ->vkontakte()
                    ->copylink()
                    ->mailto()
                    ->render(); !!}

                    <p>
                        У нас действует двух-уровневая система пришлашений. Приглашенные первого уровня будут приносить вам 10% при получении робуксов, а второго уровня (кого пригласили ваши приглашенные) - 1%.
                    </p>
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Referral list -->
                    <div class="referral-list">
                        <h2>List of referrals</h2>
                        @if($referrals->count())
                        <table>
                            <tr>
                                <th>Email</th>
                                <th>Date</th>
                                <th>Completed</th>
                            </tr>
                            @foreach($referrals as $referral)
                            <tr>
                                <td>{{ $referral->email }}</td>
                                <td>{{ $referral->created_at->toDateString() }}</td>
                                <td>
                                    @if ($referral->completed)
                                        Yes
                                    @else
                                        No <a href="{{ route('index', ['referral' => $referral->token]) }}" target="_blank">Get a link</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </table>
                        @else
                            <p>There is no referrals</p>
                        @endif
                    </div>
                    <!-- /.Referral list -->
                </div>
            </div>
        </div>
    </div>
    <!-- /.Referral list widget -->

</x-app-layout>
<!-- /.Layout -->