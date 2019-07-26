<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;

class Slika {
    
    public $id_slika;
    public $alt;
    public $putanja;
    public $featured;
    public $id_uredjaj;
    public $id_pos;
    public $inserted_at;
    public $updated_at;
    
    public function instaImages()
    {
        $rezultat = DB::table('slike')
                ->where('featured', '=', '1')
                ->orderBy('inserted_at', 'asc')
                ->paginate(8);
        return $rezultat;
    }
    
    public function adminImages()
    {
        $rezultat = DB::table('slike')
                ->select('*', 'slike.updated_at as slikaUpdate')
                ->join('uredjaji', 'uredjaji.id_uredjaj', '=', 'slike.id_uredjaj')
                ->orderBy('inserted_at', 'desc')
                ->get();
        return $rezultat;
    }
    
    public function getImage($id)
    {
        $rezultat = DB::table('slike')
                ->where('slike.id_slika', '=', $id)
                ->first();
        return $rezultat;
    }
    
    public function getImages()
    {
        $rezultat = DB::table('slike')
                ->join('uredjaji', 'uredjaji.id_uredjaj', '=', 'slike.id_uredjaj')
                ->where('uredjaji.id_uredjaj', '=', $this->id_pos)
                ->get();
        return $rezultat;
    }
    
    public function deleteSlika($id)
    {
        $rezultat = DB::table('slike')
                ->where('slike.id_slika', '=', $id)
                ->delete();
       return $rezultat;
    }
    
    public function deleteSlike()
    {
       $rezultat = DB::table('slike')
                ->join('uredjaji', 'uredjaji.id_uredjaj', '=', 'slike.id_uredjaj')
                ->where('slike.id_uredjaj', '=', $this->id_pos)
                ->delete();
       return $rezultat;
    }
    
    public function insertSlika()
    {
        $id = DB::table('slike')
                ->insert([
                    'alt' => $this->alt,
                    'putanja' => $this->putanja,
                    'featured' => $this->featured,
                    'id_uredjaj' => $this->id_uredjaj,
                    'inserted_at' => $this->inserted_at,
                    'updated_at' => $this->updated_at
                ]);
        return $id;
    }
    
    public function updateSlika($id)
    {
        if(!empty($this->putanja))
        {
            $data['slike.putanja'] = $this->putanja;
        }
        $data['slike.alt'] = $this->alt;
        $data['slike.featured'] = $this->featured;
        $rezultat = DB::table('slike')
                ->where('slike.id_slika', $id)
                ->update($data);
        return $rezultat;
    }
}
