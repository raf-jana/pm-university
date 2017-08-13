@extends('layouts.admin')
@section('styles')
        <!-- FooTable -->
<link href="/css/admin/plugins/footable/footable.core.css" rel="stylesheet">
@endsection
@section('page_styles')
    <link href="/css/admin/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <div class="ibox-tools">
                        <h5>Halls Of Knowledge List</h5>
                        <a href="{{ route('hok.create') }}" class="btn btn-primary btn-xs">Add new</a>
                    </div>
                </div>
                <div class="ibox-content">

                    <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th data-hide="phone">Title</th>
                            <th data-hide="phone">URL</th>
                            <th data-hide="phone">Posted on</th>
                            <th data-hide="phone">Status</th>
                            <th class="text-right">Action</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($hoks as $hok)
                            <tr>
                                <td>
                                    {{$hok->id}}
                                </td>
                                <td>
                                    {{$hok->title}}
                                </td>
                                <td>
                                    {{$hok->link}}
                                </td>
                                <td>
                                    {{$hok->created_at}}
                                </td>
                                <td>
                                    <span class="label label-{{activeLabelClass($hok->isPublished())}}">
                                        {{ activeLabelText($hok->isPublished()) }}
                                    </span>
                                </td>
                                <td class="text-right">
                                    <div class="btn-group">
                                        <button class="btn-white btn btn-xs">
                                            <a href="{{ route('hok.edit', [ 'id' => $hok->id ]) }}">
                                                Edit
                                            </a>
                                        </button>
                                        <button class="btn-white btn btn-xs">
                                            <a href="{{'/admin/hok/'.$hok->id}}"
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
                            <td colspan="6">
                                <ul class="pagination pull-right"></ul>
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
            <!-- Data picker -->
    <script src="/js/admin/plugins/datapicker/bootstrap-datepicker.js"></script>
    <!-- FooTable -->
    <script src="/js/admin/plugins/footable/footable.all.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.footable').footable();
        });
        @include('admin.includes._toaster')
    </script>
    <script src="/js/admin/delete_item.js"></script>
@endsection