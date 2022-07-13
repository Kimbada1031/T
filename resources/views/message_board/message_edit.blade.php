@section('custom_script')
<script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>
<script src="{{ asset('js/ck.upload.adapter.js') }}"></script>
@endsection

@section('custom_css')
<style type="text/css">
    /* 에디터 세로높이 (ckeditor5 에서는 높이 조절 핸들러를 제공하지 않는듯 한다 */
    .ck-editor__editable_inline {
        min-height: 400px;
    }
</style>
@endsection

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
                    <div class="p_title">글 수정</div>
                    <div class="coin_price text-2xl">
                        <form method="post" action="{{ route('update', $posts->id) }}">
                            @csrf
                            <div>
                                <select name="category">
                                    <option value="1" @if($posts->category == 1) selected @endif>코인</option>
                                    <option value="2" @if($posts->category == 2) selected @endif>자유</option>
                                </select>
                                <input class="title_box" name="title" type="text" value="{{ $posts->title }}"></input>
                            </div>
                            <br>
                            <textarea id="description" name="description">{!! $posts->description !!}</textarea>
                            <br>
                            <div class="coin_price text-2xl">
                                @if($posts->user_id == Auth::user()->email)
                                    <input class="basic_btn" type="submit" value="수정">
                                    <button class="basic_btn" type="button" onclick="history.back()">취소</button>
                                @else
                                    <button class="basic_btn" type="button" onclick="location.href='{{ route('write') }}'">목록</button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @section('write_js')
    <script>
        function MyCustomUploadAdapterPlugin(editor) {
            editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                return new UploadAdapter(loader);
            };
        }
        
        ClassicEditor
            .create(document.querySelector('#description'), {
                extraPlugins: [MyCustomUploadAdapterPlugin],
            }).then(editor => {
                console.log(editor);
            }).catch(error => {
                console.error(error);
            });
    </script>
    @endsection
</x-app-layout>
