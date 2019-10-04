<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Claim;
use QrCode;
use Illuminate\Support\Str;

class ClaimController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //  $claims = Claim::all();
        $claims = Claim::where('user_id',Auth::user()->id)->get();

        return view('claims.index', compact('claims'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('claims.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'address' => 'required',
            'pnr' => 'required|alpha_num|max:6',
            'signature' => 'required|image'
        ],
        [ 'signature.image' => 'Please draw Signature and Save it.']
        );

        $newName = Str::uuid() . ".png";
        $request->file('signature')->move("images", $newName);

        $claim = new Claim;
        $claim->user_id = Auth::user()->id;
        $claim->uuid = Str::uuid();
        $claim->name = $request->name;
        $claim->address = $request->address;
        $claim->pnr = $request->pnr;
        $claim->signature = $newName;

        $claim->status = 0;
        if ($claim->save()) {
            return response()->json([
                'success' => 'Created successfully!',
            ]);
        } else {
            return response()->json([
                'error' => 'Sorry there was some error! Please try again'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $claims = Claim::find($id);
        return view('claims.claim', compact('claims'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        /* $claim= Claim::find($id);
         return view('claims.edit',compact('claim'));*/
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /*$claim= Claim::find($id);
        $claim->content= $request->content;
        $claim->update();
        return redirect('/claims/'.$id);*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
// pdf generator
    public function generatePdf($id)
    {
        $claim = Claim::where('uuid', $id)->first();
        return view('claims.pdf', compact('claim'));
    }
// claim qrCode generator
    public function generateQrcode($id)
    {
        $claim = Claim::where('uuid', $id)->firstOrFail();
        $route = route('claim-report', $claim->uuid);
        $image = \QrCode::format('png')
            ->size(500)->errorCorrection('H')
            ->generate($route);
        return response($image)->header('Content-type','image/png');
        return view('claims.qrCode');
    }
}
