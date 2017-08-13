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
                        <a href="#" class="btn btn-primary btn-xs">Add new</a>
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
                            <th data-hide="phone">Posted On</th>
                            <th data-hide="phone">Status</th>
                            <th class="text-right">Action</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($articles as $article)
                            <tr>
                                <td>
                                    <input type="checkbox" class="i-checks" name="input[]">
                                </td>
                                <td>
                                    {{$article->id}}
                                </td>
                                <td>
                                    {{$article->title}}
                                </td>
                                <td>
                                    {{$article->type}}
                                </td>
                                <td>
                                    {{$article->published_at}}
                                </td>
                                <td>
                                    <span class="label label-{{activeLabelClass($article->isPublished())}}">
                                        {{ activeLabelText($article->isPublished()) }}
                                    </span>
                                </td>
                                <td class="text-right">
                                    <div class="btn-group">
                                        <button class="btn-white btn btn-xs">
                                            <a href="{{ route('posts.articles.edit', [ 'id' => $article->id ]) }}">
                                                Edit
                                            </a>
                                        </button>
                                        <button class="btn-white btn btn-xs">
                                            <a href="{{'/admin/articles/'.$article->id}}"
                                               data-token="{{csrf_token()}}"
                                               data-method="delete"
                                               data-confirm="Are you sure?">
                                                Delete
                                            </a>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="7">
                                {{ $articles->links() }}
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