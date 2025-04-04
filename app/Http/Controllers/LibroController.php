<?php

namespace App\Http\Controllers;

use App\Events\ProductUpdated;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Historial;
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
        $validator = Validator::make($request->all(), [
            'productLine' => 'required|string|max:50|unique:product_lines,productLine',
            'textDescription' => 'nullable|string|max:400',
            'image' => 'nullable|string|max:255'
        ], [
            'productLine.required' => 'Debe especificar un nombre para la línea de productos',
            'productLine.unique' => 'Esta línea de productos ya está registrada',
            'productLine.max' => 'El nombre no puede superar los 50 caracteres',
            'textDescription.max' => 'La descripción no puede exceder los 400 caracteres',
            'image.max' => 'La ruta de la imagen es demasiado larga'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $productLine = ProductLine::create($request->all());
        return response()->json(['ProductLine' => $productLine], 201);
    }



    public function showProductLines($id)
    {
        $productLine = ProductLine::findOrFail($id);
        return response()->json(['ProductLine' => $productLine]);
    }

    public function updateProductLines(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'productLine' => 'string|max:50|unique:product_lines,productLine,' . $id,
        'textDescription' => 'nullable|string|max:400',
        'image' => 'nullable|string|max:255'
    ], [
        'productLine.unique' => 'Este nombre de línea ya está en uso',
        'productLine.max' => 'El nombre debe tener máximo 50 caracteres',
        'textDescription.max' => 'La descripción supera el límite de 400 caracteres',
        'image.max' => 'La ruta de la imagen es inválida'
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $productLine = ProductLine::findOrFail($id);
    $productLine->update($request->all());
    return response()->json(['ProductLine' => $productLine]);
}

    public function destroyProductLines($id)
    {
        ProductLine::destroy($id);
        return response()->json(['message' => 'ProductLine eliminado exitosamente'], 204);
    }

    ///////////////////////////////////////////////////////////////////////////////
    /*
   broadcast(new ProductUpdated([
               'productCode' => $request->input('productCode'),
               'productName' => $request->input('productName'),
               'productLine' => $request->input('productLine'),
               'quantityInStock' => $request->input('quantityInStock')
           ]))->toOthers();

       broadcast(new ProductUpdated([
               'productName' => $request->input('productName'),
               'quantityInStock' => $request->input('quantityInStock')
           ]))->toOthers();

           broadcast(new ProductUpdated(Product::all()))->toOthers();
       */



    public function indexProducts()
    {
        $products = Product::all();
        return response()->json(['Products' => $products]);
    }



    public function showProducts($id)
    {
        $product = Product::findOrFail($id);

        return response()->json(['Product' => $product]);
    }

    public function storeProducts(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'productCode' => 'required|string|max:15|unique:products,productCode',
            'productName' => 'required|string|max:70',
            'productLine' => 'required|exists:product_lines,id',
            'quantityInStock' => 'required|integer|min:0|max:100000'
        ], [
            'productCode.required' => 'El código del producto es obligatorio',
            'productCode.unique' => 'Este código de producto ya existe',
            'productCode.max' => 'El código no puede tener más de 15 caracteres',
            'productName.required' => 'El nombre del producto es requerido',
            'productName.max' => 'El nombre excede los 70 caracteres permitidos',
            'productLine.exists' => 'La categoría seleccionada no existe',
            'quantityInStock.min' => 'El stock no puede ser negativo',
            'quantityInStock.max' => 'El stock no puede superar 100,000 unidades'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $product = Product::create($request->all());
        event(new ProductUpdated("actualizar"));
        return response()->json(['Product' => $product], 201);
    }

    public function updateProducts(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'productCode' => 'string|max:15|unique:products,productCode,' . $id,
            'productName' => 'string|max:70',
            'productLine' => 'exists:product_lines,id',
            'quantityInStock' => 'integer|min:0|max:100000'
        ], [
            'productCode.unique' => 'Este código ya está asignado a otro producto',
            'productCode.max' => 'El código debe tener máximo 15 caracteres',
            'productName.max' => 'El nombre no puede exceder 70 caracteres',
            'productLine.exists' => 'Seleccione una categoría válida',
            'quantityInStock.min' => 'El stock mínimo permitido es 0',
            'quantityInStock.max' => 'Límite de stock excedido (100,000 unidades)'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $product = Product::findOrFail($id);
        $product->update($request->all());
        event(new ProductUpdated("actualizar"));
        return response()->json(['Product' => $product]);
    }

    public function destroyProducts($id)
    {
        Product::destroy($id);
        event(new ProductUpdated("actualizar"));
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
        $validator = Validator::make($request->all(), [
            'lastName' => 'required|string|max:50',
            'firstName' => 'required|string|max:50',
            'officeCode' => 'required|exists:offices,id'
        ], [
            'lastName.required' => 'El apellido es obligatorio',
            'lastName.max' => 'El apellido no puede superar 50 caracteres',
            'firstName.required' => 'El nombre es obligatorio',
            'firstName.max' => 'El nombre no puede exceder 50 caracteres',
            'officeCode.exists' => 'La oficina seleccionada no existe'
        ]);
    

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $employee = Employee::create($request->all());
        return response()->json(['Employee' => $employee], 201);
    }

    public function showEmployees($id)
    {
        $employee = Employee::findOrFail($id);
        return response()->json(['Employee' => $employee]);
    }

    public function updateEmployees(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'lastName' => 'string|max:50',
            'firstName' => 'string|max:50',
            'officeCode' => 'exists:offices,id'
        ], [
            'lastName.max' => 'El apellido debe tener máximo 50 caracteres',
            'firstName.max' => 'El nombre debe tener máximo 50 caracteres',
            'officeCode.exists' => 'Seleccione una oficina válida'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $employee = Employee::findOrFail($id);
        $employee->update($request->all());
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
        $validator = Validator::make($request->all(), [
            'city' => 'required|string|max:50',
            'phone' => 'required|string|max:15|unique:offices,phone',
            'country' => 'required|string|max:50'
        ], [
            'city.required' => 'La ciudad es obligatoria',
            'city.max' => 'El nombre de la ciudad es demasiado largo',
            'phone.required' => 'El teléfono es obligatorio',
            'phone.unique' => 'Este número de teléfono ya está registrado',
            'phone.max' => 'El teléfono no puede exceder 15 dígitos',
            'country.required' => 'El país es obligatorio',
            'country.max' => 'El nombre del país es demasiado largo'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $office = Office::create($request->all());
        return response()->json(['Office' => $office], 201);
    }


    public function showOffices($id)
    {
        $office = Office::findOrFail($id);
        return response()->json(['Office' => $office]);
    }

    public function updateOffices(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'city' => 'string|max:50',
            'phone' => 'string|max:15|unique:offices,phone,' . $id,
            'country' => 'string|max:50'
        ], [
            'city.max' => 'La ciudad no puede superar 50 caracteres',
            'phone.unique' => 'Este teléfono ya está en uso por otra oficina',
            'phone.max' => 'El teléfono debe tener máximo 15 dígitos',
            'country.max' => 'El país no puede exceder 50 caracteres'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $office = Office::findOrFail($id);
        $office->update($request->all());
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
        $validator = Validator::make($request->all(), [
            'customerName' => 'required|string|max:50',
            'phone' => 'required|string|max:15|unique:customers,phone',
            'salesRepEmployeeNumber' => 'required|exists:employees,id'
        ], [
            'customerName.required' => 'El nombre del cliente es obligatorio',
            'customerName.max' => 'El nombre no puede superar 50 caracteres',
            'phone.required' => 'El teléfono es obligatorio',
            'phone.unique' => 'Este teléfono ya está registrado',
            'phone.max' => 'El teléfono debe tener máximo 15 dígitos',
            'salesRepEmployeeNumber.exists' => 'El empleado asignado no existe'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $customer = Customer::create($request->all());
        return response()->json(['Customer' => $customer], 201);
    }

    public function showCustomers($id)
    {
        $customer = Customer::findOrFail($id);
        return response()->json(['Customer' => $customer]);
    }

    public function updateCustomers(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'customerName' => 'string|max:50',
            'phone' => 'string|max:15|unique:customers,phone,' . $id,
            'salesRepEmployeeNumber' => 'exists:employees,id'
        ], [
            'customerName.max' => 'El nombre no puede exceder 50 caracteres',
            'phone.unique' => 'Este teléfono ya está en uso por otro cliente',
            'phone.max' => 'El teléfono debe tener máximo 15 dígitos',
            'salesRepEmployeeNumber.exists' => 'Seleccione un empleado válido'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $customer = Customer::findOrFail($id);
        $customer->update($request->all());
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
        $validator = Validator::make($request->all(), [
            'orderDate' => 'required|date',
            'status' => 'required|string|in:pendiente,completado,cancelado',
            'customerNumber' => 'required|exists:customers,id'
        ], [
            'orderDate.required' => 'La fecha del pedido es obligatoria',
            'orderDate.date' => 'Formato de fecha inválido',
            'status.required' => 'El estado del pedido es obligatorio',
            'status.in' => 'Estado no válido. Opciones: pendiente, completado, cancelado',
            'customerNumber.exists' => 'El cliente seleccionado no existe'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $order = Order::create($request->all());
        return response()->json(['Order' => $order], 201);
    }

    public function showOrders($id)
    {
        $order = Order::findOrFail($id);
        return response()->json(['Order' => $order]);
    }

    public function updateOrders(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'orderDate' => 'date',
            'status' => 'string|in:pendiente,completado,cancelado',
            'customerNumber' => 'exists:customers,id'
        ], [
            'orderDate.date' => 'Formato de fecha incorrecto',
            'status.in' => 'Estado no permitido. Use: pendiente, completado o cancelado',
            'customerNumber.exists' => 'El cliente no existe en la base de datos'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $order = Order::findOrFail($id);
        $order->update($request->all());
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
        $validator = Validator::make($request->all(), [
            'orderNumber' => 'required|exists:orders,id',
            'productCode' => 'required|exists:products,id',
            'quantityOrdered' => 'required|integer|min:1|max:1000',
            'priceEach' => 'required|numeric|min:0.01|max:999999.99'
        ], [
            'orderNumber.exists' => 'El pedido seleccionado no existe',
            'productCode.exists' => 'El producto seleccionado no existe',
            'quantityOrdered.min' => 'La cantidad mínima es 1 unidad',
            'quantityOrdered.max' => 'La cantidad máxima permitida es 1000 unidades',
            'priceEach.min' => 'El precio unitario debe ser mayor a $0.01',
            'priceEach.max' => 'El precio unitario no puede superar $999,999.99'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $orderDetail = OrderDetail::create($request->all());
        return response()->json(['OrderDetail' => $orderDetail], 201);
    }

    public function showOrderDetails($id)
    {
        $orderDetail = OrderDetail::findOrFail($id);
        return response()->json(['OrderDetail' => $orderDetail]);
    }

    public function updateOrderDetails(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'quantityOrdered' => 'integer|min:1|max:1000',
            'priceEach' => 'numeric|min:0.01|max:999999.99'
        ], [
            'quantityOrdered.min' => 'Debe ordenar al menos 1 unidad',
            'quantityOrdered.max' => 'No puede ordenar más de 1000 unidades',
            'priceEach.min' => 'El precio no puede ser menor a $0.01',
            'priceEach.max' => 'El precio excede el máximo permitido ($999,999.99)'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $orderDetail = OrderDetail::findOrFail($id);
        $orderDetail->update($request->all());
        return response()->json(['OrderDetail' => $orderDetail]);
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
        $validator = Validator::make($request->all(), [
            'checkNumber' => 'required|string|max:50|unique:payments,checkNumber',
            'paymentDate' => 'required|date',
            'amount' => 'required|numeric|min:0.01|max:1000000',
            'customerNumber' => 'required|exists:customers,id'
        ], [
            'checkNumber.required' => 'El número de cheque es obligatorio',
            'checkNumber.unique' => 'Este número de cheque ya fue registrado',
            'checkNumber.max' => 'El número de cheque no puede superar 50 caracteres',
            'paymentDate.required' => 'La fecha de pago es obligatoria',
            'paymentDate.date' => 'Formato de fecha inválido',
            'amount.min' => 'El monto mínimo permitido es $0.01',
            'amount.max' => 'El monto no puede superar $1,000,000',
            'customerNumber.exists' => 'El cliente seleccionado no existe'
        ]);
    

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $payment = Payment::create($request->all());
        return response()->json(['Payment' => $payment], 201);
    }

    public function showPayments($id)
    {
        $payment = Payment::findOrFail($id);
        return response()->json(['Payment' => $payment]);
    }

    public function updatePayments(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'checkNumber' => 'string|max:50|unique:payments,checkNumber,' . $id,
            'paymentDate' => 'date',
            'amount' => 'numeric|min:0.01|max:1000000',
            'customerNumber' => 'exists:customers,id'
        ], [
            'checkNumber.unique' => 'Este número de cheque ya está en uso',
            'checkNumber.max' => 'El número de cheque debe tener máximo 50 caracteres',
            'paymentDate.date' => 'Formato de fecha incorrecto',
            'amount.min' => 'El monto debe ser al menos $0.01',
            'amount.max' => 'El monto máximo permitido es $1,000,000',
            'customerNumber.exists' => 'El cliente no existe en la base de datos'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $payment = Payment::findOrFail($id);
        $payment->update($request->all());
        return response()->json(['Payment' => $payment]);
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
            'tokens',
            'migrations'
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

            // Obtener metadatos del modelo
            $fillable = $instance->getFillable();
            $primaryKey = $instance->getKeyName();
            $foreignKeys = array_keys($instance->getRelations()); // Obtener nombres de relaciones
            $timestamps = $instance->timestamps ? ['created_at', 'updated_at'] : [];
            $softDeletes = method_exists($instance, 'getDeletedAtColumn')
                ? [$instance->getDeletedAtColumn()]
                : [];

            // Combinar todos los campos a excluir
            $excluded = array_merge(
                [$primaryKey],
                $foreignKeys,
                $timestamps,
                $softDeletes
            );

            // Filtrar campos fillable
            $filteredFields = array_values(array_diff($fillable, $excluded));

            return response()->json([
                'fields' => $filteredFields,
                'hidden' => $instance->getHidden(),
                'casts' => $instance->getCasts()
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Modelo no encontrado'], 404);
        }
    }

    public function historial()
    {
        $historial = Historial::all();
        return response()->json(['Historial' => $historial]);
    }

}
