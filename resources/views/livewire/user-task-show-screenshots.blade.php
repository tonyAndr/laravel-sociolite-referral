<div>
    <button class="btn" wire:click="showProof">Пруфы</button>
    @if ($show_screens)
        @if (count($screenshots)) 
            @foreach ($screenshots as $k => $scr)
                <p wire:key="{{$k}}">
                    @if($service_nickname)
                        Никнейм: <strong>{{$service_nickname}}</strong>
                    @endif
                    <br>
                    <img class="max-w-84 max-h-120" src="{{Storage::url($scr)}}" />
                </p>
            @endforeach
        @else
            <p>Скриншотов нет </p>
        @endif
    @endif
</div>