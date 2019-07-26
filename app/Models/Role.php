<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;

class Role {
    
    public $id;
    public $naziv;
    public $created_at;
    public $updated_at;
    
    public function adminRoles()
    {
        $rezultat = DB::table('uloge')
                ->get();
        return $rezultat;
    }
    
    public function getRole($id)
    {
        $rezultat = DB::table('uloge')
                ->where('id_uloga', '=', $id)
                ->first();
        return $rezultat;
    }
    
    public function adminDelete($id)
    {
        $rezultat = DB::table('uloge')
                ->where('id_uloga', '=', $id)
                ->delete();
        return $rezultat;
    }
    
    public function adminInsert()
    {
        $rezultat = DB::table('uloge')
                ->insert([
                   'naziv' => $this->naziv,
                   'created_at' => $this->created_at,
                   'updated_at' => $this->updated_at
                ]);
        return $rezultat;
    }
    
    public function adminUpdate($id)
    {
        $rezultat = DB::table('uloge')
                ->where('id_uloga', '=', $id)
                ->update([
                   'naziv' => $this->naziv,
                   'updated_at'=> $this->updated_at
                ]);
        return $rezultat;
    }
}
