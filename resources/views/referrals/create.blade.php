<!-- Layout -->
<x-app-layout>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Refer something') }}
        </h2>
    </x-slot>
    
    <!-- Referral form widget -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="referral-form">
                        <h2>Enter email</h2>
                        <!-- Referral form -->
                        <form action="{{ route('referrals') }}" method="POST">
                            <div class="form-group">
                                <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" required>
                                <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                            </div>
                            <button type="submit" class="button">Send</button>
                            @csrf
                        </form>
                        <!-- /.Referral form -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.Referral form widget -->
    
</x-app-layout>
<!-- /.Layout -->