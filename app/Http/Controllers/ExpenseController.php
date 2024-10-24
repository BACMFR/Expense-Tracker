<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Services\ExpenseService;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    protected $expenseService;

    public function __construct(ExpenseService $expenseService)
    {
        $this->expenseService = $expenseService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenses = $this->expenseService->getAllExpenses();
        return response()->json($expenses);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $expense = $this->expenseService->storeExpense([
            'description' => $request->description,
            'amount' => $request->amount,
            'category' => $request->category,
            'date' => $request->date 
        ]);

        if ($expense) {
            return response()->json($expense, 201);
        }

        return response()->json(['error' => 'Failed to create expense'], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        return response()->json($expense);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        // 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expense $expense)
    {
        $updatedExpense = $this->expenseService->updateExpense($expense, [
            'description' => $request->description,
            'amount' => $request->amount,
            'category' => $request->category,
            'date' => $request->date 
        ]);

        return response()->json($updatedExpense);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        $this->expenseService->deleteExpense($expense);
        return response()->json(['message' => 'Expense deleted successfully']);
    }

    /**
     * Get a summary of all expenses.
     *
     * @return \Illuminate\Http\Response
     */
    public function summary()
    {
        $total = $this->expenseService->getSummary();
        return response()->json(['total' => $total]);
    }

    /**
     * Get a monthly summary of expenses.
     *
     * @param  int  $month
     * @return \Illuminate\Http\Response
     */
    public function monthlySummary($month)
    {
        $expenses = $this->expenseService->monthlySummary($month);
        return response()->json($expenses);
    }
}
