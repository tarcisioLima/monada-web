<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Composition;

class CompositionController extends Controller
{
    public function home()
    {
        return view('vueApp');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Composition::orderBy('id', 'DESC')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);
        $create = Composition::create($request->all());
        return response()->json(['status' => 'sucesso', 'msg' => 'Composição postada com sucesso.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Composition::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Composition::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);

        $composition = Composition::find($id);
        if($composition->count()) {
            $composition->update($request->all());
            return response()->json(['status' => 'sucesso', 'msg' => 'Composição atualizada com sucesso.']);
        } else {
            return response()->json(['status' => 'error', 'msg' => 'Erro ao atualizar composição.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $composition = Composition::find($id);
        if($composition->count()) {
            $composition->delete($id);
            return response()->json(['status' => 'sucesso', 'msg' => 'Composição deletada com sucesso.']);
        } else {
            return response()->json(['status' => 'error', 'msg' => 'Erro ao deletar composição.']);
        }
    }
}
