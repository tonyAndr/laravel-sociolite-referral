<div>
    <button wire:click="delete({{ $rowData->id }})" wire:confirm="Are you sure you want to delete this row?"
        type="submit" class="btn btn-link">
        <i class="fa-solid fa-trash"></i>
    </button>
</div>
