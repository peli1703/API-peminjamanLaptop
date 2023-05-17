<?php

namespace App\Http\Controllers;

use App\Models\peminjamanLaptop;
use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;
use Exception;

class PeminjamanLaptopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search_nama;
        //ambil data dari key limit bagian params nya di postman
        $limit =$request->limit;
        $laptops = peminjamanLaptop::where('nama','LIKE','%'.$search.'%')->limit($limit)->get();
        if ($laptops) {
            //kalau data berhasil diambil
            return ApiFormatter::createApi (200, 'success', $laptops);
        }else {
            //kalau data gagal diambil
            return ApiFormatter::createApi (400, 'failed');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $request->validate([
                'nama' => 'required|min:8',
                'nis' => 'required|min:3',
                'rombel'  => 'required',
                'rayon'  => 'required',
                'tanggal_peminjaman'=> 'required',
                'no_laptop' =>'required',
            ]);

            $laptop = peminjamanLaptop::create([
                'nama' =>$request->nama,
                'nis' =>$request->nis,
                'rombel' =>$request->rombel,
                'rayon' =>$request->rayon,
                'tanggal_peminjaman'=> \carbon\carbon::Parse($request->tanggal_peminjaman)->format('Y-m-d'),
                'no_laptop' =>$request->no_laptop,
            ]);
            
            $tambahData = peminjamanLaptop::where('id', $laptop->id)->first();

            if ($tambahData) {
                return ApiFormatter::createApi (200, 'success', $laptop);
            }else {
                return ApiFormatter::createApi (400, 'failed');
            }
        } catch (Exception $error) {
            //munculin deskripsi error yang bakal tampil dari property data jsonnya
            return ApiFormatter::createApi(400, 'failed', $error->getMessage());
        }
    }

    public function generateToken()
    {
        return csrf_token();
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try{
            //ambil data dari table students yang idnya sama kaya dari path routenya
            // where & find cuma bisa cari berdasarkan id
            $laptop = peminjamanLaptop::find($id);
            if ($laptop) {
                //kalau data berhasil diambil, tampilkan data dari student nya dengan nama status code 200
                return ApiFormatter::createApi('200', 'success', $laptop);
            } else {
                //kalau data gagal diambil/data gada, yang dikembalikan status code 400
                return ApiFormatter::createApi (400, 'failed');
            }
        }
        catch (Exception $error) {
            return ApiFormatter::createApi(400, 'failed', $error->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(peminjamanLaptop $peminjamanLaptop)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, peminjamanLaptop $peminjamanLaptop, $id)
    {
        try{
            //cek validasi inputan pada body postman
            $request->validate([
                'nama' => 'required|min:8',
                'nis' => 'required|min:3',
                'rombel'  => 'required',
                'rayon'  => 'required',
                'tanggal_peminjaman'=> 'required',
                'no_laptop' =>'required',
            ]);
            //ambil data yang akan diubah
            $laptop = peminjamanLaptop::find($id);
            //update data yang telah diambil diatas
            $updateLaptop = $laptop->update([
                'nama' =>$request->nama,
                'nis' =>$request->nis,
                'rombel' =>$request->rombel,
                'rayon' =>$request->rayon,
                'no_laptop' =>$request->no_laptop,
                'tanggal_peminjaman'=> \carbon\carbon::Parse($request->tanggal_peminjaman)->format('Y-m-d'),

            ]);
            $dataBaru = peminjamanLaptop::where('id', $laptop->id)->first();
            if ($dataBaru) {
                //jika update berhasil, tampilkan data dari $updatestudent diatas(data yan sudah berhasil diambil)
                return ApiFormatter::createApi('200','success', $dataBaru);
            } else {
                return ApiFormatter::createApi (400, 'failed');
            }
        }
        catch (Exception $error) {
            //jikabaris code try ada yang trouble, error dimunculkan dengan desc err nya dengan status code 400
            return ApiFormatter::createApi(400, 'failed', $error->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(peminjamanLaptop $peminjamanLaptop, $id)
    {
        try{
            $laptop = peminjamanLaptop::find($id);
            $delete = $laptop->delete();
            
            if ($delete) {
                //jika delete berhasil, data yang dimunculin texts cofirm dengan status code 200
                return ApiFormatter::createApi('200','succes delete data');
            } else {
                return ApiFormatter::createApi (400, 'failed');
            }
        }
        catch (Exception $error) {
            //jika baris code try ada yang trouble, error dimunculkan dengan desc err nya dengan status code 400
            return ApiFormatter::createApi(400, 'failed', $error->getMessage());
        }
    }

    public function trash()
    {
        try {
            //ambil data yang sudah di hapus sementara
            $laptop = peminjamanLaptop::onlyTrashed()->get();

            if ($laptop) {
                //kalau data berhasil terambil, tampilkan status 200 dengan data students
                return ApiFormatter::createApi('200','success ', $laptop);
            } else {
                return ApiFormatter::createApi (400, 'failed');
            }
        }
        catch (Exception $error) {
            //kalau data error di try, catch akan menampilkan desc error nya
            return ApiFormatter::createApi(400, 'failed', $error->getMessage());
        }
    }

    public function restore($id)
    {
        try {
            //ambil data yang akan batal dihapus, diambil berdasarkan id route
            $laptop = peminjamanLaptop::onlyTrashed()->where('id', $id);
            //kembalikan data
            $laptop->restore();
            //ambil kembali data yang sudah di restore
            $laptopKembali = peminjamanLaptop::where('id', $id)->first();

            if ($laptopKembali) {
                //jika seluruh prosesnya dapat dijalankan, data yang sudah dikembalikan dan diambil tadi ditampilkan pada response 200
                return ApiFormatter::createApi('200','success ', $laptopKembali);
            } else {
                return ApiFormatter::createApi (400, 'failed');
            }
        }
        catch (Exception $error) {
            //kalau data error di try, catch akan menampilkan desc error nya
            return ApiFormatter::createApi(400, 'failed', $error->getMessage());
        }
    }

    public function permanenDelete($id)
    {
        try {
            //ambil data yang akan dihapus
            $laptop = peminjamanLaptop::onlyTrashed()->where('id', $id);
            //hapus permanen data yang diambil
            $diproses = $laptop->forceDelete();

            if ($diproses) {
                //jika seluruh prosesnya dapat dijalankan, data yang sudah dikembalikan dan diambil tadi ditampilkan pada response 200
                return ApiFormatter::createApi('200','success hapus permanen ');
            } else {
                return ApiFormatter::createApi (400, 'failed');
            }
        }
        catch (Exception $error) {
            //kalau data error di try, catch akan menampilkan desc error nya
            return ApiFormatter::createApi(400, 'failed', $error->getMessage());
        }
    }
}
