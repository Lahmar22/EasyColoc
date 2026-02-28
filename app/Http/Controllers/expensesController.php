<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorie;
use App\Models\Expense;
use App\Models\Colocation;
use App\Models\Payment;
use App\Models\Membership;
class expensesController extends Controller
{
    public function index(){
        $categories = Categorie::all();
        $expenses = Expense::join('personnes', 'expenses.utilisateur_id', '=', 'personnes.id')
                            ->join('categories', 'expenses.category_id', '=', 'categories.id')
                            ->select('expenses.*', 'personnes.name as user_name', 'categories.name as category_name')
                            ->get();

        return view('user.expenses', compact('categories', 'expenses'));
    }

    public function addCategory(Request $request){
        $input = $request->validate([
            'category_name' => ['required']
        ]);

        Categorie::create([
            'name' => $input['category_name'],
        ]);

        return redirect()->route('user.expenses');
    }

    public function addExpense(Request $request){
        $input = $request->validate([
            'title' => ['required'],
            'amount' => ['required', 'numeric'],
            'date' => ['required', 'date'],
            'category_id' => ['required', 'exists:categories,id']
        ]);

        $coloc = Colocation::where('utilisateur_id', auth()->id())->first();

        Expense::create([
            'titre' => $input['title'],
            'amount' => $input['amount'],
            'expense_date' => $input['date'],
            'colocation_id' => $coloc->id,
            'utilisateur_id' => auth()->id(),
            'category_id' => $input['category_id']
        ]);

        $countUsers = Membership::where('colocation_id', $coloc->id)->count();
        $members = Membership::where('colocation_id', $coloc->id)->get();
        $amountPerUser = $input['amount'] / $countUsers;

        
        for ($i=0; $i < $countUsers ; $i++) {
            if($members[$i]->utilisateur_id == auth()->id()){
                $status = true;
            }
            else{
                $status = false;
            }

            Payment::create([
                'amount' => $amountPerUser,
                'status' => $status,
                'utilisateur_id' => $members[$i]->utilisateur_id,
                'colocation_id' => $coloc->id,
                'category_id' => $input['category_id']
            ]);
            
        }
        

        return redirect()->route('user.expenses');
    }
}
