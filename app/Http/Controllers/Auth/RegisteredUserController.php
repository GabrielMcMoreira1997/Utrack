<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class RegisteredUserController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        try {
            try {

                $request->merge([
                    'card_number' => preg_replace('/\D/', '', $request->card_number), // só números
                    'exp_date' => preg_replace('/\D/', '', $request->exp_date),    // vira MMYY
                    'cvc' => preg_replace('/\D/', '', $request->cvc),
                ]);

                $validated = $request->validate([
                    'company_name' => 'required|string|max:255',

                    'user_name' => 'required|string|max:255',
                    'user_email' => 'required|string|email|max:255',
                    'user_password' => 'required|min:6',

                    'card_number' => 'nullable|digits:16',
                    'exp_date' => 'nullable|digits:4', // 0729
                    'cvc' => 'nullable|digits_between:3,4',
                    'card_name' => 'nullable|string|max:255',
                ]);

            } catch (ValidationException $e) {
                return redirect()->back()->with('error', 'Erro ao cadastrar: ' . $e->getMessage());
            }


            /*********************************** 
             * TO DO - Integração com gateway de pagamento
             * 
             * 1. Criar uma conta de teste no Stripe
             * 2. Implementar a lógica de criação de checkout
             * 3. Tratar as respostas de sucesso e erro
             * 4. Salvar os dados do pagamento no banco
             * *******************************************/

            $company = Company::create([
                'name' => $request->company_name,
                'slug' => \Str::slug($request->company_name),
                'domain' => null, // opcional
            ]);

            $adminRole = Role::create([
                'company_id' => $company->id,
                'name' => 'Administrador',
                'slug' => 'admin',
            ]);

            $user = User::create([
                'name' => $request->user_name,
                'email' => $request->user_email,
                'password' => Hash::make($request->user_password),
                'company_id' => $company->id,
                'role_id' => $adminRole->id,
            ]);

            // event(new Registered($user));

            // Redireciona para login, assim evita de logar um usuário que não efetuou pagamento
            return redirect()->route('login')->with('success', 'Cadastro concluído!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao cadastrar: ' . $e->getMessage());
        }
    }

}
