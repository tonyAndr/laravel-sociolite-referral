<div>
    <button class="btn" wire:click="showProof">Пруфы</button>
    @if ($show_screens)
        @if (count($screenshots)) 
            @foreach ($screenshots as $k => $scr)
                <p wire:key="{{$k}}">
                    {{$scr}} <br>
                    <img src="{{Storage::url($scr)}}" />
                </p>
            @endforeach
        @else
            <p>Скриншотов нет</p>
        @endif
    @endif
</div>