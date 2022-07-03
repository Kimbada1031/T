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
                        <table class="p_table">
                            <th>제목</th>
                            <th>작성자</th>
                            <th>작성일</th>
                            <th>추천</th>
                        @forelse($posts as $post => $li)
                            <tr>
                                <td><a class="t_list" href="{{ route('show', $li->id) }}">{{ $li->title }}</a> ({{ $li->cnt }})</td>
                                <td>{{ $li->user_id }}</td>
                                <td>{{ $li->created_at }}</td>
                                <td>0</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">작성된 게시물이 없습니다.</td>
                            </tr>
                        @endforelse
                        </table>
                        <button class="basic_btn" type="button" onclick="location.href='{{ route('write') }}'">글쓰기</button>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
