<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Navigation;
use DateTimeZone;
use DateTime;

class NavigationController extends FrontEndController {
    
    public function deleteNavigation($id)
    {
        try
        {
            $navigacija = new Navigation();
            
            $navigacija->adminDelete($id);
            
            return redirect()->back()->with('success', 'Uspesno ste izbrisali navigaciju.');
            
        } catch (\Illuminate\Database\QueryException $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Greska pri brisanju navigacije iz baze!');
        }
        catch(\ErrorException $ex) { 
            \Log::error('Greska '.$ex->getMessage());
            return redirect()->back()->with('error', 'Desila se greska..');
        }
    }
    
    public function insertNavigation(Request $request)
    {
        $rules = ([
            'tbTitle' => 'required',
            'tbRoute' => 'required'
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
            $nav = new Navigation();
            
            $nav->naziv = $request->get('tbTitle');
            $nav->putanja = $request->get('tbRoute');
            $nav->created_at = $date;
            $nav->updated_at = null;
            
            $nav->adminInsert();
            
            return redirect('/admin/navigation')->with('success', 'Uspesno ste uneli '.$nav->naziv.' navigaciju.');
            
        } catch (\Illuminate\Database\QueryException $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Greska pri dodavanju uloge u bazu!');
        }
        catch(\ErrorException $ex) { 
            \Log::error('Greska '.$ex->getMessage());
            return redirect()->back()->with('error', 'Desila se greska..');
        }
    }
    
    public function updateNavigation(Request $request, $id)
    {
        try
        {
            $navigacija = new Navigation();
            
            $timezone = new DateTimeZone('Europe/Belgrade');
            $date = new DateTime('now', $timezone);
            $date->format('d.m.Y');
            
            $title = $request->get('tbTitle');
            $route = $request->get('tbRoute');
            $navigacija->naziv = $title;
            $navigacija->putanja = $route;
            $navigacija->updated_at = $date;
            
            $navigacija->adminUpdate($id);
            
            return redirect('/admin/navigation')->with('success','Uspesan update navigacije! ');
            
        } catch (\Illuminate\Database\QueryException $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Greska pri menjanju navigacije u bazi!');
        }
        catch(\ErrorException $ex) { 
            \Log::error('Greska '.$ex->getMessage());
            return redirect()->back()->with('error', 'Desila se greska..');
        }
    }
}
