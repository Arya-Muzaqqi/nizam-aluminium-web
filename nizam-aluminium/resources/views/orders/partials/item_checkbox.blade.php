<div class="flex items-center justify-between p-2.5 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
    <div class="flex items-start gap-3 overflow-hidden">
        <input type="checkbox" name="items[{{ $item->id }}][selected]" value="1" data-id="{{ $item->id }}" data-price="{{ $item->harga_dasar }}" class="item-checkbox w-4 h-4 mt-1 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
        <div>
            <p class="text-sm font-semibold text-gray-800 truncate" title="{{ $item->nama_item }}">{{ $item->nama_item }}</p>
            <p class="text-[10px] text-gray-500">Rp {{ number_format($item->harga_dasar, 0, ',', '.') }} / {{ $item->satuan }}</p>
        </div>
    </div>
    
    <div class="w-20 flex-shrink-0">
        <input type="number" name="items[{{ $item->id }}][qty]" placeholder="Qty" min="0" step="0.1" class="item-qty w-full p-1.5 text-xs text-center border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 bg-white">
    </div>
</div>