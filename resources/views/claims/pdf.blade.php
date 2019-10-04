<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Claim Report</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        p{
            line-height: 38px;
            font-size: 18px;
        }
        .tufan-sign img{
            width: 120px;
        }
        .signature-name{
            line-height: 0px;
        }
        .signature-img{
            max-width: 220px;
        }
        @page { size: auto;  margin: 0mm; }
        @media print {
            #printPageButton {
                display: none;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-sm-10">
            <div class="row">
                <div class="col-sm-12">
                    <div class="text-right">{{ \Carbon\Carbon::parse($claim->created_at)->format('d-m-Y')}}</div>
                    <div>
                        <p>Dear/Sirs Madam, </br>
                            Address: {{$claim->address}} </br>
                            Booking Reference: {{$claim->pnr}}</br>
                            I hereby confirm that MasterTrip Ltd. has a right to proceed my claim on behalf of me.
                        </p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-9">
                   <p>
                       Tufan Aygunes </br>
                       MasterTrip Ltd.
                   </p>
                    <div class="tufan-sign">
                        <img  src="{{asset('/images/signatures/tufan.png')}}" alt=""/>
                    </div>

                </div>
                <div class="col-sm-3">
                    <div class="signature">
                        <p class="text-center signature-name mt-5">{{$claim->name}}</p>
                        <div class="img-box">
                            <img class="signature-img" src="{{asset('images/').'/'.$claim->signature}}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-end">
                <div class="col-2 text-right">
                    <button id="printPageButton" class="btn btn-default mt-5 print pr-3 pl-3" onclick="window.print();return false;" >Print</button>
                </div>
            </div>
        </div>

    </div>
</div>

</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>