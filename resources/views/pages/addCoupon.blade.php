@auth
@extends('layouts.layout')
@section("content")
<div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-4">
                <h5 class="card-title fw-semibold mb-4">New Coupon</h5>
                <div class="table-responsive">
                    <form name="couponBasicInfo" id="couponBasicInfo" method="POST" action="{{route('request.addCoupon')}}">
                        <fieldset>
                            <legend>Add Coupon Form</legend>
                            @csrf
                            <div class="mb-3">
                                <label for="coupon_name" class="form-label">Coupon Name</label>
                                <input name="coupon_name" type="text" class="form-control" id="coupon_name" placeholder="Coupon Name" />
                            </div>
                            <div class="mb-3">
                                <label for="coupon_day" class="form-label">Coupon Day</label>
                                <input name="coupon_day" type="number" class="form-control" id="coupon_day" placeholder="Coupon Day ( 1 - 2 - 3)" min="1" max="10" />
                            </div>
                            <div class="mb-3">
                                <label for="coupon_validity_start_time" class="form-label">Coupon Validity Start Time</label>
                                <input name="coupon_validity_start_time" type="number" class="form-control" id="coupon_validity_start_time" placeholder="Coupon Validity Start Time (0000 - 2359)" minlength="4" maxlength="4" min="0000" max="2359" />
                            </div>
                            <div class="mb-3">
                                <label for="coupon_validity_end_time" class="form-label">Coupon Validity End Time</label>
                                <input name="coupon_validity_end_time" type="number" class="form-control" id="coupon_validity_end_time" placeholder="Coupon Validity End Time (0000 - 2359)" minlength="4" maxlength="4" min="0000" max="2359" />
                            </div>
                            <br />
                            <input type="submit" name="submit" class="btn btn-primary" value="Add Coupon" />
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@endauth