@extends('layouts.admin')
@section('styles')
    <link href="/css/admin/plugins/iCheck/custom.css" rel="stylesheet">
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
                        <h5>Edit Placement</h5>
                        <a href="{{ route('placements') }}" class="btn btn-primary btn-xs">Back To List</a>
                        <a href="{{ route('placements.create') }}" class="btn btn-primary btn-xs">Add new</a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form action="{{ route('placements.update', ['id' => $placement->id]) }}" method="post"
                          class="form-horizontal"
                          enctype="multipart/form-data">
                        {{ method_field('PUT') }}
                        {{ csrf_field() }}
                        <div class="form-group"><label class="col-sm-2 control-label">Title</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="title"
                                       value="{{ old('title', $placement->title) }}">
                            </div>
                        </div>
                        <div class="form-group"><label class="col-sm-2 control-label">Summary</label>

                            <div class="col-sm-8">
                                <textarea class="form-control" name="summary">
                                   {!!  !!} old('summary', $placement->summary) }}
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group"><label class="col-sm-2 control-label">URL</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="link"
                                       value="{{ old('link', $placement->link) }}">
                            </div>
                        </div>
                        <div class="form-group"><label class="col-sm-2 control-label">Image</label>

                            <div class="col-sm-8">
                                @if($placement->imageUrl())
                                    <img src="{{ $placement->imageUrl() }}"><br/> <br/>
                                @endif
                                <input type="file" class="form-control" name="picture">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-white">
                                    <a href="{{route('placements')}}">
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