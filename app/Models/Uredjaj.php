<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;

class Uredjaj {
    
    public $id;
    public $naziv;
    public $headline;
    public $text;
    public $created_at;
    public $updated_at;
    public $ip;
    
    public function getFirst()
    {
        $rezultat = DB::table('uredjaji')
                //->select('*', \DB::raw('(SELECT COUNT id_komentar FROM komentari ORDER BY posted_at DESC LIMIT 1) as prebrojaniKomentari'))
                ->join('slike', 'slike.id_uredjaj', '=', 'uredjaji.id_uredjaj')
                ->where('featured', '=', '1')
                ->orderBy('created_at', 'desc')
                ->first();
        return $rezultat;
    }
    
    public function getSecond()
    {
        $rezultat = DB::table('uredjaji')
                ->join('slike', 'slike.id_uredjaj', '=', 'uredjaji.id_uredjaj')
                ->where('featured', '=', '1')
                ->orderBy('created_at', 'desc')
                ->skip(1)
                ->take(1)
                ->first();
        return $rezultat;
    }
    
    public function getThird()
    {
        $rezultat = DB::table('uredjaji')
                ->join('slike', 'slike.id_uredjaj', '=', 'uredjaji.id_uredjaj')
                ->where('featured', '=', '1')
                ->orderBy('created_at', 'desc')
                ->skip(2)
                ->take(1)
                ->first();
        return $rezultat;
    }
    
    public function getOthers()
    {
        $rezultat = DB::table('uredjaji')
                ->join('slike', 'slike.id_uredjaj', '=', 'uredjaji.id_uredjaj')
                ->where('featured', '=', '1')
                ->orderBy('created_at', 'desc')
                ->skip(3)
                ->take(4)
                ->get();
        return $rezultat;
    }
    
    public function popularNews()
    {
        $rezultat = DB::table('uredjaji')
                ->select('*', \DB::raw("(SELECT count(id_pregled) FROM pregledi) as views"))
                ->join('slike', 'slike.id_uredjaj', '=', 'uredjaji.id_uredjaj')                
                ->where('featured', '=', '1')
                ->orderBy('views', 'desc')
                ->paginate(3);
        return $rezultat;
    }
    
    public function search($value)
    {
        $rezultat = DB::table('uredjaji')
                ->join('slike', 'slike.id_uredjaj', '=', 'uredjaji.id_uredjaj')
                ->where('naziv', 'like', '%'.$value.'%')
                ->where('featured', '=', '1')
                ->orWhere('text', 'like', '%'.$value.'%')
                ->where('featured', '=', '1')
                ->orderBy('created_at', 'desc')
                ->get();
        return $rezultat;
    }
    
    public function onePost($id)
    {
        $rezultat = DB::table('uredjaji')
                ->select('*', \DB::raw("(SELECT count(id_pregled) FROM pregledi WHERE id_uredjaj = $id) as views"))
                ->join('slike', 'slike.id_uredjaj', '=', 'uredjaji.id_uredjaj')
                ->where('uredjaji.id_uredjaj', '=', $id)
                ->first();
        return $rezultat;
    }
    
    public function Post($id)
    {
        $rezultat = DB::table('uredjaji')
                ->join('slike', 'slike.id_uredjaj', '=', 'uredjaji.id_uredjaj')
                ->where('uredjaji.id_uredjaj', $id)
                ->first();
        return $rezultat;
    }
    
    public function views($id, $ip)
    {
        return DB::table('pregledi')
            ->insert([
                'ip' => $ip,
                'id_uredjaj' => $id
            ]);
    }
    
    public function postName()
    {
        $rezultat = DB::table('uredjaji')
                ->join('slike', 'slike.id_uredjaj', '=', 'uredjaji.id_uredjaj')
                ->where('featured', '=', '1')
                ->orderBy('naziv', 'asc')
                ->get();
        return $rezultat;
    }
    
    public function postAsc()
    {
        $rezultat = DB::table('uredjaji')
                ->join('slike', 'slike.id_uredjaj', '=', 'uredjaji.id_uredjaj')
                ->where('featured', '=', '1')
                ->orderBy('created_at', 'asc')
                ->get();
        return $rezultat;
    }   
    
    public function adminPosts()
    {
        $rezultat = DB::table('uredjaji')
                ->select('*', 'uredjaji.updated_at as uredjajUpdate')
                ->join('slike', 'slike.id_uredjaj', '=', 'uredjaji.id_uredjaj')
                ->where('featured', '=', '1')
                ->orderBy('created_at', 'desc')
                ->get();
        return $rezultat;
    }
    
    public function adminDelete()
    {
        $rezultat = DB::table('uredjaji')
                ->where('id_uredjaj', '=', $this->id)
                ->delete();
        return $rezultat;
    }
    
    public function adminInsert()
    {
        $rezultat = DB::table('uredjaji')
                ->insertGetId([
                    'naziv' => $this->naziv,
                    'headline' => $this->headline,
                    'text' => $this->text,      
                    'created_at' => $this->created_at,
                    'updated_at' => $this->updated_at
                ]);
        return $rezultat;
    }
    
    public function adminUredjaji()
    {
        $rezultat = DB::table('uredjaji')
                ->get();
        return $rezultat;
    }
    
    public function adminUpdate($id)
    {
        $data = ([
                    'naziv' => $this->naziv,
                    'headline' => $this->headline,
                    'text' => $this->text,
                    'updated_at' => $this->updated_at
                ]);        
        
        $rezultat = DB::table('uredjaji')
                ->where('id_uredjaj', '=', $id)
                ->update($data);
        return $rezultat;
    }
}