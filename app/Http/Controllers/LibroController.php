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
use DB;
use Illuminate\Support\Facades\Validator;
use Database\Seeders\DatabaseSeeder;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Faker\Factory;
use Faker\Factory as Faker;
use Str;

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

    public function showOrderDetails($id)
    {
        $orderDetail = OrderDetail::findOrFail($id);
        return response()->json(['OrderDetail' => $orderDetail]);
    }

    public function updateOrderDetails(Request $request, $id)
    {
        OrderDetail::find($id)->update([
            'quantityOrdered' => $request->input('quantityOrdered'),
            'priceEach' => $request->input('priceEach')
        ]);

        return response()->json(['message' => 'OrderDetail actualizado exitosamente']);
    }

    public function destroyOrderDetails($id)
    {
        OrderDetail::find($id)->delete();

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

    public function showPayments($id)
    {
        $payment = Payment::findOrFail($id);
        return response()->json(['Payment' => $payment]);
    }

    public function updatePayments(Request $request, $id)
    {
        $payment = Payment::find($id)
            ->update([
                'paymentDate' => $request->input('paymentDate'),
                'amount' => $request->input('amount')
            ]);

        return response()->json(['message' => 'Payment editado exitosamente']);
    }

    public function destroyPayments($id)
    {
        Payment::find($id)
            ->delete();

        return response()->json(['message' => 'Payment eliminado exitosamente'], 204);
    }

    public function listTables()
    {
        // Ejecuta la consulta para obtener todas las tablas
        $tables = DB::select('SHOW TABLES');

        // Extrae el nombre de la tabla (en MySQL, la columna se llama "Tables_in_<nombre_base_de_datos>")
        $tableNames = array_map('current', $tables);

        // Define las tablas que deseas excluir
        $excludeTables = [
            'roles',
            'users',
            'password_resets',
            'failed_jobs',
            'personal_access_tokens',
            'librerias',
            'tokens'
        ];

        // Filtra los nombres de las tablas excluyendo los que están en $excludeTables
        $filteredTables = array_filter($tableNames, function ($table) use ($excludeTables) {
            return !in_array($table, $excludeTables);
        });

        // Reindexa el array (opcional)
        $filteredTables = array_values($filteredTables);

        return response()->json(['tables' => $filteredTables]);
    }

    public function esquema_modelo($model)
    {
        $model = 'App\\Models\\' . Str::studly(Str::singular($model));

        try {
            $instance = new $model();
            $fillable = $instance->getFillable();
            $hidden = $instance->getHidden();
            $casts = $instance->getCasts();

            return response()->json([
                'fields' => $fillable,
                'hidden' => $hidden,
                'casts' => $casts
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Modelo no encontrado'], 404);
        }
    }
    
}

/*

haz un componente de angular que me permita eliminar, modificar y agregar elementos  de manera dinámica con estas rutas:

// Product Lines
    Route::get('/v1/lineas-de-productos', [LibroController::class, 'indexProductLines']);
    Route::post('/v1/lineas-de-productos', [LibroController::class, 'storeProductLines'])->middleware('checkrole');
    Route::get('/v1/lineas-de-productos/{lineaDeProducto}', [LibroController::class, 'showProductLines']);
    Route::put('/v1/lineas-de-productos/{lineaDeProducto}', [LibroController::class, 'updateProductLines'])->middleware('checkrole');
    Route::delete('/v1/lineas-de-productos/{lineaDeProducto}', [LibroController::class, 'destroyProductLines'])->middleware('checkrole');
    //////////////////////////////////////////////////////////////////////////////

    //////////////////////////////////////////////////////////////////////////////
// Products
    Route::get('/v1/productos', [LibroController::class, 'indexProducts']);
    Route::post('/v1/productos', [LibroController::class, 'storeProducts'])->middleware('checkrole');
    Route::get('/v1/productos/{producto}', [LibroController::class, 'showProducts']);
    Route::put('/v1/productos/{producto}', [LibroController::class, 'updateProducts'])->middleware('checkrole');
    Route::delete('/v1/productos/{producto}', [LibroController::class, 'destroyProducts'])->middleware('checkrole');
    //////////////////////////////////////////////////////////////////////////////

que hacen el siguiente proceso:

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

que funcionan de una manera igual con las siguientes tablas:

endpoints = [
    'lineas-de-productos',
    'productos',         
    'empleados',      
    'oficinas',          
    'clientes',      
    'pedidos',           
    'detalles-de-pedidos',    
    'pagos'        
  ];


nota: asi es como me conecto a la api: 
this.http.get<any>(
    `${environment.apiUrl}api/v1/${endpoint}`,
      { headers: this.getHeaders() }
    ) ...

puedes utilizar esta forma de crear formularios:

este ese el componente que uso para crear campos:

  FormularioCampo: FormularioCampo[] = [ // Nombre de variable corregido
    {
      type: 'input',
      name: 'name',
      label: 'Nombre completo',
      placeholder: 'Juan Pérez',
      validations: {
        required: true,
        minLength: 3,
        maxLength: 50
      }
    },
    {
      type: 'email',
      name: 'email',
      label: 'Correo electrónico',
      placeholder: 'usuario@dominio.com',
      validations: {
        required: true,
        pattern: /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/
      }
    },
    {
      type: 'password',
      name: 'password',
      label: 'Contraseña',
      validations: {
        required: true,
        minLength: 8
      }
    },
    {
      type: 'password',
      name: 'confirmPassword',
      label: 'Confirmar contraseña',
      validations: {
        required: true,
        custom: [this.passwordMatchValidator.bind(this)]
      }
    }
  ];


y no quiero que los campos los definas de manera estática como se muestra aqui:

const FIELD_CONFIG: { [key: string]: any } = {
  'lineas-de-productos': {
    create: [
      { name: 'productLine', label: 'Línea de Producto', type: 'text', required: true },
      { name: 'textDescription', label: 'Descripción', type: 'text', required: true },
      { name: 'image', label: 'Imagen', type: 'text' }
    ],
    update: [
      { name: 'textDescription', label: 'Descripción', type: 'text', required: true },
      { name: 'image', label: 'Imagen', type: 'text' }
    ]
  },
  'productos': {
    create: [
      { name: 'productCode', label: 'Código', type: 'text', required: true },
      { name: 'productName', label: 'Nombre', type: 'text', required: true },
      { name: 'productLine', label: 'Línea', type: 'text', required: true },
      { name: 'quantityInStock', label: 'Inventario', type: 'number', required: true }
    ],
    update: [
      { name: 'productName', label: 'Nombre', type: 'text', required: true },
      { name: 'quantityInStock', label: 'Inventario', type: 'number', required: true }
    ]
  }
};

este es la ruta que utilizaras para consultar los campos de el esquema de las tablas:

public function esquema_modelo($model)
    {
        $model = 'App\\Models\\' . Str::studly(Str::singular($model));

        try {
            $instance = new $model();
            $fillable = $instance->getFillable();
            $hidden = $instance->getHidden();
            $casts = $instance->getCasts();

            return response()->json([
                'fields' => $fillable,
                'hidden' => $hidden,
                'casts' => $casts
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Modelo no encontrado'], 404);
        }
    }


    Route::get('/v1/model-fields/{model}', [LibroController::class, 'esquema_modelo'])->middleware('checkrole');

su respuesta:

{
	"fields": [
		"customerNumber",
		"checkNumber",
		"paymentDate",
		"amount"
	],
	"hidden": [],
	"casts": {
		"paymentNumber": "int"
	}
}
*/
