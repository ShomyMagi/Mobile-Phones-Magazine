<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Comment;
use DateTimeZone;
use DateTime;

class CommentController extends FrontEndController{
    
    public function insertComment($id, Request $request)
    {
        $rules = ([
           'comment' => 'required' 
        ]);
        
        $messages = ([
           'comment.required' => 'Post some comment!' 
        ]);
        
        $request->validate($rules, $messages);
        
        $comment = $request->get('comment');
        
        if(session()->has('user'))
        {
            $id_korisnik = session()->get('user')[0]->id_korisnik;
        }
        
        $timezone = new DateTimeZone('Europe/Belgrade');
        $date = new DateTime('now', $timezone);
        $date->format('d.m.Y');
        
        try
        {
            $komentar = new Comment();
            $komentar->tekst = $comment;
            $komentar->id_uredjaj = $id;
            $komentar->id_korisnik = $id_korisnik;
            $komentar->posted_at = $date;
            $komentar->updated_at = null;

            $komentar->insertComment();

            return redirect('/onePost/'.$komentar->id_uredjaj)->with('success', 'You have successfully posted a comment');
            
        } catch (\Illuminate\Database\QueryException $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error','Greska pri unosu komentara u bazu!');
        }
        catch(\ErrorException $ex) { 
            \Log::error('Greska '.$ex->getMessage());
            return redirect()->back()->with('error','Desila se greska..');
        }
    }
    
    public function deleteComment($id, $cId)
    {
        try
        {
            $komentar = new Comment();
            
            $komentar->id_komentar = $cId;
            $komentar->deleteComment();
            
            return redirect()->back()->with('success', 'You have successfully deleted a comment');
            
        } catch (\Illuminate\Database\QueryException $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Greska pri brisanju komentara iz baze!');
        }
        catch(\ErrorException $ex) { 
            \Log::error('Greska '.$ex->getMessage());
            return redirect()->back()->with('error', 'Desila se greska..');
        }
    }
    
    public function editComment(Request $request, $id, $cId)
    {
        try
        {
            $komentar = new Comment();
            
            $timezone = new DateTimeZone('Europe/Belgrade');
            $date = new DateTime('now', $timezone);
            $date->format('d.m.Y');
            
            $tekst = $request->get('comment');
            $komentar->id_komentar = $cId;
            $komentar->tekst = $tekst;
            $komentar->updated_at = $date;
            
            $komentar->editComment();
            
            return redirect('/onePost/'.$id)->with('success','You have successfully updated a comment');
            
        } catch (\Illuminate\Database\QueryException $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Greska pri menjanju komentara u bazi!');
        }
        catch(\ErrorException $ex) { 
            \Log::error('Greska '.$ex->getMessage());
            return redirect()->back()->with('error', 'Desila se greska..');
        }
    }
    
    public function deleteAdminComment($id)
    {
        try
        {
            $komentar = new Comment();
            
            $komentar->adminDelete($id);
            
            return redirect()->back()->with('success', 'Uspesno ste izbrisali komentar.');
            
        } catch (\Illuminate\Database\QueryException $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Greska pri brisanju komentara iz baze!');
        }
        catch(\ErrorException $ex) { 
            \Log::error('Greska '.$ex->getMessage());
            return redirect()->back()->with('error', 'Desila se greska..');
        }
    }
    
    public function insertAdminComment(Request $request)
    {
         $rules = ([
            'tbComment' => 'required',
            'ddlUredjaj' => 'required|not_in:0',
            'ddlKorisnik' => 'required|not_in:0'
        ]);
        
        $custom_messages = ([
            'required' => 'Polje :attribute je obavezno.',
            'ddlUredjaj.not_in' => 'Izaberite na kom postu cete da komentarisete!',
            'ddlKorisnik.not_in' => 'Izaberite koji korisnik ce komentarisati!'
        ]);
        
        $request->validate($rules, $custom_messages);
        
        $timezone = new DateTimeZone('Europe/Belgrade');
        $date = new DateTime('now', $timezone);
        $date->format('d.m.Y');
        
        try
        {
            $komentar = new Comment();
            
            $komentar->tekst = $request->get('tbComment');
            $komentar->id_uredjaj = $request->get('ddlUredjaj');
            $komentar->id_korisnik = $request->get('ddlKorisnik');
            $komentar->posted_at = $date;
            $komentar->updated_at = null;
            
            $komentar->adminInsert();
            
            return redirect('/admin/comments')->with('success', 'Uspesno ste uneli '.$komentar->tekst);
            
        } catch (\Illuminate\Database\QueryException $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Greska sa bazom pri unosu!');
        }
        catch (\Exception $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Desila se greska..');
        }
    }
    
    public function updateComment(Request $request, $id)
    {
        try
        {
            $komentar = new Comment();
            
            $timezone = new DateTimeZone('Europe/Belgrade');
            $date = new DateTime('now', $timezone);
            $date->format('d.m.Y');
            
            $tekst = $request->get('tbComment');
            $komentar->tekst = $tekst;
            $komentar->updated_at = $date;
            
            $komentar->adminUpdate($id);
            
            return redirect('/admin/comments')->with('success','Uspesan update komentara! ');
            
        } catch (\Illuminate\Database\QueryException $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Greska sa bazom pri promeni komentara!');
        }
        catch (\Exception $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Desila se greska..');
        }
    }
}
