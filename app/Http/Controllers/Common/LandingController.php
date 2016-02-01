<?php

namespace App\Http\Controllers\Common;

use App\Models\Page;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class LandingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('public.landing')
            ->with('intro', Page::findBySlug('intro'))
            ->with('tupoksi', Page::findBySlug('tupoksi'))
            ->with('renstra', Page::findBySlug('rencana-strategis'))
            ->with('regulasi', Page::findBySlug('regulasi'))
            ->with('lakip', Page::findBySlug('lakip'));
    }

    /**
     * @param $slug
     * @return $this
     * @author Fathur Rohman <fathur@dragoncapital.center>
     */
    public function page($slug)
    {
        $page = Page::findBySlug($slug);

        if($page == null)
        {
            return abort(404);
        }

        return view('public.page')
            ->with('page', $page);
    }
}
