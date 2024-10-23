<?php

namespace App\Repositories;

use App\Interfaces\TransactionRepositoryInterface;
use App\Models\Room;
use App\Models\Transaction;

class TransactionRepository implements TransactionRepositoryInterface {
    public function getTransactionDataFromSession()
    {
        return session()->get("transaction");
    }

    public function saveTransactionDataToSession($data) {
        $transaction = session()->get("transaction", []);
        foreach ($data as $key => $value) {
            $transaction[$key] = $value;
        }
        session()->put("transaction", $transaction);
    }

    public function saveTransaction($data) {
        $room = Room::find($data["room_id"]);
        $data = $this->prepareTransactionData($data, $room);
        $transaction = Transaction::create($data);
        session()->forget("transaction");
        return $transaction;
    }

    public function getTransactionByCode($code) {
        return Transaction::where('code', $code)->first();
    }

    public function prepareTransactionData($data, $room) {
        $data['code'] = $this->generateTransactionCode();
        $data['payment_status'] = 'pending';
        $data['transaction_date'] = now();
        $total = $this->calculateTotalAmount($room->price_per_month, $data['duration']);
        $data['total_amount'] = $this->calculatePaymentAmount($total, $data['payment_method']);
        return $data;
    }

    public function generateTransactionCode() {
        return 'NGKBWA' . rand(100000, 999999);
    }

    public function calculateTotalAmount($pricePerMonth, $duration) {
        $subtotal = $pricePerMonth * $duration;
        $tax = $subtotal * 0.11;
        $insurance = $subtotal * 0.01;
        return $subtotal + $tax + $insurance;
    }

    public function calculatePaymentAmount($total, $paymentMethod) {
        return $paymentMethod === 'full_payment' ? $total : $total * 0.3;
    }
}
