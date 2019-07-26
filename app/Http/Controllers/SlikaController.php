<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\Slika;
use DateTimeZone;
use DateTime;

class SlikaController extends FrontEndController {
    
    public function insertImage(Request $request)
    {
        $rules = ([            
            'fileImage' => 'mimes:jpg,jpeg,png,gif|max:4000',
            'tbAlt' => 'required',
            'ddlFeatured' => 'required|not_in:3',
            'ddlUredjaj' => 'required|not_in:0'
        ]);
        
        $custom_messages = ([
            'max' => 'Fajl ne sme biti veci od :max KB',
            'mimes' => 'Dozvoljeni formati su: :values',
            'required' => 'Polje :attribute je obavezno.',
            'ddlFeatured.not_in' => 'Izaberite da li je slika featured!',
            'ddlUredjaj.not_in' => 'Izaberite da li je slika featured!'
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
            $slika = new Slika();
                                    
            $slika->putanja = $putanja;
            $slika->alt = $request->get('tbAlt');
            
            $featured = $request->get('ddlFeatured');
            $uredjaj = $request->get('ddlUredjaj');
            
            if($featured == 1)
            {
                $slika->featured = 1;
            }
            else if($featured == 0)
            {
                $slika->featured = 0;
            }
            
            $slika->id_uredjaj = $uredjaj;
            $slika->inserted_at = $date;
            $slika->updated_at = null;
            $slika->insertSlika();
            
            return redirect('/admin/images')->with('success', 'Uspesno ste uneli sliku');
            
        } catch (\Illuminate\Database\QueryException $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Greska pri dodavanju slike u bazu!');
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
    
    public function deleteImage($id)
    {
        $slika = new Slika();
        
        try
        {
            $image_to_delete = $slika->getImage($id);
            File::delete($image_to_delete->putanja);
            
            $slika->deleteSlika($id);
            
            return redirect('/admin/images')->with('success', 'Uspesno ste izbrisali sliku.');
            
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
    
    public function updateSlika(Request $request, $id)
    {
        $request->validate([
            'fileImage' => 'mimes:jpg,jpeg,png,gif|max:4000',
            'ddlFeatured' => 'required|not_in:3'
        ],[
            'fileImage.mimes' => 'Format nije dozvoljen!',
            'max' => 'Fajl ne sme biti veci od :max KB.',
            'ddlFeatured.not_in' => 'Izaberite da li je slika featured!'
        ]);
        
        $slikaPutanja = $request->file('fileImage');
        
        $timezone = new DateTimeZone('Europe/Belgrade');
        $date = new DateTime('now', $timezone);
        $date->format('d.m.Y');
        
        try
        {
            $slika = new Slika();
            
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
            
            $slika->id_uredjaj = $request->get('ddlUredjaj');
            
            if(!empty($slikaPutanja))
            {     

                $slika_to_update = $slika->getImage($id);
                File::delete($slika_to_update->putanja);
                               
                $filename = $slikaPutanja->getClientOriginalName();
                $image_resize = Image::make($slikaPutanja->getRealPath());
                $image_resize->resize(1200, 650);
                $putanja = 'images/'.$filename;
                $image_resize->save(public_path($putanja));

                $slika->putanja = $putanja;
            }
            
            $slika->updateSlika($id);

            return redirect('/admin/images')->with('success','Uspesan update slike! ');
            
        } catch (\Illuminate\Database\QueryException $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Greska pri menjanju slike u bazi!');
        }
        catch (\Symfony\Component\HttpFoundation\File\Exception\FileException $ex) {
            \Log::error('Problem sa file-om '.$ex->getMessage());
            return redirect()->back()->with('error', 'Greska pri promeni slike!');
        }
        catch (\Exception $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Desila se greska..');
        }
    }
}
