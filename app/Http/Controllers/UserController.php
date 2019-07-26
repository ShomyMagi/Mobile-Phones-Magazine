<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\User;
use DateTimeZone;
use DateTime;
use Mail;

class UserController extends FrontEndController {
    
    public function register(Request $request)
    {
        $rules = ([
            'username' => 'regex:/^[\w\d\s]{2,20}$/|unique:korisnici,username',
            'ime' => 'regex:/^[A-z]{3,20}$/',
            'prezime' => 'regex:/^[A-z]{4,25}$/',
            'email' => 'regex:/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/',
            'password' => 'regex:/^[\w\d\s]{3,15}$/|confirmed',
            'avatar' => 'mimes:jpg,jpeg,png,gif|max:4000'
        ]);
        
        $custom_messages = ([
            'max' => 'Fajl ne sme biti veci od :max KB',
            'mimes' => 'Dozvoljeni formati su: :values',
            'username.regex' => 'Polje :attribute nije u ispravnom formatu',
            'ime.regex' => 'Polje :attribute nije u ispravnom formatu',
            'prezime.regex' => 'Polje :attribute nije u ispravnom formatu',
            'email.regex' => 'Polje :attribute nije u ispravnom formatu',
            'password.regex' => 'Polje :attribute nije u ispravnom formatu',
            'username.unique' => 'Korisnicko ime je zauzeto'
        ]);
        
        $request->validate($rules, $custom_messages);
        
        $avatar = $request->file('avatar');
        $filename = $avatar->getClientOriginalName();
        $image_resize = Image::make($avatar->getRealPath());
        $image_resize->resize(300, 300);
        $putanja = 'images/avatar/'.$filename;
        $image_resize->save(public_path($putanja));
                                           
        $timezone = new DateTimeZone('Europe/Belgrade');
        $date = new DateTime('now', $timezone);
        $date->format('d.m.Y');
        
        try
        {
            
            $user = new User();
            $user->username = $request->get('username');
            $user->password = $request->get('password');
            $user->ime = $request->get('ime');
            $user->prezime = $request->get('prezime');
            $user->email = $request->get('email');
            $user->avatar = $putanja;
            $user->registered_at = $date;
            $user->updated_at = null;
            $user->register();
            
            return redirect('/')->with('success', 'You have successfully registered '.$user->username);
        }
        catch (\Illuminate\Database\QueryException $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Greska sa bazom pri registraciji!');
        }
        catch (\Symfony\Component\HttpFoundation\File\Exception\FileException $ex) {
            \Log::error('Problem sa file-om '.$ex->getMessage());
            return redirect()->back()->with('error', 'Greska pri dodavanju avatara!');
        }
        catch (\Exception $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Desila se greska..');
        }
    }
    
    public function login(Request $request)
    {
        $request->validate([
            'username' => ['required','alpha_num'],
            'password' => ['required']
            ], [
                'required' => 'Polje :attribute je obavezno!'
        ]);
        
        $username = $request->get('username');
        $password = $request->get('password');
        
        $user = new User();
        $user->username = $username;
        $user->password = $password;
        
        $userkLogin = $user->login();
        
        if(!empty($userkLogin))
        {
            $request->session()->push('user', $userkLogin);
            if(session()->get('user')[0]->naziv == 'admin')
            {
                return redirect('/admin/users')->with('success', 'You have successfully logged in '.$username);              
            }
            else
            {
                return redirect('/user')->with('success', 'You have successfully logged in '.$username);
            }               
        }
        return redirect('/register')->with('error', 'Username or Password is incorrect!');
    }
    
    public function logout(Request $request)
    {
        try
        {
            $request->session()->forget('user');
            $request->session()->flush();
            return redirect('/');
        } catch (\Exception $ex) {
            \Log::error($ex->getMessage());
        }
    }
    
    public function about()
    {
        return view('pages.about', $this->data);
    }
    
    public function sendMail(Request $request)
    {
        try
        {   
            if(session()->has('user'))
            {   
                $tema = $request->get('subject');
                $poruka = $request->get('message');
                
                $data = array('subject' => $tema, 'message' => $poruka);
                
                Mail::send('pages.about', $data, function($message)
                {
                    $message->from(session()->get('user')[0]->email, session()->get('user')[0]->username);
                    $message->to('milos.simic002@gmail.com', 'Milos Simic');
                });
                
                echo "Mail sent";
            }
            else
            {
                $tema = $request->get('subject');
                $poruka = $request->get('message');
                //$email = $request->get('email');
                //$name = $request->get('name');
                
                $data = array('subject' => $tema, 'message' => $poruka);
                
                Mail::send('pages.about', $data, function($message)
                {
                    $message->from($request->get('email'), $request->get('name'));
                    $message->to('milos.simic002@gmail.com', 'Milos Simic');
                });
                
                echo "Mail sent";
            }
            
        } catch (\Exception $ex) {
            \Log::error($ex->getMessage());
        }
    }
    
    public function userPage()
    {
        $korisnik = new User();
        
        try
        {
            if(session()->has('user'))
            {
                $id = session()->get('user')[0]->id_korisnik;
                $this->data['userPage'] = $korisnik->getUser($id);
                $this->data['userComments'] = $korisnik->showComments($id);
                return view('pages.userPage', $this->data);
            }
                
        } catch (\Exception $ex) {
            \Log::error($ex->getMessage());
        }
    }
    
    public function showUser($id)
    {
        try
        {
            $u = new User();
            $this->data['showUser'] = $u->getUser($id);
            return view('pages.userUpdate', $this->data);
        } catch (\Exception $ex) {
            \Log::error($ex->getMessage());
        }
    }
    
    public function editUser($id, Request $request)
    {
        $request->validate([
            'avatar' => 'mimes:jpg,jpeg,png,gif|max:4000',
            'password' => 'confirmed'
        ],[
            'avatar.mimes' => 'Format nije dozvoljen!',
            'max' => 'Fajl ne sme biti veci od :max KB.',
            'password.confirmed' => 'Lozinke moraju biti iste!'
        ]);
        
        $username = $request->get('username');
        $email = $request->get('email');
        $pass = $request->get('password');
        
        $avatar = $request->file('avatar');      
        
        $timezone = new DateTimeZone('Europe/Belgrade');
        $date = new DateTime('now', $timezone);
        $date->format('d.m.Y');
        
        try
        {
            $kor = new User();
            $kor->id = $id;
            $kor->username = $username;
            $kor->email = $email;
            $kor->updated_at = $date;
            
            if(!empty($pass))
            {
                $password = md5($request->get('password'));
                $kor->password = $password;
            }
            
            if(!empty($avatar))
            {
                
                $korisnik_to_update = $kor->getUser($id);
                File::delete($korisnik_to_update->avatar);
                
                $filename = $avatar->getClientOriginalName();
                $image_resize = Image::make($avatar->getRealPath());
                $image_resize->resize(300, 300);
                $putanja = 'images/avatar/'.$filename;
                $image_resize->save(public_path($putanja));

                $kor->avatar = $putanja;
            }

                $kor->editUser($id);
            
            return redirect('/user')->with('success','You have successfully updated your account');
            
        } catch (\Illuminate\Database\QueryException $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Greska pri menjanju korisnika u bazi!');
        }
        catch (\Symfony\Component\HttpFoundation\File\Exception\FileException $ex) {
            \Log::error('Problem sa file-om '.$ex->getMessage());
            return redirect()->back()->with('error', 'Greska pri menjanju avatara!');
        }
        catch (\Exception $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Desila se greska..');
        }
    }
    
    public function deleteUser($id)
    {
        try
        {
            $korisnik = new User();
            
            $korisnik_to_delete = $korisnik->getUser($id);
            File::delete($korisnik_to_delete->avatar);
            
            $korisnik->adminDelete($id);
            
            return redirect()->back()->with('success', 'Uspesno ste izbrisali korisnika.');
            
        } catch (\Illuminate\Database\QueryException $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Greska pri brisanju korisnika iz baze!');
        }
        catch(\ErrorException $ex) { 
            \Log::error('Greska '.$ex->getMessage());
            return redirect()->back()->with('error', 'Desila se greska..');
        }
    }
    
    public function insertUser(Request $request)
    {
        $rules = ([
            'tbUsername' => 'regex:/^[\w\d\s]{2,20}$/|unique:korisnici,username',
            'tbIme' => 'regex:/^[A-z]{3,20}$/',
            'tbPrezime' => 'regex:/^[A-z]{4,25}$/',
            'tbEmail' => 'regex:/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/',
            'tbPassword' => 'regex:/^[\w\d\s]{3,15}$/',
            'fileAvatar' => 'mimes:jpg,jpeg,png,gif|max:4000',
            'ddlUloga' => 'required|not_in:0'
        ]);
        
        $custom_messages = ([
            'max' => 'Fajl ne sme biti veci od :max KB',
            'mimes' => 'Dozvoljeni formati su: :values',
            'tbUsername.regex' => 'Polje :attribute nije u ispravnom formatu',
            'tbIme.regex' => 'Polje :attribute nije u ispravnom formatu',
            'tbPrezime.regex' => 'Polje :attribute nije u ispravnom formatu',
            'tbEmail.regex' => 'Polje :attribute nije u ispravnom formatu',
            'tbPassword.regex' => 'Polje :attribute nije u ispravnom formatu',
            'tbUsername.unique' => 'Korisnicko ime je zauzeto',
            'ddlUloga.not_in' => 'Izaberite ulogu!'
        ]);
        
        $request->validate($rules, $custom_messages);
        
        $avatar = $request->file('fileAvatar');
        $filename = $avatar->getClientOriginalName();
        $image_resize = Image::make($avatar->getRealPath());
        $image_resize->resize(1200, 650);
        $putanja = 'images/'.$filename;
        $image_resize->save(public_path($putanja));    
        
        $timezone = new DateTimeZone('Europe/Belgrade');
        $date = new DateTime('now', $timezone);
        $date->format('d.m.Y');
        
        try
        {
           
            $user = new User();
            $user->username = $request->get('tbUsername');
            $user->password = $request->get('tbPassword');
            $user->ime = $request->get('tbIme');
            $user->prezime = $request->get('tbPrezime');
            $user->email = $request->get('tbEmail');
            $user->avatar = $putanja;
            $user->registered_at = $date;
            $user->updated_at = null;
            $user->id_uloga = $request->get('ddlUloga');
            $user->adminInsert();
            
            return redirect('/admin/users')->with('success', 'Uspesno ste uneli '.$user->username);
        }
        catch (\Illuminate\Database\QueryException $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Greska sa bazom pri unosu!');
        }
        catch (\Symfony\Component\HttpFoundation\File\Exception\FileException $ex) {
            \Log::error('Problem sa file-om '.$ex->getMessage());
            return redirect()->back()->with('error', 'Greska pri dodavanju avatara!');
        }
        catch (\Exception $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Desila se greska..');
        }
    }
    
    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'ddlUloga' => 'not_in:0',
            'avatar' => 'mimes:jpg,jpeg,png,gif|max:4000'
        ],[
            'ddlUloga.not_in' => 'Uloga mora biti izabrana.',
            'avatar.mimes' => 'Format nije dozvoljen!',
            'max' => 'Fajl ne sme biti veci od :max KB.'
        ]);
        
        $username = $request->get('tbUsername');
        $name = $request->get('tbIme');
        $surname = $request->get('tbPrezime');
        $email = $request->get('tbEmail');
        $role = $request->get('ddlUloga');
        
        $pass = $request->get('tbPassword');
        
        if(strlen($pass) == 32)
        {
            $password = $request->get('tbPassword');
        }
        else
        {
            $password = md5($request->get('tbPassword'));
        }
        
        $avatar = $request->file('fileAvatar');
        
        $timezone = new DateTimeZone('Europe/Belgrade');
        $date = new DateTime('now', $timezone);
        $date->format('d.m.Y');
        
        try
        {
            $kor = new User();
            $kor->id = $id;
            $kor->username = $username;
            $kor->ime = $name;
            $kor->prezime = $surname;
            $kor->email = $email;
            $kor->password = $password;
            $kor->id_uloga = $role;
            $kor->updated_at = $date;
            
            if(!empty($avatar))
            {
                $filename = $avatar->getClientOriginalName();
                $image_resize = Image::make($avatar->getRealPath());
                $image_resize->resize(300, 300);
                $putanja = 'images/avatar/'.$filename;
                $image_resize->save(public_path($putanja));
                
                $korisnik_to_update = $kor->getUser($id);
                File::delete($korisnik_to_update->avatar);

                $kor->avatar = $putanja;
            }

                $kor->adminUpdate($id);
            
            return redirect('/admin/users')->with('success','Uspesan update!'.$kor->username);
            
        } catch (\Illuminate\Database\QueryException $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Greska sa bazom pri promeni korisnika!');
        }
        catch (\Symfony\Component\HttpFoundation\File\Exception\FileException $ex) {
            \Log::error('Problem sa file-om '.$ex->getMessage());
            return redirect()->back()->with('error', 'Greska pri menjanju avatara!');
        }
        catch (\Exception $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Desila se greska..');
        }
    }
}
