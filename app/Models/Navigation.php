<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;

class Navigation {
    
    public $id;
    public $naziv;
    public $putanja;
    public $created_at;
    public $updated_at;
    
    public function getAll()
    {
        $rezultat = DB::table('navigacija')
                ->whereNotIn('id_navigacija', [4,5,6,7])
                ->get();
        return $rezultat;
    }
    
    public function getAdmin()
    {
        $rezultat = DB::table('navigacija')
                ->whereNotIn('id_navigacija', [4,7])
                ->get();
        return $rezultat;
    }
    
    public function getUser()
    {
        $rezultat = DB::table('navigacija')
                ->whereNotIn('id_navigacija', [4,6,7])
                ->get();
        return $rezultat;
    }
    
    public function getSignIn()
    {
        $rezultat = DB::table('navigacija')
                ->whereNotIn('id_navigacija', [1,2,3,5,6,7])
                ->get();
        return $rezultat;
    }
    
    public function getLogout()
    {
        $rezultat = DB::table('navigacija')
                ->whereNotIn('id_navigacija', [1,2,3,4,5,6])
                ->get();
        return $rezultat;
    }
    
    public function adminNavigation()
    {
        $rezultat = DB::table('navigacija')
                ->get();
        return $rezultat;
    }
    
    public function getNav($id)
    {
        $rezultat = DB::table('navigacija')
                ->where('id_navigacija', '=', $id)
                ->first();
        return $rezultat;
    }
    
    public function adminDelete($id)
    {
        $rezultat = DB::table('navigacija')
                ->where('id_navigacija', '=', $id)
                ->delete();
        return $rezultat;
    }
    
    public function adminInsert()
    {
        $rezultat = DB::table('navigacija')
                ->insert([
                   'naziv' => $this->naziv,
                   'putanja' => $this->putanja,
                   'created_at' => $this->created_at,
                   'updated_at' => $this->updated_at
                ]);
        return $rezultat;
    }
    
    public function adminUpdate($id)
    {
        $rezultat = DB::table('navigacija')
                ->where('id_navigacija', '=', $id)
                ->update([
                   'naziv' => $this->naziv,
                   'putanja' => $this->putanja,
                   'updated_at'=> $this->updated_at
                ]);
        return $rezultat;
    }
}