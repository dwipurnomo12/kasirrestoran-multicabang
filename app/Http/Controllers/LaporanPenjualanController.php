<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\PDF;
use App\Models\Cabang;
use App\Models\Pembelian;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Dompdf\Dompdf;

class LaporanPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('laporan-penjualan.index', [
            'cabangs'   => Cabang::all()
        ]);
    }

    /**
     * Get Data Penjualan
     */
    public function getData(Request $request)
    {
        $user = auth()->user();
        $selectedOption = $request->input('opsi');
        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalSelesai = $request->input('tanggal_selesai');

        // Logika pemilihan data berdasarkan cabang dan rentang tanggal
        if ($user->role->role === 'administrator' || $user->role->role === 'kepala restoran') {
            if ($selectedOption == '' || $selectedOption === 'Semua Cabang') {
                $pembelians = Pembelian::with('detailPembelians')->get();
            } else {
                $pembelians = Pembelian::with('detailPembelians')
                    ->where('cabang_id', $selectedOption)
                    ->get();
            }
        } else {
            if ($selectedOption == '' || $selectedOption === 'Semua Cabang') {
                $pembelians = Pembelian::with('detailPembelians')
                    ->where('cabang_id', $user->cabang_id)
                    ->get();
            } else {
                $pembelians = Pembelian::with('detailPembelians')
                    ->where('cabang_id', $user->cabang_id)
                    ->where('cabang_id', $selectedOption)
                    ->get();
            }
        }

        if ($tanggalMulai !== null && $tanggalSelesai !== null) {
            $pembelians = $pembelians->whereBetween('tgl_transaksi', [$tanggalMulai, $tanggalSelesai]);
        }

        if ($request->has('print_pdf')) {
            $data = [
                'pembelians'        => $pembelians,
                'selectedOption'    => $selectedOption,
                'tanggalMulai'      => $tanggalMulai,
                'tanggalSelesai'    => $tanggalSelesai
            ];
            $dompdf = new Dompdf();
            $dompdf->setPaper('A4', 'portrait');
            $html = view('/laporan-penjualan/print-laporan-penjualan', compact('data'))->render();
            $dompdf->loadHtml($html);
            $dompdf->render();
            $dompdf->stream('laporan_penjualan.pdf');
        }
    
        return response()->json([
            'success'   => true,
            'data'      => $pembelians
        ]);
    } 

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
}

  