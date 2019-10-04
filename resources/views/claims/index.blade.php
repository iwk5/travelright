@extends('layouts.app')
<style>
    .pull-right{
        float: right;
    }
    .panel{
        width: 50%;
        float: none;
        margin: 0 auto;
        background: #fff;
        padding: 20px;
        margin-bottom: 10px;
    }
    table {
        border: 1px solid #ccc;
        border-collapse: collapse;
        margin: 0;
        padding: 0;
        width: 100%;
        table-layout: fixed;
    }

    table caption {
        font-size: 1.5em;
        margin: .5em 0 .75em;
    }

    table tr {
        background-color: #f8f8f8;
        border: 1px solid #ddd;
        padding: .35em;
    }

    table th,
    table td {
        padding: .625em;
        text-align: center;
    }

    table th {
        font-size: .85em;
        letter-spacing: .1em;
        text-transform: uppercase;
    }

    @media screen and (max-width: 600px) {
        table {
            border: 0;
        }

        table caption {
            font-size: 1.3em;
        }

        table thead {
            border: none;
            clip: rect(0 0 0 0);
            height: 1px;
            margin: -1px;
            overflow: hidden;
            padding: 0;
            position: absolute;
            width: 1px;
        }

        table tr {
            border-bottom: 3px solid #ddd;
            display: block;
            margin-bottom: .625em;
        }

        table td {
            border-bottom: 1px solid #ddd;
            display: block;
            font-size: .8em;
            text-align: right;
        }

        table td::before {
            /*
            * aria-label has no advantage, it won't be read inside a table
            content: attr(aria-label);
            */
            content: attr(data-label);
            float: left;
            font-weight: bold;
            text-transform: uppercase;
        }

        table td:last-child {
            border-bottom: 0;
        }
    }
</style>
@section('content')
    <div class="container">
        <div class="row md-3">
            <div class="col-6"><h2>My Claims</h2></div>
            <div class="col-6"><a class="btn btn-primary pull-right " href="{{url("claims/create")}}" >New Claim</a></div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-striped">
                    @if(count($claims) > 0)
                    <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Address</th>
                        <th scope="col">PNR</th>
                 {{--       <th scope="col">Status</th>--}}
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    @endif
                    <tbody>
                        @forelse($claims as $claim)
                            <tr>
                                <td data-label="Name">{{$claim->name}}</td>
                                <td data-label="Address">{{$claim->address}}</td>
                                <td data-label="PNR">{{$claim->pnr}}</td>
                              {{--  <td data-label="Status">{{$claim->status}}</td>--}}
                                <td data-label="Actions">
                                    {{--<a href="{{route('claim-report', $claim->uuid)}}" style="color:#00cc6a"><i class="fa fa-star"></i></a>--}}
                                <a target="_blank" href="{{route('generate-qrcode', $claim->uuid)}}" style="color:#3490dc">
                                    <i class="fa fa-qrcode fa-2x" aria-hidden="true"></i>
                                </a>
                                </td>
                            </tr>
                        @empty
                            <h3 class="text-center mt-5">You have no active claim!</h3>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection