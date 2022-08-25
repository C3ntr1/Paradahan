<?php

namespace App\Http\Controllers;

use App\Repository\Eloquent\TransactionRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(private TransactionRepository $transactionRepository)
    {
        $this->middleware('auth');
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $sales = $this->transactionRepository->sales();
        return view('home', compact('sales'));
    }
}
