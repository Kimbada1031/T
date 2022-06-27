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
                            <p id="comment">{{ $li->user_id }} {{ $li->description }} {{ $li->created_at }}
                                @if($li->user_id == Auth::user()->email)
                                    <a onclick="commentEdit(this);">수정</a><a href="{{ route('d_comment', $li->id) }}">삭제</a>
                                @else
                                        <a href="#">신고</a>
                                @endif
                            </p>
                            <form method="get" action="{{ route('u_comment', $li->id) }}">
                                <p id="edit_comment" style="display:none;">
                                {{ $li->user_id }}<input name="description" type="text" value="{{ $li->description }}"></input>{{ $li->created_at }}
                                    <button type="submit">수정</button><a onclick="cancel(this)">취소</a>
                                </p>
                            </form>
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

<script>
    function commentEdit(e_comment) {
        var cmt = e_comment.parentNode;
        var ecmt = e_comment.parentNode.nextSibling.nextSibling.childNodes[1];
        cmt.style.display="none";
        ecmt.style.display="block";
    }
    function cancel(e_comment) {
        var cmt = e_comment.parentNode.parentNode.previousSibling.previousSibling;
        var ecmt = e_comment.parentNode;
        cmt.style.display="block";
        ecmt.style.display="none";
    }
</script>

