<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\Uredjaj;
use App\Models\Comment;
use App\Models\Slika;
use DateTimeZone;
use DateTime;

class UredjajController extends FrontEndController {
    
    public $data;
    public $archive;
    
    public function index()
    {
        try
        {
            $uredjaj = new Uredjaj();
            $this->data['prvi'] = $uredjaj->getFirst();
            $this->data['drugi'] = $uredjaj->getSecond();
            $this->data['treci'] = $uredjaj->getThird();
            $this->data['ostali'] = $uredjaj->getOthers();
            $this->data['popular'] = $uredjaj->popularNews();
            return view('pages.index', $this->data);
            
        } catch (\Exception $ex) {
            \Log::error($ex->getMessage());
        }
    }
    
    public function search(Request $request)
    {   
        try
        {
            $uredjaj = new Uredjaj();
            $value = $request->get('searchValue');
            $this->data['rezultat'] = $uredjaj->search($value);
            return view('pages.search', $this->data);            
            
        } catch (\Exception $ex) {
            \Log::error($ex->getMessage());
        }
    }
    
    public function archive(Request $request)
    {
        try
        {
            $uredjaj = new Uredjaj();
            $value = $request->get('sortiranje');
            
            if($value == 1)
            {
                $this->archive['postAsc'] = $uredjaj->postAsc();
                return view('pages.archiveOthers', $this->archive);
            }
            elseif($value == 2)
            {
                $this->archive['allPosts'] = $uredjaj->adminPosts();
                return view('pages.archiveOthers', $this->archive);
            }
            else
            {
                $this->data['postName'] = $uredjaj->postName();
                return view('pages.archive', $this->data);
            }
            
        } catch (\Exception $ex) {
            \Log::error($ex->getMessage());
        }
    }
    
    
    public function onePost(Request $request, $id, $cId = null)
    {
        try
        {
            $post = new Uredjaj();
            $comm = new Comment();
            $slika = new Slika();
            $comm->id_komentar = $cId;
            $slika->id_pos = $id;
            $post->views($id, $request->ip());
            $this->data['onePost'] = $post->onePost($id);
            $this->data['post'] = $post->Post($id);
            $this->data['getImages'] = $slika->getImages();
            $this->data['comments'] = $comm->getAll($id);
            $this->data['selectedComm'] = $comm->get($id);
            return view('pages.onePost', $this->data);
        } catch (\Exception $ex) {
            \Log::error($ex->getMessage());
        }
    }
    
    public function deletePost($id)
    {
        $uredjaj = new Uredjaj();
        $uredjaj->id = $id;
        
        $slika = new Slika();
        $slika->id_pos = $id;
        
        try
        {
            $post_to_delete = $slika->getImages();
            foreach($post_to_delete as $pic)
            {
                File::delete($pic->putanja);
            }
            
            $slika->deleteSlike();
            $uredjaj->adminDelete();
            
            return redirect('/admin/posts')->with('success', 'Uspesno ste izbrisali post.');
            
        } catch (\Illuminate\Database\QueryException $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Greska pri brisanju slike iz baze!');
        }
        catch (\Symfony\Component\HttpFoundation\File\Exception\FileException $ex) {
            \Log::error('Problem sa file-om '.$ex->getMessage());
            return redirect()->back()->with('error', 'Greska pri brisanju slike!');
        }
        catch (\Exception $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Desila se greska..');
        }
    }
    
    public function insertPost(Request $request)
    {
        $rules = ([            
            'fileImage' => 'mimes:jpg,jpeg,png,gif|max:4000',
            'tbNaziv' => 'required',
            'tbHeadline' => 'required',
            'tbText' => 'required',
            'tbAlt' => 'required',
            'ddlFeatured' => 'required|not_in:3'
        ]);
        
        $custom_messages = ([
            'max' => 'Fajl ne sme biti veci od :max KB',
            'mimes' => 'Dozvoljeni formati su: :values',
            'required' => 'Polje :attribute je obavezno.',
            'ddlFeatured.not_in' => 'Izaberite da li je slika featured!'
        ]);
        
        $request->validate($rules, $custom_messages);
         
        $slikaPutanja = $request->file('fileImage');
        $filename = $slikaPutanja->getClientOriginalName();
        $image_resize = Image::make($slikaPutanja->getRealPath());
        $image_resize->resize(1200, 650);
        $putanja = 'images/'.$filename;
        $image_resize->save(public_path($putanja));                            
        
        $timezone = new DateTimeZone('Europe/Belgrade');
        $date = new DateTime('now', $timezone);
        $date->format('d.m.Y');
        
        try
        {
            
            $post = new Uredjaj(); 
            $slika = new Slika();
            
            $post->naziv = $request->get('tbNaziv');
            $post->headline = $request->get('tbHeadline');
            $post->text = $request->get('tbText');
            $post->created_at = $date;
            $post->updated_at = null;
            $post_id = $post->adminInsert();
            
            $slika->putanja = $putanja;
            $slika->alt = $request->get('tbAlt');
            
            $featured = $request->get('ddlFeatured');
            
            if($featured == 1)
            {
                $slika->featured = 1;
            }
            else if($featured == 0)
            {
                $slika->featured = 0;
            }
            
            $slika->id_uredjaj = $post_id;
            $slika->inserted_at = $date;
            $slika->updated_at = null;
            $slika->insertSlika();
            
            return redirect('/admin/posts')->with('success', 'Uspesno ste uneli '.$post->naziv);
            
        } catch (\Illuminate\Database\QueryException $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Greska sa bazom pri unosu!');
        }
        catch (\Symfony\Component\HttpFoundation\File\Exception\FileException $ex) {
            \Log::error('Problem sa file-om '.$ex->getMessage());
            return redirect()->back()->with('error', 'Greska pri dodavanju slike!');
        }
        catch (\Exception $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Desila se greska..');
        }
    }
    
    public function updatePost(Request $request, $id)
    {
        $timezone = new DateTimeZone('Europe/Belgrade');
        $date = new DateTime('now', $timezone);
        $date->format('d.m.Y');
        
        try
        {           
            $naziv = $request->get('tbNaziv');
            $headline = $request->get('tbHeadline');
            $text = $request->get('tbText');
            $uredjaj = new Uredjaj();

            $uredjaj->id = $id;
            $uredjaj->naziv = $naziv;
            $uredjaj->headline = $headline;
            $uredjaj->text = $text;
            $uredjaj->updated_at = $date;

            $uredjaj->adminUpdate($id);

            return redirect('/admin/posts')->with('success','Uspesan update post-a! '.$uredjaj->naziv);
            
        } catch (\Illuminate\Database\QueryException $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Greska sa bazom pri promeni posta!');
        }
        catch (\Symfony\Component\HttpFoundation\File\Exception\FileException $ex) {
            \Log::error('Problem sa file-om '.$ex->getMessage());
            return redirect()->back()->with('error', 'Greska pri menjanju slike!');
        }
        catch (\Exception $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Desila se greska..');
        }
    }
}
