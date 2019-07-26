<?php

namespace App\Http\Controllers;
use App\Models\Navigation;
use App\Models\Slika;
use App\Models\Comment;

class FrontEndController extends Controller {
    
    public $data;
    
    public function __construct() {
        $nav = new Navigation();
        $slika = new Slika();
        $komentar = new Comment();
        $this->data['all'] = $nav->getAll();
        $this->data['admin'] = $nav->getAdmin();
        $this->data['user'] = $nav->getUser();
        $this->data['sign'] = $nav->getSignIn();
        $this->data['logout'] = $nav->getLogout();
        $this->data['instaImages'] = $slika->instaImages();
        $this->data['getComments'] = $komentar->getComments();
    }
    
    public function getRegister()
    {
        return view('pages.register');
    }
}
