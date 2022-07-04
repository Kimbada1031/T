<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            코인 게시판
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="p_title">
                        글 작성
                    </div>
                    <div class="coin_price text-2xl">
                        <form action="{{ route('write_post') }}" method="post" id="post_form">
                            @csrf
                            <!-- 카테고리 1:코인 2:자유 게시판 -->
                            <div>
                                <select name="category">
                                    <option>카테고리</option>
                                    <option value="1">코인</option>
                                    <option value="2">자유</option>
                                </select>
                                <input class="title_box" name="title" type="text" placeholder="제목을 입력해주세요."></input>
                            </div>
                                <br>
                            <textarea class="description_box" name="description"></textarea>
                            <br>
                            <input class="basic_btn" type="submit" value="저장"></input>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
