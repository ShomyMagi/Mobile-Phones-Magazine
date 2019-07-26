<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;

class User {
    
    public $id_korisnik;
    public $username;
    public $password;
    public $ime;
    public $prezime;
    public $email;
    public $avatar;
    public $id_uloga;
    public $registered_at;
    public $updated_at;
    
    public function register()
    {
        $rezultat = DB::table('korisnici')
                ->insert([
                    'username' => $this->username,
                    'password' => md5($this->password),
                    'ime' => $this->ime,
                    'prezime' => $this->prezime,
                    'email' => $this->email,
                    'avatar' => $this->avatar,                    
                    'registered_at' => $this->registered_at,
                    'updated_at' => $this->updated_at,
                    'id_uloga' => 2
                ]);
        return $rezultat;
    }
    
    public function login()
    {
        $rezultat = DB::table('korisnici')
                ->select('korisnici.*', 'uloge.naziv')
                ->join('uloge', 'uloge.id_uloga', '=', 'korisnici.id_uloga')
                ->where([
                    'username' => $this->username,
                    'password' => md5($this->password)
                ])
                ->first();
        return $rezultat;                  
    }
    
    public function getUser($id)
    {
        $rezultat = DB::table('korisnici')
                ->select('*', 'korisnici.updated_at as korisnikUpdate')
                ->join('uloge', 'uloge.id_uloga', '=', 'korisnici.id_uloga')
                ->where('id_korisnik', '=', $id)
                ->first();
        return $rezultat;
    }
    
    public function editUser($id)
    {
        $data = ([
                    'email' => $this->email,
                    'updated_at' => $this->updated_at
                ]);
        
        if(!empty($this->avatar))
        {
            $data['avatar'] = $this->avatar;
        }
        
        if(!empty($this->password))
        {
            $data['password'] = $this->password;
        }
        
        $rezultat = DB::table('korisnici')
                ->where('id_korisnik', '=', $id)
                ->update($data);
        return $rezultat;
    }
    
    public function showComments($id)
    {
        $rezultat = DB::table('komentari')
                ->join('korisnici', 'korisnici.id_korisnik', '=', 'komentari.id_korisnik')
                ->join('uredjaji', 'uredjaji.id_uredjaj', '=', 'komentari.id_uredjaj')
                ->join('slike', 'uredjaji.id_uredjaj', '=', 'slike.id_uredjaj')
                ->where('korisnici.id_korisnik', '=', $id)
                ->where('featured', '=', '1')
                ->orderBy('posted_at', 'desc')
                ->get();
        return $rezultat;
    }
    
    public function adminUsers()
    {
        $rezultat = DB::table('korisnici')
                ->select('*', 'korisnici.updated_at as korUpdate')
                ->join('uloge', 'uloge.id_uloga', '=', 'korisnici.id_uloga')
                ->orderBy('registered_at', 'desc')
                ->get();
        return $rezultat;
    }
    
    public function adminDelete($id)
    {
        $rezultat = DB::table('korisnici')
                ->where('id_korisnik', '=', $id)
                ->delete();
        return $rezultat;
    }
    
    public function adminInsert()
    {
        $rezultat = DB::table('korisnici')
                ->insert([
                    'username' => $this->username,
                    'password' => md5($this->password),
                    'ime' => $this->ime,
                    'prezime' => $this->prezime,
                    'email' => $this->email,
                    'avatar' => $this->avatar,                    
                    'registered_at' => $this->registered_at,
                    'updated_at' => $this->updated_at,
                    'id_uloga' => $this->id_uloga
                ]);
        return $rezultat;
    }
    
    public function getAdminUsers()
    {
        $rezultat = DB::table('korisnici')
                ->get();
        return $rezultat;
    }
    
    public function adminUpdate($id)
    {
        $data = ([
                    'username' => $this->username,
                    'password' => $this->password,
                    'ime' => $this->ime,
                    'prezime' => $this->prezime,
                    'email' => $this->email,
                    'updated_at' => $this->updated_at,
                    'id_uloga' => $this->id_uloga
                ]);
        
        if(!empty($this->avatar))
        {
            $data['avatar'] = $this->avatar;
        }
        
        $rezultat = DB::table('korisnici')
                ->where('id_korisnik', '=', $id)
                ->update($data);
        return $rezultat;
    }
}
