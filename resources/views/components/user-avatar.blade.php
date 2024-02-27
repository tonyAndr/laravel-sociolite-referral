@if(Auth::user()->avatar_url)
    <div class="h-10 w-10 mr-3">
        <img class="rounded-full" src="{{Auth::user()->avatar_url}}"/>
    </div>
@endif