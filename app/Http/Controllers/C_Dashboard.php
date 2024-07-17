<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\M_Transactions;
use App\Models\M_CategoryTransactions;
use App\Models\User;
use Session;
use Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class C_Dashboard extends Controller
{
    function index(){
        $result = DB::select("
        SELECT 
        (SELECT SUM(amount_kini) FROM category_transactions) as total_amount_kini,
        (SELECT COUNT(*) FROM users) as total_users,
        (SELECT COUNT(*) FROM transactions) as total_transactions,
        (SELECT COUNT(*) FROM category_transactions WHERE amount_kini >= amount_target) as count_reminder,
        (SELECT COUNT(*) FROM category_transactions) as count_category
        ");

        $result_all_categorys = M_CategoryTransactions::orderBy("id", "desc")->simplePaginate(7);

        return view("administrator.dashboard.home", [
            "result" => $result, 
            "result_all_categorys" => $result_all_categorys
        ]);
    }
    
    public function getDataTransaksi(){
        return DataTables::of(M_Transactions::orderBy("id", "asc")->get())
        ->editColumn("type", function($category) {
            if($category->type === "deposit"){
                return "<div class='badge badge-success'>Deposit</div>";
            } else {
                return "<div class='badge badge-warning'>Withdrawal</div>";
            }
        })
        ->rawColumns(["type"])
        ->addIndexColumn()
        ->make(true);
    }

    function transaksi(){
        $category_view = M_CategoryTransactions::pluck("id","category")->all();
        return view("administrator.dashboard.transaksi", ["script_tambah_transaksi"=>true, "category_id" => $category_view]);
    }

    public function tambah_transaksi(Request $request)
{
    try{
        $data = Validator::make($request->all(), [
            "amount" => "required|min:1",
            "type" => "required|in:deposit,withdrawal",
            "note" => "required",
            "id_category" => "required"
        ]);

        if($data->fails()){
            return response()->json(["error_form" => $data->errors()], 422);
        }

        $valid_data = $data->validated();
        $valid_data["amount"] = preg_replace('/[^0-9]/', '', $valid_data["amount"]);
        $valid_data["time"] = Carbon::now()->format('d M Y H:i:s');

        $transaction = DB::transaction(function () use ($valid_data) {
            // Select amount_kini
            $amount_category = DB::table('category_transactions')
                                ->where('id', $valid_data['id_category'])
                                ->value('amount_kini');

            if ($valid_data["type"] === "withdrawal" && $amount_category < $valid_data["amount"]) {
                // Saldo tidak mencukupi untuk penarikan
                return false;
            }

            // Insert transaction
            DB::table('transactions')->insert([
                'amount' => $valid_data['amount'],
                'type' => $valid_data['type'],
                'note' => $valid_data['note'],
                'time' => $valid_data['time'],
                'id_category' => $valid_data['id_category']
            ]);

            if ($valid_data["type"] === "deposit") {
                // Update deposito amount_kini +
                DB::table('category_transactions')
                    ->where('id', $valid_data['id_category'])
                    ->update(['amount_kini' => $amount_category + $valid_data['amount']]);
            } elseif ($valid_data["type"] === "withdrawal") {
                // Update withdrawal amount_kini -
                DB::table('category_transactions')
                    ->where('id', $valid_data['id_category'])
                    ->update(['amount_kini' => $amount_category - $valid_data['amount']]);
            }

            return true;
        });

        if ($transaction === false) {
            return response()->json(["status" => "error_tambah"], 400);
        }else {
            return response()->json([
                "status" => "success",
                "amount" => $valid_data['amount'],
                "type" => $valid_data['type'],
                "note" => $valid_data['note'],
                "time" => $valid_data['time']
            ]);
        }
    }catch(\Exception $e){
        return response()->json([
            "status"=>"error"
        ], 500);
    }
}


    public function getCategoryTransactions(){
        $categories = M_CategoryTransactions::orderBy("id", "asc")->get();
        
        return DataTables::of($categories)
            ->addColumn("action", function($category){
                $button = "<button onclick=\"deleteCategory(" . $category->id . ", '" . htmlspecialchars(addslashes($category->category)) . "')\" class='badge badge-danger border-0'>Hapus</button>";
                return $button;
            })
            ->rawColumns(['action']) 
            ->addIndexColumn()
            ->make(true);
    }

    public function targetAction(){
        return view("administrator.dashboard.category_transaction", ["script_tambah_kategori"=>true]);
    }

    public function addCategory(Request $request){

        $data = Validator::make($request->all(), [
            "category"=>"required",
            "amount_target"=>"required"
        ]);

        if($data->fails()){
            return response()->json(["error_form"=>$data->errors()], 422);
        }

        $valid_data = $data->validated();

        $valid_data["amount_target"] = preg_replace('/[^0-9]/', '', $valid_data["amount_target"]);

        $valid_data["amount_kini"] = 0;

        $cek_category = M_CategoryTransactions::where("category", $valid_data["category"]);

        if($cek_category->count() >= 1){
            return response()->json([
                "message" => "duplicate_category"
            ], 422);
        }

        $addCategory = M_CategoryTransactions::create($valid_data);

        if($addCategory){
            return response()->json([
                "status"=>"success"
            ]);
        }else{
            return response()->json([
                "status"=>"error_category"
            ]);
        }

    }

    public function deleteCategory(Request $request){
        //
        if(M_CategoryTransactions::where("id", $request->id)->delete()){
            return response()->json(["status"=>"success"]);
        }else{
            return response()->json(["status"=>"error"]);
        }

    }

    public function users(){
        $view_user = User::all();
        return view("administrator.dashboard.users", ["view_user" => $view_user]);
    }

    public function hapus_user($id){
        $check_user = User::where("id", $id)->count();
        $count_user = User::count();
        if($check_user === 1 && $count_user > 1){
            $delete_user = User::where("id", $id)->delete();
            if($delete_user){
                Alert::success("Berhasil!", "Berhasil delete user!");
                return redirect("/dashboard/users");
            }else{
                Alert::error("Gagal!", "Hubungi administrator!");
                return redirect("/dashboard/users");
            }
        }else{ 
            Alert::error("Gagal!", "User terbatas / id user tidak cocok!");
            return redirect("/dashboard/users/");
        }
    }

    public function tambah_user(Request $req){
        $validate = Validator::make($req->all(), [
            "name" => "required|min:5",
            "email" => "email|required",
            "password" =>"required|min:5"
        ]);
        $valid_data = $validate->validated();
        $check_user = User::where("email", $valid_data["email"])->count();
        if($check_user < 1){
            $tambah_user = User::create([
                'name' => $valid_data['name'],
                'email' => $valid_data['email'],
                'password' => Hash::make($valid_data['password'])
            ]);
            if($tambah_user){
                Alert::success("Berhasil", "Berhasil tambah user!");
                return redirect("dashboard/users");
            }else{
                Alert::error("Gagal", "Hubungi administrator!");
                return redirect("dashboard/users");
            }
        }else{
            Alert::error("Gagal", "Email tidak boleh sama!");
            return redirect("dashboard/users");
        }
    }

    public function logout(Request $req): \Illuminate\Http\RedirectResponse{
        Auth::logout();
 
        $req->session()->invalidate();
     
        $req->session()->regenerateToken();
     
        return redirect('/');
    }

}


