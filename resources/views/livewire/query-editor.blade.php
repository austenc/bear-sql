<div>
    {{-- In work, do what you enjoy. --}}
    <textarea
        @class([
            'w-full border-4 bg-white/5 rounded-lg py-2 px-4',
            'placeholder-gray-400 text-gray-200',
            'transition ease-in-out duration-200',
            {{-- 'focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent', --}}
            'border-green-400' => ! $errors->has('query'),
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
        <div class="mt-4 overflow-x-auto max-w-[500px]">
            <div class="table divide-y divide-white/10 text-sm">
                {{-- Header --}}
                <div class="table-row w-full divide-x divide-white/10 transition duration-300 ease-in-out hover:bg-white/5">
                    @foreach (collect($results[0])->keys() as $columnName)
                        <div class="table-cell flex-1 text-gray-200 px-3 py-2 whitespace-nowrap min-w-max">{{ $columnName }}</div>
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
