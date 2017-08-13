@extends('layouts.admin')
@section('styles')
    <link href="/css/admin/plugins/iCheck/custom.css" rel="stylesheet">
@endsection
@section('page_styles')
    <link href="/css/admin/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <div class="ibox-tools">
                        <h5>Posts</h5>
                        <a href="{{ route('posts.create') }}" class="btn btn-primary btn-xs">Add new</a>
                    </div>
                </div>
                <div class="ibox-content">
                    <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15">
                        <thead>
                        <tr>
                            <th></th>
                            <th>#</th>
                            <th data-hide="phone">Title</th>
                            <th data-hide="phone">Type</th>
                            <th data-hide="phone">Status</th>
                            <th class="text-right">Action</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($posts as $post)
                            <tr>
                                <td>
                                    <input type="checkbox" class="i-checks" name="input[]">
                                </td>
                                <td>
                                    {{$post->id}}
                                </td>
                                <td>
                                    {{$post->title}}
                                </td>
                                <td>
                                    {{$post->type}}
                                </td>
                                <td>
                                    <span class="label label-{{activeLabelClass($post->isPublished())}}">
                                        {{ activeLabelText($post->isPublished()) }}
                                    </span>
                                </td>
                                <td class="text-right">
                                    <div class="btn-group">
                                        <button class="btn-white btn btn-xs">
                                            <a href="{{ route('posts.edit', [ 'id' => $post->id ]) }}">
                                                Edit
                                            </a>
                                        </button>
                                        <button class="btn-white btn btn-xs">
                                            <a href="{{'/admin/posts/'.$post->id}}"
                                               data-token="{{csrf_token()}}"
                                               data-method="delete"
                                               data-confirm="Are you sure?">
                                                Delete
                                            </a>
                                        </button>
                                        <button class="btn-white btn btn-xs">
                                            <a href="{{ route('posts.articles', ['id' => $post->id]) }}">
                                                Articles
                                            </a>
                                        </button>
                                        <button class="btn-white btn btn-xs">
                                            <li class="dropdown">
                                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                                    Counts
                                                </a>
                                                @include('admin.includes._post_article_counts', ['post' => $post])
                                            </li>
                                        </button>
                                        <button class="btn-white btn btn-xs">
                                            <a href="{{ route('posts.edit', [ 'id' => $post->id ]) }}">
                                                Add Articles
                                            </a>
                                        </button>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="6">
                                {{ $posts->links() }}
                            </td>
                        </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>
    </div>
    @endsection
    @section('scripts')
            <!-- iCheck -->
    <script src="/js/admin/plugins/iCheck/icheck.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
        @include('admin.includes._toaster')
    </script>
    <script src="/js/admin/delete_item.js"></script>
@endsection