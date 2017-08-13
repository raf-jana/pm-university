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
                        <a href="{{ route('posts') }}" class="btn btn-primary btn-xs">List</a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form action="{{ route('posts.store') }}" method="post" class="form-horizontal"
                          enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Type:</label>

                            <div class="col-sm-10">
                                <select name="type" data-placeholder="Choose a Type..." class="chosen-select"
                                        tabindex="2">
                                    <option value="">Select</option>
                                    <option value="bachelore" {{ (old("type") == 'bachelore' ? "selected":"") }}>Bachelore
                                    </option>
                                    <option value="master" {{ (old("type") == 'master' ? "selected":"") }}>Master</option>
                                    <option value="specialization" {{ (old("type") == 'specialization' ? "selected":"") }}>
                                        Specialization
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"><label class="col-sm-2 control-label">Title:</label>

                            <div class="col-sm-10"><input name="title" type="text" class="form-control"
                                                          value="{{ old('title') }}"></div>
                        </div>
                        <div class="form-group"><label class="col-sm-2 control-label">Summary</label>

                            <div class="col-sm-10">
                        <textarea class="form-control" name="summary">
                            {{ old('summary') }}
                        </textarea>
                            </div>
                        </div>
                        <div class="form-group"><label class="col-sm-2 control-label">Image</label>

                            <div class="col-sm-8">
                                <input type="file" class="form-control" name="picture">
                            </div>
                        </div>

                        <div class="form-group"><label class="col-sm-2 control-label">Note Title:</label>

                            <div class="col-sm-10"><input type="text" class="form-control" name="note_title"
                                                          placeholder="Note title" value="{{ old('note_title') }}">
                            </div>
                        </div>
                        <div class="form-group"><label class="col-sm-2 control-label">Note Description:</label>

                            <div class="col-sm-10">
                                <textarea id="note_description" name="note_description">
                                    {{ old('note_description') }}
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