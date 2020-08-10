<?php

namespace App\Http\Controllers;

use App\Mahasiswa;
use App\Prodi;
use DataTables;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('mahasiswa.index');
    }
    public function mhs_list()
    {
         $mhs = Mahasiswa :: with('mprodi')->get();
         return Datatables :: of($mhs)
                -> addIndexColumn()
                -> addColumn('action', function ($mhs) {
                    $action = '<a href="/mhs/edit/'.$mhs->nim.'" class ="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a> | <a href="/mhs/delete/'.$mhs->nim.'" class ="btn btn-xs btn-danger"><i class="glyphicon glyphicon-edit"></i> Hapus</a>';
                    return $action;
                })
                ->make();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $prodi = prodi::all();
        return view('mahasiswa.create',compact('prodi'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required',
            'nama_lengkap' => 'required',
        ]);
        Mahasiswa::create($request->all());
        return redirect()->route('mhs.index')
                        ->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function show(Mahasiswa $mahasiswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function edit(Mahasiswa $mahasiswa, $nim)
    {
        $prodi = Prodi::find($id);
        return view ('prodi.edit', compact('prodi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $request->validate([
            'nama_prodi' => 'required',
        ]);

        $prodi->update($request->all());

        return redirect()->route('prodi.index')
                        ->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        $mahasiswa->delete();
         return redirect()->route('mhs.index')
        ->with('success','Data Berhasil Dihapus');
    }
}
