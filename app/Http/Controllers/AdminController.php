<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Uredjaj;
use App\Models\Comment;
use App\Models\Navigation;
use App\Models\Role;
use App\Models\Slika;

class AdminController extends Controller {
    
    public $data;
    
    public function getUsers($id = null)
    {           
        $user = new User();
        $role = new Role();
        $this->data['users'] = $user->adminUsers();
        $this->data['selectedUser'] = $user->getUser($id);
        $this->data['roles'] = $role->adminRoles();
        return view('pages.admin.admin_users', $this->data);   
    }
    
    public function getPosts($id = null)
    {
        $uredjaj = new Uredjaj();
        $slika = new Slika();
        $slika->id_pos = $id;
        $this->data['uredjaji'] = $uredjaj->adminPosts();
        $this->data['selectedUredjaj'] = $uredjaj->Post($id);
        return view('pages.admin.admin_uredjaji', $this->data);
    }
    
    public function getImages($id = null)
    {
        $slika = new Slika();
        $uredjaj = new Uredjaj();
        $this->data['slike'] = $slika->adminImages();
        $this->data['selectedImage'] = $slika->getImage($id);
        $this->data['uredjaji'] = $uredjaj->adminUredjaji();
        return view('pages.admin.admin_images', $this->data);
    }
    
    public function getComments($id = null)
    {
        $komentar = new Comment();
        $korisnik = new User();
        $uredjaj = new Uredjaj();
        $this->data['komentari'] = $komentar->adminComments();
        $this->data['selectedComment'] = $komentar->getComment($id);
        $this->data['korisnici'] = $korisnik->getAdminUsers();
        $this->data['uredjaji'] = $uredjaj->adminUredjaji();
        return view('pages.admin.admin_comments', $this->data);
    }
    
    public function getNavigation($id = null)
    {
        $navigation = new Navigation();
        $this->data['navigation'] = $navigation->adminNavigation();
        $this->data['selectedNavigation'] = $navigation->getNav($id);
        return view('pages.admin.admin_navigation', $this->data);
    }
    
    public function getRoles($id = null)
    {
        $role = new Role();
        $this->data['roles'] = $role->adminRoles();
        $this->data['selectedRole'] = $role->getRole($id);
        return view('pages.admin.admin_roles', $this->data);
    }
}
