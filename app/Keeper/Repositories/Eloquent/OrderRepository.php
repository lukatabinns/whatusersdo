<?php

namespace App\Keeper\Repositories\Eloquent;

use App\Order;
use App\Transaction;

use App\Keeper\Repositories\OrderRepositoryInterface;
use App\Keeper\Services\Forms\OrderForm;

class OrderRepository extends AbstractRepository implements OrderRepositoryInterface
{


    protected $transaction;


    /**
     * @param App\Order $order
     *
     */
    public function __construct(Order $order)
    {
        $this->model = $order;

    }


    /**
     * Get an array of key-value ( id=>name ) pairs of all Accounts
     * @return array
     */
    public function listAll()
    {
        return $this->model->lists('name', 'id');
    }

    /**
     * @param string $orderColumn
     * @param string $orderDir
     * @return mixed
     */
    public function findAll($orderColumn = 'created_at', $orderDir = 'desc')
    {
        return $this->model->orderBy($orderColumn, $orderDir)->paginate(5);
    }

    /**
     * Find a category by id
     * @param $id
     * @return mixed
     */
    public function findById($id)
    {
        return $this->model->find($id);
    }

    /**
     * Create a new category in the database
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $order = $this->getNew();
        $order->first_name = $data['first_name'];
        $order->last_name = $data['last_name'];
        $order->email = $data['email'];
		$order->address_line1 = $data['address_line1'];
        $order->city = $data['city'];
		$order->post_code = $data['post_code'];
        $order->save();

        /*$transaction = new Transaction();
        $transaction->account = $data['account_name'];
        $transaction->type = 'Transfer';
        $transaction->account = $data['account_name'];
        $transaction->payer = 'System';
        $transaction->date = date("Y/m/d");
        $transaction->description = $data['description'];
        $transaction->cr = $data['balance'];
        $transaction->bal = $data['balance'];
        $transaction->save();*/

        /**
         * Save the data to the transaction table as well.
         */
        return $order;
    }

    /**
     * Update the specific category in the database
     *
     * @param $id
     * @param array $data
     * @return mixed
     */
    public function update($id, array $data)
    {
        $order = $this->findById($id);
        $order->first_name = $data['first_name'];
        $order->last_name = $data['last_name'];
        $order->email = $data['email'];
        $order->address_line1 = $data['address_line1'];
		$order->city = $data['city'];
        $order->post_code = $data['post_code'];
        $order->save();


        /*$transaction = new Transaction();
        $transaction->account = $data['account_name'];
        $transaction->type = 'Transfer';
        $transaction->account = $data['account_name'];
        $transaction->payer = 'System';
        $transaction->date = date("Y/m/d");
        $transaction->description = $data['description'];
        $transaction->cr = $data['balance'];
        $transaction->bal = $data['balance'];
        $transaction->save();*/
        return $order;
    }

    /**
     * Delete the specific category from the database.
     *
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $this->findById($id)->delete();
    }


    /**
     * @return \Keeper\Services\Forms\OrderForm
     */
    public function getForm()
    {
        return new OrderForm();
    }

    public function getTotalOrder()
    {
        $accounts = $this->model->all();
        $res = 0;
        foreach ($accounts as $account) {
            $res += $account->balance;
        }
        return $res;
    }
}