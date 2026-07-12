<?php
// app/Http/Controllers/Public/PageController.php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Show terms of service page
     */
    public function terms()
    {
        return view('landing.terms');
    }
    
    /**
     * Show privacy policy page
     */
    public function privacy()
    {
        return view('landing.privacy');
    }
    
    /**
     * Show FAQ page
     */
    public function faq()
    {
        $faqs = [
            [
                'question' => 'Apa itu CoreSite?',
                'answer' => 'CoreSite adalah platform SaaS yang memungkinkan UMKM memiliki website toko online profesional dengan sistem kasir otomatis dalam hitungan menit.'
            ],
            [
                'question' => 'Apakah ada biaya pendaftaran?',
                'answer' => 'Pendaftaran gratis! Anda bisa mencoba paket Starter selamanya dengan batasan 100 produk.'
            ],
            [
                'question' => 'Apakah saya bisa menggunakan domain sendiri?',
                'answer' => 'Ya, untuk paket Enterprise Anda bisa menggunakan custom domain untuk toko Anda.'
            ],
            [
                'question' => 'Bagaimana dengan keamanan data?',
                'answer' => 'Data Anda aman dengan enkripsi SSL, backup rutin, dan isolasi data antar toko.'
            ],
            [
                'question' => 'Apada support untuk berbagai pembayaran?',
                'answer' => 'Saat ini support cash, transfer bank, dan QRIS. Kami akan menambah payment gateway segera.'
            ]
        ];
        
        return view('landing.faq', compact('faqs'));
    }
    
    /**
     * Show blog page (optional)
     */
    public function blog()
    {
        // You can implement blog posts here
        return view('landing.blog');
    }
    
    /**
     * Show single blog post
     */
    public function blogPost($slug)
    {
        return view('landing.blog-post');
    }
}