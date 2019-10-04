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
</style>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h2>My Claims</h2>
                <a class="btn btn-primary pull-right" href="claims/create">New Claim</a>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Address</th>
                        <th>PNR</th>
                        <th>Status</th>
                        <th>Document</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($claims as $claim)
                            <tr>
                                <td>{{$claim->name}}</td>
                                <td>{{$claim->address}}</td>
                                <td>{{$claim->pnr}}</td>
                                <td>{{$claim->status}}</td>
                                <td><a class="btn btn-success">View</a></td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
