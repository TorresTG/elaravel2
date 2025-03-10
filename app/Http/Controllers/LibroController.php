<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Libreria;


//Validaciones
use App\Models\Office;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductLine;
use Illuminate\Support\Facades\Validator;
use Database\Seeders\DatabaseSeeder;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Faker\Factory;
use Faker\Factory as Faker;

class LibroController extends Controller
{
    ///////////////////////////////////////////////////////////////////////////////
    public function indexLibrerías()
    {
        $Librerias = Libreria::all();
        return response()->json([
            'Librerias' => $Librerias,
        ]);
    }
    public function storeLibrerías(Request $request)
    {
        $Libreria = Libreria::create([
            'nombre' => $request->input('nombre'),
            'ubicacion' => $request->input('ubicacion'),
        ]);


        return response()->json([
            'Libreria' => $Libreria,
        ]);
    }
    public function showLibrerías($id)
    {
        $Libreria = Libreria::find($id);
        return response()->json([
            'Libreria' => $Libreria,
        ]);
    }
    public function updateLibrerías(Request $request, $id)
    {
        $libreria = Libreria::find($id);
        $libreria->update([
            'nombre' => $request->input('nombre'),
            'ubicacion' => $request->input('ubicacion'),
        ]);

        return response()->json([
            'Libreria' => $libreria,
        ]);
    }
    public function destroyLibrerías($id)
    {

        Libreria::destroy($id);
        return response()->json([
            'message' => 'Librería eliminado exitosamente',
        ], 204);
    }
    ///////////////////////////////////////////////////////////////////////////////
    public function indexProductLines()
    {
        $productLines = ProductLine::all();
        return response()->json(['ProductLines' => $productLines]);
    }

    public function storeProductLines(Request $request)
    {
        $productLine = ProductLine::create([
            'productLine' => $request->input('productLine'),
            'textDescription' => $request->input('textDescription'),
            'image' => $request->input('image')
        ]);
        return response()->json(['ProductLine' => $productLine]);
    }

    public function showProductLines($id)
    {
        $productLine = ProductLine::findOrFail($id);
        return response()->json(['ProductLine' => $productLine]);
    }

    public function updateProductLines(Request $request, $id)
    {
        $productLine = ProductLine::find($id);
        $productLine->update([
            'textDescription' => $request->input('textDescription'),
            'image' => $request->input('image')
        ]);
        return response()->json(['ProductLine' => $productLine]);
    }

    public function destroyProductLines($id)
    {
        ProductLine::destroy($id);
        return response()->json(['message' => 'ProductLine eliminado exitosamente'], 204);
    }

    ///////////////////////////////////////////////////////////////////////////////

    public function indexProducts()
    {
        $products = Product::all();
        return response()->json(['Products' => $products]);
    }

    public function storeProducts(Request $request)
    {
        $product = Product::create([
            'productCode' => $request->input('productCode'),
            'productName' => $request->input('productName'),
            'productLine' => $request->input('productLine'),
            'quantityInStock' => $request->input('quantityInStock')
        ]);
        return response()->json(['Product' => $product]);
    }

    public function showProducts($id)
    {
        $product = Product::findOrFail($id);
        return response()->json(['Product' => $product]);
    }

    public function updateProducts(Request $request, $id)
    {
        $product = Product::find($id);
        $product->update([
            'productName' => $request->input('productName'),
            'quantityInStock' => $request->input('quantityInStock')
        ]);
        return response()->json(['Product' => $product]);
    }

    public function destroyProducts($id)
    {
        Product::destroy($id);
        return response()->json(['message' => 'Product eliminado exitosamente'], 204);
    }
    ///////////////////////////////////////////////////////////////////////////////
    public function indexEmployees()
    {
        $employees = Employee::all();
        return response()->json(['Employees' => $employees]);
    }

    public function storeEmployees(Request $request)
    {
        $employee = Employee::create([
            'employeeNumber' => $request->input('employeeNumber'),
            'lastName' => $request->input('lastName'),
            'firstName' => $request->input('firstName'),
            'officeCode' => $request->input('officeCode')
        ]);
        return response()->json(['Employee' => $employee]);
    }

    public function showEmployees($id)
    {
        $employee = Employee::findOrFail($id);
        return response()->json(['Employee' => $employee]);
    }

    public function updateEmployees(Request $request, $id)
    {
        $employee = Employee::find($id);
        $employee->update([
            'lastName' => $request->input('lastName'),
            'firstName' => $request->input('firstName')
        ]);
        return response()->json(['Employee' => $employee]);
    }

    public function destroyEmployees($id)
    {
        Employee::destroy($id);
        return response()->json(['message' => 'Employee eliminado exitosamente'], 204);
    }
    ///////////////////////////////////////////////////////////////////////////////
    public function indexOffices()
    {
        $offices = Office::all();
        return response()->json(['Offices' => $offices]);
    }

    public function storeOffices(Request $request)
    {
        $office = Office::create([
            'officeCode' => $request->input('officeCode'),
            'city' => $request->input('city'),
            'phone' => $request->input('phone'),
            'country' => $request->input('country')
        ]);
        return response()->json(['Office' => $office]);
    }

    public function showOffices($id)
    {
        $office = Office::findOrFail($id);
        return response()->json(['Office' => $office]);
    }

    public function updateOffices(Request $request, $id)
    {
        $office = Office::find($id);
        $office->update([
            'city' => $request->input('city'),
            'phone' => $request->input('phone'),
            'country' => $request->input('country')
        ]);
        return response()->json(['Office' => $office]);
    }

    public function destroyOffices($id)
    {
        Office::destroy($id);
        return response()->json(['message' => 'Office eliminado exitosamente'], 204);
    }
    ///////////////////////////////////////////////////////////////////////////////
    public function indexCustomers()
    {
        $customers = Customer::all();
        return response()->json(['Customers' => $customers]);
    }

    public function storeCustomers(Request $request)
    {
        $customer = Customer::create([
            'customerNumber' => $request->input('customerNumber'),
            'customerName' => $request->input('customerName'),
            'phone' => $request->input('phone'),
            'salesRepEmployeeNumber' => $request->input('salesRepEmployeeNumber')
        ]);
        return response()->json(['Customer' => $customer]);
    }

    public function showCustomers($id)
    {
        $customer = Customer::findOrFail($id);
        return response()->json(['Customer' => $customer]);
    }

    public function updateCustomers(Request $request, $id)
    {
        $customer = Customer::find($id);
        $customer->update([
            'customerName' => $request->input('customerName'),
            'phone' => $request->input('phone')
        ]);
        return response()->json(['Customer' => $customer]);
    }

    public function destroyCustomers($id)
    {
        Customer::destroy($id);
        return response()->json(['message' => 'Customer eliminado exitosamente'], 204);
    }
    ///////////////////////////////////////////////////////////////////////////////
    public function indexOrders()
    {
        $orders = Order::all();
        return response()->json(['Orders' => $orders]);
    }

    public function storeOrders(Request $request)
    {
        $order = Order::create([
            'orderNumber' => $request->input('orderNumber'),
            'orderDate' => $request->input('orderDate'),
            'status' => $request->input('status'),
            'customerNumber' => $request->input('customerNumber')
        ]);
        return response()->json(['Order' => $order]);
    }

    public function showOrders($id)
    {
        $order = Order::findOrFail($id);
        return response()->json(['Order' => $order]);
    }

    public function updateOrders(Request $request, $id)
    {
        $order = Order::find($id);
        $order->update([
            'orderDate' => $request->input('orderDate'),
            'status' => $request->input('status')
        ]);
        return response()->json(['Order' => $order]);
    }

    public function destroyOrders($id)
    {
        Order::destroy($id);
        return response()->json(['message' => 'Order eliminado exitosamente'], 204);
    }
    ///////////////////////////////////////////////////////////////////////////////
    public function indexOrderDetails()
    {
        $orderDetails = OrderDetail::all();
        return response()->json(['OrderDetails' => $orderDetails]);
    }

    public function storeOrderDetails(Request $request)
    {
        $orderDetail = OrderDetail::create([
            'orderNumber' => $request->input('orderNumber'),
            'productCode' => $request->input('productCode'),
            'quantityOrdered' => $request->input('quantityOrdered'),
            'priceEach' => $request->input('priceEach')
        ]);
        return response()->json(['OrderDetail' => $orderDetail]);
    }

    public function showOrderDetails($orderNumber, $productCode)
    {
        $orderDetail = OrderDetail::where('orderNumber', $orderNumber)
            ->where('productCode', $productCode)
            ->firstOrFail();
        return response()->json(['OrderDetail' => $orderDetail]);
    }

    public function updateOrderDetails(Request $request, $orderNumber, $productCode)
    {
        OrderDetail::where('orderNumber', $orderNumber)
            ->where('productCode', $productCode)
            ->update([
                'quantityOrdered' => $request->input('quantityOrdered'),
                'priceEach' => $request->input('priceEach')
            ]);

        return response()->json(['OrderDetail' => "Modificado correctamente"]);
    }

    public function destroyOrderDetails($orderNumber, $productCode)
    {
        OrderDetail::where('orderNumber', $orderNumber)
            ->where('productCode', $productCode)
            ->delete();

        return response()->json(['message' => 'OrderDetail eliminado exitosamente'], 204);
    }
    ///////////////////////////////////////////////////////////////////////////////
    public function indexPayments()
    {
        $payments = Payment::all();
        return response()->json(['Payments' => $payments]);
    }

    public function storePayments(Request $request)
    {
        $payment = Payment::create([
            'customerNumber' => $request->input('customerNumber'),
            'checkNumber' => $request->input('checkNumber'),
            'paymentDate' => $request->input('paymentDate'),
            'amount' => $request->input('amount')
        ]);
        return response()->json(['Payment' => $payment]);
    }

    public function showPayments($customerNumber, $checkNumber)
    {
        $payment = Payment::where('customerNumber', $customerNumber)
            ->where('checkNumber', $checkNumber)
            ->firstOrFail();
        return response()->json(['Payment' => $payment]);
    }

    public function updatePayments(Request $request, $customerNumber, $checkNumber)
    {
        $payment = Payment::where('customerNumber', $customerNumber)
            ->where('checkNumber', $checkNumber)
            ->update([
                'paymentDate' => $request->input('paymentDate'),
                'amount' => $request->input('amount')
            ]);

        return response()->json(['Payment' => $payment]);
    }

    public function destroyPayments($customerNumber, $checkNumber)
    {
        Payment::where('customerNumber', $customerNumber)
            ->where('checkNumber', $checkNumber)
            ->delete();

        return response()->json(['message' => 'Payment eliminado exitosamente'], 204);
    }

}
