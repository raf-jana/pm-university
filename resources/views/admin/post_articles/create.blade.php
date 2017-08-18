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
                        <h5>Add A Post
                        </h5>
                        <a href="{{ route('posts.articles', ['id' => $id]) }}" class="btn btn-primary btn-xs">Back To
                            List</a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-12">
                            <form action="{{ route('posts.articles.store', ['id' => $id]) }}" method="post"
                                  class="form-horizontal"
                                  enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" name="post_id" value="{{ $id }}"/>

                                <div class="panel-options">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a data-toggle="tab" href="#tab-1">Main</a></li>
                                        <li class=""><a data-toggle="tab" href="#tab-2">Author</a></li>
                                    </ul>
                                </div>
                                <div class="panel-body">
                                    <div class="tab-content">
                                        <div id="tab-1" class="tab-pane active">
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label required">Type</label>

                                                <div class="col-sm-10">
                                                    <select name="type" data-placeholder="Choose a Type..."
                                                            class="chosen-select"
                                                            tabindex="2">
                                                        <option value="">Select Type</option>
                                                        <option value="latest" {{ (old("type") === 'latest' ? "selected":"") }}>
                                                            Latest
                                                        </option>
                                                        <option value="top-10" {{ (old("type") === 'top-10' ? "selected":"") }}>
                                                            Top-10
                                                        </option>
                                                        <option value="videos" {{ (old("type") === 'videos' ? "selected":"") }}>
                                                            Videos
                                                        </option>
                                                        <option value="books" {{ (old("type") === 'books' ? "selected":"") }}>
                                                            Books
                                                        </option>
                                                        <option value="interviews" {{ (old("type") === 'interviews' ? "selected":"") }}>
                                                            Interviews
                                                        </option>
                                                        <option value="tools" {{ (old("type") === 'tools' ? "selected":"") }}>
                                                            Tools
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group"><label
                                                        class="col-sm-2 control-label required">Title</label>

                                                <div class="col-sm-10"><input name="title" type="text"
                                                                              class="form-control"
                                                                              value="{{ old('title') }}"></div>
                                            </div>
                                            <div class="form-group"><label class="col-sm-2 control-label required">Source
                                                    URL</label>

                                                <div class="col-sm-10"><input name="source_url" type="text"
                                                                              class="form-control"
                                                                              value="{{ old('source_url') }}"></div>
                                            </div>
                                            <div class="form-group"><label class="col-sm-2 control-label">Image</label>

                                                <div class="col-sm-8">
                                                    <input type="file" class="form-control" name="picture">
                                                </div>
                                            </div>

                                            <div class="form-group"><label class="col-sm-2 control-label">Video
                                                    URL</label>

                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="video_url"
                                                           value="{{ old('video_url') }}">
                                                </div>
                                            </div>
                                            <div class="form-group"><label
                                                        class="col-sm-2 control-label required">Sequence</label>

                                                <div class="col-sm-1">
                                                    <input type="text" class="form-control" name="sequence"
                                                           value="{{ old('sequence') }}">
                                                </div>
                                            </div>
                                            <div class="form-group"><label
                                                        class="col-sm-2 control-label required">Description</label>

                                                <div class="col-sm-10">
                                        <textarea id="description"
                                                  name="description">{{ old('description') }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="tab-2" class="tab-pane">
                                            <div class="form-group"><label
                                                        class="col-sm-2 control-label required">Name</label>

                                                <div class="col-sm-10"><input name="author_name" type="text"
                                                                              class="form-control"
                                                                              value="{{ old('author_name') }}"></div>
                                            </div>
                                            <div class="form-group"><label
                                                        class="col-sm-2 control-label required">Organization</label>

                                                <div class="col-sm-10"><input name="author_organization" type="text"
                                                                              class="form-control"
                                                                              value="{{ old('author_organization') }}">
                                                </div>
                                            </div>
                                            <div class="form-group"><label
                                                        class="col-sm-2 control-label required">Designation</label>

                                                <div class="col-sm-10"><input name="author_designation" type="text"
                                                                              class="form-control"
                                                                              value="{{ old('author_designation') }}">
                                                </div>
                                            </div>
                                            <div class="form-group"><label
                                                        class="col-sm-2 control-label required">Location</label>

                                                <div class="col-sm-10"><input name="author_location" type="text"
                                                                              class="form-control"
                                                                              value="{{ old('author_location') }}">
                                                </div>
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
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
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