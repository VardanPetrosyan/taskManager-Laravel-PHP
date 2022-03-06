@extends('invoice._layouts.desc')
@section('page-name', $fill->name)
@section('styles')
    <style>
        .card .card-header .add {
            border-radius: 50%;
            width: 40px;
            padding: 0;
            height: 40px;
            text-align: center;
            line-height: 40px;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header card-header-rose card-header-icon d-flex justify-content-between align-items-center">
                        <div style="width: 200px;">
                            <div class="card-icon">
                                <i class="material-icons">assignment</i>
                            </div>
                            <h4 class="card-title">Fill</h4>
                        </div>
                        <div>
                            <div class="card-icon add" style="margin-right: -15px;">
                                <a href="{{ route('invoice.admin.desc_fill_dynamic_create', ['slug' => $fill->slug]) }}" class="text-white">
                                    <i class="material-icons">add</i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-response">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>From</th>
                                                <th>To</th>
                                                <th>Name</th>
                                                <th>Date</th>
                                                <th>Notes</th>
                                                <th>Image</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($datas as $i => $data)
                                                <tr>
                                                    <td>{{ ++$i }}</td>
                                                    @if($data->from_to == 'from')
                                                        <td>+{{ $data->amd }}</td>
                                                        <td></td>
                                                    @else
                                                        <td></td>
                                                        <td>-{{ $data->amd }}</td>
                                                    @endif
                                                    <td>{{ $data->names->name }}</td>
                                                    <td>{{ date_format(new DateTime($data->date), 'd/m/Y') }}</td>
                                                    <td>{{ str_limit($data->notes, 40) }}</td>
                                                    <td><a href="{{ asset('invoices/admin/desc/img/' . $data->image) }}" download>Download</a></td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8"><h3>No Data to show</h3></td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection