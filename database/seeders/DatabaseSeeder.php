<?php

namespace Database\Seeders;

use App\Models\Libreria;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\ProductLine;
use App\Models\Office;
use App\Models\Employee;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         // 1. Crear líneas de productos
     
         ProductLine::factory(5)->create();
         
         // 2. Crear oficinas
     
         Office::factory(5)->create();
         
         // 3. Crear empleados - Asegurarnos de que los employeeNumber son válidos
  
         // Primero obtenemos todas las oficinas
         $offices = Office::all();
         
         // Creamos empleados para cada oficina
         foreach ($offices as $office) {
             Employee::factory(rand(3, 5))->create([
                 'officeCode' => $office->officeCode
             ]);
         }
         
         // 4. Crear clientes - Asegurarnos de que los salesRepEmployeeNumber son válidos
        
         // Primero obtenemos todos los empleados
         $employees = Employee::all();
         
         // Verificamos que tengamos empleados
         if ($employees->isEmpty()) {
             $this->command->error('No hay empleados disponibles para asignar a clientes.');
             return;
         }
         
         // Creamos clientes asignándoles empleados existentes
         foreach ($employees as $employee) {
             Customer::factory(rand(2, 5))->create([
                 'salesRepEmployeeNumber' => $employee->employeeNumber
             ]);
         }
         
         // 5. Crear productos

         $productLines = ProductLine::all();
         
         foreach ($productLines as $productLine) {
             Product::factory(rand(5, 10))->create([
                 'productLine' => $productLine->productLine
             ]);
         }
         
         // 6. Crear órdenes

         $customers = Customer::all();
         
         foreach ($customers as $customer) {
             Order::factory(rand(1, 3))->create([
                 'customerNumber' => $customer->customerNumber
             ]);
         }
         
         // 7. Crear detalles de órdenes

         $orders = Order::all();
         $products = Product::all();
         
         foreach ($orders as $order) {
             // Determinar cuántos productos incluir en esta orden (1-3)
             $numProducts = min(rand(1, 3), $products->count());
             
             // Seleccionar productos aleatorios para esta orden
             $orderProducts = $products->random($numProducts);
             
             foreach ($orderProducts as $product) {
                 OrderDetail::create([
                     'orderNumber' => $order->orderNumber,
                     'productCode' => $product->productCode,
                     'quantityOrdered' => rand(1, 20),
                     'priceEach' => rand(10, 500) + (rand(0, 99) / 100)
                 ]);
             }
         }
         
         // 8. Crear pagos
         
         foreach ($customers as $customer) {
             // Cada cliente tendrá de 1 a 2 pagos
             $paymentCount = rand(1, 2);
             
             for ($i = 0; $i < $paymentCount; $i++) {
                 Payment::create([
                     'customerNumber' => $customer->customerNumber,
                     'checkNumber' => 'CK' . $customer->customerNumber . $i . rand(100, 999),
                     'paymentDate' => now()->subDays(rand(1, 180)),
                     'amount' => rand(100, 5000) + (rand(0, 99) / 100)
                 ]);
             }
         }
         
        Role::create(['name' => 'Guest']);
        Role::create(['name' => 'User']);
        Role::create(['name' => 'Administrator']);
        Libreria::factory(5)->create();

        
        User::create([
            'name' => 'Admin',
            'email' => 'Tobi@example.com',
            'password' => bcrypt('12345678'),
            'role_id' => 3,
            'is_active' => true,
        ]);
    }
} 