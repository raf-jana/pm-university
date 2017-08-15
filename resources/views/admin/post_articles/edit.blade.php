@extends('layouts.admin')
@section('styles')
    <link href="/css/admin/plugins/summernote/summernote.css" rel="stylesheet">
    <link href="/css/admin/plugins/summernote/summernote-bs3.css" rel="stylesheet">
    <link href="/css/admin/plugins/chosen/bootstrap-chosen.css" rel="stylesheet">
    <style>
        .required:after {
            color: red;
            content: ' *';
        }
    </style>
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
                        <h5>Add An Article
                        </h5>
                        <a href="{{ route('posts.articles', ['postId' => $postId,'id' => $id]) }}"
                           class="btn btn-primary btn-xs">Back To
                            List</a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form action="{{ route('posts.articles.update', ['postId' => $postId,'id' => $id]) }}" method="post"
                          class="form-horizontal"
                          enctype="multipart/form-data">
                        {{ method_field('PUT') }}
                        {{ csrf_field() }}
                        <input type="hidden" name="post_id" value="{{ $postId }}"/>

                        <div class="form-group">
                            <label class="col-sm-2 control-label required">Type</label>

                            <div class="col-sm-10">
                                <select name="type" data-placeholder="Choose a Type..." class="chosen-select"
                                        tabindex="2">
                                    <option value="">Select</option>
                                    <option value="top-10" {{ (old("type", $article->type) === 'top-10' ? "selected":"") }}>
                                        Top-10
                                    </option>
                                    <option value="videos" {{ (old("type", $article->type) === 'videos' ? "selected":"") }}>
                                        Videos
                                    </option>
                                    <option value="books" {{ (old("type", $article->type) === 'books' ? "selected":"") }}>
                                        Books
                                    </option>
                                    <option value="interviews" {{ (old("type", $article->type) === 'interviews' ? "selected":"") }}>
                                        Interviews
                                    </option>
                                    <option value="tools" {{ (old("type", $article->type) === 'tools' ? "selected":"") }}>
                                        Tools
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"><label class="col-sm-2 control-label required">Title</label>

                            <div class="col-sm-10"><input name="title" type="text" class="form-control"
                                                          value="{{ old('title', $article->title) }}"></div>
                        </div>
                        <div class="form-group"><label class="col-sm-2 control-label required">Source URL</label>

                            <div class="col-sm-10"><input name="source_url" type="text" class="form-control"
                                                          value="{{ old('source_url', $article->source_url) }}"></div>
                        </div>
                        <div class="form-group"><label class="col-sm-2 control-label">Image</label>

                            <div class="col-sm-8">
                                @if($article->imageUrl())
                                    <img src="{{ $article->imageUrl() }}"><br/> <br/>
                                @endif
                                <input type="file" class="form-control" name="picture">
                            </div>
                        </div>

                        <div class="form-group"><label class="col-sm-2 control-label">Video URL</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="video_url"
                                       value="{{ old('video_url', $article->video_url) }}">
                            </div>
                        </div>
                        <div class="form-group"><label class="col-sm-2 control-label required">Description</label>

                            <div class="col-sm-10">
                                <textarea id="description" name="description">
                                    {{ old('description', $article->description) }}
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
            $('#description').summernote();
        });
    </script>
@endsection