<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if($category == "coin")
                코인 게시판
            @elseif($category == "free")
                자유 게시판
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    글 목록
                    <div class="mt-6 text-gray-500 coin_dt">
                        @forelse($posts as $post => $li)
                            <p><a href="{{ route('show', $li->id) }}">{{ $li->title }}</a></p>
                        @empty
                            <p>작성된 게시물이 없습니다.</p>
                        @endforelse
                    </div>
                    <div class="coin_price text-2xl">
                        <button type="button" onclick="location.href='{{ route('write') }}'">글쓰기</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
