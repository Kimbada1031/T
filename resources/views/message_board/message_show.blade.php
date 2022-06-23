

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if($category == 1)
                코인 게시판
            @elseif($category == 2)
                자유 게시판
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    {{ $posts->title }} 
                    <div class="mt-6 text-gray-500 coin_dt">
                            <p>{{ $posts->description }}</p>
                    </div>
                    <div class="coin_price text-2xl">
                        @if($posts->user_id == Auth::user()->email)
                        @csrf
                            <button type="button" onclick="location.href='{{ route('edit', $posts->id) }}'">수정</button>
                            <button type="button" onclick="location.href='{{ route('delete', $posts->id) }}'">삭제</button>
                        @else
                            <button type="button" onclick="location.href='{{ route('write') }}'">목록</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
