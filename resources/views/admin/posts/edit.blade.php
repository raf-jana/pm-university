@extends('layouts.admin')
@section('styles')
    <link href="/css/admin/plugins/summernote/summernote.css" rel="stylesheet">
    <link href="/css/admin/plugins/summernote/summernote-bs3.css" rel="stylesheet">
    <link href="/css/admin/plugins/chosen/bootstrap-chosen.css" rel="stylesheet">
@endsection
@section('content')
    @if (count($errors) > 0)
        <div class="ibox-content m-b-sm border-bottom">
            <div class="row">
                @include('admin.includes._errors', ['errors' => $errors])
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <div class="ibox-tools">
                        <h5>Edit A Post
                        </h5>
                        <a href="{{ route('posts') }}" class="btn btn-primary btn-xs">Back To List</a>
                        <a href="{{ route('posts.create') }}" class="btn btn-primary btn-xs">Add A Post</a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form action="{{ route('posts.update', ['id' => $post->id]) }}" method="post"
                          class="form-horizontal"
                          enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="form-group">
                            <label class="col-sm-2 control-label required">Type</label>

                            <div class="col-sm-10">
                                <select name="type" data-placeholder="Choose a Type..." class="chosen-select"
                                        tabindex="2">
                                    @include('admin.posts._type_select_tag_options', ['type' => old('type', $post->type)])
                                </select>
                            </div>
                        </div>
                        <div class="form-group"><label class="col-sm-2 control-label required">Title</label>

                            <div class="col-sm-10"><input name="title" type="text" class="form-control"
                                                          value="{{ old('title', $post->title) }}"></div>
                        </div>
                        <div class="form-group"><label class="col-sm-2 control-label required">Summary</label>

                            <div class="col-sm-10">
                                <textarea class="form-control"
                                          name="summary">{{old('summary', $post->summary)}}</textarea>
                            </div>
                        </div>
                        <div class="form-group"><label class="col-sm-2 control-label">Image</label>

                            <div class="col-sm-8">
                                @if($post->imageUrl())
                                    <img src="{{ $post->imageUrl() }}"><br/> <br/>
                                @endif
                                <input type="file" class="form-control" name="picture">
                            </div>
                        </div>

                        <div class="form-group"><label class="col-sm-2 control-label required">Note Title</label>

                            <div class="col-sm-10"><input type="text" class="form-control" name="note_title"
                                                          placeholder="Note title"
                                                          value="{{ old('note_title', $post->note_title) }}">
                            </div>
                        </div>
                        <div class="form-group"><label class="col-sm-2 control-label required">Note Description:</label>

                            <div class="col-sm-10">
                                <textarea id="note_description" name="note_description">
                                    {{ old('note_description', $post->note_description) }}
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-white">
                                    <a href="{{route('posts')}}">
                                        Cancel
                                    </a>
                                </button>
                                <button class="btn btn-primary" type="submit">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection
    @section('scripts')
            <!-- Chosen -->
    <script src="/js/admin/plugins/chosen/chosen.jquery.js"></script>
    <!-- SUMMERNOTE -->
    <script src="/js/admin/plugins/summernote/summernote.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.chosen-select').chosen({width: "100%"});
            $('#note_description').summernote();
        });
    </script>
@endsection