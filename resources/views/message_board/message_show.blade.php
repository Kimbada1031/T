<x-app-layout>
    <x-slot name="header">
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
                        @if($category == 1)
                        <button type="button" onclick="location.href='{{ route('post', 'coin') }}'">목록</button>
                        @elseif($category == 2)
                        <button type="button" onclick="location.href='{{ route('post', 'free') }}'">목록</button>
                        @endif
                        @if($posts->user_id == Auth::user()->email)
                            @csrf
                            <button type="button" onclick="location.href='{{ route('edit', $posts->id) }}'">수정</button>
                            <button type="button" onclick="location.href='{{ route('delete', $posts->id) }}'">삭제</button>
                        @endif
                    </div>
                    <div class="mt-6 text-gray-500 coin_dt">
                        <p>댓글</p>
                        @forelse($comments as $comment => $li)
                            <p>{{ $li->user_id }}  {{ $li->description }}  {{ $li->created_at }}
                                @if($li->user_id == Auth::user()->email)
                                <a href="#">수정</a><a href="{{ route('d_comment', $li->id) }}">삭제</a>
                                @else
                                <a href="#">신고</a>
                                @endif
                            </p>
                        @empty
                            <p>등록된 댓글이 없습니다.</p>
                        @endforelse
                        <form method="get" action="{{ route('comment') }}">
                        @csrf
                            <input name="post_id" type="hidden" value="{{ $posts->id }}">
                            <input name="description" type="text" placeholder="내용을 입력하세요."></input><button type="submit">등록</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>