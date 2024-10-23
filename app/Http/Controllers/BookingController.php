<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerInformationStoreRequest;
use App\Interfaces\BoardingHouseRepositoryInterface;
use App\Interfaces\TransactionRepositoryInterface;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    private BoardingHouseRepositoryInterface $boardingHouseRepository;
    private TransactionRepositoryInterface $transactionRepository;

    public function __construct(BoardingHouseRepositoryInterface $boardingHouseRepository, TransactionRepositoryInterface $transactionRepository)
    {
        $this->boardingHouseRepository = $boardingHouseRepository;
        $this->transactionRepository = $transactionRepository;
    }

    public function booking(Request $request, $slug)
    {
        $this->transactionRepository->saveTransactionDataToSession($request->all());
        return redirect()->route('booking.information', $slug);
    }

    public function information($slug)
    {
        $transaction = $this->transactionRepository->getTransactionDataFromSession();
        $boardingHouse = $this->boardingHouseRepository->getBoardingHouseBySlug($slug);
        $room = $this->boardingHouseRepository->getBoardingHouseRoomById($transaction['room_id']);
        return view('pages.booking.information', compact('transaction', 'boardingHouse', 'room'));
    }

    public function saveInformation(CustomerInformationStoreRequest $request, $slug)
    {
        $data = $request->validated();
        $this->transactionRepository->saveTransactionDataToSession($data);
        return redirect()->route('booking.checkout', $slug);
    }

    public function checkout($slug)
    {
        $transaction = $this->transactionRepository->getTransactionDataFromSession();
        $boardingHouse = $this->boardingHouseRepository->getBoardingHouseBySlug($slug);
        $room = $this->boardingHouseRepository->getBoardingHouseRoomById($transaction['room_id']);
        return view('pages.booking.checkout', compact('transaction', 'boardingHouse', 'room'));
    }

    public function payment(Request $request)
    {
        $this->transactionRepository->saveTransactionDataToSession($request->all());
        $transaction = $this->transactionRepository->saveTransaction($this->transactionRepository->getTransactionDataFromSession());
        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('midtrans.isProduction');
        \Midtrans\Config::$isSanitized = config('midtrans.isSanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is3ds');

        $params = [
            'transaction_details' => [
                'order_id' => $transaction->code,
                'gross_amount' => $transaction->total_amount,
            ],
            'customer_details' => [
                'first_name' => $transaction->name,
                'email' => $transaction->email,
                'phone_number' => $transaction->phone_number,
            ],
        ];
        $paymentUrl = \Midtrans\Snap::createTransaction($params)->redirect_url;
        return redirect($paymentUrl);
    }

    public function success(Request $request) {
        $transaction = $this->transactionRepository->getTransactionByCode($request->order_id);
        if(!$transaction) {
            return redirect()->route('home');
        }
        return view('pages.booking.success', compact('transaction'));
    }

    public function check()
    {
        return view('pages.check-booking');
    }
}