<div class="bg-clip-border bg-center bg-no-repeat bg-cover bg-black"
style="background-image: url(/images/roblox_bg_2.png)">
    <div class="text-center font-bold text-white py-2 bg-black/70">Последние победители</div>
        <div class="relative flex overflow-x-hidden">
            <div class="py-6 animate-marquee whitespace-nowrap bg-black/70">
                @foreach($winners as $winner)
                <span class="text-xl mx-4 rounded-lg bg-green-200 p-4"><i class="fa-brands fa-telegram"></i> {{$winner['name']}} - <span class="">R${{$winner['reward']}}</span></span>
                @endforeach
            </div>
            <div class="absolute top-0 py-6 animate-marquee2 whitespace-nowrap bg-black/70">
                @foreach($winners as $winner)
                <span class="text-xl mx-4 rounded-lg bg-green-200 p-4"><i class="fa-brands fa-telegram"></i> {{$winner['name']}} - <span class="">R${{$winner['reward']}}</span></span>
                @endforeach
            </div>
    </div>
</div>