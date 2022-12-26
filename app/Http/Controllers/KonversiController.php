<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\TrxProdukBahanBaku;
use App\Models\BahanBaku;
class KonversiController extends Controller
{
    public function index(){
        $produk = Produk::all();
        return view('index', ['produk' => $produk]);
    }
    public function konversi(Request $request){
        //cek jenis konversi, tiap jenis konversi akan menggunakan beda fungsi untuk memproses
        if($request->jenis == 'ke_produk'){
           $resultData = $this->konversiProduk($request);
        } else {
           $resultData = $this->konversiBahanBaku($request);
        }

        //menyiapkan data untuk dikirimkan ke view
        $produk = Produk::all();
        $data = [
            'produk' => $produk,
            'status' => $resultData['status'],
            'result' => $resultData['result'],
            'jenis'  => $request->jenis,
        ];
        return view('index', $data);
    }

    //fungsi yang digunakan untuk memproses konversi bahan baku ke produk
    public function konversiProduk(Request $request){
        $kebBahan = TrxProdukBahanBaku::where('produk_id',$request->produk)->get();
        $dataBahan = [];
        $status = true;
        $result = [];
        $resultData=[];

        //cek apakah bahan baku mencukupi
        foreach ($kebBahan as $index => $bahan) {
            $dataBahan [] = BahanBaku::where('id', $bahan->bahan_baku_id)->get();
            $totalKebBahan = $bahan->kebutuhan_bahanbaku*$request->jumlah;
            if($status && ($dataBahan[$index][0]->stock_bahanbaku > $totalKebBahan)){
                $result [] = [
                    'id_bahan_baku' => $bahan->bahan_baku_id,
                    'nama_bahan_baku' => $dataBahan[$index][0]->nama_bahanbaku,
                    'kebutuhan_per_produk' => $bahan->kebutuhan_bahanbaku,
                    'stok' => $dataBahan[$index][0]->stock_bahanbaku,
                    'totalkeb'=> $totalKebBahan,
                ];
            } else {
                $status = false;
            };
        }

        //jika bahan baku mencukupi maka akan diproses
        //pengurangan stok bahan baku
        //dan penambahan stok produk
        if($status){
            foreach ($result as $key => $item) {
                //menurangi setiap bahan baku
                BahanBaku::where('id', $item['id_bahan_baku'])->decrement('stock_bahanbaku', $item['totalkeb']);
            };
            $dataProduk = Produk::where('id', $request->produk)->get()->first();

            //menambah stok produk
            Produk::where('id', $request->produk)->increment('stock_produk', $request->jumlah);

            $stokProdSetelah = Produk::where('id', $request->produk)->get('stock_produk')->first();
            $resultData = [
                'nama_produk' => $dataProduk->nama_produk,
                'stok_sebelum' => $dataProduk->stock_produk,
                'stok_setelah' => $stokProdSetelah->stock_produk
            ];
        }

        //mengembalikan value yang akan digunakan pada function konversi
        return ['status' => $status, 'result' =>  $resultData];
    }

    //fungsi yang digunakan untuk memproses konversi produk ke bahan baku
    public function konversiBahanBaku(Request $request){
        $kebBahan = TrxProdukBahanBaku::where('produk_id',$request->produk)->get();
        $dataBahan = [];
        $status = true;
        $result = [];
        $dataProduk = Produk::where('id', $request->produk)->get()->first();

        //cek apakah stok produk yang ingin dikonversi menucukupi
        //jika stok produk mencukupi maka akan diproses
        //pengurangan stok produk
        //dan penambahan stok bahan baku
        if($dataProduk->stock_produk > $request->jumlah){
            foreach ($kebBahan as $index => $bahan) {
                $dataBahan [] = BahanBaku::where('id', $bahan->bahan_baku_id)->get();
                $totalKebBahan = $bahan->kebutuhan_bahanbaku*$request->jumlah;
                $result [] = [
                    'id_bahan_baku' => $bahan->bahan_baku_id,
                    'nama_bahan_baku' => $dataBahan[$index][0]->nama_bahanbaku,
                    'kebutuhan_per_produk' => $bahan->kebutuhan_bahanbaku,
                    'stok' => $dataBahan[$index][0]->stock_bahanbaku,
                    'totalkeb'=> $bahan->kebutuhan_bahanbaku*$request->jumlah,
                ];
            }

            foreach ($result as $key => $item) {
                //penambahan bahan baku
                BahanBaku::where('id', $item['id_bahan_baku'])->increment('stock_bahanbaku', $item['totalkeb']);
            };
            //pengurangan produk
            Produk::where('id', $request->produk)->decrement('stock_produk', $request->jumlah);
        } else {
            $status = false;
        };

        //mengembalikan value yang akan digunakan pada function konversi
        return ['status' => $status, 'result' =>  $result];
    }
}
