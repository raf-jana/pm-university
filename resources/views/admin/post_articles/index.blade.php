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
                    <h5>Article Filters</h5>

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
                    <form action="{{ route('posts.articles', ['id' => $id]) }}" method="get">
                        <div class="row">
                            <div class="col-sm-4 m-b-xs">
                                @include('admin.includes._post_article_type_select_tag', ['type' => request('type')])
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
                                           placeholder="From date" value="{{ request('start_date') }}"/>
                                    <span class="input-group-addon">to</span>
                                    <input type="text" class="input-sm form-control" name="end_date"
                                           placeholder="To date" value="{{request('end_date') }}"/>
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
                                <a class="btn btn-md btn-default" href="{{ route('posts.articles', ['id' => $id]) }}"
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
            <form method="post" id="article_form" action="{{ route('posts.articles.actions') }}">
                {{ csrf_field() }}
                <div class="ibox">
                    <div class="ibox-title">
                        <div class="ibox-tools">
                            <h5>Articles</h5>
                            {{--<a href="{{ route('posts.articles.create', ['id' => $id]) }}" class="btn btn-primary btn-xs">Add
                                new</a>--}}
                            <a href="{{ route('posts.articles.create', ['id' => $id]) }}"
                               class="btn btn-rounded btn-primary btn-sm"
                               type="button"><i
                                        class="fa fa-plus-circle"></i> Add New Article
                            </a>
                            <button class="btn btn-rounded btn-warning btn-sm" type="button"
                                    onclick="article_action('publish');"><i class="fa fa-globe"></i> Publish
                            </button>
                            <button class="btn btn-rounded btn-danger btn-sm" type="button"
                                    onclick="article_action('delete');"><i
                                        class="fa fa-trash"></i> Delete
                            </button>
                            <input type="hidden" name="action_type" id="action_type">
                            <input type="hidden" name="post_id" value="{{ $id }}">
                        </div>
                    </div>
                    <div class="ibox-content">
                        @include('admin.includes._records_count_bs_alert', ['total' => $totalArticles, 'btn_class' => $totalArticles > 0 ? 'info' : 'danger'])
                        @if($totalArticles > 0)
                            <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15">
                                <thead>
                                <tr>
                                    <th style="width:5%;"><input type="checkbox" id="check_all" class="i-checks"/>
                                    </th>
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
                                            <input type="checkbox" class="check i-checks" name="article_ids[]"
                                                   id="article_{{ $article->id }}" value="{{ $article->id }}">
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
                                            {{$article->postedDate()}}
                                        </td>
                                        <td>
                                    <span class="label label-{{activeLabelClass($article->isPublished())}}">
                                        {{ activeLabelText($article->isPublished()) }}
                                    </span>
                                        </td>
                                        <td class="text-right">
                                            <div class="btn-group">
                                                <button class="btn-white btn btn-xs">
                                                    <a href="{{ route('posts.articles.edit', [ 'postId' => $article->post_id,'id' => $article->id ]) }}">
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
    <script src="/js/admin/article_bulk_actions.js"></script>
    <script src="/js/admin/delete_item.js"></script>
@endsection