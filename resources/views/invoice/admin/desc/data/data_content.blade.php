<table class="table">
    <thead>
        <tr>
            <th class="text-center">#</th>
            <th class="text-center">Name</th>
            @if($field->add_prop)
            <th class="text-center">{{$field->add_prop}}</th>
            @endif
            <th class="text-center">Date</th>
            <th class="text-center">Counter Number</th>
            <th class="text-center">Unit Price</th>
            <th class="text-center">Total Payment</th>
            <th class="text-center">Paid</th>
            <th class="text-center">Debt</th>
            <th class="text-center">Pay</th>
            <th class="text-center" width="40">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($datas as $i => $data)
            <tr class='data' id="data{{ $data->id }}">
                <td class="index text-center">{{ ($datas->currentPage()-1)*$datas->perPage()+(++$i) }}</td>
                <td class="text-center">{{ $data->dataName->name }}</td>
                @if($field->add_prop)
                <td class="text-center">{{ $data->addPropName->name}}</td>
                @endif
                <td class="text-center">{{ $data->date }}</td>
                <td class="text-center">{{ $data->counter_number}} {{$field->unit}}</td>
                <td class="text-center">{{ $data->unit_price }}</td>
                <td class="text-center">{{ $data->total_payment }}</td>
                <td class="text-center data_paid text-success">{{ $data->paid }}</td>
                <td class="text-center data_debt text-danger">{{ $data->debt }}</td>
                <td class="d-flex justify-content-center">
                    <a class="pay_icon" title="To Pay" data-id="{{$data->id}}">
                        <i class="material-icons text-light">attach_money</i>
                    </a>
                </td>
                <td class="td-actions text-center">
                    <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="material-icons">settings</i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right px-1" aria-labelledby="navbarDropdownProfile">
                        <a href="#" class="dropdown-item btn btn-success btn-link pl-0">
                            <i class="material-icons ml-3">edit</i>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Edit
                        </a>
                        <div class="dropdown-divider"></div>
                        <button id="deleteData" type="button" style="width: 100%; " class="dropdown-item btn btn-danger btn-link pl-0" data-id="{{ $data->id }}">
                            <i class="material-icons ml-3">delete_outline</i>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Delete
                        </button>
                    </div>
                </td>
            </tr>
        @empty
            <tr class="empty_data">
                <td colspan="8"><h3>No Data to show</h3></td>
            </tr>
        @endforelse
    </tbody>
</table>
<div class="datas_links d-flex justify-content-center">
    {{ $datas->links() }}
</div>