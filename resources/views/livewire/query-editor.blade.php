<div class="w-full" x-data="{
    width: $el.offsetWidth,
}">
    {{-- In work, do what you enjoy. --}}
    <textarea
        @class([
            'w-full border-2 bg-white/5 rounded-lg py-2 px-4',
            'placeholder-gray-400 text-gray-200',
            'transition ease-in-out duration-200',
            'focus:outline-none',
            {{-- 'focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent', --}}
            'border-green-400/60' => ! $errors->has('query'),
            'border-red-500' => $errors->has('query'),
        ])
        wire:model.live.debounce="query"
        name="query"
        id="query"
        cols="30"
        rows="10"
        placeholder="Enter your SQL query here..."
    ></textarea>
    @error('query')
        <div class="text-red-500">{{ $message }}</div>
    @enderror

    @if ($results->isNotEmpty())
        <div class="mt-4 overflow-x-auto max-w-0" x-effect="$el.style.maxWidth = `${width}px`" >
            <div class="table divide-y divide-white/10 text-sm">
                {{-- Header --}}
                <div class="table-row w-full divide-x divide-white/10 transition duration-300 ease-in-out">
                    @foreach (collect($results[0])->keys() as $columnName)
                        <div
                            class="table-cell flex-1 text-xs text-gray-400  hover:bg-white/5 whitespace-nowrap min-w-max border-b border-white/10"
                        >
                            <button class="text-left px-3 py-2 w-full h-full" wire:click="setOrderBy('{{ $columnName }}')">
                                {{ $columnName }}
                                <span>
                                    @if ($orderBy == $columnName)
                                        @if ($direction == 'asc')
                                            &#9650;
                                        @else
                                            &#9660;
                                        @endif
                                    @endif
                                </span>
                            </button>
                        </div>
                    @endforeach
                </div>
                {{-- Rows --}}
                @foreach ($results as $row)
                    <div class="table-row w-full divide-x divide-white/10 transition duration-300 ease-in-out hover:bg-white/5">
                        @foreach ($row as $col => $value)
                            <div class="table-cell flex-1 text-gray-200 px-3 py-2 whitespace-nowrap min-w-max">{{ $value }}</div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div
