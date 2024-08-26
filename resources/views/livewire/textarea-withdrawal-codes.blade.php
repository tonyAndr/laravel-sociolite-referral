<div>
    <form wire:submit="save">
        <p>Осталось кодов: {{$num_left}}</p>
        
        <textarea wire:model="codes" class="textarea textarea-accent w-full" rows="10" placeholder="FSFE-EFSEF-65hsES-44fwfs"></textarea>
     
        <button class="btn btn-accent" type="submit">Обновить</button>
    </form>
</div>