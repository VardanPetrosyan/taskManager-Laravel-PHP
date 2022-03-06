@extends('invoice._layouts.admin')
@section('page-name', 'Currency')
@section('styles')
    <style>
        .bootstrap-tagsinput input {
            width: 100%;
            border-bottom: 1px solid #9c27b0;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <form action="{{ route('invoice.admin.currency_store') }}" method="POST">
                    @csrf
                    <div class="card">
                        <div class="card-header card-header-{{ $sidebar->filters }} card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">local_offer</i>
                            </div>
                            <h4 class="card-title">Currency</h4>
                        </div>
                        <div class="card-body">
                            <div class="bootstrap-tagsinput info-badge">
                                @forelse($currencies as $currency)
                                    <span class="tag badge">{{ $currency->name }}
                                        <span data-role="remove" data-id="{{ $currency->id }}" class="remove"></span>
                                    </span>
                                @empty
                                    <h3>No currency to show</h3>
                                @endforelse
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <span class="bmd-form-group is-filled">
                                        <input type="text" name="currency" class="form-control tagsinput" data-role="tagsinput" data-color="info">
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end">
                            <button type="submit" class="btn btn-{{ $sidebar->filters }}">Create</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>

    <input type="hidden" id="route" value="{{ route('invoice.admin.currency_delete', ['id' => '#ID#']) }}">
@endsection

@section('scripts')
    <script src="{{ asset('invoices/admin/js/myScript.js') }}"></script>
@endsection