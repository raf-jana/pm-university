@extends('layouts.admin')
@section('styles')
    <link href="/css/admin/plugins/iCheck/custom.css" rel="stylesheet">
@endsection
@section('page_styles')
    <link href="/css/admin/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="/css/admin/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
    <link href="/css/admin/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Post Filters</h5>

                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content text-center">
                    <form action="{{ route('posts') }}" method="get">
                        <div class="row">
                            <div class="col-sm-4 m-b-xs">
                                <select class="input-md  form-control input-s-sm inline" name="type">
                                    @include('admin.posts._type_select_tag_options', ['type' => request('type')])
                                </select>
                            </div>
                            <div class="col-sm-4 m-b-xs">
                                <select class="input-md  form-control input-s-sm inline" name="status">
                                    <option value="">Select Status</option>
                                    <option value="1" {{ request('status') === '1' ? "selected":"" }}>Disabled</option>
                                    <option value="2" {{ request('status') === '2' ? "selected":"" }}>Enabled</option>
                                </select>
                            </div>
                            <div class="col-sm-4 m-b-xs" id="data_5">
                                <div class="input-daterange input-group" id="datepicker">
                                    <input type="text" class="input-sm form-control" name="start_date"
                                           value="{{ request('start_date', $oldestPost->postedDate()) }}"/>
                                    <span class="input-group-addon">to</span>
                                    <input type="text" class="input-sm form-control" name="end_date"
                                           value="{{request('end_date', $latestPost->postedDate()) }}"/>
                                </div>
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-sm-4">
                                <div class="input-group">
                                    @include('admin.includes._input_search_box')
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <a class="btn btn-md btn-default" href="{{ route('posts') }}"
                                   style="float: left;background-color: #e7eaec;">
                                    Reset</a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <form method="post" id="post_form" action="{{ route('posts.actions') }}">
                {{ csrf_field() }}
                <div class="ibox">
                    <div class="ibox-title">
                        <div class="ibox-tools">
                            <h5>Posts</h5>

                            <div class="ibox-tools">
                                <a href="{{ route('posts.create') }}" class="btn btn-rounded btn-primary btn-sm"
                                   type="button" title="Add New Post"><i
                                            class="fa fa-plus-circle"></i>
                                </a>
                                <button class="btn btn-rounded btn-warning btn-sm" type="button" title="Publish"
                                        onclick="post_action('publish');"><i class="fa fa-globe"></i> Publish
                                </button>
                                <button class="btn btn-rounded btn-alert btn-sm" type="button" title="Unpublish"
                                        onclick="post_action('unpublish');"><i class="fa fa-globe"></i> Unpublish
                                </button>
                                <button class="btn btn-rounded btn-danger btn-sm" type="button"
                                        onclick="post_action('delete');"><i
                                            class="fa fa-trash"></i> Delete
                                </button>
                                <input type="hidden" name="action_type" id="action_type">
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content table-responsive">
                        @include('admin.includes._records_count_bs_alert', ['total' => $totalPosts, 'btn_class' => $totalPosts > 0 ? 'info' : 'danger'])
                        @if($totalPosts > 0)
                            <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15">
                                <thead>
                                <tr>
                                    <th style="width:5%;"><input type="checkbox" id="check_all" class="i-checks"/>
                                    </th>
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
                                            <input type="checkbox" class="check i-checks" name="post_ids[]"
                                                   id="post_{{ $post->id }}" value="{{ $post->id }}">
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
                                                <button data-toggle="dropdown"
                                                        class="btn btn-warning btn-sm dropdown-toggle">Options <span
                                                            class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a href="{{ url($post->slug) }}" target="_blank"><i
                                                                    class="fa fa-eye"></i> View</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('posts.edit', [ 'id' => $post->id ]) }}">
                                                            <i
                                                                    class="fa fa-pencil"></i>
                                                            Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{'/admin/posts/'.$post->id}}"
                                                           data-token="{{csrf_token()}}"
                                                           data-method="delete"
                                                           data-confirm="Are you sure?">
                                                            <i class="fa fa-trash"></i>
                                                            Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="btn-group">
                                                <button data-toggle="dropdown"
                                                        class="btn btn-warning btn-sm dropdown-toggle">Counts <span
                                                            class="caret"></span>
                                                </button>
                                                @include('admin.includes._post_article_counts', ['post' => $post])
                                            </div>
                                            <div class="btn-group">
                                                <button data-toggle="dropdown"
                                                        class="btn btn-warning btn-sm dropdown-toggle">Articles <span
                                                            class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a href="{{ route('posts.articles', ['id' => $post->id]) }}"><i
                                                                    class="fa fa-list"></i> List</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('posts.articles.create', [ 'id' => $post->id ]) }}"
                                                           target="_blank"><i
                                                                    class="fa fa-plus"></i> Add Article</a>
                                                    </li>
                                                </ul>
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
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endsection
    @section('scripts')
            <!-- Data picker -->
    <script src="/js/admin/plugins/datapicker/bootstrap-datepicker.js"></script>
    <!-- iCheck -->
    <script src="/js/admin/plugins/iCheck/icheck.min.js"></script>
    <!-- Date range picker -->
    <script src="/js/admin/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="/js/admin/checkbox_bulk_actions.js"></script>
    <script>
        $(document).ready(function () {
            $('#data_5 .input-daterange').datepicker({
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                format: "yyyy-mm-dd"
            });
        });
        @include('admin.includes._toaster')
    </script>
    <script src="/js/admin/post_bulk_actions.js"></script>
    <script src="/js/admin/delete_item.js"></script>
@endsection