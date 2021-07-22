<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    // Pengguna 
    public function validasiPengguna(Request $request){
        $username   = $request->input('username');
        $result     = DB::select("SELECT * FROM pengguna WHERE username = '$username'");
        if($result != null){
            return response()->json([
                'success'   => false,
                'message'   => 'Username anda telah digunakan!',
                'data'      => ''
            ], 401);
        } else {
            return response()->json([
                'success'   => true,
                'message'   => 'Username bisa digunakan!',
                'data'      => ''
            ], 200);
        }
    }

    public function loginPengguna(Request $request){
        $username   = $request->input('username');
        $password   = $request->input('password');
        $result     = DB::select("SELECT * FROM pengguna WHERE username = '$username' AND password = '$password'");
        if($result == null){
            return response()->json([
                'success'   => false,
                'message'   => 'Login gagal, periksa akun anda!',
                'data'      => ''
            ], 401);
        } else {
            return response()->json([
                'success'   => true,
                'message'   => 'Login berhasil!',
                'data'      => $result
            ], 200);
        }
    }

    public function registerPengguna(Request $request){
        $nama_pengguna       = $request->input('nama_pengguna');
        $username   = $request->input('username');
        $password   = $request->input('password');
        $result     = DB::insert("INSERT INTO pengguna VALUES (0, '$nama_pengguna', '$username', '$password')");
        return response()->json([
            'success'   => true,
            'message'   => 'Anda berhasil register!',
            'data'      => ''
        ], 200);
    }

    public function getPengguna(Request $request, String $id){
        $result     = DB::select("SELECT * FROM pengguna WHERE id_pengguna = '$id'");
        return response()->json([
            'success'   => true,
            'message'   => 'Berhasil!',
            'data'      => $result
        ], 200);
    }

    public function editPengguna(Request $request, String $id){
        $nama_pengguna       = $request->input('nama_pengguna');
        $username   = $request->input('username');
        $password   = $request->input('password');
        $result     = DB::update("  UPDATE pengguna 
                                    SET nama_pengguna = '$nama_pengguna', 
                                        username = '$username', 
                                        password = '$password' 
                                    WHERE id_pengguna = '$id'");
        return response()->json([
            'success'   => true,
            'message'   => 'Anda berhasil register!',
            'data'      => ''
        ], 200);
    }

    // Rusunawa.

    public function getInfoRusunawa(String $id){
        $result     = DB::select("SELECT    COUNT(pengguna.id_pengguna) AS 'total_rusunawa', 
                                            COUNT(CASE WHEN rusunawa.kondisi_gedung >= 3 THEN 1 ELSE NULL END) AS 'rusunawa_perbaikan' 
                                    FROM rusunawa
                                    JOIN pengguna_rusunawa ON rusunawa.id_rusunawa = pengguna_rusunawa.id_rusunawa
                                    JOIN pengguna ON pengguna_rusunawa.id_pengguna = pengguna.id_pengguna
                                    WHERE pengguna.id_pengguna = $id GROUP BY pengguna.id_pengguna");
        return response()->json([
            'success'   => true,
            'message'   => 'Berhasil!',
            'data'      => $result
        ], 200);
    }

    public function getSemuaRusunawa(Request $request){
        $result     = DB::select("SELECT * FROM rusunawa");
        return response()->json([
            'success'   => true,
            'message'   => 'Berhasil!',
            'data'      => $result
        ], 200);
    }

    public function getRusunawa(Request $request, String $id){
        $result     = DB::select("SELECT * FROM rusunawa WHERE id_rusunawa = '$id'");
        return response()->json([
            'success'   => true,
            'message'   => 'Berhasil!',
            'data'      => $result
        ], 200);
    }
    
    public function getPenggunaRusunawa(Request $request, String $id){
        $result     = DB::select("SELECT * FROM rusunawa
JOIN pengguna_rusunawa ON rusunawa.id_rusunawa = pengguna_rusunawa.id_rusunawa
JOIN pengguna ON pengguna_rusunawa.id_pengguna = pengguna.id_pengguna
WHERE pengguna.id_pengguna = '$id'");
        return response()->json([
            'success'   => true,
            'message'   => 'Berhasil!',
            'data'      => $result
        ], 200);
    }

    public function insertRusunawa(Request $request){
        $nama                   = $request->input('nama');
        $lokasi                 = $request->input('lokasi');
        $luas_bangunan          = $request->input('luas_bangunan');
        $luas_tanah             = $request->input('luas_tanah');
        $kuota                  = $request->input('kuota');
        $penghuni               = $request->input('penghuni');
        $jangka_pemeliharaan    = $request->input('jangka_pemeliharaan');
        $kondisi_gedung         = $request->input('kondisi_gedung');
        $gambar                 = $request->input('gambar');
        $fasilitas              = $request->input('fasilitas');
        $id_pengguna              = $request->input('id_pengguna');

        $result     = DB::insert("INSERT INTO rusunawa VALUES (0, '$nama', '$lokasi', '$luas_bangunan', '$luas_tanah', '$kuota',
            '$penghuni', '$jangka_pemeliharaan', '$kondisi_gedung', '$gambar', '$fasilitas', NULL)");

        DB::insert("INSERT INTO pengguna_rusunawa SET id_pengguna = '$id_pengguna', id_rusunawa = (SELECT id_rusunawa FROM rusunawa ORDER BY created_at DESC LIMIT 1);");

        return response()->json([
            'success'   => true,
            'message'   => 'Anda berhasil insert!',
            'data'      => ''
        ], 200);
    }

    public function editRusunawa(Request $request, String $id){
        $nama                   = $request->input('nama');
        $lokasi                 = $request->input('lokasi');
        $luas_bangunan          = $request->input('luas_bangunan');
        $luas_tanah             = $request->input('luas_tanah');
        $kuota                  = $request->input('kuota');
        $penghuni               = $request->input('penghuni');
        $jangka_pemeliharaan    = $request->input('jangka_pemeliharaan');
        $kondisi_gedung         = $request->input('kondisi_gedung');
        $gambar                 = $request->input('gambar');
        $fasilitas              = $request->input('fasilitas');

        $result     = DB::update("UPDATE rusunawa SET nama = '$nama', lokasi = '$lokasi', luas_bangunan = '$luas_bangunan', luas_tanah = '$luas_tanah', kuota = '$kuota', penghuni = '$penghuni', jangka_pemeliharaan = '$jangka_pemeliharaan', kondisi_gedung = '$kondisi_gedung', gambar = '$gambar', fasilitas = '$fasilitas' WHERE id_rusunawa = '$id'");

        return response()->json([
            'success'   => true,
            'message'   => 'Anda berhasil ubah Rusunawa!',
            'data'      => ''
        ], 200);
    }

    public function deleteRusunawa(Request $request, String $id){
        $result     = DB::delete("DELETE FROM rusunawa WHERE id_rusunawa = '$id'");
        return response()->json([
            'success'   => true,
            'message'   => 'Berhasil!',
            'data'      => ''
        ], 200);
    }

    
}
