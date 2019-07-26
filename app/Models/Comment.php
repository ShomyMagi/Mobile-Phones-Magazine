<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;

class Comment {
    
    public $id_komentar;
    public $tekst;
    public $id_uredjaj;
    public $id_korisnik;
    public $posted_at;
    public $updated_at;
    
    public function getAll($id)
    {
        $rezultat = DB::table('komentari')
                ->join('korisnici', 'korisnici.id_korisnik', '=', 'komentari.id_korisnik')
                ->join('uredjaji', 'uredjaji.id_uredjaj', '=', 'komentari.id_uredjaj')
                ->where('uredjaji.id_uredjaj', '=', $id)
                ->orderBy('posted_at', 'desc')
                ->get();
        return $rezultat;
    }
    
    public function getComments()
    {
        $rezultat = DB::table('komentari')
                ->join('uredjaji', 'uredjaji.id_uredjaj', '=', 'komentari.id_uredjaj')
                ->join('korisnici', 'korisnici.id_korisnik', '=', 'komentari.id_korisnik')
                ->join('slike', 'slike.id_uredjaj', '=', 'uredjaji.id_uredjaj')
                ->where('featured', '=', '1')
                ->orderBy('posted_at', 'desc')
                ->paginate(3);
        return $rezultat;
    }
    
    public function insertComment()
    {
        $rezultat = DB::table('komentari')
                ->insert([
                   'tekst' => $this->tekst,
                   'id_uredjaj' => $this->id_uredjaj,
                   'id_korisnik' => $this->id_korisnik,
                   'posted_at' => $this->posted_at,
                   'updated_at' => $this->updated_at
                ]);
        return $rezultat;
    }
    
    public function deleteComment()
    {
        $rezultat = DB::table('komentari')
                ->where('id_komentar', '=', $this->id_komentar)
                ->delete();
        return $rezultat;
    }
    
    public function editComment()
    {
        $rezultat = DB::table('komentari')
                ->where('id_komentar', '=', $this->id_komentar)
                ->update([
                   'tekst' => $this->tekst ,
                   'updated_at' => $this->updated_at
                ]);
        return $rezultat;
    }
    
    public function get()
    {
        $rezultat = DB::table('komentari')
                ->where('id_komentar', '=', $this->id_komentar)
                ->first();
        return $rezultat;
    }
    
    public function getComment($id)
    {
        $rezultat = DB::table('komentari')
                ->where('id_komentar', '=', $id)
                ->first();
        return $rezultat;
    }
    
    public function adminComments()
    {
        $rezultat = DB::table('komentari')
                ->select('*', 'komentari.updated_at as komentarUpdate')
                ->join('uredjaji', 'uredjaji.id_uredjaj', '=', 'komentari.id_uredjaj')
                ->join('korisnici', 'korisnici.id_korisnik', '=', 'komentari.id_korisnik')
                ->orderBy('posted_at', 'desc')
                ->get();
        return $rezultat;
    }
    
    public function adminDelete($id)
    {
        $rezultat = DB::table('komentari')
                ->where('id_komentar', '=', $id)
                ->delete();
        return $rezultat;
    }
    
    public function adminInsert()
    {
        $rezultat = DB::table('komentari')
                ->insert([
                   'tekst' => $this->tekst,
                   'id_uredjaj' => $this->id_uredjaj,
                   'id_korisnik' => $this->id_korisnik,
                   'posted_at' => $this->posted_at,
                   'updated_at' => $this->updated_at
                ]);
        return $rezultat;
    }
    
    public function adminUpdate($id)
    {
        $rezultat = DB::table('komentari')
                ->where('id_komentar', '=', $id)
                ->update([
                   'tekst' => $this->tekst ,
                   'updated_at' => $this->updated_at
                ]);
        return $rezultat;
    }
}
