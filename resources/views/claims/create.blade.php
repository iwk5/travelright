@extends('layouts.app')
<style>
    #sig-canvas {
        border: 2px dotted #CCCCCC;
        border-radius: 15px;
        cursor: crosshair;
    }
    .main-heading{
        font-weight: bold;
    }
    .error{
        color: #ff0000;
    }
    .signature_saved{
        color: #008000;
    }
</style>
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-6">
                <form action="/claims" method="post" id="claimForm">
                    {{ csrf_field() }}
                    <h2 class="main-heading mb-4">Claim Your Flight!</h2>
                    <div class="form-group">
                        <input type="text" class="form-control claim_input" id="full_name" placeholder="Enter Full Name" name="name">
                        <span class="name_error error"></span>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control claim_input" id="address" placeholder="Enter Address" name="address">
                        <span class="address_error error"></span>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control claim_input" id="pnr" placeholder="Enter PNR" name="pnr">
                        <span class="pnr_error error"></span>
                    </div>
                    <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <h2>E-Signature</h2>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <canvas id="sig-canvas" >
                                        Get a better browser!
                                    </canvas>
                                </div>
                                <span class="signature_error error pl-3"></span> <span class="signature_saved pl-3"></span>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-primary" id="sig-submitBtn">Save</button>
                                    <button type="button" class="btn btn-default" id="sig-clearBtn">Clear</button>

                                    <textarea id="sig-dataUrl" class="form-control claim_input" name="signature" hidden></textarea>
                                </div>
                            </div>

                        </div>
                    <div class="form-group">
                        <input class="btn btn-primary  pr-5 pl-5" type="submit" value="Submit" >
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

    <script src="{{asset('js/myscript.js')}}"></script>
@endpush
