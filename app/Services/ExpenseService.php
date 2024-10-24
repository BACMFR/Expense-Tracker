<?php

namespace App\Services;

use App\Models\Expense;

class ExpenseService
{
    public function getAllExpenses()
    {
        $expenses = Expense::all();
        if ($expenses->isNotEmpty()) {
            return [
                'success' => true,
                'message' => 'All Expenses',
                'data' => $expenses
            ];
        }
        return [
            'success' => false,
            'message' => 'No expenses found'
        ];
    }

    public function storeExpense($data)
    {
        $expense = Expense::create([
            'description' => $data['description'],
            'amount' => $data['amount'],
            'category' => $data['category'],
            'date' => $data['date']
        ]);

        if (!$expense) {
            return [
                'success' => false,
                'message' => 'Expense not created',
            ];
        }
        return [
            'success' => true,
            'message' => 'Created Successfully',
            'data' => $expense
        ];
    }

    public function updateExpense(Expense $expense, $data)
    {
        $updated = $expense->update([
            'description' => $data['description'],
            'amount' => $data['amount'],
            'category' => $data['category'],
            'date' => $data['date']
        ]);

        if (!$updated) {
            return [
                'success' => false,
                'message' => 'Expense not updated',
            ];
        }
        return [
            'success' => true,
            'message' => 'Updated Successfully',
            'data' => $expense
        ];
    }

    public function deleteExpense(Expense $expense)
    {
        $deleted = $expense->delete();

        if (!$deleted) {
            return [
                'success' => false,
                'message' => 'Expense not deleted',
            ];
        }
        return [
            'success' => true,
            'message' => 'Deleted Successfully',
            'data' => null
        ];
    }

    public function monthlySummary($month)
    {
        $expenses = Expense::whereMonth('date', $month)->get();
        $total = $expenses->sum('amount');
        return response()->json([
            'success' => true,
            'message' => 'Monthly Summary',
            'data' => $expenses,
            'total' => $total
        ]);
    }

    public function getSummary()
    {
        $total = Expense::sum('amount');
        return [
            'success' => true,
            'message' => 'Total Amount',
            'data' => null,
            'total' => $total
        ];
    }
}
