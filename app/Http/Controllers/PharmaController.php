<?php

namespace App\Http\Controllers;

use App\Models\Pharma;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

use Illuminate\Routing\Controller;

class PharmaController extends Controller
{
    public function __construct()
    {
        // حماية جميع الدوال بميدل وير auth، باستثناء index وsearch
        $this->middleware('auth')->except(['index', 'search']);
    }
    
    public function index(Request $request)
    {
        $query = Pharma::query();

        // بحث بالاسم فقط
        if ($request->has('q') && $request->q != '') {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        // تصفية حسب التصنيف
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        $medicines = $query->paginate(12);
        $categories = Category::all();

        return view('pharma.index', compact('medicines', 'categories'));
    }

    public function search(Request $request)
    {
        $q = $request->input('q');
        $categories  = Category::all();
        $medicines   = Pharma::where('name', 'like', "%{$q}%")
                             ->orWhere('description', 'like', "%{$q}%")
                             ->paginate(12);
        return view('pharma.index', compact('medicines','categories'));
    }

    public function addToCart($id)
    {
        // التحقق من تسجيل الدخول
        if (!Auth::check()) {
            // إذا كان الطلب AJAX ولم يتم تسجيل الدخول
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'error' => 'login_required',
                    'message' => 'يجب عليك تسجيل الدخول أولاً'
                ], 401);
            }
            
            // إعادة توجيه المستخدم إلى صفحة تسجيل الدخول
            return redirect()->route('login')->with('error', 'يجب عليك تسجيل الدخول أولاً');
        }

        // الحصول على المنتج من قاعدة البيانات
        $product = Pharma::find($id);

        // إذا كان المنتج موجودًا
        if ($product) {
            // الحصول على السلة الحالية
            $cart = session('cart', []);

            // إذا كان المنتج موجودًا بالفعل في السلة، قم بتحديث الكمية
            if (isset($cart[$id])) {
                $cart[$id]['quantity']++;
            } else {
                // إضافة المنتج إلى السلة
                $cart[$id] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => 1, 
                    'image' => $product->image,// أو يمكنك تعيين الكمية المطلوبة
                ];
            }

            // تخزين السلة في الجلسة
            session(['cart' => $cart]);
            
            // التحقق مما إذا كان الطلب يريد استجابة JSON
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'تم إضافة المنتج إلى السلة',
                    'cartCount' => count($cart)
                ]);
            }
            
            // إرجاع المستخدم إلى نفس الصفحة مع رسالة نجاح
            return back()->with('success', 'تم إضافة المنتج إلى السلة');
        }

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'المنتج غير موجود'
            ], 404);
        }
        
        return redirect()->route('pharma.index')->with('error', 'المنتج غير موجود');
    }

    public function cart()
    {
        $cart = Session::get('cart', []);
        return view('pharma.cart', compact('cart'));
    }

    public function removeFromCart($id)
    {
        // التحقق من تسجيل الدخول
        if (!Auth::check()) {
            // إذا كان الطلب AJAX ولم يتم تسجيل الدخول
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'error' => 'login_required',
                    'message' => 'يجب عليك تسجيل الدخول أولاً'
                ], 401);
            }
            
            // إعادة توجيه المستخدم إلى صفحة تسجيل الدخول
            return redirect()->route('login')->with('error', 'يجب عليك تسجيل الدخول أولاً');
        }

        $cart = Session::get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
            
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'تمت إزالة الدواء من السلة بنجاح!'
                ]);
            }
            
            return back()->with('success', 'تمت إزالة الدواء من السلة بنجاح!');
        }

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'هذا الدواء غير موجود في السلة.'
            ]);
        }
        
        return back()->with('success', 'هذا الدواء غير موجود في السلة.');
    }

    public function createOrder(Request $request)
    {
        $cart = Session::get('cart', []);
        if (empty($cart)) {
            return redirect()->route('pharma.index')->with('error', 'سلة المشتريات فارغة');
        }

        // تأكيد من أن المستخدم مسجل دخول
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'يجب عليك تسجيل الدخول أولاً');
        }

        $order = Order::create([
            'user_id'      => Auth::id(), // استخدام ID للمستخدم المسجل
            'total_amount' => array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $cart)),
            'status'       => 'pending',
        ]);

        foreach ($cart as $item) {
            OrderItem::create([
                'order_id'  => $order->id,
                'pharma_id' => $item['id'],
                'quantity'  => $item['quantity'],
                'price'     => $item['price'],
                'total'     => $item['price'] * $item['quantity'],
            ]);
        }

        Session::forget('cart');
        return redirect()->route('pharma.index')->with('success', 'تم إتمام الطلب بنجاح!');
    }

    public function increaseQuantity($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += 1;  // زيادة الكمية بمقدار 1
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index');
    }

    public function decreaseQuantity($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id]) && $cart[$id]['quantity'] > 1) {
            $cart[$id]['quantity'] -= 1;  // نقص الكمية بمقدار 1
            session()->put('cart', $cart);
        } elseif (isset($cart[$id]) && $cart[$id]['quantity'] == 1) {
            // إزالة الدواء من السلة في حالة الكمية = 1
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index');
    }

    public function placeOrder()
    {
        // استرجاع السلة من الجلسة
        $cart = session()->get('cart', []);

        if (count($cart) > 0) {
            // أولاً، حفظ الطلب في جدول orders
            $order = Order::create([
                'user_id' => Auth::id(), // إضافة معرف المستخدم المسجل
                'total_amount' => 0, // سنحدد الإجمالي لاحقًا بعد إضافة العناصر
                'status' => 'pending', // الحالة الافتراضية هي "قيد الانتظار"
            ]);

            // حفظ العناصر في جدول order_items وحساب الإجمالي
            $total = 0;
           foreach ($cart as $pharmaId => $item) {
    $total += $item['price'] * $item['quantity'];

    OrderItem::create([
        'order_id'  => $order->id,
        'pharma_id' => $pharmaId,
        'quantity'  => $item['quantity'],
        'price'     => $item['price'],
        'total'     => $item['price'] * $item['quantity'],
    ]);

    // تقليل الكمية في جدول pharma
    $pharma = Pharma::find($pharmaId);
    if ($pharma) {
        $pharma->quantity -= $item['quantity'];
        $pharma->save();
    }
}

            // تحديث إجمالي الطلب في جدول orders
            $order->update([
                'total_amount' => $total,
            ]);

            // حذف السلة بعد إتمام الطلب
            session()->forget('cart');

            return redirect()->route('pharma.index')->with('success', 'تم إتمام الطلب بنجاح!');
        }

        return redirect()->route('cart.index')->with('error', 'سلة المشتريات فارغة.');
    }

    public function allOrderItems()
    {
        // التحقق من تسجيل الدخول
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'يجب عليك تسجيل الدخول لعرض طلباتك');
        }

        // الحصول على جميع الطلبات الخاصة بالمستخدم مع عناصرها
        $orders = Order::where('user_id', Auth::id())->with('items')->latest()->get();

        return view('pharma.all_order_items', compact('orders'));
    }

    public function getCartCount()
    {
        $cart = Session::get('cart', []);
        return response()->json([
            'count' => count($cart)
        ]);
    }

    /**
     * Mostrar categorías de farmacia
     *
     * @return \Illuminate\Http\Response
     */
  
}
