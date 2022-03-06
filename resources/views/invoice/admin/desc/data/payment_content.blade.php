<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered h-100 my-0" role="document">
        <div class="modal-content">
            <div class="modal-header py-4" style="background: linear-gradient(60deg , #ec407a, #d81b60);">
                <h5 class="modal-title text-light" id="paymentModalTitle">Payment</h5>
                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-0">
                <div class="d-flex justify-content-between px-3 py-2 my-1 bg-light rounded">
                    <h3 class="m-0">Debt</h3>
                    <h3 class="m-0 text-danger">{{$data->debt}}</h3>
                </div>
                <div class="d-flex justify-content-between px-3 py-2 my-1 bg-light rounded">
                    <h3 class="m-0">Paid</h3>
                    <h3 class="m-0 text-success">{{$data->paid}}</h3>
                </div>
                <form id="payForm" action="{{ route('invoice.admin.desc.fill.field.image', ['slug' => $slug,'field_slug'=>$field_slug]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="data_id" value="{{$data->id}}">
                            <div class="d-flex justify-content-between align-items-center pt-3">
                                <div class="form-group bmd-form-group is-filled">
                                    <label for="date" class="bmd-label-floating">Date*</label>
                                    <input type="date" id="date" name="date" class="form-control datepicker" value="{{ date('Y').'-'.date('m').'-'.date('d') }}">
                                    <label id="date-error" class="error" for="date" style="display: none;"></label>
                                </div>
                                <div class="form-group bmd-form-group">
                                    <label for="payment" class="bmd-label-floating">Payment*</label>
                                    <input type="number" id="payment" name="payment" class="form-control">
                                    <label id="payment-error" class="error" for="payment" style="display: none;"></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-rose">
                                    <label for="image" class="m-0  text-light"><i class="material-icons mr-2">upload</i>Image Upload</label >
                                </button>
                            </div>
                            <div class="gallery"></div>
                            <input type="file" id='image' name="filename[]" class="form-control d-none" multiple accept="image/*">
                            <div>
                                <button id="payBtn" type="submit" class="btn btn-rose">Pay</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>