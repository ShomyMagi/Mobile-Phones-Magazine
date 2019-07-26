<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Role;
use DateTimeZone;
use DateTime;

class UlogaController extends FrontEndController {    
    
    public function deleteRole($id)
    {
        try
        {
            $uloga = new Role();
            
            $uloga->adminDelete($id);
            
            return redirect()->back()->with('success', 'Uspesno ste izbrisali ulogu.');
            
        } catch (\Illuminate\Database\QueryException $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Greska pri brisanju uloge iz baze!');
        }
        catch(\ErrorException $ex) { 
            \Log::error('Greska '.$ex->getMessage());
            return redirect()->back()->with('error', 'Desila se greska..');
        }
    }
    
    public function insertRole(Request $request)
    {
        $rules = ([
            'tbRole' => 'required'
        ]);
        
        $custom_messages = ([
            'required' => 'Polje :attribute je obavezno.'
        ]);
        
        $request->validate($rules, $custom_messages);
        
        $timezone = new DateTimeZone('Europe/Belgrade');
        $date = new DateTime('now', $timezone);
        $date->format('d.m.Y');
        
        try
        {
            $uloga = new Role();
            
            $uloga->naziv = $request->get('tbRole');
            $uloga->created_at = $date;
            $uloga->updated_at = null;
            
            $uloga->adminInsert();
            
            return redirect('/admin/roles')->with('success', 'Uspesno ste uneli '.$uloga->naziv.' ulogu.');
            
        } catch (\Illuminate\Database\QueryException $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Greska pri dodavanju uloge u bazu!');
        }
        catch(\ErrorException $ex) { 
            \Log::error('Greska '.$ex->getMessage());
            return redirect()->back()->with('error', 'Desila se greska..');
        }
    }
    
    public function updateRole(Request $request, $id)
    {
        try
        {
            $uloga = new Role();
            
            $timezone = new DateTimeZone('Europe/Belgrade');
            $date = new DateTime('now', $timezone);
            $date->format('d.m.Y');
            
            $role = $request->get('tbRole');
            $uloga->naziv = $role;
            $uloga->updated_at = $date;
            
            $uloga->adminUpdate($id);
            
            return redirect('/admin/roles')->with('success','Uspesan update uloge! ');
            
        } catch (\Illuminate\Database\QueryException $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Greska pri menjanju uloge u bazi!');
        }
        catch(\ErrorException $ex) { 
            \Log::error('Greska '.$ex->getMessage());
            return redirect()->back()->with('error', 'Desila se greska..');
        }
    }
}
